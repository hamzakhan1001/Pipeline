<?php

/**
 * The Extra Api Information plugin for Matomo.
 *
 * Copyright (C) 2024 Digitalist Open Cloud <cloud@digitalist.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace Piwik\Plugins\ExtraApiInformation;

use Piwik\Piwik;
use Piwik\Option;
use Piwik\CronArchive;
use Piwik\Common;
use Piwik\Db;
use Piwik\Archive\ArchiveInvalidator;

/**
 * API for plugin ExtraApiInformation
 *
 * @method static \Piwik\Plugins\ExtraApiInformation\API getInstance()
 */
class API extends \Piwik\Plugin\API
{
    public function getArchivingStatus(bool $human = false)
    {
        Piwik::checkUserHasSuperUserAccess();
        $archiveStart = Option::get(CronArchive::OPTION_ARCHIVING_STARTED_TS);
        $archiveFinished = Option::get(CronArchive::OPTION_ARCHIVING_FINISHED_TS);
        if ($human) {
            $archiveStart = $archiveStart ? date("Y-m-d H:i:s", $archiveStart) : '-';
            $archiveFinished = $archiveFinished ? date("Y-m-d H:i:s", $archiveFinished) : '-';
        }
        return [
            'started' => $archiveStart,
            'finished' => $archiveFinished
        ];
    }

    public function getInvalidationsCount()
    {
        Piwik::checkUserHasSuperUserAccess();
        $invalidationCounts = $this->invalidationCounts();
        $total = $invalidationCounts['all'] ?? '0';
        $queued = $invalidationCounts[ArchiveInvalidator::INVALIDATION_STATUS_QUEUED] ?? '0';
        $inProgress = $invalidationCounts[ArchiveInvalidator::INVALIDATION_STATUS_IN_PROGRESS] ?? '0';
        return [
            'total' => $total,
            'queued' => $queued,
            'inprogress' => $inProgress
        ];
    }

    private function invalidationCounts()
    {
        $table = Common::prefixTable('archive_invalidations');
        $sql = "SELECT COUNT(*) as `count`, status FROM `$table` GROUP BY status";

        $rows = Db::fetchAll($sql);

        $result = array_combine(
            array_column($rows, 'status'),
            array_column($rows, 'count')
        );

        $result['all'] = array_sum($result);
        return $result;
    }
}
