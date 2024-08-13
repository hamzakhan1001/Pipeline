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

namespace Piwik\Plugins\CrashAnalytics\Columns;

use Piwik\Columns\Dimension;
use Piwik\Columns\DimensionMetricFactory;
use Piwik\Columns\DimensionSegmentFactory;
use Piwik\Columns\MetricsList;
use Piwik\Plugins\CrashAnalytics\Metrics;
use Piwik\Segment\SegmentsList;

// note: crashId segment is required in order to be able to select specific crashes from specific sources,
// which crashMessage alone can't do.
class Crash extends Dimension
{
    protected $nameSingular = 'CrashAnalytics_Crash';
    protected $namePlural = 'CrashAnalytics_Crashes';
    protected $segmentName = 'crashId';
    protected $category = 'CrashAnalytics_Crashes';
    protected $dbTableName = 'log_crash_event';
    protected $columnName = 'idlogcrash';
    protected $sqlSegment = 'log_crash_event.idlogcrash';

    public function configureMetrics(MetricsList $metricsList, DimensionMetricFactory $dimensionMetricFactory)
    {
        $uniqueCrashes = Metrics::createCustomMetric($dimensionMetricFactory, Metrics::UNIQUE_CRASHES);
        $metricsList->addMetric($uniqueCrashes);
    }

    public function configureSegments(SegmentsList $segmentsList, DimensionSegmentFactory $dimensionSegmentFactory)
    {
        $segment = $dimensionSegmentFactory->createSegment();
        $segment->setIsInternal(true);
        $segmentsList->addSegment($segment);
    }
}