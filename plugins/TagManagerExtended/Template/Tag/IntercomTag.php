<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */
namespace Piwik\Plugins\TagManagerExtended\Template\Tag;

use Piwik\Piwik;
use Piwik\Plugins\TagManager\Template\Tag\BaseTag;
use Piwik\Settings\FieldConfig;
use Piwik\Validators\NotEmpty;

class IntercomTag extends BaseTag
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
        return self::CATEGORY_REMARKETING;
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
        return 'plugins/TagManagerExtended/images/icons/tag/intercom.svg';
    }

    public function getParameters()
    {
        return array(
            $this->makeSetting('app_id', '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
                $field->title = Piwik::translate('TagManagerExtended_IntercomTagAppIdTitle');
                $field->description = Piwik::translate('TagManagerExtended_IntercomTagAppIdDescription');
                $field->customFieldComponent = self::FIELD_VARIABLE_COMPONENT;
                $field->validators[] = new NotEmpty();
            }),

            $this->makeSetting('api_base', 'https://api-iam.intercom.io', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
                $field->title = Piwik::translate('TagManagerExtended_IntercomTagApiBaseTitle');
                $field->description = Piwik::translate('TagManagerExtended_IntercomTagApiBaseDescription');
                $field->customFieldComponent = self::FIELD_VARIABLE_COMPONENT;
                $field->validators[] = new NotEmpty();
            }),

            $this->makeSetting('user_id', '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
                $field->title = Piwik::translate('TagManagerExtended_IntercomTagUserIdTitle');
                $field->description = Piwik::translate('TagManagerExtended_IntercomTagUserIdDescription');
                $field->customFieldComponent = self::FIELD_VARIABLE_COMPONENT;
            }),

            $this->makeSetting('user_name', '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
                $field->title = Piwik::translate('TagManagerExtended_IntercomTagUserNameTitle');
                $field->description = Piwik::translate('TagManagerExtended_IntercomTagUserNameDescription');
                $field->customFieldComponent = self::FIELD_VARIABLE_COMPONENT;
            }),

            $this->makeSetting('user_email', '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
                $field->title = Piwik::translate('TagManagerExtended_IntercomTagUserEmailTitle');
                $field->description = Piwik::translate('TagManagerExtended_IntercomTagUserEmailDescription');
                $field->customFieldComponent = self::FIELD_VARIABLE_COMPONENT;
            }),

            $this->makeSetting('user_created_at', '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
                $field->title = Piwik::translate('TagManagerExtended_IntercomTagUserCreatedAtTitle');
                $field->description = Piwik::translate('TagManagerExtended_IntercomTagUserCreatedAtDescription');
                $field->customFieldComponent = self::FIELD_VARIABLE_COMPONENT;
            }),

            $this->makeSetting('alignment', 'left', FieldConfig::TYPE_ARRAY, function (FieldConfig $field) {
                $field->title = Piwik::translate('TagManagerExtended_IntercomTagAlignmentTitle');
                $field->description = Piwik::translate('TagManagerExtended_IntercomTagAlignmentDescription');
                $field->uiControl = FieldConfig::UI_CONTROL_SINGLE_SELECT;
                $field->availableValues = array(
                    'left' => 'Left',
                    'right' => 'Right',
                );
                $field->validators[] = new NotEmpty();
            }),

            $this->makeSetting('horizontal_padding', '', FieldConfig::TYPE_INT, function (FieldConfig $field) {
                $field->title = Piwik::translate('TagManagerExtended_IntercomTagHorizontalPaddingTitle');
                $field->description = Piwik::translate('TagManagerExtended_IntercomTagHorizontalPaddingDescription');
                $field->customFieldComponent = self::FIELD_VARIABLE_COMPONENT;
            }),

            $this->makeSetting('vertical_padding', '', FieldConfig::TYPE_INT, function (FieldConfig $field) {
                $field->title = Piwik::translate('TagManagerExtended_IntercomTagVerticalPaddingTitle');
                $field->description = Piwik::translate('TagManagerExtended_IntercomTagVerticalPaddingDescription');
                $field->customFieldComponent = self::FIELD_VARIABLE_COMPONENT;
            }),
        );
    }

}
