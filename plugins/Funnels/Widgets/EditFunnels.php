<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

namespace Piwik\Plugins\Funnels\Widgets;

use Piwik\API\Request;
use Piwik\Widget\WidgetConfig;

class EditFunnels extends \Piwik\Widget\Widget
{
    public static function configure(WidgetConfig $config)
    {
        $idSite = \Piwik\Request::fromRequest()->getIntegerParameter('idSite', 0);

        $config->setCategoryId('Funnels_Funnels');
        $config->setSubcategoryId('Funnels_ManageFunnels');
        $config->setName('Funnels_ManageFunnels');
        $config->setIsNotWidgetizable();

        if (empty($idSite)) {
            $config->disable();
            return;
        }

        $hasFunnels  = Request::processRequest('Funnels.hasAnyActivatedFunnelForSite', ['idSite' => $idSite, 'filter_limit' => '-1'], $default = []);

        if ($hasFunnels !== true) {
            $config->disable();
        }
    }
}
