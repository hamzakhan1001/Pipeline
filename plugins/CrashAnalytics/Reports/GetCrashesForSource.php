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
use Piwik\Plugins\CrashAnalytics\Metrics;

class GetCrashesForSource extends Base
{
    protected function init()
    {
        parent::init();

        $this->dimension = new Crash();
        $this->metrics = [Metrics::CRASH_OCCURRENCES, Metrics::VISITS_WITH_CRASH];
        $this->name          = Piwik::translate('CrashAnalytics_CrashesBySourceSubtable');
        $this->documentation = Piwik::translate('CrashAnalytics_CrashesBySourceSubtableDocumentation');
        $this->isSubtableReport = true;
        if (property_exists($this, 'rowIdentifier')) {
            $this->rowIdentifier = 'idlogcrash';
        }
    }

    public function configureView(ViewDataTable $view)
    {
        parent::configureView($view);

        $this->setColumnsToDisplayWithMetadata($view);
        $view->config->columns_to_display = array_filter($view->config->columns_to_display, function ($c) {
            return $c != 'crash_source';
        });

        $this->formatFirstLastSeen($view);
    }
}