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

use Piwik\API\Request;
use Piwik\Common;
use Piwik\Db;
use Piwik\Updater;
use Piwik\Updates as PiwikUpdates;
use Piwik\Updater\Migration\Factory as MigrationFactory;

class Updates_5_2_1 extends PiwikUpdates
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
        return [];
    }

    public function doUpdate(Updater $updater)
    {
        $updater->executeMigrations(__FILE__, $this->getMigrations($updater));

        $db = Db::get();
        $table =  Common::prefixTable('site_conversion_export');
        $exports = $db->fetchAll("Select * from `$table` where deleted = 0");
        if (!is_array($exports)) {
            return;
        }
        $goalsList = [];
        $model = new Model();
        foreach ($exports as $export) {
            if (!isset($goalsList[$export['idsite']])) {
                $goalsList[$export['idsite']] = Request::processRequest('Goals.getGoals', ['idSite' => $export['idsite'], 'filter_limit' => '-1'], $default = []);
            }
            $parameters = \json_decode($export['parameters'], true);
            if (!empty($parameters['goals'])) {
                foreach ($parameters['goals'] as &$parameter) {
                    if (empty($parameter['name']) && isset($goalsList[$export['idsite']][$parameter['idgoal']]['name'])) {
                        $parameter['name'] = substr($goalsList[$export['idsite']][$parameter['idgoal']]['name'], 0, 50);
                    } elseif (empty($parameter['name']) && $parameter['idgoal'] == 0) {
                        $parameter['name'] = 'Ecommerce Orders';
                    }
                }
            }
            $model->update($export['idexport'], $export['idsite'], $export['name'], $export['type'], $export['description'], $parameters);
        }
    }
}
