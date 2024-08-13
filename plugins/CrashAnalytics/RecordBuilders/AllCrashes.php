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
use Piwik\Plugins\CrashAnalytics\Archiver\LogAggregator;
use Piwik\Plugins\CrashAnalytics\MeasurableSettings;
use Piwik\Plugins\CrashAnalytics\Metrics;
use Piwik\RankingQuery;

class AllCrashes extends Base
{
    const ALL_CRASHES_RECORD_NAME = 'CrashAnalytics_AllCrashes';

    public function getRecordMetadata(ArchiveProcessor $archiveProcessor): array
    {
        return [
            Record::make(Record::TYPE_BLOB, self::ALL_CRASHES_RECORD_NAME),
            Record::make(Record::TYPE_NUMERIC, 'CrashAnalytics_' . Metrics::NEW_CRASHES),
            Record::make(Record::TYPE_NUMERIC, 'CrashAnalytics_' . Metrics::REAPPEARED_CRASHES),
        ];
    }

    protected function aggregate(ArchiveProcessor $archiveProcessor): array
    {
        $allCrashesRecord = new DataTable();

        $nbReappearedCrashes = 0;
        $nbNewCrashes = 0;

        $settings = new MeasurableSettings($archiveProcessor->getParams()->getSite()->getId());
        $daysUntilConsideredDisappeared = $settings->daysUntilConsideredDisappeared->getValue();

        $disappearedStartTime = $archiveProcessor->getParams()->getDateTimeEnd()->subDay($daysUntilConsideredDisappeared);

        $startTimeDate = $archiveProcessor->getParams()->getDateTimeStart();
        $endTimeDate = $archiveProcessor->getParams()->getDateTimeEnd();

        $extraSelects = [
            'IFNULL(log_crash_resolved.idlogcrash, log_crash_event.idlogcrash) AS idlogcrash',
            'log_crash_resolved.message AS message',
            'log_crash_resolved.resource_uri AS resource_uri',
            'log_crash_resolved.crash_type AS crash_type',
            'MIN(log_crash_resolved.datetime_first_seen) >= \'' . $startTimeDate->getDatetime() . '\' AND MIN(log_crash_resolved.datetime_first_seen) <= \'' . $endTimeDate->getDatetime() . '\' AS ' . Metrics::NEW_CRASHES,
            'MIN(log_crash_event.prev_last_seen) <= \'' . $disappearedStartTime->getDatetime() . '\' AS ' . Metrics::REAPPEARED_CRASHES,
        ];

        $rankingQuery = null;
        if ($this->rankingQueryLimit > 0) {
            $rankingQuery = new RankingQuery($this->rankingQueryLimit);
            $rankingQuery->addLabelColumn(['idlogcrash']);
            $rankingQuery->addColumn('message');
            $rankingQuery->addColumn('resource_uri');
            $rankingQuery->addColumn('crash_type');
            $rankingQuery->addColumn(Metrics::NEW_CRASHES, 'sum');
            $rankingQuery->addColumn(Metrics::REAPPEARED_CRASHES, 'sum');
        }

        $logAggregator = new LogAggregator($archiveProcessor->getLogAggregator(), $archiveProcessor->getParams());
        $cursor = $logAggregator->aggregateCrashEvents(
            'idlogcrash',
            implode(',', $extraSelects),
            [
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
            ],
            null,
            false,
            $rankingQuery
        );
        while ($resultSetRow = $cursor->fetch()) {
            if ($resultSetRow['idlogcrash'] == RankingQuery::LABEL_SUMMARY_ROW) {
                $label = $resultSetRow['idlogcrash'];
                $existingRow = $allCrashesRecord->getSummaryRow();
            } else {
                $label = json_encode([$resultSetRow['message'], $resultSetRow['resource_uri']]);
                $existingRow = $allCrashesRecord->getRowFromLabel($label);
            }

            // there should not be an existing row, but checking just in case to avoid a fatal error
            if (!$existingRow) {
                $idLogCrash = $resultSetRow['idlogcrash'] == RankingQuery::LABEL_SUMMARY_ROW ? null : $resultSetRow['idlogcrash'];

                $nbNew = (int)$resultSetRow[Metrics::NEW_CRASHES];
                $nbReappeared = (int)$resultSetRow[Metrics::REAPPEARED_CRASHES];

                $columns = [
                    Metrics::CRASH_OCCURRENCES => $resultSetRow[Metrics::CRASH_OCCURRENCES],
                    Metrics::VISITS_WITH_CRASH => $resultSetRow[Metrics::VISITS_WITH_CRASH],
                    Metrics::NEW_CRASHES => $nbNew,
                    Metrics::REAPPEARED_CRASHES => $nbReappeared,
                ];
                if (!empty($idLogCrash)) {
                    $columns['idlogcrash'] = $idLogCrash;
                    $columns['crash_type'] = $resultSetRow['crash_type'];
                }

                if ($nbReappeared) {
                    ++$nbReappearedCrashes;
                }

                if ($nbNew) {
                    ++$nbNewCrashes;
                }

                $allCrashesRecord->sumRowWithLabel($label, $columns);
            }
        }
        $cursor->closeCursor();

        $this->setTableAggregationOpsRecursively($allCrashesRecord);

        return [
            self::ALL_CRASHES_RECORD_NAME => $allCrashesRecord,
            'CrashAnalytics_' . Metrics::NEW_CRASHES => $nbNewCrashes,
            'CrashAnalytics_' . Metrics::REAPPEARED_CRASHES => $nbReappearedCrashes,
        ];
    }
}
