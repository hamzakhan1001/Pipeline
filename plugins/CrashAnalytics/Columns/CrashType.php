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
use Piwik\Plugins\CrashAnalytics\API;

class CrashType extends Dimension
{
    protected $nameSingular = 'CrashAnalytics_CrashType';
    protected $namePlural = 'CrashAnalytics_CrashTypes';
    protected $segmentName = 'crashType';
    protected $category = 'CrashAnalytics_Crashes';
    protected $dbTableName = 'log_crash';
    protected $columnName = 'crash_type';
    protected $sqlSegment = 'log_crash.crash_type';
    protected $acceptValues = 'A crash type such as "TypeError" or "SyntaxError".';
    protected $suggestedValuesCallback = [self::class, 'getCrashTypesSuggestion'];

    public static function getCrashTypesSuggestion($idSite, $maxSuggestionsToReturn)
    {
        return API::getInstance()->getCrashTypes($idSite, $maxSuggestionsToReturn);
    }
}