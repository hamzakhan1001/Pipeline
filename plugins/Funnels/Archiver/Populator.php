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

namespace Piwik\Plugins\Funnels\Archiver;

use Piwik\Common;
use Piwik\Date;
use Piwik\Db;
use Piwik\Plugins\Funnels\Configuration;
use Piwik\Plugins\Funnels\Dao\LogTable;
use Piwik\Plugins\Funnels\Db\Pattern;
use Piwik\Plugins\Funnels\Model\FunnelsModel;
use Piwik\Tracker\Action;

class Populator
{
    /**
     * @var LogTable
     */
    private $logTable;

    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(LogTable $logTable, Configuration $configuration)
    {
        $this->logTable = $logTable;
        $this->configuration = $configuration;
    }

    public function getDb()
    {
        return Db::get();
    }

    public function deleteFunnelData($funnel, $startDateTime, $endDateTime)
    {
        if (empty($funnel['steps'])) {
            // there is no funnel when there are no steps
            return 'nosteps';
        }

        $idFunnel = (int) $funnel['idfunnel'];
        $idSite = (int) $funnel['idsite'];

        $table = $this->logTable->getPrefixedTableName();
        $tableVisit = Common::prefixTable('log_visit');

        $sql = "SELECT max(log_visit.visit_last_action_time) FROM $table log_funnel 
                        LEFT JOIN $tableVisit log_visit on log_funnel.idvisit = log_visit.idvisit
                        WHERE log_funnel.idfunnel = ? 
                              AND log_visit.idsite = ? 
                              AND log_visit.visit_last_action_time >= ?
                              AND log_visit.visit_last_action_time <= ?";

        $endDateTime = Db::fetchOne($sql, array($idFunnel, $idSite, $startDateTime, $endDateTime));

        if (empty($endDateTime)) {
            return 'no data to delete';
        }

        $deleteStartDate = Date::factory($endDateTime)->subHour(2);
        // we rearchive all visits that ended around the last archive since there might have been some ongoing visits
        // that were still on to completing a goal

        // we do not want to delete anything from a previous date
        if ($deleteStartDate->isEarlier(Date::factory($startDateTime))) {
            $deleteStartDate = Date::factory($startDateTime);
        }

        $deleteStartTime = $deleteStartDate->getDatetime();

        $table = $this->logTable->getPrefixedTableName();
        $tableVisit = Common::prefixTable('log_visit');

        $sql = "DELETE $table FROM $table 
                        LEFT JOIN $tableVisit log_visit on $table.idvisit = log_visit.idvisit
                        WHERE $table.idfunnel = ? 
                              AND log_visit.idsite = ? 
                              AND log_visit.visit_last_action_time >= ?
                              AND log_visit.visit_last_action_time <= ?";

        $bind = array($idFunnel, $idSite, $deleteStartTime, $endDateTime);
        Db::query($sql, $bind);

        return array($deleteStartTime, $endDateTime);
    }

    public function populateLogFunnel($funnel, $startDateTime, $endDateTime)
    {
        if (empty($funnel['steps'])) {
            // there is no funnel when there are no steps
            return;
        }

        $idFunnel = (int) $funnel['idfunnel'];
        $idSite = (int) $funnel['idsite'];
        $limitToProcessAtOnce = $this->configuration->getMaxRowsToPopulateAtOnce();

        $lastRequiredStepPosition = null;

        foreach ($funnel['steps'] as $step) {
            $loop = 0;
            do {
                $loop++; // prevent endless loop

                // If the step pattern is goal_equals, process that instead
                if (Pattern::TYPE_GOAL_EQUALS === $step['pattern_type']) {
                    $hasMoreVisits = $this->populateGoalStep($idSite, $idFunnel, $step['position'], $step['pattern_type'], $step['pattern'], $lastRequiredStepPosition, $startDateTime, $endDateTime, $limitToProcessAtOnce);
                    continue;
                }

                $hasMoreVisits = $this->populateStep($idSite, $idFunnel, $step['position'], $step['pattern_type'], $step['pattern'], $lastRequiredStepPosition, $startDateTime, $endDateTime, $limitToProcessAtOnce);
            } while ($hasMoreVisits && $loop < 20000);

            if ($step['required']) {
                $lastRequiredStepPosition = (int) $step['position'];
            }
        }

        // If the funnel doesn't have a goal, exit early
        if (!empty($funnel['isNonGoalFunnel'])) {
            return;
        }

        // NOW we find the ones that actually converted this goal and add a final step
        $lastStep = $funnel[FunnelsModel::KEY_FINAL_STEP_POSITION];

        $loop = 0;
        do {
            $loop++; // prevent endless loop
            $hasMoreVisits = $this->populateConversion($idSite, $idFunnel, $funnel['idgoal'], $lastStep, $lastRequiredStepPosition, $startDateTime, $endDateTime, $limitToProcessAtOnce);
        } while ($hasMoreVisits && $loop < 20000);
    }

    public function populateConversion($idSite, $idFunnel, $idGoal, $stepPosition, $lastRequiredStepPosition, $startDateTime, $endDateTime, $limitToInsertAtOnce)
    {
        $idSite = (int) $idSite;
        $idFunnel = (int) $idFunnel;
        $idGoal = (int) $idGoal;

        $visitTable = Common::prefixTable('log_visit');
        $conversionTable = Common::prefixTable('log_conversion');
        $visitActionTable = Common::prefixTable('log_link_visit_action');
        $funnelTable = $this->logTable->getPrefixedTableName();
        $limitToInsertAtOnce = (int) $limitToInsertAtOnce;

        // in theory we could start joining from log_conversion and possibly not need a join at all. Problem:
        // we need to take the same visitors into consideration as in top, because a conversion might have happened
        // on the previous day but the visit ended just after midnight.

        if (!empty($lastRequiredStepPosition)) {
            //  If a previous step was required, we make sure to only take into consideration those users
            $visitorHadEnteredFunnelQuery = $this->getSubqueryToRequireStep($idFunnel, $lastRequiredStepPosition);
        } else {
            // otherwise we take into consideration any user.
            $visitorHadEnteredFunnelQuery = '';
        }

        $sql = "SELECT lc.idvisit, 
                        lc.idlink_va, 
                        lc.idaction_url as idaction, 
                        (select lvaprev.idaction_url_ref 
                            from $visitActionTable lvaprev 
                            where lc.idlink_va = lvaprev.idlink_va 
                            limit 1) as idaction_prev,
                        null as idaction_next
                        from $visitTable lv USE INDEX (index_idsite_datetime)
                        left join $conversionTable lc on lv.idvisit = lc.idvisit 
                        WHERE $visitorHadEnteredFunnelQuery
                            lv.idsite = ? 
                            AND lv.visit_last_action_time >= ? 
                            AND lv.visit_last_action_time <= ?
                            AND lc.idgoal = ?
                            AND NOT EXISTS (SELECT 1 FROM $funnelTable lf WHERE lf.idfunnel = ? AND lf.idvisit = lv.idvisit AND lf.step_position = ?)
                        GROUP BY idvisit";

        $shouldApplyLimit = $limitToInsertAtOnce > 0;
        if ($shouldApplyLimit) {
            $sql .= " LIMIT $limitToInsertAtOnce";
        }

        $bind = array($idSite, $startDateTime, $endDateTime, $idGoal, $idFunnel, $stepPosition);

        $rows = $this->getDb()->fetchAll($sql, $bind);

        $this->logTable->bulkInsert($idSite, $idFunnel, $stepPosition, $rows);

        $hasMore = $shouldApplyLimit && !empty($rows) && count($rows) >= $limitToInsertAtOnce;

        unset($rows);
        return $hasMore;
    }

    private function getSubqueryToRequireStep($idFunnel, $lastRequiredStepPosition, $isGoalStep = false)
    {
        $subQueryRequiredStep = '';

        $visitColumn = $isGoalStep ? 'lc.idvisit' : 'lv.idvisit';

        if (!empty($lastRequiredStepPosition)) {
            $funnelTable = $this->logTable->getPrefixedTableName();
            $subQueryRequiredStep = $visitColumn . ' IN(SELECT idvisit FROM ' . $funnelTable . ' WHERE idfunnel = ' .  (int) $idFunnel . ' AND step_position = ' . (int) $lastRequiredStepPosition . ') AND';
        }

        return $subQueryRequiredStep;
    }

    public function populateStep($idSite, $idFunnel, $stepPosition, $patternType, $pattern, $lastRequiredStepPosition, $startDateTime, $endDateTime, $limitToInsertAtOnce)
    {
        $idSite = (int) $idSite;
        $idFunnel = (int) $idFunnel;
        $stepPosition = (int) $stepPosition;

        $visitTable = Common::prefixTable('log_visit');
        $actionTable = Common::prefixTable('log_action');
        $visitActionTable = Common::prefixTable('log_link_visit_action');
        $funnelTable = $this->logTable->getPrefixedTableName();
        $limitToInsertAtOnce = (int) $limitToInsertAtOnce;

        $subQueryRequiredStep = $this->getSubqueryToRequireStep($idFunnel, $lastRequiredStepPosition);

        $dbPattern = new Pattern();
        if (!$dbPattern->isValidPattern($patternType, $pattern)) {
            return false;
        }

        $pattern = $dbPattern->getMysqlQuery('la.name', $patternType, $pattern);

        $dbColInfo = $dbPattern->getActionTypeAndColumnName($patternType);
        $actionType = $dbColInfo['actionType'];
        $actionColumn = $dbColInfo['actionColumn'];
        $actionPageUrlType = (int) Action::TYPE_PAGE_URL;

        $shouldApplyLimit = $limitToInsertAtOnce > 0;
        if ($shouldApplyLimit) {
            $limit = " LIMIT $limitToInsertAtOnce";
        } else {
            $limit = '';
        }

        // idaction_url_ref = 0 when new visit
        // idaction_url_ref = null eg when there is a site search and shouldn't apply to action type url
        // lva.idaction_url_ref seems to be pretty much always a pageview because it depends on exit url
        // lvanext.idaction_url_ref seems to be always a pageview as well

        // we need to make sure it finds the first matching action for that funnel, not the last matching funnel.
        // otherwise `lva.idlink_va < lvanext.idlink_va` may result in non matching result even though there could be one
        // if we had used the first matching idaction
        $sql = "SELECT q.idvisit,
                        q.idlink_va, 
                        q.idaction_prev, 
                        q.idaction,
                        (select lvanext.idaction_url 
                            FROM $visitActionTable lvanext 
                            LEFT JOIN $actionTable lanext ON lvanext.idaction_url = lanext.idaction
                            WHERE q.idvisit = lvanext.idvisit 
                                AND lvanext.idsite = $idSite
                                AND lanext.`type` = $actionPageUrlType
                                AND (lvanext.idaction_url != q.idaction_url OR lvanext.idaction_name != q.idaction_name)
                                AND q.pageview_position < lvanext.pageview_position
                            ORDER BY lvanext.pageview_position ASC
                            LIMIT 1) as idaction_next
                        FROM (SELECT lv.idvisit,
                                    lva.idlink_va, 
                                    lva.idaction_url_ref as idaction_prev, 
                                    lva." . $actionColumn . " as idaction,
                                    lva.idaction_url,
                                    lva.idaction_name,
                                    lva.pageview_position
                                    from $visitTable lv USE INDEX (index_idsite_datetime)
                                    left join $visitActionTable lva on 
                                    lv.idvisit = lva.idvisit
                                    left join $actionTable la on 
                                    lva." . $actionColumn . " = la.idaction
                                    WHERE $subQueryRequiredStep
                                        lv.idsite = ? 
                                        AND la.type = " . $actionType . "
                                        AND lv.visit_last_action_time >= ?
                                        AND lv.visit_last_action_time <= ?
                                        AND NOT EXISTS (SELECT 1 FROM $funnelTable lf WHERE lf.idfunnel = ? AND lf.idvisit = lv.idvisit AND lf.step_position = ?)
                                        AND " . $pattern['query'] . "
                                GROUP BY idvisit $limit
                        ) q";

        $bind = array($idSite, $startDateTime, $endDateTime, $idFunnel, $stepPosition);
        $bind[] = $pattern['bind'];

        $rows = $this->getDb()->fetchAll($sql, $bind);

        $this->logTable->bulkInsert($idSite, $idFunnel, $stepPosition, $rows);

        $hasMore = $shouldApplyLimit && !empty($rows) && count($rows) >= $limitToInsertAtOnce;

        unset($rows);
        return $hasMore;
    }

    public function populateGoalStep($idSite, $idFunnel, $stepPosition, $patternType, $pattern, $lastRequiredStepPosition, $startDateTime, $endDateTime, $limitToInsertAtOnce)
    {
        $idSite = (int) $idSite;
        $idFunnel = (int) $idFunnel;
        $stepPosition = (int) $stepPosition;
        $idGoal = (int) $pattern;

        $conversionTable = Common::prefixTable('log_conversion');
        $visitActionTable = Common::prefixTable('log_link_visit_action');
        $actionTable = Common::prefixTable('log_action');
        $funnelTable = $this->logTable->getPrefixedTableName();
        $limitToInsertAtOnce = (int) $limitToInsertAtOnce;

        $subQueryRequiredStep = $this->getSubqueryToRequireStep($idFunnel, $lastRequiredStepPosition, true);

        $dbPattern = new Pattern();
        if (!$dbPattern->isValidPattern($patternType, $pattern)) {
            return false;
        }

        $actionPageUrlType = (int) Action::TYPE_PAGE_URL;

        $shouldApplyLimit = $limitToInsertAtOnce > 0;
        if ($shouldApplyLimit) {
            $limit = " LIMIT $limitToInsertAtOnce";
        } else {
            $limit = '';
        }

        // idaction_url_ref = 0 when new visit
        // idaction_url_ref = null eg when there is a site search and shouldn't apply to action type url
        // lva.idaction_url_ref seems to be pretty much always a pageview because it depends on exit url
        // lvanext.idaction_url_ref seems to be always a pageview as well

        // we need to make sure it finds the first matching action for that funnel, not the last matching funnel.
        // otherwise `lva.idlink_va < lvanext.idlink_va` may result in non matching result even though there could be one
        // if we had used the first matching idaction
        $sql = "SELECT q.idvisit,
                        q.idlink_va, 
                        q.idaction_prev, 
                        q.idaction,
                        (SELECT lvanext.idaction_url 
                            FROM $visitActionTable lvanext 
                            LEFT JOIN $actionTable lanext ON lvanext.idaction_url = lanext.idaction
                            WHERE q.idvisit = lvanext.idvisit 
                                AND lvanext.idsite = $idSite
                                AND lanext.`type` = $actionPageUrlType
                                AND (lvanext.idaction_url != q.idaction_url OR lvanext.idaction_name != q.idaction_name)
                                AND q.pageview_position < lvanext.pageview_position
                            ORDER BY lvanext.pageview_position ASC
                            LIMIT 1) AS idaction_next
                        FROM (SELECT lc.idvisit,
                                    lva.idlink_va, 
                                    lva.idaction_url AS idaction_prev, 
                                    NULL AS idaction,
                                    lva.idaction_url,
                                    lva.idaction_name,
                                    lva.pageview_position
                                    FROM $conversionTable AS lc USE INDEX (index_idsite_datetime)
                                    LEFT JOIN $visitActionTable lva ON lc.idvisit = lva.idvisit
                                    WHERE $subQueryRequiredStep
                                        lc.idsite = ? 
                                        AND lc.idgoal = ?
                                        AND lc.server_time >= ?
                                        AND lc.server_time <= ?
                                        AND NOT EXISTS (SELECT 1 FROM $funnelTable lf WHERE lf.idfunnel = ? AND lf.idvisit = lc.idvisit AND lf.step_position = ?)
                                GROUP BY idvisit $limit
                        ) q";

        $bind = array($idSite, $idGoal, $startDateTime, $endDateTime, $idFunnel, $stepPosition);

        $rows = $this->getDb()->fetchAll($sql, $bind);

        $this->logTable->bulkInsert($idSite, $idFunnel, $stepPosition, $rows);

        $hasMore = $shouldApplyLimit && !empty($rows) && count($rows) >= $limitToInsertAtOnce;

        unset($rows);
        return $hasMore;
    }

    public function updateEntryAndExitStep($idSite, $idFunnel, $startDateTime, $endDateTime)
    {
        $idSite = (int) $idSite;
        $idFunnel = (int) $idFunnel;

        $table = $this->logTable->getPrefixedTableName();
        $tableVisit = Common::prefixTable('log_visit');

        $sql = "UPDATE $table AS log_funnel
                 INNER JOIN (SELECT inner_funnel.idvisit, min(step_position) as minstep, max(step_position) as maxstep 
                        FROM $tableVisit log_visit  USE INDEX (index_idsite_datetime)
                        LEFT JOIN $table inner_funnel on inner_funnel.idvisit = log_visit.idvisit
                        WHERE inner_funnel.idfunnel = ? 
                              AND log_visit.idsite = ? 
                              AND log_visit.visit_last_action_time >= ?
                              AND log_visit.visit_last_action_time <= ?
                        GROUP BY log_visit.idvisit) lf
                  SET log_funnel.min_step = lf.minstep, log_funnel.max_step = lf.maxstep 
                  WHERE log_funnel.idvisit = lf.idvisit
                        AND log_funnel.idfunnel = ? 
                        AND (log_funnel.min_step != lf.minstep
                        OR log_funnel.max_step != lf.maxstep)";

        $bind = array($idFunnel, $idSite, $startDateTime, $endDateTime, $idFunnel);
        Db::query($sql, $bind);
    }
}
