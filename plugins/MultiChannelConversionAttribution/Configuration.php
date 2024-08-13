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

namespace Piwik\Plugins\MultiChannelConversionAttribution;

use Piwik\Config;

class Configuration
{
    const KEY_MAXIMUM_ROWS_IN_DATATABLE = 'datatable_archiving_maximum_rows';
    const KEY_MAXIMUM_ROWS_IN_SUBTABLE = 'datatable_archiving_maximum_rows_subtable';

    const DEFAULT_MAXIMUM_ROWS_IN_DATATABLE = 500;
    const DEFAULT_MAXIMUM_ROWS_IN_SUBTABLE = 500;

    const DEFAULT_AVAILABLE_DAYS_PRIOR_CONVERSION = '7,30,60,90';
    const DEFAULT_DAY_PRIOR_CONVERSION = 30;
    const KEY_AVAILABLE_DAYS_PRIOR_CONVERSION = 'available_days_prior_to_conversion';
    const KEY_DAY_PRIOR_CONVERSION = 'default_day_prior_to_conversion';

    const KEY_CAN_INVALIDATE_REPORTS_GENERAL = 'can_invalidate_reports';

    public function install()
    {
        $config = $this->getConfig();

        $conf = $config->MultiChannelConversionAttribution;
        if (empty($conf)) {
            $conf = array();
        }

        // we make sure to set a value only if none has been configured yet, eg in common config.
        if (empty($conf[self::KEY_DAY_PRIOR_CONVERSION])) {
            $conf[self::KEY_DAY_PRIOR_CONVERSION] = self::DEFAULT_DAY_PRIOR_CONVERSION;
        }
        if (empty($conf[self::KEY_AVAILABLE_DAYS_PRIOR_CONVERSION])) {
            $conf[self::KEY_AVAILABLE_DAYS_PRIOR_CONVERSION] = self::DEFAULT_AVAILABLE_DAYS_PRIOR_CONVERSION;
        }
        if (empty($conf[self::KEY_MAXIMUM_ROWS_IN_DATATABLE])) {
            $conf[self::KEY_MAXIMUM_ROWS_IN_DATATABLE] = self::DEFAULT_MAXIMUM_ROWS_IN_DATATABLE;
        }
        if (empty($conf[self::KEY_MAXIMUM_ROWS_IN_SUBTABLE])) {
            $conf[self::KEY_MAXIMUM_ROWS_IN_SUBTABLE] = self::DEFAULT_MAXIMUM_ROWS_IN_SUBTABLE;
        }

        $config->MultiChannelConversionAttribution = $conf;

        $config->forceSave();
    }

    public function uninstall()
    {
        $config = $this->getConfig();
        $config->MultiChannelConversionAttribution = array();
        $config->forceSave();
    }

    public function getDayPriorToConversion()
    {
        $value = $this->getConfigValue(self::KEY_DAY_PRIOR_CONVERSION, self::DEFAULT_DAY_PRIOR_CONVERSION);

        $available = $this->getDaysPriorToConversion();

        if (!in_array($value, $available)) {
            if (!empty($available)) {
                return (int) reset($available);
            }

            // in this case it would return empty result as this won't be archived. but when daysPriorToConversion
            // is empty it wouldn't archive anything anyway.
            return self::DEFAULT_DAY_PRIOR_CONVERSION;
        }

        return (int) $value;
    }

    /**
     * @return array
     */
    public function getDaysPriorToConversion()
    {
        $value = $this->getConfigValue(self::KEY_AVAILABLE_DAYS_PRIOR_CONVERSION, self::DEFAULT_AVAILABLE_DAYS_PRIOR_CONVERSION);

        if (!empty($value)) {
            $days = explode(',', $value);
            return array_map('intval', $days);
        }

        return array();
    }

    public function getMaximumRowsInDataTable()
    {
        $config = $this->getConfig();
        if (empty($config->MultiChannelConversionAttribution[self::KEY_MAXIMUM_ROWS_IN_DATATABLE])) {
            return self::DEFAULT_MAXIMUM_ROWS_IN_DATATABLE;
        }
        return (int) $config->MultiChannelConversionAttribution[self::KEY_MAXIMUM_ROWS_IN_DATATABLE];
    }

    public function getMaximumRowsInSubTable()
    {
        $config = $this->getConfig();
        if (empty($config->MultiChannelConversionAttribution[self::KEY_MAXIMUM_ROWS_IN_SUBTABLE])) {
            return self::DEFAULT_MAXIMUM_ROWS_IN_SUBTABLE;
        }
        return (int) $config->MultiChannelConversionAttribution[self::KEY_MAXIMUM_ROWS_IN_SUBTABLE];
    }

    public function shouldShowReArchiveFAQ()
    {
        $config = $this->getConfig();
        if (!isset($config->General[self::KEY_CAN_INVALIDATE_REPORTS_GENERAL])) {
            return true;
        }

        return (bool) $config->General[self::KEY_CAN_INVALIDATE_REPORTS_GENERAL];
    }

    private function getConfig()
    {
        return Config::getInstance();
    }

    private function getConfigValue($name, $default)
    {
        $config = $this->getConfig();
        $attribution = $config->MultiChannelConversionAttribution;
        if (isset($attribution[$name])) {
            return $attribution[$name];
        }
        return $default;
    }
}
