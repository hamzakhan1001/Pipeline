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

namespace Piwik\Plugins\AdvertisingConversionExport;

use Piwik\Common;
use Piwik\Db;
use Piwik\Updater;
use Piwik\Updates as PiwikUpdates;
use Piwik\Updater\Migration\Factory as MigrationFactory;

class Updates_5_2_0 extends PiwikUpdates
{
    /**
     * @var MigrationFactory
     */
    private $migration;

    public function __construct(MigrationFactory $factory)
    {
        $this->migration = $factory;
    }

    public function getMigrations(Updater $updater)
    {
        $migrations = [];
        // Set salt value
        $config = new Configuration();
        $salt = $config->getSalt();
        if (empty($salt)) {
            $salt = Common::generateUniqId();
            $config->setSalt($salt);
        }
        $db = Db::get();
        $table =  Common::prefixTable('site_conversion_export');
        $exports = $db->fetchAll("Select idexport, access_token from `$table`");
        if (!is_array($exports)) {
            return $migrations;
        }
        foreach ($exports as $export) {
            $migrations[] = $this->migration->db->sql('UPDATE `' . $table . '` SET access_token = "' . sha1($export['access_token'] . $salt) . '" where idexport = "' . $export['idexport'] . '"');
        }

        return $migrations;
    }

    public function doUpdate(Updater $updater)
    {
        $updater->executeMigrations(__FILE__, $this->getMigrations($updater));
    }
}
