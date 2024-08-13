<?php 
/**
 * Plugin Name: SEO Web Vitals (Matomo Plugin)
 * Plugin URI: https://plugins.matomo.org/SEOWebVitals
 * Description: Improve your website performance, rank higher in search results and optimise your visitor experience with SEO Web Vitals.
 * Author: InnoCraft
 * Author URI: https://matomo.org
 * Version: 5.0.6
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

namespace Piwik\Plugins\SEOWebVitals;

use Piwik\Common;
use Piwik\Plugins\SEOWebVitals\Dao\Reports;
use Piwik\Plugins\SitesManager\Model;

 
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

class SEOWebVitals extends \Piwik\Plugin
{
    public function registerEvents()
    {
        return array(
            'Metrics.getDefaultMetricTranslations' => 'getDefaultMetricTranslations',
            'Metrics.getDefaultMetricDocumentationTranslations' => 'getDefaultMetricDocumentationTranslations',
            'Metrics.getDefaultMetricSemanticTypes' => 'addDefaultMetricSemanticTypes',
            'Archiving.getIdSitesToArchiveWhenNoVisits'   => 'getIdSitesToArchiveWhenNoVisits',
            'AssetManager.getJavaScriptFiles' => 'getJsFiles',
            'Translate.getClientSideTranslationKeys' => 'getClientSideTranslationKeys',
            'Metrics.isLowerValueBetter'=> 'isLowerMetricValueBetter'
        );
    }

    public function addDefaultMetricSemanticTypes(&$types)
    {
        $metrics = new Metrics();
        foreach ($metrics->getSemanticTypes() as $metricName => $type) {
            $types[$metricName] = $type;
        }
    }

    public function isLowerMetricValueBetter(&$isLowerBetter, $column)
    {
        if (!$isLowerBetter) {
            $metrics = Metrics::appendAllStrategies([Metrics::METRIC_LOAD_EXPERIENCE_CLS_NUMERICVALUE => 1,
                Metrics::METRIC_LOAD_EXPERIENCE_FID_NUMERICVALUE => 1,
                Metrics::METRIC_LOAD_EXPERIENCE_INP_NUMERICVALUE => 1,
                Metrics::METRIC_AUDIT_DISPLAY_VALUE => 1,
                Metrics::METRIC_LOAD_EXPERIENCE_LCP_NUMERICVALUE => 1,
                Metrics::METRIC_LOAD_EXPERIENCE_FCP_NUMERICVALUE => 1]);
            if (array_key_exists($column, $metrics)) {
                $isLowerBetter = true;
            }
        }
    }

    public function getIdSitesToArchiveWhenNoVisits(&$idSites)
    {
        if (Common::getRequestVar('segment', '', 'string')) {
            return; // no need to archive the reports for segments in this case
        }

        $sitesModel = new Model();
        $allIdSites = $sitesModel->getSitesId();

        // todo query which sites have configured URLs and which ones not
        $idSites = array_unique(array_merge($idSites, $allIdSites));

    }

    public function install()
    {
        $reports = new Reports();
        $reports->install();
    }

    public function uninstall()
    {
        $reports = new Reports();
        $reports->uninstall();
    }

    public function getDefaultMetricTranslations(&$translations)
    {
        $metrics = new Metrics();
        foreach ($metrics->getTranslations() as $metricName => $translation) {
            $translations[$metricName] = $translation;
        }
    }

    public function getDefaultMetricDocumentationTranslations(&$translations)
    {
        $metrics = new Metrics();
        foreach ($metrics->getDocumentationTranslations() as $metricName => $translation) {
            $translations[$metricName] = $translation;
        }
    }

    public function getJsFiles(&$jsFiles)
    {
        $jsFiles[] = 'plugins/SEOWebVitals/javascripts/rowaction.js';
        $jsFiles[] = 'plugins/SEOWebVitals/javascripts/setupUrls.js';
    }

    public function getClientSideTranslationKeys(&$translationKeys)
    {
        $translationKeys[] = 'SEOWebVitals_RowActionTooltipTitle';
        $translationKeys[] = 'SEOWebVitals_RowActionTooltipDefault';
    }
}
