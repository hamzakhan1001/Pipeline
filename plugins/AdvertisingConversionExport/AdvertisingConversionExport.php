<?php 
/**
 * Plugin Name: Advertising Conversion Export (Matomo Plugin)
 * Plugin URI: https://plugins.matomo.org/AdvertisingConversionExport
 * Description: Provides an export of attributed goal conversions for usage in ad networks like Google Ads so you no longer need a conversion pixel.
 * Author: InnoCraft
 * Author URI: https://plugins.matomo.org/AdvertisingConversionExport
 * Version: 5.1.1
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
 * @link    https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */

namespace Piwik\Plugins\AdvertisingConversionExport;

use Piwik\Common;
use Piwik\Container\StaticContainer;
use Piwik\Plugin\Manager;
use Piwik\Plugins\AdvertisingConversionExport\AttributionModel\AttributionModelAbstract;
use Piwik\Plugins\AdvertisingConversionExport\AttributionModel\DataDriven;
use Piwik\Plugins\AdvertisingConversionExport\AttributionModel\LastClick;
use Piwik\Plugins\AdvertisingConversionExport\ClickIdProvider\Bing;
use Piwik\Plugins\AdvertisingConversionExport\ClickIdProvider\ClickIdProviderAbstract;
use Piwik\Plugins\AdvertisingConversionExport\ClickIdProvider\Facebook;
use Piwik\Plugins\AdvertisingConversionExport\ClickIdProvider\Google;
use Piwik\Plugins\AdvertisingConversionExport\ClickIdProvider\Yandex;
use Piwik\Plugins\AdvertisingConversionExport\Dao\LogClickId;
use Piwik\Plugins\AdvertisingConversionExport\Export\Adapter\AdapterAbstract;

 
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

class AdvertisingConversionExport extends \Piwik\Plugin
{
    const SITE_CONVERSION_AVAILABLE_EXPORTS = 'site_conversion_available_exports';

    public function registerEvents()
    {
        return [
            'AssetManager.getStylesheetFiles'        => 'getStylesheetFiles',
            'Translate.getClientSideTranslationKeys' => 'getClientSideTranslationKeys',
            'Db.getTablesInstalled'                  => 'getTablesInstalled',
            'Tracker.Cache.getSiteAttributes'        => 'addConfiguredExportTypes'
        ];
    }

    public function isTrackerPlugin()
    {
        return true;
    }

    /**
     * Register the new tables, so Matomo knows about them.
     *
     * @param array $allTablesInstalled
     */
    public function getTablesInstalled(&$allTablesInstalled)
    {
        $allTablesInstalled[] = Common::prefixTable('log_clickid');
        $allTablesInstalled[] = Common::prefixTable('conversion_export');
    }

    public function install()
    {
        $model = new Model();
        $model->install();
        $logTable = new LogClickId();
        $logTable->install();
    }

    public function uninstall()
    {
        $model = new Model();
        $model->uninstall();
        $logTable = new LogClickId();
        $logTable->uninstall();
    }

    public function getStylesheetFiles(&$stylesheets)
    {
        $stylesheets[] = "plugins/AdvertisingConversionExport/vue/src/ConversionExport/Edit.less";
        $stylesheets[] = "plugins/AdvertisingConversionExport/vue/src/ConversionExport/List.less";
        $stylesheets[] = "plugins/AdvertisingConversionExport/stylesheets/styles.less";
    }

    public function getClientSideTranslationKeys(&$translationKeys)
    {
        $translationKeys[] = 'AdvertisingConversionExport_AccessToken';
        $translationKeys[] = 'AdvertisingConversionExport_AccessTokenHelp';
        $translationKeys[] = 'AdvertisingConversionExport_AdditionalSegment';
        $translationKeys[] = 'AdvertisingConversionExport_AllClickIds';
        $translationKeys[] = 'AdvertisingConversionExport_AttributedCreditHelp';
        $translationKeys[] = 'AdvertisingConversionExport_AttributedCreditInvalid';
        $translationKeys[] = 'AdvertisingConversionExport_AttributionModelHelp';
        $translationKeys[] = 'AdvertisingConversionExport_AttributionModelInvalid';
        $translationKeys[] = 'AdvertisingConversionExport_AttributionSettings';
        $translationKeys[] = 'AdvertisingConversionExport_ClickIdAttribution';
        $translationKeys[] = 'AdvertisingConversionExport_ClickIdAttributionDescription';
        $translationKeys[] = 'AdvertisingConversionExport_ConversionsToExport';
        $translationKeys[] = 'AdvertisingConversionExport_ConversionsToExportHelp';
        $translationKeys[] = 'AdvertisingConversionExport_CreateNewExport';
        $translationKeys[] = 'AdvertisingConversionExport_DataDrivenAttributionModel';
        $translationKeys[] = 'AdvertisingConversionExport_DaysToExport';
        $translationKeys[] = 'AdvertisingConversionExport_DaysToExportHelp';
        $translationKeys[] = 'AdvertisingConversionExport_DaysToLookBack';
        $translationKeys[] = 'AdvertisingConversionExport_DaysToLookBackDescription';
        $translationKeys[] = 'AdvertisingConversionExport_DeleteExport';
        $translationKeys[] = 'AdvertisingConversionExport_DeleteExportConfirm';
        $translationKeys[] = 'AdvertisingConversionExport_DirectAttributionOnly';
        $translationKeys[] = 'AdvertisingConversionExport_DirectAttributionOnlyDescription';
        $translationKeys[] = 'AdvertisingConversionExport_DirectAttributionOnlyNote';
        $translationKeys[] = 'AdvertisingConversionExport_DoNotShare';
        $translationKeys[] = 'AdvertisingConversionExport_DownloadExport';
        $translationKeys[] = 'AdvertisingConversionExport_DownloadLink';
        $translationKeys[] = 'AdvertisingConversionExport_EditExport';
        $translationKeys[] = 'AdvertisingConversionExport_ErrorXNotProvided';
        $translationKeys[] = 'AdvertisingConversionExport_ExportCreated';
        $translationKeys[] = 'AdvertisingConversionExport_ExportDescriptionHelp';
        $translationKeys[] = 'AdvertisingConversionExport_ExportDescriptionPlaceHolder';
        $translationKeys[] = 'AdvertisingConversionExport_ExportNameHelp';
        $translationKeys[] = 'AdvertisingConversionExport_ExportSaveFailed';
        $translationKeys[] = 'AdvertisingConversionExport_ExportType';
        $translationKeys[] = 'AdvertisingConversionExport_ExportTypeHelp';
        $translationKeys[] = 'AdvertisingConversionExport_ExportUpdated';
        $translationKeys[] = 'AdvertisingConversionExport_ExportNote';
        $translationKeys[] = 'AdvertisingConversionExport_ExportNoteMessage';
        $translationKeys[] = 'AdvertisingConversionExport_ExternalAttributedConversionHelp';
        $translationKeys[] = 'AdvertisingConversionExport_FieldAccessTokenPlaceholder';
        $translationKeys[] = 'AdvertisingConversionExport_FieldNamePlaceholder';
        $translationKeys[] = 'AdvertisingConversionExport_FirstClickId';
        $translationKeys[] = 'AdvertisingConversionExport_GoalAlias';
        $translationKeys[] = 'AdvertisingConversionExport_IncludedConversions';
        $translationKeys[] = 'AdvertisingConversionExport_LastClickAttributionModel';
        $translationKeys[] = 'AdvertisingConversionExport_LastClickId';
        $translationKeys[] = 'AdvertisingConversionExport_LastRequested';
        $translationKeys[] = 'AdvertisingConversionExport_LastRequestedInfo';
        $translationKeys[] = 'AdvertisingConversionExport_ManageExports';
        $translationKeys[] = 'AdvertisingConversionExport_ManageExportsIntroduction';
        $translationKeys[] = 'AdvertisingConversionExport_NoExportsFound';
        $translationKeys[] = 'AdvertisingConversionExport_NoGoalsConfigured';
        $translationKeys[] = 'AdvertisingConversionExport_PleaseConfigureGoals';
        $translationKeys[] = 'AdvertisingConversionExport_Regenerate';
        $translationKeys[] = 'AdvertisingConversionExport_RegenerateAccessTokenConfirm';
        $translationKeys[] = 'AdvertisingConversionExport_ShowDownloadLink';
        $translationKeys[] = 'AdvertisingConversionExport_UnableToLoadExport';
        $translationKeys[] = 'AdvertisingConversionExport_UpdatingData';
        $translationKeys[] = 'AdvertisingConversionExport_UseCustomRevenue';
        $translationKeys[] = 'AdvertisingConversionExport_UseEmptyRevenue';
        $translationKeys[] = 'AdvertisingConversionExport_UseGoalRevenue';
        $translationKeys[] = 'AdvertisingConversionExport_VisitorsToExport';
        $translationKeys[] = 'AdvertisingConversionExport_VisitorsToExportHelp';
        $translationKeys[] = 'CoreUpdater_UpdateTitle';
        $translationKeys[] = 'General_Actions';
        $translationKeys[] = 'General_Add';
        $translationKeys[] = 'General_Cancel';
        $translationKeys[] = 'General_Close';
        $translationKeys[] = 'General_ColumnRevenue';
        $translationKeys[] = 'General_Description';
        $translationKeys[] = 'General_EcommerceOrders';
        $translationKeys[] = 'General_Goal';
        $translationKeys[] = 'General_Id';
        $translationKeys[] = 'General_LoadingData';
        $translationKeys[] = 'General_Name';
        $translationKeys[] = 'General_Never';
        $translationKeys[] = 'General_No';
        $translationKeys[] = 'General_Remove';
        $translationKeys[] = 'General_Unknown';
        $translationKeys[] = 'General_Value';
        $translationKeys[] = 'General_Yes';
        $translationKeys[] = 'AdvertisingConversionExport_PleaseConfigureDaysToExport';
    }

    /**
     * @return ClickIdProviderAbstract[]
     */
    public static function getAvailableClickIdProviders(): array
    {
        return [
            Google::getInstance(),
            Facebook::getInstance(),
            Bing::getInstance(),
            Yandex::getInstance(),
        ];
    }

    /**
     * @return AttributionModelAbstract[]
     */
    public static function getAttributionModels(): array
    {
        return StaticContainer::get('attributionModels');
    }

    public static function getAttributionModelsArray(): array
    {
        $attributionModels = array();

        foreach (self::getAttributionModels() as $attributionModel) {
            if ($attributionModel->getId()) {
                $attributionModels[$attributionModel->getId()] = [
                    'id' => $attributionModel->getId(),
                    'exportName' => $attributionModel->getExportName(),
                    'translatedName' => $attributionModel->getTranslatedName(),
                ];
            }
        }

        return $attributionModels;
    }

    /**
     * @return AdapterAbstract[]
     */
    public static function getAvailableExportTypes(): array
    {
        $plugin = Manager::getInstance()->getLoadedPlugin('AdvertisingConversionExport');
        return $plugin->findMultipleComponents('Export/Adapter', AdapterAbstract::class);
    }

    public static function getExportAdapterById(string $id): ?string
    {
        foreach (self::getAvailableExportTypes() as $type) {
            if ($type::getId() === $id) {
                return $type;
            }
        }

        return null;
    }

    public function addConfiguredExportTypes(&$content, $idSite)
    {
        $model = new Model();
        $content[self::SITE_CONVERSION_AVAILABLE_EXPORTS] = $model->getAllConfiguredExportTypes($idSite);
    }
}
