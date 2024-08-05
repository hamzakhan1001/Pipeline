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
use Piwik\Url;
use Piwik\Plugins\AdvertisingConversionExport\ClickIdProvider\Google;

class GoogleAds extends AdapterAbstract
{
    const ID = 'GoogleAds';

    public static function getName(): string
    {
        return 'Google Ads';
    }

    public static function getDescription(): string
    {
        $faqURL = Url::addCampaignParametersToMatomoLink('https://matomo.org/faq/reports/how-to-set-up-conversion-import-in-google-ads/');

        return Piwik::translate('AdvertisingConversionExport_GoogleAdsExportDescription') . '. ' . Piwik::translate('AdvertisingConversionExport_GoogleAdsExportFAQText', array('<a href="' . $faqURL . '" target="_blank" rel="noreferrer noopener">', '</a>'));
    }

    protected function getClickIdProvider()
    {
        return Google::getInstance();
    }

    public function generate(): string
    {
        if ($this->configuration->externalAttributedConversion) {
            $content = $this->getFileHeaderWithExternalAttributedConversion();
        } else {
            $content = $this->getFileHeaderWithoutExternalAttributedConversion();
        }

        if ($this->configuration->onlyDirectAttribution) {
            $cursor = $this->fetchDirectlyAttributedConversions();
        } else {
            $cursor = $this->fetchAllAttributedConversions();
        }

        while ($conversion = $cursor->fetch()) {
            if ($this->configuration->externalAttributedConversion) {
                $content .= $this->getConversionDataWithExternalAttributedConversion($conversion);
            } else {
                $content .= $this->getConversionDataWithoutExternalAttributedConversion($conversion);
            }
        }

        $cursor->closeCursor();

        return $content;
    }

    private function getFileHeaderWithExternalAttributedConversion()
    {
        $attributionModel = $this->configuration->getAttributionModelExportName();
        $timezone = $this->configuration->getSite()->getTimezone();
        $timezone = $this->convertTimezone($timezone);
        return <<<HEAD
### INSTRUCTIONS ###,,,,,
"# IMPORTANT: Remember to set the TimeZone value in the ""parameters"" row and/or in your Conversion Time column",,,,,
# For instructions on how to set your timezones visit http://goo.gl/T1C5Ov,,,,,
"# If you include conversion value, it should be the value corresponding to the attributed conversion credit.",,,,,
,,,,,
### TEMPLATE ###,,,,,
Parameters:Attribution Model = {$attributionModel},,,,,
Parameters:TimeZone={$timezone},,,# Attributed credit should be between 0 and 1 #,# Optional #,# Optional #
Google Click ID,Conversion Name,Conversion Time,Attributed Credit,Conversion Value,Conversion Currency,Ad User Data,Ad Personalization

HEAD;
    }

    private function getFileHeaderWithoutExternalAttributedConversion()
    {
        $timezone = $this->configuration->getSite()->getTimezone();
        $timezone = $this->convertTimezone($timezone);
        return <<<HEAD
### INSTRUCTIONS ###,,,,
"# IMPORTANT: Remember to set the TimeZone value in the ""parameters"" row and/or in your Conversion Time column",,,,
# For instructions on how to set your timezones visit http://goo.gl/T1C5Ov,,,,
,,,,
### TEMPLATE ###,,,,
Parameters:TimeZone={$timezone},,,,
Google Click ID,Conversion Name,Conversion Time,Conversion Value,Conversion Currency,Ad User Data,Ad Personalization

HEAD;
    }

    private function getConversionDataWithExternalAttributedConversion($conversion)
    {
        $goal               = $this->configuration->getGoalConfig($conversion['idgoal']);
        $clickId            = $conversion['adclickid'];
        $conversionName     = $goal->alias;
        $conversionValue    = $goal->getConversionValue($conversion['revenue']);
        $conversionCurrency = $this->configuration->getSite()->getCurrency();
        $conversionTime     = Date::factory($conversion['server_time'], $this->configuration->getSite()->getTimezone())->toString('Y-m-d H:i:s');
        $attributedCredit   = $this->configuration->attributedCredit;
        $adUserData         = $this->systemSetting->ad_user_data_consent_status->getValue();
        $adPersonalization  = $this->systemSetting->ad_personalization_consent_status->getValue();

        return <<<CONVERSION
{$clickId},{$conversionName},{$conversionTime},{$attributedCredit},{$conversionValue},{$conversionCurrency},{$adUserData},{$adPersonalization}

CONVERSION;

    }

    private function getConversionDataWithoutExternalAttributedConversion($conversion)
    {
        $goal               = $this->configuration->getGoalConfig($conversion['idgoal']);
        $clickId            = $conversion['adclickid'];
        $conversionName     = $goal->alias;
        $conversionValue    = $goal->getConversionValue($conversion['revenue']);
        $conversionCurrency = $this->configuration->getSite()->getCurrency();
        $conversionTime     = Date::factory($conversion['server_time'], $this->configuration->getSite()->getTimezone())->toString('Y-m-d H:i:s');
        $adUserData         = $this->systemSetting->ad_user_data_consent_status->getValue();
        $adPersonalization  = $this->systemSetting->ad_personalization_consent_status->getValue();

        return <<<CONVERSION
{$clickId},{$conversionName},{$conversionTime},{$conversionValue},{$conversionCurrency},{$adUserData},{$adPersonalization}

CONVERSION;

    }
}
