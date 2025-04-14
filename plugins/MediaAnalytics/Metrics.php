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

class Metrics
{
    public const METRIC_NB_PLAYS = 'nb_plays';
    public const METRIC_NB_PLAYS_BY_UNIQUE_VISITORS = 'nb_unique_visitors_plays';
    public const METRIC_NB_IMPRESSIONS = 'nb_impressions';
    public const METRIC_NB_IMPRESSIONS_BY_UNIQUE_VISITORS = 'nb_unique_visitors_impressions';
    public const METRIC_NB_FINISHES = 'nb_finishes';
    public const METRIC_NB_PLAYS_WITH_TIME_TO_INITIAL_PLAY = 'nb_plays_with_tip';
    public const METRIC_NB_PLAYS_WITH_MEDIA_LENGTH = 'nb_plays_with_ml';
    public const METRIC_NB_UNIQUE_VISITORS = 'nb_uniq_visitors';

    public const METRIC_AVG_TIME_TO_PLAY = 'avg_time_to_play';
    public const METRIC_AVG_TIME_WATCHED = 'avg_time_watched';
    public const METRIC_AVG_COMPLETION = 'avg_completion_rate';
    public const METRIC_AVG_MEDIA_LENGTH = 'avg_media_length';
    public const METRIC_PLAY_RATE = 'play_rate';
    public const METRIC_FINISH_RATE = 'finish_rate';
    public const METRIC_FULLSCREEN_RATE = 'fullscreen_rate';
    public const METRIC_IMPRESSION_RATE = 'impression_rate';

    public const METRIC_MAX_MEDIA_LENGTH = 'max_media_length';

    public const METRIC_TOTAL_TIME_WATCHED = 'sum_total_time_watched';
    public const METRIC_TOTAL_AUDIO_PLAYS = 'sum_total_audio_plays';
    public const METRIC_TOTAL_AUDIO_IMPRESSIONS = 'sum_total_audio_impressions';
    public const METRIC_TOTAL_VIDEO_PLAYS = 'sum_total_video_plays';
    public const METRIC_TOTAL_VIDEO_IMPRESSIONS = 'sum_total_video_impressions';

    public const METRIC_SUM_PLAYS = 'sum_plays';
    public const METRIC_SUM_FULLSCREEN_PLAYS = 'sum_fullscreen_plays';
    public const METRIC_SUM_TIME_TO_PLAY = 'sum_time_to_play';
    public const METRIC_SUM_TIME_WATCHED = 'sum_time_watched';
    public const METRIC_SUM_TIME_PROGRESS = 'sum_time_progress';
    public const METRIC_SUM_MEDIA_LENGTH = 'sum_media_length';
}
