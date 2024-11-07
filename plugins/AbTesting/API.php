<?php

/**
 * Copyright (C) InnoCraft Ltd - All rights reserved.
 *
 * NOTICE:  All information contained herein is, and remains the property of InnoCraft Ltd.
 * The intellectual and technical concepts contained herein are protected by trade secret or copyright law.
 * Redistribution of this information or reproduction of this material is strictly forbidden
 * unless prior written permission is obtained from InnoCraft Ltd.
 *
 * You shall use this code only in accordance with the license agreement obtained from InnoCraft Ltd.
 *
 * @link https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */

namespace Piwik\Plugins\AbTesting;

use Exception;
use Piwik\API\Request;
use Piwik\Archive;
use Piwik\Common;
use Piwik\Config;
use Piwik\Container\StaticContainer;
use Piwik\DataTable;
use Piwik\Date;
use Piwik\Filesystem;
use Piwik\Period;
use Piwik\Period\Factory;
use Piwik\Piwik;
use Piwik\Plugin;
use Piwik\Plugins\AbTesting\Columns\Metrics\AverageMoney;
use Piwik\Plugins\AbTesting\Columns\Metrics\AverageValue;
use Piwik\Plugins\AbTesting\Columns\Metrics\AverageVisitLength;
use Piwik\Plugins\AbTesting\Columns\Metrics\BounceRate;
use Piwik\Plugins\AbTesting\Columns\Metrics\ConversionRate;
use Piwik\Plugins\AbTesting\Columns\Metrics\DetectedEffect;
use Piwik\Plugins\AbTesting\Columns\Metrics\RemainingVisitors;
use Piwik\Plugins\AbTesting\Columns\Metrics\SignificanceRate;
use Piwik\Plugins\AbTesting\Columns\Metrics\TotalMoney;
use Piwik\Plugins\AbTesting\Input\AccessValidator;
use Piwik\Plugins\AbTesting\Input\SuccessMetricInExperiment;
use Piwik\Plugins\AbTesting\Model\Experiments;
use Piwik\Plugins\AbTesting\RecordBuilders\BucketUniqueVisitors;
use Piwik\Plugins\AbTesting\Stats\Strategy;
use Piwik\Plugins\AbTesting\Tracker\RequestProcessor;
use Piwik\Plugins\AbTesting\Tracker\Target;
use Piwik\Site;
use Piwik\View;

/**
 * @method static API getInstance()
 */
class API extends \Piwik\Plugin\API
{
    /**
     * @var Experiments
     */
    private $experimentsModel;

    /**
     * @var Metrics
     */
    private $metrics;

    /**
     * @var Strategy
     */
    private $stats;

    /**
     * @var AccessValidator
     */
    private $access;

    private $forcedRangeArchiving = false;

    /**
     * @var Archive\ArchiveInvalidator
     */
    private $archiveInvalidator;

    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(
        Experiments $experiments,
        Metrics $metrics,
        Strategy $strategy,
        AccessValidator $accessValidator,
        Archive\ArchiveInvalidator $archiveInvalidator,
        Configuration $configuration
    ) {
        $this->experimentsModel = $experiments;
        $this->metrics = $metrics;
        $this->stats = $strategy;
        $this->access = $accessValidator;
        $this->archiveInvalidator = $archiveInvalidator;
        $this->configuration = $configuration;
    }

    private function checkSiteExists($idSite)
    {
        new Site($idSite);
    }

    private function enableRangeArchivingIfNeeded($period)
    {
        if ($period != 'range') {
            return;
        }

        $config = Config::getInstance();
        $general = $config->General;

        // range archives are required for A/B Testing to work

        if (empty($general['archiving_range_force_on_browser_request'])) {
            $general['archiving_range_force_on_browser_request'] = 1;
            $config->General = $general;
            $this->forcedRangeArchiving = true;
        }
    }

    private function disableRangeArchivingIfNeeded()
    {
        if ($this->forcedRangeArchiving) {
            $config = Config::getInstance();
            $general = $config->General;
            $general['archiving_range_force_on_browser_request'] = 0;
            $config->General = $general;
            $this->forcedRangeArchiving = false;
        }
    }

    /**
     * Get an overview of all metrics per variation. It lists for each variation the value of each selected success
     * metrics plus some base metrics like the number of visits and unique visitors the experiment had.
     *
     * @param int $idSite
     * @param string $period
     * @param string $date
     * @param int $idExperiment
     * @param bool|string $segment
     * @return DataTable
     * @throws Exception
     */
    public function getMetricsOverview($idSite, $period, $date, $idExperiment, $segment = false)
    {
        $this->access->checkReportViewPermission($idSite);

        $this->checkSiteExists($idSite);

        $this->experimentsModel->checkExperimentExists($idExperiment, $idSite);
        $experiment = $this->experimentsModel->getExperiment($idExperiment, $idSite);

        $recordName = Archiver::getExperimentRecordName($idExperiment);

        $table = $this->getDataTable($recordName, $idSite, $period, $date, $segment);

        if ($table instanceof DataTable\Map) {
            $this->addEstimatedUniqueRecordsToDataTableMap($table, $experiment, $idSite, $period, $date, $segment);
        } else {
            $this->addEstimatedUniqueRecordsToDataTable($table, $experiment, $idSite, $period, $date, $segment);
        }

        // If the requested period covers the full test period we use the aggregated unqiue metrics
        if ($this->coversFullTestPeriod($experiment, $period, $date)) {
            $table->filter(function ($table) {
                $firstRow = $table->getFirstRow();
                if ($firstRow && $firstRow->hasColumn(Metrics::METRIC_UNIQUE_VISITORS_AGGREGATED)) {
                    $table->deleteColumn(Metrics::METRIC_UNIQUE_VISITORS);
                    $table->renameColumn(Metrics::METRIC_UNIQUE_VISITORS_AGGREGATED, Metrics::METRIC_UNIQUE_VISITORS);
                }
                if ($firstRow && $firstRow->hasColumn(Metrics::METRIC_UNIQUE_VISITORS_ENTERED_AGGREGATED)) {
                    $table->deleteColumn(Metrics::METRIC_UNIQUE_VISITORS_ENTERED);
                    $table->renameColumn(Metrics::METRIC_UNIQUE_VISITORS_ENTERED_AGGREGATED, Metrics::METRIC_UNIQUE_VISITORS_ENTERED);
                }
            });
        }

        $table->filter('Piwik\Plugins\AbTesting\DataTable\Filter\RenameLabelToVariationName', array($experiment['variations']));
        $table->filter('Piwik\Plugins\AbTesting\DataTable\Filter\Sort');
        $table->filter('Piwik\Plugins\AbTesting\DataTable\Filter\AddSegmentValue', array($experiment['name']));

        // The unique visitors metric is only available for day metrics or when requesting the full test period
        $hasUniqueMetrics = true;
        if ($period !== 'day' && !$this->coversFullTestPeriod($experiment, $period, $date)) {
            $hasUniqueMetrics = false;
        }

        $metricsToShow = $this->metrics->getMetricOverviewNames($experiment['success_metrics'], $hasUniqueMetrics, AbTesting::shouldEnableUniqueVisitorMetricForcefully($experiment));
        $translations = $this->metrics->getMetricOverviewTranslations($idSite);

        foreach ($metricsToShow as $metric) {
            if (strpos($metric, Metrics::METRIC_AVERAGE_PREFIX) === 0) {
                if (Metrics::isRevenueMetric($metric)) {
                    $title = $metric;
                    if (isset($translations[$metric])) {
                        $title = $translations[$metric];
                    }
                    $this->addProcessedMetric($table, new AverageMoney($metric, $title));
                } elseif ($metric === Metrics::METRIC_AVERAGE_PREFIX . Metrics::METRIC_SUM_VISIT_LENGTH) {
                    $this->addProcessedMetric($table, new AverageVisitLength());
                } else {
                    $title = $metric;
                    if (isset($translations[$metric])) {
                        $title = $translations[$metric];
                    }
                    $this->addProcessedMetric($table, new AverageValue($metric, $title));
                }
            } elseif ($metric === BounceRate::METRIC_NAME) {
                $this->addProcessedMetric($table, new BounceRate());
            }
        }

        $table->queueFilter('ColumnDelete', array(array(), $metricsToShow));

        return $table;
    }

    protected function coversFullTestPeriod($experiment, $period, $date)
    {
        // No point trying to continue since we don't know unless there's a start date
        if (empty($experiment['start_date'])) {
            return false;
        }

        try {
            $timezone = Site::getTimezoneFor($experiment['idsite']);
            $startDate = Date::factory($experiment['start_date'], $timezone)->setTime('00:00:00');
            $endDate   = $experiment['end_date'] ? Date::factory($experiment['end_date'], $timezone)->setTime('00:00:00') : Date::today();

            if (Period::isMultiplePeriod($date, $period)) {
                return false;
            }

            $period = Factory::build($period, $date);

            // check that start date is within requested period
            if ($period->getDateStart()->toString() !== $startDate->toString() && $period->getDateStart()->isLater($startDate)) {
                return false;
            }

            // check that end date is within the requested period
            if ($period->getDateEnd()->toString() !== $endDate->toString() && $period->getDateEnd()->isEarlier($endDate)) {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get details, such as remaining visitors, statistical significance, etc for a specific success metric.
     *
     * @param int    $idSite
     * @param string $period
     * @param string $date
     * @param int    $idExperiment
     * @param string $successMetric   The given success metric must be "assigned" / "selected" for this experiment.
     *                                A list of overall available success metrics can be fetched via
     *                                "AbTesting.getAvailableSuccessMetrics". To see which success metrics are assigned
     *                                to the given experiment call "AbTesting.getExperiment".
     * @param bool|string $segment
     * @return DataTable
     */
    public function getMetricDetails($idSite, $period, $date, $idExperiment, $successMetric, $segment = false)
    {
        $this->access->checkReportViewPermission($idSite);

        $this->checkSiteExists($idSite);

        $this->experimentsModel->checkExperimentExists($idExperiment, $idSite);
        $experiment = $this->experimentsModel->getExperiment($idExperiment, $idSite);

        $successMetricInExperiment = new SuccessMetricInExperiment($experiment['success_metrics'], $successMetric);
        $successMetricInExperiment->check();

        $recordName = Archiver::getExperimentRecordName($idExperiment);

        $table = $this->getDataTable($recordName, $idSite, $period, $date, $segment);

        if ($table instanceof DataTable\Map) {
            $this->addEstimatedUniqueRecordsToDataTableMap($table, $experiment, $idSite, $period, $date, $segment);
        } else {
            $this->addEstimatedUniqueRecordsToDataTable($table, $experiment, $idSite, $period, $date, $segment);
        }

        // If the requested period covers the full test period we use the aggregated unique metrics
        if ($this->coversFullTestPeriod($experiment, $period, $date)) {
            $table->filter(function ($table) {
                $firstRow = $table->getFirstRow();
                if ($firstRow && $firstRow->hasColumn(Metrics::METRIC_UNIQUE_VISITORS_AGGREGATED)) {
                    $table->deleteColumn(Metrics::METRIC_UNIQUE_VISITORS);
                    $table->renameColumn(Metrics::METRIC_UNIQUE_VISITORS_AGGREGATED, Metrics::METRIC_UNIQUE_VISITORS);
                }
                if ($firstRow && $firstRow->hasColumn(Metrics::METRIC_UNIQUE_VISITORS_ENTERED_AGGREGATED)) {
                    $table->deleteColumn(Metrics::METRIC_UNIQUE_VISITORS_ENTERED);
                    $table->renameColumn(Metrics::METRIC_UNIQUE_VISITORS_ENTERED_AGGREGATED, Metrics::METRIC_UNIQUE_VISITORS_ENTERED);
                }
            });
        }

        $table->queueFilter('Piwik\Plugins\AbTesting\DataTable\Filter\RenameLabelToVariationName', array($experiment['variations']));
        $table->queueFilter('Piwik\Plugins\AbTesting\DataTable\Filter\Sort');
        $table->filter('Piwik\Plugins\AbTesting\DataTable\Filter\AddValuesOfOriginalToRows', array($successMetric));

        $this->addProcessedMetric($table, new DetectedEffect($successMetric));

        // The unique visitors metric is only available for day metrics or when requesting the full test period
        $hasUniqueMetrics = true;
        if ($period !== 'day' && !$this->coversFullTestPeriod($experiment, $period, $date)) {
            $hasUniqueMetrics = false;
        }

        $metricsToShow = $this->metrics->getMetricDetailNames($successMetric, $hasUniqueMetrics, AbTesting::shouldEnableUniqueVisitorMetricForcefully($experiment));
        $translations = $this->metrics->getMetricDetailTranslations($idSite, $successMetric);

        if (Metrics::isConversionMetric($successMetric)) {
            $this->addProcessedMetric($table, new ConversionRate($successMetric));
        } elseif ($successMetric === Metrics::METRIC_SUM_VISIT_LENGTH) {
            $this->addProcessedMetric($table, new AverageVisitLength());
        } elseif ($successMetric === Metrics::METRIC_PAGEVIEWS) {
            $this->addProcessedMetric($table, new AverageValue(Metrics::METRIC_AVERAGE_PREFIX . $successMetric, $translations[$successMetric]));
        } elseif ($successMetric === Metrics::METRIC_BOUNCE_COUNT) {
            $this->addProcessedMetric($table, new BounceRate());
        } elseif (Metrics::isRevenueMetric($successMetric)) {
            $this->addProcessedMetric($table, new TotalMoney($successMetric, $translations[$successMetric]));
            $this->addProcessedMetric($table, new AverageMoney(Metrics::METRIC_AVERAGE_PREFIX . $successMetric, $translations[$successMetric]));
        }

        $this->addProcessedMetric($table, new RemainingVisitors($this->stats, $experiment, $successMetric));

        $significance = new SignificanceRate($this->stats, $experiment, $successMetric);
        $optionalRecordName = $significance->getRecordNameIfNeedsDataTable();

        if ($optionalRecordName) {
            if (Period::isMultiplePeriod($date, $period)) {
                $table2Period = 'range';
            } else {
                $table2Period = $period;
            }
            $table2 = $this->getDataTableOnly($optionalRecordName, $idSite, $table2Period, $date, $segment);
            $significance->setDataTableWithSamples($table2);
        }

        $this->addProcessedMetric($table, $significance);

        $table->queueFilter('ColumnDelete', array(array(), $metricsToShow));
        $table->queueFilter('Piwik\Plugins\AbTesting\DataTable\Filter\AddSegmentValue', array($experiment['name']));

        return $table;
    }

    /**
     * @param $recordName
     * @param $idSite
     * @param $period
     * @param $date
     * @param $segment
     * @param $experiment
     * @return DataTable
     */
    private function getDataTable($recordName, $idSite, $period, $date, $segment)
    {
        $table = $this->getDataTableOnly($recordName, $idSite, $period, $date, $segment);
        $table->filter('Piwik\Plugins\AbTesting\DataTable\Filter\AddOriginalRowIfNeeded');
        $table->deleteColumn('aggregationTime');

        return $table;
    }

    private function getDataTableOnly($recordName, $idSite, $period, $date, $segment)
    {
        $this->enableRangeArchivingIfNeeded($period);

        $archive = Archive::build($idSite, $period, $date, $segment);
        $table = $archive->getDataTable($recordName);

        $this->disableRangeArchivingIfNeeded();

        return $table;
    }

    /**
     * Creates a new experiment. We will require all minimal needed data in order to create the experiment so it will
     * be directly possible to start the experiment afterwards.
     *
     * @param int $idSite
     * @param string $name
     * @param string $hypothesis
     * @param string $description
     * @param array $variations     eg array(array('name' => 'variation1'), array('name' => 'variation2', ', 'percentage' => '30', 'redirect_url' => 'https://www.innocraft.com'))
     *                              While name is mandatory, percentage is optional and if given has to be a numer between 1 and 100.
     *                              Optionally a 'redirect_url' can be passed to indicate that this variation should redirect a user to another page.
     *                              Requires at least one variation to be given.
     * @param array $includedTargets eg array(array('attribute' => 'url', 'type' => 'equals_simple', 'inverted' => 0, 'value' => 'http://example.com/directory'))
     *                               For a list of available attribute and type values call "AbTesting.getAvailableTargetAttributes".
     *                               "inverted" should be "0" or "1".
     *                               Requires at least one included target to be given.
     * @param array $successMetrics  eg array(array('metric' => 'nb_pageviews'), array('metric' => 'bounce_count')).
     *                               For a list of available metrics call "AbTesting.getAvailableSuccessMetrics".
     *                               Requires at least one success metric to be given.
     * @return int  The ID of the created experiment.
     * @throws Exception
     */
    public function addExperiment($idSite, $name, $hypothesis, $description, $variations, $includedTargets, $successMetrics)
    {
        $this->access->checkWritePermission($idSite);

        $this->checkSiteExists($idSite); // lets not a super user create sites that do not exist yet

        $variations = $this->unsanitizeFieldInArray($variations, 'redirect_url');
        $includedTargets = $this->unsanitizeTargets($includedTargets);

        $confidenceThreshold = 95;

        return $this->experimentsModel->createExperiment($idSite, $name, $description, $hypothesis, $variations, $includedTargets, $successMetrics, $confidenceThreshold);
    }

    private function unsanitizeTargets($targets)
    {
        if (!empty($targets) && is_array($targets)) {
            foreach ($targets as $index => $rule) {
                if (!empty($rule['value']) && is_string($rule['value'])) {
                    $targets[$index]['value'] = Common::unsanitizeInputValue($rule['value']);
                }
            }
        }

        return $targets;
    }

    /**
     * Updates the experiment. All fields need to be set in order to update an experiment. Easiest way is to get all
     * values for an experiment via "AbTesting.getExperiment", make the needed changes on the experiment, and send the
     * values to "AbTesting.updateExperiment".
     *
     * @param int $idExperiment
     * @param int $idSite
     * @param string $name
     * @param string $description
     * @param string $hypothesis
     * @param array $variations eg array(array('name' => 'variation1'), array('name' => 'variation2', ', 'percentage' => '30', 'redirect_url' => 'https://www.innocraft.com')
     *                          While name is mandatory, percentage is optional and if given has to be a numer between 1 and 100.
     *                          Optionally a 'redirect_url' can be passed to indicate that this variation should redirect a user to another page.
     *                          Requires at least one variation to be given.
     * @param int $confidenceThreshold accepts a value values: 90, 95, 98, 99 and  99.5
     * @param int $mdeRelative a number >= 1 and <= 1000
     * @param int $percentageParticipants a number between 0 and 100
     * @param array $successMetrics  eg array(array('metric' => 'nb_pageviews'), array('metric' => 'bounce_count')).
     *                               For a list of available metrics call "AbTesting.getAvailableSuccessMetrics".
     *                               Requires at least one success metric to be given.
     * @param array $includedTargets eg array(array('attribute' => 'url', 'type' => 'equals_simple', 'inverted' => 0, 'value' => 'http://example.com/directory'))
     *                               For a list of available attribute and type values call "AbTesting.getAvailableTargetAttributes".
     *                               "inverted" should be "0" or "1".
     *                               Requires at least one included target to be given.
     * @param array $excludedTargets Same format as $includedTargets. Can be an empty array.
     * @param string $startDate  Optional date in UTC eg '2014-10-29 01:02:03'
     * @param string $endDate   Optional date in UTC '2014-10-29 01:02:03'
     * @param bool $forwardUtmParams Indicates whether redirects should forward any utm* parameters
     * @throws Exception
     */
    public function updateExperiment(
        $idExperiment,
        $idSite,
        $name,
        $description,
        $hypothesis,
        $variations,
        $confidenceThreshold,
        $mdeRelative,
        $percentageParticipants,
        $successMetrics,
        $includedTargets,
        $excludedTargets = array(),
        $startDate = false,
        $endDate = false,
        $forwardUtmParams = false
    ) {
        $this->access->checkWritePermission($idSite);

        $this->checkSiteExists($idSite); // lets not a super user update experiments for site that does not exist anymore

        $variations = $this->unsanitizeFieldInArray($variations, 'redirect_url');
        $includedTargets = $this->unsanitizeTargets($includedTargets);
        $excludedTargets = $this->unsanitizeTargets($excludedTargets);

        $experiment = $this->experimentsModel->checkExperimentCanBeUpdated($idExperiment, $idSite);
        $this->experimentsModel->updateExperiment(
            $idExperiment,
            $idSite,
            $name,
            $description,
            $hypothesis,
            $variations,
            $confidenceThreshold,
            $mdeRelative,
            $percentageParticipants,
            $includedTargets,
            $excludedTargets,
            $successMetrics,
            $startDate,
            $endDate,
            $forwardUtmParams
        );

        // invalidate cache used in redirect.php
        $tmp = StaticContainer::get('path.cache');
        $files = Filesystem::globr($tmp, 'abtesting_*.php');
        if (!empty($files) && is_array($files)) {
            foreach ($files as $file) {
                Filesystem::deleteFileIfExists($file);
            }
        }

        if (!empty($experiment['start_date'])) {
            try {
                $startDate = Date::factory($experiment['start_date']);
            } catch (\Exception $ex) {
                // empty
            }

            if (!empty($startDate)) {
                $this->archiveInvalidator->reArchiveReport([$idSite], 'AbTesting', Archiver::getExperimentRecordName($idExperiment), $startDate);
                if ($this->configuration->isEstimatedUniqueVisitorArchivingEnabled()) {
                    $this->archiveInvalidator->reArchiveReport([$idSite], 'AbTesting', Archiver::getExperimentEstimatedUniqueVisitorBucketRecordName($idExperiment), $startDate);
                    $this->archiveInvalidator->reArchiveReport([$idSite], 'AbTesting', Archiver::getExperimentEstimatedUniqueVisitorEnteredBucketRecordName($idExperiment), $startDate);
                }
            }
        }
    }

    private function unsanitizeFieldInArray($array, $field)
    {
        if (!empty($array) && is_array($array)) {
            foreach ($array as &$entry) {
                if (!empty($entry[$field])) {
                    $entry[$field] = Common::unsanitizeInputValue($entry[$field]);
                }
            }
        }

        return $array;
    }

    /**
     * Starts an experiment immediately. Usually not needed to call this method as by default an experiment will be
     * started as soon as we notice the first tracking request for this experiment unless the experiment has a scheduled
     * start date.
     *
     * @param int $idExperiment
     * @param int $idSite
     * @throws Exception
     */
    public function startExperiment($idExperiment, $idSite)
    {
        $this->access->checkWritePermission($idSite);

        $this->experimentsModel->checkExperimentCanBeUpdated($idExperiment, $idSite);
        $this->experimentsModel->startExperiment($idExperiment, $idSite);
    }

    /**
     * Finishes (stops) the given experiment. Only a created or running experiment can be finished. The experiment
     * will be finished immediately and no tracking requests for such an experiment will be accepted anymore. Make sure
     * to remove an embedded JavaScript code from your website once it has been finished.
     *
     * @param int $idExperiment
     * @param int $idSite
     * @return array
     * @throws Exception
     */
    public function finishExperiment($idExperiment, $idSite)
    {
        $this->access->checkWritePermission($idSite);

        $this->experimentsModel->checkExperimentCanBeUpdated($idExperiment, $idSite);
        $this->experimentsModel->finishExperiment($idExperiment, $idSite);
    }

    /**
     * Archives the given experiment. Once an experiment has been archived, it won't be available in reports and
     * segments anymore. It will be also not possible anymore to update this experiment.
     *
     * @param $idExperiment
     * @param int $idSite
     * @return array
     * @throws Exception
     */
    public function archiveExperiment($idExperiment, $idSite)
    {
        $this->access->checkWritePermission($idSite);

        $this->experimentsModel->checkExperimentCanBeUpdated($idExperiment, $idSite);
        $this->experimentsModel->setStatus($idExperiment, $idSite, Experiments::STATUS_ARCHIVED);
    }

    /**
     * Get the HTML code to embed the A/B Test JavaScript tracking file. Returns eg "<script src="..."></script>".
     * The method might return an empty string if the tracker file is loaded automatically via the piwik.js file to
     * prevent loading the A/B test client twice.
     *
     * Will automatically update the query parameters of the JavaScript file to make sure the latest version of this
     * file will be loaded. If
     *
     * @return string
     */
    public function getJsIncludeTemplate()
    {
        $this->access->checkHasSomeWritePermission();

        if (Plugin\Manager::getInstance()->isPluginActivated('CustomJsTracker')) {
            $includeAutomatically = Request::processRequest('CustomJsTracker.doesIncludePluginTrackersAutomatically');
            if ($includeAutomatically) {
                return '';
            }
        }

        $view = new View('@AbTesting/jsIncludeTemplate');
        return $view->render();
    }

    /**
     * Gets the JavaScript embed code to run an experiment. Will return an empty string and remove the experiment
     * from the site automatically as soon as it has been finished or archived
     *
     * @param int $idExperiment
     * @param int $idSite
     * @return string
     * @throws Exception
     */
    public function getJsExperimentTemplate($idExperiment, $idSite)
    {
        $this->access->checkWritePermission($idSite);

        $this->experimentsModel->checkExperimentExists($idExperiment, $idSite);
        $experiment = $this->experimentsModel->getExperiment($idExperiment, $idSite);

        if (
            $experiment['status'] === Experiments::STATUS_FINISHED
            || $experiment['status'] === Experiments::STATUS_ARCHIVED
        ) {
            // the experiment is finished or archived, we should no longer execute it
            return '';
        }

        $view = new View('@AbTesting/jsExperimentTemplate');
        $view->experiment = $experiment;
        $view->originalVariationName = RequestProcessor::VARIATION_NAME_ORIGINAL;
        $view->jsVarName = lcfirst(trim($experiment['name']));
        return $view->render();
    }

    /**
     * Get a list of all experiments for given site.
     *
     * @param int $idSite
     * @return array
     */
    public function getAllExperiments($idSite)
    {
        $this->access->checkWritePermission($idSite);

        return $this->experimentsModel->getAllExperimentsForSite($idSite);
    }

    /**
     * Get a list of active experiments.
     *
     * @param int $idSite
     * @return array
     */
    public function getActiveExperiments($idSite)
    {
        $this->access->checkWritePermission($idSite);

        return $this->experimentsModel->getActiveExperiments($idSite);
    }

    /**
     * Get a list of experiments by status. To get a list of available statuses call "AbTesting.getAvailableStatuses".
     *
     * @param int $idSite
     * @param string|array $statuses
     * @return array
     * @throws Exception If no status given.
     */
    public function getExperimentsByStatuses($idSite, $statuses)
    {
        $this->access->checkWritePermission($idSite);

        if (empty($statuses)) {
            throw new Exception(Piwik::translate('AbTesting_ErrorXNotProvided', 'status'));
        }

        return $this->experimentsModel->getExperimentsByStatuses($idSite, $statuses);
    }

    /**
     * Get a specific experiment.
     *
     * @param int $idExperiment
     * @param int $idSite
     * @return array|false
     */
    public function getExperiment($idExperiment, $idSite)
    {
        $this->access->checkReportViewPermission($idSite);

        return $this->experimentsModel->getExperiment($idExperiment, $idSite);
    }

    /**
     * Deletes the given experiment. It won't be possible to undo this. There's also the possibility to archive
     * an experiment via "Experiment.archiveExperiment"
     *
     * @param int $idExperiment
     * @param int $idSite
     * @return array
     */
    public function deleteExperiment($idExperiment, $idSite)
    {
        $this->access->checkWritePermission($idSite);

        $this->experimentsModel->deleteExperiment($idExperiment, $idSite);

        $this->archiveInvalidator->removeInvalidationsSafely([$idSite], 'AbTesting', Archiver::getExperimentRecordName($idExperiment));
        if ($this->configuration->isEstimatedUniqueVisitorArchivingEnabled()) {
            $this->archiveInvalidator->removeInvalidationsSafely([$idSite], 'AbTesting', Archiver::getExperimentEstimatedUniqueVisitorBucketRecordName($idExperiment));
            $this->archiveInvalidator->removeInvalidationsSafely([$idSite], 'AbTesting', Archiver::getExperimentEstimatedUniqueVisitorEnteredBucketRecordName($idExperiment));
        }
    }

    /**
     * Get a list of valid experiment statuses (eg "running", "finished", ...)
     *
     * @param int $idSite
     * @return array
     */
    public function getAvailableStatuses($idSite)
    {
        $this->access->checkWritePermission($idSite);

        return $this->experimentsModel->getValidStatuses();
    }

    /**
     * Get a list of all available success metrics.
     *
     * @param int $idSite
     * @return array
     */
    public function getAvailableSuccessMetrics($idSite)
    {
        $this->access->checkWritePermission($idSite);

        return $this->metrics->getSuccessMetrics($idSite);
    }

    /**
     * Get a list of all available target attributes and target types for "includedTargets" and "excludedTargets".
     * @return array
     */
    public function getAvailableTargetAttributes()
    {
        $this->access->checkHasSomeWritePermission();

        return Target::getAvailableTargetTypes();
    }

    /**
     * @param $idSite
     * @return array
     * @throws Exception
     * @hide
     */
    public function getExperimentsWithReports($idSite)
    {
        $this->access->checkReportViewPermission($idSite);

        return $this->experimentsModel->getExperimentsWithReports($idSite);
    }

    private function addProcessedMetric(DataTable\DataTableInterface $table, $metric)
    {
        $table->filter(function (DataTable $table) use ($metric) {
            $processedMetrics = $table->getMetadata(DataTable::EXTRA_PROCESSED_METRICS_METADATA_NAME);

            if (empty($processedMetrics)) {
                $processedMetrics = array();
            }

            $processedMetrics[] = $metric;

            $table->setMetadata(DataTable::EXTRA_PROCESSED_METRICS_METADATA_NAME, $processedMetrics);
        });
    }

    private function addEstimatedUniqueRecordsToDataTable($table, $experiment, $idSite, $period, $date, $segment)
    {
        if (!$this->configuration->shouldShowEstimatedUniqueVisitors()) {
            return;
        }

        $estimatedUniqueVisitorsData = [];

        $estimatedUniqueVisitorBucketRecordName = Archiver::getExperimentEstimatedUniqueVisitorBucketRecordName($experiment['idexperiment']);
        $estimatedUniqueVisitorBucketRecordTable = $this->getDataTable($estimatedUniqueVisitorBucketRecordName, $idSite, $period, $date, $segment);
        BucketUniqueVisitors::setEstimatedUniqueVisitors($estimatedUniqueVisitorBucketRecordTable->getRows(), Metrics::METRIC_ESTIMATED_UNIQUE_VISITORS_AGGREGATED, $estimatedUniqueVisitorsData);

        $estimatedUniqueVisitorEnteredBucketRecordName = Archiver::getExperimentEstimatedUniqueVisitorEnteredBucketRecordName($experiment['idexperiment']);
        $estimatedUniqueVisitorEnteredBucketRecordTable = $this->getDataTable($estimatedUniqueVisitorEnteredBucketRecordName, $idSite, $period, $date, $segment);
        BucketUniqueVisitors::setEstimatedUniqueVisitors($estimatedUniqueVisitorEnteredBucketRecordTable->getRows(), Metrics::METRIC_ESTIMATED_UNIQUE_VISITORS_ENTERED_AGGREGATED, $estimatedUniqueVisitorsData);

        $this->addEstimatedValuesToTable($table, $estimatedUniqueVisitorsData);
    }

    private function addEstimatedUniqueRecordsToDataTableMap($table, $experiment, $idSite, $period, $date, $segment)
    {
        if (!$this->configuration->shouldShowEstimatedUniqueVisitors()) {
            return;
        }

        $estimatedUniqueVisitorBucketRecordName = Archiver::getExperimentEstimatedUniqueVisitorBucketRecordName($experiment['idexperiment']);
        $estimatedUniqueVisitorBucketRecordTableMap = $this->getDataTable($estimatedUniqueVisitorBucketRecordName, $idSite, $period, $date, $segment);

        $estimatedUniqueVisitorEnteredBucketRecordName = Archiver::getExperimentEstimatedUniqueVisitorEnteredBucketRecordName($experiment['idexperiment']);
        $estimatedUniqueVisitorEnteredBucketRecordTableMap = $this->getDataTable($estimatedUniqueVisitorEnteredBucketRecordName, $idSite, $period, $date, $segment);

        foreach ($estimatedUniqueVisitorBucketRecordTableMap->getDataTables() as $key => $estimatedUniqueVisitorBucketRecordTable) {
            $estimatedUniqueVisitorsData = [];
            BucketUniqueVisitors::setEstimatedUniqueVisitors($estimatedUniqueVisitorBucketRecordTable->getRows(), Metrics::METRIC_ESTIMATED_UNIQUE_VISITORS_AGGREGATED, $estimatedUniqueVisitorsData);
            $estimatedUniqueVisitorEnteredBucketRecordTable = $estimatedUniqueVisitorEnteredBucketRecordTableMap->getTable($key);
            BucketUniqueVisitors::setEstimatedUniqueVisitors($estimatedUniqueVisitorEnteredBucketRecordTable->getRows(), Metrics::METRIC_ESTIMATED_UNIQUE_VISITORS_ENTERED_AGGREGATED, $estimatedUniqueVisitorsData);

            $this->addEstimatedValuesToTable($table->getTable($key), $estimatedUniqueVisitorsData);
        }
    }

    private function addEstimatedValuesToTable($table, $estimatedUniqueVisitorsData)
    {
        if (!empty($estimatedUniqueVisitorsData)) {
            $table->filter(function ($table) use ($estimatedUniqueVisitorsData) {
                $rows = $table->getRows();
                foreach ($rows as &$row) {
                    $label = $row->getColumn('label');
                    if (!$label || $label === Archiver::LABEL_NOT_DEFINED || $label == RequestProcessor::VARIATION_ORIGINAL_ID || $label == RequestProcessor::VARIATION_NAME_ORIGINAL || $label == Piwik::translate('AbTesting_NameOriginalVariation')) {
                        $label = '0';
                    }
                    if (!empty($estimatedUniqueVisitorsData[$label])) {
                        unset($estimatedUniqueVisitorsData[$label]['label']);
                        $row->addColumns($estimatedUniqueVisitorsData[$label]);
                    }
                }
            });
        }
    }
}
