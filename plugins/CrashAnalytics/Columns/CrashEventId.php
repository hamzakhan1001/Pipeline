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
use Piwik\Columns\MetricsList;
use Piwik\Plugins\CrashAnalytics\Metrics;

class CrashEventId extends Dimension
{
    protected $category = 'CrashAnalytics_Crashes';
    protected $dbTableName = 'log_crash_event';
    protected $columnName = 'idlogcrashevent';

    public function configureMetrics(MetricsList $metricsList, DimensionMetricFactory $dimensionMetricFactory)
    {
        $crashOccurrences = Metrics::createCustomMetric($dimensionMetricFactory, Metrics::CRASH_OCCURRENCES);
        $metricsList->addMetric($crashOccurrences);
    }
}