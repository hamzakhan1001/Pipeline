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

namespace Piwik\Plugins\FormAnalytics;

use Piwik\Plugins\FormAnalytics\Dao\LogForm;
use Piwik\Log\LoggerInterface;

class Tasks extends \Piwik\Plugin\Tasks
{
    /**
     * @var LogForm
     */
    private $logForm;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LogForm $logForm, LoggerInterface $logger)
    {
        $this->logForm = $logForm;
        $this->logger = $logger;
    }

    public function schedule()
    {
        $this->monthly('removeDeletedFormLogEntries');
    }

    /**
     * To test execute the following command:
     * `./console core:run-scheduled-tasks "Piwik\Plugins\FormAnalytics\Tasks.removeDeletedFormLogEntries"`
     *
     * @throws \Exception
     */
    public function removeDeletedFormLogEntries()
    {
        $loopMax = 500;
        $index = 0;
        $numDeleted = 0;

        do {
            if ($index > $loopMax) {
                $this->logger->info(sprintf('Deleted %s log forms so far and stopping because of too many loops. Next time will delete again.', $numDeleted));

                return; // safety loop... delete max 25M rows per table in one cronjob (500 loops * 50k max entries)
            }
            $index++;

            $logForms = $this->logForm->findDeletedLogFormIds($maxEntries = 50000);
            $numDeleted += count($logForms);
            $this->logForm->deleteLogEntriesForRemovedForms($logForms);
        } while (!empty($logForms));

        $this->logger->info(sprintf('Deleted %s log forms', $numDeleted));
    }
}
