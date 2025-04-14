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
 * @link    https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */

namespace Piwik\Plugins\AdvertisingConversionExport\Export\Adapter;

use Piwik\Common;
use Piwik\Date;
use Piwik\Piwik;
use Piwik\Plugins\AdvertisingConversionExport\ClickIdProvider\Bing;
use Piwik\ProxyHttp;

/**
 * See https://help.ads.microsoft.com/#apex/ads/en/56852/2
 */
class MicrosoftAds extends AdapterAbstract
{
    public const ID = 'MicrosoftAds';

    public static function getName(): string
    {
        return 'Microsoft Advertising';
    }

    public static function getDescription(): string
    {
        return Piwik::translate('AdvertisingConversionExport_MicrosoftAdsExportDescription');
    }

    protected function getClickIdProvider()
    {
        return Bing::getInstance();
    }

    public function generate($isHTTPRequest = false): string
    {
        $content = $this->getFileHeader();

        if ($this->configuration->onlyDirectAttribution) {
            $cursor = $this->fetchDirectlyAttributedConversions();
        } else {
            $cursor = $this->fetchAllAttributedConversions();
        }

        while ($conversion = $cursor->fetch()) {
            $content .= $this->getConversionData($conversion);
        }

        $cursor->closeCursor();

        return $content;
    }

    public function sendHttpHeaders()
    {
        Common::sendHeader('Content-Type: text/csv', true);
        Common::sendHeader("Content-Disposition: attachment; filename=conversion-export.csv");
        ProxyHttp::overrideCacheControlHeaders('no-cache');
    }

    private function getFileHeader()
    {
        $diff = $this->getTimezoneOffsetFromUTC($this->configuration->getSite()->getTimezone());
        $hours = floor(abs($diff) / 3600);
        $minutes = abs($diff % 3600) / 60;
        $timezone = ($diff < 0 ? '-' : '+') . str_pad($hours, 2, '0', STR_PAD_LEFT) . str_pad($minutes, 2, '0', STR_PAD_LEFT);
        return <<<HEAD
### INSTRUCTIONS ###,,,,
"# Important: Remember to change the TimeZone value (GMT offset) in the ""parameters"" row",,,,
"# TimeZone values should be entered in HHMM format (e.g. New York is -0500 and Berlin is +0100. If you use Greenwich Mean Time, simply enter +0000).",,,,
"# Make sure you do not include additional columns. For more instructions on how to use this tempate, visit https://aka.ms/dk8o1y",,,,
,,,,
### TEMPLATE ###,,,,
Parameters:TimeZone={$timezone};,,,,
Microsoft Click ID,Conversion Name,Conversion Time,Conversion Value,Conversion Currency

HEAD;
    }

    private function getConversionData($conversion)
    {
        $goal               = $this->configuration->getGoalConfig($conversion['idgoal']);
        $clickId            = $conversion['adclickid'];
        $conversionName     = $goal->alias;
        $conversionValue    = $goal->getConversionValue($conversion['revenue']);
        $conversionCurrency = $this->configuration->getSite()->getCurrency();
        $conversionTime     = Date::factory($conversion['server_time'], $this->configuration->getSite()->getTimezone())->toString('Y-m-d H:i:s');

        return <<<CONVERSION
{$clickId},{$conversionName},{$conversionTime},{$conversionValue},{$conversionCurrency}

CONVERSION;
    }

    private function getTimezoneOffsetFromUTC($timezone)
    {
        if (stripos($timezone, 'utc-') !== false || stripos($timezone, 'utc+') !== false) {
            $websiteDatetTime = new \DateTime('now' . str_replace('utc', '', strtolower($timezone)), new \DateTimeZone('UTC'));
            $websiteTimezone = $websiteDatetTime->getTimezone();
        } else {
            $websiteTimezone = timezone_open($timezone);
        }
        $utcTimezone =  date_create("now", timezone_open('UTC'));

        return timezone_offset_get($websiteTimezone, $utcTimezone);
    }
}
