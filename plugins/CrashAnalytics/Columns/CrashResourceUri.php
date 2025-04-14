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
use Piwik\Columns\DimensionSegmentFactory;
use Piwik\Piwik;
use Piwik\Segment\SegmentsList;

class CrashResourceUri extends Dimension
{
    protected $nameSingular = 'CrashAnalytics_CrashSourceUrl';
    protected $namePlural = 'CrashAnalytics_CrashSourceUrls';
    protected $segmentName = 'crashSource';
    protected $category = 'CrashAnalytics_Crashes';
    protected $dbTableName = 'log_crash';
    protected $columnName = 'resource_uri';
    protected $sqlSegment = 'log_crash.resource_uri';
    protected $suggestedValuesApi = 'CrashAnalytics.getCrashesBySource';
}