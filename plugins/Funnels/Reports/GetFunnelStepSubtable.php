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

namespace Piwik\Plugins\Funnels\Reports;

use Piwik\Piwik;
use Piwik\Plugin\Report;
use Piwik\Plugin\ViewDataTable;
use Piwik\Plugins\CoreVisualizations\Visualizations\HtmlTable;
use Piwik\Plugins\Funnels\Metrics;

class GetFunnelStepSubtable extends Report
{
    protected function init()
    {
        parent::init();

        $this->name = Piwik::translate('Funnels_EntriesAndExits');
        $this->documentation = '';
        $this->actionToLoadSubTables = 'getFunnelStepSubtable';
    }

    public function configureView(ViewDataTable $view)
    {
        $view->config->show_footer = false;
        $view->config->enable_sort = false;
        $view->config->disable_row_evolution = true;

        $view->config->addTranslation('label', Piwik::translate('Funnels_Step'));
        $view->config->addTranslation(Metrics::NUM_HITS, Piwik::translate('General_ColumnHits'));

        $view->config->datatable_js_type = 'FunnelEntryExitDataTable';
    }

    public function configureReportMetadata(&$availableReports, $infos)
    {
        if (!$this->isEnabled()) {
            return;
        }

        // reset name etc
        $this->init();
    }

    public function getDefaultTypeViewDataTable()
    {
        return HtmlTable::ID;
    }
}
