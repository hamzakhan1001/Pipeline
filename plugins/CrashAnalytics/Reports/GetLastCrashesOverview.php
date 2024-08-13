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

use Piwik\API\Request;
use Piwik\Common;
use Piwik\Config;
use Piwik\Piwik;
use Piwik\Plugins\CrashAnalytics\Columns\Crash;
use Piwik\Plugins\CrashAnalytics\Metrics;
use Piwik\Report\ReportWidgetFactory;
use Piwik\View;
use Piwik\Widget\WidgetsList;

class GetLastCrashesOverview extends Base
{
    protected function init()
    {
        parent::init();

        $title = Piwik::translate('CrashAnalytics_CrashOverviewLastNMinutes30');

        $lastMinutes = $this->getLastMinutes();
        if (in_array($lastMinutes, $this->getReportLastMinuteValues())) {
           if ($lastMinutes < 60) {
                $title = Piwik::translate('CrashAnalytics_CrashOverviewLastNMinutes', $lastMinutes);
            } else {
                $title = Piwik::translate('CrashAnalytics_CrashOverviewLastNHours', floor($lastMinutes / 60));
            }
        }

        $this->name = $title;

        $this->dimension = new Crash();
        $this->documentation = Piwik::translate('CrashAnalytics_LastCrashesOverviewDocumentation');
        $this->subcategoryId = 'CrashAnalytics_RealTime';
        $this->order = 140;
        $this->metrics = [
            Metrics::CRASH_OCCURRENCES,
            Metrics::VISITS_WITH_CRASH,
            Metrics::NEW_CRASHES,
            Metrics::DISAPPEARED_CRASHES,
            Metrics::REAPPEARED_CRASHES,
        ];
    }

    public function render()
    {
        $idSite = Common::getRequestVar('idSite', null, 'int');
        Piwik::checkUserHasViewAccess($idSite);

        $lastMinutes = $this->getLastMinutes();

        $overview = Request::processRequest('CrashAnalytics.getLastCrashesOverview', [
            'idSite' => $idSite,
            'lastMinutes' => $lastMinutes,
            'format_metrics' => '1',
        ]);

        $view = new View('@CrashAnalytics/getLastCrashesOverview.twig');

        if (!empty($overview)) {
            $overview = $overview->getFirstRow();
            if (!empty($overview)) {
                $overview = $overview->getColumns();
            }
        } else {
            $overview = [];
        }

        $view->is_auto_refresh = Common::getRequestVar('is_auto_refresh', 0, 'int');
        $view->lastMinutes = $lastMinutes;
        $view->overview = $overview;
        $view->liveRefreshAfterMs = (int) Config::getInstance()->General['live_widget_refresh_after_seconds'] * 1000;
        $view->title = $this->name;
        return $view->render();
    }

    private function getLastMinutes()
    {
        return Common::getRequestVar('lastMinutes', 30, 'int');
    }

    public function configureWidgets(WidgetsList $widgetsList, ReportWidgetFactory $factory)
    {
        $lastNMinutes = $this->getReportLastMinuteValues();

        foreach ($lastNMinutes as $index => $timeToAdd) {
            $config = $factory->createWidget();
            if ($timeToAdd < 60) {
                $title = Piwik::translate('CrashAnalytics_CrashOverviewLastNMinutes', $timeToAdd);
            } else {
                $title = Piwik::translate('CrashAnalytics_CrashOverviewLastNHours', floor($timeToAdd / 60));
            }
            $config->setName($title);
            $config->setParameters(array('lastMinutes' => $timeToAdd));
            $config->setOrder($this->order + $index + 1);
            $widgetsList->addWidgetConfig($config);
        }
    }
}