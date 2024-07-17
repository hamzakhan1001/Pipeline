<?php 
/**
 * Plugin Name: Extra Tools (Matomo Plugin)
 * Plugin URI: http://plugins.matomo.org/ExtraTools
 * Description: Adds automatic installation from the console, db backups etc.
 * Author: Digitalist, Mikke Schirén
 * Author URI: https://www.digitalist.se/matomo
 * Version: 5.0.3
 */
?><?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link http://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\ExtraTools;

 
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

class ExtraTools extends \Piwik\Plugin
{
    /**
     * @see Piwik\Plugin::registerEvents
     */
    public function registerEvents()
    {
        return array(
            'Translate.getClientSideTranslationKeys' => 'getClientSideTranslationKeys',
        );
    }

    public function getClientSideTranslationKeys(&$translationKeys)
    {
        $translationKeys[] = 'ExtraTools_ExtraTools';
        $translationKeys[] = 'ExtraTools_Documentation';
        $translationKeys[] = 'ExtraTools_Invalidations';
        $translationKeys[] = 'ExtraTools_PhpInfo';
    }
}
