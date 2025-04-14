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

namespace Piwik\Plugins\MediaAnalytics;

use Piwik\DataTable\Row;
use Piwik\Plugins\MediaAnalytics\Dao\LogMediaPlays;
use Piwik\Plugins\MediaAnalytics\Widgets\BaseWidget;

/**
 * Class Archiver
 * @package Piwik\Plugins\MediaAnalytics
 */
class Archiver extends \Piwik\Plugin\Archiver
{
    public const RECORD_VIDEO_RESOURCES = "MediaAnalytics_video_resources_record";
    public const RECORD_VIDEO_GROUPEDRESOURCES = "MediaAnalytics_video_groupedresources_record";
    public const RECORD_VIDEO_TITLES = "MediaAnalytics_video_title_record";
    public const RECORD_VIDEO_RESOLUTIONS = "MediaAnalytics_video_resolutions_record";
    public const RECORD_VIDEO_HOURS = "MediaAnalytics_video_hours_record";

    public const RECORD_AUDIO_RESOURCES = "MediaAnalytics_audio_resources_record";
    public const RECORD_AUDIO_GROUPEDRESOURCES = "MediaAnalytics_audio_groupedresources_record";
    public const RECORD_AUDIO_TITLES = "MediaAnalytics_audio_title_record";
    public const RECORD_AUDIO_HOURS = "MediaAnalytics_audio_hours_record";

    public const RECORD_PLAYER_NAMES = "MediaAnalytics_playernames_record";

    public const NUMERIC_RECORD_PREFIX = 'MediaAnalytics_';

    public const LABEL_NOT_DEFINED = 'MEDIA_LABEL_NOT_DEFINED';

    public const SECONDARY_DIMENSION_HOURS = 'hours';
    public const SECONDARY_DIMENSION_RESOLUTION = 'resolution';
    public const SECONDARY_DIMENSION_SPENT_TIME = 'spent_time';
    public const SECONDARY_DIMENSION_MEDIA_PROGRESS = 'media_progress';
    public const SECONDARY_DIMENSION_MEDIA_SEGMENTS = 'media_segments';

    public const METADATA_ROW = 'metadata';
    public const GROUPED_MEDIA_SEGMENT_APPENDIX = '_grouped';

    public static function isUniqueVisitorsEnabled($periodLabel)
    {
        return $periodLabel === 'day';
    }

    public function getDependentSegmentsToArchive(): array
    {
        $segmentObj = $this->getParams()->getSegment();
        $segment = '';
        //getOriginalString is not available in lower matomo version like 4.2.1
        if (method_exists($segmentObj, 'getOriginalString')) {
            $segment = $segmentObj->getOriginalString();
        }
        $mediaSegment = BaseWidget::addMediaSegment($segment);

        return [
            ['plugin' => 'UserCountry', 'segment' => $mediaSegment],
        ];
    }

    private function getParams()
    {
        return $this->getProcessor()->getParams();
    }

    public static function putValueIntoSecondsBucket($value)
    {
        if ($value <= 10) {
            return $value;
        }

        $rest = 0;

        if ($value >= 21600) {
            $rest = $value % 1800; // after 6 hours we group watched time into buckets of 30 minutes
        } elseif ($value >= 10800) {
            $rest = $value % 900; // after 3 hours we group watched time into buckets of 15 minutes
        } elseif ($value >= 7201) {
            $rest = $value % 600; // after 2 hours we group watched time into buckets of 10 minutes
        } elseif ($value >= 3601) {
            $rest = $value % 300; // after 1 hour we group watched time into buckets of 5 minutes
        } elseif ($value >= 1201) {
            $rest = $value % 60; // after 10 minutes we group watched time into buckets of 1 minute
        } elseif ($value >= 301) {
            $rest = $value % 30; // after 5 minutes we group watched time into buckets of 30 seconds
        } elseif ($value >= 121) {
            $rest = $value % 20; // after 2 minutes we group watched time into buckets of 20 seconds
        } elseif ($value >= 61) {
            $rest = $value % 10; // after 1 minutes we group watched time into buckets of 10 seconds
        } elseif ($value >= 31) {
            $rest = $value % 5; // after 30 seconds we group watched time into buckets of 5 seconds
        } elseif ($value >= 11) {
            $rest = $value % 2; // after 10 seconds we group watched time into buckets of 2 seconds
        }

        return $value - $rest;
    }

    public static function getColumnAggregationOpteration()
    {
        return array(
            'url' => function ($thisColumnValue, $columnToSumValue, Row $thisRow, Row $thatRow) {
                if (
                    $thisRow->isSummaryRow()
                    || $thatRow->isSummaryRow()
                ) {
                    return null;
                }
                if (!empty($thisColumnValue)) {
                    return $thisColumnValue;
                }
                if (!empty($columnToSumValue)) {
                    return $columnToSumValue;
                }
            },
            Metrics::METRIC_SUM_PLAYS => 'sum',
            Metrics::METRIC_MAX_MEDIA_LENGTH => 'max',
        );
    }

    public static function getSecondaryDimensionMediaSegmentSelect($aggregation)
    {
        $segmentColumns = LogMediaPlays::getSegmentColumns();
        $groupedSegments = LogMediaPlays::getSmallGapsPerGroup();
        $select = '';

        $columnPrefix = '';
        $aggregationStart = '';
        $aggregationEnd = '';
        if ($aggregation === 'sum') {
            $aggregationStart = 'sum(';
            $aggregationEnd = ')';
            $columnPrefix = 'sum_';
        }

        foreach ($segmentColumns as $segmentColumn) {
            $select .= $aggregationStart . 'log_media_plays.' . $segmentColumn . $aggregationEnd . ' as ' . $columnPrefix . $segmentColumn . ',';
        }

        foreach ($groupedSegments as $groupedSegment => $smallSegments) {
            $smallSegments = array_map(function ($smallSegment) {
                return 'log_media_plays.' . LogMediaPlays::makeSegmentColumn($smallSegment);
            }, $smallSegments);

            $select .= $aggregationStart . 'GREATEST(' . implode(',', $smallSegments) . ')' . $aggregationEnd . ' as ' . $columnPrefix . LogMediaPlays::makeSegmentGroupColumn($groupedSegment) . ',';
        }
        $select = rtrim($select, ',');

        return $select;
    }
}
