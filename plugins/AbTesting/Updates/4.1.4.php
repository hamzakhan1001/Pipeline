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

namespace Piwik\Plugins\AbTesting;

use Piwik\Archive\ArchiveInvalidator;
use Piwik\Common;
use Piwik\Date;
use Piwik\Db;
use Piwik\Plugins\AbTesting\Model\Experiments;
use Piwik\Updater;
use Piwik\Updates as PiwikUpdates;
use Piwik\Updater\Migration\Factory as MigrationFactory;

/**
 * Update for version 4.1.4
 */
class Updates_4_1_4 extends PiwikUpdates
{
    /**
     * @var MigrationFactory
     */
    private $migration;

    /**
     * @var ArchiveInvalidator
     */
    private $invalidator;

    public function __construct(MigrationFactory $factory, ArchiveInvalidator $invalidator)
    {
        $this->migration = $factory;
        $this->invalidator = $invalidator;
    }

    public function doUpdate(Updater $updater)
    {
        $threeMonthAgo = Date::now()->subMonth(3)->toString();

        $experiments = Db::fetchAll('SELECT * FROM ' . Common::prefixTable('experiments') . ' WHERE status = ? AND end_date >= ?', [Experiments::STATUS_FINISHED, $threeMonthAgo]);

        foreach ($experiments as $experiment) {
            // schedule rearchiving for the last day of the experiment to ensure we have a correct aggregated number of unique visitors
            $this->invalidator->scheduleReArchiving($experiment['idsite'], 'AbTesting', $experiment['idexperiment'], Date::factory($experiment['end_date'])->subDay(1)->getStartOfDay());
        }
    }
}