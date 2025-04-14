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

use Piwik\Piwik;
use Piwik\Plugin\ViewDataTable;
use Piwik\Plugins\CoreVisualizations\Visualizations\Graph;
use Piwik\Plugins\CoreVisualizations\Visualizations\HtmlTable;
use Piwik\Plugins\CrashAnalytics\Columns\Crash;
use Piwik\Plugins\CrashAnalytics\Metrics;
use Piwik\Report\ReportWidgetFactory;
use Piwik\Widget\WidgetsList;

class GetDisappearedCrashes extends Base
{
    protected function init()
    {
        parent::init();

        $this->dimension = new Crash();
        $this->metrics = [Metrics::CRASH_OCCURRENCES, Metrics::VISITS_WITH_CRASH];
        $this->name = Piwik::translate('CrashAnalytics_DisappearedCrashesReport');
        $this->documentation = Piwik::translate('CrashAnalytics_DisappearedCrashesDocumentation');
        $this->subcategoryId = 'CrashAnalytics_Overview';
        $this->defaultSortColumn = 'label';
        $this->order = 45;
        if (property_exists($this, 'rowIdentifier')) {
            $this->rowIdentifier = 'idlogcrash';
        }
    }

    public function configureView(ViewDataTable $view)
    {
        parent::configureView($view);

        $view->config->columns_to_display = [
            'label',
            'crash_type',
            'crash_source',
            'crash_first_seen',
            'crash_last_seen',
        ];
        $this->formatFirstLastSeen($view);

        if ($view instanceof HtmlTable) {
            $view->config->show_totals_row = false;
            $view->config->show_exclude_low_population = false;
            $view->config->show_insights = false;
            $view->config->show_table_all_columns = false;
            $view->config->show_bar_chart = false;
            $view->config->show_pie_chart = false;
            $view->config->show_tag_cloud = false;
        }
    }

    public function configureWidgets(WidgetsList $widgetsList, ReportWidgetFactory $factory)
    {
        $widget = $factory->createWidget();
        $widget->setSubcategoryId(Piwik::translate('CrashAnalytics_CrashesBy'));
        $widget->setName(Piwik::translate('CrashAnalytics_Disappeared'));
        $widgetsList->addToContainerWidget('Crashes', $widget);

        $widget = $factory->createWidget();
        $widget->setIsWide();
        $widgetsList->addWidgetConfig($widget);
    }
}