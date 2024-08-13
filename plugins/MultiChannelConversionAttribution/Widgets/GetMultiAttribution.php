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
namespace Piwik\Plugins\MultiChannelConversionAttribution\Widgets;

use Piwik\API\Request;
use Piwik\Common;
use Piwik\Date;
use Piwik\Piwik;
use Piwik\Period;
use Piwik\Option;
use Piwik\Plugin\ReportsProvider;
use Piwik\Plugins\MultiChannelConversionAttribution\Models\Base as BaseAttribution;
use Piwik\Plugins\MultiChannelConversionAttribution\Configuration;
use Piwik\Plugins\MultiChannelConversionAttribution\Input\Validator;
use Piwik\Plugins\MultiChannelConversionAttribution\Metrics;
use Piwik\Plugins\MultiChannelConversionAttribution\Model\GoalAttributionModel;
use Piwik\Plugins\MultiChannelConversionAttribution\MultiChannelConversionAttribution;
use Piwik\Plugins\MultiChannelConversionAttribution\SystemSettings;
use Piwik\SettingsPiwik;
use Piwik\Tracker\GoalManager;
use Piwik\Url;
use Piwik\Widget\Widget;
use Piwik\Widget\WidgetConfig;

class GetMultiAttribution extends Widget
{
    /**
     * @var GoalAttributionModel
     */
    protected $model;

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * @var SystemSettings
     */
    private $systemSettings;

    public function __construct(GoalAttributionModel $model, Configuration $configuration, Validator $validator, SystemSettings $systemSettings)
    {
        $this->model = $model;
        $this->configuration = $configuration;
        $this->validator = $validator;
        $this->systemSettings = $systemSettings;
    }

    public static function configure(WidgetConfig $config)
    {
        $config->setCategoryId('Goals_Goals');
        $config->setSubcategoryId('MultiChannelConversionAttribution_MultiAttribution');
        $config->setName('MultiChannelConversionAttribution_MultiChannelConversionAttribution');
        $config->setOrder(99);

        $idSite = Common::getRequestVar('idSite', 0, 'int');
        if (!empty($idSite)) {
            $config->setIsEnabled(Piwik::isUserHasViewAccess($idSite));
        } else {
            $config->disable();
        }
    }

    protected function getGoals($idSite)
    {
        $goals = Request::processRequest('MultiChannelConversionAttribution.getSiteAttributionGoals', [
            'idSite' => $idSite, 'filter_limit' => -1
        ], $default = []);
        foreach ($goals as $index => $goal) {
            if ($goal['idgoal'] === GoalManager::IDGOAL_ORDER) {
                unset($goals[$index]);
            }
        }
        return $goals;
    }

    public function render()
    {
        $idSite = Common::getRequestVar('idSite', 0, 'int');
        $this->validator->checkReportViewPermission($idSite);

        $isWidgetized = Common::getRequestVar('widget', 0, 'int');

        $goals = array();
        foreach ($this->getGoals($idSite) as $goal) {
            // string is important to preselect correct value
            $goals[] = array('key' => (string) $goal['idgoal'], 'value' => $goal['name']);
        }
        $firstGoal = $this->getDefaultValue('idGoal', 'string', '-2', $goals);
        if (empty($goals)) {
            $firstGoal = null;
        }

        $campaignDimensionCombinationOptions = $this->systemSettings->getTransformedCampaignDimensionCombinationOptions();
        $defaultCampaignDimensionCombination = $this->getDefaultValue('idCampaignDimensionCombination', 'int', 0, $campaignDimensionCombinationOptions);

        $attributionModels = array();
        $attributionModelsCancelable = array(
            array('key' => '', 'value' => Piwik::translate('MultiChannelConversionAttribution_SelectModel'))
        );
        $reportHelp = Piwik::translate('MultiChannelConversionAttribution_ChannelReportInlineHelpStart') . ': ';
        foreach (BaseAttribution::getAll() as $attribution) {
            $attributionModels[] = array('key' => (string) $attribution->getId(), 'value' => $attribution->getName());
            $attributionModelsCancelable[] = array('key' => (string) $attribution->getId(), 'value' => $attribution->getName());
            $reportHelp .= '<br /><strong>'. $attribution->getName() . '</strong>: ' . $attribution->getDocumentation() . "\n";
        }


        $selectedModels = array();
        $selectedModels[] = $this->getDefaultValue('attributionModel1', 'string', 'lastInteraction', $attributionModels);
        $selectedModels[] = $this->getDefaultValue('attributionModel2', 'string', '', $attributionModels, false);
        $selectedModels[] = $this->getDefaultValue('attributionModel3', 'string', '', $attributionModels, false);
        $_GET['attributionModels'] = implode(',', $selectedModels);
        $_GET['comparisonMetric'] = Metrics::SUM_CONVERSIONS;

        if (isset($firstGoal)) {
            $_GET['idGoal'] = (int) $firstGoal;
            $report = ReportsProvider::factory('MultiChannelConversionAttribution', 'getChannelAttribution');
            $report = $report->render();
        } else {
            $report = '';
        }

        $comparisonOptions = array(
            array('key' => Metrics::SUM_CONVERSIONS, 'value' => Piwik::translate('Goals_ColumnConversions')),
            array('key' => Metrics::SUM_REVENUE, 'value' => Piwik::translate('General_ColumnRevenue')),
        );
        $settingsUrl = '';
        if (\Piwik\Piwik::hasUserSuperUserAccess()) {
            $settingsUrl = SettingsPiwik::getPiwikUrl() . 'index.php?' . Url::getQueryStringFromParameters([
                    'idSite' => $idSite,
                    'module' => 'CoreAdminHome',
                    'action' => 'generalSettings',
                ]) . '#MultiChannelConversionAttributionPluginSettings';
        }

        $showInconsistentDataAlertMessage = '';
        if ($this->isOlderDateInRequest()) {
            $updateDateTimeStamp = (int) Option::get(MultiChannelConversionAttribution::LAST_PLUGIN_UPDATE_DATE);
            $pluginUpdateDate = Date::factory($updateDateTimeStamp)->toString('Y-m-d');
            $showInconsistentDataAlertMessage = Piwik::translate('MultiChannelConversionAttribution_InconsistentLastNonDirectDataAlert', array('<strong>', '</strong>', $pluginUpdateDate));
        }

        $noGoalEnabledMessageKey = 'MultiChannelConversionAttribution_NoGoalEnabledWithoutWriteAccess';
        if (Piwik::isUserHasWriteAccess($idSite)) {
            $noGoalEnabledMessageKey = 'MultiChannelConversionAttribution_NoGoalEnabledWithWriteAccess';
        }

        return $this->renderTemplate('report', array(
            'campaignDimensionCombinationOptions' => $campaignDimensionCombinationOptions,
            'defaultCampaignDimensionCombination' => (string) $defaultCampaignDimensionCombination,
            'goals' => $goals,
            'firstGoal' => $firstGoal,
            'attributionModels' => $attributionModels,
            'attributionModelsCancelable' => $attributionModelsCancelable,
            'report' => $report,
            'selectedModels' => $selectedModels,
            'comparisonOptions' => $comparisonOptions,
            'isWidgetized' => $isWidgetized,
            'reportHelp' => $reportHelp,
            'settingsUrl' => $settingsUrl,
            'showInconsistentDataAlertMessage' => $showInconsistentDataAlertMessage,
            'noGoalEnabledMessageKey' => $noGoalEnabledMessageKey
        ));
    }

    private function getDefaultValue($requestKeyName, $requestKeyType, $defaultValue, $availableValues, $selectFirstValueAsDefault = true)
    {
        $urlValue = Common::getRequestVar($requestKeyName, $defaultValue, $requestKeyType);

        foreach ($availableValues as $availableValue) {
            if (isset($availableValue['key']) && $availableValue['key'] == $urlValue) {
                return $urlValue;
            }
        }

        return (isset($availableValues[0]['key']) && $selectFirstValueAsDefault ? $availableValues[0]['key'] : $defaultValue);
    }

    private function isOlderDateInRequest()
    {
        $updateTimeStamp = Option::get(MultiChannelConversionAttribution::LAST_PLUGIN_UPDATE_DATE);
        $period = Common::getRequestVar('period');
        $date = Common::getRequestVar('date');

        if (!$updateTimeStamp || !$period || !$date) {
            return false;
        }

        $startDateTimeStamp = Date::factory(Period\Factory::makePeriodFromQueryParams('',
            $period, $date)->getDateStart())->getTimestamp();

        return $updateTimeStamp > $startDateTimeStamp;
    }

}
