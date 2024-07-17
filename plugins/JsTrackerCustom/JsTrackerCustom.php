<?php 
/**
 * Plugin Name: Js Tracker Custom (Matomo Plugin)
 * Plugin URI: http://plugins.matomo.org/JsTrackerCustom
 * Description: This plugin allows you to add custom JavaScript to Matomos tracking code
 * Author: InnoCraft
 * Author URI: https://www.innocraft.com
 * Version: 5.0.1
 */
?><?php
/**
 * InnoCraft - the company of the makers of Piwik Analytics, the free/libre analytics platform
 *
 * @link https://www.innocraft.com
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */
namespace Piwik\Plugins\JsTrackerCustom;

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

class JsTrackerCustom extends Plugin
{
    public function registerEvents()
    {
        return [
            'Translate.getClientSideTranslationKeys' => 'getClientSideTranslationKeys',
        ];
    }

    public function getClientSideTranslationKeys(&$result)
    {
        $result[] = 'JsTrackerCustom_AddCustomJs';
        $result[] = 'JsTrackerCustom_JsTrackerCustom';
    }
}
