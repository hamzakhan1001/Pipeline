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
use Piwik\Plugins\CrashAnalytics\Columns\Crash;
use Piwik\Plugins\CrashAnalytics\Columns\Metrics\VisitsCrashRate;
use Piwik\Plugins\CrashAnalytics\Metrics;
use Piwik\Report\ReportWidgetFactory;
use Piwik\Widget\WidgetsList;

class GetReappearedCrashes extends Base
{
    protected function init()
    {
        parent::init();

        $this->dimension = new Crash();
        $this->metrics = [Metrics::CRASH_OCCURRENCES, Metrics::VISITS_WITH_CRASH];
        $this->name          = Piwik::translate('CrashAnalytics_ReappearedCrashesReport');
        $this->documentation = Piwik::translate('CrashAnalytics_ReappearedCrashesDocumentation');
        $this->subcategoryId = 'CrashAnalytics_Overview';
        $this->order = 40;
        $this->processedMetrics = [
            VisitsCrashRate::METRIC_NAME,
        ];
        if (property_exists($this, 'rowIdentifier')) {
            $this->rowIdentifier = 'idlogcrash';
        }
    }

    public function configureView(ViewDataTable $view)
    {
        parent::configureView($view);

        $this->setColumnsToDisplayWithMetadata($view);
        $this->formatFirstLastSeen($view);
    }

    public function configureWidgets(WidgetsList $widgetsList, ReportWidgetFactory $factory)
    {
        $widget = $factory->createWidget();
        $widget->setSubcategoryId(Piwik::translate('CrashAnalytics_CrashesBy'));
        $widget->setName(Piwik::translate('CrashAnalytics_Reappeared'));
        $widgetsList->addToContainerWidget('Crashes', $widget);

        $widget = $factory->createWidget();
        $widget->setIsWide();
        $widgetsList->addWidgetConfig($widget);
    }
}