<?php 
/**
 * Plugin Name: Diagnostics Extended (Matomo Plugin)
 * Plugin URI: http://plugins.matomo.org/DiagnosticsExtended
 * Description: Additional checks for the System Check
 * Author: Lukas Winkler
 * Author URI: https://lw1.at
 * Version: 0.2.0
 */
?><?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\DiagnosticsExtended;

use Piwik\Notification;
use Piwik\Piwik;

 
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

class DiagnosticsExtended extends \Piwik\Plugin
{
    public function registerEvents()
    {
        return [
            'Request.dispatch' => "addNotification"
        ];
    }

    public function addNotification(&$module, &$action, &$parameters)
    {
        if ($module == "Installation" && $action == "systemCheckPage") {
            $id = 'DiagnosticsExtended_Help';

            $notification = new Notification(Piwik::translate("DiagnosticsExtended_NotificationText",
                [
                    '<a href="https://forum.matomo.org/" target="_blank" rel="noopener">',
                    '</a>',
                    '<a href="https://github.com/Findus23/matomo-DiagnosticsExtended/issues" target="_blank" rel="noopener">',
                    '</a>'
                ]
            ));
            $notification->raw = true;
            $notification->title = Piwik::translate('DiagnosticsExtended_NotificationTitle');
            $notification->context = Notification::CONTEXT_INFO;
            \Piwik\Notification\Manager::notify($id, $notification);
        }
    }



}
