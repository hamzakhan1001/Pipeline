<?php 
/**
 * Plugin Name: Cohorts (Matomo Plugin)
 * Plugin URI: https://plugins.matomo.org/Cohorts
 * Description: Track your retention efforts over time and keep your visitors engaged and coming back for more.
 * Author: InnoCraft
 * Author URI: https://plugins.matomo.org/Cohorts
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

namespace Piwik\Plugins\Cohorts;

use Piwik\Archive\ArchiveInvalidator;
use Piwik\Container\StaticContainer;
use Piwik\CronArchive;
use Piwik\Date;
use Piwik\Option;
use Piwik\Piwik;
use Piwik\Plugin\Manager;
use Piwik\Plugins\Cohorts\Columns\Metrics\VisitorRetentionPercent;

 
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

class Cohorts extends \Piwik\Plugin
{
    public function registerEvents()
    {
        return [
            'AssetManager.getStylesheetFiles' => 'getStylesheets',
            'AssetManager.getJavaScriptFiles' => 'getJsFiles',
            'Metrics.getDefaultMetricTranslations' => 'getDefaultMetricTranslations',
            'API.getPagesComparisonsDisabledFor'     => 'getPagesComparisonsDisabledFor',
            'Metrics.getEvolutionUnit' => 'removeSecondsUnit'
        ];
    }

    public function activate()
    {
        $this->schedulePluginReArchiving();
    }

    public function deactivate()
    {
        $archiveInvalidator = StaticContainer::get(ArchiveInvalidator::class);
        $archiveInvalidator->removeInvalidationsSafely('all', $this->getPluginName());
    }

    public function getPagesComparisonsDisabledFor(&$pages)
    {
        $pages[] = 'General_Visitors.Cohorts_Cohorts';
    }

    public function getDefaultMetricTranslations(&$translations)
    {
        $translations[VisitorRetentionPercent::NAME] = Piwik::translate('Cohorts_ReturningVisitorsPercent');
    }

    public function getStylesheets(&$stylesheets)
    {
        $stylesheets[] =  'plugins/Cohorts/stylesheets/dataTableVizCohorts.less';
    }

    public function getJsFiles(&$javascripts)
    {
        $javascripts[] = 'plugins/Cohorts/javascripts/cohortsDataTable.js';
    }

    public function removeSecondsUnit(&$unit, $column, $idSite)
    {
        $request = \Piwik\Request::fromRequest();
        $module = $request->getStringParameter('module', '');
        $action = $request->getStringParameter('action', '');
        if ($column === 'avg_time_on_site' && $module === 'Cohorts' && $action === 'getEvolutionGraph') {
            $unit = ' ';
        }
    }

    /**
     * This helper method is to take an already formatted metric and return a numeric value that can be used for
     * calculations, like determining the color grade.
     *
     * This method was moved from \Piwik\Plugins\Cohorts\Visualizations\Cohorts and adjusted to be more accurate.
     *
     * @param $columnValue
     * @return float|int|string
     */
    public static function getNumericValue($columnValue)
    {
        // If it's already numeric, we should be able to just return that
        if (is_numeric($columnValue)) {
            return $columnValue;
        }

        $columnValue = trim($columnValue);

        // If it's a percentage, just convert it to a float because some already have decimals and others don't
        if (is_string($columnValue) && strpos($columnValue, '%') === strlen($columnValue) - 1) {
            return floatval($columnValue);
        }

        $matches = [];
        $hundredth = 0;
        // Since currencies can use . and , differently, we need to be a little smarter
        // We know that cohorts uses decimal accuracy of 2, so we can remove the decimal and convert it to float
        if (preg_match('/(?<=\d)[\.||,]\d{2}$/', $columnValue, $matches)) {
            $match = $matches[0];
            $hundredth = floatval(preg_replace('/[,.]/', '', $match)) / 100;
            $columnValue = str_replace($match, '', $columnValue);
        }

        // If it's a time and has minutes, make sure that all amounts have a preceding 0 if less than 10
        // Sometimes, there will be hours and minutes, but not seconds. So, check if min is the end of the string
        if (strpos($columnValue, ' min ') !== false || (strpos($columnValue, ' min') === strlen($columnValue) - 4)) {
            $columnValue = self::preFormatTimeString($columnValue);
        }

        // Remove all non-numeric characters since the decimal should already be removed
        $columnValue = preg_replace('/[^0-9]/', '', $columnValue);
        $columnValue = trim($columnValue);

        // Once the integer portion is converted to float, add the decimal back
        return floatval($columnValue) + $hundredth;
    }

    private static function preFormatTimeString(string $timeString): string{
        $parts = explode(' ', $timeString);
        $newString = '';

        // If no seconds are present, add them
        if (!preg_match('/^[0-9]{1,2}s/', $parts[count($parts) - 1])) {
            $parts[] = '0s';
        }

        foreach ($parts as $part) {
            $isNumeric = is_numeric($part);
            $numericPart = $isNumeric ? $part : preg_replace('/[^0-9]/', '', $part);
            // If the part has no numeric values, just append and move on
            if ((empty($numericPart) && $numericPart !== '0') || !is_numeric($numericPart)) {
                $newString .= $part;
                continue;
            }

            // If the number is already greater than 10, we're good to go. Append and move on
            $intPart = intval($numericPart);
            if ($intPart >= 10) {
                $newString .= $part;
                continue;
            }

            // Since the number is less than 10, let's prepend a 0 to make it consistent once non-numerics are removed
            $newString .= str_replace($numericPart, '0' . $numericPart, $part);
        }

        return $newString;
    }
}
