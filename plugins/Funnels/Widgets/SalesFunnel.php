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
 *
 */

namespace Piwik\Plugins\Funnels\Widgets;

use Piwik\Access;
use Piwik\API\Request;
use Piwik\Common;
use Piwik\Container\StaticContainer;
use Piwik\Site;
use Piwik\Tracker\GoalManager;
use Piwik\Widget\Widget;
use Piwik\Widget\WidgetConfig;

class SalesFunnel extends Widget
{
    public static function configure(WidgetConfig $config)
    {
        $config->setCategoryId('Goals_Ecommerce');
        $config->setSubcategoryId('General_Overview');
        $config->setName('Funnels_SalesFunnel');
        $config->setIsWide();
        $config->setIsNotWidgetizable();
        $config->setOrder(999);

        $idSite = Common::getRequestVar('idSite', 0, 'int');

        if (!$idSite || !Site::isEcommerceEnabledFor($idSite) || !self::getAccessValidator()->canWrite($idSite)) {
            $config->disable();
        }
    }

    private static function getAccessValidator()
    {
        return StaticContainer::get('Piwik\Plugins\Funnels\Input\Validator');
    }

    public function render()
    {
        $request = \Piwik\Request::fromRequest();
        $idSite = $request->getIntegerParameter('idSite');
        $isFunnelEdit = $request->getBoolParameter('isFunnelEdit', false);
        self::getAccessValidator()->checkWritePermission($idSite);

        $funnel = $this->getFunnel($idSite, GoalManager::IDGOAL_ORDER);
        $idFunnel = null;
        if (!empty($funnel['idfunnel'])) {
            $idFunnel = $funnel['idfunnel'];
        }

        $isFunnelEdit = $isFunnelEdit && !empty($idFunnel);

        $goals = [];
        $goalsResponse = Request::processRequest('Goals.getGoals', [
            'idSite' => $idSite, 'filter_limit' => -1
        ], $default = []);
        foreach ($goalsResponse as $goal) {
            // string is important to preselect correct value
            $goals[] = ['key' => (string) $goal['idgoal'], 'value' => $goal['name']];
        }

        return $this->renderTemplate('salesFunnel', array(
            'idFunnel' => $idFunnel,
            'isFunnelEdit' => $isFunnelEdit,
            'goals' => $goals,
        ));
    }

    private function getFunnel($idSite, $idGoal)
    {
        return Access::doAsSuperUser(function () use ($idSite) {
            return Request::processRequest('Funnels.getSalesFunnelForSite', ['idSite' => $idSite]);
        });
    }
}
