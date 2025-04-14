<?php 
/**
 * Plugin Name: Form Analytics (Matomo Plugin)
 * Plugin URI: https://plugins.matomo.org/FormAnalytics
 * Description: Increase conversions on your online forms and lose less visitors by learning everything about your users behavior and their pain points on your forms
 * Author: InnoCraft
 * Author URI: https://plugins.matomo.org/FormAnalytics
 * Version: 5.0.14
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

namespace Piwik\Plugins\FormAnalytics;

use Piwik\API\Request;
use Piwik\Category\Subcategory;
use Piwik\Common;
use Piwik\Container\StaticContainer;
use Piwik\Piwik;
use Piwik\Plugin;
use Piwik\Plugins\CoreHome\SystemSummary;
use Piwik\Plugins\FormAnalytics\Actions\ActionForm;
use Piwik\Plugins\FormAnalytics\Dao\LogFormPage;
use Piwik\Plugins\FormAnalytics\Dao\SiteForm;
use Piwik\Plugins\FormAnalytics\Dao\LogForm;
use Piwik\Plugins\FormAnalytics\Dao\LogFormField;
use Piwik\Plugins\FormAnalytics\Model\FormsModel;
use Piwik\Segment\SegmentsList;

 
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

class FormAnalytics extends Plugin
{
    public const TRACKER_CACHE_RUNNING_FORMS_KEY = 'forms';
    public const TRACKER_CACHE_ALL_FORMS_KEY = 'forms_all';
    public const TRACKER_CACHE_NUM_AUTO_CREATED = 'num_forms_auto_created';
    public const TRACKER_READY_HOOK_NAME = '/*!! formAnalyticsTrackerReadyHook */';
    public const TRACKER_READY_HOOK_NAME_WHEN_MINIFIED = '/*!!! formAnalyticsTrackerReadyHook */';

    public function registerEvents()
    {
        return array(
            'AssetManager.getStylesheetFiles' => 'getStylesheetFiles',
            'AssetManager.getJavaScriptFiles' => 'getJsFiles',
            'Translate.getClientSideTranslationKeys' => 'getClientSideTranslationKeys',
            'Category.addSubcategories' => 'addSubcategories',
            'Tracker.Cache.getSiteAttributes'  => 'addSiteForms',
            'SitesManager.deleteSite.end' => 'onDeleteSite',
            'Segment.addSegments' => 'addSegments',
            'Metrics.getDefaultMetricTranslations' => 'getDefaultMetricTranslations',
            'System.addSystemSummaryItems' => 'addSystemSummaryItems',
            'Metrics.getDefaultMetricDocumentationTranslations' => 'getDefaultMetricDocumentationTranslations',
            'Actions.addActionTypes' => 'addActionTypes',
            'API.getPagesComparisonsDisabledFor'     => 'getPagesComparisonsDisabledFor',
            'Db.getTablesInstalled' => 'getTablesInstalled',
            'CustomJsTracker.manipulateJsTracker'  => 'updateMaxNoOfFormRequestAllowed',
            'Metrics.getDefaultMetricSemanticTypes' => 'addMetricSemanticTypes',
            'Db.getActionReferenceColumnsByTable' => 'addActionReferenceColumnsByTable',
        );
    }

    public function addMetricSemanticTypes(array &$types): void
    {
        $types = array_merge($types, Metrics::getMetricSemanticTypes());
    }

    /**
     * Register the new tables, so Matomo knows about them.
     *
     * @param array $allTablesInstalled
     */
    public function getTablesInstalled(&$allTablesInstalled)
    {
        $allTablesInstalled[] = Common::prefixTable('log_form');
        $allTablesInstalled[] = Common::prefixTable('log_form_field');
        $allTablesInstalled[] = Common::prefixTable('log_form_page');
        $allTablesInstalled[] = Common::prefixTable('site_form');
    }

    public function getPagesComparisonsDisabledFor(&$pages)
    {
        $pages[] = 'FormAnalytics_Forms.FormAnalytics_TypeRealTime';
    }

    public function addSystemSummaryItems(&$systemSummary)
    {
        $dao = $this->getSiteFormsDao();
        $numForms = $dao->getNumFormsTotal();

        $systemSummary[] = new SystemSummary\Item($key = 'forms', Piwik::translate('FormAnalytics_NForms', $numForms), $value = null, array('module' => 'FormAnalytics', 'action' => 'manage'), $icon = 'icon-form', $order = 8);
    }

    public function isTrackerPlugin()
    {
        return true;
    }

    public function install()
    {
        $form = new SiteForm();
        $form->install();

        $logForm = new LogForm();
        $logForm->install();

        $logForm = new LogFormPage();
        $logForm->install();

        $logFormField = new LogFormField();
        $logFormField->install();

        $configuration = new Configuration();
        $configuration->install();
    }

    public function uninstall()
    {
        $form = new SiteForm();
        $form->uninstall();

        $logForm = new LogForm();
        $logForm->uninstall();

        $logForm = new LogFormPage();
        $logForm->uninstall();

        $logFormField = new LogFormField();
        $logFormField->uninstall();

        $configuration = new Configuration();
        $configuration->uninstall();
    }

    public function onDeleteSite($idSite)
    {
        $formsModel = $this->getFormsModel();
        $formsModel->deactivateFormsForSite($idSite);
    }

    public function getDefaultMetricTranslations(&$translations)
    {
        $translations = array_merge($translations, Metrics::getMetricsTranslations());
    }

    public function getDefaultMetricDocumentationTranslations(&$translations)
    {
        $translations = array_merge($translations, Metrics::getMetricsDocumentationTranslations());
    }

    public function addSiteForms(&$content, $idSite)
    {
        // we cache running and created forms as a created one can become running while being cached
        $formsModel = $this->getFormsModel();
        $content[self::TRACKER_CACHE_RUNNING_FORMS_KEY] = $formsModel->getFormsByStatuses($idSite, FormsModel::STATUS_RUNNING);
        $content[self::TRACKER_CACHE_ALL_FORMS_KEY] = $formsModel->getFormsByStatuses($idSite, array(FormsModel::STATUS_RUNNING, FormsModel::STATUS_ARCHIVED));
        $content[self::TRACKER_CACHE_NUM_AUTO_CREATED] = $formsModel->getNumFormsAutoCreated($idSite);
    }

    private function getSiteFormsDao()
    {
        return StaticContainer::get('Piwik\Plugins\FormAnalytics\Dao\SiteForm');
    }

    /**
     * @return FormsModel
     */
    private function getFormsModel()
    {
        return StaticContainer::get('Piwik\Plugins\FormAnalytics\Model\FormsModel');
    }

    public function addSubcategories(&$subcategories)
    {
        $idSite = Common::getRequestVar('idSite', 0, 'int');

        if (empty($idSite)) {
            // fallback for eg API.getReportMetadata which uses idSites
            $idSite = Common::getRequestVar('idSites', 0, 'int');

            if (empty($idSite)) {
                return;
            }
        }

        $forms = $this->getFormsByStatuses($idSite, FormsModel::STATUS_RUNNING);

        $order = 20;
        foreach ($forms as $form) {
            $subcategory = new Subcategory();
            $subcategory->setName($form['name']);
            $subcategory->setCategoryId('FormAnalytics_Forms');
            $subcategory->setId($form['idsiteform']);
            $subcategory->setOrder($order++);
            $subcategories[] = $subcategory;
        }
    }

    public function getClientSideTranslationKeys(&$result)
    {
        $result[] = 'General_Done';
        $result[] = 'General_Yes';
        $result[] = 'General_No';
        $result[] = 'General_Add';
        $result[] = 'General_Remove';
        $result[] = 'General_Description';
        $result[] = 'General_Cancel';
        $result[] = 'General_Name';
        $result[] = 'General_Search';
        $result[] = 'General_Ok';
        $result[] = 'General_Id';
        $result[] = 'FormAnalytics_ManageForms';
        $result[] = 'FormAnalytics_ErrorFormRuleRequired';
        $result[] = 'General_LoadingData';
        $result[] = 'FormAnalytics_FieldDescriptionPlaceholder';
        $result[] = 'FormAnalytics_FieldNamePlaceholder';
        $result[] = 'CoreUpdater_UpdateTitle';
        $result[] = 'FormAnalytics_Filter';
        $result[] = 'FormAnalytics_ConversionCriteria';
        $result[] = 'FormAnalytics_UpdatingData';
        $result[] = 'FormAnalytics_FormSetupFormRules';
        $result[] = 'FormAnalytics_FormSetupFormRulesHelp';
        $result[] = 'FormAnalytics_ComparisonsCaseInsensitive';
        $result[] = 'FormAnalytics_ComparisonsIgnoredValues';
        $result[] = 'FormAnalytics_SettingAllowCreationByPageOnlyDescription';
        $result[] = 'FormAnalytics_SettingAllowCreationByPageOnly';
        $result[] = 'FormAnalytics_FormSetupPageRules';
        $result[] = 'FormAnalytics_FormSetupPageRulesHelp';
        $result[] = 'FormAnalytics_FormSetupConversionRules';
        $result[] = 'FormAnalytics_FormSetupTitle';
        $result[] = 'FormAnalytics_FormSetupConversionRulesTitle';
        $result[] = 'FormAnalytics_FormSetupConversionRulesConditionPageVisitInLineHelp';
        $result[] = 'FormAnalytics_FormSetupConversionRulesConditionFormSubmitInLineHelp';
        $result[] = 'FormAnalytics_FormSetupConversionRulesConditionJsOrTagManagerInLineHelp';
        $result[] = 'FormAnalytics_FormSetupConversionRulesManualConversionJsOrTagManagerDescription';
        $result[] = 'FormAnalytics_FormSetupConversionRulesFaqHelpLink';
        $result[] = 'FormAnalytics_FormSetupPageRulesHelpNew';
        $result[] = 'FormAnalytics_FormSetupJsOrTagManagerHelp';
        $result[] = 'FormAnalytics_ErrorInvalidConversionOption';
        $result[] = 'FormAnalytics_FormSetupConversionRulesPageVisitHelp';
        $result[] = 'FormAnalytics_FormSetupConversionRulesFormSubmitHelp';
        $result[] = 'FormAnalytics_FormSetupConversionRulesJsOrTagManagerHelp';
        $result[] = 'FormAnalytics_ArchiveReportInfo';
        $result[] = 'FormAnalytics_Status';
        $result[] = 'FormAnalytics_NoFormsFound';
        $result[] = 'FormAnalytics_DeleteFormInfo';
        $result[] = 'FormAnalytics_ViewReportInfo';
        $result[] = 'FormAnalytics_FormNameHelp';
        $result[] = 'FormAnalytics_FormDescriptionHelp';
        $result[] = 'FormAnalytics_CreateNewForm';
        $result[] = 'FormAnalytics_ErrorXNotProvided';
        $result[] = 'FormAnalytics_EditForm';
        $result[] = 'FormAnalytics_FormCreated';
        $result[] = 'FormAnalytics_FormUpdated';
        $result[] = 'FormAnalytics_ManageFormsIntroduction';
        $result[] = 'FormAnalytics_DeleteFormConfirm';
        $result[] = 'FormAnalytics_ArchiveReportConfirm';
        $result[] = 'FormAnalytics_DisplayNameRequiresAdminAccess';
        $result[] = 'FormAnalytics_FieldName';
        $result[] = 'FormAnalytics_FieldType';
        $result[] = 'FormAnalytics_DisplayName';
        $result[] = 'FormAnalytics_FormFieldEditLimited';
        $result[] = 'FormAnalytics_FormX';
        $result[] = 'FormAnalytics_DataIsCollectedWhen';
        $result[] = 'General_Or';
        $result[] = 'FormAnalytics_AndWhen';
        $result[] = 'FormAnalytics_FormIsConvertedWhen';
        $result[] = 'FormAnalytics_NoConversionRulesDefinesAdmin';
        $result[] = 'FormAnalytics_NoConversionRulesDefinesView';
        $result[] = 'FormAnalytics_ShowVisitorLogStarters';
        $result[] = 'FormAnalytics_ShowVisitorLogSubmitters';
        $result[] = 'FormAnalytics_ShowVisitorLogConverters';
        $result[] = 'FormAnalytics_ViewFormFields';
        $result[] = 'FormAnalytics_EditFormFields';
        $result[] = 'FormAnalytics_TheFormIsSubmitted';
        $result[] = 'FormAnalytics_FormSetupConversionRulesConditionJsOrTagManager';
    }

    public function getStylesheetFiles(&$stylesheets)
    {
        $stylesheets[] = "plugins/FormAnalytics/vue/src/Manage/Edit.less";
        $stylesheets[] = "plugins/FormAnalytics/vue/src/Manage/List.less";
        $stylesheets[] = "plugins/FormAnalytics/stylesheets/report.less";
    }

    public function getJsFiles(&$jsFiles)
    {
        $jsFiles[] = "plugins/FormAnalytics/javascripts/liveFormDataTable.js";
    }

    public function addSegments(SegmentsList $list)
    {
        $segment = new Segment();
        $segment->setSegment(Segment::FORM_NAME_SEGMENT);
        $segment->setType(Segment::TYPE_DIMENSION);
        $segment->setName('FormAnalytics_SegmentFormName');
        $segment->setAcceptedValues(Piwik::translate('FormAnalytics_SegmentFormNameDescription'));
        $segment->setSqlSegment('log_form.idsiteform');
        $segment->setSqlFilter('\\Piwik\\Plugins\\FormAnalytics\\Segment::getIdByName');
        $segment->setSuggestedValuesCallback(function ($idSite, $maxValuesToReturn) {
            $forms = $this->getFormsByStatuses($idSite, FormsModel::STATUS_RUNNING);
            $names = array();

            foreach ($forms as $form) {
                $names[] = $form['name'];
            }

            return array_slice($names, 0, $maxValuesToReturn);
        });

        $list->addSegment($segment);

        $segment = new Segment();
        $segment->setSegment(Segment::FORM_NUM_STARTS_SEGMENT);
        $segment->setType(Segment::TYPE_METRIC);
        $segment->setName('FormAnalytics_SegmentFormStarts');
        $segment->setAcceptedValues(Piwik::translate('FormAnalytics_SegmentFormStartsDescription'));
        $segment->setSqlSegment('log_form.num_starts');
        $segment->setSuggestedValuesCallback(function ($idSite, $maxValuesToReturn) {

            return range(1, $maxValuesToReturn);
        });

        $list->addSegment($segment);

        $segment = new Segment();
        $segment->setSegment(Segment::FORM_NUM_SUBMISSIONS_SEGMENT);
        $segment->setType(Segment::TYPE_METRIC);
        $segment->setName('FormAnalytics_SegmentFormSubmissions');
        $segment->setAcceptedValues(Piwik::translate('FormAnalytics_SegmentFormSubmissionsDescription'));
        $segment->setSqlSegment('log_form.num_submissions');
        $segment->setSuggestedValuesCallback(function ($idSite, $maxValuesToReturn) {

            return range(1, $maxValuesToReturn);
        });

        $list->addSegment($segment);

        $segment = new Segment();
        $segment->setSegment(Segment::FORM_CONVERTED_SEGMENT);
        $segment->setType(Segment::TYPE_METRIC);
        $segment->setName('FormAnalytics_SegmentFormConverted');
        $segment->setAcceptedValues(Piwik::translate('FormAnalytics_SegmentFormConvertedDescription'));
        $segment->setSqlSegment('log_form.converted');
        $segment->setSqlFilterValue(function ($value) {
            if (in_array($value, array('0', '1'))) {
                return (int) $value;
            }

            $value = strtolower($value);

            if ($value === 'yes') {
                return 1;
            }

            if ($value === 'no') {
                return 0;
            }

            return $value;
        });
        $segment->setSuggestedValuesCallback(function () {
            // we cannot use translation for yes / no otherwise it would fail depending on the users langauge
            return array('0', '1', 'Yes', 'No');
        });

        $list->addSegment($segment);

        $segment = new Segment();
        $segment->setSegment(Segment::FORM_SPENT_TIME_SEGMENT);
        $segment->setType(Segment::TYPE_METRIC);
        $segment->setName('FormAnalytics_SegmentFormSpentTime');
        $segment->setAcceptedValues(Piwik::translate('FormAnalytics_SegmentFormSpentTimeDescription'));
        $segment->setSqlSegment('log_form.time_spent');
        $segment->setSuggestedValuesCallback(function ($idSite, $maxValuesToReturn) {
            $values = range(0, 3000, 100);

            return array_slice($values, 0, $maxValuesToReturn);
        });

        $list->addSegment($segment);
    }

    public function addActionTypes(&$types)
    {
         $types[] = [
             'id' => ActionForm::TYPE_FORM,
             'name' => 'form'
         ];
    }

    private function getFormsByStatuses($idSite, $status)
    {
        return Request::processRequest('FormAnalytics.getFormsByStatuses', [
            'idSite' => $idSite,
            'statuses' => $status,
            'filter_limit' => -1
        ], $default = []);
    }

    public function updateMaxNoOfFormRequestAllowed(&$content)
    {
        $configuration = new Configuration();
        $maxNoOfFormRequestAllowed = $configuration->getNumberOfFormRequestsAllowed();
        if (is_numeric($maxNoOfFormRequestAllowed)) {
            $replace = "Matomo.FormAnalytics.setMaxNoOfFormRequestsAllowed($maxNoOfFormRequestAllowed);";
        } else {
            $replace = '';
        }

        $content = str_replace(array(self::TRACKER_READY_HOOK_NAME_WHEN_MINIFIED, self::TRACKER_READY_HOOK_NAME), $replace, $content);
    }

    public function addActionReferenceColumnsByTable(&$result)
    {
        $result['log_form_page'] = ['idaction_url'];
    }
}
