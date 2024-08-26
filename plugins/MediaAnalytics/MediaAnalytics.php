<?php 
/**
 * Plugin Name: Media Analytics (Matomo Plugin)
 * Plugin URI: https://plugins.matomo.org/MediaAnalytics
 * Description: Grow your business with advanced video & audio analytics. Get powerful insights into how your audience watches your videos and listens to your audio.
 * Author: InnoCraft
 * Author URI: https://www.media-analytics.net
 * Version: 5.0.9
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

namespace Piwik\Plugins\MediaAnalytics;

use Exception;
use Piwik\Columns\Dimension;
use Piwik\Common;
use Piwik\Piwik;
use Piwik\Plugin;
use Piwik\Plugin\Manager;
use Piwik\Plugins\Live\Live;
use Piwik\Plugins\MediaAnalytics\Actions\ActionMedia;
use Piwik\Plugins\MediaAnalytics\Dao\LogMediaPlays;
use Piwik\Plugins\MediaAnalytics\Dao\LogTable;
use Piwik\Segment\SegmentsList;
use Piwik\Widget\WidgetConfig;
use Piwik\Config;

 
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

class MediaAnalytics extends Plugin
{
    const MEDIA_TYPE_VIDEO = 1;
    const MEDIA_TYPE_AUDIO = 2;
    const TRACKER_READY_HOOK_NAME = '/*!! mediaTrackerReadyHook */';
    const TRACKER_READY_HOOK_NAME_WHEN_MINIFIED = '/*!!! mediaTrackerReadyHook */';
    
    public function registerEvents()
    {
        return array(
            'Segment.addSegments' => 'addSegmentDimensionMetadata',
            'AssetManager.getStylesheetFiles' => 'getStylesheetFiles',
            'AssetManager.getJavaScriptFiles' => 'getJsFiles',
            'Metrics.getDefaultMetricTranslations' => 'getDefaultMetricTranslations',
            'Metrics.getDefaultMetricDocumentationTranslations' => 'getDefaultMetricDocumentationTranslations',
            'Metrics.getDefaultMetricSemanticTypes' => 'addDefaultMetricSemanticTypes',
            'Translate.getClientSideTranslationKeys' => 'getClientSideTranslationKeys',
            'Widget.addWidgetConfigs' => 'addWidgetConfigs',
            'Actions.addActionTypes' => 'addActionTypes',
            'Db.getTablesInstalled' => 'getTablesInstalled',
            'CustomJsTracker.manipulateJsTracker'  => 'disableMediaAnalyticsDefaultIfNeeded'
        );
    }

    public function addDefaultMetricSemanticTypes(&$types)
    {
        $types[Metrics::METRIC_NB_PLAYS] = Dimension::TYPE_NUMBER;
        $types[Metrics::METRIC_NB_PLAYS_BY_UNIQUE_VISITORS] = Dimension::TYPE_NUMBER;
        $types[Metrics::METRIC_NB_IMPRESSIONS] = Dimension::TYPE_NUMBER;
        $types[Metrics::METRIC_NB_IMPRESSIONS_BY_UNIQUE_VISITORS] = Dimension::TYPE_NUMBER;
        $types[Metrics::METRIC_NB_FINISHES] = Dimension::TYPE_NUMBER;
        $types[Metrics::METRIC_TOTAL_TIME_WATCHED] = Dimension::TYPE_DURATION_S;
        $types[Metrics::METRIC_TOTAL_AUDIO_PLAYS] = Dimension::TYPE_NUMBER;
        $types[Metrics::METRIC_TOTAL_AUDIO_IMPRESSIONS] = Dimension::TYPE_NUMBER;
        $types[Metrics::METRIC_TOTAL_VIDEO_PLAYS] = Dimension::TYPE_NUMBER;
        $types[Metrics::METRIC_TOTAL_VIDEO_IMPRESSIONS] = Dimension::TYPE_NUMBER;
    }

    public function disableMediaAnalyticsDefaultIfNeeded(&$content)
    {
        $configuration = new Configuration();
        if (!$configuration->shouldEnableEventTrackingByDefault()){
            $replace = 'arguments[0].MediaAnalytics.enableEvents = false;';
        } else {
            $replace = '';
        }

        $content = str_replace(array(self::TRACKER_READY_HOOK_NAME_WHEN_MINIFIED, self::TRACKER_READY_HOOK_NAME), $replace, $content);
    }

    /**
     * Register the new tables, so Matomo knows about them.
     *
     * @param array $allTablesInstalled
     */
    public function getTablesInstalled(&$allTablesInstalled)
    {
        $allTablesInstalled[] = Common::prefixTable('log_media_plays');
        $allTablesInstalled[] = Common::prefixTable('log_media');
    }
    
    public function isTrackerPlugin()
    {
        return true;
    }

    public function install()
    {
        $logTable = new LogTable();
        $logTable->install();

        $logTable = new LogMediaPlays();
        $logTable->install();

        $configuration = new Configuration();
        $configuration->install();
    }

    public function uninstall()
    {
        $logTable = new LogTable();
        $logTable->uninstall();

        $logTable = new LogMediaPlays();
        $logTable->uninstall();

        $configuration = new Configuration();
        $configuration->uninstall();
    }

    public function addWidgetConfigs(&$configs)
    {
        $idSite = Common::getRequestVar('idSite', false, 'int');

        if (!empty($idSite)) {
            $widgetsToAdd = array(
                '60' => 'MediaAnalytics_WidgetTitleMostPlaysLast60',
                '1440' => 'MediaAnalytics_WidgetTitleMostPlaysLast1440'
            );
            foreach ($widgetsToAdd as $lastMinutes => $name) {
                $config = new WidgetConfig();
                $config->setModule('MediaAnalytics');
                $config->setAction('mostPlays');
                $config->setName($name);
                $config->setCategoryId('MediaAnalytics_Media');
                $config->setParameters(array('lastMinutes' => $lastMinutes));
                $config->setIsEnabled(Piwik::isUserHasViewAccess($idSite));
                $config->setOrder(102);
                if ('1440' == $lastMinutes || Common::getRequestVar('method', '', 'string') === 'API.getWidgetMetadata') {
                    $config->setSubcategoryId('MediaAnalytics_TypeRealTime');
                }
                $configs[] = $config;
            }

            $isVisitorLogEnabled = Manager::getInstance()->isPluginActivated('Live') && Live::isVisitorLogEnabled($idSite);

            if ($isVisitorLogEnabled) {
                $config = new WidgetConfig();
                $config->setModule('MediaAnalytics');
                $config->setAction('getAudienceLog');
                $config->setName('MediaAnalytics_MediaVisitorLogTitle');
                $config->setCategoryId('MediaAnalytics_Media');
                $config->setSubcategoryId('MediaAnalytics_TypeAudienceLog');
                $config->setIsNotWidgetizable();
                $config->setIsEnabled(Piwik::isUserHasViewAccess($idSite));
                $configs[] = $config;
            }
        }
    }

    public function getStylesheetFiles(&$stylesheets)
    {
        $stylesheets[] = 'plugins/MediaAnalytics/stylesheets/reports.less';
    }

    public function getJsFiles(&$jsFiles)
    {
        $jsFiles[] = 'plugins/MediaAnalytics/javascripts/mediaDataTable.js';
        $jsFiles[] = 'plugins/MediaAnalytics/javascripts/liveMediaDataTable.js';
        $jsFiles[] = 'plugins/MediaAnalytics/javascripts/mediaBarGraph.js';
        $jsFiles[] = 'plugins/MediaAnalytics/javascripts/rowaction.js';
    }
    
    public function getDefaultMetricTranslations(&$translations)
    {
        $translations[Metrics::METRIC_NB_PLAYS] = Piwik::translate('MediaAnalytics_ColumnPlays');
        $translations[Metrics::METRIC_NB_PLAYS_BY_UNIQUE_VISITORS] = Piwik::translate('MediaAnalytics_ColumnPlaysByUniqueVisitors');
        $translations[Metrics::METRIC_NB_IMPRESSIONS] = Piwik::translate('MediaAnalytics_ColumnImpressions');
        $translations[Metrics::METRIC_NB_IMPRESSIONS_BY_UNIQUE_VISITORS] = Piwik::translate('MediaAnalytics_ColumnImpressionsByUniqueVisitors');
        $translations[Metrics::METRIC_NB_FINISHES] = Piwik::translate('MediaAnalytics_ColumnFinishes');
        $translations[Metrics::METRIC_TOTAL_TIME_WATCHED] = Piwik::translate('MediaAnalytics_ColumnTotalTimeWatched');
        $translations[Metrics::METRIC_TOTAL_AUDIO_PLAYS] = Piwik::translate('MediaAnalytics_ColumnTotalAudioPlays');
        $translations[Metrics::METRIC_TOTAL_AUDIO_IMPRESSIONS] = Piwik::translate('MediaAnalytics_ColumnTotalAudioImpressions');
        $translations[Metrics::METRIC_TOTAL_VIDEO_PLAYS] = Piwik::translate('MediaAnalytics_ColumnTotalVideoPlays');
        $translations[Metrics::METRIC_TOTAL_VIDEO_IMPRESSIONS] = Piwik::translate('MediaAnalytics_ColumnTotalVideoImpressions');
    }

    public function getDefaultMetricDocumentationTranslations(&$translations)
    {
        $translations[Metrics::METRIC_NB_PLAYS] = Piwik::translate('MediaAnalytics_ColumnDescriptionPlays');
        $translations[Metrics::METRIC_NB_PLAYS_BY_UNIQUE_VISITORS] = Piwik::translate('MediaAnalytics_ColumnDescriptionPlaysByUniqueVisitors');
        $translations[Metrics::METRIC_NB_IMPRESSIONS] = Piwik::translate('MediaAnalytics_ColumnDescriptionImpressions');
        $translations[Metrics::METRIC_NB_IMPRESSIONS_BY_UNIQUE_VISITORS] = Piwik::translate('MediaAnalytics_ColumnDescriptionImpressionsByUniqueVisitors');
        $translations[Metrics::METRIC_NB_FINISHES] = Piwik::translate('MediaAnalytics_ColumnDescriptionFinishes');
        $translations[Metrics::METRIC_TOTAL_TIME_WATCHED] = Piwik::translate('MediaAnalytics_ColumnDescriptionTotalTimeWatched');
        $translations[Metrics::METRIC_TOTAL_AUDIO_PLAYS] = Piwik::translate('MediaAnalytics_ColumnDescriptionTotalAudioPlays');
        $translations[Metrics::METRIC_TOTAL_AUDIO_IMPRESSIONS] = Piwik::translate('MediaAnalytics_ColumnDescriptionTotalAudioImpressions');
        $translations[Metrics::METRIC_TOTAL_VIDEO_PLAYS] = Piwik::translate('MediaAnalytics_ColumnDescriptionTotalVideoPlays');
        $translations[Metrics::METRIC_TOTAL_VIDEO_IMPRESSIONS] = Piwik::translate('MediaAnalytics_ColumnDescriptionTotalVideoImpressions');
    }

    public function getClientSideTranslationKeys(&$translationKeys)
    {
        $translationKeys[] = 'MediaAnalytics_RowActionTooltipTitle';
        $translationKeys[] = 'MediaAnalytics_RowActionTooltipDefault';
        $translationKeys[] = 'MediaAnalytics_MediaDetails';
        $translationKeys[] = 'SegmentEditor_CustomSegment';
        $translationKeys[] = 'MediaAnalytics_GettingStarted';
        $translationKeys[] = 'MediaAnalytics_NoMediaTrackedYet';
        $translationKeys[] = 'MediaAnalytics_NoMediaTrackedYetDescription';
        $translationKeys[] = 'MediaAnalytics_NoMediaTrackedYetMoreInfo';
        $translationKeys[] = 'MediaAnalytics_NoMediaTrackedYetWillDisappear';
        $translationKeys[] = 'MediaAnalytics_PiwikJsNotWritable1';
        $translationKeys[] = 'MediaAnalytics_PiwikJsNotWritable2';
    }

    public function addSegmentDimensionMetadata(SegmentsList $list)
    {
        $mediaTypeValues = array(self::MEDIA_TYPE_AUDIO => 'audio', self::MEDIA_TYPE_VIDEO => 'video');
        
        $segment = new Segment();
        $segment->setSegment(Segment::NAME_MEDIA_IMPRESSION_TYPE);
        $segment->setType(Segment::TYPE_DIMENSION);
        $segment->setName(Piwik::translate('MediaAnalytics_SegmentNameMediaImpressionType'));
        $segment->setSqlSegment('log_media.media_type');
        $segment->setAcceptedValues(Piwik::translate('MediaAnalytics_SegmentDescriptionMediaImpressionType'));
        $segment->setSqlFilterValue(function ($mediaType) use ($mediaTypeValues) {
            if (isset($mediaTypeValues[$mediaType])) {
                return (int) $mediaType;
            }
            
            if ($key = array_search($mediaType, $mediaTypeValues)) {
                return (int) $key;
            }

            $message = Piwik::translate('InvalidMediaTypeUseEg', implode(', ', $mediaTypeValues));

            throw new Exception($message);
        });
        $segment->setSuggestedValuesCallback(function ($idSite, $maxValuesToReturn) use ($mediaTypeValues) {
            return array_values($mediaTypeValues);
        });
        $list->addSegment($segment);

        $segment = new Segment();
        $segment->setSegment(Segment::NAME_MEDIA_PLAYS_TYPE);
        $segment->setType(Segment::TYPE_DIMENSION);
        $segment->setName(Piwik::translate('MediaAnalytics_SegmentNameMediaPlaysType'));
        $segment->setSqlSegment('log_media.idview');
        $segment->setSqlFilter('\\Piwik\\Plugins\\MediaAnalytics\\Segment::getMediaTypePlays');
        $segment->setAcceptedValues(Piwik::translate('MediaAnalytics_SegmentDescriptionMediaPlayType'));
        $segment->setSqlFilterValue(function ($mediaType) use ($mediaTypeValues) {
            if (isset($mediaTypeValues[$mediaType])) {
                return (int) $mediaType;
            }

            if ($key = array_search($mediaType, $mediaTypeValues)) {
                return (int) $key;
            }

            $message = Piwik::translate('InvalidMediaTypeUseEg', implode(', ', $mediaTypeValues));

            throw new Exception($message);
        });
        $segment->setSuggestedValuesCallback(function ($idSite, $maxValuesToReturn) use ($mediaTypeValues) {
            return array_values($mediaTypeValues);
        });
        $list->addSegment($segment);
    }

    public function addActionTypes(&$types)
    {
        $types[] = [
            'id' => ActionMedia::TYPE_MEDIA,
            'name' => 'media'
        ];
    }
}
