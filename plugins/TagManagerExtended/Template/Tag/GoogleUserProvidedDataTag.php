<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */
namespace Piwik\Plugins\TagManagerExtended\Template\Tag;

use Piwik\Piwik;
use Piwik\Settings\FieldConfig;
use Piwik\Plugins\TagManager\Template\Tag\BaseTag;
use Piwik\Validators\NotEmpty;

class GoogleUserProvidedDataTag extends BaseTag
{
    public function getName()
    {
        // By default, the name will be automatically fetched from the TagManagerExtended_CustomHtmlTagName translation key.
        // you can either adjust/create/remove this translation key, or return a different value here directly.
        return parent::getName();
    }

    public function getDescription()
    {
        // By default, the description will be automatically fetched from the TagManagerExtended_CustomHtmlTagDescription
        // translation key. you can either adjust/create/remove this translation key, or return a different value
        // here directly.
        return parent::getDescription();
    }

    public function getHelp()
    {
        // By default, the help will be automatically fetched from the TagManagerExtended_CustomHtmlTagHelp translation key.
        // you can either adjust/create/remove this translation key, or return a different value here directly.
        return parent::getHelp();
    }

    public function getCategory()
    {
        return self::CATEGORY_ANALYTICS;
    }

    public function getIcon()
    {
        // You may optionally specify a path to an image icon URL, for example:
        //
        // return 'plugins/TagManagerExtended/images/MyIcon.png';
        //
        // to not return default icon call:
        // return parent::getIcon();
        //
        // The image should have ideally a resolution of about 64x64 pixels.
        return 'plugins/TagManagerExtended/images/icons/tag/google.svg';
    }

    public function getParameters()
    {
        return array(
            $this->makeSetting('email', '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
                $field->title = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagEmailTitle');
                $field->description = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagEmailDescription');
                $field->customFieldComponent = self::FIELD_VARIABLE_COMPONENT;
            }),
            $this->makeSetting('sha256_email_address', '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
                $field->title = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagSha256EmailAddressTitle');
                $field->description = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagSha256EmailAddressDescription');
                $field->customFieldComponent = self::FIELD_VARIABLE_COMPONENT;
            }),
            $this->makeSetting('phone_number', '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
                $field->title = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagPhoneNumberTitle');
                $field->description = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagPhoneNumberDescription');
                $field->customFieldComponent = self::FIELD_VARIABLE_COMPONENT;
            }),
            $this->makeSetting('sha256_phone_number', '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
                $field->title = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagSha256PhoneNumberTitle');
                $field->description = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagSha256PhoneNumberDescription');
                $field->customFieldComponent = self::FIELD_VARIABLE_COMPONENT;
            }),
            $this->makeSetting('address_first_name', '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
                $field->title = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagAddressFirstNameTitle');
                $field->description = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagAddressFirstNameDescription');
                $field->customFieldComponent = self::FIELD_VARIABLE_COMPONENT;
            }),
            $this->makeSetting('address_sha256_first_name', '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
                $field->title = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagSha256AddressFirstNameTitle');
                $field->description = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagSha256AddressFirstNameDescription');
                $field->customFieldComponent = self::FIELD_VARIABLE_COMPONENT;
            }),
            $this->makeSetting('address_last_name', '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
                $field->title = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagAddressLastNameTitle');
                $field->description = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagAddressLastNameDescription');
                $field->customFieldComponent = self::FIELD_VARIABLE_COMPONENT;
            }),
            $this->makeSetting('address_sha256_last_name', '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
                $field->title = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagSha256AddressLastNameTitle');
                $field->description = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagSha256AddressLastNameDescription');
                $field->customFieldComponent = self::FIELD_VARIABLE_COMPONENT;
            }),
            $this->makeSetting('address_street', '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
                $field->title = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagAddressStreetTitle');
                $field->description = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagAddressStreetDescription');
                $field->customFieldComponent = self::FIELD_VARIABLE_COMPONENT;
            }),
            $this->makeSetting('address_city', '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
                $field->title = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagAddressCityTitle');
                $field->description = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagAddressCityDescription');
                $field->customFieldComponent = self::FIELD_VARIABLE_COMPONENT;
            }),
            $this->makeSetting('address_region', '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
                $field->title = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagAddressRegionTitle');
                $field->description = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagAddressRegionDescription');
                $field->customFieldComponent = self::FIELD_VARIABLE_COMPONENT;
            }),
            $this->makeSetting('address_postal_code', '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
                $field->title = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagAddressPostalCodeTitle');
                $field->description = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagAddressPostalCodeDescription');
                $field->customFieldComponent = self::FIELD_VARIABLE_COMPONENT;
            }),
            $this->makeSetting('address_country', '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
                $field->title = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagAddressCountryTitle');
                $field->description = Piwik::translate('TagManagerExtended_GoogleUserProvidedDataTagAddressCountryDescription');
                $field->customFieldComponent = self::FIELD_VARIABLE_COMPONENT;
            }),
        );
    }

}
