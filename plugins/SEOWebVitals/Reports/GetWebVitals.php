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

namespace Piwik\Plugins\SEOWebVitals\Reports;

use Piwik\ArchiveProcessor\Rules;
use Piwik\Common;
use Piwik\Container\StaticContainer;
use Piwik\DataTable;
use Piwik\Date;
use Piwik\Metrics\Formatter;
use Piwik\Period;
use Piwik\Piwik;
use Piwik\Plugin\Report;
use Piwik\Plugin\ViewDataTable;
use Piwik\SettingsPiwik;
use Piwik\Site;
use Piwik\Tracker\Model as TrackerModel;
use Piwik\Tracker\PageUrl as TrackerPageUrl;
use Piwik\Plugins\Actions\Columns\PageUrl;
use Piwik\Plugins\CoreVisualizations\Visualizations\HtmlTable;
use Piwik\Plugins\CoreVisualizations\Visualizations\Sparklines;
use Piwik\Plugins\SEOWebVitals\Columns\Audit;
use Piwik\Plugins\SEOWebVitals\Dao\Pages;
use Piwik\Plugins\SEOWebVitals\Dao\PageSpeedApi;
use Piwik\Plugins\SEOWebVitals\Metrics;
use Piwik\Plugins\SEOWebVitals\Visualizations\AllStrategiesTable;
use Piwik\Plugins\SEOWebVitals\Visualizations\DesktopStrategyTable;
use Piwik\Plugins\SEOWebVitals\Visualizations\MobileStrategyTable;
use Piwik\Report\ReportWidgetFactory;
use Piwik\Url;
use Piwik\Widget\WidgetsList;

/**
 * This class defines a new report.
 *
 * See {@link http://developer.piwik.org/api-reference/Piwik/Plugin/Report} for more information.
 */
class GetWebVitals extends Report
{
    protected function init()
    {
        parent::init();

        $this->order = 1;

        $this->categoryId = 'Referrers_Referrers';
        $this->subcategoryId = 'SEOWebVitals_SEOWebVitals';

        $this->name          = Piwik::translate('SEOWebVitals_SEOWebVitals');
        $this->documentation = Piwik::translate('SEOWebVitals_WebVitalsReportDocumentation');

        $this->onlineGuideUrl = Url::addCampaignParametersToMatomoLink('https://matomo.org/guide/reports/seo-web-vitals/');

        $idSubtable = Common::getRequestVar('idSubtable', 0, 'int');
        $label = Common::getRequestVar('label', '', 'string');
        $isRowEvolutionForSubtable = Common::getRequestVar('method', '', 'string') === 'API.getRowEvolution'
            && $label && strpos($label, ' &gt; @') !== false; // row evolution doesn't send the idSubtable...
        if ($idSubtable || $isRowEvolutionForSubtable) {
            $this->dimension     = new Audit();
            $metrics =  [Metrics::METRIC_AUDIT_SCORE];
            if (Common::getRequestVar('period', '', 'string') === 'day') {
                $metrics[] = Metrics::METRIC_AUDIT_DISPLAY_VALUE;
            }
        } else {
            $this->dimension     = new PageUrl();
            $metrics = [
                Metrics::METRIC_PERFORMANCE_SCORE,
                Metrics::METRIC_LOAD_EXPERIENCE_FCP_NUMERICVALUE,
                Metrics::METRIC_LOAD_EXPERIENCE_FID_NUMERICVALUE,
                Metrics::METRIC_LOAD_EXPERIENCE_INP_NUMERICVALUE,
                Metrics::METRIC_LOAD_EXPERIENCE_LCP_NUMERICVALUE,
                Metrics::METRIC_LOAD_EXPERIENCE_CLS_NUMERICVALUE,
            ];
        }

        $this->metrics = [];
        foreach (PageSpeedApi::getAllStrategies() as $strategy) {
            foreach ($metrics as $metric) {
                $this->metrics[] = Metrics::appendStrategy($metric, $strategy);
            }
        }

        $this->processedMetrics = [];
    }

    public function getDefaultTypeViewDataTable()
    {
        return AllStrategiesTable::ID;
    }

    public function configureWidgets(WidgetsList $widgetsList, ReportWidgetFactory $factory)
    {
        parent::configureWidgets($widgetsList, $factory);

        $idSite = Common::getRequestVar('idSite', 0,'int');
        if (empty($idSite)) {
            return;
        }

        $order = 500;
        $pageUrls = new Pages();
        foreach ($pageUrls->getPageUrlsToMonitor($idSite) as $url) {

            $urlToUse = str_replace(array_keys(TrackerPageUrl::$urlPrefixMap), '', $url);
            $config = $factory->createWidget();
            $config->forceViewDataTable(Sparklines::ID);
            $config->setSubcategoryId('SEOWebVitals_SEOWebVitals');
            $config->setParameters(['label' => $urlToUse]);
            $config->setName($urlToUse);
            $config->setOrder($order++);
            $config->setIsNotWidgetizable();
            $widgetsList->addWidgetConfig($config);
        }

    }

    /**
     * Here you can configure how your report should be displayed. For instance whether your report supports a search
     * etc. You can also change the default request config. For instance change how many rows are displayed by default.
     *
     * @param ViewDataTable $view
     */
    public function configureView(ViewDataTable $view)
    {
        if (!empty($this->dimension)) {
            $view->config->addTranslations(array('label' => $this->dimension->getName()));
        }

        $idSite = Common::getRequestVar('idSite');

        $view->config->show_bar_chart = false;
        $view->config->show_pie_chart = false;
        $view->config->show_all_views_icons = false;
        $view->config->show_tag_cloud = false;
        $view->config->show_table_all_columns = false;
        $view->config->show_insights = false;
        $view->config->show_flatten_table = false;
        $view->config->show_exclude_low_population = false;
        $view->config->show_table = false;

        $youCanConfigureMessage = Piwik::translate('SEOWebVitals_YouCanConfigure', ['<a class="editwebsitesettings" href="index.php' . Url::getCurrentQueryStringWithParametersModified(['module' => 'SitesManager', 'action' => 'index']) . '#/editsiteid='.(int)$idSite.'">', '</a>', '"' . Piwik::translate('SEOWebVitals_UrlsMonitorFieldTitle') . '"']);

        $isDesktopView = $view->isViewDataTableId(DesktopStrategyTable::ID);
        $isMobileView = $view->isViewDataTableId(MobileStrategyTable::ID);

        if ($view->isViewDataTableId(Sparklines::ID)) {
            $view->config->addSparklineMetric(array(Metrics::appendStrategy(Metrics::METRIC_PERFORMANCE_SCORE, PageSpeedApi::STRATEGY_MOBILE)), $order = 10);
            $view->config->addSparklineMetric(array(Metrics::appendStrategy(Metrics::METRIC_PERFORMANCE_SCORE, PageSpeedApi::STRATEGY_DESKTOP)), $order = 15);
            return;
        }

        $metricsToKeep = [];
        foreach ($this->metrics as $metric) {
            if ($isDesktopView) {
                if (Metrics::isStrategyMetric($metric,  PageSpeedApi::STRATEGY_DESKTOP)) {
                    $metricsToKeep[] = $metric;
                }
            } elseif ($isMobileView) {
                if (Metrics::isStrategyMetric($metric,  PageSpeedApi::STRATEGY_MOBILE)) {
                    $metricsToKeep[] = $metric;
                }
            } else {
                $metricsToKeep[] = $metric;
            }
        }
        $this->metrics = $metricsToKeep;

        $view->requestConfig->filter_limit = '-1';
        $view->requestConfig->filter_offset = 0;
        $view->config->show_pagination_control = false;
        $view->config->show_limit_control = false;
        $view->config->show_offset_information = false;

        if ($view->isViewDataTableId(HtmlTable::ID)) {
            /** @var HtmlTable $view */
            $view->config->show_totals_row = false;
        }

        $view->requestConfig->totals = 0;

        $idSubtable = Common::getRequestVar('idSubtable', 0, 'int');
        if ($idSubtable) {
            $view->config->tooltip_metadata_name = 'audit_description';

            $view->config->filters[] = function (DataTable $table) {
                $strategies = PageSpeedApi::getAllStrategies();
                foreach ($table->getRows() as $row) {
                    foreach ($strategies as $strategy) {
                        $scoreColumn = Metrics::appendStrategy(Metrics::METRIC_AUDIT_SCORE, $strategy);
                        $score = $row->getColumn($scoreColumn);
                        if ($score || $score === 0 || $score === '0') {
                            $score .= '%';
                        }
                        $row->setColumn($scoreColumn, $score);
                    }
                }
            };
        } else {
            $view->config->tooltip_metadata_name = 'url';
            $view->config->filters[] = function (DataTable $table) use ($view, $idSite, $youCanConfigureMessage) {
                if (!$table->getRowsCount()) {
                    $pageSpeedApi = StaticContainer::get(PageSpeedApi::class);
                    $sites = new Pages();
                    $view->config->no_data_message = Piwik::translate('CoreHome_ThereIsNoDataForThisReport');
                    $view->config->no_data_message .= ' ';

                    if (!$pageSpeedApi->hasApiKeyConfigured()) {
                        if (Piwik::hasUserSuperUserAccess()) {
                            $view->config->no_data_message .= Piwik::translate('SEOWebVitals_RequiredAPIkeySuperUser', ['<strong>', '<a class="configureApiKeyWebVitals" href="index.php' . Url::getCurrentQueryStringWithParametersModified(['module' => 'CoreAdminHome', 'action' => 'generalSettings']) . '#/SEOWebVitals">', '</a>', '</strong>']);
                        } else {
                            $view->config->no_data_message .= Piwik::translate('SEOWebVitals_RequiredAPIkey', ['<strong>', '</strong>']);
                        }
                    } elseif (!$sites->getPageUrlsToMonitor($idSite)) {
                        $view->config->no_data_message .= Piwik::translate('SEOWebVitals_NoURLsConfigured');
                        $view->config->no_data_message .= ' ';
                        if (Piwik::isUserHasAdminAccess($idSite)) {
                            $trackerModel = new TrackerModel();
                            if (!$trackerModel->isSiteEmpty($idSite)) {
                                // only show if there is traffic... technically should only show if traffic was there recently
                                $view->config->no_data_message .= Piwik::translate('SEOWebVitals_ClickToConfigure5popular', ['<a onclick="SEOWebVitals.setupUrls()" id="seowebvitals-setup-urls">', '</a>']);
                                $view->config->no_data_message .= Piwik::translate('SEOWebVitals_Working', ['<span id="seowebvitals-working" style="display:none;">&nbsp;', '</span>']);
                                $view->config->no_data_message .= Piwik::translate('SEOWebVitals_Done', ['<span id="seowebvitals-success" style="display:none;">', '</span>']);
                                $view->config->no_data_message .= Piwik::translate('SEOWebVitals_Reload', ['<a id="seowebvitals-reload" onclick="SEOWebVitals.reloadPage()" style="display:none;">&nbsp;', '</a>']);
                                $view->config->no_data_message .= ' ';
                            };
                            $view->config->no_data_message .= $youCanConfigureMessage;
                        } else {
                            $view->config->no_data_message .=  Piwik::translate('SEOWebVitals_PleaseAskAdmin');
                        }
                    } else {
                        $view->config->no_data_message .= Piwik::translate('SEOWebVitals_DateBeforeConfigured');

                        $period = $table->getMetadata('period');
                        if (!empty($period) && is_object($period) && $period instanceof Period && $idSite) {
                            $timezone = Site::getTimezoneFor($idSite);
                            $today = Date::factoryInTimezone('today', $timezone);
                            $includesToday = $period->isDateInPeriod($today);
                            if ($includesToday) {
                                $view->config->no_data_message .= ' ' . Piwik::translate('SEOWebVitals_DateTodayConfigured');
                            }

                        }

                    }

                    if (!SettingsPiwik::isInternetEnabled()) {
                        $view->config->no_data_message .= '<br><br><strong>' . Piwik::translate('SEOWebVitals_DiagnosticInternetDisabledComment');
                        $view->config->no_data_message .= ' ' . Piwik::translate('SEOWebVitals_DiagnosticInternetDisabledComment2') . '</strong>';
                    }

                } else {

                    if ($view->isViewDataTableId(HtmlTable::ID)) {
                        $view->config->show_header_message = '<div class="alert alert-info inp-banner-alert">' . Piwik::translate('SEOWebVitals_INPBannerDescriptionPastDeadline', ['<b>', '</b>', '<a href="https://web.dev/blog/inp-cwv" target="_blank" rel="noreferrer nopener">', '</a>']) . '</div>';
                        $view->config->show_footer_message .= '<br><br>';
                        $view->config->show_footer_message .= Piwik::translate('SEOWebVitals_AllScoresAreCalculated', ['', '']);

                        if (!Common::getRequestVar('segment', '', 'string')
                            && Rules::isBrowserTriggerEnabled()
                            && Piwik::hasUserSuperUserAccess()) {
                            $view->config->show_footer_message .= '<br><br>';
                            $view->config->show_footer_message .= Piwik::translate('SEOWebVitals_DiagnosticReportPerformanceComment', ['<a href="' . Url::addCampaignParametersToMatomoLink('https://matomo.org/faq/on-premise/how-to-set-up-auto-archiving-of-your-reports/') . '" rel="noreferrer noopener" target="_blank">', '</a>']);
                        }
                    }

                    $formatter = StaticContainer::get(Formatter::class);
                    $strategies = PageSpeedApi::getAllStrategies();
                    foreach ($table->getRows() as $row) {
                        foreach ($strategies as $strategy) {
                            foreach (Metrics::TOP_LEVEL_NUMERIC_CATEGORY_MAPPING as $metric => $category) {
                                //TODO ideally this was in a processed metric
                                $columnDisplayValue = Metrics::appendStrategy($metric, $strategy);
                                $displayValue = $row->getColumn($columnDisplayValue);
                                if ($metric !== Metrics::METRIC_LOAD_EXPERIENCE_CLS_NUMERICVALUE) {
                                    if ($metric === Metrics::METRIC_LOAD_EXPERIENCE_FID_NUMERICVALUE) {
                                        $displayValue = empty($displayValue) ? "-" : Piwik::translate('SEOWebVitals_NbMilliseconds', $displayValue);
                                    } else if ($metric === Metrics::METRIC_LOAD_EXPERIENCE_INP_NUMERICVALUE) {
                                        $displayValue = Piwik::translate('SEOWebVitals_NbMilliseconds', $displayValue);
                                    } else {
                                        $displayValue = $displayValue / 1000;
                                        $displayValue = round($displayValue, 2);
                                        $displayValue = $formatter->getPrettyTimeFromSeconds($displayValue, true);
                                    }
                                }
                                $summary = $displayValue;
                                $row->setColumn($columnDisplayValue, $summary);
                            }
                        }
                    }

                }
            };
        }

        $view->config->columns_to_display = array_merge(array('label'), $this->metrics);

        $view->config->show_footer_message = '';

        if ($idSubtable) {
            $view->config->show_footer_message .= Piwik::translate('SEOWebVitals_DataIsEstimated');

            if (Common::getRequestVar('period', '', 'string') !== 'day') {
                $view->config->show_footer_message .= '<br><br>';
                $view->config->show_footer_message .= Piwik::translate('SEOWebVitals_InformationColumnRemoved');
            }
        } else {
            if (Piwik::isUserHasAdminAccess($idSite)) {
                $view->config->show_footer_message .= $youCanConfigureMessage;

            } else {
                $view->config->show_footer_message .= Piwik::translate('SEOWebVitals_ToMonitoreMoreAskAdmin');
            }

            if (Common::getRequestVar('segment', '', 'string')) {
                $view->config->show_footer_message .= '<br><br>';
                $view->config->show_footer_message .= Piwik::translate('SEOWebVitals_ReportNotSupportSegmentation', ['<strong>', '</strong>']);
            }
        }

    }
}
