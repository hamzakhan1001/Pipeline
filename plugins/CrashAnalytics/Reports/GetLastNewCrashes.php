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

use Piwik\Common;
use Piwik\Config;
use Piwik\DataTable;
use Piwik\Piwik;
use Piwik\Plugin\ViewDataTable;
use Piwik\Plugins\CoreVisualizations\Visualizations\HtmlTable;
use Piwik\Plugins\CrashAnalytics\Columns\Crash;
use Piwik\Plugins\CrashAnalytics\Metrics;
use Piwik\Report\ReportWidgetFactory;
use Piwik\Widget\WidgetsList;

class GetLastNewCrashes extends Base
{
    protected function init()
    {
        parent::init();

        $this->name = Piwik::translate('CrashAnalytics_LastNewCrashes');
        $this->dimension = new Crash();
        $this->documentation = Piwik::translate('CrashAnalytics_LastNewCrashesDocumentation');
        $this->subcategoryId = 'CrashAnalytics_RealTime';
        $this->order = 160;
        $this->metrics = [
            Metrics::CRASH_OCCURRENCES,
        ];
    }

    public function configureView(ViewDataTable $view)
    {
        parent::configureView($view);

        // realtime reports are not in API metadata so we have to add documentation manually here
        $view->config->metrics_documentation[Metrics::CRASH_OCCURRENCES] = Piwik::translate('CrashAnalytics_CrashOccurrencesDocumentation');
        $view->config->metrics_documentation[Metrics::VISITS_WITH_CRASH] = Piwik::translate('CrashAnalytics_VisitsWithCrashDocumentation');

        $this->setDatetimeTooltipsForLastCrashesReport($view);

        $lastMinutes = Common::getRequestVar('lastMinutes', 30, 'int');
        $filterLimit = Common::getRequestVar('filter_limit', 5, 'int');

        $view->requestConfig->request_parameters_to_modify['lastMinutes'] = $lastMinutes;
        $view->requestConfig->filter_limit = $filterLimit;
        $view->config->custom_parameters['lastMinutes'] = $lastMinutes;
        $view->config->custom_parameters['updateInterval'] = (int) Config::getInstance()->General['live_widget_refresh_after_seconds'] * 1000;
        if ($view->config->custom_parameters['updateInterval'] < 2000) {
            $view->config->custom_parameters['updateInterval'] = 2000; // we want at least 2 seconds interval
        }

        if ($view->isViewDataTableId(HtmlTable::ID)) {
            $view->config->disable_row_evolution = true;
        }

        $view->config->columns_to_display = ['label', 'crash_source', 'crash_first_seen', Metrics::CRASH_OCCURRENCES];

        $view->requestConfig->filter_sort_column = 'crash_first_seen';
        $view->requestConfig->filter_sort_order = 'desc';

        $view->config->filters[] = array(function (DataTable $dataTable) {
            // we have to disable the filter as it otherwise seems to not sort correctly
            $dataTable->disableFilter('Sort');
        }, $parameters = array(), $priority = true);

        $view->config->datatable_js_type = 'LiveCrashDataTable';
        $view->config->show_tag_cloud = false;
        $view->config->show_insights = false;
        $view->config->show_bar_chart = false;
        $view->config->show_pie_chart = false;
        $view->config->show_exclude_low_population = false;
        $view->config->show_search = false;
        $view->config->show_pagination_control = false;
        $view->config->show_offset_information = false;
        $view->config->enable_sort = false;
        $view->config->show_flatten_table = false;
        $view->config->show_table_all_columns = false;
        $view->config->show_table = false;
        $view->config->show_footer_icons = false;
    }

    public function configureWidgets(WidgetsList $widgetsList, ReportWidgetFactory $factory)
    {
        $lastNMinutes = $this->getReportLastCrashesMinuteValues();

        foreach ($lastNMinutes as $index => $timeToAdd) {
            $config = $factory->createWidget();
            if ($timeToAdd < 60) {
                $config->setName(Piwik::translate('CrashAnalytics_NewCrashesLastNMinutes', $timeToAdd));
            } else {
                $config->setName(Piwik::translate('CrashAnalytics_NewCrashesLastNHours', floor($timeToAdd / 60)));
            }
            $config->setParameters(array('lastMinutes' => $timeToAdd));
            $config->setOrder($this->order + $index + 1);
            $widgetsList->addWidgetConfig($config);
        }
    }
}