<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

namespace Piwik\Plugins\SEOWebVitals\Visualizations;

/**
 * DataTable Visualization that derives from HtmlTable and sets show_extra_columns to true.
 */
class DesktopStrategyTable extends AllStrategiesTable
{
    const ID = 'tableWebVitalsDesktopStrategy';
    const FOOTER_ICON       = 'plugins/Morpheus/icons/dist/devices/desktop.png';
    const FOOTER_ICON_TITLE = 'SEOWebVitals_DesktopOnly';

}
