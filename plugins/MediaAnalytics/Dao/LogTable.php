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
namespace Piwik\Plugins\MediaAnalytics\Dao;

use Piwik\Common;
use Piwik\Config;
use Piwik\Container\StaticContainer;
use Piwik\Date;
use Piwik\Db;
use Piwik\DbHelper;
use Piwik\Plugins\Live\Model;
use Piwik\Plugins\MediaAnalytics\Archiver;
use Piwik\Plugins\MediaAnalytics\MediaAnalytics;
use Piwik\Segment;

class LogTable
{
    private $table = 'log_media';
    private $tablePrefixed = '';
    private $noOfRetriesOnDeadlock = 1;

    /**
     * @internal tests only
     * @var bool
     */
    public $forceSleepInQuery = false;

    const MAX_LENGTH_IDVIEW = 6;

    /**
     * @var Db|Db\AdapterInterface|\Piwik\Tracker\Db
     */
    private $db;

    public function __construct()
    {
        $this->tablePrefixed = Common::prefixTable($this->table);
    }

    private function getDb()
    {
        if (!isset($this->db)) {
            $this->db = Db::get();
        }
        return $this->db;
    }

    public function install()
    {
        DbHelper::createTable($this->table, "
                  `idvisitor` binary(8) NOT NULL,
                  `idvisit` BIGINT unsigned NOT NULL,
                  `idsite` INT(11) unsigned NOT NULL,
                  `idview` VARCHAR(".self::MAX_LENGTH_IDVIEW.") NOT NULL,
                  `player_name` VARCHAR(20) NOT NULL,
                  `media_type` TINYINT(1) NOT NULL,
                  `resolution` VARCHAR(20) DEFAULT '',
                  `fullscreen` TINYINT(1) UNSIGNED NOT NULL,
                  `media_title` VARCHAR(150) DEFAULT '',
                  `resource` VARCHAR(300) NOT NULL,
                  `server_time` DATETIME NOT NULL,
                  `time_to_initial_play` INT(11) UNSIGNED DEFAULT NULL,
                  `watched_time` BIGINT UNSIGNED DEFAULT 0,
                  `media_progress` INT(11) UNSIGNED DEFAULT 0,
                  `media_length` INT(11) UNSIGNED DEFAULT 0,
                  PRIMARY KEY(`idvisit`,`idview`),
                  KEY(`idsite`,`media_type`,`server_time`)");
    }

    public function uninstall()
    {
        Db::query(sprintf('DROP TABLE IF EXISTS `%s`', $this->tablePrefixed));
    }

    public function hasRecord($idVisit, $idView)
    {
        $sql = sprintf('SELECT 1 FROM %s WHERE idvisit = ? AND idview = ? LIMIT 1', $this->tablePrefixed);
        $bind = array($idVisit, $idView);
        $hasRecord = Db::fetchOne($sql, $bind);

        return !empty($hasRecord);
    }

    private function getResolution($mediaWidth, $mediaHeight)
    {
        $resolution = empty($mediaHeight) || empty($mediaWidth) || !is_numeric($mediaHeight) || !is_numeric($mediaWidth) ? '' : ($mediaWidth . 'x' . $mediaHeight);
        $resolution = !empty($resolution) ? Common::mb_substr(trim($resolution), 0, 20) : '';

        return $resolution;
    }

    public function record($idVisitor, $idVisit, $idSite, $idView, $mediaType, $playerName, $mediaTitle, $resource, $watchedTime, $mediaProgress, $mediaLength, $timeToInitialPlay, $mediaWidth, $mediaHeight, $isFullscreen, $serverTime, $retry = 0)
    {
        $fullscreen = empty($isFullscreen) ? 0 : 1;
        $resolution = $this->getResolution($mediaWidth, $mediaHeight);

        if ($timeToInitialPlay === '') {
            $timeToInitialPlay = null;
        }

        $values = array(
            'idvisitor' => $idVisitor,
            'idvisit' => $idVisit,
            'idsite' => $idSite,
            'idview' => !empty($idView) ? Common::mb_substr(trim($idView), 0, self::MAX_LENGTH_IDVIEW) : '',
            'media_type' => $mediaType,
            'player_name' => $playerName,
            'media_title' => !empty($mediaTitle) ? Common::mb_substr(trim($mediaTitle), 0, 150) : '',
            'resource' => !empty($resource) ? Common::mb_substr(trim($resource), 0, 300) : '',
            'watched_time' => $watchedTime,
            'media_progress' => $mediaProgress,
            'media_length' => $mediaLength,
            'time_to_initial_play' => $timeToInitialPlay,
            'resolution' => $resolution,
            'fullscreen' => $fullscreen,
            'server_time' => $serverTime
        );

        $columns = implode('`,`', array_keys($values));
        $vals = Common::getSqlStringFieldsArray($values);
        $sql = sprintf('INSERT INTO %s (`%s`) VALUES(%s)', $this->tablePrefixed, $columns, $vals);
        $bind = array_values($values);

        try {
            $this->getDb()->query($sql, $bind);

        } catch (\Exception $e) {
            if (Db::get()->isErrNo($e, \Piwik\Updater\Migration\Db::ERROR_CODE_DUPLICATE_ENTRY)) {
                // race condition where two tried to insert at same time... we need to update instead
                // note: if both requests that had race conditions set different media title... there could be
                // incosistencies since we don't know which media title or resolution had most recent information
                $this->updateRecord($idVisit, $idView, $mediaTitle, $watchedTime, $mediaProgress, $mediaLength, $timeToInitialPlay, $mediaWidth, $mediaHeight, $isFullscreen);
                return;
            } else if (stripos($e->getMessage(), 'Deadlock found when trying to get lock') !== false && $retry < $this->noOfRetriesOnDeadlock) {
                $retry++;
                $this->record($idVisitor, $idVisit, $idSite, $idView, $mediaType, $playerName, $mediaTitle, $resource, $watchedTime, $mediaProgress, $mediaLength, $timeToInitialPlay, $mediaWidth, $mediaHeight, $isFullscreen, $serverTime, $retry);
                return;
            }
            throw $e;
        }
    }

    public function updateRecord($idVisit, $idView, $mediaTitle, $watchedTime, $mediaProgress, $mediaLength, $timeToInitialPlay, $mediaWidth, $mediaHeight, $isFullscreen, $retry = 0)
    {
        $resolution = $this->getResolution($mediaWidth, $mediaHeight);

        $fullscreen = empty($isFullscreen) ? 0 : 1;

        if ($timeToInitialPlay === '') {
            $timeToInitialPlay = null;
        }

        $bind = array();

        $bind[] = $watchedTime;
        $bind[] = $watchedTime;
        $bind[] = $mediaProgress;
        $bind[] = $mediaProgress;
        $bind[] = $mediaLength;
        $bind[] = $mediaLength;
        $bind[] = $timeToInitialPlay;
        $bind[] = !empty($mediaTitle) ? Common::mb_substr(trim($mediaTitle), 0, 150) : '';
        $bind[] = $resolution;
        $bind[] = $idVisit;
        $bind[] = $idView;

        $sql = sprintf('UPDATE %s SET 
                watched_time = IF(watched_time < ?, ?, watched_time), 
                media_progress = IF(media_progress < ?, ?, media_progress), 
                media_length = IF(media_length < ?, ?, media_length),
                time_to_initial_play = IFNULL(time_to_initial_play, ?),
                media_title = ?,
                resolution = ?,
                fullscreen = IF(fullscreen >= 1, 1, ' . $fullscreen . ') 
                WHERE idvisit = ? AND idview = ?',
            $this->tablePrefixed);

        try {
            $this->getDb()->query($sql, $bind);
        } catch (\Exception $e) {
            if (stripos($e->getMessage(), 'Deadlock found when trying to get lock') !== false && $retry  < $this->noOfRetriesOnDeadlock) {
                $retry++;
                $this->updateRecord($idVisit, $idView, $mediaTitle, $watchedTime, $mediaProgress, $mediaLength, $timeToInitialPlay, $mediaWidth, $mediaHeight, $isFullscreen, $retry);
                return;
            }
            throw $e;
        }
    }

    public function getAllRecords()
    {
        $records = $this->getDb()->fetchAll('SELECT * FROM ' . $this->tablePrefixed);
        foreach ($records as &$record) {
            $record['idvisitor'] = bin2hex($record['idvisitor']);
            $record['idvisit'] = (int)$record['idvisit'];
        }
        return $records;
    }

    private function getDbReader()
    {
        return Db::getReader();
    }

    public function getRecordsForVisitIds($visitIds)
    {
        if (empty($visitIds)) {
            return [];
        }

        $extraWhere = '';
        if ($this->forceSleepInQuery) {
            $extraWhere = 'SLEEP(1) AND';
        }

        $visitIds = array_map('intval', $visitIds);

        $query = "SELECT /* MediaAnalytics.getRecordsForVisitIds */ * FROM " . $this->tablePrefixed . " as log_media WHERE $extraWhere idvisit IN ('" . implode("','", $visitIds) ."') AND watched_time != 0";

        $readerDb = $this->getDbReader();
        $query = DbHelper::addMaxExecutionTimeHintToQuery($query, $this->getLiveQueryMaxExecutionTime());

        try {
            return $readerDb->fetchAll($query, []);
        } catch (\Exception $e) {
            Model::handleMaxExecutionTimeError($readerDb, $e, '', Date::now(), Date::now(), null, 0, ['sql' => $query]);
            throw $e;
        }
    }

    private function getLiveQueryMaxExecutionTime()
    {
        return Config::getInstance()->General['live_query_max_execution_time'];
    }

    public function getRecordsForVisitIdExtended($visitIds)
    {
        if (empty($visitIds)) {
            return [];
        }

        $extraWhere = '';
        if ($this->forceSleepInQuery) {
            $extraWhere = 'SLEEP(1) AND';
        }

        $visitIds = array_map('intval', $visitIds);

        $columns = 'log_media.*,'. Archiver::getSecondaryDimensionMediaSegmentSelect('');

        $prefixedMediaPlays = Common::prefixTable('log_media_plays');

        $query = "SELECT /* MediaAnalytics.getRecordsForVisitIdExtended */ $columns FROM " . $this->tablePrefixed . " as log_media LEFT JOIN $prefixedMediaPlays as log_media_plays ON log_media_plays.idview = log_media.idview and log_media_plays.idvisit = log_media.idvisit WHERE $extraWhere log_media.idvisit IN ('" . implode("','", $visitIds) ."') AND log_media.watched_time != 0";

        $readerDb = $this->getDbReader();
        $query = DbHelper::addMaxExecutionTimeHintToQuery($query, $this->getLiveQueryMaxExecutionTime());

        try {
            return $readerDb->fetchAll($query, []);
        } catch (\Exception $e) {
            Model::handleMaxExecutionTimeError($readerDb, $e, '', Date::now(), Date::now(), null, 0, ['sql' => $query]);
            throw $e;
        }
    }

    public function hasRecords($idSite)
    {
        return (bool) $this->getDb()->fetchOne('SELECT count(idsite) FROM ' . $this->tablePrefixed . ' WHERE idsite = ? LIMIT 1', array($idSite));
    }

    public function getNumPlays($idSite, $fromServerTime, $segment)
    {
        $result = 0;
        foreach ([MediaAnalytics::MEDIA_TYPE_VIDEO, MediaAnalytics::MEDIA_TYPE_AUDIO] as $mediaType) {
            $where = sprintf('%1$s.idsite = ? and %1$s.media_type = ? and %1$s.server_time > ? and DATE_ADD(%1$s.server_time, INTERVAL %1$s.watched_time SECOND) > ? and %1$s.watched_time > 0', $this->table);
            $segment = new Segment($segment, $idSite);
            $query = $segment->getSelectQuery('count(log_media.idview)', $this->table, $where, array($idSite, $mediaType, $this->getTime8HoursBack($fromServerTime), $fromServerTime));

            $result += $this->getDbReader()->fetchOne($query['sql'], $query['bind']);
        }

        return $result;
    }

    public function getSumWatchedTime($idSite, $fromServerTime, $segment)
    {
        $result = 0;
        foreach ([MediaAnalytics::MEDIA_TYPE_VIDEO, MediaAnalytics::MEDIA_TYPE_AUDIO] as $mediaType) {
            $where = sprintf('%1$s.idsite = ? and %1$s.media_type = ? and %1$s.server_time > ? and DATE_ADD(%1$s.server_time, INTERVAL %1$s.watched_time SECOND) > ?', $this->table);
            $segment = new Segment($segment, $idSite);
            $query = $segment->getSelectQuery('sum(log_media.watched_time)', $this->table, $where, array($idSite, $mediaType, $this->getTime8HoursBack($fromServerTime), $fromServerTime));

            $result += $this->getDbReader()->fetchOne($query['sql'], $query['bind']);
        }

        return $result;
    }

    public function getMostPlays($idSite, $fromServerTime, $limit, $segment)
    {
        $result = [];
        foreach ([MediaAnalytics::MEDIA_TYPE_VIDEO, MediaAnalytics::MEDIA_TYPE_AUDIO] as $mediaType) {
            $where = sprintf('%1$s.idsite = ? and %1$s.media_type = ? and %1$s.server_time > ? and DATE_ADD(%1$s.server_time, INTERVAL %1$s.watched_time SECOND) > ? and %1$s.watched_time > 0', $this->table);
            $segment = new Segment($segment, $idSite);
            $query = $segment->getSelectQuery(
                "count(log_media.idvisit) as value, IF(log_media.media_title='', log_media.resource, log_media.media_title) as label",
                $this->table,
                $where,
                array($idSite, $mediaType, $this->getTime8HoursBack($fromServerTime), $fromServerTime),
                $orderBy = 'value DESC, label ASC',
                $groupBy = 'label',
                (int) $limit
            );

            $result = array_merge($result, $this->getDbReader()->fetchAll($query['sql'], $query['bind']));
        }

        usort($result, function($a, $b) {
            if ($a['value'] === $b['value']) {
                return strnatcasecmp($a['label'], $b['label']);
            }

            return $a['value'] > $b['value'] ? -1 : 1;
        });

        return array_slice($result, 0, $limit);
    }

    protected function getTime8HoursBack($serverTime)
    {
        $date = Date::factory($serverTime);
        return $date->subHour(8)->toString('Y-m-d H:i:s');
    }

    public function getMostUsedValuesForDimension($dimension, $idSite, $limit)
    {
        $startDate = Date::now()->subDay(60)->toString();

        if (defined('PIWIK_TEST_MODE')) {
            $testNow = \Piwik\Container\StaticContainer::get('test.vars.testMockNowDate');
            if ($testNow) {
                $startDate = Date::getDatetimeFromTimestamp($testNow);
            }
        }

        $query = sprintf('SELECT %s, count(%s) as value FROM %s WHERE idsite = ? and server_time > ? and %s is not null GROUP BY %s ORDER BY value DESC, %s ASC LIMIT %d',
            $dimension, $dimension, $this->tablePrefixed, $dimension, $dimension, $dimension, (int) $limit);
        $rows = Db::get()->fetchAll($query, array($idSite, $startDate));

        $values = array();
        foreach ($rows as $row) {
            $values[] = $row[$dimension];
        }

        return $values;
    }

    public static function getInstance()
    {
        return StaticContainer::get(LogTable::class);
    }

}

