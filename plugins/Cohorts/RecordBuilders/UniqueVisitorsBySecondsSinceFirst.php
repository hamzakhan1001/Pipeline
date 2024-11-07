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
use Piwik\ArchiveProcessor\Record;
use Piwik\DataTable;
use Piwik\Date;
use Piwik\Metrics;
use Piwik\Plugins\Cohorts\Archiver;
use Piwik\SettingsPiwik;

class UniqueVisitorsBySecondsSinceFirst extends SecondsSinceFirst
{
    public function getRecordMetadata(ArchiveProcessor $archiveProcessor): array
    {
        $periodLabel = $archiveProcessor->getParams()->getPeriod()->getLabel();
        if (
            SettingsPiwik::isUniqueVisitorsEnabled($periodLabel)
            && $periodLabel != 'range'
            && $periodLabel != 'day'
        ) {
            return [
                Record::make(Record::TYPE_BLOB, Archiver::COHORTS_UNIQUE_VISITORS_ARCHIVE_RECORD)
                    ->setColumnToSortByBeforeTruncation(Metrics::INDEX_NB_UNIQ_VISITORS),
            ];
        }

        return [];
    }

    protected function aggregate(ArchiveProcessor $archiveProcessor): array
    {
        return [];
    }

    public function buildForNonDayPeriod(ArchiveProcessor $archiveProcessor): void
    {
        parent::buildForNonDayPeriod($archiveProcessor);

        // NOTE: on cloud this is not a performance killer
        $periodLabel = $archiveProcessor->getParams()->getPeriod()->getLabel();
        if (
            SettingsPiwik::isUniqueVisitorsEnabled($periodLabel)
            // it doesn't make sense to aggregate this record for range periods, since ranges are arbitrary. so we can't know which arbitrary range a first visit is on.
            // we still trigger the above archiving, since it will pre-archive days if they have not been already.
            && $periodLabel != 'range'
        ) {
            $this->aggregateUniqueVisitorsForNonDay($archiveProcessor);
        }
    }

    private function aggregateUniqueVisitorsForNonDay(ArchiveProcessor $archiveProcessor): void
    {
        $timezone = $archiveProcessor->getParams()->getSite()->getTimezone();
        $siteTimezoneOffset = Date::getUtcOffset($timezone);

        $dimension = $this->getSelectDimension($archiveProcessor, $siteTimezoneOffset);
        if ($dimension === null) {
            return; // can't aggregate for period
        }

        $dimensions = [$dimension];

        $result = new DataTable();
        $this->aggregateVisitLogs($archiveProcessor->getLogAggregator(), $result, $dimensions, [Metrics::INDEX_NB_UNIQ_VISITORS, Metrics::INDEX_NB_USERS]);
        $this->insertBlobRecord(
            $archiveProcessor,
            Archiver::COHORTS_UNIQUE_VISITORS_ARCHIVE_RECORD,
            $result,
            $this->maxRowsInTable,
            $this->maxRowsInSubtable,
            Metrics::INDEX_NB_UNIQ_VISITORS
        );

        unset($result);
    }
}
