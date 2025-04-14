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

namespace Piwik\Plugins\Funnels;

use Piwik\Date;
use Piwik\Plugins\Funnels\Dao\Funnel;
use Piwik\Plugins\Funnels\Dao\LogTable;
use Piwik\Plugins\SitesManager\API as APISitesManager;

class Tasks extends \Piwik\Plugin\Tasks
{
    /**
     * @var LogTable
     */
    private $logTable;

    /**
     * @var Funnel
     */
    private $funnel;

    public function __construct(LogTable $logTable, Funnel $funnel)
    {
        $this->logTable = $logTable;
        $this->funnel = $funnel;
    }

    public function schedule()
    {
        $this->daily('cleanupLogFunnel');
        $this->daily('cleanupFunnels');
        $this->weekly('truncateOlderLogFunnelRecords');
    }

    /**
     * For all sites, iterate over all active funnels and delete log_funnel records older than a week old. This is an
     * effort to keep the table smaller so that queries perform well. Previously, we didn't delete records from the
     * log_funnel table unless we were rebuilding the funnel data or the funnel was deactivated.
     *
     * @return void
     */
    public function truncateOlderLogFunnelRecords()
    {
        $lastWeek = Date::lastWeek();
        $allWebsites = APISitesManager::getInstance()->getAllSitesId();
        foreach ($allWebsites as $idSite) {
            $funnels = $this->funnel->getAllFunnelsForSite($idSite);
            foreach ($funnels as $funnel) {
                $this->logTable->deleteFunnelEntriesPastDateTime($funnel['idfunnel'], $lastWeek);
            }
        }
    }

    /**
     * We delete log funnel entries for funnels that have been disabled.
     */
    public function cleanupLogFunnel()
    {
        $idFunnels = $this->funnel->getDisabledFunnelIds();

        foreach ($idFunnels as $idFunnel) {
            $this->logTable->deleteFunnelEntries($idFunnel);
        }
    }

    /**
     * We delete old funnel entries that have been deleted more than 6 months ago
     */
    public function cleanupFunnels()
    {
        $dateTime = Date::now()->subMonth(6)->getDatetime();

        $idFunnels = $this->funnel->getDisabledFunnelIdsOlderThan($dateTime);

        foreach ($idFunnels as $idFunnel) {
            $this->funnel->deleteFunnel($idFunnel);
        }
    }
}
