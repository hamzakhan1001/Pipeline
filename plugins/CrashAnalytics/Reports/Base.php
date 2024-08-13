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

use Piwik\DataTable;
use Piwik\Date;
use Piwik\Metrics\Formatter;
use Piwik\Piwik;
use Piwik\Plugin\ViewDataTable;
use Piwik\Plugins\CoreVisualizations\Visualizations\Graph;
use Piwik\Plugins\CoreVisualizations\Visualizations\HtmlTable;
use Piwik\Plugins\CrashAnalytics\Columns\Crash;
use Piwik\Plugins\CrashAnalytics\Columns\Metrics\PageviewCrashRate;
use Piwik\Plugins\CrashAnalytics\Columns\Metrics\VisitsCrashRate;
use Piwik\Plugins\CrashAnalytics\Metrics;
use Piwik\Plugins\CrashAnalytics\SystemSettings;
use Piwik\Plugins\CrashAnalytics\Tracker\ResourceUriNormalizer;

abstract class Base extends \Piwik\Plugin\Report
{
    protected $showCrashSource = true;

    protected function init()
    {
        $this->categoryId = 'CrashAnalytics_Crashes';
        $this->processedMetrics = [];
        $this->defaultSortColumn = Metrics::CRASH_OCCURRENCES;
    }

    public function configureReportMetadata(&$availableReports, $infos)
    {
        $reportsToIgnoreInScheduledReports = [
            'getLastCrashesOverview',
            'getLastTopCrashes',
            'getLastNewCrashes',
            'getLastReappearedCrashes',
            'getLastDisappearedCrashes',
        ];

        if (in_array($this->action, $reportsToIgnoreInScheduledReports)) {
            return;
        }

        parent::configureReportMetadata($availableReports, $infos);
    }

    public function configureView(ViewDataTable $view)
    {
        if (!empty($this->dimension)) {
            $labelTranslation = $this->dimension instanceof Crash ? Piwik::translate('CrashAnalytics_Message') : $this->dimension->getName();
            $view->config->addTranslations(array('label' => $labelTranslation));
        }

        $view->config->addTranslations([
            'crash_type' => Piwik::translate('CrashAnalytics_Type'),
            'crash_source' => Piwik::translate('CrashAnalytics_Source'),
            'crash_first_seen' => Piwik::translate('CrashAnalytics_FirstSeen'),
            'crash_last_seen' => Piwik::translate('CrashAnalytics_LastSeen'),
            'crash_last_reappeared' => Piwik::translate('CrashAnalytics_LastReappeared'),
        ]);

        if ($this->dimension instanceof Crash) {
            $this->setCrashDimensionTooltips($view);
            $this->setTooltipForGroupedHashSources($view);
        }

        $this->addVisitsCrashRateTooltip($view);

        if ($view instanceof HtmlTable
            && property_exists($view->config, 'min_label_width')
        ) {
            $view->config->min_label_width = 288;
        }

        if ($view instanceof Graph) {
            $view->config->selectable_columns = $this->metrics;
        }

        if ($this->dimension instanceof Crash) {
            // detect 'Script error.'
            $view->config->filters[] = [
                function (DataTable $table) use ($view) {
                    $foundScriptError = false;
                    foreach ($table->getRows() as $row) {
                        $message = $row->getColumn('label');
                        $message = strtolower($message);
                        $message = rtrim($message, '.');
                        $source = $row->getColumn('crash_source');

                        if ($message == 'script error' && empty($source)) {
                            $foundScriptError = true;
                            break;
                        }
                    }

                    if ($foundScriptError) {
                        $view->config->show_footer_message .= "\n" . Piwik::translate('CrashAnalytics_ScriptErrorFooterMessage', [
                            '<a href="" target="_blank" rel="noreferrer noopener">', // TODO: faq url
                            '</a>',
                        ]);
                    }
                },
                [],
                true,
            ];

            // detect hash filenames and if found link to faq explaining the group hashed source file system setting
            $systemSettings = new SystemSettings();
            $groupHashSourceFiles = $systemSettings->groupHashedSourceFiles->getValue();
            if (!$groupHashSourceFiles) { // only display if setting is disabled
                $resourceUriNormalizer = new ResourceUriNormalizer($systemSettings->versioningUrlParameters->getValue(), $groupHashSourceFiles);
                $view->config->filters[] = [
                    function (DataTable $table) use ($view, $resourceUriNormalizer) {
                        $foundHashJs = false;
                        foreach ($table->getRows() as $row) {
                            $source = $row->getColumn('crash_source');
                            if ($resourceUriNormalizer->isLooksLikeHashedFile($source)) {
                                $foundHashJs = true;
                                break;
                            }
                        }

                        if ($foundHashJs) {
                            // if the other message was added, make sure there's a line break before this one
                            if (!empty($view->config->show_footer_message)) {
                                $view->config->show_footer_message .= "<br/><br/>";
                            }

                            $view->config->show_footer_message .= "\n" . Piwik::translate('CrashAnalytics_UngroupedHashFooterMessage', [
                                '<em>',
                                '</em>',
                                '<a href="" target="_blank" rel="noreferrer noopener">', //  TODO: faq url
                                '</a>',
                            ]);
                        }
                    },
                    [],
                    true,
                ];
            }
        }
    }

    private function addVisitsCrashRateTooltip(ViewDataTable $view)
    {
        $view->config->filters[] = [
            function (DataTable $table) {
                $visits = $table->getMetadata('nb_visits');
                if ($visits === false) {
                    return;
                }

                foreach ($table->getRows() as $row) {
                    $visitsWithCrash = $row->getColumn(Metrics::VISITS_WITH_CRASH);
                    $tooltip = Piwik::translate('CrashAnalytics_VisitsExperiencedOutOf', [$visitsWithCrash, $visits]);
                    $row->setMetadata(VisitsCrashRate::METRIC_NAME . '_tooltip', $tooltip);
                }
            },
            [],
            false,
        ];
    }

    protected function addPageviewTooltips(ViewDataTable $view)
    {
        $view->config->filters[] = [
            DataTable\Filter\ColumnCallbackAddMetadata::class,
            [
                [Metrics::PAGEVIEWS_WITH_CRASH, 'nb_hits'],
                PageviewCrashRate::METRIC_NAME . '_tooltip',
                function ($pageviewsWithCrash, $nbHits) {
                    if ($pageviewsWithCrash === false || $nbHits === false) {
                        return '';
                    }
                    return Piwik::translate('CrashAnalytics_PageviewsWithCrashOutOfPageviews', [$pageviewsWithCrash, $nbHits]);
                },
            ],
            false,
        ];
    }

    protected function formatFirstLastSeen(ViewDataTable $view)
    {
        $dateTimeColumns = ['crash_first_seen', 'crash_last_seen'];
        foreach ($dateTimeColumns as $column) {
            $view->config->filters[] = [
                DataTable\Filter\ColumnCallbackAddMetadata::class,
                [
                    $column,
                    $column . '_tooltip',
                ],
                false,
            ];
        }

        $formatter = new Formatter();
        $now = Date::now();
        $view->config->filters[] = [
            DataTable\Filter\ColumnCallbackReplace::class,
            [
                $dateTimeColumns,
                function ($value) use ($now, $formatter) {
                    if (empty($value)) {
                        return $value;
                    }

                    $valueDate = Date::factory($value);

                    $secondsSinceNow = $now->getTimestamp() - $valueDate->getTimestamp();
                    if ($secondsSinceNow < 60 * 60 * 24) { // if less than 24 hrs
                        return Piwik::translate('General_TimeAgo', $formatter->getPrettyTimeFromSeconds($secondsSinceNow, true));
                    }

                    return $valueDate->getLocalized(Date::DATE_FORMAT_SHORT);
                },
            ],
            false,
        ];
    }

    protected function setColumnsToDisplayWithMetadata(ViewDataTable $view)
    {
        if ($view instanceof HtmlTable) {
            $view->config->columns_to_display = array_filter([
                'label',
                'crash_type',
                $this->showCrashSource ? 'crash_source' : null,
                Metrics::CRASH_OCCURRENCES,
                Metrics::VISITS_WITH_CRASH,
                VisitsCrashRate::METRIC_NAME,
                'crash_first_seen',
                'crash_last_seen',
            ]);
        }

        if ($view instanceof Graph) {
            $view->config->columns_to_display = [
                'label',
                Metrics::CRASH_OCCURRENCES,
            ];
        }
    }

    /**
     * Returns the minute values for widgets based on the lastN reports. Defaults to 30 minutes & 8 hours.
     *
     * @return int[]
     */
    protected function getReportLastMinuteValues()
    {
        return [30, 8 * 60];
    }

    /**
     * Returns the minute values for the last reappeared, last new, last disappeared widgets. Defaults 8
     * hours and nothing else.
     *
     * @return int[]
     */
    protected function getReportLastCrashesMinuteValues()
    {
        return [8 * 60];
    }

    private function setCrashDimensionTooltips(ViewDataTable $view)
    {
        $view->config->tooltip_metadata_name = 'whole_label_tooltip'; // not using label_tooltip as this causes issues in tooltip display

        $view->config->metrics_documentation['crash_type'] = Piwik::translate('CrashAnalytics_CrashTypeDocumentation');
        $view->config->metrics_documentation['crash_source'] = Piwik::translate('CrashAnalytics_ResourceUriDocumentation');
        $view->config->metrics_documentation['crash_first_seen'] = Piwik::translate('CrashAnalytics_FirstSeenDocumentation');
        $view->config->metrics_documentation['crash_last_seen'] = Piwik::translate('CrashAnalytics_LastSeenDocumentation');

        $truncateColumns = [
            'label' => ['limit' => 45, 'at' => 'end'],
            'crash_type' => ['limit' => 20, 'at' => 'end'],
            'crash_source' => ['limit' => 35, 'at' => 'start'],
        ];

        foreach ($truncateColumns as $column => $truncateInfo) {
            $view->config->filters[] = [
                function (DataTable $table) use ($column, $truncateInfo) {
                    foreach ($table->getRows() as $row) {
                        $this->truncateColumn($row, $column, $truncateInfo['limit'], $truncateInfo['at'] == 'start');
                    }

                    $totalsRow = $table->getTotalsRow();
                    if ($totalsRow) {
                        $this->truncateColumn($totalsRow, $column, $truncateInfo['limit'], $truncateInfo['at'] == 'start');
                    }

                    $table->setLabelsHaveChanged();
                },
                [],
                false,
            ];
        }
    }

    private function truncateColumn(DataTable\Row $row, $column, $limit, $atStart = false)
    {
        $value = $row->getColumn($column);

        if ($atStart) {
            $truncated = mb_substr($value, max(0, strlen($value) - $limit), strlen($value));
        } else {
            $truncated = mb_substr($value, 0, $limit);
        }

        if ($value != $truncated) {
            $row->setMetadata($column != 'label' ? $column . '_tooltip' : 'whole_label_tooltip', $value);

            $truncatedWithEllipsis = $atStart ? '...' . $truncated : $truncated . '...';
            $row->setColumn($column, $truncatedWithEllipsis);
        }
    }
    protected function setDatetimeTooltipsForLastCrashesReport(ViewDataTable $view)
    {
        $dateTimeColumns = ['crash_first_seen', 'crash_last_seen', 'crash_last_reappeared'];
        $view->config->filters[] = [
            function (DataTable $table) use ($dateTimeColumns) {
                foreach ($table->getRows() as $row) {
                    foreach ($dateTimeColumns as $column) {
                        $value = $row->getColumn($column);
                        if (empty($value)) {
                            continue;
                        }

                        $valueDate = Date::factory($value);
                        $row->setMetadata($column . '_tooltip', $valueDate->getDatetime());

                        $prettyValue = $row->getColumn($column . '_pretty');
                        $row->setColumn($column, $prettyValue);
                    }
                }
            },
            [],
            false,
        ];
    }

    private function setTooltipForGroupedHashSources(ViewDataTable $view)
    {
        $resourceUriNormalizer = new ResourceUriNormalizer(null, false);
        $view->config->filters[] = [
            function (DataTable $table) use ($resourceUriNormalizer) {
                foreach ($table->getRows() as $row) {
                    $crashSource = $row->getColumn('crash_source');
                    if (!$resourceUriNormalizer->isLooksLikeGroupedHash($crashSource)) {
                        continue;
                    }

                    $tooltip = $row->getMetadata('crash_source_tooltip');
                    if (!empty($tooltip)) {
                        $tooltip .= '<br/><br/>';
                    }

                    $tooltip .= Piwik::translate('CrashAnalytics_GroupedHashRowTooltip');
                    $row->setMetadata('crash_source_tooltip', $tooltip);
                }
            },
            [],
            false,
        ];
    }
}
