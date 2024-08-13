<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\MultiChannelConversionAttribution;

use Piwik\Access;
use Piwik\Container\StaticContainer;
use Piwik\Updater;
use Piwik\Updates;

/**
 */
class Updates_4_2_1 extends Updates
{

    public function doUpdate(Updater $updater)
    {
        Access::doAsSuperUser(function() {
            $configuration = StaticContainer::get('Piwik\Plugins\MultiChannelConversionAttribution\Configuration');
            $systemSettings = new SystemSettings($configuration);
            $systemSettings->campaignDimensionCombinations->setValue([
                ['period' => 7, 'topLevel' => 'referer_name'],
                ['period' => 30, 'topLevel' => 'referer_name'],
                ['period' => 90, 'topLevel' => 'referer_name'],
            ]);
            $systemSettings->campaignDimensionCombinations->save();
        });
    }


}