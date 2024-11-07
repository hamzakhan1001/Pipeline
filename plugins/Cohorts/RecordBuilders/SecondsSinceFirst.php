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

namespace Piwik\Plugins\Cohorts\RecordBuilders;

use Piwik\ArchiveProcessor;
use Piwik\ArchiveProcessor\Record;
use Piwik\Container\StaticContainer;
use Piwik\DataTable;
use Piwik\Date;
use Piwik\Log\LoggerInterface;
use Piwik\Metrics;
use Piwik\Plugins\Cohorts\Archiver;
use Piwik\DataAccess\LogAggregator;
use Piwik\Version;

class SecondsSinceFirst extends Base
{
    public function getRecordMetadata(ArchiveProcessor $archiveProcessor): array
    {
        $period = $archiveProcessor->getParams()->getPeriod()->getLabel();
        return [
            Record::make(Record::TYPE_BLOB, Archiver::COHORTS_ARCHIVE_RECORD)
                ->setColumnToSortByBeforeTruncation($period == 'day' ? Metrics::INDEX_NB_UNIQ_VISITORS : Metrics::INDEX_NB_VISITS),
        ];
    }

    protected function aggregate(ArchiveProcessor $archiveProcessor): array
    {
        $timezone = $archiveProcessor->getParams()->getSite()->getTimezone();
        $siteTimezoneOffset = Date::getUtcOffset($timezone);
        $dimensions = [$this->getSelectDimension($archiveProcessor, $siteTimezoneOffset, 'day')];

        $logAggregator = $archiveProcessor->getLogAggregator();

        $result = new DataTable();

        $this->aggregateVisitLogs($logAggregator, $result, $dimensions);
        $this->aggregateConversionLogs($logAggregator, $result, $dimensions);

        return [Archiver::COHORTS_ARCHIVE_RECORD => $result];
    }

    protected function aggregateVisitLogs(LogAggregator $logAggregator, DataTable $result, array $dimensions, $metrics = false): void
    {
        /** @var \Zend_Db_Statement $query */
        $query = $logAggregator->queryVisitsByDimension($dimensions, $where = 'log_visit.visitor_seconds_since_first IS NOT NULL', $additionalSelects = [], $metrics);
        while ($row = $query->fetch()) {
            $label = $row['label'];

            $timeLabel = strtotime($label);
            if (empty($timeLabel)) {
                StaticContainer::get(LoggerInterface::class)->debug("Invalid label found: '{label}' in row: {row}", [
                    'label' => $label,
                    'row' => $row,
                ]);

                continue;
            }

            if (empty($metrics)) {
                $columns = [
                    Metrics::INDEX_NB_UNIQ_VISITORS => $row[Metrics::INDEX_NB_UNIQ_VISITORS],
                    Metrics::INDEX_NB_VISITS => $row[Metrics::INDEX_NB_VISITS],
                    Metrics::INDEX_NB_ACTIONS => $row[Metrics::INDEX_NB_ACTIONS],
                    Metrics::INDEX_NB_USERS => $row[Metrics::INDEX_NB_USERS],
                    Metrics::INDEX_MAX_ACTIONS => $row[Metrics::INDEX_MAX_ACTIONS],
                    Metrics::INDEX_SUM_VISIT_LENGTH => $row[Metrics::INDEX_SUM_VISIT_LENGTH],
                    Metrics::INDEX_BOUNCE_COUNT => $row[Metrics::INDEX_BOUNCE_COUNT],
                    Metrics::INDEX_NB_VISITS_CONVERTED => $row[Metrics::INDEX_NB_VISITS_CONVERTED],
                ];
            } else {
                $columns = [];
                foreach ($metrics as $metric) {
                    $columns[$metric] = (float)($row[$metric] ?? 0);
                }
            }

            $result->sumRowWithLabel($timeLabel, $columns);
        }
    }

    private function aggregateConversionLogs(LogAggregator $logAggregator, DataTable $result, array $dimensions): void
    {
        $extraFrom = [
            [
                'table' => 'log_visit',
                'joinOn' => 'log_visit.idvisit = log_conversion.idvisit',
            ],
        ];

        /** @var \Zend_Db_Statement $query */
        $query = version_compare(Version::VERSION, '5.2.0-b6', '>=')
            ? $logAggregator->queryConversionsByDimension($dimensions, $where = 'log_visit.visitor_seconds_since_first IS NOT NULL', $additionalSelects = [], $extraFrom, false, false, true)
            : $logAggregator->queryConversionsByDimension($dimensions, $where = 'log_visit.visitor_seconds_since_first IS NOT NULL', $additionalSelects = [], $extraFrom);
        while ($row = $query->fetch()) {
            $label = $row['label'];

            $timeLabel = strtotime($label);
            if (empty($timeLabel)) {
                StaticContainer::get(LoggerInterface::class)->debug("Invalid label found: '{label}' in row: {row}", [
                    'label' => $label,
                    'row' => $row,
                ]);

                continue;
            }

            $idGoal = (int) $row['idgoal'];
            $columns = [
                Metrics::INDEX_GOALS => [
                    $idGoal => Metrics::makeGoalColumnsRow($idGoal, $row),
                ],
            ];

            $result->sumRowWithLabel($timeLabel, $columns);
        }

        $result->filter(DataTable\Filter\EnrichRecordWithGoalMetricSums::class);
    }
}
