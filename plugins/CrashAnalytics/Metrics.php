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

namespace Piwik\Plugins\CrashAnalytics;

use Piwik\Columns\Dimension;
use Piwik\Piwik;
use Piwik\Plugin\ArchivedMetric;
use Piwik\Plugin\Metric;
use Piwik\Plugins\CrashAnalytics\Columns\Metrics\PageviewCrashRate;
use Piwik\Plugins\CrashAnalytics\Columns\Metrics\VisitsCrashRate;

class Metrics
{
    const CRASH_OCCURRENCES = 'nb_crash_occurrences';
    const VISITS_WITH_CRASH = 'nb_visits_with_crash';
    const UNIQUE_CRASHES = 'nb_uniq_crashes';
    const NEW_CRASHES = 'nb_new_crashes';
    const DISAPPEARED_CRASHES = 'nb_disappeared_crashes';
    const REAPPEARED_CRASHES = 'nb_reappeared_crashes';
    const PAGEVIEWS_WITH_CRASH = 'nb_pageview_with_crash';
    const IGNORED_CRASHES = 'nb_ignored_crashes';

    public static function getMetricSemanticTypes()
    {
        return [
            self::CRASH_OCCURRENCES => Dimension::TYPE_NUMBER,
            self::VISITS_WITH_CRASH => Dimension::TYPE_NUMBER,
            self::UNIQUE_CRASHES => Dimension::TYPE_NUMBER,
            self::NEW_CRASHES => Dimension::TYPE_NUMBER,
            self::DISAPPEARED_CRASHES => Dimension::TYPE_NUMBER,
            self::REAPPEARED_CRASHES => Dimension::TYPE_NUMBER,
            self::PAGEVIEWS_WITH_CRASH => Dimension::TYPE_NUMBER,
            self::IGNORED_CRASHES => Dimension::TYPE_NUMBER,

            'idlogcrash' => null,
            'crash_source' => Dimension::TYPE_TEXT,
            'crash_type' => Dimension::TYPE_TEXT,
            'crash_first_seen' => Dimension::TYPE_DATETIME,
            'crash_last_seen' => Dimension::TYPE_DATETIME,
            'crash_last_reappeared' => Dimension::TYPE_DATETIME,
        ];
    }

    // aggregation operations when aggregating days and other periods together, rather than aggregating
    // log table rows
    public static function getMetricAggregationOps()
    {
        // for columns referring to crash metadata, when adding rows w/ the same label, we can assume the
        // metadata is always the same. this allows us to keep the metadata when archiving periods larger
        // than a day.
        $useThisMetricAggregationOp = function ($op, $thisValue) { return $thisValue; };

        return [
            self::CRASH_OCCURRENCES => 'sum',
            self::VISITS_WITH_CRASH => 'sum',
            self::UNIQUE_CRASHES => 'skip',
            self::NEW_CRASHES => 'sum',
            self::DISAPPEARED_CRASHES => 'sum',
            self::REAPPEARED_CRASHES => 'sum',
            self::PAGEVIEWS_WITH_CRASH => 'sum',
            self::IGNORED_CRASHES => 'max',

            'idlogcrash' => $useThisMetricAggregationOp,
            'crash_source' => $useThisMetricAggregationOp,
            'crash_type' => $useThisMetricAggregationOp,
            'crash_first_seen' => $useThisMetricAggregationOp,
            'crash_last_seen' => $useThisMetricAggregationOp,
            'crash_last_reappeared' => $useThisMetricAggregationOp,
        ];
    }

    // aggregation operations when aggregating within a single day
    public static $dbMetricAggregationOps = [
        self::CRASH_OCCURRENCES => ArchivedMetric::AGGREGATION_COUNT,
        self::VISITS_WITH_CRASH => ArchivedMetric::AGGREGATION_UNIQUE,
        self::UNIQUE_CRASHES => ArchivedMetric::AGGREGATION_UNIQUE,
        self::PAGEVIEWS_WITH_CRASH => ArchivedMetric::AGGREGATION_UNIQUE,
    ];

    public static function getMetricTranslations()
    {
        return [
            self::CRASH_OCCURRENCES => 'CrashAnalytics_CrashOccurrences',
            self::VISITS_WITH_CRASH => 'CrashAnalytics_VisitsWithCrash',
            self::UNIQUE_CRASHES => 'CrashAnalytics_UniqueCrashes',
            self::NEW_CRASHES => 'CrashAnalytics_NewCrashes',
            self::DISAPPEARED_CRASHES => 'CrashAnalytics_DisappearedCrashes',
            self::REAPPEARED_CRASHES => 'CrashAnalytics_ReappearedCrashes',
            self::PAGEVIEWS_WITH_CRASH => 'CrashAnalytics_PageviewsWithCrash',
            self::IGNORED_CRASHES => 'CrashAnalytics_IgnoredCrashes',
            VisitsCrashRate::METRIC_NAME => VisitsCrashRate::TRANSLATION_ID,
            PageviewCrashRate::METRIC_NAME => PageviewCrashRate::TRANSLATION_ID,
        ];
    }

    public static function getMetricsDocumentationTranslations()
    {
        return [
            self::CRASH_OCCURRENCES => 'CrashAnalytics_CrashOccurrencesDocumentation',
            self::VISITS_WITH_CRASH => 'CrashAnalytics_VisitsWithCrashDocumentation',
            self::UNIQUE_CRASHES => 'CrashAnalytics_UniqueCrashesDocumentation',
            self::NEW_CRASHES => 'CrashAnalytics_NewCrashesDocumentation',
            self::DISAPPEARED_CRASHES => 'CrashAnalytics_DisappearedCrashesMetricDocumentation',
            self::REAPPEARED_CRASHES => 'CrashAnalytics_ReappearedCrashesMetricDocumentation',
            self::PAGEVIEWS_WITH_CRASH => 'CrashAnalytics_PageviewsWithCrashDocumentation',
            self::IGNORED_CRASHES => 'CrashAnalytics_IgnoredCrashDocumentation',
            VisitsCrashRate::METRIC_NAME => VisitsCrashRate::DOCUMENTATION_TRANSLATION_ID,
            PageviewCrashRate::METRIC_NAME => PageviewCrashRate::DOCUMENTATION_TRANSLATION_ID,
        ];
    }

    public static function createCustomMetric(\Piwik\Columns\DimensionMetricFactory $dimensionMetricFactory, string $metric)
    {
        $translations = self::getMetricTranslations();
        $documentation = self::getMetricsDocumentationTranslations();

        return $dimensionMetricFactory->createCustomMetric($metric, $translations[$metric], self::$dbMetricAggregationOps[$metric], Piwik::translate($documentation[$metric]));
    }
}