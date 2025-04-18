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

namespace Piwik\Plugins\Cohorts\Reports;

use Piwik\Piwik;
use Piwik\Plugin\Report;
use Piwik\Plugins\Cohorts\Columns\Metrics\VisitorRetentionPercent;
use Piwik\Plugins\CoreHome\Columns\Metrics\ActionsPerVisit;
use Piwik\Plugins\CoreHome\Columns\Metrics\AverageTimeOnSite;
use Piwik\Plugins\CoreHome\Columns\Metrics\BounceRate;
use Piwik\Plugins\CoreVisualizations\Visualizations\JqplotGraph\Evolution;
use Piwik\Report\ReportWidgetFactory;
use Piwik\Widget\WidgetsList;

class GetCohortsOverTime extends Report
{
    public const DEFAULT_METRIC = VisitorRetentionPercent::NAME;

    protected function init()
    {
        parent::init();

        $this->categoryId = 'General_Visitors';
        // Don't set the subcategory since we don't want this report to show in the Cohorts tab
        $this->name = Piwik::translate('Cohorts_CohortsOverTime');

        $this->processedMetrics = [
            new BounceRate(),
            new ActionsPerVisit(),
            new AverageTimeOnSite(),
        ];
        $this->metrics = GetCohorts::getAvailableCohortsMetrics($includeTemporary = false);
    }

    public function configureWidgets(WidgetsList $widgetsList, ReportWidgetFactory $factory)
    {
        $widgetsList->addWidgetConfig(
            $factory->createWidget()
                ->setName('Cohorts_EvolutionGraph')
                ->forceViewDataTable(Evolution::ID)
                ->setModule('Cohorts')
                ->setAction('getEvolutionGraph')
                ->setOrder(5)
                ->setIsWide()
        );
    }

    public function configureReportMetadata(&$availableReports, $infos)
    {
        // empty
    }
}
