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

use Piwik\Container\StaticContainer;
use Piwik\Piwik;
use Piwik\Plugins\SEOWebVitals\Dao\Pages;
use Piwik\Settings\Setting;
use Piwik\Settings\FieldConfig;

class MeasurableSettings extends \Piwik\Settings\Measurable\MeasurableSettings
{
    /** @var Setting|null */
    public $checkUrls;

    protected function init()
    {
        $this->checkUrls = $this->makeUrlsSetting();
    }

    private function makeUrlsSetting()
    {
        $type = FieldConfig::TYPE_ARRAY;

        return $this->makeSetting('check_urls', [], $type, function (FieldConfig $field) {
            $field->title = Piwik::translate('SEOWebVitals_UrlsMonitorFieldTitle');
            $field->inlineHelp = Piwik::translate('SEOWebVitals_UrlsMonitorFieldDescription');

            $configuration = StaticContainer::get(Configuration::class);
            $maxUrlsPerSite = $configuration->getMaxUrlsPerSite();
            if ($maxUrlsPerSite > -1) {
                $field->inlineHelp .= '<br><br>';
                $field->inlineHelp .= Piwik::translate('SEOWebVitals_MaxPageUrlsCanBeConfigured');
            }

            $field->uiControl = FieldConfig::UI_CONTROL_TEXTAREA;
            $field->validate = function ($value) {
                foreach ($value as $url) {
                    $url = trim($url);
                    if (!Pages::startsWithHttpProtocol($url)) {
                        throw new \Exception(Piwik::translate('SEOWebVitals_ErrorNotCorrectUrlProtocol', $url));
                    }
                }

                $maxUrlsPerSite = StaticContainer::get(Configuration::class)->getMaxUrlsPerSite();

                $numUrls = count($value);
                if ($maxUrlsPerSite > -1 && $numUrls > $maxUrlsPerSite) {
                    throw new \Exception(Piwik::translate('SEOWebVitals_ErrorMaxUrlsPerSite', [$numUrls, $maxUrlsPerSite]));
                }
            };
            $field->transform = function ($value) {
                return array_values(array_unique(array_map('trim', $value)));
            };
        });
    }

}
