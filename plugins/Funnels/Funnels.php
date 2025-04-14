<?php 
/**
 * Plugin Name: Funnels (Matomo Plugin)
 * Plugin URI: https://plugins.matomo.org/Funnels
 * Description: Identify and understand where your visitors drop off to increase your conversions, sales and revenue with your existing traffic.
 * Author: InnoCraft
 * Author URI: https://plugins.matomo.org/Funnels
 * Version: 5.3.8
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

namespace Piwik\Plugins\Funnels;

use Piwik\API\Request;
use Piwik\Category\Subcategory;
use Piwik\Columns\Dimension;
use Piwik\Common;
use Piwik\Container\StaticContainer;
use Piwik\Date;
use Piwik\Plugins\Funnels\Archiver\LogFunnelOptionLogic;
use Piwik\Plugins\Funnels\Dao\Funnel;
use Piwik\Plugins\Funnels\Dao\LogTable;
use Piwik\Piwik;
use Piwik\Plugin;
use Piwik\Plugins\Funnels\Model\FunnelsModel;
use Piwik\Plugins\Funnels\RecordBuilders\FunnelEntries;
use Piwik\Plugins\Funnels\RecordBuilders\FunnelExits;
use Piwik\Plugins\Funnels\RecordBuilders\FunnelFlow;
use Piwik\Segment\SegmentsList;
use Piwik\View;

 
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

class Funnels extends Plugin
{
    public const MENU_CATEGORY = 'Funnels_Funnels';

    // todo use constant from Common class in Matomo 4+.
    // we do not use it directly to support Pre Matomo 3.6 versions as well as newer ones.
    public const REFERRER_TYPE_SOCIAL_NETWORK = 7;

    public function install()
    {
        $dao = new Funnel();
        $dao->install();

        $dao = new LogTable();
        $dao->install();

        $configuration = new Configuration();
        $configuration->install();
    }

    public function uninstall()
    {
        $dao = new Funnel();
        $dao->uninstall();

        $dao = new LogTable();
        $dao->uninstall();

        $configuration = new Configuration();
        $configuration->uninstall();
    }

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
            'API.Goals.addGoal' => 'validateFunnelParams',
            'API.Goals.updateGoal' => 'validateFunnelParams',
            'API.Goals.addGoal.end' => 'setFunnelFromNew',
            'API.Goals.updateGoal.end' => 'setFunnelFromUpdate',
            'API.Goals.deleteGoal.end' => 'deleteFunnel',
            'SitesManager.deleteSite.end' => 'onDeleteSite',
            'Translate.getClientSideTranslationKeys' => 'getClientSideTranslationKeys',
            'Segment.addSegments' => 'addSegments',
            'Metrics.getDefaultMetricTranslations' => 'getDefaultMetricTranslations',
            'Metrics.getDefaultMetricDocumentationTranslations' => 'getDefaultMetricDocumentationTranslations',
            'Metrics.getDefaultMetricSemanticTypes' => 'getDefaultMetricSemanticTypes',
            'Category.addSubcategories' => 'addSubcategories',
            'Db.getTablesInstalled' => 'getTablesInstalled',
            'API.CoreAdminHome.invalidateArchivedReports' => 'checkApiRequestsToInvalidateFunnelData',
            'Console.doRun' => 'checkConsoleCommandsToInvalidateFunnelData',
            'Archiver.addRecordBuilders' => 'addRecordBuilders',
        );
    }

    public function addRecordBuilders(array &$recordBuilders): void
    {
        $idSite = \Piwik\Request::fromRequest()->getIntegerParameter('idSite', 0);
        if (!$idSite) {
            return;
        }

        /** @var FunnelsModel $funnelsModel */
        $funnelsModel = StaticContainer::get(FunnelsModel::class);
        $funnels = $funnelsModel->getAllActivatedFunnelsForSite($idSite);
        foreach ($funnels as $funnel) {
            $recordBuilders[] = StaticContainer::getContainer()->make(FunnelFlow::class, ['funnel' => $funnel]);
            $recordBuilders[] = StaticContainer::getContainer()->make(FunnelEntries::class, ['funnel' => $funnel]);
            $recordBuilders[] = StaticContainer::getContainer()->make(FunnelExits::class, ['funnel' => $funnel]);
        }
    }

    /**
     * Register the new tables, so Matomo knows about them.
     *
     * @param array $allTablesInstalled
     */
    public function getTablesInstalled(&$allTablesInstalled)
    {
        $allTablesInstalled[] = Common::prefixTable('funnel');
        $allTablesInstalled[] = Common::prefixTable('log_funnel');
        $allTablesInstalled[] = Common::prefixTable('funnel_steps');
    }

    public function addSubcategories(&$subcategories)
    {
        $idSite = Common::getRequestVar('idSite', 0, 'int');

        if (!$this->getValidator()->canViewReport($idSite)) {
            return;
        }

        $funnels = $this->getAllActivatedFunnelsForSite($idSite);
        $order = 5;

        // Sort the funnels by name
        $columnArray = array_column($funnels, 'name');
        array_multisort($columnArray, SORT_ASC, $funnels);

        foreach ($funnels as $funnel) {
            $order++;

            $category = new Subcategory();
            $category->setName($funnel['name']);
            $category->setCategoryId(self::MENU_CATEGORY);
            $category->setId($funnel['idfunnel']);
            $category->setOrder($order);
            $subcategories[] = $category;
        }
    }

    public function getDefaultMetricSemanticTypes(&$types)
    {
        $types[Metrics::NUM_STEP_VISITS] = Dimension::TYPE_NUMBER;
        $types[Metrics::NUM_STEP_ENTRIES] = Dimension::TYPE_NUMBER;
        $types[Metrics::NUM_STEP_EXITS] = Dimension::TYPE_NUMBER;
        $types[Metrics::NUM_STEP_PROCEEDS] = Dimension::TYPE_NUMBER;
        $types[Metrics::SUM_FUNNEL_ENTRIES] = Dimension::TYPE_NUMBER;
        $types[Metrics::SUM_FUNNEL_EXITS] = Dimension::TYPE_NUMBER;
        $types[Metrics::NUM_CONVERSIONS] = Dimension::TYPE_NUMBER;
        $types[Metrics::NUM_STEP_SKIPS] = Dimension::TYPE_NUMBER;
        $types[Metrics::NUM_STEP_PROGRESSIONS] = Dimension::TYPE_NUMBER;
    }

    public function getDefaultMetricTranslations(&$translations)
    {
        $translations[Metrics::NUM_STEP_VISITS] = Piwik::translate('Funnels_ColumnNbStepVisits');
        $translations[Metrics::NUM_STEP_ENTRIES] = Piwik::translate('Funnels_ColumnNbStepEntries');
        $translations[Metrics::NUM_STEP_EXITS] = Piwik::translate('Funnels_ColumnNbStepExits');
        $translations[Metrics::NUM_STEP_PROCEEDS] = Piwik::translate('Funnels_ColumnNbProceeds');
        $translations[Metrics::NUM_STEP_PROGRESSIONS] = Piwik::translate('Funnels_ColumnNbProgressions');
        $translations[Metrics::NUM_STEP_SKIPS] = Piwik::translate('Funnels_ColumnNbSkips');
        $translations[Metrics::RATE_ABANDONED] = Piwik::translate('Funnels_ColumnAbandonedRate');
        $translations[Metrics::SUM_FUNNEL_ENTRIES] = Piwik::translate('Funnels_ColumnSumEntries');
        $translations[Metrics::SUM_FUNNEL_EXITS] = Piwik::translate('Funnels_ColumnSumExits');
        $translations[Metrics::NUM_CONVERSIONS] = Piwik::translate('Funnels_ColumnNumFunnelConversions');
        $translations[Metrics::RATE_CONVERSION] = Piwik::translate('Funnels_ColumnRateFunnelConversion');
    }

    public function getDefaultMetricDocumentationTranslations(&$translations)
    {
        $translations[Metrics::NUM_STEP_VISITS] = Piwik::translate('Funnels_ColumnNbStepVisitsDocumentationUpdated');
        $translations[Metrics::NUM_STEP_ENTRIES] = Piwik::translate('Funnels_ColumnNbStepEntriesDocumentationUpdated');
        $translations[Metrics::NUM_STEP_EXITS] = Piwik::translate('Funnels_ColumnNbStepExitsDocumentationUpdated');
        $translations[Metrics::NUM_STEP_PROCEEDS] = Piwik::translate('Funnels_ColumnNbStepProceededDocumentation');
        $translations[Metrics::NUM_STEP_PROGRESSIONS] = Piwik::translate('Funnels_ColumnNbStepProgressionsDocumentation');
        $translations[Metrics::NUM_STEP_SKIPS] = Piwik::translate('Funnels_ColumnNbStepSkipsDocumentation');
        $translations[Metrics::SUM_FUNNEL_ENTRIES] = Piwik::translate('Funnels_ColumnSumEntriesDocumentation');
        $translations[Metrics::SUM_FUNNEL_EXITS] = Piwik::translate('Funnels_ColumnSumExitsDocumentation');
        $translations[Metrics::NUM_CONVERSIONS] = Piwik::translate('Funnels_ColumnNumFunnelConversionsDocumentation');
        $translations[Metrics::RATE_CONVERSION] = Piwik::translate('Funnels_ColumnRateFunnelConversionDocumentation');
        $translations[Metrics::RATE_ABANDONED] = Piwik::translate('Funnels_ColumnAbandonedRateDocumentation');
    }

    public function getClientSideTranslationKeys(&$translationKeys)
    {
        $translationKeys[] = 'General_Yes';
        $translationKeys[] = 'General_No';
        $translationKeys[] = 'General_Ok';
        $translationKeys[] = 'General_Name';
        $translationKeys[] = 'General_Help';
        $translationKeys[] = 'General_Remove';
        $translationKeys[] = 'General_Cancel';
        $translationKeys[] = 'Goals_Pattern';
        $translationKeys[] = 'Funnels_Unlock';
        $translationKeys[] = 'Funnels_RemoveStepTooltip';
        $translationKeys[] = 'Funnels_HelpStepTooltip';
        $translationKeys[] = 'Funnels_InfoCannotActivateFunnelIncomplete';
        $translationKeys[] = 'Funnels_InfoFunnelIsLocked';
        $translationKeys[] = 'Funnels_ConfirmUnlockFunnel';
        $translationKeys[] = 'Funnels_ConfirmDeactivateFunnel';
        $translationKeys[] = 'Funnels_AddStep';
        $translationKeys[] = 'Funnels_ValidateFunnelSteps';
        $translationKeys[] = 'Funnels_ValidateUrlMatchesDescription';
        $translationKeys[] = 'Funnels_EnterURLToValidate';
        $translationKeys[] = 'Funnels_Step';
        $translationKeys[] = 'Funnels_ActivateFunnel';
        $translationKeys[] = 'Funnels_ActivateFunnelDescription';
        $translationKeys[] = 'Funnels_ConfigureFunnelSteps';
        $translationKeys[] = 'Funnels_ConfigureFunnelStepsDescription1';
        $translationKeys[] = 'Funnels_ConfigureFunnelStepsDescription2';
        $translationKeys[] = 'Funnels_ConfigureFunnelStepsDescription3';
        $translationKeys[] = 'Funnels_WarningOnUpdateReportNeedsArchiving';
        $translationKeys[] = 'Funnels_WarningFunnelIsActivatedRequiredUnlock';
        $translationKeys[] = 'Funnels_RequiredColumnTitle';
        $translationKeys[] = 'Funnels_ComparisonColumnTitle';
        $translationKeys[] = 'Funnels_Introduction';
        $translationKeys[] = 'Funnels_IntroductionListItem1';
        $translationKeys[] = 'Funnels_IntroductionListItem2';
        $translationKeys[] = 'Funnels_IntroductionListItem3';
        $translationKeys[] = 'Funnels_IntroductionListItem4';
        $translationKeys[] = 'Funnels_IntroductionFollowSteps';
        $translationKeys[] = 'Funnels_ViewSalesFunnelReport';
        $translationKeys[] = 'Funnels_FunnelIsLockedCannotBeSaved';
        $translationKeys[] = 'Funnels_FunnelX';
        $translationKeys[] = 'General_Overview';
        $translationKeys[] = 'Funnels_FunnelMetricsSummary';
        $translationKeys[] = 'Funnels_GoalMetricSummary1';
        $translationKeys[] = 'Funnels_GoalMetricSummary2';
        $translationKeys[] = 'Live_RowActionTooltipWithDimension';
        $translationKeys[] = 'Funnels_Funnel';
        $translationKeys[] = 'Funnels_Entries';
        $translationKeys[] = 'General_ColumnNbVisits';
        $translationKeys[] = 'Funnels_Exits';
        $translationKeys[] = 'Funnels_ColumnProceededRate';
        $translationKeys[] = 'Funnels_Completed';
        $translationKeys[] = 'Funnels_ConvertsGoal';
        $translationKeys[] = 'Funnels_GoalFunnelReportHelp';
        $translationKeys[] = 'Funnels_GoalFunnelReport';
        $translationKeys[] = 'Funnels_HitsWereBackfilled';
        $translationKeys[] = 'Funnels_HitsWereNotBackfilled';
        $translationKeys[] = 'Funnels_NbConversion';
        $translationKeys[] = 'General_OneVisit';
        $translationKeys[] = 'Goals_Conversions';
        $translationKeys[] = 'General_NVisits';
        $translationKeys[] = 'Funnels_SegmentVisitorsByThisFunnelStep';
        $translationKeys[] = 'General_RowEvolutionRowActionTooltipTitle';
        $translationKeys[] = 'Funnels_NbEntry';
        $translationKeys[] = 'Funnels_NbEntries';
        $translationKeys[] = 'Funnels_XVisitorsConvertedFunnel';
        $translationKeys[] = 'Goals_ConversionRate';
        $translationKeys[] = 'Funnels_XoutOfYVisitsconverted';
        $translationKeys[] = 'Funnels_NbProceeded';
        $translationKeys[] = 'Funnels_NbExit';
        $translationKeys[] = 'Funnels_NbExits';
        $translationKeys[] = 'CoreHome_ThereIsNoDataForThisReport';
        $translationKeys[] = 'CoreHome_DataForThisReportHasBeenPurged';
        $translationKeys[] = 'Funnels_FunnelReportNotGeneratedYet';
        $translationKeys[] = 'Funnels_EnableFunnel';
        $translationKeys[] = 'Funnels_EnableFunnelHelpText';
        $translationKeys[] = 'Funnels_Steps';
        $translationKeys[] = 'Funnels_TestUrlHelpText';
        $translationKeys[] = 'Funnels_HelpRequiredStepsDescription';
        $translationKeys[] = 'Funnels_PatternHelpText';
        $translationKeys[] = 'Funnels_ValidateStepsOptional';
        $translationKeys[] = 'Funnels_StepName';
        $translationKeys[] = 'Funnels_ManageFunnels';
        $translationKeys[] = 'Funnels_FunnelName';
        $translationKeys[] = 'Funnels_FunnelNameHelp';
        $translationKeys[] = 'Funnels_AddNewFunnel';
        $translationKeys[] = 'Goals_GoalConversion';
        $translationKeys[] = 'Funnels_AddFunnel';
        $translationKeys[] = 'Funnels_AddNewFunnel';
        $translationKeys[] = 'Funnels_UpdateFunnel';
        $translationKeys[] = 'Funnels_DeleteFunnelConfirm';
        $translationKeys[] = 'Funnels_AddNewUserUnableToEdit';
        $translationKeys[] = 'Funnels_ThereIsNoFunnelToManage';
        $translationKeys[] = 'Funnels_TestUrlHelpTextGoalComparison';
        $translationKeys[] = 'Funnels_RequiredStepsHelpTextNew';
        $translationKeys[] = 'Funnels_RequiredStepsHelpTextNote';
        $translationKeys[] = 'General_ColumnNbVisits';
        $translationKeys[] = 'Funnels_DropOff';
        $translationKeys[] = 'Funnels_FunnelConversion';
        $translationKeys[] = 'Funnels_FunnelReport';
        $translationKeys[] = 'Funnels_FunnelReportHelp';
        $translationKeys[] = 'Funnels_FunnelReportHelpClosedFunnel';
        $translationKeys[] = 'Funnels_FunnelReportHelpOpenFunnel';
        $translationKeys[] = 'Funnels_DefaultAllVisits';
        $translationKeys[] = 'Funnels_EditSalesFunnel';
        $translationKeys[] = 'Ecommerce_Sales';
        $translationKeys[] = 'Funnels_GoalCheckHover';
        $translationKeys[] = 'Funnels_Skips';
        $translationKeys[] = 'Funnels_ShowFunnelVisitsLog';
        $translationKeys[] = 'Funnels_ShowGoalReport';
        $translationKeys[] = 'Funnels_EditFunnel';
        $translationKeys[] = 'Funnels_Condition';
        $translationKeys[] = 'Funnels_EntriesAndExitsActionTooltipTitle';
        $translationKeys[] = 'Funnels_EntriesAndExitsActionTooltip';
        $translationKeys[] = 'Funnels_EntriesAndExits';
        $translationKeys[] = 'Funnels_Proceeds';
        $translationKeys[] = 'Funnels_Progressions';
    }

    public function onDeleteSite($idSite)
    {
        $funnel = new Funnel();
        $now = Date::now()->getDatetime();
        $funnel->disableFunnelsForSite($idSite, $now);
    }

    public function deleteFunnel($returnedValue, $info)
    {
        if (empty($info['parameters'])) {
            return;
        }

        $finalParameters = $info['parameters'];

        $idSite = $finalParameters['idSite'];
        $idGoal = $finalParameters['idGoal'];

        $goal = Request::processRequest('Goals.getGoal', array('idSite' => $idSite, 'idGoal' => $idGoal), $default = []);

        if (empty($goal['idgoal'])) {
            // we only delete funnel if that goal was actually deleted
            // we check for idgoal because API might return true even though goal does not exist
            Request::processRequest('Funnels.deleteGoalFunnel', array('idSite' => $idSite, 'idGoal' => $idGoal), $default = []);
        }
    }

    public function validateFunnelParams($finalParameters)
    {
        // important! We validate before the goal is created or updated. Otherwise we would only save partial data
        // eg it would be otherwise possible that a goal is first updated, then an error occurs when validating steps
        // meaning the user would end up having some data saved and some data not. Instead we validate the sent data
        // first before the actual goal api gets the request and throw exceptions as early as possible
        if (isset($_POST['funnelActivated']) && isset($_POST['funnelSteps']) && !empty($finalParameters)) {
            // we only validate when a value was actually sent.
            $isActivated = Common::getRequestVar('funnelActivated', 0, 'int');
            $steps = Common::getRequestVar('funnelSteps', array(), 'array');
            $idSite = $finalParameters['idSite'];

            $validator = $this->getValidator();
            $validator->checkWritePermission($idSite);
            $validator->validateFunnelConfiguration($isActivated, $steps);
        }
    }

    private function getValidator()
    {
        return StaticContainer::get('Piwik\Plugins\Funnels\Input\Validator');
    }

    public function setFunnelFromNew($returnedValue, $info)
    {
        if ($returnedValue) {
            $idGoal = $returnedValue;
            $finalParameters = $info['parameters'];
            $idSite = $finalParameters['idSite'];

            $this->setFunnel($idSite, $idGoal);
        }
    }

    public function setFunnelFromUpdate($returnedValue, $info)
    {
        if (empty($info['parameters'])) {
            return;
        }

        $finalParameters = $info['parameters'];
        $idSite = $finalParameters['idSite'];
        $idGoal = $finalParameters['idGoal'];

        $this->setFunnel($idSite, $idGoal);
    }

    private function setFunnel($idSite, $idGoal)
    {
        if (!isset($_POST['funnelActivated']) || !isset($_POST['funnelSteps'])) {
            // no value was set, we should not set funnel as it would generate a new funnel ID causing all existing
            // reports to be gone. We are allowed to only set a funnel, when the UI sent funnel data along the
            // goals request
            return;
        }

        $isActivated = Common::getRequestVar('funnelActivated', 0, 'int');
        $steps = Common::getRequestVar('funnelSteps', array(), 'array');

        $this->getFunnelsModel()->clearGoalsCache($idSite);

        Request::processRequest('Funnels.setGoalFunnel', array(
            'idSite' => $idSite,
            'idGoal' => $idGoal,
            'isActivated' => $isActivated,
            'steps' => $steps
        ), $default = []);
    }

    private function getFunnelsModel()
    {
        return StaticContainer::get('Piwik\Plugins\Funnels\Model\FunnelsModel');
    }

    public function getJsFiles(&$jsFiles)
    {
        $jsFiles[] = "plugins/Funnels/javascripts/funnelDataTable.js";
        $jsFiles[] = "plugins/Funnels/javascripts/funnelStepDataTable.js";
        $jsFiles[] = "plugins/Funnels/javascripts/funnelEntryExitDataTable.js";
    }

    public function getStylesheetFiles(&$stylesheets)
    {
        $stylesheets[] = "plugins/Funnels/vue/src/ManageFunnel/ManageFunnel.less";
        $stylesheets[] = "plugins/Funnels/vue/src/ManageSiteFunnels/ManageSiteFunnels.less";
        $stylesheets[] = "plugins/Funnels/stylesheets/report.less";
        $stylesheets[] = "plugins/Funnels/stylesheets/manage.less";
        $stylesheets[] = "plugins/Funnels/vue/src/Report/FunnelConversionReport.less";
        $stylesheets[] = "plugins/Funnels/vue/src/Tooltip/Tooltip.less";
    }

    public function printGoalListHead(&$out)
    {
        $out .= '<th>' . Piwik::translate('Funnels_Funnel') . '</th>';
    }

    public function printGoalListBody(&$out, $goal)
    {
        $funnel = $this->getFunnel($goal['idsite'], $goal['idgoal']);

        $out .= '<td>';

        if (!empty($funnel['activated'])) {
            $message = Piwik::translate('Funnels_ActivatedFunnelExists');
            $out .= '<span title="' . $message . '" class="icon-ok funnelActivated"></span>';
        } elseif (!empty($funnel['steps'])) {
            $message = Piwik::translate('Funnels_FunnelConfiguredButNotActivated');
            $out .= '<span title="' . $message . '" class="icon-ok funnelExists"></span>';
        } else {
            $out .= '-';
        }

        $out .= '</td>';
    }

    public function printGoalEdit(&$out)
    {
        $idSite = Common::getRequestVar('idSite', 0, 'int');

        if (empty($idSite) || !$this->getValidator()->canWrite($idSite)) {
            return;
        }

        // Get the list of goals so that they can be used by the dropdown
        $goals = Request::processRequest('Goals.getGoals', [
            'idSite' => $idSite, 'filter_limit' => -1
        ], []);
        $formattedGoals = [];
        foreach ($goals as $goal) {
            // string is important to preselect correct value
            $formattedGoals[] = ['key' => (string) $goal['idgoal'], 'value' => $goal['name']];
        }

        // Prep the view of the funnels edit form specifc to a goal funnel
        $view = new View('@Funnels/editGoalFunnel');
        $view->idSite = $idSite;
        $view->goals = $formattedGoals;

        // Render the view and append it to the goals edit form
        $out .=  $view->render();
    }

    public function addSegments(SegmentsList $list)
    {
        $segment = new Segment();
        $segment->setSegment(Segment::NAME_FUNNEL_SEGMENT);
        $segment->setType(Segment::TYPE_DIMENSION);
        $segment->setName('Funnels_SegmentNameFunnelName');
        $segment->setSqlSegment('log_funnel.idfunnel');
        $segment->setAcceptedValues(Piwik::translate('Funnels_SegmentNameFunnelNameDescription'));
        $segment->setSqlFilter('\\Piwik\\Plugins\\Funnels\\Segment::getIdByName');
        $segment->setSuggestedValuesCallback(function ($idSite, $maxValuesToReturn) {
            $funnels = $this->getAllActivatedFunnelsForSite($idSite);
            $names = array();

            foreach ($funnels as $funnel) {
                $names[] = $funnel['name'];
            }

            $names = array_unique($names);

            return array_slice($names, 0, $maxValuesToReturn);
        });

        $list->addSegment($segment);

        $segment = new Segment();
        $segment->setSegment(Segment::NAME_FUNNEL_STEP_POSITION);
        $segment->setType(Segment::TYPE_METRIC);
        $segment->setName('Funnels_SegmentNameStepPosition');
        $segment->setSqlSegment('log_funnel.step_position');
        $segment->setAcceptedValues(Piwik::translate('Funnels_SegmentNameStepPositionDescription'));
        $segment->setSuggestedValuesCallback(function ($idSite, $maxValuesToReturn) {
            $steps = range(1, 10);

            return array_slice($steps, 0, $maxValuesToReturn);
        });

        $list->addSegment($segment);
    }

    private function getFunnel($idSite, $idGoal)
    {
        // when showing goal reporting page or manage goals page we need to know whether a funnel exists for view users
        return Request::processRequest('Funnels.getGoalFunnel', ['idSite' => $idSite, 'idGoal' => $idGoal], $default = []);
    }

    private function getAllActivatedFunnelsForSite($idSite)
    {
        return Request::processRequest('Funnels.getAllActivatedFunnelsForSite', ['idSite' => $idSite, 'filter_limit' => -1], $default = []);
    }

    /**
     * Tied to the API event for when archives are invalidated. This allows us to delete options used by the funnel
     * archiving process to determine if the log_funnel table records need to be rebuilt.
     *
     * @param $eventData
     * @return void
     */
    public function checkApiRequestsToInvalidateFunnelData(&$eventData)
    {
        StaticContainer::get(LogFunnelOptionLogic::class)->invalidateFunnelOptionsIfNecessary($eventData);
    }

    /**
     * Should be executed when the Console.doRun event is triggered and checks if it's invalidating reports. If it is,
     * we might need to delete certain option records so that the log_funnel records get rebuilt.
     *
     * @param null|int $exitCode
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Input\OutputInterface $output
     * @return void
     * @throws \Exception
     */
    public function checkConsoleCommandsToInvalidateFunnelData(&$exitCode, $input, $output)
    {
        // Make sure it's for invalidation, since we don't care about anything else.
        if (!$input->hasParameterOption('core:invalidate-report-data')) {
            return;
        }

        // Return if no dates were provided, since that's required.
        if (!$input->hasParameterOption('--dates')) {
            return;
        }

        // Stop if it's a dry run, since nothing actually got invalidated.
        if ($input->hasParameterOption('--dry-run')) {
            return;
        }

        // Set the parameter values using the parameter options or default values.
        $parameters = [
            'dates' => $input->getParameterOption('--dates'),
            'idSites' => $input->getParameterOption('--sites', 'all'),
            'period' => $input->getParameterOption('--periods', 'all'),
            'plugin' => $input->getParameterOption('--plugin', false),
        ];

        StaticContainer::get(LogFunnelOptionLogic::class)->invalidateFunnelOptionsIfNecessary($parameters);
    }
}
