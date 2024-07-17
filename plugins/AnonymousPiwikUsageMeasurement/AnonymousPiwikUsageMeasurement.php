<?php 
/**
 * Plugin Name: Anonymous Piwik Usage Measurement (Matomo Plugin)
 * Plugin URI: http://plugins.matomo.org/AnonymousPiwikUsageMeasurement
 * Description: Send anonymized usage data to your own Matomo instance or to any other Matomo
 * Author: Matomo
 * Author URI: https://matomo.org
 * Version: 5.0.1
 */
?><?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\AnonymousPiwikUsageMeasurement;

use Piwik\Common;
use Piwik\Container\StaticContainer;
use Piwik\Date;
use Piwik\Piwik;
use Piwik\Plugins\AnonymousPiwikUsageMeasurement\Tracker\Profiles;

 
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

class AnonymousPiwikUsageMeasurement extends \Piwik\Plugin
{
    const TRACKING_DOMAIN = 'https://demo-anonymous.matomo.org';
    const EXAMPLE_DOMAIN = 'http://example.com';

    private $profilingStack = array();

    /**
     * @see \Piwik\Plugin::registerEvents
     */
    public function registerEvents()
    {
        return array(
            'AssetManager.getJavaScriptFiles' => 'getJsFiles',
            'Template.jsGlobalVariables' => 'addMatomoClientTracking',
            'API.Request.dispatch' => 'logStartTimeOfApiCall',
            'API.Request.dispatch.end' => 'trackApiCall',
            'Db.getTablesInstalled' => 'getTablesInstalled'
        );
    }

    public function install()
    {
        $dao = new Profiles();
        $dao->install();
    }

    public function uninstall()
    {
        $dao = new Profiles();
        $dao->uninstall();
    }

    /**
     * Register the new tables, so Matomo knows about them.
     *
     * @param array $allTablesInstalled
     */
    public function getTablesInstalled(&$allTablesInstalled)
    {
        $allTablesInstalled[] = Common::prefixTable('usage_measurement_profiles');
    }

    public function logStartTimeOfApiCall(&$finalParameters, $pluginName, $methodName)
    {
        // API methods can call other API methods...
        $this->profilingStack[] = array(
            'method' => $pluginName . '.' . $methodName,
            'time' => microtime(true)
        );
    }

    public function trackApiCall(&$return, $endHookParams)
    {
        $endTime = microtime(true);

        $name = $endHookParams['module'];
        $method = $name . '.' . $endHookParams['action'];
        $neededTimeInMs = 0;

        do {
            $call = array_pop($this->profilingStack);

            // we need to make sure the call was actually for this method to not send wrong data.
            if ($method === $call['method']) {

                $neededTimeInMs = ceil(($endTime - $call['time']) * 1000);
                break;
            }

        } while (!empty($this->profilingStack));

        if (empty($neededTimeInMs)) {
            return;
        }

        $profiles = StaticContainer::get('Piwik\Plugins\AnonymousPiwikUsageMeasurement\Tracker\Profiles');

        $now = Date::now()->getDatetime();
        $category = 'API';

        $profiles->pushProfile($now, $category, $name, $method, $count = 1, (int) $neededTimeInMs);
    }

    public function getJsFiles(&$jsFiles)
    {
        $jsFiles[] = 'matomo.js';
        $jsFiles[] = 'plugins/AnonymousPiwikUsageMeasurement/javascripts/url.js';
        $jsFiles[] = 'plugins/AnonymousPiwikUsageMeasurement/javascripts/tracking.js';
    }

    public function addMatomoClientTracking(&$out)
    {
        $settings = StaticContainer::get(SystemSettings::class);
        $userSettings = StaticContainer::get(UserSettings::class);

        $config = array(
            'targets' => array(),
            'visitorCustomVariables' => array(),
            'trackingDomain' => self::TRACKING_DOMAIN,
            'exampleDomain' => self::EXAMPLE_DOMAIN,
            'userId' => Piwik::getCurrentUserLogin()
        );

        if (Piwik::isUserIsAnonymous()
            || !$settings->canUserOptOut->getValue()
            || $userSettings->userTrackingEnabled->getValue()) {
            // an anonymous user is currently always tracked, an anonymous user would not have permission to read
            // this user setting. The `isUserIsAnonymous()` check is not needed but there to improve performance
            // in case user is anonymous. Then we avoid checking whether user has access to any sites which can be slow
            // a user not having any view permission is also always tracked so far as such a user is not allowed to read
            // this setting
            $targets = StaticContainer::get('Piwik\Plugins\AnonymousPiwikUsageMeasurement\Tracker\Targets');
            $customVars = StaticContainer::get('Piwik\Plugins\AnonymousPiwikUsageMeasurement\Tracker\CustomVariables');

            $config['targets'] = $targets->getTargets();
            $config['visitorCustomVariables'] = $customVars->getClientVisitCustomVariables();
        }

        $out .= "\nvar piwikUsageTracking = " . json_encode($config) . ";\n";
    }

}
