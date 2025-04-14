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

namespace Piwik\Plugins\Cohorts\RecordBuilders;

use Piwik\ArchiveProcessor;
use Piwik\ArchiveProcessor\RecordBuilder;
use Piwik\Config;
use Piwik\Plugins\Cohorts\Archiver;

abstract class Base extends RecordBuilder
{
    public function __construct()
    {
        parent::__construct();
        $this->maxRowsInTable = $this->getMaximumRowsInDataTable();
    }

    /**
     * @param int $siteTimezoneOffset timezone offset in hours
     */
    protected function getSelectDimension(ArchiveProcessor $archiveProcessor, $siteTimezoneOffset, $period = false)
    {
        $period = $period ?: $archiveProcessor->getParams()->getPeriod()->getLabel();

        // label is the number of days since the epoch that the first visit of this visitor was in in site's timezone,
        // rounded to start of period
        $secondsSinceFirstVisit = "log_visit.visitor_seconds_since_first";
        $firstActionTimeUtc = "UNIX_TIMESTAMP(log_visit.visit_first_action_time)";
        $firstVisitStartTime = "($firstActionTimeUtc - $secondsSinceFirstVisit)";
        $adjustedFirstVisitTime = "(UNIX_TIMESTAMP(CONVERT_TZ(FROM_UNIXTIME($firstVisitStartTime), @@session.time_zone, '+00:00')) + $siteTimezoneOffset)";

        $firstVisitTimeStartDay = "DATE_FORMAT(FROM_UNIXTIME($adjustedFirstVisitTime), '%Y-%m-%d')";
        if ($period == 'day') {
            $roundToPeriodStart = $firstVisitTimeStartDay;
        } elseif ($period == 'week') {
            $roundToPeriodStart = "DATE_ADD($firstVisitTimeStartDay, INTERVAL - WEEKDAY($firstVisitTimeStartDay) DAY)";
        } elseif ($period == 'month') {
            $roundToPeriodStart = "DATE_FORMAT(FROM_UNIXTIME($adjustedFirstVisitTime), '%Y-%m-01')";
        } elseif ($period == 'year') {
            $roundToPeriodStart = "DATE_FORMAT(FROM_UNIXTIME($adjustedFirstVisitTime), '%Y-01-01')";
        } else {
            return null;
        }

        return "$roundToPeriodStart AS label";
    }

    private function getMaximumRowsInDataTable()
    {
        $config = Config::getInstance()->Cohorts;
        if (empty($config['datatable_archiving_maximum_rows'])) {
            return Archiver::DEFAULT_ARCHIVING_MAX_ROWS;
        }

        $maxRows = $config['datatable_archiving_maximum_rows'];
        if ($maxRows <= 0) {
            return Archiver::DEFAULT_ARCHIVING_MAX_ROWS;
        }

        return $maxRows;
    }
}
