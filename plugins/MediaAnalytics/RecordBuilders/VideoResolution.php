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

class VideoResolution extends Base
{
    public function getRecordMetadata(ArchiveProcessor $archiveProcessor): array
    {
        return [
            Record::make(Record::TYPE_BLOB, Archiver::RECORD_VIDEO_RESOLUTIONS),
        ];
    }

    protected function aggregate(ArchiveProcessor $archiveProcessor): array
    {
        $videoResolutions = new DataTableBuilder();
        $groupBy = 'log_media.resolution';
        $where = ' AND char_length(log_media.resolution) > 5 AND log_media.media_type = ' . MediaAnalytics::MEDIA_TYPE_VIDEO;

        $this->makeRegularReport($archiveProcessor, [$videoResolutions], $where, $groupBy);

        return [Archiver::RECORD_VIDEO_RESOLUTIONS => $videoResolutions->getDataTable()];
    }
}
