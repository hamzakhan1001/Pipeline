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
use Piwik\Db;
use Piwik\DbHelper;

class LogCrashStack
{
    const TABLE_NAME = 'log_crash_stack';

    /**
     * @var Db|Db\AdapterInterface|\Piwik\Tracker\Db
     */
    private $db;

    private function getDb()
    {
        if (!isset($this->db)) {
            $this->db = Db::get();
        }
        return $this->db;
    }

    public function install()
    {
        DbHelper::createTable(self::TABLE_NAME, "
            `idlogcrashstack` BIGINT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `hash` INT(10) UNSIGNED NOT NULL,
            `compressed` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
            `value` MEDIUMBLOB NULL DEFAULT NULL,
            PRIMARY KEY (`idlogcrashstack`),
            INDEX (`hash`)
        ");

        // we always build the hash on the raw text for simplicity
    }

    public function uninstall()
    {
        Db::query(sprintf('DROP TABLE IF EXISTS `%s`', Common::prefixTable(self::TABLE_NAME)));
    }

    public function findEntry($textHash, $text, $textCompressed)
    {
        $sql = sprintf('SELECT idlogcrashstack FROM %s WHERE `hash` = ? and (`value` = ? or `value` = ?) LIMIT 1', Common::prefixTable(self::TABLE_NAME));
        $id = $this->getDb()->fetchOne($sql, array($textHash, $text, $textCompressed));

        return $id;
    }

    public function createEntry($textHash, $text, $isCompressed)
    {
        $sql = sprintf('INSERT INTO %s (`hash`, `compressed`, `value`) VALUES(?,?,?) ', Common::prefixTable(self::TABLE_NAME));
        $this->getDb()->query($sql, array($textHash, (int) $isCompressed, $text));

        return $this->getDb()->lastInsertId();
    }

    public function record($text)
    {
        if ($text === null || $text === false) {
            return null;
        }

        $normalizedText = self::normalizeText($text);

        $textHash = abs(crc32($normalizedText));
        $textCompressed = $this->compress($text);

        $id = $this->findEntry($textHash, $text, $textCompressed);

        if (!empty($id)) {
            return $id;
        }

        $isCompressed = 0;
        if ($text !== $textCompressed && strlen($textCompressed) < strlen($text)) {
            // detect if it is more efficient to store compressed or raw text
            $text = $textCompressed;
            $isCompressed = 1;
        }

        return $this->createEntry($textHash, $text, $isCompressed);
    }

    public function deleteUnusedStackEntries()
    {
        $eventTable = Common::prefixTable('log_crash_event');
        $blobTable = Common::prefixTable('log_crash_stack');

        $blobEntries = Db::fetchAll('SELECT distinct idlogcrashstack FROM ' . $eventTable . ' LIMIT 2');
        $blobEntries = array_filter($blobEntries, function ($val) {
            return $val['idlogcrashstack'] !== null;
        }); // remove null values.

        if (empty($blobEntries)) {
            // no longer any blobs in use... delete all blobs
            $sql = 'DELETE FROM ' . $blobTable;
            $query = Db::query($sql);
            return [$sql, $query->rowCount()];
        }

        $indexSql = 'FORCE INDEX FOR JOIN (idlogcrashstack)';

        $sql = sprintf('DELETE crashblob
            FROM %s crashblob
            LEFT JOIN %s crashevent %s on crashblob.idlogcrashstack = crashevent.idlogcrashstack
            WHERE crashevent.idlogcrashevent is null', $blobTable, $eventTable, $indexSql);

        $query = Db::query($sql);
        return [$sql, $query->rowCount()];
    }

    public function getAllRecords()
    {
        $blobs = $this->getDb()->fetchAll('SELECT * FROM ' . Common::prefixTable(self::TABLE_NAME));
        return $this->enrichRecords($blobs);
    }

    private function enrichRecords($blobs)
    {
        if (!empty($blobs)) {
            foreach ($blobs as $index => &$blob) {
                if (!empty($blob['compressed'])) {
                    $blob['value'] = $this->uncompress($blob['value']);
                }
            }
        }

        return $blobs;
    }

    private function compress($data)
    {
        if (!empty($data)) {
            return gzcompress($data);
        }

        return $data;
    }

    public function uncompress($data)
    {
        if (!empty($data)) {
            return gzuncompress($data);
        }

        return $data;
    }

    public static function normalizeText($text)
    {
        $text = preg_replace('/\s+/', ' ', $text);
        $text = mb_strtolower($text);
        $text = trim($text);
        return $text;
    }
}

