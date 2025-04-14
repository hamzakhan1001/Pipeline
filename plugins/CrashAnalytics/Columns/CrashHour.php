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

class CrashHour extends Dimension
{
    protected $nameSingular = 'CrashAnalytics_CrashHour';
    protected $namePlural = 'CrashAnalytics_CrashHours';
    protected $segmentName = 'crashHour';
    protected $category = 'CrashAnalytics_Crashes';
    protected $dbTableName = 'log_crash_event';
    protected $columnName = 'server_time';
    protected $sqlSegment = 'HOUR(log_crash_event.server_time)';
    protected $acceptValues = '0, 1, 2, 3, ..., 20, 21, 22, 23';

    public function __construct()
    {
        $this->suggestedValuesCallback = function ($idSite, $maxValuesToReturn) {
            $values = range(0, min(23, $maxValuesToReturn));
            $values = array_map('strval', $values);
            return $values;
        };
    }

    public function configureMetrics(MetricsList $metricsList, DimensionMetricFactory $dimensionMetricFactory)
    {
        // empty
    }
}
