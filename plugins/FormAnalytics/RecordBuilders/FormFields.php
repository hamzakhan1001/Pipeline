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

namespace Piwik\Plugins\FormAnalytics\RecordBuilders;

use Piwik\ArchiveProcessor;
use Piwik\Plugins\FormAnalytics\Archiver;
use Piwik\Plugins\FormAnalytics\Archiver\LogAggregator;
use Piwik\Plugins\FormAnalytics\Metrics;

class FormFields extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->columnToSortByBeforeTruncation = Metrics::SUM_FORM_VIEWS;
    }

    public function getRecordMetadata(ArchiveProcessor $archiveProcessor): array
    {
        return $this->getRecordMetadataForFormBlobRecords($archiveProcessor, Archiver::FORM_FIELDS_RECORD);
    }

    protected function aggregate(ArchiveProcessor $archiveProcessor): array
    {
        $idSite = $archiveProcessor->getParams()->getSite()->getId();
        if (empty($idSite)) {
            return [];
        }

        $dataTables = $this->makeDataTablesForForms($idSite);

        $aggregator = new LogAggregator($archiveProcessor->getLogAggregator());

        $cursor = $aggregator->aggregateFields();
        $this->addRowsToDataTables($dataTables, $cursor);
        unset($cursor);

        $cursor = $aggregator->aggregateSubmittedFields();
        $this->addRowsToDataTables($dataTables, $cursor);
        unset($cursor);

        $cursor = $aggregator->aggregateConvertedFields();
        $this->addRowsToDataTables($dataTables, $cursor);
        unset($cursor);

        $dataTablesByRecordName = $this->getDataTablesByRecordName($dataTables, Archiver::FORM_FIELDS_RECORD);
        return $dataTablesByRecordName;
    }

    protected function getRecordRowFromCursorRow(array $cursorRow): array
    {
        $emptyRow = [
            Metrics::SUM_FIELD_TIME_SPENT => 0,
            Metrics::SUM_FIELD_HESITATION_TIME => 0,
            Metrics::SUM_FIELD_FIELDSIZE => 0,
            Metrics::SUM_FIELD_FIELDSIZE_UNSUBMITTED => 0,
            Metrics::SUM_FIELD_FIELDSIZE_SUBMITTED => 0,
            Metrics::SUM_FIELD_FIELDSIZE_CONVERTED => 0,
            Metrics::SUM_FIELD_UNIQUE_AMENDMENTS => 0,
            Metrics::SUM_FIELD_UNIQUE_REFOCUS => 0,
            Metrics::SUM_FIELD_UNIQUE_INTERACTIONS => 0,
            Metrics::SUM_FIELD_CONVERTED => 0,
            Metrics::SUM_FIELD_SUBMITTED => 0,
            Metrics::SUM_FIELD_LEFTBLANK_SUBMITTED => 0,
            Metrics::SUM_FIELD_LEFTBLANK_CONVERTED => 0,
        ];

        return array_merge($emptyRow, $cursorRow);
    }
}
