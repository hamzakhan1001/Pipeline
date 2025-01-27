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
use Piwik\Plugins\Cohorts\Visualizations\CohortsLineChart;
use Piwik\Report\ReportWidgetFactory;
use Piwik\Widget\WidgetsList;

class GetCohortsChart extends GetCohortsOverTime
{
    public const MAX_FILTER_LIMIT = 30;
    public const ALLOWED_FILTER_LIMITS = [5,10,15,20,25,30];

    protected function init()
    {
        parent::init();

        $this->categoryId = 'General_Visitors';
        $this->subcategoryId = 'Cohorts_Cohorts';
        $this->name = Piwik::translate('Cohorts_CohortsChart');

        // We don't want clicking on a period to do anything since they don't correspond to dates like evolution charts
        $this->parameters['disableLink'] = 1;
    }

    public function configureWidgets(WidgetsList $widgetsList, ReportWidgetFactory $factory)
    {
        // These widgets are intentionally not available in the Dashboard, since that wouldn't make sense
        $widgetsList->addWidgetConfig(
            $factory->createWidget()
                ->setName('')
                ->setModule('Cohorts')
                ->setAction('index')
                ->setOrder(3)
                ->setIsWide()
        );

        $widgetsList->addWidgetConfig(
            $factory->createWidget()
                ->forceViewDataTable(CohortsLineChart::ID)
                ->setModule('Cohorts')
                ->setAction('getCohortsChart')
                ->setOrder(5)
                ->setIsWide()
                ->setIsNotWidgetizable()
        );
    }
}
