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

use Piwik\Plugins\Live\Visualizations\VisitorLog;

class CrashActions
{
    public function getActionsBeforeCrash($idLogCrash, $visit)
    {
        $actionsBeforeCrash = [];
        $actionGroupsBeforeCrash = [];

        $crashTimestamp = null;

        if (!empty($visit['actionGroups'])) {
            // find action group with the current crash
            $actionGroupOfCrash = 0;
            foreach ($visit['actionGroups'] as $group) {
                $actionsOnPage = $group['actionsOnPage'];

                $found = false;
                foreach ($actionsOnPage as $action) {
                    if (isset($action['crashEventId']) && $action['crashEventId'] == $idLogCrash) {
                        $crashTimestamp = $action['timestamp'];
                        $found = true;
                        break;
                    }
                }

                if ($found) {
                    break;
                }

                ++$actionGroupOfCrash;
            }

            if ($actionGroupOfCrash >= count($visit['actionGroups'])) { // not found
                return [$visit['actionDetails'], $visit['actionGroups']];
            }

            // get last N action groups up to and including crash
            $start = max(0, $actionGroupOfCrash - API::CRASH_DETAILS_NUM_ACTIONS_BEFORE_CRASH_TO_DISPLAY);
            $actionGroupsBeforeCrash = array_slice($visit['actionGroups'], $start, ($actionGroupOfCrash - $start) + 1);

            // for last action group, remove actions including and after the crash itself.
            end($actionGroupsBeforeCrash);
            $lastKey = key($actionGroupsBeforeCrash);

            $actionDetails = $actionGroupsBeforeCrash[$lastKey];
            foreach ($actionDetails as $index => $action) {
                if (isset($action['crashEventId']) && $action['crashEventId'] == $idLogCrash) {
                    unset($actionGroupsBeforeCrash[$lastKey][$index]);
                }
            }

            end($actionGroupsBeforeCrash);
            foreach (['actionsOnPage', 'refreshActions'] as $prop) {
                $actionGroupsBeforeCrash[$lastKey][$prop] = array_filter($actionGroupsBeforeCrash[$lastKey][$prop], function ($action) use ($crashTimestamp) {
                    return isset($action['timestamp']) && $action['timestamp'] <= $crashTimestamp;
                });
            }

            // re-assemble actions array
            foreach ($actionGroupsBeforeCrash as $group) {
                $flatActions = [];
                if (!empty($group['pageviewAction'])) {
                    $flatActions[] = $group['pageviewAction'];
                }
                $flatActions = array_merge(
                    $flatActions,
                    $group['actionsOnPage'] ?? [],
                    $group['refreshActions'] ?? []
                );

                usort($flatActions, function ($a, $b) {
                    $fields = array('timestamp', 'title', 'url', 'type', 'pageIdAction', 'goalId', 'timeSpent');
                    foreach ($fields as $field) {
                        $sort = VisitorLog::sortByActionsOnPageColumn($a, $b, $field);
                        if ($sort !== 0) {
                            return $sort;
                        }
                    }

                    return 0;
                });

                $actionsBeforeCrash = array_merge($actionsBeforeCrash, $flatActions);
            }
        }

        return [$actionsBeforeCrash, $actionGroupsBeforeCrash];
    }
}