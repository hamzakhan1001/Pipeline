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

use Piwik\Container\StaticContainer;
use Piwik\Piwik;
use Piwik\Plugin\ViewDataTable;
use Piwik\Plugins\CoreVisualizations\Visualizations\HtmlTable;
use Piwik\Plugins\Funnels\Columns\Step;
use Piwik\Plugins\Funnels\Metrics;
use Piwik\Report\ReportWidgetFactory;
use Piwik\Request;
use Piwik\Widget\WidgetsList;

class GetFunnelFlowTable extends GetFunnelFlow
{
    public const ROW_IDENTIFIER = 'customLabel';

    protected function init()
    {
        parent::init();

        $this->name = Piwik::translate('Funnels_FunnelDetails');
        $this->dimension = new Step();
        $this->documentation = '';
        $this->order = 200;
        // We have to use a custom label in order for the evolution to work with the prefixed label
        $this->rowIdentifier = self::ROW_IDENTIFIER;
    }

    public function configureWidgets(WidgetsList $widgetsList, ReportWidgetFactory $factory)
    {
        $idSite = Request::fromRequest()->getIntegerParameter('idSite', 0);

        $validator = StaticContainer::get('Piwik\Plugins\Funnels\Input\Validator');

        if (!$validator->canViewReport($idSite)) {
            return;
        }

        $funnels = $this->getAllActivatedFunnelsForSite($idSite);

        foreach ($funnels as $funnel) {
            $config = $factory->createWidget();
            $config->setName(Piwik::translate('Funnels_FunnelDetails'));
            $config->setSubcategoryId($funnel['idfunnel']);
            $config->setAction('funnelReportTable');
            $config->setOrder(30);
            $config->setParameters(['idGoal' => $funnel['idgoal'], 'idFunnel' => $funnel['idfunnel']]);
            $config->setIsWide();
            $config->setIsNotWidgetizable();
            $widgetsList->addWidgetConfig($config);
        }
    }

    public function configureView(ViewDataTable $view)
    {
        $view->config->show_footer = false;
        $view->config->enable_sort = false;

        $view->config->addTranslation('label', Piwik::translate('Funnels_Step'));
        $view->config->addTranslation(Metrics::NUM_STEP_VISITS, Piwik::translate('General_ColumnNbVisits'));
        $view->config->addTranslation(Metrics::NUM_STEP_ENTRIES, Piwik::translate('Funnels_Entries'));
        $view->config->addTranslation(Metrics::NUM_STEP_EXITS, Piwik::translate('Funnels_Exits'));
        $view->config->addTranslation(Metrics::NUM_STEP_PROCEEDS, Piwik::translate('Funnels_Proceeds'));
        $view->config->addTranslation(Metrics::NUM_STEP_SKIPS, Piwik::translate('Funnels_Skips'));
        $view->config->addTranslation(Metrics::NUM_STEP_PROGRESSIONS, Piwik::translate('Funnels_Progressions'));

        $view->config->metrics_documentation[Metrics::NUM_STEP_VISITS] = Piwik::translate('Funnels_ColumnNbStepVisitsDocumentationUpdated');
        $view->config->metrics_documentation[Metrics::NUM_STEP_ENTRIES] = Piwik::translate('Funnels_ColumnNbStepEntriesDocumentationUpdated');
        $view->config->metrics_documentation[Metrics::NUM_STEP_EXITS] = Piwik::translate('Funnels_ColumnNbStepExitsDocumentationUpdated');
        $view->config->metrics_documentation[Metrics::NUM_STEP_PROCEEDS] = Piwik::translate('Funnels_ColumnNbStepProceedsDocumentation');
        $view->config->metrics_documentation[Metrics::NUM_STEP_SKIPS] = Piwik::translate('Funnels_ColumnNbStepSkipsDocumentation');
        $view->config->metrics_documentation[Metrics::NUM_STEP_PROGRESSIONS] = Piwik::translate('Funnels_ColumnNbStepProgressionsDocumentation');

        $view->requestConfig->filter_sort_column = 'label';

        $view->config->disable_row_actions = 1;
        $view->config->datatable_js_type = 'FunnelStepDataTable';
    }

    public function configureReportMetadata(&$availableReports, $infos)
    {
        if (!$this->isEnabled()) {
            return;
        }

        // reset name etc
        $this->init();
    }

    public function getDefaultTypeViewDataTable()
    {
        return HtmlTable::ID;
    }
}
