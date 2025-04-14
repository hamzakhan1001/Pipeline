<?php
/*!
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

namespace Piwik\Plugins\CrashAnalytics;

use Piwik\Plugins\CrashAnalytics\Dao\LogCrash;
use Piwik\Plugins\CrashAnalytics\Dao\LogCrashEvent;
use Piwik\Plugins\CrashAnalytics\Dao\LogCrashStack;
use Piwik\Plugins\SitesManager\Model;
use Piwik\Log\LoggerInterface;
use Piwik\Config;

class Tasks extends \Piwik\Plugin\Tasks
{
    /**
     * @var LogCrashEvent
     */
    private $logCrashEvent;

    /**
     * @var LogCrashStack
     */
    private $logCrashStack;

    /**
     * @var LogCrash
     */
    private $logCrash;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(LogCrashEvent $logCrashEvent, LogCrashStack $logCrashStack, LoggerInterface $logger, Configuration $configuration,
                                LogCrash $logCrash)
    {
        $this->logCrashEvent = $logCrashEvent;
        $this->logCrashStack = $logCrashStack;
        $this->logger = $logger;
        $this->configuration = $configuration;
        $this->logCrash = $logCrash;
    }

    public function schedule()
    {
        $this->weekly('removeCrashDataForDeletedSites');
        $this->daily('removeOldCrashEvents');
        $this->daily('removeOldCrashes');
        $this->weekly('removeOldCrashStacks');
    }

    public function removeOldCrashEvents()
    {
        $loopMax = 500;
        $index = 0;
        $numDeleted = 0;

        $deleteOlderThan = $this->configuration->getDeleteCrashDataOlderThan();

        // default to core delete_logs_older_than if there is one
        if ($deleteOlderThan <= 0) {
            $this->logger->info('[CrashAnalytics] delete_crash_data_older_than is not set or is set to an invalid value, defaulting to [Deletelogs] delete_logs_older_than value.');

            $deleteOlderThan = (int)Config::getInstance()->Deletelogs['delete_logs_older_than'];
            if ($deleteOlderThan <= 0) {
                $this->logger->info('[CrashAnalytics] delete_crash_data_older_than is not set or is set to an invalid value and [Deletelogs] delete_logs_older_than is not set, skipping purging.');
                return;
            }
        }

        $model = new Model();
        $idSites = $model->getSitesId();

        do {
            if ($index > $loopMax) {
                $this->logger->info(sprintf('Deleted %s log crash evens so far and stopping because of too many loops. Next time will delete again.', $numDeleted));

                return; // safety loop... delete max 25M rows per table in one cronjob (500 loops * 50k max entries)
            }
            $index++;

            $deletedThisIteration = $this->logCrashEvent->deleteOldCrashEvents($maxEntries = 50000, $deleteOlderThan, $idSites);
            $numDeleted += $deletedThisIteration;
        } while (!empty($deletedThisIteration));

        $this->logger->info(sprintf('Deleted %s log crash events', $numDeleted));
    }

    public function removeOldCrashStacks()
    {
        [$sql, $numDeleted] = $this->logCrashStack->deleteUnusedStackEntries();
        $this->logger->info(sprintf('Deleted %s log crash stack entries', $numDeleted));
    }

    public function removeOldCrashes()
    {
        $loopMax = 500;
        $index = 0;
        $numDeleted = 0;

        $deleteOlderThan = $this->configuration->getConsiderCrashNewAfterNDays();

        // default to core delete_logs_older_than if there is one
        if ($deleteOlderThan <= 0) {
            $this->logger->info('[CrashAnalytics] consider_crash_new_after_n_days set to 0, skipping deletion of old log_crash entries so reoccurrences will be considered new.');
            return;
        }

        do {
            if ($index > $loopMax) {
                $this->logger->info(sprintf('Deleted %s log crashes so far and stopping because of too many loops. Next time will delete again.', $numDeleted));

                return; // safety loop... delete max 25M rows per table in one cronjob (500 loops * 50k max entries)
            }
            $index++;

            $deletedThisIteration = $this->logCrash->deleteOldCrashes($maxEntries = 50000, $deleteOlderThan);
            $numDeleted += $deletedThisIteration;
        } while (!empty($deletedThisIteration));

        $this->logger->info(sprintf('Deleted %s log crash rows', $numDeleted));
    }

    public function removeCrashDataForDeletedSites()
    {
        $model = new Model();
        $idSites = $model->getSitesId();

        $this->removeLogCrashEventsForDeletedSites($idSites);
        $this->removeLogCrashesForDeletedSites($idSites);
    }

    private function removeLogCrashEventsForDeletedSites(array $idSites)
    {
        $loopMax = 500;
        $index = 0;
        $numDeleted = 0;

        do {
            if ($index > $loopMax) {
                $this->logger->info(sprintf('Deleted %s log crash events so far and stopping because of too many loops. Next time will delete again.', $numDeleted));

                return; // safety loop... delete max 25M rows per table in one cronjob (500 loops * 50k max entries)
            }
            $index++;

            $deletedThisIteration = $this->logCrashEvent->deleteForSitesNotIn($maxEntries = 50000, $idSites);
            $numDeleted += $deletedThisIteration;
        } while (!empty($deletedThisIteration));

        $this->logger->info(sprintf('Deleted %s log crash event rows', $numDeleted));
    }

    private function removeLogCrashesForDeletedSites(array $idSites)
    {
        $loopMax = 500;
        $index = 0;
        $numDeleted = 0;

        do {
            if ($index > $loopMax) {
                $this->logger->info(sprintf('Deleted %s log crash so far and stopping because of too many loops. Next time will delete again.', $numDeleted));

                return; // safety loop... delete max 25M rows per table in one cronjob (500 loops * 50k max entries)
            }
            $index++;

            $deletedThisIteration = $this->logCrash->deleteForSitesNotIn($maxEntries = 50000, $idSites);
            $numDeleted += $deletedThisIteration;
        } while (!empty($deletedThisIteration));

        $this->logger->info(sprintf('Deleted %s log crash rows', $numDeleted));
    }
}