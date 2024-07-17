<?php 
/**
 * Plugin Name: Admin Notification (Matomo Plugin)
 * Plugin URI: http://plugins.matomo.org/AdminNotification
 * Description: Adds the ability for Piwik administrators to include an informative message to all user's dashboards. This uses the built in Notification function.
 * Author: Josh Brule
 * Author URI: https://github.com/jbrule/piwikplugin-AdminNotification
 * Version: 5.0.0
 */
?><?php

namespace Piwik\Plugins\AdminNotification;

use Piwik\Piwik;
use Piwik\Notification;

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

class AdminNotification extends \Piwik\Plugin
{
    private static $hooks = array(
            'Login.authenticate.successful' => 'setNotificationV3', //Version 3.X Post login handler
            'SystemSettings.updated' => 'settingsChangedV3' //Version 3.X Setting updated handler
    );

    public function registerEvents()
    {
        return self::$hooks;
    }

    public function settingsChangedV3($settings)
    {
        if ($settings->getPluginName() === 'AdminNotification') {
            $this->setNotificationV3();
        }
    }

    public function setNotificationV3()
    {
            // Known issue. The alert notification is not updated until login/logout on v3.x.

            // 2.X Compatibility. This method appears to be getting called in v2.X which I didn't
            // believe would trigger the newer hooks.
        if (!class_exists('\Piwik\Settings\Plugin\SystemSettings')) { //If class doesn't exist just get out.
            return;
        }

            $settings = new SystemSettings();
            //print_r($settings->enabled->getValue());

        if ($settings->enabled->getValue()) {
            $notification = new Notification($settings->message->getValue());
            $notification->title = $settings->messageTitle->getValue();
            $notification->context = $settings->context->getValue();
            $notification->type = Notification::TYPE_PERSISTENT;
            //$notification->priority = Notification::PRIORITY_MAX;

            //echo "NOTIFY";
            //print_r($notification);

            Notification\Manager::notify('AdminNotification_notice', $notification);
        } else {
            //echo "NOTIFY CANCEL";
            Notification\Manager::cancel('AdminNotification_notice');
        }
    }
}
