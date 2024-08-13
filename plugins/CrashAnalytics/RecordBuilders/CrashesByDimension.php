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
use Piwik\Plugins\CrashAnalytics\Metrics;
use Piwik\RankingQuery;

abstract class CrashesByDimension extends Base
{
    /**
     * Gets the dimension column to create a record around.
     *
     * @return string
     */
    abstract public function getDimensionColumn(): string;

    public function getLabelSelect(): string
    {
        return '';
    }

    public function getExtraFrom(): array
    {
        return [];
    }

    public function getExtraMetrics(): array
    {
        return [];
    }

    public function getRecordMetadata(ArchiveProcessor $archiveProcessor): array
    {
        return [
            Record::make(Record::TYPE_BLOB, static::RECORD_NAME),
        ];
    }

    protected function aggregate(ArchiveProcessor $archiveProcessor): array
    {
        $logAggregator = new LogAggregator($archiveProcessor->getLogAggregator(), $archiveProcessor->getParams());

        $dimension = $this->getDimensionColumn();

        $extraLabelSelect = $this->getLabelSelect();
        if (!empty($extraLabelSelect)) {
            $extraLabelSelect .= ' AS label';
        } else {
            $extraLabelSelect = "$dimension AS label";
        }

        $record = new DataTable();
        $this->aggregateRootTable($logAggregator, $record, $dimension, $extraLabelSelect);
        $this->aggregateSubtables($logAggregator, $record, $dimension, $extraLabelSelect);

        $this->setTableAggregationOpsRecursively($record);

        return [static::RECORD_NAME => $record];
    }

    protected function getSubtableRowLabel(array $resultSetRow): string
    {
        return json_encode([$resultSetRow['message'], $resultSetRow['resource_uri']]);
    }

    private function aggregateRootTable(LogAggregator $logAggregator, DataTable $record, $dimension, $extraLabelSelect): void
    {
        $extraFrom = $this->getExtraFrom();

        $extraMetrics = $this->getExtraMetrics();
        $metrics = array_merge([Metrics::CRASH_OCCURRENCES, Metrics::VISITS_WITH_CRASH], array_keys($extraMetrics));

        $rankingQuery = null;
        if ($this->rankingQueryLimit > 0) {
            $rankingQuery = new RankingQuery($this->rankingQueryLimit);
            $rankingQuery->addLabelColumn(['label']);
            $rankingQuery->addColumn(Metrics::CRASH_OCCURRENCES, 'sum');
            $rankingQuery->addColumn(Metrics::VISITS_WITH_CRASH);
            foreach ($extraMetrics as $name => $aggregation) {
                $rankingQuery->addColumn($name, $aggregation);
            }
        }

        // aggregate root table
        $cursor = $logAggregator->aggregateCrashEvents(
            $dimension,
            $extraLabelSelect,
            $extraFrom,
            $metrics,
            false,
            $rankingQuery
        );
        while ($resultSetRow = $cursor->fetch()) {
            $label = $resultSetRow['label'] ?: '';

            $columns = [
                Metrics::CRASH_OCCURRENCES => $resultSetRow[Metrics::CRASH_OCCURRENCES],
                Metrics::VISITS_WITH_CRASH => $resultSetRow[Metrics::VISITS_WITH_CRASH],
            ];

            foreach ($extraMetrics as $name => $aggregation) {
                $columns[$name] = $resultSetRow[$name];
            }

            $record->sumRowWithLabel($label, $columns);
        }
        $cursor->closeCursor();
    }

    private function aggregateSubtables(LogAggregator $logAggregator, DataTable $record, $dimension, $extraLabelSelect): void
    {
        $extraFrom = $this->getExtraFrom();

        $extraMetrics = $this->getExtraMetrics();
        $metrics = array_merge([Metrics::CRASH_OCCURRENCES, Metrics::VISITS_WITH_CRASH], array_keys($extraMetrics));

        $groupBy = 'log_crash_resolved.idlogcrash';
        $extraSelects = $extraLabelSelect . ', ' . implode(', ', [
            'log_crash_resolved.idlogcrash',
            'log_crash_resolved.resource_uri',
            'log_crash_resolved.message AS message',
            'log_crash_resolved.crash_type AS crash_type',
        ]);

        if ($dimension != 'log_crash_resolved.resource_uri') {
            $groupBy .= ', ' . $dimension;
        }

        $subtableExtraFrom = $extraFrom;
        $subtableExtraFrom[] = [
            'table' => 'log_crash',
            'tableAlias' => 'log_crash_original',
            'joinOn' => 'log_crash_event.idlogcrash = log_crash_original.idlogcrash',
        ];
        $subtableExtraFrom[] = [
            'table' => 'log_crash',
            'tableAlias' => 'log_crash_resolved',
            'joinOn' => 'log_crash_resolved.idlogcrash = IFNULL(log_crash_original.group_idlogcrash, log_crash_original.idlogcrash)',
        ];

        $rankingQuery = null;
        if ($this->rankingQueryLimit > 0) {
            $rankingQuery = new RankingQuery($this->rankingQueryLimit);
            $rankingQuery->addLabelColumn(['label', 'idlogcrash']);
            $rankingQuery->addColumn('message');
            if ($dimension != 'log_crash_resolved.resource_uri') {
                $rankingQuery->addColumn('resource_uri');
            }
            $rankingQuery->addColumn('crash_type');
            $rankingQuery->addColumn(Metrics::CRASH_OCCURRENCES, 'sum');
            $rankingQuery->addColumn(Metrics::VISITS_WITH_CRASH);
            foreach ($extraMetrics as $name => $aggregation) {
                $rankingQuery->addColumn($name, $aggregation);
            }
        }

        $cursor = $logAggregator->aggregateCrashEvents(
            $groupBy,
            $extraSelects,
            $subtableExtraFrom,
            $metrics,
            $includeIgnored = false,
            $rankingQuery
        );
        while ($resultSetRow = $cursor->fetch()) {
            $rootTableLabel = $resultSetRow['label'] ?: '';

            $rootTableRow = $record->getRowFromLabel($rootTableLabel);
            if (empty($rootTableRow) && $rootTableLabel !== RankingQuery::LABEL_SUMMARY_ROW) {
                $rootTableRow = $record->getSummaryRow();
            }
            if (empty($rootTableRow)) {
                continue;
            }

            $label = $this->getSubtableRowLabel($resultSetRow);
            $columns = [
                Metrics::CRASH_OCCURRENCES => $resultSetRow[Metrics::CRASH_OCCURRENCES],
                Metrics::VISITS_WITH_CRASH => $resultSetRow[Metrics::VISITS_WITH_CRASH],
            ];
            if ($rootTableLabel != RankingQuery::LABEL_SUMMARY_ROW) {
                $columns['crash_type'] = $resultSetRow['crash_type'];
                $columns['idlogcrash'] = $resultSetRow['idlogcrash'];
            }

            foreach ($extraMetrics as $name => $aggregation) {
                $columns[$name] = $resultSetRow[$name];
            }

            $rootTableRow->sumRowWithLabelToSubtable($label, $columns);
        }
        $cursor->closeCursor();
    }
}
