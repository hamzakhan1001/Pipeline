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
 * @link    https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */

namespace Piwik\Plugins\AdvertisingConversionExport\Dao;

use Piwik\Common;
use Piwik\Db;
use Piwik\DbHelper;
use Piwik\Tracker;

class LogClickId
{
    /** @var string Name of the log table */
    private $table = 'log_clickid';
    private $tablePrefixed = '';

    /**
     * @var Db|Db\AdapterInterface|Tracker\Db
     */

    public function __construct()
    {
        $this->tablePrefixed = Common::prefixTable($this->table);
    }

    private function getDb()
    {
        return Db::get();
    }


    /**
     * Creates the required log table
     */
    public function install()
    {
        $table = "
                `idvisit` BIGINT(10) UNSIGNED NOT NULL,
                `idvisitor` BINARY(8) NOT NULL,
                `adclickid` VARCHAR(255) NULL DEFAULT NULL,
                `adprovider` VARCHAR(50) NULL DEFAULT NULL,
                `server_time` DATETIME NOT NULL,
                PRIMARY KEY (`idvisit`),
                INDEX `idvisitor` (`idvisitor`)
        ";

        DbHelper::createTable($this->table, $table);
    }

    /**
     * Removes the log table
     */
    public function uninstall()
    {
        Db::query(sprintf('DROP TABLE IF EXISTS `%s`', $this->tablePrefixed));
    }

    /**
     * Finds all visits with the given visit ids
     *
     * @param $idVisits
     * @return array
     * @throws Tracker\Db\DbException
     */
    public function findIdVisits($idVisits)
    {
        if (empty($idVisits)) {
            return [];
        }

        $idVisits = array_map('intval', $idVisits);

        $query = sprintf('SELECT * 
                                 FROM %s 
                                 WHERE idvisit IN (%s)', $this->tablePrefixed, implode(', ', $idVisits));
        return $this->getDb()->fetchAll($query);
    }

    /**
     * Inserts a new record with the given data
     *
     * @param $visit
     * @return int
     * @throws Tracker\Db\DbException
     */
    public function insertVisit($visit)
    {
        $fields = array_keys($visit);
        $fields = implode(", ", $fields);
        $values = Common::getSqlStringFieldsArray($visit);
        $table  = $this->tablePrefixed;

        $sql  = "INSERT INTO $table ($fields) VALUES ($values)";
        $bind = array_values($visit);

        $db = Tracker::getDatabase();
        $db->query($sql, $bind);

        return $db->lastInsertId();
    }
}
