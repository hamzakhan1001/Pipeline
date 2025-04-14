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

namespace Piwik\Plugins\CrashAnalytics;

use Piwik\Common;
use Piwik\Config;
use Piwik\Container\StaticContainer;
use Piwik\Piwik;
use Piwik\Plugins\CrashAnalytics\Dao\LogCrashEvent;
use Piwik\Plugins\Live\VisitorDetailsAbstract;
use Piwik\View;

class VisitorDetails extends VisitorDetailsAbstract
{
    const CRASH_TYPE = 'crash';

    protected $crashes = [];

    /**
     * @var LogCrashEvent
     */
    private $logCrashEvent;

    public function __construct()
    {
        $this->logCrashEvent = StaticContainer::get(LogCrashEvent::class);
    }

    public function extendVisitorDetails(&$visitor)
    {
        if (!array_key_exists($visitor['idVisit'], $this->crashes)) {
            $this->queryCrashesForVisitIds([$visitor['idVisit']]);
        }

        $visitor['crashes'] = isset($this->crashes[$visitor['idVisit']]) ? $this->crashes[$visitor['idVisit']] : 0;
    }

    public function provideActionsForVisitIds(&$actions, $visitIds)
    {
        $crashDetails = $this->queryCrashesForVisitIds($visitIds);

        // use while / array_shift combination instead of foreach to save memory
        while (is_array($crashDetails) && count($crashDetails)) {
            $action = array_shift($crashDetails);
            $idVisit = $action['idvisit'];
            unset($action['idvisit']);
            $actions[$idVisit][] = $action;
        }
    }

    public function renderAction($action, $previousAction, $visitorDetails)
    {
        if ($action['type'] != self::CRASH_TYPE) {
            return;
        }

        $view = new View('@CrashAnalytics/_actionCrash');
        $view->action = $action;
        $view->previousAction = $previousAction;
        $view->visitInfo = $visitorDetails;
        $view->isWidgetized = Common::getRequestVar('widget', 0, 'int');
        return $view->render();
    }

    public function renderActionTooltip($action, $visitInfo)
    {
        if ($action['type'] != self::CRASH_TYPE) {
            return [];
        }

        $view = new View('@CrashAnalytics/_actionTooltip');
        $view->action = $action;
        return [[150, $view->render()]];
    }

    private function queryCrashesForVisitIds($idVisits)
    {
        $limit = (int)Config::getInstance()->General['visitor_log_maximum_actions_per_visit'] * count($idVisits);

        $crashRows = $this->logCrashEvent->getCrashesForVisits($idVisits, $limit);

        $crashes = [];
        foreach ($crashRows as $row) {
            $crashes[] = [
                'idvisit' => $row['idvisit'],
                'type' => self::CRASH_TYPE,
                'icon' => 'plugins/CrashAnalytics/images/crash.png',
                'idpageview' => $row['idpageview'],
                'title' => Piwik::translate('CrashAnalytics_Error') . ': ' . $row['message'],
                'serverTimePretty' => $row['server_time'], // will be overwritten by server_time of action later

                // data from log_crash_event
                'crashEventId' => $row['idlogcrashevent'],
                'crashId' => $row['idlogcrash'],
                'resourceLine' => $row['resource_line'],
                'resourceColumn' => $row['resource_column'],
                'stackTrace' => $row['stack_trace'],
                'category' => $row['category'],

                // data from log_crash
                'crashType' => $row['crash_type'],
                'message' => $row['message'],
                'resourceUri' => $row['resource_uri'],
                'datetimeOccurredFirst' => $row['datetime_first_seen'],
                'datetimeIgnoredError' => $row['datetime_ignored_error'],
                'datetimeLastSeen' => $row['datetime_last_seen'],
                'datetimeLastReappeared' => $row['datetime_last_reappeared'],
            ];
        }
        return $crashes;
    }
}