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

class GoogleAnalytics4EventTag extends BaseTag
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
        return 'plugins/TagManagerExtended/images/icons/tag/google-analytics-4.svg';
    }

    public function getParameters()
    {
        return array(
            $this->makeSetting('eventName', '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
                $field->title = Piwik::translate('TagManagerExtended_GoogleAnalytics4EventNameTitle');
                $field->description = Piwik::translate('TagManagerExtended_GoogleAnalytics4EventNameDescription');
                $field->customFieldComponent = self::FIELD_VARIABLE_COMPONENT;
                $field->validators[] = new NotEmpty();
            }),

            $this->makeSetting('eventParameters', '', FieldConfig::TYPE_ARRAY, function (FieldConfig $field) {
                $field->uiControl = FieldConfig::UI_CONTROL_MULTI_TUPLE;
                $field->title = Piwik::translate('TagManagerExtended_GoogleAnalytics4EventParametersTitle');
                $field->description = Piwik::translate('TagManagerExtended_GoogleAnalytics4EventParametersDescription');

                $field1 = new FieldConfig\MultiPair(Piwik::translate('Parameter'), 'parameter', FieldConfig::UI_CONTROL_TEXT);
                $field1->customFieldComponent = self::FIELD_VARIABLE_COMPONENT;

                $field2 = new FieldConfig\MultiPair(Piwik::translate('Value'), 'value', FieldConfig::UI_CONTROL_TEXT);
                $field2->customFieldComponent = self::FIELD_VARIABLE_COMPONENT;

                $field->uiControlAttributes['field1'] = $field1->toArray();
                $field->uiControlAttributes['field2'] = $field2->toArray();
            }),

        );
    }

}
