<?php
/**
 * Copyright (C) InnoCraft Ltd - All rights reserved.
 *
 * NOTICE:  All information contained herein is, and remains the property of InnoCraft Ltd.
 * The intellectual and technical concepts contained herein are protected by trade secret or copyright law.
 * Redistribution of this information or reproduction of this material is strictly forbidden
 * unless prior written permission is obtained from InnoCraft Ltd.
 *
 * You shall use this code only in accordance with the license agreement obtained from InnoCraft Ltd.
 *
 * @link    https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */

namespace Piwik\Plugins\AdvertisingConversionExport\Widgets;

use Piwik\API\Request;
use Piwik\Common;
use Piwik\Piwik;
use Piwik\Site;
use Piwik\Widget\WidgetConfig;

class ManageExports extends \Piwik\Widget\Widget
{
    public static function configure(WidgetConfig $config)
    {
        $idSite = Common::getRequestVar('idSite', 0, 'int');

        $config->setCategoryId('Goals_Goals');
        $config->setSubcategoryId('AdvertisingConversionExport_ConversionExports');
        $config->setIsNotWidgetizable();

        // hide menu item if no idSite is set or if the user doesn't have write access
        if (empty($idSite) || !Piwik::isUserHasWriteAccess($idSite)) {
            $config->disable();
            return;
        }

        $goals  = Request::processRequest('Goals.getGoals', ['idSite' => $idSite, 'filter_limit' => '-1'], $default = []);

        $config->setName('AdvertisingConversionExport_ConversionExports');

        // hide menu item if there are no goals and ecommerce is disabled
        if (!count($goals) && !Site::isEcommerceEnabledFor($idSite)) {
            $config->disable();
        }
    }
}
