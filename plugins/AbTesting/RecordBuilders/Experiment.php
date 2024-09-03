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

namespace Piwik\Plugins\AbTesting\RecordBuilders;

use Piwik\ArchiveProcessor;
use Piwik\ArchiveProcessor\Record;
use Piwik\ArchiveProcessor\RecordBuilder;
use Piwik\Config;
use Piwik\Container\StaticContainer;
use Piwik\Period;
use Piwik\DataAccess\LogAggregator;
use Piwik\DataTable;
use Piwik\Date;
use Piwik\Plugins\AbTesting\Archiver;
use Piwik\Plugins\AbTesting\Archiver\Aggregator;
use Piwik\Plugins\AbTesting\Configuration;
use Piwik\Plugins\AbTesting\Metrics;
use Piwik\Plugins\AbTesting\Stats\Strategy;
use Piwik\Plugins\AbTesting\Tracker\RequestProcessor;
use Piwik\Tracker\GoalManager;

class Experiment extends RecordBuilder
{
    /**
     * @var array
     */
    private $experiment;

    /**
     * @var Strategy
     */
    private $strategy;

    /**
     * @var array
     */
    private $idGoals;

    /**
     * @var array
     */
    private $dayColumnAggregationOps;

    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(array $experiment, Strategy $strategy)
    {
        parent::__construct();

        $this->experiment = $experiment;

        $generalConfig = Config::getInstance()->General;

        $this->maxRowsInTable = $generalConfig['datatable_archiving_maximum_rows_standard'];
        $this->strategy = $strategy;

        $this->idGoals = $this->getIdGoalsToArchiveFromExperiment();

        $this->columnAggregationOps = $this->getMultipleReportsAggregationOperations();
        $this->dayColumnAggregationOps = ['aggregationTime' => 'max'];

        $this->configuration = StaticContainer::get(Configuration::class);
    }

    public function getRecordMetadata(ArchiveProcessor $archiveProcessor): array
    {
        $idSite = $archiveProcessor->getParams()->getSite()->getId();
        $idExperiment = $this->experiment['idexperiment'];

        $recordName = Archiver::getExperimentRecordName($idExperiment);

        $records = [
            Record::make(Record::TYPE_BLOB, $recordName),
        ];

        $revenueMetrics = $this->getRevenueMetrics();
        foreach ($revenueMetrics as $metric => $idGoal) {
            if (!$this->hasSuccessMetric($metric)) {
                continue;
            }

            $bestStrategy = $this->strategy->getBestStrategyForMetric($metric, $idExperiment, $idSite);
            if ($bestStrategy !== Strategy::MANN_WHITNEY) {
                continue;
            }

            $recordName = Archiver::getExperimentSampleRecordName($idExperiment, $metric);
            $records[] = Record::make(Record::TYPE_BLOB, $recordName);
        }

        return $records;
    }

    protected function aggregate(ArchiveProcessor $archiveProcessor): array
    {
        $aggregator = new Aggregator($archiveProcessor->getLogAggregator());

        $idSite = $archiveProcessor->getParams()->getSite()->getId();
        if (!isset($idSite)) {
            return [];
        }

        $experiment = $this->experiment;
        $idExperiment = $experiment['idexperiment'];

        // skip finished experiment archiving for days after the experiment ended
        if ($experiment['status'] === 'finished' && !empty($experiment['end_date'])) {
            $endDate = Date::factory($experiment['end_date'])->setTime('23:59:59');
            if ($archiveProcessor->getParams()->getDateStart()->isLater($endDate)) {
                return [];
            }
        }

        $records = [];

        $record = new DataTable();

        // we always archive this one as it archives visits, unique visitors
        $cursor = $aggregator->aggregateVisitMetrics($experiment);
        $this->addRowsToRecord($record, $cursor);

        // we always archive this one as it archives visits entered , unique visitors entered
        $cursor = $aggregator->aggregateBouncesAndEnteredVisits($experiment);
        $this->addRowsToRecord($record, $cursor);

        if ($this->hasSuccessMetric(Metrics::METRIC_PAGEVIEWS)) {
            $cursor = $aggregator->aggregatePageviews($experiment);
            $this->addRowsToRecord($record, $cursor);
        }

        if ($this->hasSuccessMetric(array(Metrics::METRIC_TOTAL_CONVERSIONS, Metrics::METRIC_TOTAL_REVENUE))) {
            $cursor = $aggregator->aggregateGoalConversions($experiment, $idGoal = null, Metrics::METRIC_TOTAL_CONVERSIONS, Metrics::METRIC_TOTAL_REVENUE);
            $this->addRowsToRecord($record, $cursor);
        }

        if ($this->hasSuccessMetric(array(Metrics::METRIC_TOTAL_ORDERS, Metrics::METRIC_TOTAL_ORDERS_REVENUE))) {
            $idGoal = GoalManager::IDGOAL_ORDER;
            $cursor = $aggregator->aggregateGoalConversions($experiment, $idGoal, Metrics::METRIC_TOTAL_ORDERS, Metrics::METRIC_TOTAL_ORDERS_REVENUE);
            $this->addRowsToRecord($record, $cursor);
        }

        foreach ($this->idGoals as $idGoal) {
            $conversionName = Metrics::getMetricNameConversionGoal($idGoal);
            $revenueName = Metrics::getMetricNameRevenueGoal($idGoal);

            if ($this->hasSuccessMetric([$conversionName, $revenueName])) {
                $cursor = $aggregator->aggregateGoalConversions($experiment, $idGoal, $conversionName, $revenueName);
                $this->addRowsToRecord($record, $cursor);
            }
        }

        $labels = [];
        $expectedNumRows = [];
        foreach ($record->getRowsWithoutSummaryRow() as $row) {
            $label = $row->getColumn('label');
            if ($label === Archiver::LABEL_NOT_DEFINED) {
                $label = '';
            }

            $labels[] = $label;
            $expectedNumRows[$label] = $row->getColumn(Metrics::METRIC_VISITS);
        }

        $conversionMetrics = array(
            Metrics::METRIC_TOTAL_CONVERSIONS => null,
            Metrics::METRIC_TOTAL_ORDERS => GoalManager::IDGOAL_ORDER
        );
        $revenueMetrics = $this->getRevenueMetrics();

        foreach ($this->idGoals as $idGoal) {
            $conversionMetrics[Metrics::getMetricNameConversionGoal($idGoal)] = $idGoal;
        }

        // TTEST CALCULATIONS
        foreach ($labels as $label) {
            if ($this->hasSuccessMetric(Metrics::METRIC_PAGEVIEWS)) {
                $query = $aggregator->getDistributionPageviewQuery($experiment, $label);
                $cursor = $aggregator->calcDistributionValues(Metrics::METRIC_PAGEVIEWS, $query);
                $this->addRowsToRecord($record, $cursor);
            }

            if ($this->hasSuccessMetric(Metrics::METRIC_SUM_VISIT_LENGTH)) {
                $query = $aggregator->getDistributionVisitTotalTimeQuery($experiment, $label);
                $cursor = $aggregator->calcDistributionValues(Metrics::METRIC_SUM_VISIT_LENGTH, $query);
                $this->addRowsToRecord($record, $cursor);
            }

            foreach ($revenueMetrics as $revenueMetric => $idGoal) {
                if (!$this->hasSuccessMetric($revenueMetric)) {
                    continue;
                }

                $bestStrategy = $this->strategy->getBestStrategyForMetric($revenueMetric, $idExperiment, $idSite);
                if ($bestStrategy === Strategy::TTEST) {
                    $query = $aggregator->getDistributionRevenueForTtest($experiment, $label, $idGoal);
                    $cursor = $aggregator->calcDistributionValues($revenueMetric, $query);
                    $this->addRowsToRecord($record, $cursor);
                }
            }

            foreach ($conversionMetrics as $conversionMetric => $idGoal) {
                if (!$this->hasSuccessMetric($conversionMetric)) {
                    continue;
                }
                $bestStrategy = $this->strategy->getBestStrategyForMetric($conversionMetric, $idExperiment, $idSite);
                if ($bestStrategy === Strategy::TTEST) {
                    $query = $aggregator->getDistributionConversionForTtest($experiment, $label, $idGoal);
                    $cursor = $aggregator->calcDistributionValues($conversionMetric, $query);
                    $this->addRowsToRecord($record, $cursor);
                }
            }

        }

        if (!empty($labels) && $this->configuration->isUniqueVisitorArchivingEnabled()) {
            $params = $archiveProcessor->getParams();
            $startDate = Date::factory($experiment['start_date'])->setTime('00:00:00');
            $today = Date::today();

            if (!$today->isEarlier($startDate)) {
                // when the ab test is already running also calculate the unique visitors metrics for the whole test time
                $period = Period\Factory::build('range', $startDate->toString().','.$today->toString());
                $newParams = new ArchiveProcessor\Parameters($params->getSite(), $period, $params->getSegment());
                $logAggregator = new LogAggregator($newParams);
                $periodAggregator = new Aggregator($logAggregator);

                $unique = $periodAggregator->getUniqueVisitors($experiment, $onlyEntered = false);
                foreach ($unique as $row) {
                    $record->sumRowWithLabel($this->getQueryRowLabel($row), [
                        Metrics::METRIC_UNIQUE_VISITORS_AGGREGATED => $row['uniqueVisitors'],
                        'aggregationTime' => microtime(true),
                    ], $this->dayColumnAggregationOps);
                }

                $uniqueEntered = $periodAggregator->getUniqueVisitors($experiment, $onlyEntered = true);
                foreach ($uniqueEntered as $row) {
                    $record->sumRowWithLabel($this->getQueryRowLabel($row), [
                        Metrics::METRIC_UNIQUE_VISITORS_ENTERED_AGGREGATED => $row['uniqueVisitors'],
                        'aggregationTime' => microtime(true),
                    ], $this->dayColumnAggregationOps);
                }
            }
        }

        $recordName = Archiver::getExperimentRecordName($idExperiment);
        $records[$recordName] = $record;

        // MANN WHITNEY HISTOGRAM TABLE CALCULATIONS
        foreach ($revenueMetrics as $metric => $idGoal) {
            if (!$this->hasSuccessMetric($metric)) {
                continue;
            }

            $bestStrategy = $this->strategy->getBestStrategyForMetric($metric, $idExperiment, $idSite);

            if ($bestStrategy === Strategy::MANN_WHITNEY) {
                $record = new DataTable();

                foreach ($labels as $label) {
                    $cursor = $aggregator->getDistributionRevenueForMannWhitney($experiment, $label, $idGoal);
                    $this->addVariationRowsToDataArray($label, $expectedNumRows[$label], $record, $cursor);
                }

                $recordName = Archiver::getExperimentSampleRecordName($idExperiment, $metric);
                $records[$recordName] = $record;
                unset($cursor);
            }
        }

        return $records;
    }

    protected function hasSuccessMetric($neededMetric): bool
    {
        if (!is_array($neededMetric)) {
            $neededMetric = array($neededMetric);
        }
        $experimentMetrics = $this->getSuccessMetricsFromExperiment();
        foreach ($experimentMetrics as $metricName) {

            foreach ($neededMetric as $m) {
                if ($metricName === $m) {
                    return true;
                }
            }

        }

        return false;
    }

    private function getRevenueMetrics(): array
    {
        $metrics = [
            Metrics::METRIC_TOTAL_REVENUE => null,
            Metrics::METRIC_TOTAL_ORDERS_REVENUE => GoalManager::IDGOAL_ORDER,
        ];
        foreach ($this->idGoals as $idGoal) {
            $metrics[Metrics::getMetricNameRevenueGoal($idGoal)] = $idGoal;
        }
        return $metrics;
    }

    protected function getIdGoalsToArchiveFromExperiment(): array
    {
        $idGoals = [];

        $experimentMetrics = $this->getSuccessMetricsFromExperiment();

        foreach ($experimentMetrics as $successMetric) {
            $idGoal = Metrics::getGoalIdFromMetricName($successMetric);

            if (!empty($idGoal)) {
                $idGoals[] = (int) $idGoal;
            }
        }

        return array_values(array_unique($idGoals));
    }

    protected function getSuccessMetricsFromExperiment(): array
    {
        $experiment = $this->experiment;

        $metrics = [];
        foreach ($experiment['success_metrics'] as $metric) {
            if (empty($metric['metric'])) {
                continue;
            }
            $metrics[] = $metric['metric'];
        }
        return $metrics;
    }

    private function addRowsToRecord(DataTable $record, $cursor)
    {
        $emptyRow = $this->getEmptyMetricsRow();

        while ($row = $cursor->fetch()) {
            $label = $this->getQueryRowLabel($row);
            unset($row['label']);

            $columns = $emptyRow;
            foreach ($row as $name => $value) {
                $columns[$name] = (float) $value;
            }

            $record->sumRowWithLabel($label, $columns, $this->dayColumnAggregationOps);
        }
        $cursor->closeCursor();
    }

    private function addVariationRowsToDataArray(string $label, int $totalRowsExpected, DataTable $record, $cursor): void
    {
        $label = $label ?: Archiver::LABEL_NOT_DEFINED;

        $numRows = 0;
        while ($row = $cursor->fetch()) {
            $columns = [
                (string) $row['revenue'] => $row['revenueCount'],
            ];

            $record->sumRowWithLabel($label, $columns);
            $numRows += $row['revenueCount'];
        }

        $numFurtherZeros = $totalRowsExpected - $numRows;
        if ($numFurtherZeros > 0) {
            $record->sumRowWithLabel($label, ['revenue' => 0, 'revenueCount' => $numFurtherZeros]);
        }

        $cursor->closeCursor();
    }

    private function getEmptyMetricsRow(): array
    {
        $metrics = [
            Metrics::METRIC_VISITS => 0,
            Metrics::METRIC_VISITS_ENTERED => 0,
            Metrics::METRIC_UNIQUE_VISITORS => 0,
            Metrics::METRIC_UNIQUE_VISITORS_ENTERED => 0,
            Metrics::METRIC_UNIQUE_VISITORS_AGGREGATED => 0,
            Metrics::METRIC_UNIQUE_VISITORS_ENTERED_AGGREGATED => 0,
            Metrics::METRIC_BOUNCE_COUNT => 0,
            Metrics::METRIC_SUM_VISIT_LENGTH => 0,
            Metrics::METRIC_TOTAL_CONVERSIONS => 0,
            Metrics::METRIC_TOTAL_REVENUE => 0,
            Metrics::METRIC_PAGEVIEWS => 0,
            Metrics::METRIC_TOTAL_ORDERS => 0,
            Metrics::METRIC_TOTAL_ORDERS_REVENUE => 0,
        ];

        foreach ($this->idGoals as $idGoal) {
            $metrics[Metrics::getMetricNameConversionGoal($idGoal)] = 0;
            $metrics[Metrics::getMetricNameRevenueGoal($idGoal)] = 0;
        }

        return $metrics;
    }

    public function getMultipleReportsAggregationOperations(): array
    {
        $experimentMetrics = $this->getSuccessMetricsFromExperiment();

        $allMetricsAggregate = [];

        foreach ($experimentMetrics as $metric) {
            $allMetricsAggregate[] = $metric;
        }

        $columnsAggregationOperation = [];

        $aggregate = function ($thisValue, $otherValue, $thisRow, $otherRow) {
            if (!is_array($thisValue)) {
                $thisValue = array($thisValue);
            }

            if (is_array($otherValue)) {
                foreach ($otherValue as $val) {
                    $thisValue[] = $val;
                }
            } else {
                $thisValue[] = $otherValue;
            }

            return $thisValue;
        };

        // this is bit of a hack... what may happen is that user starts an a/b test... then data is being tracked and archived
        // then user changes a/b test and eg removes "pageviews". Meaning new archives won't have this metric but older
        // existing reports still have it. However, the currently configured a/b test would not have it anymore. Then
        // under circumstances when it tries to aggregate older reports with newer ones then Matomo might try to aggregate
        // these previously archived pageviews metrics but below custom aggregate is missing because it is no longer configured
        // on the custom report. As a workaround we simply add custom aggregate functions for metrics  that might not even be
        // assigned to the report (or are assigned already). It won't work when removing specific goals so far but it works in some cases
        // with Matomo 4 this should be less likely an issue because we would invalidate and rearchive all reports when browser archiving
        // is enabled. Ideally we'd fetch the actual list of available metrics but even this might change over time when eg user
        // deletes a goal
        $allMetricsAggregate[] = 'nb_pageviews';
        $allMetricsAggregate[] = 'bounce_count';
        $allMetricsAggregate[] = 'sum_visit_length';
        $allMetricsAggregate[] = 'nb_revenue';
        $allMetricsAggregate[] = 'nb_conversions';
        $allMetricsAggregate[] = Metrics::METRIC_TOTAL_ORDERS;
        $allMetricsAggregate[] = Metrics::METRIC_TOTAL_ORDERS_REVENUE;
        foreach (range(0, 100) as $madeUpGoalId) {
            $allMetricsAggregate[] = 'nb_conversions_goal_' . $madeUpGoalId;
            $allMetricsAggregate[] = 'nb_revenue_goal_' . $madeUpGoalId;
        }

        foreach ($allMetricsAggregate as $metric) {
            $columnsAggregationOperation[$metric . Archiver::APPENDIX_TTEST_SUM] = $aggregate;
            $columnsAggregationOperation[$metric . Archiver::APPENDIX_TTEST_COUNT] = $aggregate;
            $columnsAggregationOperation[$metric . Archiver::APPENDIX_TTEST_STDDEV_SAMP] = $aggregate;
        }

        // always remove unique visitors values for aggregated archives
        $columnsAggregationOperation[Metrics::METRIC_UNIQUE_VISITORS] = 'skip';
        $columnsAggregationOperation[Metrics::METRIC_UNIQUE_VISITORS_ENTERED] = 'skip';

        $columnsAggregationOperation['aggregationTime'] = 'max';

        $columnsAggregationOperation[Metrics::METRIC_UNIQUE_VISITORS_AGGREGATED] = function ($theFirstRow, $other, $thisRow, $otherRow) {
            if ($thisRow->getColumn('aggregationTime') < $otherRow->getColumn('aggregationTime')) {
                return $otherRow->getColumn(Metrics::METRIC_UNIQUE_VISITORS_AGGREGATED);
            }

            return $thisRow->getColumn(Metrics::METRIC_UNIQUE_VISITORS_AGGREGATED);
        };

        $columnsAggregationOperation[Metrics::METRIC_UNIQUE_VISITORS_ENTERED_AGGREGATED] = function ($theFirstRow, $other, $thisRow, $otherRow) {
            if ($thisRow->getColumn('aggregationTime') < $otherRow->getColumn('aggregationTime')) {
                return $otherRow->getColumn(Metrics::METRIC_UNIQUE_VISITORS_ENTERED_AGGREGATED);
            }

            return $thisRow->getColumn(Metrics::METRIC_UNIQUE_VISITORS_ENTERED_AGGREGATED);
        };

        return $columnsAggregationOperation;
    }

    private function getQueryRowLabel(array $row): string
    {
        $label = $row['label'];

        if (empty($label) || $label == RequestProcessor::VARIATION_ORIGINAL_ID) {
            $label = Archiver::LABEL_NOT_DEFINED;
        }

        return $label;
    }
}
