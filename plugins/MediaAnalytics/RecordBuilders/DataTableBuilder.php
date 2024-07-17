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

namespace Piwik\Plugins\MediaAnalytics\RecordBuilders;

use Piwik\DataTable;
use Piwik\Plugins\MediaAnalytics\Archiver;
use Piwik\Plugins\MediaAnalytics\Metrics;

/**
 * Takes rows from a log aggregation query result set and adds them to a DataTable.
 */
class DataTableBuilder
{
    /**
     * @var DataTable
     */
    protected $dataTable;

    /**
     * @var array
     */
    protected $queryRowColumnAggregationOps;

    public function __construct()
    {
        $multiPeriodColumnAggregationOps = Archiver::getColumnAggregationOpteration();

        $table = new DataTable();
        $table->setMetadata(DataTable::COLUMN_AGGREGATION_OPS_METADATA_NAME, $multiPeriodColumnAggregationOps);
        $table->filterSubtables(function (DataTable $subtable) use ($multiPeriodColumnAggregationOps) {
            $subtable->setMetadata(DataTable::COLUMN_AGGREGATION_OPS_METADATA_NAME, $multiPeriodColumnAggregationOps);
        });
        $this->dataTable = $table;

        $this->queryRowColumnAggregationOps = array_merge(
            $multiPeriodColumnAggregationOps,
            ['url' => function ($thisColumnValue, $columnToSumValue) {
                // NOTE: the order of these conditions is swapped compared to Archiver::getColumnAggregationOpteration().
                // this was done to keep the behavior the same as before after removing the use of DataArrays.
                if (!empty($columnToSumValue)){
                    return $columnToSumValue;
                }
                if (!empty($thisColumnValue)) {
                    return $thisColumnValue;
                }

                return false;
            }]
        );
    }

    public function addRow(array $resultSetRow): void
    {
        $label = $this->getLabelToUse($resultSetRow['label']);
        unset($resultSetRow['label']);

        $columns = self::createColumnsFromResultSetRow($resultSetRow);
        $this->dataTable->sumRowWithLabel($label, $columns, $this->queryRowColumnAggregationOps);
    }

    public function addRowToSubtable(string $secondaryDimension, $parentLabel, $label, array $resultSetRow): void
    {
        $parentLabel = $this->getLabelToUse($parentLabel);

        $topLevelRow = $this->dataTable->sumRowWithLabel($parentLabel, []);
        $secondLevelRow = $topLevelRow->sumRowWithLabelToSubtable($secondaryDimension, []);

        unset($resultSetRow['label']);
        $secondLevelRow->sumRowWithLabelToSubtable($label, $resultSetRow, $this->queryRowColumnAggregationOps);
    }

    public function getDataTable(): DataTable
    {
        return $this->dataTable;
    }

    public static function createColumnsFromResultSetRow(array $resultSetRow): array
    {
        return array(
            Metrics::METRIC_NB_PLAYS => $resultSetRow[Metrics::METRIC_NB_PLAYS] ?? 0,
            Metrics::METRIC_NB_PLAYS_BY_UNIQUE_VISITORS => $resultSetRow[Metrics::METRIC_NB_PLAYS_BY_UNIQUE_VISITORS] ?? 0,
            Metrics::METRIC_NB_IMPRESSIONS => $resultSetRow[Metrics::METRIC_NB_IMPRESSIONS] ?? 0,
            Metrics::METRIC_NB_IMPRESSIONS_BY_UNIQUE_VISITORS => $resultSetRow[Metrics::METRIC_NB_IMPRESSIONS_BY_UNIQUE_VISITORS] ?? 0,
            Metrics::METRIC_NB_FINISHES => $resultSetRow[Metrics::METRIC_NB_FINISHES] ?? 0,
            Metrics::METRIC_SUM_MEDIA_LENGTH => $resultSetRow[Metrics::METRIC_SUM_MEDIA_LENGTH] ?? 0,
            Metrics::METRIC_SUM_TIME_WATCHED => $resultSetRow[Metrics::METRIC_SUM_TIME_WATCHED] ?? 0,
            Metrics::METRIC_SUM_TIME_TO_PLAY => $resultSetRow[Metrics::METRIC_SUM_TIME_TO_PLAY] ?? 0,
            Metrics::METRIC_SUM_TIME_PROGRESS => $resultSetRow[Metrics::METRIC_SUM_TIME_PROGRESS] ?? 0,
            Metrics::METRIC_NB_PLAYS_WITH_TIME_TO_INITIAL_PLAY => $resultSetRow[Metrics::METRIC_NB_PLAYS_WITH_TIME_TO_INITIAL_PLAY] ?? 0,
            Metrics::METRIC_NB_PLAYS_WITH_MEDIA_LENGTH => $resultSetRow[Metrics::METRIC_NB_PLAYS_WITH_MEDIA_LENGTH] ?? 0,
            Metrics::METRIC_SUM_FULLSCREEN_PLAYS => $resultSetRow[Metrics::METRIC_SUM_FULLSCREEN_PLAYS] ?? 0,
        );
    }

    protected function isEmptyLabel($label): bool
    {
        return !isset($label) || $label === '' || $label === false;
    }

    protected function getLabelToUse(string $labelInDb): string
    {
        if ($this->isEmptyLabel($labelInDb)) {
            return Archiver::LABEL_NOT_DEFINED;
        }
        return $labelInDb;
    }
}
