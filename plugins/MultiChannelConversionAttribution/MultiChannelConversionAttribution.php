<?php 
/**
 * Plugin Name: Multi Channel Conversion Attribution (Matomo Plugin)
 * Plugin URI: https://plugins.matomo.org/MultiChannelConversionAttribution
 * Description: Get a clear understanding of how much credit each of your marketing channel is actually responsible for to shift your marketing efforts wisely.
 * Author: InnoCraft
 * Author URI: https://www.innocraft.com
 * Version: 5.0.8
 */
?><?php

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

namespace Piwik\Plugins\MultiChannelConversionAttribution;

use Piwik\API\Request;
use Piwik\Archive\ArchiveInvalidator;
use Piwik\Common;
use Piwik\Container\StaticContainer;
use Piwik\Piwik;
use Piwik\Plugin;
use Piwik\Plugins\MultiChannelConversionAttribution\Dao\GoalAttributionDao;
use Piwik\Plugins\MultiChannelConversionAttribution\Model\GoalAttributionModel;
use Piwik\Plugins\MultiChannelConversionAttribution\RecordBuilders\GoalAttribution;

 
if (defined( 'ABSPATH')
&& function_exists('add_action')) {
    $path = '/matomo/app/core/Plugin.php';
    if (defined('WP_PLUGIN_DIR') && WP_PLUGIN_DIR && file_exists(WP_PLUGIN_DIR . $path)) {
        require_once WP_PLUGIN_DIR . $path;
    } elseif (defined('WPMU_PLUGIN_DIR') && WPMU_PLUGIN_DIR && file_exists(WPMU_PLUGIN_DIR . $path)) {
        require_once WPMU_PLUGIN_DIR . $path;
    } else {
        return;
    }
    add_action('plugins_loaded', function () {
        if (function_exists('matomo_add_plugin')) {
            matomo_add_plugin(__DIR__, __FILE__, true);
        }
    });
}

class MultiChannelConversionAttribution extends \Piwik\Plugin
{
    public const LAST_PLUGIN_UPDATE_DATE = 'LastPluginUpdate.MultiChannelConversionAttribution';

    /**
     * @see \Piwik\Plugin::registerEvents
     */
    public function registerEvents()
    {
        return array(
            'Template.beforeGoalListActionsHead' => 'printGoalListHead',
            'Template.beforeGoalListActionsBody' => 'printGoalListBody',
            'Template.endGoalEditTable' => 'printGoalEdit',
            'AssetManager.getJavaScriptFiles' => 'getJsFiles',
            'AssetManager.getStylesheetFiles' => 'getStylesheetFiles',
            'API.Goals.addGoal.end' => 'setAttributionFromAddGoal',
            'API.Goals.updateGoal.end' => 'setAttributionFromGoalUpdate',
            'API.Goals.deleteGoal.end' => 'onDeleteGoal',
            'SitesManager.deleteSite.end' => 'onDeleteSite',
            'Translate.getClientSideTranslationKeys' => 'getClientSideTranslationKeys',
            'Metrics.getDefaultMetricTranslations' => 'getDefaultMetricTranslations',
            'Metrics.getDefaultMetricDocumentationTranslations' => 'getDefaultMetricDocumentationTranslations',
            'Db.getTablesInstalled' => 'getTablesInstalled',
            'Archiver.addRecordBuilders' => 'addRecordBuilders',
        );
    }

    public function addRecordBuilders(array &$recordBuilders): void
    {
        $idSite = \Piwik\Request::fromRequest()->getIntegerParameter('idSite', 0);
        if (empty($idSite)) {
            return;
        }

        $attributions = StaticContainer::get(GoalAttributionModel::class);
        $idGoals = $attributions->getSiteAttributionGoalIds($idSite);

        $systemSettings = StaticContainer::get(SystemSettings::class);
        $campaignDimensionCombinations = $systemSettings->getTransformedCampaignDimensionCombinationOptions(true);

        $configuration = StaticContainer::get(Configuration::class);
        $maxRowsInTable = $configuration->getMaximumRowsInDataTable();
        $maxRowsInSubtable = $configuration->getMaximumRowsInSubTable();

        foreach ($campaignDimensionCombinations as $campaignDimensionCombination) {
            if (empty($campaignDimensionCombination['period']) || empty($campaignDimensionCombination['topLevel'])) {
                continue;
            }

            $recordBuilders[] = new GoalAttribution($campaignDimensionCombination, $idGoals, $maxRowsInTable, $maxRowsInSubtable);
        }
    }

    /**
     * Register the new tables, so Matomo knows about them.
     *
     * @param array $allTablesInstalled
     */
    public function getTablesInstalled(&$allTablesInstalled)
    {
        $allTablesInstalled[] = Common::prefixTable('goal_attribution');
    }

    public function install()
    {
        $configuration = new Configuration();
        $configuration->install();

        $attributionDao = new GoalAttributionDao();
        $attributionDao->install();
    }

    public function activate()
    {
        if (Plugin\Manager::getInstance()->isPluginActivated('Goals') && Piwik::hasUserSuperUserAccess()) {
            try {
                $goals = Request::processRequest('Goals.getGoals', array('idSite' => 'all', 'filter_limit' => -1), $default = []);
                if (count($goals) <= 50) {
                    $attributionDao = new GoalAttributionDao();

                    foreach ($goals as $goal) {
                        $attributionDao->addGoalAttribution($goal['idsite'], $goal['idgoal']);
                    }
                }
            } catch (\Exception $e) {
            }
        }

        $this->schedulePluginReArchiving();
    }

    public function deactivate()
    {
        $archiveInvalidator = StaticContainer::get(ArchiveInvalidator::class);
        $archiveInvalidator->removeInvalidationsSafely('all', $this->getPluginName());
    }

    public function uninstall()
    {
        $configuration = new Configuration();
        $configuration->uninstall();

        $attributionDao = new GoalAttributionDao();
        $attributionDao->uninstall();
    }

    private function getDao()
    {
        return StaticContainer::get('Piwik\Plugins\MultiChannelConversionAttribution\Dao\GoalAttributionDao');
    }

    private function getValidator()
    {
        return StaticContainer::get('Piwik\Plugins\MultiChannelConversionAttribution\Input\Validator');
    }

    public function printGoalListHead(&$out)
    {
        $out .= '<th>' . Piwik::translate('MultiChannelConversionAttribution_Attribution') . '</th>';
    }

    public function setAttributionFromAddGoal($returnedValue, $info)
    {
        if ($returnedValue) {
            $idGoal = $returnedValue;
            $finalParameters = $info['parameters'];
            $idSite = $finalParameters['idSite'];

            $this->setAttribution($idSite, $idGoal);
        }
    }

    public function setAttributionFromGoalUpdate($value, $info)
    {
        if (empty($info['parameters'])) {
            return;
        }

        $finalParameters = $info['parameters'];
        $idSite = $finalParameters['idSite'];
        $idGoal = $finalParameters['idGoal'];

        $this->setAttribution($idSite, $idGoal);
    }

    private function setAttribution($idSite, $idGoal)
    {
        if (!isset($_POST['multiAttributionEnabled'])) {
            // no value was set, we should not change anything
            return;
        }

        $isEnabled = Common::getRequestVar('multiAttributionEnabled', 0, 'int');

        Request::processRequest('MultiChannelConversionAttribution.setGoalAttribution', array(
            'idSite' => $idSite,
            'idGoal' => $idGoal,
            'isEnabled' => $isEnabled
        ), $default = []);
    }

    public function printGoalListBody(&$out, $goal)
    {
        $attribution = Request::processRequest('MultiChannelConversionAttribution.getGoalAttribution', [
            'idSite' => $goal['idsite'],
            'idGoal' => $goal['idgoal'],
        ], $default = []);

        $isEnabled = (bool)$attribution['isEnabled'];

        $out .= '<td>';

        if (!empty($isEnabled)) {
            $message = Piwik::translate('MultiChannelConversionAttribution_MultiAttributionEnabledForGoal');
            $message = htmlentities($message);
            $out .= '<span title="' . $message . '" class="icon-ok multiAttributionActivated"></span>';
        } else {
            $out .= '-';
        }

        $out .= '</td>';
    }

    public function getDefaultMetricTranslations(&$translations)
    {
        $translations = array_merge($translations, Metrics::getMetricsTranslations());
    }

    public function getDefaultMetricDocumentationTranslations(&$translations)
    {
        $translations = array_merge($translations, Metrics::getMetricsDocumentationTranslations());
    }

    public function printGoalEdit(&$out)
    {
        $idSite = Common::getRequestVar('idSite', 0, 'int');

        if (!$this->getValidator()->canWrite($idSite)) {
            return;
        }

        $out .= '<div vue-entry="MultiChannelConversionAttribution.ManageMultiattribution"></div>';
    }

    public function getJsFiles(&$jsFiles)
    {
        $jsFiles[] = "plugins/MultiChannelConversionAttribution/javascripts/attributionDataTable.js";
    }

    public function getStylesheetFiles(&$stylesheets)
    {
        $stylesheets[] = "plugins/MultiChannelConversionAttribution/vue/src/ManageMultiattribution/ManageMultiattribution.less";
        $stylesheets[] = "plugins/MultiChannelConversionAttribution/vue/src/ReportAttribution/ReportAttribution.less";
        $stylesheets[] = "plugins/MultiChannelConversionAttribution/stylesheets/styles.css";
    }

    public function getClientSideTranslationKeys(&$translationKeys)
    {
        $translationKeys[] = 'MultiChannelConversionAttribution_Introduction';
        $translationKeys[] = 'MultiChannelConversionAttribution_Enabled';
        $translationKeys[] = 'MultiChannelConversionAttribution_MultiChannelConversionAttribution';
        $translationKeys[] = 'General_Goal';
        $translationKeys[] = 'MultiChannelConversionAttribution_DaysPriorToConversion';
        $translationKeys[] = 'MultiChannelConversionAttribution_AttributionModelX';
        $translationKeys[] = 'MultiChannelConversionAttribution_NoGoalEnabled';
        $translationKeys[] = 'MultiChannelConversionAttribution_CampaignDimensionCombinationTitle';
        $translationKeys[] = 'MultiChannelConversionAttribution_CampaignDimensionCombinationTitleNew';
        $translationKeys[] = 'MultiChannelConversionAttribution_CampaignDimensionCombinationSettingHelp';
        $translationKeys[] = 'MultiChannelConversionAttribution_CampaignDimensionCombinationSettingHelpLine1';
        $translationKeys[] = 'MultiChannelConversionAttribution_CampaignDimensionCombinationSettingHelpLine2';
        $translationKeys[] = 'MultiChannelConversionAttribution_CampaignDimensionCombinationSettingHelpLine3';
        $translationKeys[] = 'MultiChannelConversionAttribution_CampaignDimensionCombinationSettingHelpLine2ReArchiveFaq';
        $translationKeys[] = 'MultiChannelConversionAttribution_CampaignCombinationEdit';
        $translationKeys[] = 'MultiChannelConversionAttribution_ExceptionMessagePeriodOrTopLevelEmpty';
        $translationKeys[] = 'MultiChannelConversionAttribution_ExceptionMessageSameTopAndSubLevel';
        $translationKeys[] = 'MultiChannelConversionAttribution_ExceptionMessageDuplicateCombination';
        $translationKeys[] = 'MultiChannelConversionAttribution_CampaignDimensionCombinationSettingTitle';
        $translationKeys[] = 'MultiChannelConversionAttribution_CampaignDimensionCombinationSettingTitleNew';
        $translationKeys[] = 'MultiChannelConversionAttribution_CampaignDimensionCombinationSettingDescription';
        $translationKeys[] = 'MultiChannelConversionAttribution_ExceptionMessageTopLevelEmpty';
        $translationKeys[] = 'MultiChannelConversionAttribution_NoGoalEnabledWithoutWriteAccess';
        $translationKeys[] = 'MultiChannelConversionAttribution_NoGoalEnabledWithWriteAccess';
    }

    public function onDeleteSite($idSite)
    {
        $dao = $this->getDao();
        $dao->removeSiteAttributions($idSite);
    }

    public function onDeleteGoal($value, $info)
    {
        if (empty($info['parameters'])) {
            return;
        }

        $finalParameters = $info['parameters'];

        $idSite = $finalParameters['idSite'];
        $idGoal = $finalParameters['idGoal'];

        $goal = Request::processRequest('Goals.getGoal', array('idSite' => $idSite, 'idGoal' => $idGoal), $default = []);

        if (empty($goal['idgoal'])) {
            // we only delete attribution if that goal was actually deleted
            // we check for idgoal because API might return true even though goal does not exist
            $dao = $this->getDao();
            $dao->removeGoalAttribution($idSite, $idGoal);
        }
    }
}
