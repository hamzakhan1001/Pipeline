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

use Piwik\ArchiveProcessor;
use Piwik\ArchiveProcessor\Record;
use Piwik\Plugins\MediaAnalytics\Archiver;
use Piwik\Plugins\MediaAnalytics\MediaAnalytics;
use Piwik\Plugins\MediaAnalytics\RecordBuilders\DataTableBuilders\HourTableBuilder;

class AudioHours extends Base
{
    public function getRecordMetadata(ArchiveProcessor $archiveProcessor): array
    {
        return [
            Record::make(Record::TYPE_BLOB, Archiver::RECORD_AUDIO_HOURS),
        ];
    }

    protected function aggregate(ArchiveProcessor $archiveProcessor): array
    {
        $hourTableBuilder = new HourTableBuilder($archiveProcessor->getParams());
        $groupBy = 'hour(log_media.server_time)';
        $where = ' AND log_media.media_type = ' . MediaAnalytics::MEDIA_TYPE_AUDIO;

        $this->makeRegularReport($archiveProcessor, [$hourTableBuilder], $where, $groupBy);

        return [Archiver::RECORD_AUDIO_HOURS => $hourTableBuilder->getDataTable()];
    }
}
