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

namespace Piwik\Plugins\CrashAnalytics\Dao;

use Piwik\Common;
use Piwik\Config;
use Piwik\Date;
use Piwik\Db;
use Piwik\DbHelper;
use Piwik\Piwik;
use Piwik\Plugins\CrashAnalytics\MeasurableSettings;
use Piwik\Plugins\CrashAnalytics\Metrics;
use Piwik\Plugins\Live\Model;
use Piwik\Site;
use Piwik\Tracker\PageUrl;

class LogCrashEvent
{
    const TABLE_NAME = 'log_crash_event';
    const CATEGORY_MAX_LENGTH = 100;

    const TYPE_ACTION_RESOURCE_URI = 90;

    /**
     * @var Db|Db\AdapterInterface|\Piwik\Tracker\Db
     */
    private $db;

    /**
     * @var LogCrashStack
     */
    private $logCrashStack;

    /**
     * for tests
     *
     * @var bool
     */
    public $forceSleepInGetLogCrashEvents = false;

    public function __construct(LogCrashStack $logCrashStack)
    {
        $this->logCrashStack = $logCrashStack;
    }

    private function getDb()
    {
        if (!isset($this->db)) {
            $this->db = Db::get();
        }
        return $this->db;
    }

    private function getDbReader()
    {
        return Db::getReader();
    }

    public function install()
    {
        $categoryMaxLength = self::CATEGORY_MAX_LENGTH;

        DbHelper::createTable(self::TABLE_NAME, "
            `idlogcrashevent` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `idsite` INT UNSIGNED NOT NULL,
            `idvisit` BIGINT(10) UNSIGNED NOT NULL,
            `idvisitor` BINARY(8) NOT NULL,
            `idlogcrash` BIGINT UNSIGNED NOT NULL,
            `idlogcrashstack` BIGINT UNSIGNED NULL,
            `idaction_resource_uri` INTEGER(10) UNSIGNED NULL,
            `resource_line` INT UNSIGNED NULL,
            `resource_column` INT UNSIGNED NULL,
            `server_time` DATETIME NOT NULL,
            `created_time` DATETIME NOT NULL,
            `idpageview` CHAR(6) NULL DEFAULT NULL,
            `idaction_url` INTEGER UNSIGNED NULL,
            `idaction_name` INTEGER UNSIGNED NULL,
            `prev_last_seen` DATETIME NULL,
            `category` VARCHAR($categoryMaxLength) NOT NULL DEFAULT '',
            PRIMARY KEY (`idlogcrashevent`),
            INDEX idlogcrash (`idlogcrash`),
            INDEX idlogcrashstack (`idlogcrashstack`),
            INDEX idsiteservertime (`idsite`, `server_time`),
            INDEX idvisit (`idvisit`)
        ");
    }

    public function uninstall()
    {
        Db::query(sprintf('DROP TABLE IF EXISTS `%s`', Common::prefixTable(self::TABLE_NAME)));
    }

    public function record($parameters)
    {
        $stack = $parameters['stack'] ?? null;

        $idCrashStack = null;
        if ($stack) {
            $idCrashStack = $this->logCrashStack->record($stack);
        }

        $category = trim(mb_strtolower($parameters['category'] ?? ''));
        $category = mb_substr($category, 0, self::CATEGORY_MAX_LENGTH);

        $values = [
            'idsite' => (int)$parameters['idsite'],
            'idvisit' => (int)$parameters['idvisit'],
            'idvisitor' => $parameters['idvisitor'],
            'idlogcrash' => $parameters['idlogcrash'],
            'idlogcrashstack' => $idCrashStack,
            'idaction_resource_uri' => $parameters['idaction_resource_uri'] ?? null,
            'resource_line' => $parameters['resource_line'] ?? null,
            'resource_column' => $parameters['resource_column'] ?? null,
            'server_time' => $parameters['server_time'],
            'created_time' => $parameters['created_time'],
            'idpageview' => $parameters['idpageview'] ?? null,
            'idaction_url' => !empty($parameters['idaction_url']) ? $parameters['idaction_url'] : null,
            'idaction_name' => !empty($parameters['idaction_name']) ? $parameters['idaction_name'] : null,
            'prev_last_seen' => $parameters['prev_last_seen'] ?? null,
            'category' => $category,
        ];

        $columns = implode('`,`', array_keys($values));

        $placeholders = array_map(function () { return '?'; }, $values);
        $placeholders = implode(',', $placeholders);

        $sql = sprintf('INSERT INTO %s (`%s`) VALUES (%s)', Common::prefixTable(self::TABLE_NAME), $columns, $placeholders);

        $bind = array_values($values);

        $this->getDb()->query($sql, $bind);
        return $this->getDb()->lastInsertId();
    }

    public function getAllRecords()
    {
        return $this->getDb()->fetchAll('SELECT * FROM ' . Common::prefixTable(self::TABLE_NAME));
    }

    public function getLastCrashEventsInPeriod($idLogCrash, $idSite, \Piwik\Period $period, \Piwik\Segment $segment, $limit, $offset, $dateFormat = Date::DATE_FORMAT_LONG)
    {
        $where = 'log_crash_event.idsite = ? AND log_crash_event.idlogcrash = ? AND log_crash_event.server_time >= ? AND log_crash_event.server_time <= ?';

        $timezone = Site::getTimezoneFor($idSite);
        $bind = [
            $idSite,
            $idLogCrash,
            $period->getDateTimeStart()->setTimezone($timezone)->getDatetime(),
            $period->getDateTimeEnd()->setTimezone($timezone)->getDatetime(),
        ];

        $query = $segment->getSelectQuery(
            'log_crash_event.idlogcrashevent as crashEventId,
            log_crash_event.idlogcrash as crashId,
            log_crash_resolved.message,
            log_crash_resolved.crash_type as crashType,
            log_action_resource_uri.name as resourceUri,
            log_action_resource_uri.url_prefix as resourceUriUrlPrefix,
            log_crash_original.resource_uri as normalizedResourceUri,
            log_crash_event.server_time,
            log_crash_event.category,
            log_crash_event.resource_line as resourceLine,
            log_crash_event.resource_column as resourceColumn,
            log_crash_stack.value as stackTrace,
            log_crash_stack.compressed,
            log_crash_event.idvisit as idVisit,
            log_action_page_url.name as pageUrl,
            log_action_page_url.url_prefix as pageUrlPrefix',
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
                    'table' => 'log_crash_stack',
                    'joinOn' => 'log_crash_stack.idlogcrashstack = log_crash_event.idlogcrashstack',
                ],
                [
                    'table' => 'log_action',
                    'tableAlias' => 'log_action_page_url',
                    'joinOn' => 'log_action_page_url.idaction = log_crash_event.idaction_url',
                ],
                [
                    'table' => 'log_action',
                    'tableAlias' => 'log_action_resource_uri',
                    'joinOn' => 'log_action_resource_uri.idaction = log_crash_event.idaction_resource_uri',
                ],
            ],
            $where,
            $bind,
            'server_time DESC',
            false,
            $limit,
            $offset
        );

        $sql = $this->decorateQueryWithSourceLocationHint($query['sql'], __FUNCTION__);
        $result = $this->getDbReader()->fetchAll($sql, $query['bind']);
        foreach ($result as &$row) {
            if (!empty($row['compressed'])) {
                $row['stackTrace'] = $this->logCrashStack->uncompress($row['stackTrace']);
            }
            unset($row['compressed']);

            $row['crashEventId'] = (int)$row['crashEventId'];
            $row['crashId'] = (int)$row['crashId'];
            $row['idVisit'] = (int)$row['idVisit'];

            if (isset($row['resourceLine'])) {
                $row['resourceLine'] = (int)$row['resourceLine'];
            }
            if (isset($row['resourceColumn'])) {
                $row['resourceColumn'] = (int)$row['resourceColumn'];
            }

            $row['timestamp'] = strtotime($row['server_time']);
            $row['serverTimePretty'] = Date::factory($row['server_time'])->getLocalized($dateFormat);
            unset($row['server_time']);

            $row['pageUrl'] = $this->reconstructPageUrl($row['pageUrl'], $row['pageUrlPrefix'], $idSite);
            unset($row['pageUrlPrefix']);

            $row['resourceUri'] = PageUrl::reconstructNormalizedUrl($row['resourceUri'], $row['resourceUriUrlPrefix']);

            // ensure the same protocol is used in log_crash_event data as in log_crash data
            $protocolToUse = parse_url($row['normalizedResourceUri'], PHP_URL_SCHEME);
            $protocolToReplace = parse_url($row['resourceUri'], PHP_URL_SCHEME);
            $row['resourceUri'] = $protocolToUse . ($row['resourceUri'] ? substr($row['resourceUri'], ($protocolToReplace ? strlen($protocolToReplace) : 0)) : '');

            unset($row['resourceUriUrlPrefix']);
            unset($row['normalizedResourceUri']);
        }
        return $result;
    }

    public function getLastCrashes($idSite, \Piwik\Segment $segment, $lastNMinutes, $where, $limit, $orderBy, $extraBind = [])
    {
        $where = ['log_crash_event.idsite = ?', 'log_crash_event.server_time >= ?', 'log_crash_resolved.datetime_ignored_error IS NULL', $where];
        $where = array_filter($where);
        $where = implode(' AND ', $where);

        $lastNMinutesDatetime = Date::now()->subSeconds(60 * $lastNMinutes)->getDatetime();
        $bind = [$idSite, $lastNMinutesDatetime];
        $bind = array_merge($bind, $extraBind);

        $query = $segment->getSelectQuery(
            'log_crash_resolved.idlogcrash,
            log_crash_resolved.message,
            log_crash_resolved.resource_uri,
            log_crash_group.datetime_first_seen as crash_first_seen,
            log_crash_group.datetime_last_seen as crash_last_seen,
            log_crash_group.datetime_last_reappeared as crash_last_reappeared,
            count(log_crash_event.idlogcrashevent) AS ' . Metrics::CRASH_OCCURRENCES . ',
            count(distinct log_crash_event.idvisit) AS ' . Metrics::VISITS_WITH_CRASH,
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
            $where,
            $bind,
            $orderBy ?? (Metrics::CRASH_OCCURRENCES . ' DESC'),
            $groupBy = 'log_crash_resolved.idlogcrash',
            $limit
        );

        $sql = $this->decorateQueryWithSourceLocationHint($query['sql'], __FUNCTION__);

        $result = $this->getDbReader()->fetchAll($sql, $query['bind']);
        $this->setLastCrashRowsLabel($result);
        return $result;
    }

    public function getLastCrashesOverview($idSite, \Piwik\Segment $segment, $lastNMinutes)
    {
        $settings = new MeasurableSettings($idSite);
        $daysUntilConsideredDisappeared = $settings->daysUntilConsideredDisappeared->getValue();

        $lastNMinutesDateObj = Date::now()->subSeconds(60 * $lastNMinutes);
        $lastNMinutesDatetime = $lastNMinutesDateObj->getDatetime();

        // query for crash occurrences & visits with crash
        $query = $segment->getSelectQuery(
            'count(log_crash_event.idlogcrashevent) AS ' . Metrics::CRASH_OCCURRENCES . ',
            count(distinct log_crash_event.idvisit) AS ' . Metrics::VISITS_WITH_CRASH,
            [
                'log_crash_event',
                'log_crash',
            ],
            'log_crash_event.idsite = ? AND log_crash_event.server_time >= ? AND log_crash.datetime_ignored_error IS NULL',
            [$idSite, $lastNMinutesDatetime]
        );

        $sql = $this->decorateQueryWithSourceLocationHint($query['sql'], __FUNCTION__);
        $result = $this->getDbReader()->fetchRow($sql, $query['bind']);

        $allNewOrReappearedSql = 'SELECT log_crash.idlogcrash
            FROM ' . Common::prefixTable('log_crash_event') . ' log_crash_event
            LEFT JOIN ' . Common::prefixTable('log_crash') . ' log_crash ON log_crash_event.idlogcrash = log_crash.idlogcrash
           WHERE log_crash_event.server_time >= ? AND log_crash.idsite = ? AND log_crash.datetime_ignored_error IS NULL
                 AND (log_crash.datetime_first_seen >= ? OR log_crash.datetime_last_reappeared >= ?)';

        $allNewOrReappeared = $this->getDbReader()->fetchAll($allNewOrReappearedSql, [$lastNMinutesDatetime, $idSite, $lastNMinutesDatetime, $lastNMinutesDatetime]);
        $allNewOrReappeared = array_column($allNewOrReappeared, 'idlogcrash');
        $allNewOrReappeared = array_unique($allNewOrReappeared);
        $hasNewOrReappeared = !empty($allNewOrReappeared);

        // query for new/reappeared (only if there is at least one new or reappeared crash overall)
        if ($hasNewOrReappeared) {
            $query = $segment->getSelectQuery(
                'log_crash_group.datetime_first_seen as datetime_first_seen,
                log_crash_group.datetime_last_reappeared as datetime_last_reappeared',
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
                'log_crash_event.idlogcrash IN (' . implode(', ', $allNewOrReappeared) . ')',
                [$lastNMinutesDatetime, $lastNMinutesDatetime],
                '',
                'log_crash_resolved.idlogcrash'
            );

            $sql = 'SELECT sum(case when sq.datetime_first_seen >= ? then 1 else 0 end) AS ' . Metrics::NEW_CRASHES . ',
                         sum(case when sq.datetime_last_reappeared >= ? then 1 else 0 end) AS ' . Metrics::REAPPEARED_CRASHES . '
                    FROM (' . $query['sql'] . ') sq';

            $sql = $this->decorateQueryWithSourceLocationHint($sql, __FUNCTION__);

            $result = array_merge($result, $this->getDbReader()->fetchRow($sql, $query['bind']));
        } else {
          $result[Metrics::NEW_CRASHES] = 0;
          $result[Metrics::REAPPEARED_CRASHES] = 0;
        }

        // query for disappeared
        $disappearedEndTime = Date::now()->subDay($daysUntilConsideredDisappeared);
        $disappearedStartTime = $disappearedEndTime->subSeconds(60 * $lastNMinutes);

        $disappearedQuery = $segment->getSelectQuery(
            'count(distinct IFNULL(log_crash_original.group_idlogcrash, log_crash_original.idlogcrash)) AS ' . Metrics::DISAPPEARED_CRASHES,
            [
                'log_crash_event', // required to be able to join to log_visit properly
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
            ],
            "log_crash_resolved.idsite = ? AND log_crash_original.datetime_last_seen >= ? AND log_crash_original.datetime_last_seen <= ? AND log_crash_resolved.datetime_ignored_error IS NULL",
            [$idSite, $disappearedStartTime->getDatetime(), $disappearedEndTime->getDatetime()],
            ''
        );

        $disappearedQuerySql = $disappearedQuery['sql'];
        $disappearedQueryBind = $disappearedQuery['bind'];

        $disappearedQuerySql = $this->decorateQueryWithSourceLocationHint($disappearedQuerySql, __FUNCTION__);

        $disappearedResult = $this->getDbReader()->fetchRow($disappearedQuerySql, $disappearedQueryBind);
        unset($disappearedResult['last_seen']);
        if (empty($disappearedResult)) {
            $disappearedResult = [Metrics::DISAPPEARED_CRASHES => 0];
        }

        return array_merge($result, $disappearedResult);
    }

    public function getLastDisappearedCrashes($idSite, \Piwik\Segment $segment, $lastNMinutes, $limit)
    {
        $settings = new MeasurableSettings($idSite);
        $daysUntilConsideredDisappeared = $settings->daysUntilConsideredDisappeared->getValue();

        $idSite = (int)$idSite;
        $disappearedEndTime = Date::now()->subDay($daysUntilConsideredDisappeared);
        $disappearedStartTime = $disappearedEndTime->subSeconds(60 * $lastNMinutes);

        $disappearedQuery = $segment->getSelectQuery(
            'log_crash_resolved.idlogcrash,
            log_crash_resolved.message,
            log_crash_resolved.resource_uri,
            log_crash_group.datetime_first_seen as crash_first_seen,
            log_crash_group.datetime_last_seen AS crash_last_seen,
            log_crash_group.datetime_last_reappeared as crash_last_reappeared',
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
            'log_crash_event.idsite = ? AND log_crash_group.datetime_last_seen >= \'' . $disappearedStartTime->getDatetime()
                . '\' AND log_crash_group.datetime_last_seen <= \'' . $disappearedEndTime->getDatetime() . '\'',
            [$idSite],
            false,
            'log_crash_resolved.idlogcrash',
            $limit
        );

        $disappearedQuerySql = $disappearedQuery['sql'];
        $disappearedQueryBind = $disappearedQuery['bind'];

        $disappearedQuerySql = $this->decorateQueryWithSourceLocationHint($disappearedQuerySql, __FUNCTION__);

        $result = $this->getDbReader()->fetchAll($disappearedQuerySql, $disappearedQueryBind);
        $this->setLastCrashRowsLabel($result);

        return $result;
    }

    private function setLastCrashRowsLabel(&$rows)
    {
        // labels must be unique before we process the DataTable, so we make a temp label of message & resource_uri columns
        foreach ($rows as &$row) {
            $row['label'] = json_encode([$row['message'], $row['resource_uri']]);
            unset($row['message']);
            unset($row['resource_uri']);
        }
    }

    public function deleteOldCrashEvents($maxEntries, $deleteOlderThan, $idSites)
    {
        $idSites = array_map('intval', $idSites);
        $idSites = implode(',', $idSites);

        $deleteOlderThanDatetime = Date::today()->subDay($deleteOlderThan)->getDatetime();

        $sql = 'DELETE FROM ' . Common::prefixTable(self::TABLE_NAME) . ' WHERE server_time < ? AND idsite IN ('
            . $idSites . ') LIMIT ' . (int)$maxEntries;
        $bind = [$deleteOlderThanDatetime];

        $query = Db::query($sql, $bind);
        return $query->rowCount();
    }

    public function getCrashesForVisits($idVisits, $limit)
    {
        if (empty($idVisits)) {
            return [];
        }

        $idVisits = array_map('intval', $idVisits);
        $idVisitsStr = implode(',', $idVisits);

        $logCrashEvent = Common::prefixTable(self::TABLE_NAME);
        $logCrash = Common::prefixTable(LogCrash::TABLE_NAME);
        $logCrashStack = Common::prefixTable(LogCrashStack::TABLE_NAME);

        $extraWhere = '';
        if ($this->forceSleepInGetLogCrashEvents) {
            $extraWhere = 'SLEEP(1) AND';
        }

        $sql = "
          SELECT log_crash_event.idvisit,
                 log_crash_event.idpageview,
                 log_crash_event.server_time,
                 log_crash_event.idlogcrashevent,
                 log_crash_event.idlogcrash,
                 log_crash_event.resource_line,
                 log_crash_event.resource_column,
                 log_crash_stack.value AS stack_trace,
                 log_crash_stack.compressed AS stack_trace_compressed,
                 log_crash_event.category,
                 log_crash.crash_type,
                 log_crash.message,
                 log_crash.resource_uri,
                 log_crash.datetime_first_seen,
                 log_crash.datetime_ignored_error,
                 log_crash.datetime_last_seen,
                 log_crash.datetime_last_reappeared
            FROM $logCrashEvent log_crash_event
       LEFT JOIN $logCrash log_crash ON log_crash.idlogcrash = log_crash_event.idlogcrash
       LEFT JOIN $logCrashStack log_crash_stack ON log_crash_stack.idlogcrashstack = log_crash_event.idlogcrashstack
           WHERE $extraWhere idvisit IN ($idVisitsStr) AND log_crash.datetime_ignored_error IS NULL";

        if ($limit > 0) {
            $sql .= " LIMIT " . (int)$limit;
        }

        $sql = $this->decorateQueryWithSourceLocationHint($sql, __FUNCTION__);
        $sql = DbHelper::addMaxExecutionTimeHintToQuery($sql, $this->getLiveQueryMaxExecutionTime());
        $db = $this->getDbReader();

        try {
            $rows = $db->fetchAll($sql);
        } catch (\Exception $e) {
            Model::handleMaxExecutionTimeError($db, $e, '', Date::now(), Date::now(), null, 0, ['sql' => $sql]);
            throw $e;
        }

        foreach ($rows as &$row) {
            if (!empty($row['stack_trace_compressed'])) {
                $row['stack_trace'] = $this->logCrashStack->uncompress($row['stack_trace']);
            }
        }

        return $rows;
    }

    private function getLiveQueryMaxExecutionTime()
    {
        return Config::getInstance()->General['live_query_max_execution_time'];
    }

    public function getMostRecentCrashEvent($idSite, $idLogCrash)
    {
        $sql = "SELECT log_crash_event.*, log_action.name as crash_page_url, log_action.url_prefix as crash_page_url_prefix
            FROM " . Common::prefixTable(self::TABLE_NAME) . ' log_crash_event
       LEFT JOIN ' . Common::prefixTable('log_action') . ' log_action ON log_action.idaction = log_crash_event.idaction_url
           WHERE idsite = ? AND idlogcrash = ? ORDER BY server_time DESC LIMIT 1';
        $result = $this->getDbReader()->fetchRow($sql, [$idSite, $idLogCrash]);
        return $result;
    }

    public function deleteForSitesNotIn($maxEntries, $existingSites)
    {
        $existingSites = array_map('intval', $existingSites);
        $existingSites = implode(',', $existingSites);

        $sql = "DELETE FROM " . Common::prefixTable(self::TABLE_NAME) . " WHERE idsite NOT IN ($existingSites) LIMIT " . (int)$maxEntries;

        $query = Db::query($sql);
        return $query->rowCount();
    }

    public function reconstructPageUrl($pageUrl, $pageUrlPrefix, ?int $idSite = null)
    {
        if (empty($pageUrl)) {
            return null;
        }

        $urlPrefix = $pageUrlPrefix;
        $crashPageUrl = PageUrl::reconstructNormalizedUrl($pageUrl, $urlPrefix);

        if (!empty($idSite) && strpos($crashPageUrl, 'http://') === 0) { // mirrors code in Actions filter in the Actions plugin
            $host = parse_url($crashPageUrl, PHP_URL_HOST);

            if ($host && PageUrl::shouldUseHttpsHost($idSite, $host)) {
                $crashPageUrl = 'https://' . mb_substr($crashPageUrl, 7 /* = strlen('http://') */);
            }
        }

        return $crashPageUrl;
    }

    private function decorateQueryWithSourceLocationHint($sql, $queryHintDecoration)
    {
        $sql = preg_replace('/SELECT\s+/', 'SELECT /* CrashAnalytics ' . $queryHintDecoration . ' */ ', $sql, 1);
        return $sql;
    }
}
