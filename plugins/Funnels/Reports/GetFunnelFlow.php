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

namespace Piwik\Plugins\Funnels\Reports;

use Piwik\API\Request;
use Piwik\Common;
use Piwik\Container\StaticContainer;
use Piwik\Piwik;
use Piwik\Plugin\ViewDataTable;
use Piwik\Plugins\CoreVisualizations\Visualizations\HtmlTable;
use Piwik\Plugins\CoreVisualizations\Visualizations\JqplotGraph\Evolution;
use Piwik\Plugins\Funnels\Columns\Metrics\ProceededRate;
use Piwik\Plugins\Funnels\Columns\Step;
use Piwik\Plugins\Funnels\Metrics;
use Piwik\Report\ReportWidgetFactory;
use Piwik\Widget\WidgetsList;

class GetFunnelFlow extends Base
{
    protected function init()
    {
        parent::init();

        $this->name = Piwik::translate('Funnels_Flow');
        $this->dimension = new Step();
        $this->documentation = '';
        $this->order = 100;
        $this->metrics = [
            Metrics::NUM_STEP_VISITS,
            Metrics::NUM_STEP_ENTRIES,
            Metrics::NUM_STEP_EXITS,
            Metrics::NUM_STEP_PROGRESSIONS,
            Metrics::NUM_STEP_PROCEEDS,
            Metrics::NUM_STEP_SKIPS,
        ];
        $this->processedMetrics = array(new ProceededRate());
    }

    private function getValidator()
    {
        return StaticContainer::get('Piwik\Plugins\Funnels\Input\Validator');
    }

    public function configureWidgets(WidgetsList $widgetsList, ReportWidgetFactory $factory)
    {
        $idSite = Common::getRequestVar('idSite', 0, 'int');

        $validator = $this->getValidator();

        if (!$validator->canViewReport($idSite)) {
            return;
        }

        $funnels = $this->getAllActivatedFunnelsForSite($idSite);

        foreach ($funnels as $funnel) {
            // $config = $factory->createWidget();
            // $config->setName(Piwik::translate('Funnels_GoalFunnelReport'));
            // $config->forceViewDataTable(Evolution::ID);
            // $config->setSubcategoryId($funnel['idfunnel']);
            // $config->setAction('goalFunnelReport');
            // $config->setOrder(99);
            // $config->setParameters(['idGoal' => $funnel['idgoal'], 'idFunnel' => $funnel['idfunnel']]);
            // $config->setIsNotWidgetizable();
            // $widgetsList->addWidgetConfig($config);

            $config = $factory->createWidget();
            $config->setName(Piwik::translate('Funnels_FunnelReport'));
            $config->setSubcategoryId($funnel['idfunnel']);
            $config->setAction('funnelReport');
            $config->setOrder(20);
            $config->setParameters(['idGoal' => $funnel['idgoal'], 'idFunnel' => $funnel['idfunnel']]);
            $config->setIsWide();
            $config->setIsNotWidgetizable();
            $widgetsList->addWidgetConfig($config);
        }
    }

    public function configureView(ViewDataTable $view)
    {
        if (!empty($this->dimension)) {
            $view->config->addTranslations(array('label' => $this->dimension->getName()));
        }

        $view->config->addTranslation(Metrics::NUM_STEP_VISITS, Piwik::translate('General_ColumnNbVisits'));
        $view->config->addTranslation(Metrics::NUM_STEP_VISITS_ACTUAL, Piwik::translate('General_ColumnNbVisits'));

        $view->requestConfig->filter_limit = 5;

        $view->config->columns_to_display = array_merge(array('label'), $this->metrics);
        $view->requestConfig->request_parameters_to_modify['idFunnel'] = Common::getRequestVar('idFunnel', null, 'int');
        $view->config->show_goals = false;

        if ($view->isViewDataTableId(Evolution::ID)) {
            $view->config->add_total_row = false;
        }

        if ($view->isViewDataTableId(HtmlTable::ID)) {
            $view->config->title = '';
            $view->config->show_footer = false;
            $view->config->enable_sort = false;
        }
    }

    public function configureReportMetadata(&$availableReports, $infos)
    {
        if (!$this->isEnabled()) {
            return;
        }

        $idSite = $this->getIdSiteFromInfos($infos);
        $funnels = $this->getAllActivatedFunnelsForSite($idSite);

        $order = 111; // goals start at 50, we want to show them after goals
        foreach ($funnels as $funnel) {
            $order = $order + 2;

            $funnel['name'] = Common::sanitizeInputValue($funnel['name']);

            $this->name       = Piwik::translate('Funnels_FunnelXFlow', $funnel['name']);
            $this->parameters = [
                'idGoal' => $funnel['idgoal'],
            ];
            if (intval($this->parameters['idGoal']) === 0) {
                $this->parameters['idFunnel'] = $funnel['idfunnel'] ?? 0;
                unset($this->parameters['idGoal']);
            }
            $this->order      = 52.2 + $funnel['idgoal'] * 3;

            $availableReports[] = $this->buildReportMetadata();
        }

        // reset name etc
        $this->init();
    }

    public function getDefaultTypeViewDataTable()
    {
        return Evolution::ID;
    }

    protected function getAllActivatedFunnelsForSite($idSite)
    {
        return Request::processRequest('Funnels.getAllActivatedFunnelsForSite', [
            'idSite' => $idSite, 'filter_limit' => -1], $default = []);
    }
}
