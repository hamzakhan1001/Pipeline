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

namespace Piwik\Plugins\CrashAnalytics;

use Piwik\Config;

class Configuration
{
    const KEY_DELETE_CRASH_DATA_OLDER_THAN = 'delete_crash_data_older_than';
    const KEY_DATATABLE_ARCHIVING_MAXIMUM_ROWS_CRASHES = 'datatable_archiving_maximum_rows_crashes';
    const KEY_DATATABLE_ARCHIVING_MAXIMUM_ROWS_CRASH_TOPTABLE = 'datatable_archiving_maximum_rows_crash_toptable';
    const KEY_DATATABLE_ARCHIVING_MAXIMUM_ROWS_CRASH_SUBTABLE = 'datatable_archiving_maximum_rows_crash_subtable';
    const KEY_CONSIDER_CRASH_NEW_AFTER_N_DAYS = 'consider_crash_new_after_n_days';
    const KEY_CRASH_RANKING_QUERY_LIMIT = 'crash_archiving_ranking_query_row_limit';

    const DEFAULT_DELETE_CRASH_DATA_OLDER_THAN = 90;
    const DEFAULT_DATATABLE_ARCHIVING_MAXIMUM_ROWS_CRASHES = 500;
    const DEFAULT_DATATABLE_ARCHIVING_MAXIMUM_ROWS_CRASH_TOPTABLE = 500;
    const DEFAULT_DATATABLE_ARCHIVING_MAXIMUM_ROWS_CRASH_SUBTABLE = 100;
    const DEFAULT_CONSIDER_CRASH_NEW_AFTER_N_DAYS = 365 * 2;
    const DEFAULT_CRASH_RANKING_QUERY_LIMIT = 50000;

    /**
     * @var Config
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function install()
    {
        $initialConfig = [
            self::KEY_DELETE_CRASH_DATA_OLDER_THAN => self::DEFAULT_DELETE_CRASH_DATA_OLDER_THAN,
            self::KEY_DATATABLE_ARCHIVING_MAXIMUM_ROWS_CRASHES => self::DEFAULT_DATATABLE_ARCHIVING_MAXIMUM_ROWS_CRASHES,
            self::KEY_DATATABLE_ARCHIVING_MAXIMUM_ROWS_CRASH_TOPTABLE => self::DEFAULT_DATATABLE_ARCHIVING_MAXIMUM_ROWS_CRASH_TOPTABLE,
            self::KEY_DATATABLE_ARCHIVING_MAXIMUM_ROWS_CRASH_SUBTABLE => self::DEFAULT_DATATABLE_ARCHIVING_MAXIMUM_ROWS_CRASH_SUBTABLE,
            self::KEY_CONSIDER_CRASH_NEW_AFTER_N_DAYS => self::DEFAULT_CONSIDER_CRASH_NEW_AFTER_N_DAYS,
            self::KEY_CRASH_RANKING_QUERY_LIMIT => self::DEFAULT_CRASH_RANKING_QUERY_LIMIT,
        ];

        $config = $this->config;
        foreach ($initialConfig as $key => $value) {
            if (empty($config->CrashAnalytics[$key])) {
                $config->CrashAnalytics[$key] = $value;
            }
        }
        $config->forceSave();
    }

    public function uninstall()
    {
        $config = $this->config;
        $config->CrashAnalytics = [];
        $config->forceSave();
    }

    public function getDeleteCrashDataOlderThan()
    {
        $config = $this->config;
        $value = (int)($config->CrashAnalytics[self::KEY_DELETE_CRASH_DATA_OLDER_THAN] ?? self::DEFAULT_DELETE_CRASH_DATA_OLDER_THAN);
        return $value;
    }

    public function getDataTableArchivingMaximumRows()
    {
        $config = $this->config;
        $value = (int)($config->CrashAnalytics[self::KEY_DATATABLE_ARCHIVING_MAXIMUM_ROWS_CRASHES] ?? self::DEFAULT_DATATABLE_ARCHIVING_MAXIMUM_ROWS_CRASHES);
        if ($value <= 0) {
            return self::DEFAULT_DATATABLE_ARCHIVING_MAXIMUM_ROWS_CRASHES;
        }
        return $value;
    }

    public function getDataTableArchivingMaximumTopTableRowsForNonCrashDimension()
    {
        $config = $this->config;
        $value = (int)($config->CrashAnalytics[self::KEY_DATATABLE_ARCHIVING_MAXIMUM_ROWS_CRASH_TOPTABLE] ?? self::DEFAULT_DATATABLE_ARCHIVING_MAXIMUM_ROWS_CRASH_TOPTABLE);
        if ($value <= 0) {
            return self::DEFAULT_DATATABLE_ARCHIVING_MAXIMUM_ROWS_CRASH_TOPTABLE;
        }
        return $value;
    }

    public function getDataTableArchivingMaximumSubtableRowsForNonCrashDimension()
    {
        $config = $this->config;
        $value = (int)($config->CrashAnalytics[self::KEY_DATATABLE_ARCHIVING_MAXIMUM_ROWS_CRASH_SUBTABLE] ?? self::DEFAULT_DATATABLE_ARCHIVING_MAXIMUM_ROWS_CRASH_SUBTABLE);
        if ($value <= 0) {
            return self::DEFAULT_DATATABLE_ARCHIVING_MAXIMUM_ROWS_CRASH_SUBTABLE;
        }
        return $value;
    }

    public function getConsiderCrashNewAfterNDays()
    {
        $config = $this->config;
        $value = (int)($config->CrashAnalytics[self::KEY_CONSIDER_CRASH_NEW_AFTER_N_DAYS] ?? self::DEFAULT_CONSIDER_CRASH_NEW_AFTER_N_DAYS);
        if ($value <= 0) {
            return 0;
        }
        return $value;
    }

    public function getRankingQueryLimit()
    {
        $config = $this->config;
        $value = (int)($config->CrashAnalytics[self::KEY_CRASH_RANKING_QUERY_LIMIT] ?? self::DEFAULT_CRASH_RANKING_QUERY_LIMIT);
        if ($value <= 0) {
            return 0;
        }
        return $value;
    }
}