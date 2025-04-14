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

use Piwik\API\Request;
use Piwik\ArchiveProcessor\Rules;
use Piwik\Columns\Dimension;
use Piwik\Date;
use Piwik\Segment;

class CrashMessage extends Dimension
{
    protected $nameSingular = 'CrashAnalytics_CrashMessage';
    protected $namePlural = 'CrashAnalytics_CrashMessages';
    protected $segmentName = 'crashMessage';
    protected $category = 'CrashAnalytics_Crashes';
    protected $dbTableName = 'log_crash';
    protected $columnName = 'message';
    protected $sqlSegment = 'log_crash.message';
    protected $suggestedValuesCallback = [self::class, 'getSuggestedSegmentValues'];

    // Note: we can't use $suggestedValuesApi since it uses the `segment` row metadata looking for crashMessage==,
    // but for that report since there can be duplicate labels w/ different sources, we use crashId.
    public static function getSuggestedSegmentValues($idSite, $maxSuggestionsToReturn)
    {
        if (Rules::isBrowserTriggerEnabled()) { // same requirement as in plugins/API/API.php getSuggestedValuesForSegment()
            return [];
        }

        $now = Date::now();

        // code copied from plugins/API/API.php getSuggestedValuesForSegment()
        $period = 'year';
        $date = $now->toString();
        if ($now->toString('m') == '01') {
            if (Rules::isArchivingDisabledFor(array($idSite), new Segment('', array($idSite)), 'range')) {
                $date = $now->subYear(1)->toString(); // use previous year data to avoid using range
            } else {
                $period = 'range';
                $date = $now->subMonth(1)->toString() . ',' . $now->addDay(1)->toString();
            }
        }

        $table = Request::processRequest('CrashAnalytics.getAllCrashMessages', array(
            'idSite' => $idSite,
            'period' => $period,
            'date' => $date,
            'segment' => '',
            'filter_offset' => 0,
            'filter_limit' => $maxSuggestionsToReturn
        ));

        return array_unique($table->getColumn('label'));
    }
}