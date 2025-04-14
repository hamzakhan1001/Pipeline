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

class FunnelExits extends ActionsRecordBuilder
{
    public function getRecordMetadata(ArchiveProcessor $archiveProcessor): array
    {
        $recordName = Archiver::completeRecordName(Archiver::FUNNELS_EXITS_RECORD, $this->funnel['idfunnel'], $this->funnel['revision']);
        return [
            Record::make(Record::TYPE_BLOB, $recordName),
        ];
    }

    protected function aggregate(ArchiveProcessor $archiveProcessor): array
    {
        $aggregator = new Archiver\LogAggregator($archiveProcessor->getLogAggregator());

        $funnel = $this->funnel;
        $idFunnel = (int) $funnel['idfunnel'];

        $record = new DataTable();
        $this->initializeRecord($record);

        $cursor = $aggregator->aggregateExitActions($idFunnel);
        $this->addRowsToDataArray($record, $cursor);
        $cursor->closeCursor();

        $recordName = Archiver::completeRecordName(Archiver::FUNNELS_EXITS_RECORD, $idFunnel, $funnel['revision']);

        return [$recordName => $record];
    }
}
