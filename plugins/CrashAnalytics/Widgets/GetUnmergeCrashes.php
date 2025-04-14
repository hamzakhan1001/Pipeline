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
 * @link https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */
namespace Piwik\Plugins\CrashAnalytics\Widgets;

use Piwik\Common;
use Piwik\Piwik;
use Piwik\Widget\Widget;
use Piwik\Widget\WidgetConfig;

class GetUnmergeCrashes extends Widget
{
    public static function configure(WidgetConfig $config)
    {
        $config->setCategoryId('CrashAnalytics_Crashes');
        $config->setSubcategoryId('CrashAnalytics_ManageCrashes');
        $config->setName('CrashAnalytics_UnmergeCrashes');
        $config->setParameters(array('showtitle' => 0));
        $config->setOrder(100);
        $config->setIsWide();
        $config->setIsNotWidgetizable();

        $idSite = Common::getRequestVar('idSite', 0, 'int');
        if (Piwik::isUserHasWriteAccess($idSite)) {
            $config->enable();
        } else {
            $config->disable();
        }
    }

    public function render()
    {
        $idSite = Common::getRequestVar('idSite', null, 'int');
        Piwik::checkUserHasWriteAccess($idSite);

        return '<div vue-entry="CrashAnalytics.UnmergeCrashes"></div>';
    }
}
