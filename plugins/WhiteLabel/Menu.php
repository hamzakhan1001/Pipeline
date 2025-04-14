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

namespace Piwik\Plugins\WhiteLabel;

use Piwik\Menu\MenuAdmin;
use Piwik\Menu\MenuTop;
use Piwik\Piwik;

class Menu extends \Piwik\Plugin\Menu
{
    /**
     * @var SystemSettings
     */
    private $settings;

    public function __construct(SystemSettings $settings)
    {
        $this->settings = $settings;
    }

    public function configureAdminMenu(MenuAdmin $menu)
    {
        if ($this->settings->marketplaceOnlySuperUser->getValue() && !Piwik::hasUserSuperUserAccess()) {
            $menu->remove('CorePluginsAdmin_MenuPlatform', 'Marketplace_Marketplace');
        }
    }

    public function configureTopMenu(MenuTop $menu)
    {
        parent::configureTopMenu($menu);
        if (
            !$this->settings->enableWhatsNewSection->getValue() ||
            (
                !empty($this->settings->brandName->getValue()) ||
                $this->settings->removeLinksToMatomo->getValue()
            )
        ) {
            $menu->remove('CoreAdminHome_WhatIsNew');
        }

        if (!$this->settings->enableHelpSection->getValue()) {
            $helpFeedbackKey = 'General_Help';
            $help = Piwik::translate($helpFeedbackKey);
            $menu->remove($help);
            $menu->remove($helpFeedbackKey);
        }
    }
}
