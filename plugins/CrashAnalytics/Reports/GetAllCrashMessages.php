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
use Piwik\Plugin\ReportsProvider;
use Piwik\Report\ReportWidgetFactory;
use Piwik\Widget\WidgetsList;

class GetAllCrashMessages extends GetCrashMessages
{
    protected function init()
    {
        parent::init();

        $this->name = Piwik::translate('CrashAnalytics_AllCrashMessages');
        $this->documentation = Piwik::translate('CrashAnalytics_AllCrashMessagesDocumentation');
        $this->order = 11;
    }

    public function getRelatedReports()
    {
        return [
            ReportsProvider::factory('CrashAnalytics', 'getCrashMessages'),
            ReportsProvider::factory('CrashAnalytics', 'getUnidentifiedCrashMessages'),
        ];
    }
}