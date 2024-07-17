<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\MediaAnalytics\Widgets;

use Piwik\Config;
use Piwik\Piwik;
use Piwik\Plugins\MediaAnalytics\Configuration;
use Piwik\Widget\Widget;
use Piwik\Widget\WidgetConfig;
use Piwik\View;

class GetInfoTrackEvents extends Widget
{
    public static function configure(WidgetConfig $config)
    {
        $config->setCategoryId('MediaAnalytics_Media');

        $config->setSubcategoryId('General_Overview');
        $config->setName('');
        $config->setOrder(99999);
        $config->setIsWide();

        $configuration = new Configuration();
        // we need to show the widget only when event tracking is disabled
        if ($configuration->shouldEnableEventTrackingByDefault()) {
            $config->disable();
        }
    }

    /**
     * This method renders the widget. It's on you how to generate the content of the widget.
     * As long as you return a string everything is fine. You can use for instance a "Piwik\View" to render a
     * twig template. In such a case don't forget to create a twig template (eg. myViewTemplate.twig) in the
     * "templates" directory of your plugin.
     *
     * @return string
     */
    public function render()
    {
        return '<div vue-entry="CoreHome.Alert" severity="&quot;info&quot;">'
            . Piwik::translate('MediaAnalytics_DisableEventTrackingInfoMessage', array('<a href="https://matomo.org/faq/media-analytics/how-do-i-enable-tracking-of-all-media-events-by-default/" target="_blank">','</a>')).'</div>';
    }

}