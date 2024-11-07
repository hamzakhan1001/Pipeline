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

namespace Piwik\Plugins\Funnels\RecordBuilders;

use Matomo\Cache\Transient;
use Piwik\ArchiveProcessor;
use Piwik\ArchiveProcessor\RecordBuilder;
use Piwik\Common;
use Piwik\Container\StaticContainer;
use Piwik\DataTable;
use Piwik\Date;
use Piwik\Db;
use Piwik\Log\LoggerInterface;
use Piwik\Plugins\Funnels\Archiver\LogFunnelOptionLogic;
use Piwik\Plugins\Funnels\Archiver\Populator;
use Piwik\Plugins\Funnels\Configuration;
use Piwik\Plugins\Funnels\Model\FunnelsModel;
use Piwik\SettingsPiwik;
use Piwik\Site;

abstract class Base extends RecordBuilder
{
    /**
     * @var array
     */
    protected $funnel;

    /**
     * @var Transient
     */
    private $cache;

    /**
     * @var Populator
     */
    private $populator;

    /**
     * @var FunnelsModel
     */
    private $funnels;

    public function __construct(
        array $funnel,
        Transient $cache,
        Populator $populator,
        FunnelsModel $funnelsModel,
        Configuration $configuration
    ) {
        parent::__construct();

        $this->cache = $cache;
        $this->funnel = $funnel;
        $this->populator = $populator;
        $this->funnels = $funnelsModel;

        $this->columnAggregationOps = [
            'referer_type' => function ($thisValue, $otherValue) {
                // edge case. when two different referrer types have the same label, instead of aggregating we unset the
                // referer_type as it cannot be clearly assigned to either.
                if ($thisValue != $otherValue) {
                    return '';
                }
                return $thisValue;
            },
        ];

        $this->maxRowsInTable = null;
        $this->maxRowsInSubtable = $configuration->getMaxRowsInActions();
    }

    public function buildFromLogs(ArchiveProcessor $archiveProcessor): void
    {
        $idSite = $archiveProcessor->getParams()->getSite()->getId();
        if (empty($idSite)) {
            return;
        }

        $populateSucceeded = $this->populateLogFunnel($archiveProcessor);
        if (!$populateSucceeded) {
            return;
        }

        parent::buildFromLogs($archiveProcessor);
    }

    /**
     * @param ArchiveProcessor $archiveProcessor
     * @return void
     */
    private function populateLogFunnel(ArchiveProcessor $archiveProcessor): bool
    {
        if (count($archiveProcessor->getParams()->getIdSites()) > 1) {
            return false;
        }

        $idSite = $archiveProcessor->getParams()->getSite()->getId();

        if ($this->hasPopulatedForArchiveRequest($archiveProcessor)) {
            return true;
        }

        $funnels = $this->getActivatedFunnelsWithSteps($idSite);

        // $startDateTime eg '2020-01-01 23:00:00';
        // $endDateTime eg '2020-01-02 22:59:59';
        $startDate = $archiveProcessor->getParams()->getDateStart();
        $endDate = $archiveProcessor->getParams()->getDateEnd();
        $startDateTime = $startDate->getDateStartUTC();
        $endDateTime = $endDate->getDateEndUTC();
        $startDateTimestamp = $startDate->getStartOfDay()->getTimestamp();
        $endDateTimestamp = $endDate->getEndOfDay()->getTimestamp();
        $segment = $archiveProcessor->getParams()->getSegment();
        $lfLogic = StaticContainer::get(LogFunnelOptionLogic::class);

        // PG-837 got rid of the check that didn't rebuild log_funnel for segments

        // prevent running a bug where archiving without segment starts at the same time several times eg when loading
        // dashboard
        $lock = 'funnels_populate_log_' . ((int)$idSite) . '_' . $startDate->toString('ymd') . '_' . $endDate->toString('ymd');
        $instanceId = SettingsPiwik::getPiwikInstanceId();
        if ($instanceId) {
            $mysqlMaxLockLength = 63;
            $lock .= $instanceId;
            if (Common::mb_strlen($lock) > $mysqlMaxLockLength) {
                $lock = Common::mb_substr($lock, 0, $mysqlMaxLockLength);
            }
        }

        $maxAllowedWait = 21600; // 21600 seconds = 6 hours
        if (Db::getDbLock($lock, $maxAllowedWait)) {
            try {
                /*
                 * Now that we have a lock, that means that the data in log_funnel should be complete. Let's check
                 * if we're processing for today and the minimum wait time has passed or if we're processing for a
                 * later date and any new actions have been recorded for our date range since the last archiving.
                 */
                // Since the Date::isToday() method has a bug, do our own isToday logic until it's fixed
                $siteTz = Site::getTimezoneFor($idSite);
                $now = Date::factory('now', $siteTz);
                $nowString = $now->toString();
                $dateString = $archiveProcessor->getParams()->getPeriod()->toString();
                $isToday = $nowString === $dateString;
                if (
                    ($isToday && $lfLogic->isOverTodaysRequiredWaitTime($idSite))
                    || (!$isToday && $lfLogic->hasThereBeenNewActionsSinceLastArchive($idSite, $startDateTimestamp, $endDateTimestamp))
                ) {
                    // Since things have changed, let's populate the max actions right now
                    $lfLogic->populateMaxLinkVisitActionsForDay($idSite, $startDateTimestamp, $endDateTimestamp);
                    // If we're archiving for today, update the option so that we can reference it later
                    if ($isToday) {
                        $lfLogic->updateLatestTodayFunnelArchiveOption($idSite);
                    }

                    // pre-populate log_funnel
                    foreach ($funnels as $funnel) {
                        $this->populator->deleteFunnelData($funnel, $startDateTime, $endDateTime);
                        $this->populator->populateLogFunnel($funnel, $startDateTime, $endDateTime);

                        $transactionLevel = null;
                        if (class_exists('\Piwik\Db\TransactionLevel')) {
                            // supported from Matomo 3.12.0
                            $transactionLevel = new Db\TransactionLevel($this->populator->getDb());
                            if ($transactionLevel->canLikelySetTransactionLevel()) {
                                $transactionLevel->setUncommitted();
                            }
                        }

                        // this might need to go into segmentation and always done before archiving, but depends on how we interpret
                        // action segments
                        $this->populator->updateEntryAndExitStep($funnel['idsite'], $funnel['idfunnel'], $startDateTime, $endDateTime);

                        if (!empty($transactionLevel)) {
                            $transactionLevel->restorePreviousStatus();
                        }
                    }
                }
            } catch (\Throwable $e) {
                Db::releaseDbLock($lock);

                throw $e;
            }

            Db::releaseDbLock($lock);
        } else {
            $message = "Funnel archiving has been waiting too long and is giving up.";
            $message .= " Site: {$idSite} Start date: {$startDate} End date: {$endDate}";
            if (!empty($segment) && !$segment->isEmpty()) {
                $message .= " Segment hash: {$segment->getHash()}";
            }

            StaticContainer::get(LoggerInterface::class)->warn($message);

            return false;
        }

        $this->markHasPopulatedForArchiveRequest($archiveProcessor);

        return true;
    }

    private function hasPopulatedForArchiveRequest(ArchiveProcessor $archiveProcessor): bool
    {
        // make sure we only populate log funnels once per archive request, instead of once
        // per RecordBuilder execution.
        $cacheKey = $this->getHasPopulatedForArchiveRequestCacheKey($archiveProcessor);
        $value = $this->cache->fetch($cacheKey);
        return $value;
    }

    private function markHasPopulatedForArchiveRequest(ArchiveProcessor $archiveProcessor): void
    {
        $cacheKey = $this->getHasPopulatedForArchiveRequestCacheKey($archiveProcessor);
        $this->cache->save($cacheKey, true);
    }

    private function getHasPopulatedForArchiveRequestCacheKey(ArchiveProcessor $archiveProcessor)
    {
        $params = $archiveProcessor->getParams();
        $keyPieces = [
            $params->getSite()->getId(),
            $params->getPeriod()->getLabel(),
            $params->getPeriod()->getRangeString(),
            $params->getSegment()->getHash(),
        ];

        $cacheKey = 'Funnels.RecordBuilder.populated.' . implode('.', $keyPieces);
        return $cacheKey;
    }

    protected function getActivatedFunnelsWithSteps($idSite)
    {
        if (!isset($idSite) || false === $idSite) {
            return [];
        }

        $funnelsWithoutSteps = $this->funnels->getAllActivatedFunnelsForSite($idSite);

        $funnels = [];
        foreach ($funnelsWithoutSteps as $funnel) {
            // in theory the system should prevent from being able to activate a funnel without step, but we make sure to
            // just ignore such funnels
            if (!empty($funnel['steps'])) {
                $funnels[] = $funnel;
            }
        }
        return $funnels;
    }

    protected function initializeRecord(DataTable $record, array $emptyRow = []): void
    {
        if (!empty($this->funnel['steps'])) {
            foreach ($this->funnel['steps'] as $step) {
                $label = $step['position'];
                $record->addRowFromSimpleArray(array_merge(['label' => $label], $emptyRow));
            }

            // If this is a funnel without a goal, don't add the extra step
            if (!empty($this->funnel['isNonGoalFunnel'])) {
                return;
            }

            // one more step for the actual conversion
            $record->addRowFromSimpleArray(array_merge(['label' => $this->funnel[FunnelsModel::KEY_FINAL_STEP_POSITION]], $emptyRow));
        }
    }
}
