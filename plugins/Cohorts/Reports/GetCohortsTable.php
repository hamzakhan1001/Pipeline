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
use Piwik\Plugin\ViewDataTable;
use Piwik\Report\ReportWidgetFactory;
use Piwik\ViewDataTable\Manager;
use Piwik\Widget\WidgetsList;

class GetCohortsTable extends GetCohorts
{
    protected function init()
    {
        parent::init();

        $this->categoryId = 'General_Visitors';
        $this->subcategoryId = 'Cohorts_Cohorts';
        $this->name = Piwik::translate('Cohorts_CohortsTable');
    }

    public function configureWidgets(WidgetsList $widgetsList, ReportWidgetFactory $factory)
    {
        // This wouldn't make sense as a Dashboard widget since it's almost a duplicate of GetCohorts
        $widgetsList->addWidgetConfig($factory->createWidget()->setIsWide()->setIsNotWidgetizable());
    }

    public function configureView(ViewDataTable $view)
    {
        parent::configureView($view);
        $view->config->show_limit_control = false;
        // Set this back to stock DataTable since we don't want the cohortsDataTable.js customisations for this table
        $view->config->datatable_js_type = 'DataTable';
    }

    /**
     * Look up the saved preferences for the new Cohorts visualisations. It's a little custom since two reports are
     * sharing preferences.
     *
     * @return array Of the saved preferences. If nothing has been saved, the defaults will be returned instead
     */
    public static function getSavedDefaultReportParameters(): array
    {
        $savedParams = Manager::getViewDataTableParameters(Piwik::getCurrentUserLogin(), 'Cohorts.getCohortsTable');
        $savedParams = !is_array($savedParams) ? [] : $savedParams;
        $savedParams['metric'] = $savedParams['metric'] ?? self::DEFAULT_METRIC;
        $savedParams['filter_limit'] = $savedParams['filter_limit'] ?? 10;

        return $savedParams;
    }
}
