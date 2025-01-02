<?php 
/**
 * Plugin Name: Tag Manager Extended (Matomo Plugin)
 * Plugin URI: http://plugins.matomo.org/TagManagerExtended
 * Description: Adds several useful tags, triggers and variables to the Tag Manager
 * Author: Openmost
 * Author URI: https://openmost.io/products/tag-manager-extended/
 * Version: 5.2.2
 */
?><?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\TagManagerExtended;

 
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

class TagManagerExtended extends \Piwik\Plugin
{
    public function registerEvents()
    {
        return array(
            'AssetManager.getStylesheetFiles' => 'getStylesheetFiles',
            'AssetManager.getJavaScriptFiles' => 'getJavaScriptFiles',
            'TagManager.filterTags' => 'filterTags',
            'TagManager.filterVariables' => 'filterVariables',
        );
    }

    public function getStylesheetFiles(&$files)
    {
        $files[] = "plugins/TagManagerExtended/stylesheets/style.less";
    }

    public function getJavaScriptFiles(&$files)
    {
        $files[] = "plugins/TagManagerExtended/javascripts/script.js";
    }

    public function filterTags(&$tags)
    {
        $found = false;
        foreach ($tags as $key => &$tag) {
            if (in_array($tag->getId(), ['Axeptio', 'CookieYes', 'Cookiebot', 'OneTrust', 'Hotjar', 'GoogleAdsConversion', 'GoogleAnalytics4Event', 'GoogleTag']) && $this->isPartOfTagManagerPlugin($tag)) {
                $found = true;
                unset($tags[$key]);
            }
        }

        if ($found) {
            $tags = array_values($tags);
        }
    }

    public function filterVariables(&$variables)
    {
        $found = false;
        foreach ($variables as $key => &$variable) {
            if (in_array($variable->getId(), ['ClickDataAttribute']) && $this->isPartOfTagManagerPlugin($variable)) {
                $found = true;
                unset($variables[$key]);
            }
        }

        if ($found) {
            $variables = array_values($variables);
        }
    }

    private function isPartOfTagManagerPlugin($object): bool
    {
        $classname = get_class($object);
        $parts = explode('\\', $classname);
        $pluginName = 'TagManager';

        if (count($parts) >= 4 && $parts[1] === 'Plugins') {
            $pluginName = $parts[2];
        }

        return $pluginName === 'TagManager';
    }
}
