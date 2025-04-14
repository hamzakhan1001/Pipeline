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

namespace Piwik\Plugins\CrashAnalytics\Reports;

use Piwik\API\Request;
use Piwik\Common;
use Piwik\DataTable;
use Piwik\DataTable\Filter\CalculateEvolutionFilter;
use Piwik\Metrics\Formatter as MetricFormatter;
use Piwik\Period\Month;
use Piwik\Period\Range;
use Piwik\Piwik;
use Piwik\Plugin\ViewDataTable;
use Piwik\Plugins\CoreVisualizations\Visualizations\Graph;
use Piwik\Plugins\CoreVisualizations\Visualizations\JqplotGraph\Evolution;
use Piwik\Plugins\CoreVisualizations\Visualizations\Sparklines;
use Piwik\Plugins\CrashAnalytics\Columns\Metrics\PageviewCrashRate;
use Piwik\Plugins\CrashAnalytics\Columns\Metrics\VisitsCrashRate;
use Piwik\Plugins\CrashAnalytics\Metrics;
use Piwik\Report\ReportWidgetFactory;
use Piwik\Widget\WidgetsList;

class Get extends Base
{
    protected function init()
    {
        parent::init();

        $this->metrics = [
            Metrics::CRASH_OCCURRENCES,
            Metrics::VISITS_WITH_CRASH,
            Metrics::IGNORED_CRASHES,
            Metrics::UNIQUE_CRASHES,
            Metrics::NEW_CRASHES,
            Metrics::DISAPPEARED_CRASHES,
            Metrics::REAPPEARED_CRASHES,
        ];
        $this->name          = Piwik::translate('CrashAnalytics_CrashesOverview');
        $this->documentation = Piwik::translate('CrashAnalytics_CrashesOverviewDocumentation');
        $this->subcategoryId = 'CrashAnalytics_Overview';
        $this->processedMetrics = [
            VisitsCrashRate::METRIC_NAME,
        ];
    }

    public function configureView(ViewDataTable $view)
    {
        parent::configureView($view);

        $selectableMetrics = [
            Metrics::CRASH_OCCURRENCES,
            Metrics::VISITS_WITH_CRASH,
            VisitsCrashRate::METRIC_NAME,
            Metrics::IGNORED_CRASHES,
            Metrics::UNIQUE_CRASHES,
            Metrics::NEW_CRASHES,
            Metrics::DISAPPEARED_CRASHES,
            Metrics::REAPPEARED_CRASHES,
        ];

        if (!$view->isViewDataTableId(Graph::ID)) {
            $view->config->columns_to_display = $selectableMetrics;
        }

        if ($view instanceof Evolution) {
            $view->config->selectable_columns = $selectableMetrics;
        }

        if ($view instanceof Sparklines) {
            foreach ($selectableMetrics as $metric) {
                $view->config->addSparklineMetric($metric);
            }

            $view->config->addTranslation(VisitsCrashRate::METRIC_NAME, Piwik::translate('CrashAnalytics_VisitsCrashRate'));

            // copied from VisitsSummary/Get.php, didn't need to be changed
            list($lastPeriodDate, $ignore) = Range::getLastDate();
            if ($lastPeriodDate !== false) {
                $translations = array_merge(Metrics::getMetricTranslations(), [
                    VisitsCrashRate::METRIC_NAME => VisitsCrashRate::TRANSLATION_ID,
                    PageviewCrashRate::METRIC_NAME => PageviewCrashRate::TRANSLATION_ID,
                ]);
                $translations = array_map(function ($v) { return mb_strtolower(Piwik::translate($v)); }, $translations);
                $view->config->addTranslations($translations);

                $currentPeriod = \Piwik\Period\Factory::build(Piwik::getPeriod(), Common::getRequestVar('date'));
                $currentPrettyDate = ($currentPeriod instanceof Month ? $currentPeriod->getLocalizedLongString() : $currentPeriod->getPrettyString());
                $lastPeriod = \Piwik\Period\Factory::build(Piwik::getPeriod(), $lastPeriodDate);
                $lastPrettyDate = ($currentPeriod instanceof Month ? $lastPeriod->getLocalizedLongString() : $lastPeriod->getPrettyString());

                /** @var DataTable $previousData */
                $previousData = Request::processRequest('CrashAnalytics.get', ['date' => $lastPeriodDate, 'format_metrics' => '0']);
                $previousDataRow = $previousData->getFirstRow();

                $view->config->compute_evolution = function ($columns, $metrics) use ($currentPrettyDate, $lastPrettyDate, $previousDataRow) {
                    $value = reset($columns);
                    $columnName = key($columns);
                    $pastValue = $previousDataRow ? $previousDataRow->getColumn($columnName) : 0;

                    // Format
                    $formatter = new MetricFormatter();
                    $currentValueFormatted = $value;
                    $pastValueFormatted = $pastValue;
                    foreach ($metrics as $metric) {
                        if ($metric->getName() == $columnName) {
                            $pastValueFormatted = $metric->format($pastValue, $formatter);
                            $currentValueFormatted = $metric->format($value, $formatter);
                            break;
                        }
                    }

                    $columnTranslations = \Piwik\Metrics::getDefaultMetricTranslations();
                    $columnTranslation = '';
                    if (array_key_exists($columnName, $columnTranslations)) {
                        $columnTranslation = $columnTranslations[$columnName];
                    }

                    return [
                        'currentValue' => $value,
                        'pastValue' => $pastValue,
                        'tooltip' => Piwik::translate('General_EvolutionSummaryGeneric', [
                            $currentValueFormatted . ' ' . $columnTranslation,
                            $currentPrettyDate,
                            $pastValueFormatted . ' ' . $columnTranslation,
                            $lastPrettyDate,
                            CalculateEvolutionFilter::calculate($value, $pastValue, $precision = 1)])
                    ];
                };
            }
        }
    }

    public function configureWidgets(WidgetsList $widgetsList, ReportWidgetFactory $factory)
    {
        $config = $factory->createWidget();
        $config->forceViewDataTable(Evolution::ID);
        $config->setAction('getEvolutionGraph');
        $config->setOrder(5);
        $config->setName('General_EvolutionOverPeriod');
        $widgetsList->addWidgetConfig($config);

        $config = $factory->createWidget();
        $config->forceViewDataTable(Sparklines::ID);
        $config->setName('CrashAnalytics_CrashesOverview');
        $config->setIsNotWidgetizable();
        $config->setOrder(15);
        $widgetsList->addWidgetConfig($config);
    }
}
