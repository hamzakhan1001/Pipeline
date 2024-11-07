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

namespace Piwik\Plugins\Funnels\Reports;

use Piwik\Date;
use Piwik\NumberFormatter;
use Piwik\Period;
use Piwik\Plugins\Funnels\Metrics;

class FunnelReportProcessor
{
    private $numberFormatter;

    public function __construct(NumberFormatter $numberFormatter)
    {
        $this->numberFormatter = $numberFormatter;
    }

    /**
     * Returns a formatted string representing the given period.
     *
     * If the period is a Day, the formatted string will be in the format "Mon DD, YYYY" (e.g., "Apr 26, 2024").
     * For other period types, the formatted string will be the localized long string representation of the period.
     *
     * @param Period $period The period object.
     * @return string The formatted date string.
     */
    public function getCustomFormattedDate(Period $period): string
    {

        if ($period instanceof \Piwik\Period\Day) {
            // getLocalizedLongString would give us "Friday, April 26, 2024" but we'd prefer the shorter "Apr 26, 2024"
            // Not simply switching to getLocalizedShortString because that'll actually give us "Fri, Apr 26" which is not what we want
            $date = $period->toString();
            $date = Date::factory($date);
            $formatter = new \Piwik\Intl\Data\Provider\DateTimeFormatProvider();
            $pattern = $formatter->getFormatPattern(\Piwik\Intl\Data\Provider\DateTimeFormatProvider::DATE_FORMAT_SHORT);
            $formattedString = $date->getLocalized($pattern, true);
            // $formattedString = $date->getLocalized(Date::DATE_FORMAT_SHORT);
        } else {
            $formattedString = $period->getLocalizedLongString();
            $formattedString = ucfirst($formattedString);
        }

        return $formattedString;
    }

    /**
     * Calculates and sets metrics for each row in the funnel flow.
     *
     * @param array &$flowRows The funnel flow rows to be processed.
     * @param int $totalVisits The total number of visits for the funnel.
     * @return int The maximum height among all the rows.
     */
    public function calculateAndSetRowMetrics(array &$flowRows, int $totalVisits): int
    {
        $maxHeight = 0;
        foreach ($flowRows as $index => &$row) {
            $conversionRate = $totalVisits > 0 ? $row[Metrics::NUM_STEP_VISITS_ACTUAL] / $totalVisits : 0;
            $row['conversion_rate'] = $this->numberFormatter->formatPercent($conversionRate * 100, 1);

            $exitRate = $row[Metrics::NUM_STEP_VISITS_ACTUAL] > 0 ? ($row[Metrics::NUM_STEP_EXITS] / $row[Metrics::NUM_STEP_VISITS_ACTUAL]) * 100 : 0;
            $row['step_rate_exits'] = $this->numberFormatter->formatPercent($exitRate, 1);

            if ($index === 0) {
                $row['step_nb_previous_proceeded'] = 0;
                $row['step_nb_previous_exits'] = null;
                $row['height'] = $row[Metrics::NUM_STEP_VISITS_ACTUAL];
            } else {
                $row['step_nb_previous_proceeded'] = $flowRows[$index - 1][Metrics::NUM_STEP_PROCEEDS];
                if ($index === count($flowRows) - 1) {
                    $row['step_nb_previous_proceeded'] += $flowRows[$index - 1][Metrics::NUM_STEP_SKIPS];
                } else {
                    $row['step_nb_previous_proceeded'] -= $row[Metrics::NUM_STEP_SKIPS];
                }

                // If the previous step had some skipped, the previous proceeded might be missing some
                if ($row[Metrics::NUM_STEP_VISITS] > $row['step_nb_previous_proceeded'] + $row[Metrics::NUM_STEP_ENTRIES]) {
                    $row['step_nb_previous_proceeded'] += ($row[Metrics::NUM_STEP_VISITS] - ($row['step_nb_previous_proceeded'] + $row[Metrics::NUM_STEP_ENTRIES]));
                }

                $row['step_nb_previous_exits'] = $flowRows[$index - 1][Metrics::NUM_STEP_EXITS];
                $row['height'] = $row['step_nb_previous_exits'] + $row[Metrics::NUM_STEP_SKIPS] + $row[Metrics::NUM_STEP_ENTRIES] + $row['step_nb_previous_proceeded'];
            }
            $maxHeight = max($maxHeight, $row['height']);
        }
        return $maxHeight;
    }

    /**
     * Calculates and sets the bar heights for each row in the funnel flow.
     *
     * The bar heights represent the proportions of exits, skipped steps, entries, and proceeded steps
     * relative to the maximum height. The heights are calculated as percentages and then rounded down
     * to four decimal places.
     *
     * @param array &$flowRows The funnel flow rows to be processed.
     * @param int $maxHeight The maximum height among all the rows.
     */
    public function calculateAndSetBarHeights(array &$flowRows, int $maxHeight): void
    {
        if ($maxHeight <= 0) {
            return;
        }
        foreach ($flowRows as $index => &$row) {
            $heightExits = ($row['step_nb_previous_exits'] / $maxHeight) * 100;
            $heightSkipped = ($row[Metrics::NUM_STEP_SKIPS] / $maxHeight) * 100;
            $heightEntries = ($row[Metrics::NUM_STEP_ENTRIES] / $maxHeight) * 100;
            $heightProceeded = ($row['step_nb_previous_proceeded'] / $maxHeight) * 100;

            // Using floor() instead of round($var, 4) to prevent the total bar height from exceeding 100%,
            // which would cause the bar to overflow its container and create visual inconsistencies.
            $row['bar_height_exits'] = floor($heightExits * 10000) / 10000;
            $row['bar_height_skipped'] = floor($heightSkipped * 10000) / 10000;
            $row['bar_height_entries'] = floor($heightEntries * 10000) / 10000;
            $row['bar_height_proceeded'] = floor($heightProceeded * 10000) / 10000;
        }
    }
}
