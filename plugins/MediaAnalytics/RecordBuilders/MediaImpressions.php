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
use Piwik\Plugins\MediaAnalytics\Metrics;
use Piwik\Plugins\MediaAnalytics\Archiver;

class MediaImpressions extends Base
{
    public function getRecordMetadata(ArchiveProcessor $archiveProcessor): array
    {
        return [
            Record::make(Record::TYPE_NUMERIC, Archiver::NUMERIC_RECORD_PREFIX . Metrics::METRIC_NB_IMPRESSIONS),
            Record::make(Record::TYPE_NUMERIC, Archiver::NUMERIC_RECORD_PREFIX . Metrics::METRIC_NB_IMPRESSIONS_BY_UNIQUE_VISITORS),
        ];
    }

    protected function aggregate(ArchiveProcessor $archiveProcessor): array
    {
        $aggregator = new Archiver\Aggregator($archiveProcessor->getLogAggregator(), $archiveProcessor->getParams()->getSegment(), $this->configuration);

        $select = sprintf(
            'count(log_media.idvisit) as %s, count(distinct log_media.idvisitor) as %s',
            Metrics::METRIC_NB_IMPRESSIONS,
            Metrics::METRIC_NB_IMPRESSIONS_BY_UNIQUE_VISITORS
        );
        $cursor = $aggregator->query($select, $where = '', $groupBy = '', $orderBy = '');
        $row = $cursor->fetch();

        return [
            Archiver::NUMERIC_RECORD_PREFIX . Metrics::METRIC_NB_IMPRESSIONS => $row[Metrics::METRIC_NB_IMPRESSIONS],
            Archiver::NUMERIC_RECORD_PREFIX . Metrics::METRIC_NB_IMPRESSIONS_BY_UNIQUE_VISITORS => $row[Metrics::METRIC_NB_IMPRESSIONS_BY_UNIQUE_VISITORS],
        ];
    }
}
