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

namespace Piwik\Plugins\SEOWebVitals\Dao;

use Piwik\Common;
use Piwik\Plugins\SEOWebVitals\MeasurableSettings;

class Pages
{
    public static function startsWithHttpProtocol($url)
    {
        if (empty($url)) {
            return false;
        }
        return stripos($url, 'http://') === 0 || stripos($url, 'https://') === 0;
    }

    public function getPageUrlsToMonitor($idSite)
    {
        if (empty($idSite)) {
            return [];
        }
        $measurable = new MeasurableSettings($idSite);
        $extraUrls = $measurable->checkUrls->getValue();
        $urlsToMonitor = [];
        if (!empty($extraUrls) && is_array($extraUrls)) {
            $urlsToMonitor = array_map(function ($url) {
                return Common::sanitizeNullBytes($url);
            }, $extraUrls);
            $urlsToMonitor = array_map('trim', $urlsToMonitor);
            $urlsToMonitor = array_unique($urlsToMonitor);
            $urlsToMonitor = array_values($urlsToMonitor);
        }

        return $urlsToMonitor;
    }
}
