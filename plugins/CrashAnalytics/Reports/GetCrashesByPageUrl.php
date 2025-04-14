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
use Piwik\Plugins\Actions\Columns\PageUrl;
use Piwik\Plugins\CrashAnalytics\Columns\Metrics\PageviewCrashRate;
use Piwik\Plugins\CrashAnalytics\Columns\Metrics\VisitsCrashRate;
use Piwik\Plugins\CrashAnalytics\Metrics;
use Piwik\Report\ReportWidgetFactory;
use Piwik\Widget\WidgetsList;

class GetCrashesByPageUrl extends Base
{
    protected function init()
    {
        parent::init();

        $this->dimension = new PageUrl();
        $this->metrics = [Metrics::CRASH_OCCURRENCES, Metrics::VISITS_WITH_CRASH];
        $this->name          = Piwik::translate('CrashAnalytics_CrashesByPageUrl');
        $this->documentation = Piwik::translate('CrashAnalytics_CrashesByPageUrlDocumentation');
        $this->subcategoryId = 'CrashAnalytics_AllCrashes';
        $this->actionToLoadSubTables = 'getCrashesForPageUrl';
        $this->order = 5;
        $this->processedMetrics = [
            VisitsCrashRate::METRIC_NAME,
            PageviewCrashRate::METRIC_NAME,
        ];
    }

    public function configureView(ViewDataTable $view)
    {
        parent::configureView($view);

        $view->config->columns_to_display = [
            'label',
            Metrics::CRASH_OCCURRENCES,
            PageviewCrashRate::METRIC_NAME,
            Metrics::VISITS_WITH_CRASH,
            VisitsCrashRate::METRIC_NAME,
        ];

        $this->addPageviewTooltips($view);
    }

    public function configureWidgets(WidgetsList $widgetsList, ReportWidgetFactory $factory)
    {
        $widget = $factory->createWidget();
        $widget->setSubcategoryId(Piwik::translate('CrashAnalytics_CrashesByPages'));
        $widget->setName('CrashAnalytics_PageUrl');
        $widgetsList->addToContainerWidget('Crashes', $widget);
    }
}