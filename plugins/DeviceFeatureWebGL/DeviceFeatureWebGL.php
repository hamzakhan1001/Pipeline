<?php 
/**
 * Plugin Name: Device Feature Web GL (Matomo Plugin)
 * Plugin URI: http://plugins.matomo.org/DeviceFeatureWebGL
 * Description: This plugin allows you to track browser compatibility for WebGL
 * Author: Stefan Giehl
 * Author URI: http://github.com/sgiehl/piwik-plugin-DeviceFeatureWebGL
 * Version: 5.0.0
 */
?><?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\DeviceFeatureWebGL;

use Piwik\DataTable;
use Piwik\Plugin;

/**
 *
 */
 
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

class DeviceFeatureWebGL extends Plugin
{
    /**
     * @see Plugin::registerEvents
     */
    public function registerEvents()
    {
        return [
            'API.DevicePlugins.getPlugin.end' => 'setWebGLTitle',
        ];
    }

    /**
     * @param $dataTable
     */
    public function setWebGLTitle($dataTable)
    {
        $dataTables = [];
        if ($dataTable instanceof DataTable\Map) {
            $dataTables = $dataTable->getDataTables();
        } else {
            if ($dataTable instanceof DataTable) {
                $dataTables = [$dataTable];
            }
        }

        foreach ($dataTables as $table) {
            $table->queueFilter(function ($dataTable) {
                $row = $dataTable->getRowFromLabel('Webgl');
                if ($row) {
                    $row->setColumn('label', 'WebGL');
                }
            });
        }
    }

    public function isTrackerPlugin()
    {
        return true;
    }
}
