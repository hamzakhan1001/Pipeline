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

namespace Piwik\Plugins\Funnels;

use Piwik\API\Request;
use Piwik\Common;
use Piwik\Config;
use Piwik\DataTable;
use Piwik\Http\BadRequestException;
use Piwik\NumberFormatter;
use Piwik\Piwik;
use Piwik\Plugin;
use Piwik\Plugin\Manager;
use Piwik\Plugins\Funnels\Db\Pattern;
use Piwik\Plugins\Funnels\Input\Validator;
use Piwik\Plugins\Funnels\Model\FunnelNotFoundException;
use Piwik\Plugins\Funnels\Model\FunnelsModel;
use Piwik\Plugins\Funnels\Reports\FunnelReportProcessor;
use Piwik\Plugins\Live\Live;
use Piwik\Plugins\PrivacyManager\PrivacyManager;
use Piwik\Site;
use Piwik\Tracker\GoalManager;
use Piwik\Tracker\PageUrl;
use Piwik\Plugin\Controller as PluginController;
use Piwik\View;

class Controller extends PluginController
{
    /**
     * @var FunnelsModel
     */
    private $funnels;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * @var Pattern
     */
    private $pattern;

    /**
     * @var NumberFormatter
     */
    private $numberFormatter;

    public function __construct(FunnelsModel $funnels, Validator $validator, Pattern $pattern, NumberFormatter $numberFormatter)
    {
        $this->funnels = $funnels;
        $this->validator = $validator;
        $this->pattern = $pattern;
        $this->numberFormatter = $numberFormatter;

        parent::__construct();
    }

    /**
     * Shows which URLs match a certain pattern and help text for how to configure a step.
     * @return string
     */
    public function stepHelp()
    {
        $this->checkSitePermission();
        $this->validator->checkWritePermission($this->idSite);

        $pattern = Common::getRequestVar('pattern', '', 'string');
        $patternType = Common::getRequestVar('pattern_type', '', 'string');
        $limit = 20;

        $hasMoreUrls = false;
        $urls = array();
        if (!empty($pattern) && !empty($patternType)) {
            $urls = $this->pattern->findMatchingUrls($patternType, $pattern, $this->idSite, $limit);
            $hasMoreUrls = count($urls) >= $limit;
        }

        return $this->renderTemplate('stepHelp', array(
            'urls' => $urls,
            'hasMoreUrls' => $hasMoreUrls,
            'urlLimit' => $limit,
            'pattern' => $pattern,
            'patternType' => $patternType,
            'patternTranslations' => Pattern::getTranslationsForPatternTypes(),
            'urlPrefixes' => array_keys(PageUrl::$urlPrefixMap)
        ));
    }

    /**
     * Shows a message if there are no funnels configured
     * @return string
     */
    public function overview()
    {
        $this->checkSitePermission();
        $this->validator->checkReportViewPermission($this->idSite);

        $hasActivatedFunnels = Request::processRequest('Funnels.hasAnyActivatedFunnelForSite', [
            'idSite' => $this->idSite,
        ], $default = []);

        if ($hasActivatedFunnels) {
            return '';
        }

        return $this->renderTemplate('overview', array(
            'canEditFunnels' => $this->validator->canWrite($this->idSite),
        ));
    }

    private function addMetricsToFunnel($funnel)
    {
        /** @var DataTable $metrics */
        $metrics = Request::processRequest('Funnels.getMetrics', array(
            'idFunnel' => $funnel['idfunnel'],
            'format_metrics' => '1',
            'filter_limit' => '-1'
        ));
        $metrics = $metrics->getFirstRow();

        if (!empty($metrics)) {
            $funnel['numEntries'] = $metrics->getColumn(Metrics::SUM_FUNNEL_ENTRIES) ?: 0;
            $funnel['numExits'] = $metrics->getColumn(Metrics::SUM_FUNNEL_EXITS) ?: 0;
            $funnel['numConversions'] = $metrics->getColumn(Metrics::NUM_CONVERSIONS) ?: 0;
            $funnel['conversionRate'] = $metrics->getColumn(Metrics::RATE_CONVERSION);
            $funnel['abandonedRate'] = $metrics->getColumn(Metrics::RATE_ABANDONED);
        } else {
            $funnel['numEntries'] = 0;
            $funnel['numExits'] = 0;
            $funnel['numConversions'] = 0;
            $funnel['conversionRate'] = 0;
            $funnel['abandonedRate'] = 0;
        }

        $funnel['urlSparklineConversions'] = $this->getUrlSparkline('getEvolutionGraph', array('columns' => array(Metrics::NUM_CONVERSIONS), 'getMetrics' => '1', 'idFunnel' => $funnel['idfunnel'], 'idGoal' => $funnel['idgoal']));
        $funnel['urlSparklineConversionRate'] = $this->getUrlSparkline('getEvolutionGraph', array('columns' => array(Metrics::RATE_CONVERSION), 'getMetrics' => '1', 'idFunnel' => $funnel['idfunnel'], 'idGoal' => $funnel['idgoal']));

        return $funnel;
    }

    public function getEvolutionGraph(array $columns = array(), array $defaultColumns = array())
    {
        $this->checkSitePermission();
        $this->validator->checkReportViewPermission($this->idSite);

        $idGoal = Common::getRequestVar('idGoal', null, 'int');
        $idFunnel = Common::getRequestVar('idFunnel', null, 'int');
        if (empty($idFunnel)) {
            $this->checkGoalFunnelExists($this->idSite, $idGoal);
        }

        if (empty($columns)) {
            $columns = Common::getRequestVar('columns', false);
            if (false !== $columns) {
                $columns = Piwik::getArrayFromApiParameter($columns);
            }
        }

        $view = $this->getLastUnitGraph($this->pluginName, __FUNCTION__, 'Funnels.getMetrics');

        // configure displayed columns
        if (empty($columns)) {
            $columns = Common::getRequestVar('columns', false);
            if (false !== $columns) {
                $columns = Piwik::getArrayFromApiParameter($columns);
            }
        }
        if (false !== $columns) {
            $columns = !is_array($columns) ? array($columns) : $columns;
        }

        if (!empty($columns)) {
            $view->config->columns_to_display = $columns;
        } elseif (empty($view->config->columns_to_display) && !empty($defaultColumns)) {
            $view->config->columns_to_display = $defaultColumns;
        }

        $view->config->selectable_columns = array(
            Metrics::RATE_CONVERSION,
            Metrics::NUM_CONVERSIONS,
            Metrics::RATE_ABANDONED,
            Metrics::SUM_FUNNEL_ENTRIES,
            Metrics::SUM_FUNNEL_EXITS,
        );

        $view->config->row_picker_match_rows_by = 'label';
        $view->config->documentation = Piwik::translate('General_EvolutionOverPeriod');

        return $this->renderView($view);
    }

    public function goalFunnelReport()
    {
        $this->checkSitePermission();
        $this->validator->checkReportViewPermission($this->idSite);

        $idGoal = Common::getRequestVar('idGoal', null, 'int');
        $period = Common::getRequestVar('period', null, 'string');
        $date = Common::getRequestVar('date', null, 'string');
        $idFunnel = \Piwik\Request::fromRequest()->getIntegerParameter('idFunnel');
        $segment = Request::getRawSegmentFromRequest();

        $funnel = !empty($idFunnel) ? $this->getNonGoalFunnel($this->idSite, $idFunnel) : $this->getGoalFunnel($this->idSite, $idGoal);
        $funnel = $this->addMetricsToFunnel($funnel);

        // needed for when requesting evolution graph
        $_GET['idFunnel'] = (int) $funnel['idfunnel'];

        $evolution = $this->getEvolutionGraph(array(Metrics::RATE_CONVERSION));

        /** @var DataTable $funnelFlow */
        $funnelFlow = Request::processRequest('Funnels.getFunnelFlow', array(
            'idFunnel' => $funnel['idfunnel'],
            'format_metrics' => '1',
            'filter_limit' => '-1'
        ));

        $funnelFlowArray = array_values($funnelFlow->getRows());
        $funnelFlowArray = array_map(function (DataTable\Row $row) {
            // Decode special characters in the labels
            $row->setColumn('label', html_entity_decode($row->getColumn('label'), ENT_QUOTES));
            return array_merge($row->getColumns(), $row->getMetadata());
        }, $funnelFlowArray);

        $hasBeenPurged = false;
        $deleteReportsOlderThan = false;
        if ($funnelFlow->getRowsCount() === 0) {
            $hasBeenPurged = $this->hasReportBeenPurged($funnelFlow);
            $deleteReportsOlderThan = $this->getDeleteReportsOlderThan();
        }

        return $this->renderTemplate('goalFunnelReport', array(
            'idsite' => $this->idSite,
            'evolution' => $evolution,
            'idSite' => $this->idSite,
            'period' => $period,
            'segment' => !empty($segment) ? $segment : '',
            'date' => $date,
            'funnel' => $funnel,
            'funnelFlow' => $funnelFlowArray,
            'canEditFunnels' => $this->validator->canWrite($this->idSite),
            'patternTranslations' => Pattern::getTranslationsForPatternTypes(),
            'isVisitorLogEnabled' => self::isVisitorLogEnabled(),
            'hasBeenPurged' => $hasBeenPurged,
            'deleteReportsOlderThan' => $deleteReportsOlderThan
        ));
    }

    public function funnelReport()
    {
        $this->checkSitePermission();
        $this->validator->checkReportViewPermission($this->idSite);

        $request = \Piwik\Request::fromRequest();
        $requestIdFunnel = $request->getIntegerParameter('idFunnel', null);
        $requestPeriod = $request->getStringParameter('period', null);
        $requestComparePeriods = $request->getArrayParameter('comparePeriods', []);
        $requestDate = $request->getStringParameter('date', null);
        $requestCompareDates = $request->getArrayParameter('compareDates', []);
        $requestSegment = $request->getStringParameter('segment', '');
        $requestCompareSegments = $request->getArrayParameter('compareSegments', []);

        $allPeriods = array_merge([$requestPeriod], $requestComparePeriods);
        $allDates = array_merge([$requestDate], $requestCompareDates);
        $allSegments = array_merge([$requestSegment], $requestCompareSegments);

        $generalConfig = Config::getInstance()->General;
        $segmentCompareLimit = (int)$generalConfig['data_comparison_segment_limit'];
        if (count($allSegments) > $segmentCompareLimit + 1) {
            throw new BadRequestException(Piwik::translate('General_MaximumNumberOfSegmentsComparedIs', [$segmentCompareLimit]));
        }

        $segmentRows = [];
        $maxHeights = [];
        $metadata = [
            'segments' => [],
            'steps' => [],
            'has_proceeded' => false,
            'has_entries' => false,
            'has_skipped' => false,
            'has_exits' => false,
            'has_multiple_valid_segments' => (count($allPeriods) * count($allSegments) >= 2),
            'has_period_comparison' => (count($allPeriods) >= 2),
        ];

        $funnelReportProcessor = new FunnelReportProcessor($this->numberFormatter);

        foreach ($allPeriods as $periodIndex => $period) {
            $date = $allDates[$periodIndex];
            foreach ($allSegments as $segment) {
                $funnelFlows = Request::processRequest('Funnels.getFunnelFlow', [
                    'period' => $period,
                    'date' => $date,
                    'idFunnel' => $requestIdFunnel,
                    'format_metrics' => '1',
                    'filter_limit' => '-1',
                    'segment' => $segment,
                ]);

                $flowRows = $funnelFlows->getRows() ?? [];
                $flowMeta = $funnelFlows->getAllTableMetadata() ?? [];

                // Set default values to avoid using null coalescing operators later
                foreach ($flowRows as &$row) {
                    $row[Metrics::NUM_STEP_ENTRIES] = $row[Metrics::NUM_STEP_ENTRIES] ?? 0;
                    $row[Metrics::NUM_STEP_EXITS] = $row[Metrics::NUM_STEP_EXITS] ?? 0;
                    $row[Metrics::NUM_STEP_PROCEEDS] = $row[Metrics::NUM_STEP_PROCEEDS] ?? 0;
                    $row[Metrics::NUM_STEP_SKIPS] = $row[Metrics::NUM_STEP_SKIPS] ?? 0;
                    $row[Metrics::NUM_STEP_VISITS_ACTUAL] = $row[Metrics::NUM_STEP_VISITS_ACTUAL] ?? 0;
                    $row['step_nb_previous_proceeded'] = $row['step_nb_previous_proceeded'] ?? 0;
                    $row['step_nb_previous_exits'] = $row['step_nb_previous_exits'] ?? 0;
                }
                unset($row);

                $segmentPretty = html_entity_decode($flowMeta['segmentPretty'], ENT_QUOTES);
                $periodPretty = $funnelReportProcessor->getCustomFormattedDate($flowMeta['period']);
                $segmentKey = $segmentPretty . '~|~' . $periodPretty; // Using a delimiter that is unlikely to be in the segment name
                $maxHeights[$segmentKey] = $funnelReportProcessor->calculateAndSetRowMetrics($flowRows, $flowMeta['totals']['step_nb_entries'] ?? 0);
                $metadata['segments'][$segmentKey] = $segmentPretty;
                $segmentRows[$segmentKey] = $flowRows;

                foreach ($flowRows as $index => $row) {
                    if (empty($metadata['steps'][$index])) {
                        // Decode special characters in the labels
                        $metadata['steps'][$index] = html_entity_decode($row->getColumn('label'), ENT_QUOTES);
                    }
                    if ($index === 0) {
                        $metadata['has_proceeded'] = $metadata['has_proceeded'] || ($row['step_nb_entries'] > 0);
                    } else {
                        $metadata['has_entries'] = $metadata['has_entries'] || ($row['step_nb_entries'] > 0);
                        $metadata['has_proceeded'] = $metadata['has_proceeded'] || ($row['step_nb_previous_proceeded'] > 0);
                    }
                    $metadata['has_skipped'] = $metadata['has_skipped'] || ($row['step_nb_skipped'] > 0);
                    $metadata['has_exits'] = $metadata['has_exits'] || ($row['step_nb_previous_exits'] > 0);
                }
            }
        }

        $maxHeight = max($maxHeights);
        foreach ($segmentRows as $segmentKey => $flowRows) {
            if ($maxHeights[$segmentKey] <= 0) {
                continue;
            }
            $funnelReportProcessor->calculateAndSetBarHeights($segmentRows[$segmentKey], $maxHeight);
        }

        $vueStructuredData = [];
        foreach ($segmentRows as $segmentKey => $flowRows) {
            if (!isset($firstSegmentRow)) {
                $firstSegmentRow = $flowRows;
            }
            if (isset($metadata['steps'])) {
                foreach ($metadata['steps'] as $index => $step) {
                    $vueStructuredData[$index][$segmentKey] = $flowRows[$index] ?? null;
                }
            }
        }

        return $this->renderTemplate('funnelConversionReport', [
            'idSite' => $this->idSite,
            'metadata' => $metadata,
            'funnelFlow' => $vueStructuredData,
            'firstSegmentFlow' => $firstSegmentRow,
            'isClosedFunnel' => $this->isClosedFunnel($requestIdFunnel),
        ]);
    }

    private function isClosedFunnel($idFunnel): bool
    {
        $funnel = $this->funnels->getFunnel($idFunnel);
        $steps = $funnel['steps'] ?? [];
        $requiredValues = array_unique(array_column($steps, 'required'));

        return count($requiredValues) === 1 && !empty($requiredValues[0]);
    }

    public function funnelReportTable()
    {
        $this->checkSitePermission();
        $this->validator->checkReportViewPermission($this->idSite);

        return $this->renderReport('getFunnelFlowTable', 'getFunnelFlow');
    }

    public function getFunnelStepEntriesExits()
    {
        $this->checkSitePermission();
        $this->validator->checkReportViewPermission($this->idSite);

        return $this->renderReport('getFunnelStepSubtable', 'Funnels.' . __METHOD__);
    }

    public function getFunnelStepSubtable()
    {
        $this->checkSitePermission();
        $this->validator->checkReportViewPermission($this->idSite);

        $subStepType = \Piwik\Request::fromRequest()->getStringParameter('subStepType', '');
        $apiMethod = 'getFunnelEntries';
        if ($subStepType === 'exit') {
            $apiMethod = 'getFunnelExits';
        }
        return $this->renderReport($apiMethod, $apiMethod);
    }

    public function funnelSummary()
    {
        $this->checkSitePermission();
        $this->validator->checkReportViewPermission($this->idSite);

        $idGoal = Common::getRequestVar('idGoal', null, 'int');
        $period = Common::getRequestVar('period', null, 'string');
        $date = Common::getRequestVar('date', null, 'string');
        $idFunnel = \Piwik\Request::fromRequest()->getIntegerParameter('idFunnel');
        $segment = Request::getRawSegmentFromRequest();

        $funnel = !empty($idFunnel) ? $this->getNonGoalFunnel($this->idSite, $idFunnel) : $this->getGoalFunnel($this->idSite, $idGoal);
        $funnel = $this->addMetricsToFunnel($funnel);

        // needed for when requesting evolution graph
        $_GET['idFunnel'] = (int) $funnel['idfunnel'];

        /** @var DataTable $funnelFlow */
        $funnelFlow = Request::processRequest('Funnels.getFunnelFlow', array(
            'idFunnel' => $funnel['idfunnel'],
            'format_metrics' => '1',
            'filter_limit' => '-1'
        ));

        $funnelFlowArray = [];
        foreach ($funnelFlow->getRows() as $row) {
            $funnelFlowArray[$row->getColumn('label')] = array_merge($row->getColumns(), $row->getMetadata());
        }

        /** @var DataTable $goalsReport */
        $goalsReport = Request::processRequest('Goals.get', array(
            'idGoal' => $idGoal,
            'idSite' => $this->idSite,
            'columns' => array('nb_conversions', 'conversion_rate', 'revenue')
        ));
        $goalsSummary = $goalsReport->getFirstRow();

        $currencySymbol = Site::getCurrencySymbolFor($this->idSite);
        $numberFormatter = NumberFormatter::getInstance();

        $revenue = $goalsSummary->getColumn('revenue');
        $revenueFormatted = $numberFormatter->formatCurrency(
            $revenue,
            $currencySymbol,
            GoalManager::REVENUE_PRECISION
        );

        return $this->renderTemplate('funnelSummary', array(
            'idsite' => $this->idSite,
            'idSite' => $this->idSite,
            'period' => $period,
            'segment' => !empty($segment) ? $segment : '',
            'date' => $date,
            'funnel' => $funnel,
            'goalsSummary' => array_merge($goalsSummary->getColumns(), [
                'revenue' => $revenue ? $revenueFormatted : null,
            ]),
            'funnelFlow' => $funnelFlowArray,
            'isVisitorLogEnabled' => self::isVisitorLogEnabled(),
            'patternTranslations' => Pattern::getTranslationsForPatternTypes(),
            'isNonGoalFunnel' => $funnel['isNonGoalFunnel'] ?? false,
            'userCanEditFunnels' => Piwik::isUserHasWriteAccess($this->idSite),
        ));
    }

    public function addNewFunnel()
    {
        $view = new View('@Funnels/editFunnels');
        $this->setGeneralVariablesView($view);
        $view->funnels = [];
        $view->userCanEditFunnels = Piwik::isUserHasWriteAccess($this->idSite);
        $view->isAddNewView = true;
        $view->idFunnel = 0;
        $view->goals = $this->getFormattedGoalsArray();
        return $view->render();
    }

    public function editFunnels()
    {
        $view = new View('@Funnels/editFunnels');
        $this->setGeneralVariablesView($view);
        $funnels = API::getInstance()->getAllActivatedFunnelsForSite($this->idSite);
        // Since we're getting the list of funnels from an API call, we need to unescape special characters
        foreach ($funnels as $index => $funnel) {
            $funnels[$index]['name'] = html_entity_decode($funnel['name'], ENT_QUOTES);
        }
        $columnArray = array_column($funnels, 'idfunnel');
        array_multisort($columnArray, SORT_ASC, $funnels);
        $view->funnels = $funnels;
        $view->userCanEditFunnels = Piwik::isUserHasWriteAccess($this->idSite);
        $view->idFunnel = \Piwik\Request::fromRequest()->getIntegerParameter('idFunnel', 0);
        $view->goals = $this->getFormattedGoalsArray();
        return $view->render();
    }

    protected function getGoals($idSite)
    {
        return Request::processRequest('Goals.getGoals', [
            'idSite' => $idSite, 'filter_limit' => -1
        ], $default = []);
    }

    protected function getFormattedGoalsArray()
    {
        $goals = [];
        foreach ($this->getGoals($this->idSite) as $goal) {
            // string is important to preselect correct value
            $goals[] = ['key' => (string) $goal['idgoal'], 'value' => $goal['name']];
        }

        return $goals;
    }

    private static function isVisitorLogEnabled()
    {
        return Manager::getInstance()->isPluginActivated('Live') && Live::isVisitorLogEnabled();
    }

    private function getDeleteReportsOlderThan()
    {
        $settings = PrivacyManager::getPurgeDataSettings();

        if (!empty($settings['delete_reports_older_than'])) {
            return $settings['delete_reports_older_than'];
        }

        return '';
    }

    private function hasReportBeenPurged($dataTable)
    {
        if (!Plugin\Manager::getInstance()->isPluginActivated('PrivacyManager')) {
            return false;
        }

        return PrivacyManager::hasReportBeenPurged($dataTable);
    }

    private function checkGoalFunnelExists($idSite, $idGoal)
    {
        $funnel = $this->getGoalFunnel($idSite, $idGoal);
        if (empty($funnel)) {
            throw new FunnelNotFoundException();
        }
    }

    private function getGoalFunnel($idSite, $idGoal)
    {
        return Request::processRequest('Funnels.getGoalFunnel', [
            'idSite' => $idSite,
            'idGoal' => $idGoal,
        ], $default = []);
    }

    private function getNonGoalFunnel($idSite, $idFunnel)
    {
        return Request::processRequest('Funnels.getFunnel', [
            'idSite' => $idSite,
            'idFunnel' => $idFunnel,
        ], $default = []);
    }
}
