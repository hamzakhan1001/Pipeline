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

use Matomo\Cache\Transient;
use Piwik\ArchiveProcessor;
use Piwik\ArchiveProcessor\Record;
use Piwik\Common;
use Piwik\DataTable;
use Piwik\Plugins\Funnels\Archiver;
use Piwik\Plugins\Funnels\Archiver\Populator;
use Piwik\Plugins\Funnels\Configuration;
use Piwik\Plugins\Funnels\Metrics;
use Piwik\Plugins\Funnels\Model\FunnelsModel;

class FunnelEntries extends ActionsRecordBuilder
{
    /**
     * @var int
     */
    private $maximumRowsInReferrers;

    public function __construct(
        array $funnel,
        Transient $cache,
        Populator $populator,
        FunnelsModel $funnelsModel,
        Configuration $configuration
    ) {
        parent::__construct($funnel, $cache, $populator, $funnelsModel, $configuration);
        $this->maximumRowsInReferrers = $configuration->getMaxRowsInReferrers();
        $this->columnToSortByBeforeTruncation = Metrics::NUM_HITS;
    }

    public function getRecordMetadata(ArchiveProcessor $archiveProcessor): array
    {
        $recordName = Archiver::completeRecordName(Archiver::FUNNELS_ENTRIES_RECORD, $this->funnel['idfunnel'], $this->funnel['revision']);
        return [
            Record::make(Record::TYPE_BLOB, $recordName),
        ];
    }

    protected function aggregate(ArchiveProcessor $archiveProcessor): array
    {
        $aggregator = new Archiver\LogAggregator($archiveProcessor->getLogAggregator());

        $funnel = $this->funnel;
        $idFunnel = (int) $funnel['idfunnel'];

        $cursor = $aggregator->aggregateActionReferrers($idFunnel);
        $referrers = new DataTable();
        $this->addRowsToDataArray($referrers, $cursor);
        $cursor->closeCursor();

        $referrers->filterSubtables(function (DataTable $table) {
            $table->setMetadata(DataTable::COLUMN_AGGREGATION_OPS_METADATA_NAME, $this->columnAggregationOps);
        });

        $referrers->filterSubtables(DataTable\Filter\Truncate::class, [
            $this->maximumRowsInReferrers,
            DataTable::LABEL_SUMMARY_ROW,
            Metrics::NUM_HITS,
        ]);

        $record = new DataTable();
        $this->initializeRecord($record);

        $cursor = $aggregator->aggregateEntriesActions($idFunnel);
        $this->addRowsToDataArray($record, $cursor);
        $cursor->closeCursor();

        $this->setFunnelEntriesRecordReferrers($record, $referrers);
        Common::destroy($referrers);
        unset($referrers);

        $recordName = Archiver::completeRecordName(Archiver::FUNNELS_ENTRIES_RECORD, $idFunnel, $funnel['revision']);

        return [$recordName => $record];
    }

    private function setFunnelEntriesRecordReferrers(DataTable $record, DataTable $referrers): void
    {
        foreach ($record->getRowsWithoutSummaryRow() as $row) {
            $step = $row->getColumn('label');

            if ($subtable = $row->getSubtable()) {
                $rowVisitEntry = $subtable->getRowFromLabel(Archiver::LABEL_VISIT_ENTRY);
                // for visit entries, we want to set a subtable listing all referrers

                if (!empty($rowVisitEntry)) {
                    // find matching subtable for that step from referrers table
                    $refererStepRow = $referrers->getRowFromLabel($step);

                    if (!empty($refererStepRow) && $refererStepRow->getSubtable()) {
                        // move subtable from referrers table to funnel entries record
                        $rowVisitEntry->setSubtable($refererStepRow->getSubtable());
                        $refererStepRow->removeSubtable();
                    }
                }
            }
        }
    }
}
