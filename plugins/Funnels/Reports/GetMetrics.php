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

use Piwik\Access;
use Piwik\API\Request;
use Piwik\Common;
use Piwik\Container\StaticContainer;
use Piwik\DataTable;
use Piwik\NumberFormatter;
use Piwik\Piwik;
use Piwik\Plugin\ViewDataTable;
use Piwik\Plugins\CoreVisualizations\Visualizations\JqplotGraph\Evolution;
use Piwik\Plugins\CoreVisualizations\Visualizations\Sparklines;
use Piwik\Plugins\Funnels\Columns\Metrics\AbandonedRate;
use Piwik\Plugins\Funnels\Columns\Metrics\ConversionRate;
use Piwik\Plugins\Funnels\Funnels;
use Piwik\Plugins\Funnels\Metrics;
use Piwik\Plugins\Funnels\Model\FunnelNotFoundException;
use Piwik\Plugins\Funnels\Model\FunnelsModel;
use Piwik\Report\ReportWidgetFactory;
use Piwik\Widget\WidgetsList;

class GetMetrics extends Base
{
    protected function init()
    {
        parent::init();

        $this->name = Piwik::translate('Funnels_Flow');
        $this->dimension = null;
        $this->documentation = '';
        $this->order = 100;
        $this->metrics = array(
            Metrics::NUM_CONVERSIONS,
            Metrics::SUM_FUNNEL_ENTRIES,
            Metrics::SUM_FUNNEL_EXITS,
        );
        $this->processedMetrics = array(new ConversionRate(), new AbandonedRate());
    }

    private function getIdSite()
    {
        return Common::getRequestVar('idSite', null, 'int');
    }

    public function configureView(ViewDataTable $view)
    {
        $view->requestConfig->filter_limit = 5;
        $idGoal = Common::getRequestVar('idGoal', 0, 'int');
        $idFunnel = Common::getRequestVar('idFunnel', 0, 'int');
        $idSite = $this->getIdSite();

        $this->getValidator()->checkReportViewPermission($idSite);

        $view->config->columns_to_display = array_merge(array('label'), $this->metrics);
        if (!empty($idFunnel)) {
            $view->requestConfig->request_parameters_to_modify['idFunnel'] = $idFunnel;
        }
        if (FunnelsModel::isValidGoalId($idGoal)) {
            $view->requestConfig->request_parameters_to_modify['idGoal'] = $idGoal;
        }

        $view->config->show_goals = false;

        if ($view->isViewDataTableId(Evolution::ID)) {
            $view->config->add_total_row = false;

//            if ($this->getValidator()->canWrite($idSite)) {
//                $view->config->title_edit_entity_url = 'index.php' . Url::getCurrentQueryStringWithParametersModified(array(
//                    'module' => 'Goals',
//                    'action' => 'manage',
//                    'forceView' => null,
//                    'viewDataTable' => null,
//                    'showtitle' => null,
//                    'random' => null
//                ));
//            }
        } elseif ($view->isViewDataTableId(Sparklines::ID)) {
            /** @var Sparklines $view */
            $funnelsOverview = Common::getRequestVar('funnels_overview', 0, 'int');
            $goalOverview = Common::getRequestVar('goal_overview', 0, 'int');

            $funnel = null;
            // If there's an acutal goal ID, validate it. Otherwise, try looking up the funnel using the funnel ID
            if (FunnelsModel::isValidGoalId($idGoal) && intval($idGoal) !== 0) {
                $funnel = $this->getFunnel($idSite, $idGoal);
            }

            if (!empty($idFunnel) && empty($funnel)) {
                $funnel = $this->getNonGoalFunnel($idSite, $idFunnel);
            }

            if (empty($funnel)) {
                $funnel = $this->getFunnel($idSite, $idGoal);
                if (empty($funnel)) {
                    throw new FunnelNotFoundException();
                }
            }

            // here we configure the "funnel overview" in the goal detail page
            if ($goalOverview) {
                $view->config->setNotLinkableWithAnyEvolutionGraph();
                $view->config->title_attributes = array('piwik-funnel-page-link' => $funnel['idfunnel']);
                $view->config->show_footer_message = '<a class="openFunnelReport"
                href="#" piwik-funnel-page-link="' . (int) $funnel['idfunnel'] . '"
   ><span class="icon-show"></span> ' . Piwik::translate('Funnels_ViewFunnelReport') . '</a>';
            } elseif ($funnelsOverview) {
                // here we configure the sparklines for showing it in the "all funnels overview" page
                $view->config->title_attributes = array('piwik-funnel-page-link' => $funnel['idfunnel']);

                if (!empty($funnel['name'])) {
                    $view->config->title = $funnel['name'];
                }
            } else {
                // here we configure the sparklines for the funnel detail page
                $view->config->title = '';
            }

            $view->config->addTranslations(array(
                Metrics::NUM_CONVERSIONS => Piwik::translate('Funnels_NbFunnelConversions'),
                Metrics::RATE_CONVERSION => Piwik::translate('Funnels_RateFunnelConversion'),
            ));

            $numberFormatter = NumberFormatter::getInstance();
            $view->config->filters[] = function (DataTable $table) use ($numberFormatter, $idSite) {
                $firstRow = $table->getFirstRow();
                if ($firstRow) {
                    $conversionRate = $firstRow->getColumn('conversion_rate');
                    if (false !== $conversionRate) {
                        $firstRow->setColumn('conversion_rate', $numberFormatter->formatPercent($conversionRate, $precision = 1));
                    }

                    $conversions = $firstRow->getColumn('nb_conversions');
                    if (false !== $conversions) {
                        $firstRow->setColumn('nb_conversions', $numberFormatter->formatNumber($conversions));
                    }
                }
            };

            $view->config->addSparklineMetric(array(Metrics::RATE_CONVERSION), $order = 20);
            $view->config->addSparklineMetric(array(Metrics::NUM_CONVERSIONS), $order = 20);
        }
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

        $funnels = Request::processRequest('Funnels.getAllActivatedFunnelsForSite', ['idSite' => $idSite, 'filter_limit' => -1], $default = []);

        $funnelOverview = Piwik::translate('Funnels_FunnelX', Piwik::translate('General_Overview'));

        $overviewContainer = $factory->createContainerWidget('FunnelsOverview');
        $overviewContainer->setName(Piwik::translate('Funnels_FunnelsOverview'));
        $overviewContainer->setCategoryId(Funnels::MENU_CATEGORY);
        $overviewContainer->setSubcategoryId('General_Overview');
        $overviewContainer->setIsWidgetizable();
        $overviewContainer->setOrder(10);
        $widgetsList->addWidgetConfig($overviewContainer);

        // Sort the funnels by name
        $columnArray = array_column($funnels, 'name');
        array_multisort($columnArray, SORT_ASC, $funnels);

        $order = 0;
        foreach ($funnels as $funnel) {
            $order++;
            $config = $factory->createWidget();
            $config->setName(Piwik::translate('Funnels_EvolutionForGoalFunnelX', $funnel['name']));
            $config->forceViewDataTable(Evolution::ID);
            $config->setSubcategoryId($funnel['idfunnel']);
            $config->setAction('getEvolutionGraph');
            $config->setOrder(40);
            $config->setParameters(array('idGoal' => $funnel['idgoal'], 'columns' => Metrics::RATE_CONVERSION, 'idFunnel' => $funnel['idfunnel']));
            $config->setIsNotWidgetizable();
            $widgetsList->addWidgetConfig($config);

            $config = $factory->createWidget();
            $config->setName('');
            $config->forceViewDataTable(Sparklines::ID);
            $config->setSubcategoryId($funnel['idfunnel']);
            $config->setOrder(50);
            $config->setParameters(array('idGoal' => $funnel['idgoal'], 'idFunnel' => $funnel['idfunnel']));
            $config->setIsNotWidgetizable();
            $widgetsList->addWidgetConfig($config);

            $config = $factory->createWidget();
            $config->setName($funnel['name']);
            $config->setSubcategoryId($funnel['idfunnel']);
            $config->setAction('funnelSummary');
            $config->setOrder(5);
            $config->setParameters(array('idGoal' => $funnel['idgoal'], 'idFunnel' => $funnel['idfunnel']));
            $config->setIsNotWidgetizable();
            $widgetsList->addWidgetConfig($config);

            $config = $factory->createWidget();
            $config->setName($funnel['name']);
            $config->forceViewDataTable(Sparklines::ID);
            $config->setOrder($order);
            $config->setParameters(array('idGoal' => $funnel['idgoal'], 'funnels_overview' => '1', 'showtitle' => '1', 'idFunnel' => $funnel['idfunnel']));
            $config->setIsNotWidgetizable();
            $overviewContainer->addWidgetConfig($config);

            $config = $factory->createWidget();
            $config->setName($funnelOverview);
            $config->forceViewDataTable(Sparklines::ID);
            $config->setCategoryId('Goals_Goals');
            $config->setSubcategoryId($funnel['idgoal']);
            $config->setOrder(26);
            $config->setParameters(array('idGoal' => $funnel['idgoal'], 'goal_overview' => '1', 'idFunnel' => $funnel['idfunnel']));
            $config->setIsNotWidgetizable();
            $widgetsList->addWidgetConfig($config);
        }
    }

    public function configureReportMetadata(&$availableReports, $infos)
    {
        if (!$this->isEnabled()) {
            return;
        }

        $idSite = $this->getIdSiteFromInfos($infos);
        $funnels = Request::processRequest('Funnels.getAllActivatedFunnelsForSite', ['idSite' => $idSite, 'filter_limit' => -1], $default = []);

        $order = 111; // goals start at 50, we want to show them after goals
        foreach ($funnels as $funnel) {
            $order = $order + 2;

            $funnel['name'] = Common::sanitizeInputValue($funnel['name']);

            $this->name       = Piwik::translate('Funnels_FunnelXSummary', $funnel['name']);
            $this->parameters = [
                'idGoal' => $funnel['idgoal'],
            ];
            if (intval($this->parameters['idGoal']) === 0) {
                $this->parameters['idFunnel'] = $funnel['idfunnel'] ?? 0;
                unset($this->parameters['idGoal']);
            }
            $this->order      = 52.1 + $funnel['idgoal'] * 3;

            $availableReports[] = $this->buildReportMetadata();
        }

        // reset name etc
        $this->init();
    }

    public function getDefaultTypeViewDataTable()
    {
        return Evolution::ID;
    }

    private function getFunnel($idSite, $idGoal)
    {
        return Access::doAsSuperUser(function () use ($idSite, $idGoal) {
            return Request::processRequest('Funnels.getGoalFunnel', ['idSite' => $idSite, 'idGoal' => $idGoal], $default = []);
        });
    }

    private function getNonGoalFunnel($idSite, $idFunnel)
    {
        return Access::doAsSuperUser(function () use ($idSite, $idFunnel) {
            return Request::processRequest('Funnels.getFunnel', ['idSite' => $idSite, 'idFunnel' => $idFunnel], $default = []);
        });
    }
}
