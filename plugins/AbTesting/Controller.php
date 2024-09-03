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

namespace Piwik\Plugins\AbTesting;

use Piwik\API\Request;
use Piwik\Common;
use Piwik\Piwik;
use Piwik\Period;
use Piwik\Plugin\ReportsProvider;
use Piwik\Plugins\AbTesting\Input\AccessValidator;
use Piwik\Plugins\AbTesting\Model\Experiments;
use Exception;
use Piwik\Plugins\AbTesting\Reports\GetMetricsOverview;

class Controller extends \Piwik\Plugin\Controller
{
    /**
     * @var Metrics
     */
    private $metrics;

    /**
     * @var Metrics
     */
    private $experiments;

    /**
     * @var AccessValidator
     */
    private $access;

    public function __construct(Metrics $metrics, Experiments $experiments, AccessValidator $accessValidator)
    {
        parent::__construct();
        $this->metrics = $metrics;
        $this->experiments = $experiments;
        $this->access = $accessValidator;
    }

    public function manage()
    {
        $idSite = Common::getRequestVar('idSite');

        if (strtolower($idSite) === 'all') {
            // prevent fatal error... redirect to a specific site as it is not possible to manage for all sites
            $this->access->checkHasSomeWritePermission();
            $this->redirectToIndex('AbTesting', 'manage');
            exit;
        }

        $this->access->checkWritePermission($idSite);

        return $this->renderTemplate('manage', array('title' => Piwik::translate('AbTesting_Experiments')));
    }

    public function getMetricsOverview()
    {
        $this->checkSitePermission();
        $experiment = $this->initExperimentView();

        $report = ReportsProvider::factory($this->pluginName, 'getMetricsOverview');
        return $report->render();
    }

    public function getMetricDetails()
    {
        $this->checkSitePermission();
        $experiment = $this->initExperimentView();

        $report = ReportsProvider::factory($this->pluginName, 'getMetricDetails');
        return $report->render();
    }

    public function summary()
    {
        $this->access->checkReportViewPermission($this->idSite);

        $experiment = $this->initExperimentView();
        $isAdmin = $this->access->canWrite($this->idSite);

        $readable = Period\Factory::build($_GET['period'], $_GET['date']);
        $readablePeriod = $readable->getPrettyString();
        $configuration = new Configuration();

        return $this->renderTemplate('summary', array(
            'experiment' => $experiment,
            'isAdmin' => $isAdmin,
            'isEstimatedUniqueVisitorEnabled' => $configuration->shouldShowEstimatedUniqueVisitors(),
            'readablePeriod' => $readablePeriod
        ));
    }

    public function getEvolutionGraph($variationName = false, array $columns = array(), array $defaultColumns = array())
    {
        $this->checkSitePermission();

        if (empty($columns)) {
            $columns = Common::getRequestVar('columns', false);
            if (false !== $columns) {
                $columns = Piwik::getArrayFromApiParameter($columns);
            }
        }

        $experiment = $this->initExperimentView();

        // For evolution charts always use day period, as the request is actually a multi period request
        // In addition metrics like unique visitors might be unavailable when period is set to range
        $_GET['period'] = 'day';

        // The currentControllerAction needs to match the apiMethod so that the customised report ID is used when loading preferences
        $view = $this->getLastUnitGraph($this->pluginName, 'getMetricsOverview', 'AbTesting.getMetricsOverview');

        if (false !== $columns) {
            $columns = !is_array($columns) ? array($columns) : $columns;
        }

        if (!empty($columns)) {
            $view->config->columns_to_display = $columns;
        } elseif (empty($view->config->columns_to_display) && !empty($defaultColumns)) {
            $view->config->columns_to_display = $defaultColumns;
        }

        // If this is the first load of the widget see if the saved preferences should override the default metric
        if (GetMetricsOverview::DEFAULT_WIDGET_METRICS == $columns && !empty($view->config->custom_parameters['columns']) && \Piwik\Request::fromRequest()->getIntegerParameter('evolution_day_last_n', 0) === 0) {
            $view->config->columns_to_display = $view->config->custom_parameters['columns'];
        }

        $selectable = $this->metrics->getMetricOverviewNames($experiment['success_metrics'], true, AbTesting::shouldEnableUniqueVisitorMetricForcefully($experiment));
        $index = array_search('label', $selectable);
        if (false !== $index) {
            unset($selectable[$index]);
        }

        $view->config->selectable_columns = $selectable;

        // configure displayed rows
        $visibleRows = Common::getRequestVar('rows', false);
        if ($visibleRows !== false) {
            // this happens when the row picker has been used
            $visibleRows = Piwik::getArrayFromApiParameter($visibleRows);
            $visibleRows = array_map('urldecode', $visibleRows);

            // typeReferrer is redundant if rows are defined, so make sure it's not used
            $view->config->custom_parameters['typeReferrer'] = false;
        } else {
            // use $typeReferrer as default
            if ($variationName === false) {
                $variationName = Common::getRequestVar('variationName', false, 'string');
            }
            $label = $variationName;
            $total = Piwik::translate('General_Total');

            if (!empty($view->config->rows_to_display)) {
                $visibleRows = $view->config->rows_to_display;
            } else {
                $visibleRows = array($label);
            }

            $view->requestConfig->request_parameters_to_modify['rows'] = $label . ',' . $total;
        }
        $view->config->row_picker_match_rows_by = 'label';
        $view->config->rows_to_display = $visibleRows;
        $view->config->documentation = Piwik::translate('General_EvolutionOverPeriod');
        $view->config->show_periods = false;
        // Set the customised report ID so that it will be used when loading/saving preferences
        $view->config->report_id = 'AbTesting.getMetricsOverview_idExperiment--' . $experiment['idexperiment'];
        // Override this so that when the customer adjusts graph selections, it makes the call using the correct action
        $view->config->controllerAction = 'getEvolutionGraph';

        return $this->renderView($view);
    }

    private function initExperimentView()
    {
        $idExperiment = Common::getRequestVar('idExperiment', null, 'int');

        $experiment = $this->getExperiment($idExperiment, $this->idSite);

        if (empty($experiment)) {
            throw new Exception(Piwik::translate('AbTesting_ErrorExperimentDoesNotExist'));
        }

        if (empty($_GET['useDateUrl']) && !empty($experiment['date_range_string'])) {
            $parts = explode(',', $experiment['date_range_string']);

            if (count($parts) === 2 && isset($parts[0]) && isset($parts[1]) && $parts[0] === $parts[1]) {
                $_GET['period'] = 'day';
                $_GET['date'] = $parts[0];
                $this->strDate = $parts[0]; //strdate is null due to range, so when we change period from range to day we should update strDate too, else it throws 500 error
            } else {
                $_GET['period'] = 'range';
                $_GET['date'] = $experiment['date_range_string'];
            }
        }

        $_GET['disableLink'] = '1';

        return $experiment;
    }

    private function getExperiment($idExperiment, $idSite)
    {
        return Request::processRequest('AbTesting.getExperiment', [
            'idExperiment' => $idExperiment,
            'idSite' => $idSite,
        ], $default = []);
    }
}
