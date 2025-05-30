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

namespace Piwik\Plugins\AdvertisingConversionExport;

use Piwik\Piwik;
use Piwik\Settings\Setting;
use Piwik\Settings\FieldConfig;
use Piwik\Plugins\AdvertisingConversionExport\Validators\ConsentStatus;
use Piwik\Url;

/**
 * Defines Settings for AdvertisingConversionExport.
 *
 * Usage like this:
 * $settings = new SystemSettings();
 * $settings->metric->getValue();
 * $settings->description->getValue();
 */
class SystemSettings extends \Piwik\Settings\Plugin\SystemSettings
{
    /** @var Setting */
    public $ad_user_data_consent_status;

    /** @var Setting */
    public $ad_personalization_consent_status;

    /** @var Setting */
    public $anonymize_click_ids;

    private $availableStatuses = array('UNKNOWN' => 'Unknown', 'UNSPECIFIED' => 'Unspecified', 'GRANTED' => 'Granted', 'DENIED' => 'Denied');

    private const DEFAULT_STATUS = 'UNSPECIFIED';

    protected function init()
    {
        $this->ad_user_data_consent_status = $this->createConsentStatus('AdUserData', true);
        $this->ad_personalization_consent_status = $this->createConsentStatus('AdPersonalization');
        $this->anonymize_click_ids = $this->createAnonymizeClickIds();
    }

    private function createConsentStatus($type, $showInlineHelp = false)
    {
        $availableStatuses = $this->availableStatuses;
        $defaultStatus = self::DEFAULT_STATUS;
        return $this->makeSetting($type . 'ConsentStatus', $default = '', FieldConfig::TYPE_STRING, function (FieldConfig $field) use ($availableStatuses, $type, $showInlineHelp, $defaultStatus) {
            $field->title = Piwik::translate('AdvertisingConversionExport_' . $type . 'Title');
            $field->uiControl = FieldConfig::UI_CONTROL_SINGLE_SELECT;
            $field->availableValues = $availableStatuses;
            if ($showInlineHelp) {
                $field->inlineHelp = Piwik::translate(
                    'AdvertisingConversionExport_' . $type . 'Description',
                    array('<a href="https://support.google.com/google-ads/answer/14310715" target="_blank" rel="noreferrer noopener">', '</a>', '<br><br>', $availableStatuses[$defaultStatus])
                );
            }

            $field->transform = function ($value) use ($defaultStatus) {
                if (empty($value)) {
                    // Reason for doing it here and not setting the default when making the setting is due to UI restrictions,
                    // if we set the setting default other than empty the inlineBox shows up for both the settings, and we want to have a common box for both the settings
                    return  $defaultStatus;
                }

                return $value;
            };

            $field->validators[] = new ConsentStatus($availableStatuses);
        });
    }

    private function createAnonymizeClickIds()
    {
        $providers = AdvertisingConversionExport::getAvailableClickIdProviders();
        $defaultValues = [];
        $availableValues = [];
        foreach ($providers as $provider) {
            $defaultValues[] = $provider::ID;
            $availableValues[] = ['name' => 'anonymizeClickIds[]', 'value' => $provider->getName(), 'key' => $provider::ID];
        }
        return $this->makeSetting('anonymizeClickIds', $defaultValues, FieldConfig::TYPE_ARRAY, function (FieldConfig $field) use ($defaultValues, $availableValues) {
            $faqURL = Url::addCampaignParametersToMatomoLink(
                'https://matomo.org/faq/advertising-conversion-export/exported-clickids-have-value-as-anonymized/',
                null,
                null,
                'App.CoreAdminHome.generalSettings'
            );
            $field->introduction = Piwik::translate('AdvertisingConversionExport_AnonymiseClickIDSettingTitle');
            $field->inlineHelp = Piwik::translate(
                'AdvertisingConversionExport_AnonymiseClickIDSettingDescription',
                [
                    '<a target="_blank" rel="noreferrer noopener" href="' . $faqURL . '">',
                    '</a>',
                    '<br><br><strong>',
                    '</strong>',
                ]
            );
            $field->uiControl = FieldConfig::UI_CONTROL_CHECKBOX;
            $field->availableValues = $availableValues;
            $field->validate = function ($values) use ($defaultValues) {
                foreach ($values as $value) {
                    if (!in_array($value, $defaultValues)) {
                        throw new \Exception('Invalid value "' . $value . '"');
                    }
                }
            };
        });
    }
}
