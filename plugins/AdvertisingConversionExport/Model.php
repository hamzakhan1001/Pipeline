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

namespace Piwik\Plugins\AdvertisingConversionExport;

use Piwik\Common;
use Piwik\Date;
use Piwik\Db;
use Piwik\DbHelper;
use Piwik\Site;

class Model
{
    private $tableName = 'site_conversion_export';
    private $tablePrefixed;

    public function __construct()
    {
        $this->tablePrefixed = Common::prefixTable($this->tableName);
    }

    /**
     * Creates table
     */
    public function install(): void
    {
        $table = "`idexport` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                  `idsite` INT(11) NOT NULL,
                  `access_token` VARCHAR(100) NOT NULL,
                  `name` VARCHAR(50) NOT NULL,
                  `type` VARCHAR(15) NOT NULL,
                  `description` VARCHAR(1000) NOT NULL,
                  `parameters` LONGTEXT NOT NULL,
                  `ts_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  `ts_modified` TIMESTAMP NOT NULL DEFAULT 0,
                  `ts_requested` TIMESTAMP NULL DEFAULT NULL,
                  `deleted` TINYINT(1) NOT NULL DEFAULT '0',
                  PRIMARY KEY (`idexport`),
                  UNIQUE INDEX `access_token` (`access_token`)";

        DbHelper::createTable($this->tableName, $table);
    }

    public function uninstall(): void
    {
        Db::query(sprintf('DROP TABLE IF EXISTS `%s`', $this->tablePrefixed));
    }

    /**
     * Adds a new export
     *
     * @param int    $idSite
     * @param string $name
     * @param string $description
     * @param string $accessToken
     * @param array  $parameters
     * @throws \Zend_Db_Adapter_Exception
     * @return int id of the new export
     */
    public function add(int $idSite, string $name, string $type, string $description, string $accessToken, array $parameters): int
    {
        $db = $this->getDatabase();
        $db->insert($this->tablePrefixed, [
            'idsite'       => $idSite,
            'name'         => $name,
            'type'         => $type,
            'description'  => $description,
            'access_token' => $accessToken,
            'parameters'   => json_encode($parameters),
            'ts_modified' => Date::now()->getDatetime(),
        ]);

        return $db->lastInsertId();
    }

    /**
     * Updates the given export
     *
     * @param int    $idExport
     * @param int    $idSite
     * @param string $name
     * @param string $description
     * @param array  $parameters
     * @throws \Zend_Db_Adapter_Exception
     */
    public function update(int $idExport, int $idSite, string $name, string $type, string $description, array $parameters): void
    {
        $db = $this->getDatabase();
        $db->update($this->tablePrefixed, [
            'name'        => $name,
            'type'        => $type,
            'description' => $description,
            'parameters'  => json_encode($parameters),
            'ts_modified' => Date::now()->getDatetime(),
        ], 'idexport = ' . (int)$idExport . ' AND idsite = ' . (int)$idSite);
    }

    /**
     * Updates the access token for the given export
     *
     * @param int    $idExport
     * @param string $accessToken
     * @throws \Zend_Db_Adapter_Exception
     */
    public function updateAccessToken(int $idExport, string $accessToken): void
    {
        $db = $this->getDatabase();
        $db->update($this->tablePrefixed, [
            'access_token' => $accessToken,
            'ts_modified'  => Date::now()->getDatetime(),
        ], 'idexport = ' . (int)$idExport);
    }

    /**
     * Returns an export by the given access token
     *
     * @param $accessToken
     * @return array
     * @throws \Throwable
     */
    public function getByAccessToken($accessToken): array
    {
        $query = sprintf(
            'SELECT * FROM %s WHERE `access_token` = ? AND `deleted` = 0',
            $this->tablePrefixed
        );

        $entry = $this->getDatabase()->fetchRow($query, [$accessToken]);

        if (empty($entry)) {
            return [];
        }

        $entry = $this->enrichEntry($entry);

        return $entry;
    }

    /**
     * Returns an export by the given access token
     *
     * @param int $idExport
     * @return array
     * @throws \Throwable
     */
    public function getByIdExport($idExport): array
    {
        $query = sprintf(
            'SELECT * FROM %s WHERE `idexport` = ? AND `deleted` = 0',
            $this->tablePrefixed
        );

        $entry = $this->getDatabase()->fetchRow($query, [$idExport]);

        if (empty($entry)) {
            return [];
        }

        $entry = $this->enrichEntry($entry);

        return $entry;
    }

    /**
     * Returns the configured conversion exports for the given sites
     *
     * @param int[]|string $idSites ids of the sites to fetch entries for, can be an array of ints or a string like 1,2
     *                              or all
     *
     * @return array
     */
    public function getEntries($idSites): array
    {
        if (!is_array($idSites)) {
            $idSites = Site::getIdSitesFromIdSitesString($idSites);
        }

        $idSites = array_map('intval', $idSites);

        $query = sprintf(
            'SELECT * FROM %s WHERE `idsite` IN (%s) AND `deleted` = 0 ORDER BY `ts_created` ASC',
            $this->tablePrefixed,
            implode(', ', $idSites)
        );

        $entries = $this->getDatabase()->fetchAll($query);

        foreach ($entries as &$entry) {
            $entry = $this->enrichEntry($entry);
        }

        return $entries;
    }

    public function updateRequestTime($idExport): void
    {
        $db = $this->getDatabase();
        $db->update($this->tablePrefixed, [
            'ts_requested' => Date::now()->getDatetime(),
        ], 'idexport = ' . (int)$idExport);
    }

    /**
     * Returns the configured conversion exports for the given sites
     *
     * @param int $idSites id of the site to fetch distinct exports configured like Google,Bing,Yandex
     *
     * @return array
     */
    public function getAllConfiguredExportTypes(int $idSite): array
    {
        $types = [];

        $query = sprintf(
            'SELECT distinct type FROM %s  WHERE `idsite`=%s AND `deleted` = 0 ',
            $this->tablePrefixed,
            ((int) $idSite)
        );

        $entries = $this->getDatabase()->fetchAll($query);

        foreach ($entries as &$entry) {
            if (!empty($entry['type'])) {
                $types[$entry['type']] = $entry['type'];
            }
        }

        return $types;
    }


    /**
     * Marks the given export as deleted
     *
     * Note: Exports will only be "soft" deleted. This can be reverted by manually updating the db record
     *
     * @param int $idExport
     */
    public function deleteEntry($idExport): void
    {
        $db = $this->getDatabase();
        $db->update($this->tablePrefixed, [
            'deleted' => '1',
        ], 'idexport = ' . (int)$idExport);
    }

    /**
     * @return \Piwik\Db\AdapterInterface|Db\Adapter\Mysqli|Db\Adapter\Pdo\Mysql
     */
    protected function getDatabase()
    {
        return Db::get();
    }

    private function enrichEntry($entry)
    {
        if (!empty($entry['parameters'])) {
            $entry['parameters'] = \json_decode($entry['parameters'], true);
        }

        $entry['ts_requested_pretty'] = isset($entry['ts_requested'])
            ? Date::factory($entry['ts_requested'])->getLocalized('M/d/yy h:mm a')
            : null;

        return $entry;
    }
}
