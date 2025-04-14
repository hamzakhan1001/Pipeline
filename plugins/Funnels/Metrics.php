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

namespace Piwik\Plugins\Funnels;

class Metrics
{
    /**
     * Used for action reports when eg listing the entry / exit URLs
     */
    public const NUM_HITS = 'nb_hits';

    /**
     * Used for funnel steps
     */
    public const NUM_STEP_ENTRIES = 'step_nb_entries';
    public const NUM_STEP_EXITS = 'step_nb_exits';
    public const NUM_STEP_PROCEEDS = 'step_nb_proceeded';
    public const NUM_STEP_VISITS = 'step_nb_visits';
    public const NUM_STEP_VISITS_ACTUAL = 'step_nb_visits_actual';
    public const RATE_PROCEEDED = 'step_proceeded_rate';
    public const RATE_EXITED = 'step_exited_rate';
    public const NUM_STEP_SKIPS = 'step_nb_skipped';
    public const NUM_STEP_PROGRESSIONS = 'step_nb_progressions';

    /**
     * Used for metrics that apply to the funnel as a total
     */
    public const SUM_FUNNEL_ENTRIES = 'funnel_sum_entries';
    public const SUM_FUNNEL_EXITS = 'funnel_sum_exits';
    public const NUM_CONVERSIONS = 'funnel_nb_conversions';
    public const RATE_CONVERSION = 'funnel_conversion_rate';
    public const RATE_ABANDONED = 'funnel_abandoned_rate';
}
