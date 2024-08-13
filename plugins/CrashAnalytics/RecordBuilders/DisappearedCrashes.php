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

namespace Piwik\Plugins\CrashAnalytics\RecordBuilders;

use Piwik\ArchiveProcessor;
use Piwik\ArchiveProcessor\Record;
use Piwik\DataTable;
use Piwik\Date;
use Piwik\Plugins\CrashAnalytics\Archiver\LogAggregator;
use Piwik\Plugins\CrashAnalytics\Metrics;

class DisappearedCrashes extends Base
{
    const DISAPPEARED_RECORD_NAME = 'CrashAnalytics_DisappearedCrashes';

    public function getRecordMetadata(ArchiveProcessor $archiveProcessor): array
    {
        return [
            Record::make(Record::TYPE_BLOB, self::DISAPPEARED_RECORD_NAME),
            Record::make(Record::TYPE_NUMERIC, 'CrashAnalytics_' . Metrics::DISAPPEARED_CRASHES),
        ];
    }

    protected function aggregate(ArchiveProcessor $archiveProcessor): array
    {
        $archiveParams = $archiveProcessor->getParams();
        if ($archiveParams->getDateStart()->isToday()
            || $this->isYesterday($archiveParams->getDateStart())
        ) {
            return []; // not supported for dates other than today and yesterday
        }

        $logAggregator = new LogAggregator($archiveProcessor->getLogAggregator(), $archiveParams);

        $disappearedRecord = new DataTable();

        $cursor = $logAggregator->queryDisappearedCrashes($archiveParams);
        while ($disappearedRow = $cursor->fetch()) {
            $label = json_encode([$disappearedRow['message'], $disappearedRow['resource_uri']]);

            // there should not be an existing row, but checking just in case to avoid a fatal error
            if (!$disappearedRecord->getRowFromLabel($label)) {
                $columns = [
                    'idlogcrash' => $disappearedRow['idlogcrash'],
                    'crash_type' => $disappearedRow['crash_type'],
                ];

                $disappearedRecord->sumRowWithLabel($label, $columns);
            }
        }

        $nbDisappearedCrashes = $disappearedRecord->getRowsCount();

        $this->setTableAggregationOpsRecursively($disappearedRecord);

        return [
            self::DISAPPEARED_RECORD_NAME => $disappearedRecord,
            'CrashAnalytics_' . Metrics::DISAPPEARED_CRASHES => $nbDisappearedCrashes,
        ];
    }

    private function isYesterday(\Piwik\Date $date)
    {
        $yesterday = Date::yesterday()->toString();
        return $yesterday == $date->toString();
    }
}
