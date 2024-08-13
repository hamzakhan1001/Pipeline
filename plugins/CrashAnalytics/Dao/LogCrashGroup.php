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

class LogCrashGroup
{
    const TABLE_NAME = 'log_crash_group';

    /**
     * @var Db|Db\AdapterInterface|\Piwik\Tracker\Db
     */
    private $db;

    private $tableColumns = [
        'idlogcrash' => 'BIGINT UNSIGNED NOT NULL AUTO_INCREMENT',
        'datetime_first_seen' => 'DATETIME NULL',
        'datetime_last_seen' => 'DATETIME NULL',
        'datetime_last_reappeared' => 'DATETIME NULL',
    ];

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
            INDEX lastseen (`datetime_last_seen`)
        ");
    }

    public function uninstall()
    {
        Db::query(sprintf('DROP TABLE IF EXISTS `%s`', Common::prefixTable(self::TABLE_NAME)));
    }

    public function record($idlogcrash, $values, $forceOverwrite = false)
    {
        $columnSetFunctions = [
            'datetime_first_seen' => 'LEAST',
            'datetime_last_seen' => 'GREATEST',
            'datetime_last_reappeared' => 'GREATEST',
        ];

        $table = Common::prefixTable(self::TABLE_NAME);

        $columns = array_keys($values);
        $placeholders = array_map(function () { return '?'; }, $columns);

        $sql = "INSERT INTO $table (idlogcrash, " . implode(',', $columns) . ")
            VALUES (?, " . implode(',', $placeholders) . ")
            ON DUPLICATE KEY
            UPDATE ";

        // bind values for INSERT
        $bind = array_merge(
            [$idlogcrash],
            array_values($values)
        );

        $updates = [];
        foreach ($columns as $column) {
            if ($forceOverwrite) {
                $updates[] = $column . ' = ?';
            } else {
                $updates[] = $column . ' = IF(' . $column . ' IS NULL, ?, ' . $columnSetFunctions[$column] . '(' . $column . ', ?))';
            }
        }

        $sql .= implode(', ', $updates);

        // bind values for UPDATE
        foreach (array_values($values) as $value) {
            if ($forceOverwrite) {
                $bind[] = $value;
            } else {
                $bind[] = $value;
                $bind[] = $value;
            }
        }

        Db::query($sql, $bind);
    }
}