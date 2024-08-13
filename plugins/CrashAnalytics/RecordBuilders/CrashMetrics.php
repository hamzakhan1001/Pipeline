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
use Piwik\Plugins\CrashAnalytics\Archiver\LogAggregator;
use Piwik\Plugins\CrashAnalytics\Metrics;

class CrashMetrics extends Base
{
    public function getRecordMetadata(ArchiveProcessor $archiveProcessor): array
    {
        return [
            Record::make(Record::TYPE_NUMERIC, 'CrashAnalytics_' . Metrics::CRASH_OCCURRENCES),
            Record::make(Record::TYPE_NUMERIC, 'CrashAnalytics_' . Metrics::UNIQUE_CRASHES),
            Record::make(Record::TYPE_NUMERIC, 'CrashAnalytics_' . Metrics::VISITS_WITH_CRASH),
            Record::make(Record::TYPE_NUMERIC, 'CrashAnalytics_' . Metrics::IGNORED_CRASHES),
        ];
    }

    protected function aggregate(ArchiveProcessor $archiveProcessor): array
    {
        $logAggregator = new LogAggregator($archiveProcessor->getLogAggregator(), $archiveProcessor->getParams());

        $extraFrom = [
            [
                'table' => 'log_crash',
                'tableAlias' => 'log_crash_original',
                'joinOn' => 'log_crash_event.idlogcrash = log_crash_original.idlogcrash',
            ],
            [
                'table' => 'log_crash',
                'tableAlias' => 'log_crash_resolved',
                'joinOn' => 'log_crash_resolved.idlogcrash = IFNULL(log_crash_original.group_idlogcrash, log_crash_original.idlogcrash)',
            ],
        ];

        $metrics = [
            Metrics::CRASH_OCCURRENCES,
            Metrics::UNIQUE_CRASHES,
            Metrics::VISITS_WITH_CRASH,
        ];

        $cursor = $logAggregator->aggregateCrashEvents('', '', $extraFrom, $metrics);
        $rows = $cursor->fetch();
        $cursor->closeCursor();

        $ignoredCrashes = $logAggregator->getIgnoredCrashCount();
        $rows[Metrics::IGNORED_CRASHES] = $ignoredCrashes;

        $result = [];
        foreach ($rows as $metric => $value) {
            $result['CrashAnalytics_' . $metric] = $value;
        }

        return $result;
    }
}
