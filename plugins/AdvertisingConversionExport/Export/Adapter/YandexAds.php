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

use Piwik\Date;
use Piwik\Piwik;
use Piwik\Plugins\AdvertisingConversionExport\ClickIdProvider\Yandex;

/**
 * https://yandex.com/support/metrica/data/offline-conversion_data.html#offline-conversion__make-file
 */
class YandexAds extends AdapterAbstract
{
    public const ID = 'YandexAds';

    public static function getName(): string
    {
        return 'Yandex Ads';
    }

    public static function getDescription(): string
    {
        return Piwik::translate('AdvertisingConversionExport_YandexAdsExportDescription');
    }

    protected function getClickIdProvider()
    {
        return Yandex::getInstance();
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

    private function getFileHeader()
    {
        return <<<HEAD
yclid,Target,DateTime,Price,Currency

HEAD;
    }

    private function getConversionData($conversion)
    {
        $goal               = $this->configuration->getGoalConfig($conversion['idgoal']);
        $clickId            = $conversion['adclickid'];
        $conversionName     = $goal->alias;
        $conversionValue    = $goal->getConversionValue($conversion['revenue']);
        $conversionCurrency = $this->configuration->getSite()->getCurrency();
        // conversion time is expected as utc timestamp  (so we don't adjust the server_time to the sites timezone)
        $conversionTime = Date::factory($conversion['server_time'])->getTimestampUTC();

        return <<<CONVERSION
{$clickId},{$conversionName},{$conversionTime},{$conversionValue},{$conversionCurrency}

CONVERSION;
    }
}
