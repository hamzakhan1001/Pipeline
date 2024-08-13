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

use Piwik\Piwik;
use Piwik\Settings\Setting;
use Piwik\Settings\FieldConfig;

class SystemSettings extends \Piwik\Settings\Plugin\SystemSettings
{
    /** @var Setting */
    public $apiKey;

    protected function init()
    {
        $this->apiKey = $this->createApiKeySetting();
    }

    private function createApiKeySetting()
    {
        return $this->makeSetting('api_key', $default = '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = 'Page Speed API Token'; // we don't translate this one as Page Speed is kind of a product name
            $field->uiControl = FieldConfig::UI_CONTROL_PASSWORD;
            $field->description = Piwik::translate('SEOWebVitals_PageSpeedApiTokenDescription');
            // todo replace the link to google API by a link to an faq from us which we need to write and describe step by step how to get the api key
            $field->inlineHelp = '<a href="https://developers.google.com/speed/docs/insights/v5/get-started#APIKey">'.Piwik::translate('SEOWebVitals_ClickToConfigureApiKey').'</a>';
            $field->transform = function ($value) {
                return trim($value);
            };
        });
    }
}
