<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\MultiChannelConversionAttribution;

use Piwik\Common;
use Piwik\Piwik;
use Piwik\Settings\Setting;
use Piwik\Settings\FieldConfig;
use Piwik\SettingsPiwik;
use Piwik\Url;

/**
 * Defines Settings for MultiChannelConversionAttribution.
 *
 * Usage like this:
 * $settings = new SystemSettings();
 * $settings->metric->getValue();
 * $settings->description->getValue();
 */
class SystemSettings extends \Piwik\Settings\Plugin\SystemSettings
{
    /** @var Setting */
    public $campaignDimensionCombinations;

    /*
     * @var Configuration
     */
    private $configuration;

    private $defaultCampaignCombinationOptions = [
        ['period' => 90, 'topLevel' => 'referer_name'],
        ['period' => 90, 'topLevel' => 'referer_keyword'],
        ['period' => 90, 'topLevel' => 'referer_name', 'subLevel' => 'referer_keyword']
    ];

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
        parent::__construct();
    }

    protected function init()
    {
        $this->campaignDimensionCombinations = $this->campaignDimensionCombinationSetting();
    }

    private function campaignDimensionCombinationSetting()
    {
        $self = $this;
        return $this->makeSetting('campaignDimensionCombination', $self->defaultCampaignCombinationOptions, FieldConfig::TYPE_ARRAY, function (FieldConfig $field) use ($self) {
            $idSite = Common::getRequestVar('idSite', 0, 'int');
            $period = Common::getRequestVar('period', 'day', 'string');
            $date = Common::getRequestVar('date', 'yesterday', 'string');
            $reportLink = SettingsPiwik::getPiwikUrl() . 'index.php?' . Url::getQueryStringFromParameters([
                    'idSite' => $idSite,
                    'date' => $date,
                    'period' => $period,
                    'module' => 'CoreHome',
                    'action' => 'index',
                ]) . '#category=Goals_Goals&subcategory=MultiChannelConversionAttribution_MultiAttribution'."&idSite=$idSite&period=$period&date=$date";
            $showShowReArchiveFAQ = $this->configuration->shouldShowReArchiveFAQ();
            $field->title = Piwik::translate('MultiChannelConversionAttribution_CampaignDimensionCombinationSettingTitleNew', array('<a href="'.$reportLink.'" target="_blank" rel="noreferrer noopener">', '</a>'));
            $inlineHelpText = Piwik::translate('MultiChannelConversionAttribution_CampaignDimensionCombinationSettingHelpLine1', array('<b>', '</b>'));
            if ($showShowReArchiveFAQ) {
                $inlineHelpText .= ' '.Piwik::translate('MultiChannelConversionAttribution_CampaignDimensionCombinationSettingHelpLine1FAQ', array('<a href="' . $reportLink . '" target="_blank" rel="noreferrer noopener">', '</a>'));
            }
            $inlineHelpText .= '<br><br>';
            $inlineHelpText .= Piwik::translate('MultiChannelConversionAttribution_CampaignDimensionCombinationSettingHelpLine2', array('<b>', '</b>', '<a href="'.$reportLink.'" target="_blank" rel="noreferrer noopener">', '</a>')). '<br><br>';
            $inlineHelpText .= Piwik::translate('MultiChannelConversionAttribution_CampaignDimensionCombinationSettingHelpLine3', array('<b>', '</b>'));
            if ($showShowReArchiveFAQ) {
                $inlineHelpText .= ' '.Piwik::translate('MultiChannelConversionAttribution_CampaignDimensionCombinationSettingHelpLine3ReArchiveFaq',
                        ['<a href="' . Url::addCampaignParametersToMatomoLink('https://matomo.org/faq/how-to/faq_155/', null, null, 'App.MultiChannelConversionAttribution.campaignDimensionCombinationSetting') . '" target="_blank" rel="noreferrer noopener">', '</a>']);
            }
            $field->inlineHelp = $inlineHelpText;
            $field->uiControl = FieldConfig::UI_CONTROL_MULTI_TUPLE;
            $field->uiControlAttributes['rows'] = 3; //Available since Matomo 5
            $field1 = new FieldConfig\MultiPair(Piwik::translate('MultiChannelConversionAttribution_CampaignDimensionCombinationPeriodSettingTitle'), 'period',
                FieldConfig::UI_CONTROL_TEXT);

            $field1->availableValues = $self->getPeriodValues();
            $field1->uiControl = FieldConfig::UI_CONTROL_SINGLE_SELECT;

            $field2 = new FieldConfig\MultiPair(Piwik::translate('MultiChannelConversionAttribution_CampaignDimensionCombinationTopLevelSettingTitle'), 'topLevel',
                FieldConfig::UI_CONTROL_TEXT);
            $field2->availableValues = $self->getCampaignOptions();
            $field2->uiControl = FieldConfig::UI_CONTROL_SINGLE_SELECT;

            $field3 = new FieldConfig\MultiPair(Piwik::translate('MultiChannelConversionAttribution_CampaignDimensionCombinationSubLevelSettingTitle'), 'subLevel',
                FieldConfig::UI_CONTROL_TEXT);
            $field3->availableValues = $self->getCampaignOptions();
            $field3->uiControl = FieldConfig::UI_CONTROL_SINGLE_SELECT;

            $field->uiControlAttributes['field1'] = $field1->toArray();
            $field->uiControlAttributes['field2'] = $field2->toArray();
            $field->uiControlAttributes['field3'] = $field3->toArray();
            $field->validate = function ($values) use ($self) {
                $combinations = [];
                $campaignOptions = $self->getCampaignOptions();
                $availablePeriods = $self->getPeriodValues();
                foreach ($values as $index=>$value) {
                    if (empty($value['period']) && empty($value['topLevel']) && empty($value['subLevel'])) {
                        continue;
                    }
                    $key = $value['period'] . '_' . $value['topLevel'] . (!empty($value['subLevel']) ? '_' . $value['subLevel'] : '');
                    if (empty($value['period']) || empty($value['topLevel'])) {
                        throw new \Exception(Piwik::translate('MultiChannelConversionAttribution_ExceptionMessagePeriodOrTopLevelEmpty'));
                    } else if (!isset($availablePeriods[$value['period']])) {
                        throw new \Exception(Piwik::translate('MultiChannelConversionAttribution_ExceptionMessagePeriodInvalid', rtrim(implode(', ', $availablePeriods), ',')));
                    } else if (isset($value['subLevel']) && $value['topLevel'] == $value['subLevel']) {
                        throw new \Exception(Piwik::translate('MultiChannelConversionAttribution_ExceptionMessageSameTopAndSubLevel'));
                    } else if (empty($campaignOptions[$value['topLevel']])) {
                        throw new \Exception(Piwik::translate('MultiChannelConversionAttribution_ExceptionMessageTopLevelEmpty'));
                    } else if (!empty($value['subLevel']) && empty($campaignOptions[$value['subLevel']])) {
                        $values[$index]['subLevel'] = '';
                        $key = $value['period'] . '_' . $value['topLevel'];
                    }

                    if (isset($combinations[$key])) {
                        throw new \Exception(Piwik::translate('MultiChannelConversionAttribution_ExceptionMessageDuplicateCombination'));
                    }

                    $combinations[$key] = 1;
                }
            };
            $field->transform = function ($values) use ($self) {
                $campaignOptions = $self->getCampaignOptions();
                foreach ($values as $index=>$value) {
                    if (empty($value['period']) && empty($value['topLevel']) && empty($value['subLevel'])) {
                        unset($values[$index]);
                    } else if (!empty($value['subLevel']) && empty($campaignOptions[$value['subLevel']])) {
                        $values[$index]['subLevel'] = '';
                    }
                }

                return array_values($values);
            };
        });
    }

    public function getCampaignOptions()
    {
        $campaignOptions = ['referer_name' => 'Campaign Name', 'referer_keyword' => 'Campaign Keyword'];
        if(\Piwik\Plugin\Manager::getInstance()->isPluginActivated('MarketingCampaignsReporting')) {
            $campaignContent = new \Piwik\Plugins\MarketingCampaignsReporting\Columns\CampaignContent();
            $campaignOptions[$campaignContent->getColumnName()] = $campaignContent->getName();

            $campaignGroup= new  \Piwik\Plugins\MarketingCampaignsReporting\Columns\CampaignGroup();
            $campaignOptions[$campaignGroup->getColumnName()] = $campaignGroup->getName();

            $campaignId= new  \Piwik\Plugins\MarketingCampaignsReporting\Columns\CampaignId();
            $campaignOptions[$campaignId->getColumnName()] = $campaignId->getName();

            $campaignMedium = new  \Piwik\Plugins\MarketingCampaignsReporting\Columns\CampaignMedium();
            $campaignOptions[$campaignMedium->getColumnName()] = $campaignMedium->getName();

            $campaignPlacement = new  \Piwik\Plugins\MarketingCampaignsReporting\Columns\CampaignPlacement();
            $campaignOptions[$campaignPlacement->getColumnName()] = $campaignPlacement->getName();

            $campaignSource = new  \Piwik\Plugins\MarketingCampaignsReporting\Columns\CampaignSource();
            $campaignOptions[$campaignSource->getColumnName()] = $campaignSource->getName();
        }

        return $campaignOptions;
    }

    public function getTransformedCampaignDimensionCombinationOptions($raw = false)
    {
        $values = $this->campaignDimensionCombinations->getValue();
        $transformValues = [];
        $campaignOptions = $this->getCampaignOptions();
        $availablePeriodValues = $this->getPeriodValues();
        $index = 0;
        foreach ($values as $value) {
            if (
                empty($value['period']) ||
                empty($value['topLevel']) ||
                empty($campaignOptions[$value['topLevel']]) ||
                (!empty($value['subLevel']) && empty($campaignOptions[$value['subLevel']])) ||
                (!isset($availablePeriodValues[$value['period']]))
            ) {
                continue;
            }
            if ($raw) {
                $transformValues[$index] = $value;
            } else {
                $transformValues[$index] = [
                    'key' => $index,
                    'value' => ($campaignOptions[$value['topLevel']]) . (!empty($value['subLevel']) ? ' - ' . $campaignOptions[$value['subLevel']] : '') . ' (' . $value['period'] . ' days' . ')'
                ];
            }
            $index++;
        }
        return $transformValues;
    }

    public function getPeriodValues()
    {
        $daysPriorToConversion = $this->configuration->getDaysPriorToConversion();
        $periods = [];
        foreach ($daysPriorToConversion as $dayPriorToConversion) {
            $periods[$dayPriorToConversion] = $dayPriorToConversion;
        }

        return $periods;
    }
}
