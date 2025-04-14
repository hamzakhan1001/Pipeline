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

namespace Piwik\Plugins\MultiChannelConversionAttribution\Reports;

use Piwik\API\Request;
use Piwik\Common;
use Piwik\DataTable;
use Piwik\Piwik;
use Piwik\Plugins\CoreVisualizations\Visualizations\HtmlTable;
use Piwik\Plugin\ViewDataTable;
use Piwik\Plugins\MultiChannelConversionAttribution\Columns\Metrics\Conversion;
use Piwik\Plugins\MultiChannelConversionAttribution\Columns\ChannelType;
use Piwik\Plugins\MultiChannelConversionAttribution\Metrics;
use Piwik\View;
use Piwik\Plugins\MultiChannelConversionAttribution\Models;
use Piwik\Plugins\MultiChannelConversionAttribution\Columns\Metrics\AttributionComparison;
use Piwik\Plugins\MultiChannelConversionAttribution\Columns\Metrics\Revenue;
use Piwik\Plugin\ProcessedMetric;

class GetChannelAttribution extends Base
{
    /**
     * @var Models\Base
     */
    private $baseModel = null;
    /**
     * @var Models\Base[]
     */
    private $compareModels = array();

    protected function init()
    {
        $this->categoryId = 'Goals_Goals';

        $models = \Piwik\Request::fromRequest()->getStringParameter('attributionModels', '');
        $models = explode(',', $models);
        $this->compareModels = Models\Base::getByIds($models);

        $this->processedMetrics = array();
        $this->metrics = array();

        if (!empty($this->compareModels)) {
            $this->baseModel = array_shift($this->compareModels);
        } else {
            $this->baseModel = null;
        }

        if (!empty($this->baseModel)) {
            $this->defaultSortColumn = Metrics::completeAttributionMetric(Metrics::SUM_CONVERSIONS, $this->baseModel);
        }

        foreach (Models\Base::getAll() as $model) {
            $conversion = Metrics::completeAttributionMetric(Metrics::SUM_CONVERSIONS, $model);
            $revenue = Metrics::completeAttributionMetric(Metrics::SUM_REVENUE, $model);
            $this->metrics[] = $conversion;
            $this->metrics[] = $revenue;
            $this->processedMetrics[] = new Conversion($conversion, $model);
            $this->processedMetrics[] = new Revenue($revenue, $model);
        }

        if (isset($this->baseModel) && !empty($this->compareModels)) {
            foreach ($this->compareModels as $model) {
                $this->processedMetrics[] = new AttributionComparison(Metrics::SUM_CONVERSIONS, $this->baseModel, $model);
                $this->processedMetrics[] = new AttributionComparison(Metrics::SUM_REVENUE, $this->baseModel, $model);
            }
        }

        $this->dimension = new ChannelType();
        $this->name = Piwik::translate('MultiChannelConversionAttribution_MultiChannelConversionAttribution');
        $this->actionToLoadSubTables = $this->action;
        $this->order = 100;
    }

    private function requestsSubtable()
    {
        return \Piwik\Request::fromRequest()->getIntegerParameter('idSubtable', 0) > 0;
    }

    public function configureView(ViewDataTable $view)
    {
        // in case $_GET is set manually in widget, and the report instance was created before, we make sure it will be loaded
        $this->init();

        if (!empty($this->baseModel)) {
            $models = $this->compareModels;
            array_unshift($models, $this->baseModel);
        } else {
            $models = array();
        }

        $view->config->addTranslation('label', $this->dimension->getName());

        $view->config->columns_to_display = array('label');
        foreach ($models as $model) {
            $view->config->columns_to_display[] = Metrics::completeAttributionMetric(Metrics::SUM_CONVERSIONS, $model);
            $view->config->columns_to_display[] = Metrics::completeAttributionMetric(Metrics::SUM_REVENUE, $model);
        }

        if (empty($view->config->metrics_documentation)) {
            $view->config->metrics_documentation = array();
        }

        if (!empty($this->processedMetrics)) {
            foreach ($this->processedMetrics as $metric) {
                /** @var ProcessedMetric $metric */
                $name = $metric->getName();
                $view->config->addTranslation($name, $metric->getTranslatedName());
                $view->config->metrics_documentation[$name] = $metric->getDocumentation();
            }
        }

        $compareModels = $this->compareModels;
        $baseModel = $this->baseModel;

        $view->config->filters[] = function (DataTable $dataTable) use ($view, $compareModels, $baseModel) {
            if ($view->isViewDataTableId(HtmlTable::ID)) {
                $view->config->datatable_css_class = 'dataTableActions';
            }
            $metrics = array(Metrics::SUM_CONVERSIONS, Metrics::SUM_REVENUE);
            foreach ($dataTable->getRowsWithoutSummaryRow() as $row) {
                foreach ($compareModels as $compareModel) {
                    foreach ($metrics as $metric) {
                        $name = Metrics::completeAttributionMetric($metric, $compareModel);
                        $prefixName = 'html_column_' . $name .  '_suffix';
                        $value = $row->getColumn('comparison_' . $name);

                        if (!$value) {
                            $value = 0;
                        } else {
                            $value = $value * 100;
                            $value = round($value, 1);
                        }

                        if ($value < 0) {
                            $class = 'negativeEvolution';
                        } elseif ($value > 0) {
                            $class = 'positiveEvolution';
                        } else {
                            $class = 'positiveEvolution';
                            $value = 0;
                        }

                        if (isset($view->config->translations[$name])) {
                            $metricName = $view->config->translations[$name];
                        } else {
                            $metricName = $metric;
                        }

                        $title = Piwik::translate('MultiChannelConversionAttribution_XInComparisonToTooltip', array($metricName, $compareModel->getName(), $baseModel->getName()));
                        $value = '<span title="' . $title . '" class="' . $class . '" style="margin-left: 8px"> ' . $value . '%</span>';

                        $row->setMetadata($prefixName, $value);
                    }
                }
            }
        };
        $view->config->datatable_js_type = 'AttributionDataTable';
        $view->config->show_pagination_control = false;
        $view->config->show_offset_information = false;
        $view->config->show_insights = false;
        $view->config->show_tag_cloud = false;
        $view->config->show_table_all_columns = false;
        $view->config->show_exclude_low_population = false;
        $view->config->show_pie_chart = false;
        $view->config->show_bar_chart = false;
        $view->config->show_title = 0;
        $view->config->show_limit_control = true;
        $view->config->show_search = true;
        $view->config->search_recursive = true;
        $view->config->show_all_views_icons = false;

        $view->requestConfig->request_parameters_to_modify['idGoal'] = \Piwik\Request::fromRequest()->getIntegerParameter('idGoal', 0);
        $view->requestConfig->request_parameters_to_modify['attributionModels'] = \Piwik\Request::fromRequest()->getStringParameter('comparisonMetric', '');
        $view->config->custom_parameters['idGoal'] = $view->requestConfig->request_parameters_to_modify['idGoal'];
        $view->config->custom_parameters['attributionModels'] = $view->requestConfig->request_parameters_to_modify['attributionModels'];

        $view->config->subtable_controller_action = $this->actionToLoadSubTables;

        if ($view->isViewDataTableId(HtmlTable::ID)) {
            $view->config->show_embedded_subtable = true;

            if ($this->requestsSubtable()) {
                $view->config->disable_row_evolution = true; // couldn't make it work..
            }

            if (Request::shouldLoadExpanded()) {
                $view->config->show_expanded = true;
            }
        }
    }

    public static function isRequestingRowEvolutionPopover()
    {
        $action = \Piwik\Request::fromRequest()->getStringParameter('action', '');

        return $action === 'getRowEvolutionPopover' || $action === 'getRowEvolutionGraph';
    }

    public static function isRequestingGlossary()
    {
        return \Piwik\Request::fromRequest()->getStringParameter('action', '') === 'glossary'
            && \Piwik\Request::fromRequest()->getStringParameter('module', '') === 'API';
    }

    public function getMetricNamesToProcessReportTotals()
    {
        $metrics = array();
        foreach ($this->metrics as $metric) {
            if (strpos($metric, Metrics::SUM_CONVERSIONS) !== false) {
                $metrics[] = $metric;
            }
        }
        return $metrics;
    }

    public function configureReportMetadata(&$availableReports, $infos)
    {
        // we do only want to make it work for row evolution.
        if (self::isRequestingRowEvolutionPopover() || self::isRequestingGlossary()) {
            $idGoal = \Piwik\Request::fromRequest()->getIntegerParameter('idGoal', -2);
            $this->parameters = array('idGoal' => $idGoal);

            parent::configureReportMetadata($availableReports, $infos);

            $this->parameters = array();
        }

        // If this isn't for the API endpoint looking up report metadata, simply return
        if (\Piwik\Request::fromRequest()->getStringParameter('method', '') !== 'API.getReportMetadata') {
            return;
        }

        $paramOverride = [];
        if (isset($_GET['idSites']) && is_numeric($_GET['idSites'])) {
            // fix for mobile app not working due to no idSite being sent to below API requests
            $paramOverride['idSite'] = (int) $_GET['idSites'];
        }
        // Since it's the endpoint for getting metadata, let's get the metadata for all the goals and combinations
        $goals = Request::processRequest('Goals.getGoals', $paramOverride);
        $combinations = Request::processRequest('MultiChannelConversionAttribution.getAvailableCampaignDimensionCombinations', $paramOverride);
        // If there aren't any goals or combinations, return early
        if (empty($goals) || empty($combinations)) {
            return;
        }

        foreach ($goals as $goal) {
            $goalName = Common::sanitizeInputValue($goal['name']);
            $this->parameters = [
                'idGoal' => $goal['idgoal'],
            ];
            // This specific order formula was copied from plugins/Funnels/Reports/GetMetrics.php to ensure proper ordering
            // If this number is changed, the report won't be grouped with the correct goal
            $this->order      = 52.1 + $goal['idgoal'] * 3;

            // Include each combination for every goal
            foreach ($combinations as $combination) {
                // This makes a fractional change to the order to ensure that the combinations are in the correct order
                // Using an integer value moves the report too far and will no longer be grouped with the correct goal
                $this->order += (intval($combination['key']) * 0.1);
                $this->name = Piwik::translate('MultiChannelConversionAttribution_AttributionForGoalX', [$goalName, $combination['value']]);
                $this->parameters['idCampaignDimensionCombination'] = $combination['key'];
                $availableReports[] = $this->buildReportMetadata();
            }
        }

        $this->parameters = array();
    }

    public function render()
    {
        $rendered = parent::render();

        if (!empty($this->baseModel) && !$this->requestsSubtable()) {
            $headersToDisplay = array($this->baseModel->getName());
            $documentations = array($this->baseModel->getDocumentation());
            foreach ($this->compareModels as $model) {
                $headersToDisplay[] = $model->getName();
                $documentations[] = $model->getDocumentation();
            }

            $view = new View('@MultiChannelConversionAttribution/tableHeader');
            $view->headersToDisplay = $headersToDisplay;
            $view->documentations = $documentations;
            $row = $view->render();
            $rendered = str_replace('<thead>', '<thead>' . $row, $rendered);
        }

        return $rendered;
    }

    public function isRequiresProfilableData()
    {
        return true;
    }
}
