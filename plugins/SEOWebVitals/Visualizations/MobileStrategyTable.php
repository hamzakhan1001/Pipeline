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
class MobileStrategyTable extends AllStrategiesTable
{
    public const ID = 'tableWebVitalsMobileStrategy';
    public const FOOTER_ICON       = 'plugins/Morpheus/icons/dist/devices/smartphone.png';
    public const FOOTER_ICON_TITLE = 'SEOWebVitals_MobileOnly';
}
