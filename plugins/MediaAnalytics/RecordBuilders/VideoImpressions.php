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
use Piwik\Plugins\MediaAnalytics\MediaAnalytics;
use Piwik\Plugins\MediaAnalytics\Metrics;
use Piwik\Plugins\MediaAnalytics\Archiver;

class VideoImpressions extends Base
{
    public function getRecordMetadata(ArchiveProcessor $archiveProcessor): array
    {
        return [
            Record::make(Record::TYPE_NUMERIC, Archiver::NUMERIC_RECORD_PREFIX . Metrics::METRIC_TOTAL_VIDEO_IMPRESSIONS),
        ];
    }

    protected function aggregate(ArchiveProcessor $archiveProcessor): array
    {
        $aggregator = new Archiver\Aggregator($archiveProcessor->getLogAggregator(), $archiveProcessor->getParams()->getSegment(), $this->configuration);

        $select = sprintf('count(log_media.idvisit) as %s', Metrics::METRIC_TOTAL_VIDEO_IMPRESSIONS);
        $cursor = $aggregator->query($select, $where = ' AND media_type = ' . MediaAnalytics::MEDIA_TYPE_VIDEO, $groupBy = '', $orderBy = '');

        $row = $cursor->fetch();

        return [
            Archiver::NUMERIC_RECORD_PREFIX . Metrics::METRIC_TOTAL_VIDEO_IMPRESSIONS => $row[Metrics::METRIC_TOTAL_VIDEO_IMPRESSIONS],
        ];
    }
}
