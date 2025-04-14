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
use Piwik\Date;
use Piwik\Db;
use Piwik\DbHelper;
use Piwik\Plugins\CrashAnalytics\Tracker\BrowserInconsistencies;
use Piwik\Plugins\CrashAnalytics\Tracker\JsErrorTranslations;
use Piwik\Tracker\Cache;

class LogCrash
{
    const TABLE_NAME = 'log_crash';

    const DEFAULT_DAYS_UNTIL_CONSIDERED_DISAPPEARED = 7;

    const MAX_LENGTH_MESSAGE = 255;
    const MAX_LENGTH_RESOURCE_URI = 300;
    const MAX_LENGTH_CRASH_TYPE = 100;
    const DEFAULT_UPDATE_EVERY_N_HOURS = 3;

    private $updateEveryNHours;

    /**
     * @var Db|Db\AdapterInterface|\Piwik\Tracker\Db
     */
    private $db;

    /**
     * @var BrowserInconsistencies
     */
    private $browserInconsistencies;

    /**
     * @var LogCrashGroup
     */
    private $logCrashGroup;

    private $tableColumns = [
        'idlogcrash' => 'BIGINT UNSIGNED NOT NULL AUTO_INCREMENT',
        'idsite' => 'INT UNSIGNED NOT NULL',
        'crash_type' => 'VARCHAR(' . self::MAX_LENGTH_CRASH_TYPE . ') NOT NULL',
        'message' => 'VARCHAR(' . self::MAX_LENGTH_MESSAGE . ') NOT NULL',
        'resource_uri' => 'VARCHAR(' . self::MAX_LENGTH_RESOURCE_URI . ') NOT NULL DEFAULT \'\'',
        'stack_trace' => 'MEDIUMBLOB NULL DEFAULT NULL',
        'resource_line' => 'INT UNSIGNED NULL',
        'resource_column' => 'INT UNSIGNED NULL',
        'datetime_first_seen' => 'DATETIME NOT NULL',
        'datetime_ignored_error' => 'DATETIME NULL',
        'datetime_last_seen' => 'DATETIME NOT NULL',
        'datetime_last_reappeared' => 'DATETIME NULL',
        // needed to be able to match by normalized message, while retaining original format in message
        'crc32_hash' => 'INT UNSIGNED NOT NULL',
        // when merging crashes, the group_idlogcrash is set to an identical crash.
        // we aggregate using this column instead of idlogcrash
        'group_idlogcrash' => 'BIGINT UNSIGNED NULL',
    ];

    public function __construct(BrowserInconsistencies $browserInconsistencies, LogCrashGroup $logCrashGroup,
                                $updateEveryNHours = self::DEFAULT_UPDATE_EVERY_N_HOURS)
    {
        $this->browserInconsistencies = $browserInconsistencies;
        $this->logCrashGroup = $logCrashGroup;
        $this->updateEveryNHours = $updateEveryNHours;
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
        $columns = '';
        foreach ($this->tableColumns as $column => $type) {
            $columns .= "`$column` $type,\n";
        }

        DbHelper::createTable(self::TABLE_NAME, "
            $columns
            PRIMARY KEY (`idlogcrash`),
            INDEX resolvedidlogcrash (`idlogcrash`, `group_idlogcrash`),
            INDEX idsitehash (`idsite`, `crc32_hash`),
            INDEX idsiteignored (`idsite`, `datetime_ignored_error`),
            INDEX lastseen (`datetime_last_seen`)
        ");
    }

    public function uninstall()
    {
        Db::query(sprintf('DROP TABLE IF EXISTS `%s`', Common::prefixTable(self::TABLE_NAME)));
    }

    private function findEntry($crc32hash, $normalizedMessage, $resourceUri, $idSite)
    {
        $uriWithoutProtocol = self::removeProtocol($resourceUri);

        $sql = sprintf(
            'SELECT idlogcrash, message, resource_uri, datetime_last_seen, datetime_ignored_error, group_idlogcrash
            FROM %s
            WHERE crc32_hash = ? AND idsite = ? AND resource_uri LIKE ?',
            Common::prefixTable(self::TABLE_NAME)
        );

        $rows = $this->getDb()->fetchAll($sql, array($crc32hash, $idSite, '%' . $uriWithoutProtocol));
        foreach ($rows as $row) { // handle hash collisions
            $rowNormalizedMessage = LogCrashStack::normalizeText($row['message']);
            if ($normalizedMessage == $rowNormalizedMessage
                && $uriWithoutProtocol == self::removeProtocol($row['resource_uri'])
            ) {
                return $row;
            }
        }
        return null;
    }

    private function updateEntry($idSite, $id, $groupId, $existingDateLastSeen, $newValues)
    {
        $newLastSeen = strtotime($newValues['datetime_last_seen']);

        // only update an entry every N hours
        $isTimeToUpdate = strtotime($existingDateLastSeen) + $this->updateEveryNHours * 60 * 60 <= $newLastSeen;
        if (!$isTimeToUpdate) {
            return;
        }

        $values = [
            'datetime_last_seen' => $newValues['datetime_last_seen'],
        ];

        $crashGroupValues = $values;

        $optionalColumns = ['stack_trace', 'resource_uri', 'crc32_hash', 'resource_line', 'resource_column'];
        foreach ($optionalColumns as $column) {
            if (isset($newValues[$column])) {
                $values[$column] = $newValues[$column];
            }
        }

        $startOfDayLastSeen = strtotime($existingDateLastSeen);
        $startOfDayLastSeen = date('Y-m-d 00:00:00', $startOfDayLastSeen);
        $startOfDayLastSeen = strtotime($startOfDayLastSeen);

        $cache = Cache::getCacheWebsiteAttributes($idSite);
        $reappearedAfterNDays = (int)($cache['CrashAnalytics']['days_until_crash_considered_disappeared'] ?? self::DEFAULT_DAYS_UNTIL_CONSIDERED_DISAPPEARED);

        if ($startOfDayLastSeen + $reappearedAfterNDays * 24 * 60 * 60 < $newLastSeen) {
            $values['datetime_last_reappeared'] = $newValues['datetime_last_seen'];
            $crashGroupValues['datetime_last_reappeared'] = $values['datetime_last_reappeared'];
        }

        $sql = "UPDATE " . Common::prefixTable(self::TABLE_NAME)
            . " SET ";
        foreach (array_keys($values) as $idx => $column) {
            if ($idx !== 0) {
                $sql .= ',';
            }
            $sql .= $column . ' = ?';
        }
        $sql .= ' WHERE idlogcrash = ' . (int)$id;
        $this->getDb()->query($sql, array_values($values));

        $resolvedIdLogCrash = $groupId ?: $id;
        $this->logCrashGroup->record($resolvedIdLogCrash, $crashGroupValues);
    }

    public function record($parameters, $cdt)
    {
        if (is_int($cdt)) {
            $cdt = date('Y-m-d H:i:s', $cdt);
        }

        $message = JsErrorTranslations::translateCrashIfNeeded($parameters['message']);
        $message = mb_substr($message, 0, self::MAX_LENGTH_MESSAGE);

        $resourceUri = $parameters['resource_uri'] ?? '';
        $resourceUri = mb_substr($resourceUri, 0, self::MAX_LENGTH_RESOURCE_URI);

        $stackTrace = $parameters['stack_trace'] ?? null;

        $crashType = mb_substr($parameters['crash_type'], 0, self::MAX_LENGTH_CRASH_TYPE);

        $updatedMessage = $this->browserInconsistencies->getNormalizedMessageIfCommon($message);
        if (!empty($updatedMessage)) {
            $message = $updatedMessage;
        }

        $normalizedMessage = LogCrashStack::normalizeText($message);
        $hash = $this->getCrc32Hash($normalizedMessage, $resourceUri);

        $values = [
            'idsite' => (int)$parameters['idsite'],
            'crash_type' => $crashType,
            'message' => $message,
            'resource_uri' => $resourceUri,
            'stack_trace' => $stackTrace,
            'resource_line' => $parameters['resource_line'] ?? null,
            'resource_column' => $parameters['resource_column'] ?? null,
            'datetime_first_seen' => $cdt,
            'datetime_last_seen' => $cdt,
            'crc32_hash' => $hash,
        ];

        $row = $this->findEntry($hash, $normalizedMessage, $resourceUri, $values['idsite']);
        if (!empty($row)) {
            if (!empty($row['datetime_ignored_error'])) {
                return [null, null];
            }

            // if the resource URI has a different protocol than the existing resource URI, and the existing
            // one is http, update it in the database (we prefer https when encountered)
            $newResourceProtocol = parse_url($resourceUri, PHP_URL_SCHEME);
            $existingResourceProtocol = parse_url($row['resource_uri'], PHP_URL_SCHEME);
            $isProtocolUpgrade = $newResourceProtocol === 'https' && $newResourceProtocol != $existingResourceProtocol;

            if ($isProtocolUpgrade) {
                $values['resource_uri'] = $resourceUri;
            } else {
                unset($values['resource_uri']);
                unset($values['crc32_hash']);
            }

            $this->updateEntry($parameters['idsite'], $row['idlogcrash'], $row['group_idlogcrash'], $row['datetime_last_seen'], $values);
            return [$row['idlogcrash'], $row['datetime_last_seen']];
        }

        $values = array_filter($values, function ($v) { return $v !== null; });

        $columns = implode('`,`', array_keys($values));

        $placeholders = array_map(function () { return '?'; }, $values);
        $placeholders = implode(',', $placeholders);

        $sql = sprintf('INSERT INTO %s (`%s`) VALUES (%s)', Common::prefixTable(self::TABLE_NAME), $columns, $placeholders);

        $bind = array_values($values);

        $this->getDb()->query($sql, $bind);
        $idlogcrash = $this->getDb()->lastInsertId();

        $this->logCrashGroup->record($idlogcrash, [
            'datetime_first_seen' => $values['datetime_first_seen'],
            'datetime_last_seen' => $values['datetime_last_seen'],
            'datetime_last_reappeared' => null,
        ]);

        return [$idlogcrash, null];
    }

    public function fetchDynamicCrashData($idlogcrashes)
    {
        if (empty($idlogcrashes)) {
            return [];
        }

        $idlogcrashes = array_map('intval', $idlogcrashes);

        $sql = "SELECT log_crash_group.*
          FROM " . Common::prefixTable(self::TABLE_NAME) . " log_crash
          LEFT JOIN " . Common::prefixTable(LogCrashGroup::TABLE_NAME) . " log_crash_group
            ON log_crash.group_idlogcrash = log_crash_group.idlogcrash OR (log_crash.group_idlogcrash IS NULL AND log_crash.idlogcrash = log_crash_group.idlogcrash) 
         WHERE log_crash.idlogcrash IN (" . implode(', ', $idlogcrashes) . ")";

        $result = $this->getDbReader()->fetchAll($sql);
        $result = array_column($result, null, 'idlogcrash');
        return $result;
    }

    public function getCrash($idSite, $idLogCrash)
    {
        $sql = "SELECT * FROM " . Common::prefixTable(self::TABLE_NAME) . ' WHERE idsite = ? AND idlogcrash = ? LIMIT 1';
        $result = $this->getDbReader()->fetchRow($sql, [$idSite, $idLogCrash]);
        if (!empty($result)) {
            $this->transformCrashRow($result);
        }
        return $result;
    }

    public function setCrashIgnore($idSite, $idLogCrash, $ignored)
    {
        $sql = "UPDATE " . Common::prefixTable(self::TABLE_NAME) . ' SET datetime_ignored_error = '
            . ($ignored ? '\'' . Date::now()->getDatetime() . '\'' : 'NULL')
            . ' WHERE idsite = ? AND idlogcrash = ? AND (idlogcrash = group_idlogcrash OR group_idlogcrash IS NULL)';
        $query = $this->getDb()->query($sql, [$idSite, $idLogCrash]);
        return $query->rowCount() > 0;
    }

    public function getIgnoredCrashHashesForSite($idSite, $limit = null)
    {
        $sql = "SELECT idlogcrash, message, resource_uri FROM " . Common::prefixTable(self::TABLE_NAME) . '
        WHERE idsite = ? AND datetime_ignored_error IS NOT NULL ORDER BY datetime_ignored_error DESC'
        . ($limit ? ' LIMIT '.(int)$limit : '');

        $rows = $this->getDb()->fetchAll($sql, [$idSite]);
        foreach ($rows as &$row) {
            $row['hash'] = self::getHash($row['message'], $row['resource_uri']);
        }

        $result = array_column($rows, 'hash', 'idlogcrash');;
        return $result;
    }

    public function getLatestIgnoredCrashHashes($limit)
    {
        $sql = "SELECT idsite, message, resource_uri FROM " . Common::prefixTable(self::TABLE_NAME) . '
        WHERE datetime_ignored_error IS NOT NULL ORDER BY datetime_ignored_error DESC
        LIMIT '. (int)$limit;
        $rows = $this->getDb()->fetchAll($sql);

        $result = [];
        foreach ($rows as $row) {
            $hash = self::getHash($row['message'], $row['resource_uri']);
            $result[$row['idsite']][] = $hash;
        }
        return $result;
    }

    public function getIgnoredCrashesForSite($idSite)
    {
        $sql = "SELECT * FROM " . Common::prefixTable(self::TABLE_NAME) . ' WHERE idsite = ? AND datetime_ignored_error IS NOT NULL';
        $result = $this->getDb()->fetchAll($sql, [$idSite]);
        return $result;
    }

    public function deleteOldCrashes($maxEntries, $deleteOlderThan)
    {
        $deleteOlderThanDatetime = Date::today()->subDay($deleteOlderThan)->getDatetime();

        $sql = "DELETE FROM " . Common::prefixTable(self::TABLE_NAME) . ' WHERE datetime_last_seen < ? AND datetime_ignored_error IS NULL LIMIT ' . (int)$maxEntries;
        $query = $this->getDb()->query($sql, [$deleteOlderThanDatetime]);
        return $query->rowCount();
    }

    public function getAllCrashes($idSite, $sortColumn, $sortOrder, $limit = 10, $offset = 5)
    {
        $sortColumn = trim($sortColumn ?: 'datetime_last_reappeared');
        if (empty($this->tableColumns[$sortColumn])) {
            throw new \Exception("Invalid sort column '$sortColumn'!");
        }

        $sortOrder = trim(strtoupper($sortOrder ?: 'DESC'));
        if ($sortOrder !== 'ASC' && $sortOrder != 'DESC') {
            throw new \Exception("Invalid sort order '$sortOrder'!");
        }

        $sql = "SELECT * FROM " . Common::prefixTable(self::TABLE_NAME) . " WHERE idsite = ? AND (group_idlogcrash IS NULL OR group_idlogcrash = idlogcrash)";
        if ($sortColumn) {
            $sql .= " ORDER BY $sortColumn $sortOrder";
        }

        $sql .= ' LIMIT ' . (int)$limit . ' OFFSET ' . (int)$offset;

        $result = $this->getDbReader()->fetchAll($sql, [$idSite]);
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

    public static function getHash($message, $resourceUri)
    {
        $resourceUri = self::removeProtocol($resourceUri);

        $message = mb_substr($message, 0, self::MAX_LENGTH_MESSAGE);
        $resourceUri = mb_substr($resourceUri, 0, self::MAX_LENGTH_MESSAGE);

        $normalizedMessage = LogCrashStack::normalizeText($message);
        return md5($normalizedMessage . '.' . $resourceUri);
    }

    // public for tests
    public function getCrc32Hash($message, $resourceUri)
    {
        $resourceUri = self::removeProtocol($resourceUri);

        $message = mb_substr($message, 0, self::MAX_LENGTH_MESSAGE);
        $resourceUri = mb_substr($resourceUri, 0, self::MAX_LENGTH_MESSAGE);

        $normalizedMessage = LogCrashStack::normalizeText($message);
        return abs(crc32($normalizedMessage . '.' . $resourceUri));
    }

    private static function removeProtocol($resourceUri)
    {
        return preg_replace('%^[a-zA-Z0-9]+://%', '', $resourceUri);
    }

    public function getUniqueCrashTypes($idSite, $limit = false)
    {
        $sql = 'SELECT DISTINCT(crash_type) AS crash_type FROM ' . Common::prefixTable('log_crash')
            . ' WHERE idsite = ? AND datetime_ignored_error IS NULL AND crash_type <> \'\'';

        $limit = (int)$limit;
        if ($limit > 0) {
            $sql .= ' LIMIT ' . $limit;
        }

        $types = $this->getDbReader()->fetchAll($sql, [$idSite]);
        $types = array_column($types, 'crash_type');
        return $types;
    }

    public function mergeCrashes(array $idlogcrashes)
    {
        if (count($idlogcrashes) <= 1) {
            throw new \Exception('Not enough crashes to merge');
        }

        $idlogcrashes = array_map('intval', $idlogcrashes);

        // to keep the db state simple and disallow any weird states, we only allow merging idlogcrashes that don't resolve to another one
        // note: this shouldn't ever happen when going through the UI, but users of the API might accidentally do this.
        $sql = 'SELECT idlogcrash FROM ' . Common::prefixTable('log_crash')
            . ' WHERE group_idlogcrash IS NOT NULL AND group_idlogcrash <> idlogcrash AND idlogcrash IN ('
            . implode(', ', $idlogcrashes) . ') LIMIT 1';
        $idlogcrashesAlreadyMerged = Db::fetchRow($sql);
        if (!empty($idlogcrashesAlreadyMerged)) {
            throw new \Exception("Some of the requested crashes referenced have already been merged and should not be visible, please use the crashes they resolve to.");
        }

        $sql = 'SELECT idlogcrash, resource_uri FROM ' . Common::prefixTable('log_crash') . ' WHERE group_idlogcrash IN ('
            . implode(', ', $idlogcrashes) .  ')';

        $extraIdlogcrashes = $this->getDb()->fetchAll($sql);
        $extraIdlogcrashes = array_column($extraIdlogcrashes, 'idlogcrash');

        $idlogcrashes = array_merge($idlogcrashes, $extraIdlogcrashes);
        $idlogcrashes = array_unique($idlogcrashes);

        // check that none of the crashes are ignored, none of the crashes are inline and every crash
        // has the same source
        $sql = 'SELECT COUNT(DISTINCT resource_uri) AS resource_uris,
                    MAX(resource_uri) AS resource_uri,
                    SUM(CASE WHEN datetime_ignored_error IS NULL THEN 0 ELSE 1 END) AS ignored
                FROM ' . Common::prefixTable('log_crash') . ' WHERE idlogcrash IN (' . implode(',', $idlogcrashes) . ')';
        $counts = Db::fetchRow($sql);
        if ($counts['resource_uris'] > 1) {
            throw new \Exception('Unable to merge crashes with different source URIs.');
        }
        if (mb_strtolower(trim($counts['resource_uri'])) === 'inline') {
            throw new \Exception('Unable to merge inline crashes.');
        }
        if ($counts['ignored'] > 0) {
            throw new \Exception('Cannot merge ignored crashes.');
        }

        $idLogCrashToMergeTo = min($idlogcrashes);
        $sql = 'UPDATE ' . Common::prefixTable('log_crash') . ' SET group_idlogcrash = ? WHERE idlogcrash IN ('
            . implode(',', $idlogcrashes) . ')';

        $this->getDb()->query($sql, [$idLogCrashToMergeTo]);

        // update log crash group table
        $sql = 'SELECT MIN(datetime_first_seen) AS datetime_first_seen,
                MAX(datetime_last_seen) AS datetime_last_seen,
                MAX(datetime_last_reappeared) AS datetime_last_reappeared
            FROM ' . Common::prefixTable('log_crash') . '
            WHERE idlogcrash IN (' . implode(',', $idlogcrashes) . ')';
        $dateValues = $this->getDb()->fetchRow($sql);
        $this->logCrashGroup->record($idLogCrashToMergeTo, $dateValues, true);
    }

    public function unmergeCrashGroup($idLogCrash)
    {
        $idLogCrash = (int)$idLogCrash;

        $sql = 'SELECT SUM(CASE WHEN datetime_ignored_error IS NULL THEN 0 ELSE 1 END) FROM '
            . Common::prefixTable('log_crash') . ' WHERE group_idlogcrash = ?';
        $countIgnored = Db::fetchOne($sql, [$idLogCrash]);
        if ($countIgnored > 0) {
            throw new \Exception('Cannot unmerge ignored crashes');
        }

        $sql = 'UPDATE ' . Common::prefixTable('log_crash') . ' SET group_idlogcrash = NULL WHERE group_idlogcrash = ?';
        $updateCount = $this->getDb()->query($sql, [$idLogCrash])->rowCount();

        if ($updateCount) {
            $sql = 'SELECT datetime_first_seen, datetime_last_seen, datetime_last_reappeared
            FROM ' . Common::prefixTable('log_crash') . '
            WHERE idlogcrash = ?';
            $dateValues = $this->getDb()->fetchRow($sql, $idLogCrash);
            $this->logCrashGroup->record($idLogCrash, $dateValues, true);
        }
    }

    public function getCrashGroups($idSite): array
    {
        $sql = "SELECT * FROM " . Common::prefixTable(self::TABLE_NAME)
            . ' WHERE idsite = ? AND group_idlogcrash IS NOT NULL ORDER BY group_idlogcrash ASC, idlogcrash ASC';
        $rows = Db::fetchAll($sql, [$idSite]);

        $groups = [];
        foreach ($rows as $row) {
            $row['idsite'] = (int)$row['idsite'];
            $row['idlogcrash'] = (int)$row['idlogcrash'];

            $groupIdLogCrash = $row['group_idlogcrash'];
            if (empty($groups[$groupIdLogCrash])) {
                $groups[$groupIdLogCrash] = [];
            }
            $groups[$groupIdLogCrash][] = $row;
        }
        return $groups;
    }

    // TODO: test for exclude
    public function searchCrashMessagesForMerge(int $idSite, string $searchTerm, string $resourceUri, int $filter_limit,
                                                int $filter_offset, array $excludeIdLogCrashes = []): array
    {
        $extraWhere = '';
        if (!empty($excludeIdLogCrashes)) {
            $excludeIdLogCrashes = array_map('intval', $excludeIdLogCrashes);
            $extraWhere = ' AND idlogcrash NOT IN (' . implode(',', $excludeIdLogCrashes) . ')';
        }

        $sql = 'SELECT message, idlogcrash FROM ' . Common::prefixTable(self::TABLE_NAME)
            . ' WHERE idsite = ? AND resource_uri = ? AND message LIKE ? AND (group_idlogcrash IS NULL OR group_idlogcrash = idlogcrash) '
            . $extraWhere . '
                ORDER BY message
                LIMIT ' . min($filter_limit, 100) . ' OFFSET ' . $filter_offset;
        $bind = [
            $idSite,
            $resourceUri,
            '%' . $searchTerm . '%',
        ];

        $result = $this->getDb()->fetchAll($sql, $bind);
        foreach ($result as &$row) {
            $row['idlogcrash'] = (int)$row['idlogcrash'];
        }
        return $result;
    }

    private function transformCrashRow(array &$row)
    {
        $row['idsite'] = (int)$row['idsite'];
        $row['idlogcrash'] = (int)$row['idlogcrash'];
        if (!empty($row['group_idlogcrash'])) {
            $row['group_idlogcrash'] = (int)$row['group_idlogcrash'];
        }
    }
}
