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

use Piwik\ArchiveProcessor;
use Piwik\ArchiveProcessor\Record;
use Piwik\DataTable;
use Piwik\Plugins\Funnels\Archiver;
use Piwik\Plugins\Funnels\Metrics;
use Piwik\Plugins\Funnels\Model\FunnelsModel;

class FunnelFlow extends Base
{
    public function getRecordMetadata(ArchiveProcessor $archiveProcessor): array
    {
        $idFunnel = (int) $this->funnel['idfunnel'];
        $revision = $this->funnel['revision'];

        return [
            Record::make(Record::TYPE_BLOB, Archiver::completeRecordName(Archiver::FUNNELS_FLOW_RECORD, $idFunnel, $revision)),
            Record::make(Record::TYPE_NUMERIC, Archiver::completeRecordName(Archiver::FUNNELS_NUM_ENTRIES_RECORD, $idFunnel, $revision)),
            Record::make(Record::TYPE_NUMERIC, Archiver::completeRecordName(Archiver::FUNNELS_NUM_EXITS_RECORD, $idFunnel, $revision)),
            Record::make(Record::TYPE_NUMERIC, Archiver::completeRecordName(Archiver::FUNNELS_NUM_CONVERSIONS_RECORD, $idFunnel, $revision)),
        ];
    }

    protected function aggregate(ArchiveProcessor $archiveProcessor): array
    {
        $aggregator = new Archiver\LogAggregator($archiveProcessor->getLogAggregator());

        $funnel = $this->funnel;
        $idFunnel = (int) $funnel['idfunnel'];
        $revision = $funnel['revision'];

        $records = [];

        $recordFlow = Archiver::completeRecordName(Archiver::FUNNELS_FLOW_RECORD, $idFunnel, $revision);

        $recordNumEntries = Archiver::completeRecordName(Archiver::FUNNELS_NUM_ENTRIES_RECORD, $idFunnel, $revision);
        $recordNumExits = Archiver::completeRecordName(Archiver::FUNNELS_NUM_EXITS_RECORD, $idFunnel, $revision);
        $recordNumConversions = Archiver::completeRecordName(Archiver::FUNNELS_NUM_CONVERSIONS_RECORD, $idFunnel, $revision);

        $emptyRow = [
            Metrics::NUM_STEP_VISITS_ACTUAL => 0,
            Metrics::NUM_STEP_ENTRIES => 0,
            Metrics::NUM_STEP_EXITS => 0,
        ];

        $flowRecord = new DataTable();
        $this->initializeRecord($flowRecord, $emptyRow);

        $cursor = $aggregator->aggregateNumHitsPerStep($idFunnel);
        $this->addRowsToDataArray($flowRecord, $cursor, $emptyRow);

        $cursor = $aggregator->aggregateNumEntriesPerStep($idFunnel);
        $this->addRowsToDataArray($flowRecord, $cursor, $emptyRow);

        $cursor = $aggregator->aggregateNumExitsPerStep($idFunnel);
        $this->addRowsToDataArray($flowRecord, $cursor, $emptyRow);

        $cursor->closeCursor();
        unset($cursor);

        $records[$recordNumEntries] = $this->getNumEntries($flowRecord);
        $records[$recordNumExits] = $this->getNumExits($flowRecord);
        $records[$recordNumConversions] = $this->getNumConversions($flowRecord);

        $records[$recordFlow] = $flowRecord;

        return $records;
    }

    private function getNumEntries(DataTable $flowRecord): float
    {
        return array_sum($flowRecord->getColumn(Metrics::NUM_STEP_ENTRIES));
    }

    private function getNumExits(DataTable $flowRecord): float
    {
        $lastStepPosition = $this->getLastStepPosition();

        $exits = 0;
        foreach ($flowRecord->getRows() as $row) {
            if ($row->getColumn('label') == $lastStepPosition) {
                // we need to ignore exits from last step
                continue;
            }

            if (!empty($row->getColumn(Metrics::NUM_STEP_EXITS))) {
                $exits += $row->getColumn(Metrics::NUM_STEP_EXITS);
            }
        }
        return $exits;
    }

    private function getNumConversions(DataTable $flowRecord): float
    {
        $lastStepPosition = $this->getLastStepPosition();

        $conversions = 0;

        $lastStepRow = $flowRecord->getRowFromLabel($lastStepPosition);
        if (!empty($lastStepRow) && $lastStepRow->getColumn(Metrics::NUM_STEP_VISITS_ACTUAL)) {
            $conversions = $lastStepRow->getColumn(Metrics::NUM_STEP_VISITS_ACTUAL);
        }

        return $conversions;
    }

    private function getLastStepPosition(): ?float
    {
        $lastStepPosition = null;
        if (!empty($this->funnel[FunnelsModel::KEY_FINAL_STEP_POSITION])) {
            $lastStepPosition = $this->funnel[FunnelsModel::KEY_FINAL_STEP_POSITION];
        }
        return $lastStepPosition;
    }

    protected function addRowsToDataArray(DataTable $record, $cursor, array $emptyRow): void
    {
        while ($row = $cursor->fetch()) {
            $label = $row['label'];
            unset($row['label']);

            $columns = array_merge($emptyRow, $row);

            $record->sumRowWithLabel($label, $columns);
        }
        $cursor->closeCursor();
    }
}
