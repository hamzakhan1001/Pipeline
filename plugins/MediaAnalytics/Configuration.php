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

namespace Piwik\Plugins\MediaAnalytics;

use Piwik\Config;

/**
 * Class Configuration
 * @package Piwik\Plugins\MediaAnalytics
 */
class Configuration
{
    const MAXIMUM_ROWS_IN_DATATABLE = 'datatable_archiving_maximum_rows_media';
    const MAXIMUM_ROWS_IN_SUBTABLE = 'datatable_archiving_maximum_rows_subtable_media';
    const ENABLE_EVENT_TRACKING = 'enable_event_tracking_by_default';

    const DEFAULT_MAXIMUM_ROWS_IN_DATATABLE = 1000;
    const DEFAULT_MAXIMUM_ROWS_IN_SUBTABLE = 1000;
    const DEFAULT_ENABLE_EVENT_TRACKING = 1;

    const ARCHIVING_RANKING_QUERY_ROW_LIMIT_PRIMARY = 'archiving_ranking_query_row_limit_primary';
    const ARCHIVING_RANKING_QUERY_ROW_LIMIT_SECONDARY = 'archiving_ranking_query_row_limit_secondary';

    const DEFAULT_RANKING_QUERY_LIMIT_PRIMARY = 10000;
    const DEFAULT_RANKING_QUERY_LIMIT_SECONDARY = 75000;

    const RANKING_QUERY_TYPE_PRIMARY = 'primary';
    const RANKING_QUERY_TYPE_SECONDARY = 'secondary';

    private $parametersExcludeDefault = array('enablejsapi', 'player_id');

    public function getDefaultMediaParametersToExclude()
    {
        return $this->parametersExcludeDefault;
    }

    public function getMaximumRowsInDataTable()
    {
        $config = $this->getConfig();
        if (empty($config->MediaAnalytics[self::MAXIMUM_ROWS_IN_DATATABLE])) {
            return null;
        }
        return (int) $config->MediaAnalytics[self::MAXIMUM_ROWS_IN_DATATABLE];
    }

    public function getMaximumRowsInSubTable()
    {
        $config = $this->getConfig();
        if (empty($config->MediaAnalytics[self::MAXIMUM_ROWS_IN_SUBTABLE])) {
            return null;
        }
        return (int) $config->MediaAnalytics[self::MAXIMUM_ROWS_IN_SUBTABLE];
    }

    public function getMediaParametersToExclude()
    {
        $config = $this->getConfig();
        $media = $config->MediaAnalytics;

        if (empty($media)) {
            return $this->parametersExcludeDefault;
        }

        if (empty($media['media_analytics_exclude_query_parameters'])) {
            return array();
        }

        $values = explode(',', $media['media_analytics_exclude_query_parameters']);
        $values = array_map('trim', $values);

        return array_unique($values);
    }

    public function install()
    {
        $config = $this->getConfig();

        if (empty($config->MediaAnalytics['media_analytics_exclude_query_parameters'])) {
            $config->MediaAnalytics['media_analytics_exclude_query_parameters'] = implode(',', $this->parametersExcludeDefault);
        }

        if (empty($config->MediaAnalytics[self::MAXIMUM_ROWS_IN_DATATABLE])) {
            $config->MediaAnalytics[self::MAXIMUM_ROWS_IN_DATATABLE] = self::DEFAULT_MAXIMUM_ROWS_IN_DATATABLE;
        }

        if (empty($config->MediaAnalytics[self::MAXIMUM_ROWS_IN_SUBTABLE])) {
            $config->MediaAnalytics[self::MAXIMUM_ROWS_IN_SUBTABLE] = self::DEFAULT_MAXIMUM_ROWS_IN_SUBTABLE;
        }

        if (!isset($config->MediaAnalytics[self::ENABLE_EVENT_TRACKING])) {
            $config->MediaAnalytics[self::ENABLE_EVENT_TRACKING] = self::DEFAULT_ENABLE_EVENT_TRACKING;
        }

        $config->forceSave();
    }

    public function uninstall()
    {
        $config = $this->getConfig();
        $config->MediaAnalytics = array();
        $config->forceSave();
    }

    private function getConfig()
    {
        return Config::getInstance();
    }

    public function shouldEnableEventTrackingByDefault()
    {
        return (bool) $this->getConfigValue(self::ENABLE_EVENT_TRACKING, self::DEFAULT_ENABLE_EVENT_TRACKING);
    }

    private function getConfigValue($name, $default)
    {
        $config = $this->getConfig();
        $values = $config->MediaAnalytics;
        if (isset($values[$name])) {
            return $values[$name];
        }
        return $default;
    }

    /**
     * Get the limit that should be used for the ranking query when archiving MediaAnalytics. There's a limit for the
     * primary queries and a limit for the secondary dimension queries. The type indicates which limit to return. If no
     * type is provided, the primary limit will be returned. The limit is pulled from the config file, but if no value
     * is returned, a default will be used.
     *
     * @param string $type Indicates the type of primary or secondary
     * @return int
     */
    public function getRankingQueryLimit($type = '')
    {
        $limit = $this->getConfigValue(self::ARCHIVING_RANKING_QUERY_ROW_LIMIT_PRIMARY, self::DEFAULT_RANKING_QUERY_LIMIT_PRIMARY);
        if ($type == self::RANKING_QUERY_TYPE_SECONDARY) {
            $limit = $this->getConfigValue(self::ARCHIVING_RANKING_QUERY_ROW_LIMIT_SECONDARY, self::DEFAULT_RANKING_QUERY_LIMIT_SECONDARY);
        }

        return $limit;
    }
}
