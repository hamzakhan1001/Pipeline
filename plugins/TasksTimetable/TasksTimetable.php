<?php 
/**
 * Plugin Name: Tasks Timetable (Matomo Plugin)
 * Plugin URI: http://plugins.matomo.org/TasksTimetable
 * Description: List all maintenance tasks that are scheduled to run. Displays the task names and next execution time in a table.
 * Author: Megan Liang, Jay Deshpande, Matomo
 * Author URI: https://matomo.org
 * Version: 5.0.1
 */
?><?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\TasksTimetable;

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

class TasksTimetable extends \Piwik\Plugin
{

    public function registerEvents()
    {
        return [
            'Translate.getClientSideTranslationKeys' => 'getClientSideTranslationKeys',
       ];
    }

    public function getClientSideTranslationKeys(&$translations)
    {
        $translations[] = 'TasksTimetable_ScheduledTasks';
        $translations[] = 'TasksTimetable_Introduction';
        $translations[] = 'General_Name';
        $translations[] = 'General_Date';
        $translations[] = 'TasksTimetable_NothingScheduled';
    }
}
