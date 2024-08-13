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

namespace Piwik\Plugins\SEOWebVitals;

use Piwik\Config;

class Configuration
{
    const DEFAULT_MAX_URLS_PER_SITE = -1;

    const KEY_MAX_URLS_PER_SITE = 'max_urls_monitor_per_site';

    public function install()
    {
        $config = $this->getConfig();

        $webVitals = $config->SEOWebVitals;
        if (empty($webVitals)) {
            $webVitals = array();
        }

        // we make sure to set a value only if none has been configured yet, eg in common config.
        if (empty($webVitals[self::KEY_MAX_URLS_PER_SITE])) {
            $webVitals[self::KEY_MAX_URLS_PER_SITE] = self::DEFAULT_MAX_URLS_PER_SITE;
        }

        $config->SEOWebVitals = $webVitals;

        $config->forceSave();
    }

    public function uninstall()
    {
        $config = $this->getConfig();
        $config->SEOWebVitals = array();
        $config->forceSave();
    }

    /**
     * @return int
     */
    public function getMaxUrlsPerSite()
    {
        $value = $this->getConfigValue(self::KEY_MAX_URLS_PER_SITE, self::DEFAULT_MAX_URLS_PER_SITE);

        if ($value === false || $value === '' || $value === null || !is_numeric($value)) {
            $value = self::DEFAULT_MAX_URLS_PER_SITE;
        }

        return (int) $value;
    }

    private function getConfig()
    {
        return Config::getInstance();
    }

    private function getConfigValue($name, $default)
    {
        $config = $this->getConfig();
        $attribution = $config->SEOWebVitals;
        if (isset($attribution[$name])) {
            return $attribution[$name];
        }
        return $default;
    }
}
