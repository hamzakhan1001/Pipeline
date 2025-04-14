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
use Piwik\Piwik;

class CrashCategory extends Dimension
{
    protected $nameSingular = 'CrashAnalytics_CrashCategory';
    protected $namePlural = 'CrashAnalytics_CrashCategories';
    protected $segmentName = 'crashCategory';
    protected $category = 'CrashAnalytics_Crashes';
    protected $dbTableName = 'log_crash_event';
    protected $columnName = 'category';
    protected $sqlSegment = 'log_crash_event.category';
    protected $suggestedValuesApi = 'CrashAnalytics.getCrashesByCategory';
}