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

namespace Piwik\Plugins\AbTesting;

use Piwik\API\Request;
use Piwik\Category\Subcategory;
use Piwik\Common;
use Piwik\Container\StaticContainer;
use Piwik\Exception\DI\DependencyException;
use Piwik\Exception\DI\NotFoundException;
use Piwik\Log\LoggerInterface;
use Piwik\Piwik;
use Piwik\Plugins\AbTesting\Dao\Experiment;
use Piwik\Plugins\AbTesting\Dao\LogTable;
use Piwik\Plugins\AbTesting\Dao\Strategy;
use Piwik\Plugin;
use Exception;
use Piwik\Plugins\AbTesting\Model\Experiments;
use Piwik\Plugins\MarketingCampaignsReporting\MarketingCampaignsReporting;
use Piwik\Segment\SegmentsList;
use Piwik\Widget\WidgetConfig;
use Piwik\Plugins\CoreHome\SystemSummary;

class AbTesting extends Plugin
{
    public const TRACKER_READY_HOOK_NAME = '/*!! abTestingTrackerReadyHook */';
    public const TRACKER_READY_HOOK_NAME_WHEN_MINIFIED = '/*!!! abTestingTrackerReadyHook */';

    public function registerEvents()
    {
        return array(
            'AssetManager.getStylesheetFiles' => 'getStylesheetFiles',
            'AssetManager.getJavaScriptFiles' => 'getJsFiles',
            'Translate.getClientSideTranslationKeys' => 'getClientSideTranslationKeys',
            'Tracker.Cache.getSiteAttributes'  => 'addSiteExperiments',
            'Segment.addSegments' => 'addSegments',
            'SitesManager.deleteSite.end' => 'onDeleteSite',
            'Template.jsGlobalVariables' => 'addJsGlobalVariables',
            'Tracker.getJavascriptCode' => 'makePiwikJsLoadSync',
            'Category.addSubcategories' => 'addSubcategories',
            'Widget.addWidgetConfigs' => 'addWidgetConfigs',
            'System.addSystemSummaryItems' => 'addSystemSummaryItems',
            'Tracker.PageUrl.getQueryParametersToExclude' => 'getQueryParametersToExclude',
            'API.getPagesComparisonsDisabledFor'     => 'getPagesComparisonsDisabledFor',
            'Db.getTablesInstalled' => 'getTablesInstalled',
            'Metrics.getDefaultMetricSemanticTypes' => 'addDefaultMetricSemanticTypes',
            'Archiver.addRecordBuilders' => 'addRecordBuilders',
            'CustomJsTracker.manipulateJsTracker' => 'manipulateJsTracker',
        );
    }

    public function manipulateJsTracker(&$content)
    {
        $replace = '';
        $params = Common::getCampaignParameters();
        if (Plugin\Manager::getInstance()->isPluginActivated('MarketingCampaignsReporting')) {
            try {
                $params = MarketingCampaignsReporting::getCampaignParameters();
            } catch (DependencyException | NotFoundException $e) {
                // Don't do anything, generally when the plugin is activated configs are not loaded, and causes missing DependencyException
                StaticContainer::get(LoggerInterface::class)->info('There was an issue while trying to get the list of campaign parameters for the MarketingCampaignsReporting plugin. Error: ' . $e->getMessage());
            }
        }
        if (is_array($params) && count($params) > 0) {
            // Flatten the nested arrays
            $params = array_merge(...array_values($params));

            $replace = 'window.matomoAbTestingCampaignUrlParamList = ' . json_encode($params) . ';';
        }

        $content = str_replace([self::TRACKER_READY_HOOK_NAME_WHEN_MINIFIED, self::TRACKER_READY_HOOK_NAME], $replace, $content);
    }

    public function addDefaultMetricSemanticTypes(array &$types): void
    {
        $metrics = StaticContainer::get(Metrics::class);
        $types = array_merge($types, $metrics->getMetricSemanticTypes());
    }

    public function addRecordBuilders(&$recordBuilders)
    {
        $idSite = \Piwik\Request::fromRequest()->getIntegerParameter('idSite', 0);
        if (!$idSite) {
            return;
        }

        $experimentsService = StaticContainer::get(Experiments::class);
        $experiments = $experimentsService->getExperimentsWithReports($idSite);

        foreach ($experiments as $experiment) {
            $recordBuilders[] = StaticContainer::getContainer()->make(\Piwik\Plugins\AbTesting\RecordBuilders\BucketUniqueVisitors::class, [
                'experiment' => $experiment,
            ]);
            $recordBuilders[] = StaticContainer::getContainer()->make(\Piwik\Plugins\AbTesting\RecordBuilders\Experiment::class, [
                'experiment' => $experiment,
            ]);
        }
    }

    /**
     * Register the new tables, so Matomo knows about them.
     *
     * @param array $allTablesInstalled
     */
    public function getTablesInstalled(&$allTablesInstalled)
    {
        $allTablesInstalled[] = Common::prefixTable('experiments');
        $allTablesInstalled[] = Common::prefixTable('log_abtesting');
        $allTablesInstalled[] = Common::prefixTable('experiments_strategy');
        $allTablesInstalled[] = Common::prefixTable('experiments_variations');
    }

    public function getPagesComparisonsDisabledFor(&$pages)
    {
        $pages[] = 'AbTesting_Experiments.General_Overview';
        $pages[] = 'AbTesting_Experiments.AbTesting_ManageExperiments';
    }

    public function getQueryParametersToExclude(&$parametersToExclude)
    {
        $parametersToExclude[] = 'pk_abe';
        $parametersToExclude[] = 'pk_abv';
    }

    public function addSystemSummaryItems(&$systemSummary)
    {
        $dao = $this->getExperimentsDao();
        $numExperiments = $dao->getNumExperimentsTotal();

        $systemSummary[] = new SystemSummary\Item($key = 'experiments', Piwik::translate('AbTesting_NExperiments', $numExperiments), $value = null, array('module' => 'AbTesting', 'action' => 'manage'), $icon = 'abtestingicon-lab', $order = 9);
    }

    public function addSubcategories(&$subcategories)
    {
        $idSite = Common::getRequestVar('idSite', 0, 'int');

        if (!$idSite) {
            // fallback for eg API.getReportMetadata which uses idSites
            $idSite = Common::getRequestVar('idSites', 0, 'int');

            if (!$idSite) {
                return;
            }
        }

        if (!Piwik::isUserHasViewAccess($idSite)) {
            return;
        }

        $experiments = $this->getExperimentsWithReports($idSite);

        $order = 20;
        foreach ($experiments as $experiment) {
            $category = new Subcategory();
            $category->setName($experiment['name']);
            $category->setCategoryId('AbTesting_Experiments');
            $category->setId($experiment['idexperiment']);
            $category->setOrder($order++);
            $subcategories[] = $category;
        }
    }

    public function addWidgetConfigs(&$subcategories)
    {
        $idSite = Common::getRequestVar('idSite', 0, 'int');

        if (!$idSite) {
            // fallback for eg API.getReportMetadata which uses idSites
            $idSite = Common::getRequestVar('idSites', 0, 'int');

            if (!$idSite) {
                return;
            }
        }

        if (!Piwik::isUserHasViewAccess($idSite)) {
            return;
        }

        $experiments = $this->getExperimentsWithReports($idSite);

        foreach ($experiments as $experiment) {
            $title = Piwik::translate('AbTesting_MenuTitleExperiment', $experiment['name']);
            $config = new WidgetConfig();
            $config->setName($title);
            $config->setModule('AbTesting');
            $config->setAction('summary');
            $config->setCategoryId('AbTesting_Experiments');
            $config->setSubcategoryId($experiment['idexperiment']);
            $config->setParameters(array('idExperiment' => $experiment['idexperiment']));
            $config->setIsNotWidgetizable();
            $config->setOrder(1);
            $subcategories[] = $config;
        }
    }

    public function makePiwikJsLoadSync(&$codeImpl, $parameters)
    {
        $idSite = Common::getRequestVar('idSite', 0, 'int', $codeImpl);

        if (!empty($idSite)) {
            $experimentsModel = $this->getExperimentsModel();
            if ($experimentsModel->hasSiteExperiments($idSite)) {
                // it is needed to load the piwik js tracker synchronous when using a/b tests
                $codeImpl['loadAsync'] = false;
            }
        }
    }

    public function addJsGlobalVariables()
    {
        echo 'var piwikExposeAbTestingTarget = true;';
    }

    public function install()
    {
        $dao = new Experiment();
        $dao->install();

        $dao = new Strategy();
        $dao->install();

        $dao = new LogTable();
        $dao->install();

        $configuration = StaticContainer::get(Configuration::class);
        $configuration->install();
    }

    public function uninstall()
    {
        $dao = new Experiment();
        $dao->uninstall();

        $dao = new Strategy();
        $dao->uninstall();

        $dao = new LogTable();
        $dao->uninstall();

        $configuration = StaticContainer::get(Configuration::class);
        $configuration->uninstall();
    }

    public function isTrackerPlugin()
    {
        return true;
    }

    public function onDeleteSite($idSite)
    {
        $experimentsModel = $this->getExperimentsModel();
        $experimentsModel->deleteExperimentsForSite($idSite);
    }

    public function getClientSideTranslationKeys(&$result)
    {
        $result[] = 'General_Save';
        $result[] = 'General_Done';
        $result[] = 'General_Actions';
        $result[] = 'General_Yes';
        $result[] = 'General_No';
        $result[] = 'General_Add';
        $result[] = 'General_Remove';
        $result[] = 'General_Search';
        $result[] = 'CoreUpdater_UpdateTitle';
        $result[] = 'AbTesting_Rule';
        $result[] = 'AbTesting_Filter';
        $result[] = 'AbTesting_EditExperiment';
        $result[] = 'AbTesting_NameOriginalVariation';
        $result[] = 'AbTesting_CreateNewExperimentNow';
        $result[] = 'AbTesting_Status';
        $result[] = 'AbTesting_StartDate';
        $result[] = 'AbTesting_FinishDate';
        $result[] = 'AbTesting_NoActiveExperimentConfigured';
        $result[] = 'AbTesting_CreateNewExperiment';
        $result[] = 'AbTesting_ManageExperiments';
        $result[] = 'AbTesting_ExperimentCreated';
        $result[] = 'AbTesting_ExperimentUpdated';
        $result[] = 'AbTesting_ExperimentStarted';
        $result[] = 'AbTesting_ExperimentFinished';
        $result[] = 'AbTesting_SuccessMetrics';
        $result[] = 'AbTesting_SuccessConditions';
        $result[] = 'AbTesting_NameAllowedCharacters';
        $result[] = 'AbTesting_ErrorXNotProvided';
        $result[] = 'AbTesting_ExperimentName';
        $result[] = 'AbTesting_Hypothesis';
        $result[] = 'AbTesting_Variation';
        $result[] = 'AbTesting_Variations';
        $result[] = 'AbTesting_FilesystemDirectory';
        $result[] = 'AbTesting_FieldSuccessMetricsLabel';
        $result[] = 'AbTesting_StatusActive';
        $result[] = 'AbTesting_ExperimentIsFinishedPleaseRemoveCode';
        $result[] = 'AbTesting_FieldSuccessMetricsHelp1';
        $result[] = 'AbTesting_FieldSuccessMetricsHelp2';
        $result[] = 'AbTesting_FieldSuccessMetricsHelp3';
        $result[] = 'AbTesting_FieldIncludedTargetsLabel';
        $result[] = 'AbTesting_FieldIncludedTargetsHelp2';
        $result[] = 'AbTesting_FieldExcludedTargetsLabel';
        $result[] = 'AbTesting_FieldExcludedTargetsHelp';
        $result[] = 'AbTesting_FieldRedirectHelp1';
        $result[] = 'AbTesting_FieldRedirectHelp2';
        $result[] = 'AbTesting_FieldRedirectHelp3';
        $result[] = 'AbTesting_ClickToCreateNewGoal';
        $result[] = 'AbTesting_TargetComparisons';
        $result[] = 'AbTesting_ErrorExperimentCannotBeUpdatedBecauseArchived';
        $result[] = 'AbTesting_FieldScheduleExperimentStartHelp';
        $result[] = 'AbTesting_FieldScheduleExperimentFinishHelp';
        $result[] = 'AbTesting_TargetComparisionsCaseInsensitive';
        $result[] = 'AbTesting_FormScheduleIntroduction';
        $result[] = 'AbTesting_FieldScheduleExperimentStartLabel';
        $result[] = 'AbTesting_FieldScheduleExperimentFinishLabel';
        $result[] = 'AbTesting_FieldPercentageParticipantsLabel';
        $result[] = 'AbTesting_FieldPercentageParticipantsHelp';
        $result[] = 'AbTesting_FieldPercentageVariationsLabel';
        $result[] = 'AbTesting_FieldPercentageVariationsHelp';
        $result[] = 'AbTesting_FieldVariationsHelp';
        $result[] = 'AbTesting_ErrorVariationAllocatedNot100Traffic';
        $result[] = 'AbTesting_ErrorVariationAllocatedNotEnoughOriginal';
        $result[] = 'AbTesting_EqualsDateInYourTimezone';
        $result[] = 'AbTesting_CurrentTimeInUTC';
        $result[] = 'AbTesting_NoExperimentsFound';
        $result[] = 'AbTesting_DeleteExperimentInfo';
        $result[] = 'AbTesting_ViewReportInfo';
        $result[] = 'AbTesting_ArchiveReportInfo';
        $result[] = 'AbTesting_ArchiveReportConfirm';
        $result[] = 'AbTesting_DeleteExperimentConfirm';
        $result[] = 'AbTesting_UrlParameterValueToMatchPlaceholder';
        $result[] = 'AbTesting_TargetPageTestTitle';
        $result[] = 'AbTesting_TargetPageTestLabel';
        $result[] = 'AbTesting_TargetPageTestErrorInvalidUrl';
        $result[] = 'AbTesting_TargetPageTestUrlMatches';
        $result[] = 'AbTesting_TargetPageTestUrlNotMatches';
        $result[] = 'AbTesting_ExperimentCreatedInfo1';
        $result[] = 'AbTesting_ExperimentCreatedInfo2';
        $result[] = 'AbTesting_ExperimentCreatedInfo3';
        $result[] = 'AbTesting_ExperimentRunningInfo1';
        $result[] = 'AbTesting_ExperimentRunningInfo2';
        $result[] = 'AbTesting_ExperimentRunningInfo3';
        $result[] = 'AbTesting_ManageExperimentsIntroduction';
        $result[] = 'AbTesting_ExperimentFinishedInfo1';
        $result[] = 'AbTesting_ExperimentFinishedInfo2';
        $result[] = 'AbTesting_RelatedActions';
        $result[] = 'AbTesting_ExperimentWillStartFromFirstTrackingRequest';
        $result[] = 'AbTesting_RunExperimentWithJsClient';
        $result[] = 'AbTesting_RunExperimentWithJsTracker';
        $result[] = 'AbTesting_RunExperimentWithOtherSDK';
        $result[] = 'AbTesting_RunExperimentWithEmailCampaign';
        $result[] = 'AbTesting_ConfidenceThreshold';
        $result[] = 'AbTesting_MinimumDetectableEffectMDE';
        $result[] = 'AbTesting_NeedHelp';
        $result[] = 'General_OrCancel';
        $result[] = 'AbTesting_TargetTypeEqualsSimple';
        $result[] = 'AbTesting_TargetTypeEqualsSimpleInfo';
        $result[] = 'AbTesting_TargetTypeEqualsExactly';
        $result[] = 'AbTesting_TargetTypeEqualsExactlyInfo';
        $result[] = 'AbTesting_TargetTypeRegExp';
        $result[] = 'AbTesting_TargetTypeRegExpInfo';
        $result[] = 'AbTesting_FieldExperimentNameHelp';
        $result[] = 'AbTesting_FieldHypothesisHelp';
        $result[] = 'AbTesting_FieldHypothesisPlaceholder';
        $result[] = 'AbTesting_FieldDescriptionHelp';
        $result[] = 'AbTesting_FieldDescriptionPlaceholder';
        $result[] = 'AbTesting_ActivateExperimentOnAllPages';
        $result[] = 'AbTesting_ActiveExperimentOnSomePages';
        $result[] = 'AbTesting_NavigationBack';
        $result[] = 'AbTesting_Schedule';
        $result[] = 'AbTesting_EmbedCode';
        $result[] = 'AbTesting_Definition';
        $result[] = 'AbTesting_UpdatingData';
        $result[] = 'AbTesting_FormCreateExperimentIntro';
        $result[] = 'AbTesting_FieldConfidenceThresholdHelp';
        $result[] = 'AbTesting_FieldMinimumDetectableEffectHelp1';
        $result[] = 'AbTesting_FieldMinimumDetectableEffectHelp2';
        $result[] = 'AbTesting_FieldSuccessConditionsHelp';
        $result[] = 'AbTesting_NewExperimentTargetPageHelp';
        $result[] = 'AbTesting_TargetPages';
        $result[] = 'AbTesting_TrafficAllocation';
        $result[] = 'AbTesting_ActionViewReport';
        $result[] = 'AbTesting_ActionFinishExperiment';
        $result[] = 'AbTesting_ActionEditExperimentAnyway';
        $result[] = 'AbTesting_ConfirmUpdateStartsExperiment';
        $result[] = 'AbTesting_ConfirmFinishExperiment';
        $result[] = 'AbTesting_ExperimentRequiresUpdateBeforeViewEmbedCode';
        $result[] = 'AbTesting_ActionArchiveExperiment';
        $result[] = 'AbTesting_ActionArchiveExperimentSuccess';
        $result[] = 'AbTesting_ErrorCreateNoUrlDefined';
        $result[] = 'AbTesting_TargetTypeIsAny';
        $result[] = 'AbTesting_TargetTypeIsNot';
        $result[] = 'AbTesting_EditThisExperiment';
        $result[] = 'AbTesting_Redirects';
        $result[] = 'General_Description';
        $result[] = 'General_Ok';
        $result[] = 'Goals_GoalX';
        $result[] = 'AbTesting_ExpectedImprovement';
        $result[] = 'AbTesting_ReportStatusRunning';
        $result[] = 'AbTesting_ReportWhenToDeclareWinner';
        $result[] = 'AbTesting_ReportStatusFinished';
        $result[] = 'AbTesting_MenuTitleExperiment';
        $result[] = 'AbTesting_ReportDateCannotBeChanged';
        $result[] = 'AbTesting_WhereToInsertCodeWarning';
        $result[] = 'AbTesting_CustomJsNotAllowedWarning';
        $result[] = 'AbTesting_IncludeAbTestingTrackerCode';
        $result[] = 'AbTesting_RunExperimentsInJsTracker';
        $result[] = 'AbTesting_UpdateExperimentWarning';
        $result[] = 'AbTesting_TestVariationViaUrl';
        $result[] = 'AbTesting_RunningTestOnServer';
        $result[] = 'AbTesting_HowToRunTestOnServer';
        $result[] = 'AbTesting_AppTrackingDescription';
        $result[] = 'AbTesting_HeadingAppTrackingExample';
        $result[] = 'AbTesting_HeadingPhpTracker';
        $result[] = 'AbTesting_AppTrackingAlertText';
        $result[] = 'AbTesting_RunningInCampaignDescription';
        $result[] = 'AbTesting_NeedHelpDevZone';
        $result[] = 'AbTesting_NeedHelpGetInTouch';
        $result[] = 'AbTesting_CodeCommentUseOriginal';
        $result[] = 'AbTesting_CodeCommentUseExperimentId';
        $result[] = 'AbTesting_CodeCommentUseExperimentIdUrl';
        $result[] = 'AbTesting_ForwardUtmParams';
        $result[] = 'AbTesting_ForwardUtmParamsHelpText';
        $result[] = 'AbTesting_ForwardUtmParamsHelpTextNote';
        $result[] = 'AbTesting_ReportingEfficiency';
        $result[] = 'AbTesting_ReportingEfficiencyDescription';
    }

    public function getStylesheetFiles(&$stylesheets)
    {
        $stylesheets[] = "plugins/AbTesting/libs/jquery-timepicker/jquery.timepicker.css";
        $stylesheets[] = "plugins/AbTesting/vue/src/TargetTest/TargetTest.less";
        $stylesheets[] = "plugins/AbTesting/vue/src/ExperimentUrlTarget/ExperimentUrlTarget.less";
        $stylesheets[] = "plugins/AbTesting/vue/src/Experiments/Edit.less";
        $stylesheets[] = "plugins/AbTesting/vue/src/Experiments/List.less";
        $stylesheets[] = "plugins/AbTesting/libs/abtestingicons/style.css";
        $stylesheets[] = "plugins/AbTesting/stylesheets/report.less";
    }

    public function getJsFiles(&$jsFiles)
    {
        $jsFiles[] = "plugins/AbTesting/libs/jquery-timepicker/jquery.timepicker.min.js";
        $jsFiles[] = "plugins/AbTesting/tracker.min.js";

        $jsFiles[] = "plugins/AbTesting/javascripts/abtestDataTable.js";
    }

    public function addSiteExperiments(&$content, $idSite)
    {
        // we cache running and created experiments as a created one can become running while being cached
        $experimentsModel = $this->getExperimentsModel();
        $content['experiments'] = $experimentsModel->getActiveExperiments($idSite);
    }

    public function addSegments(SegmentsList $list)
    {
        $segment = new Segment();
        $segment->setSegment(Segment::NAME_EXPERIMENT_SEGMENT);
        $segment->setType(Segment::TYPE_DIMENSION);
        $segment->setName('AbTesting_Experiment');
        $segment->setSqlSegment('log_abtesting.idexperiment');
        $segment->setAcceptedValues('Accepts any experiment name of a currently running or finished experiment.');
        $segment->setSqlFilter('\\Piwik\\Plugins\\AbTesting\\Segment::getIdByName');
        $segment->setSuggestedValuesCallback(function ($idSite, $maxValuesToReturn) {
            $experiments = $this->getExperimentsWithReports($idSite);
            $names = array();

            foreach ($experiments as $experiment) {
                $names[] = $experiment['name'];
            }

            return array_slice($names, 0, $maxValuesToReturn);
        });

        $list->addSegment($segment);

        $segment = new Segment();
        $segment->setSegment(Segment::NAME_VARIATION_SEGMENT);
        $segment->setType(Segment::TYPE_DIMENSION);
        $segment->setName('AbTesting_Variation');
        $segment->setSqlSegment('log_abtesting.idvariation');
        $segment->setAcceptedValues('Accepts any variation name of a currently running or finished experiment.');
        $segment->setSqlFilter('\\Piwik\\Plugins\\AbTesting\\Segment::getIdByName');
        $segment->setSuggestedValuesCallback(function ($idSite, $maxValuesToReturn) {
            $experiments = $this->getExperimentsWithReports($idSite);
            $names = array();

            foreach ($experiments as $experiment) {
                foreach ($experiment['variations'] as $variation) {
                    $names[] = $variation['name'];
                }
            }

            return array_slice($names, 0, $maxValuesToReturn);
        });

        $list->addSegment($segment);

        $segment = new Segment();
        $segment->setSegment(Segment::NAME_ENTERED_SEGMENT);
        $segment->setType(Segment::TYPE_DIMENSION);
        $segment->setName('AbTesting_VisitEnteredExperiment');
        $segment->setSqlSegment('log_abtesting.entered');
        $segment->setAcceptedValues('Eg "1", "0", "true", "false"');
        $segment->setSqlFilterValue(function ($entered) {
            if (in_array($entered, array(0,1))) {
                return (int) $entered;
            }

            if (strtolower($entered) === 'true') {
                return 1;
            }

            if (strtolower($entered) === 'false') {
                return 0;
            }

            $message = Piwik::translate('AbTesting_ErrorXNotWhitelisted', array('abtesting_entered', '1, 0, true, false'));

            throw new Exception($message);
        });
        $segment->setSuggestedValuesCallback(function ($idSite, $maxValuesToReturn) {
            return array('true', 'false', '1', '0');
        });

        $list->addSegment($segment);
    }

    private function getExperimentsModel()
    {
        return StaticContainer::get('Piwik\Plugins\AbTesting\Model\Experiments');
    }

    private function getExperimentsDao()
    {
        return StaticContainer::get('Piwik\Plugins\AbTesting\Dao\Experiment');
    }

    private function getExperimentsWithReports($idSite)
    {
        return Request::processRequest('AbTesting.getExperimentsWithReports', ['idSite' => $idSite, 'filter_limit' => -1], $default = []);
    }

    public static function shouldEnableUniqueVisitorMetricForcefully($experiment)
    {
        return in_array($experiment['status'], [Experiments::STATUS_ARCHIVED, Experiments::STATUS_FINISHED]);
    }
}
