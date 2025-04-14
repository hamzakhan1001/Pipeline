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

namespace Piwik\Plugins\CrashAnalytics\Archiver;

use Piwik\ArchiveProcessor\Parameters;
use Piwik\Common;
use Piwik\DataAccess\LogAggregator as MatomoLogAggregator;
use Piwik\Period\Factory;
use Piwik\Plugins\CrashAnalytics\Dao\LogCrashEvent;
use Piwik\Plugins\CrashAnalytics\MeasurableSettings;
use Piwik\Plugins\CrashAnalytics\Metrics;
use Piwik\RankingQuery;

class LogAggregator
{
    /**
     * @var MatomoLogAggregator
     */
    private $coreLogAggregator;

    /**
     * @var Parameters
     */
    private $params;

    public function __construct(MatomoLogAggregator $coreLogAggregator, Parameters $params)
    {
        $this->coreLogAggregator = $coreLogAggregator;
        $this->params = $params;
    }

    public function getMetricAggregationSql()
    {
        return [
            Metrics::CRASH_OCCURRENCES => 'count(log_crash_event.idlogcrashevent)',
            Metrics::UNIQUE_CRASHES => 'count(distinct log_crash_resolved.message)',
            Metrics::VISITS_WITH_CRASH => 'count(distinct log_crash_event.idvisit)',
            Metrics::PAGEVIEWS_WITH_CRASH => 'count(distinct log_crash_event.idpageview)',
        ];
    }

    // public for testing sql content
    public function getQueryForAggregateCrashEvents($groupBy, $extraSelects = '', $extraFrom = [], $metrics = null, $includeIgnored = false, RankingQuery $rankingQuery = null)
    {
        $from = ['log_crash_event'];
        $from = array_merge($from, $extraFrom);
        if (!$includeIgnored && !$this->doesFromContain($from, 'log_crash')) {
            $from[] = [
                'table' => 'log_crash',
                'tableAlias' => 'log_crash_original',
                'joinOn' => 'log_crash_event.idlogcrash = log_crash_original.idlogcrash',
            ];
            $from[] = [
                'table' => 'log_crash',
                'tableAlias' => 'log_crash_resolved',
                'joinOn' => 'log_crash_resolved.idlogcrash = IFNULL(log_crash_original.group_idlogcrash, log_crash_original.idlogcrash)',
            ];
        }

        $select = [];
        if (!empty($extraSelects)) {
            $select[] = $extraSelects;
        }

        if (empty($metrics)) {
            $metrics = [
                Metrics::CRASH_OCCURRENCES,
                Metrics::VISITS_WITH_CRASH,
            ];

            if ($rankingQuery) {
                $rankingQuery->addColumn(Metrics::VISITS_WITH_CRASH);
                $rankingQuery->addColumn(Metrics::CRASH_OCCURRENCES, 'sum');
            }
        }

        $orderBy = false;
        if ($rankingQuery) {
            $orderBy = Metrics::CRASH_OCCURRENCES . ' DESC, ' . $groupBy . ' ASC, log_crash_resolved.datetime_last_seen DESC';
        }

        $metricAggregationSql = $this->getMetricAggregationSql();
        $metricSql = array_map(function ($m) use ($metricAggregationSql) {
            return $metricAggregationSql[$m] . ' AS ' . $m;
        }, $metrics);
        $metricSql = implode(', ', $metricSql);

        $select[] = $metricSql;
        $select = implode(', ', $select);

        $bind = [];

        $where = $this->coreLogAggregator->getWhereStatement(LogCrashEvent::TABLE_NAME, 'server_time');
        if (!$includeIgnored) {
            $where .= ' AND log_crash_resolved.datetime_ignored_error IS NULL';
        }

        $query = $this->coreLogAggregator->generateQuery($select, $from, $where, $groupBy, $orderBy);
        if ($rankingQuery) {
            $query['sql'] = $rankingQuery->generateRankingQuery($query['sql']);
        }

        $bind = array_merge($query['bind'], $bind);
        return [$query['sql'], $bind];
    }

    public function aggregateCrashEvents($groupBy, $extraSelects = '', $extraFrom = [], $metrics = null, $includeIgnored = false, RankingQuery $rankingQuery = null)
    {
        [$sql, $bind] = $this->getQueryForAggregateCrashEvents($groupBy, $extraSelects, $extraFrom, $metrics, $includeIgnored, $rankingQuery);
        return $this->coreLogAggregator->getDb()->query($sql, $bind);
    }

    public function getIgnoredCrashCount()
    {
        $sql = 'SELECT COUNT(idlogcrash) AS ' . Metrics::IGNORED_CRASHES . ' FROM ' . Common::prefixTable('log_crash')
            . ' WHERE datetime_ignored_error <= ?';
        return $this->coreLogAggregator->getDb()->fetchOne($sql, [$this->params->getDateTimeEnd()->getDatetime()]);
    }

    public function getDb()
    {
        return $this->coreLogAggregator->getDb();
    }

    public function getCoreAggregator()
    {
        return $this->coreLogAggregator;
    }

    private function doesFromContain($from, $tableName)
    {
        foreach ($from as $entry) {
            if ($entry == $tableName || (isset($entry['table']) && $entry['table'] == $tableName)) {
                return true;
            }
        }
        return false;
    }

    // public for testing sql content
    public function getQueryForDisappearedCrashes(Parameters $archiveParams)
    {
        $settings = new MeasurableSettings($archiveParams->getSite()->getId());
        $daysUntilConsideredDisappeared = $settings->daysUntilConsideredDisappeared->getValue();

        $disappearedStartTime = $archiveParams->getDateTimeStart()->subDay($daysUntilConsideredDisappeared);
        $disappearedEndTime = $archiveParams->getDateTimeEnd()->subDay($daysUntilConsideredDisappeared);

        $pastParams = new Parameters(
            $archiveParams->getSite(),
            Factory::build('day', $disappearedStartTime),
            $archiveParams->getSegment()
        );
        $pastLogAggregator = new \Piwik\DataAccess\LogAggregator($pastParams);

        // selects if the latest occurrence between N days ago and period end time is N days ago, where N
        // is the number of days that must pass before an error is considered "disappeared"/"reappeared"
        $query = $pastLogAggregator->generateQuery(
            'log_crash_resolved.idlogcrash,
            log_crash_resolved.message,
            log_crash_resolved.crash_type,
            log_crash_resolved.resource_uri',
            [
                'log_crash_event',
                [
                    'table' => 'log_crash',
                    'tableAlias' => 'log_crash_original',
                    'joinOn' => 'log_crash_event.idlogcrash = log_crash_original.idlogcrash',
                ],
                [
                    'table' => 'log_crash',
                    'tableAlias' => 'log_crash_resolved',
                    'joinOn' => 'log_crash_resolved.idlogcrash = IFNULL(log_crash_original.group_idlogcrash, log_crash_original.idlogcrash)',
                ],
                [
                    'table' => 'log_crash_group',
                    'tableAlias' => 'log_crash_group',
                    'joinOn' => 'log_crash_group.idlogcrash = log_crash_resolved.idlogcrash',
                ],
            ],
            $pastLogAggregator->getWhereStatement('log_crash_event', 'server_time') . " 
                AND log_crash_resolved.datetime_ignored_error IS NULL
                AND log_crash_group.datetime_last_seen >= '{$disappearedStartTime->getDatetime()}'
                AND log_crash_group.datetime_last_seen <= '{$disappearedEndTime->getDatetime()}'",
            'log_crash_resolved.idlogcrash',
            false
        );

        $query['sql'] = $this->decorateQueryWithSourceLocationHint($query['sql']);
        return array_values($query);
    }

    public function queryDisappearedCrashes(Parameters $archiveParams)
    {
        [$sql, $bind] = $this->getQueryForDisappearedCrashes($archiveParams);
        return $this->coreLogAggregator->getDb()->query($sql, $bind);
    }

    private function decorateQueryWithSourceLocationHint($sql)
    {
        $sql = preg_replace('/SELECT\s+\/\*/i', 'SELECT /* ' . $this->coreLogAggregator->getQueryOriginHint() . ' */ /*', $sql, 1);
        return $sql;
    }
}
