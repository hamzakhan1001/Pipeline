<?php 
/**
 * Plugin Name: Security Info (Matomo Plugin)
 * Plugin URI: http://plugins.matomo.org/SecurityInfo
 * Description: Provides security information about your PHP environment and offers suggestions based on PhpSecInfo from the PHP Security Consortium.
 * Author: Matomo
 * Author URI: https://matomo.org
 * Version: 5.0.4
 */
?><?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\SecurityInfo;

/**
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

class SecurityInfo extends \Piwik\Plugin
{
    /**
     * @see \Piwik\Plugin::registerEvents
     */
    public function registerEvents()
    {
        return array(
            'AssetManager.getStylesheetFiles' => 'getStylesheetFiles',
            'Translate.getClientSideTranslationKeys' => 'getClientSideTranslationKeys',
        );
    }

    public function getStylesheetFiles(&$stylesheets)
    {
        $stylesheets[] = "plugins/SecurityInfo/stylesheets/securityinfo.less";
    }

    public function getClientSideTranslationKeys(&$keys)
    {
        $keys[] = 'SecurityInfo_SecurityInformation';
        $keys[] = 'SecurityInfo_PluginDescription';
        $keys[] = 'SecurityInfo_Test';
        $keys[] = 'SecurityInfo_Result';
    }
}
