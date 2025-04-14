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

namespace Piwik\Plugins\GhostBrand;

use Piwik\AssetManager;
use Piwik\Piwik;
use Piwik\Settings\Setting;
use Piwik\Settings\FieldConfig;
use Piwik\SettingsPiwik;

/**
 * Defines Settings for GhostBrand.
 *
 * Usage like this:
 * $settings = new SystemSettings();
 * $settings->brandName->getValue();
 */
class SystemSettings extends \Piwik\Settings\Plugin\SystemSettings
{
    /** @var Setting */
    public $brandName;

    /** @var Setting */
    public $marketplaceOnlySuperUser;

    /** @var Setting */
    public $GhostBrandTrackingEndpoint;

    /** @var Setting */
    public $removeLinksToMatomo;

    /** @var Setting */
    public $headerBackgroundColor;

    /** @var Setting */
    public $headerFontColor;

    /** @var Setting */
    public $enableWhatsNewSection;

    protected function init()
    {
        // System setting --> allows selection of a single value
        $this->brandName = $this->createBrandNameSetting();
        $this->headerBackgroundColor = $this->createHeaderBackgroundColor();
        $this->headerFontColor = $this->createHeaderFontColor();
        $this->marketplaceOnlySuperUser = $this->createMarketplaceOnlySuperUserSetting();
        $this->GhostBrandTrackingEndpoint = $this->createGhostBrandTrackingEndpoint();
        $this->removeLinksToMatomo = $this->createRemoveLinksToMatomo();
        $this->enableWhatsNewSection = $this->enableWhatsNewSection();
    }

    private function createBrandNameSetting()
    {
        return $this->makeSetting('brandName', $default = '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = Piwik::translate('GhostBrand_SettingBrandNameTitle');
            $field->description = Piwik::translate('GhostBrand_SettingBrandNameDescription');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->validate = function ($value) {
                if (!empty($value) && strlen($value) > 50) {
                    $message = Piwik::translate('GhostBrand_SettingBrandNameMaxLen', 50);
                    throw new \Exception($message);
                }
                $blockedChars = array('>', '<', "'", '"', '{', '}', "\0","\n", "\r");
                foreach ($blockedChars as $blockedChar) {
                    if (!empty($value) && strpos($value, $blockedChar) !== false) {
                        $message = Piwik::translate('GhostBrand_SettingBrandNameInvalidChar', $blockedChar);
                        throw new \Exception($message);
                    }
                }

            };
        });
    }

    private function createMarketplaceOnlySuperUserSetting()
    {
        return $this->makeSetting('marketplaceOnlySuperUser', $default = false, FieldConfig::TYPE_BOOL, function (FieldConfig $field) {
            $field->title = Piwik::translate('GhostBrand_SettingMarketplaceOnlySuperUserTitle');
            $field->description = Piwik::translate('GhostBrand_SettingMarketplaceOnlySuperUserDescription');
            $field->uiControl = FieldConfig::UI_CONTROL_CHECKBOX;
        });
    }

    private function createGhostBrandTrackingEndpoint()
    {
        return $this->makeSetting('GhostBrandTrackingEndpoint', $default = false, FieldConfig::TYPE_BOOL, function (FieldConfig $field) {
            $field->title = Piwik::translate('GhostBrand_SettingGhostBrandTrackingEndpoint');
            $url = '"'.SettingsPiwik::getPiwikUrl() . 'js/tracker.php' . '"';
            $field->description = Piwik::translate('GhostBrand_SettingGhostBrandTrackingEndpointDescription', $url);
            $field->uiControl = FieldConfig::UI_CONTROL_CHECKBOX;
        });
    }

    private function createRemoveLinksToMatomo()
    {
        return $this->makeSetting('removeLinksToMatomo', $default = false, FieldConfig::TYPE_BOOL, function (FieldConfig $field) {
            $field->title = Piwik::translate('GhostBrand_SettingRemoveLinksToMatomo');
            $field->description = Piwik::translate('GhostBrand_SettingRemoveLinksToMatomoDescription');
            $field->uiControl = FieldConfig::UI_CONTROL_CHECKBOX;
        });
    }

    private function enableWhatsNewSection()
    {
        return $this->makeSetting('enableWhatsNewSection', $default = true, FieldConfig::TYPE_BOOL, function (FieldConfig $field) {
            $field->title = Piwik::translate('GhostBrand_SettingEnableWhatsNewSectionTitle');
            $field->description = Piwik::translate('GhostBrand_SettingEnableWhatsNewSectionDescription');
            $field->inlineHelp = Piwik::translate('GhostBrand_SettingEnableWhatsNewSectionInlineHelp', array('<br><strong>', '</strong>'));
            $field->uiControl = FieldConfig::UI_CONTROL_CHECKBOX;
        });
    }

    private function createHeaderBackgroundColor()
    {
        return $this->makeSetting('headerBackgroundColor', $default = '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = Piwik::translate('GhostBrand_SettingHeaderBackgroundColor');
            $field->description = Piwik::translate('GhostBrand_SettingColorHelp');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->uiControlAttributes = array('maxlength' => 7);
            $field->validate = function ($value) {
                if ($value === false || $value === '' || $value === null) {
                    return;// vald
                }
                if (substr($value, 0, 1) === '#') {
                    $value = substr($value, 1);
                }
                if (ctype_xdigit($value) && in_array(strlen($value),array(3,6), true)) {
                    return;
                }
                throw new \Exception("The header background value '$value' is not valid. Expected value is for example 'ffffff' or 'fff'.");
            };
            $field->transform = function ($value) {
                if ($value && substr($value, 0, 1) === '#') {
                    $value = substr($value, 1);
                }

                return $value;
            };
        });
    }
    
    public function save()
    {
        parent::save();
        AssetManager::getInstance()->removeMergedAssets();
    }

    private function createHeaderFontColor()
    {
        return $this->makeSetting('headerFontColor', $default = '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = Piwik::translate('GhostBrand_SettingHeaderFontColor');
            $field->description = Piwik::translate('GhostBrand_SettingColorHelp');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->validate = function ($value) {
                if ($value === false || $value === '' || $value === null) {
                    return;// vald
                }
                if (substr($value, 0, 1) === '#') {
                    $value = substr($value, 1);
                }
                if (ctype_xdigit($value) && in_array(strlen($value),array(3,6), true)) {
                    return;
                }
                throw new \Exception("The header background value '$value' is not valid. Expected value is for example 'ffffff' or 'fff'.");
            };
            $field->transform = function ($value) {
                if ($value && substr($value, 0, 1) === '#') {
                    $value = substr($value, 1);
                }

                return $value;
            };
        });
    }

}
