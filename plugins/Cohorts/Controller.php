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

namespace Piwik\Plugins\Cohorts;

use Piwik\Common;
use Piwik\DataTable;
use Piwik\Date;
use Piwik\Period;
use Piwik\Piwik;
use Piwik\Plugins\Cohorts\Reports\GetCohorts;
use Piwik\Plugins\CoreVisualizations\Visualizations\JqplotGraph\Evolution;
use Piwik\Request;
use Piwik\Site;
use Piwik\ViewDataTable\Factory;

class Controller extends \Piwik\Plugin\Controller
{
    public function getEvolutionGraph()
    {
        $this->checkSitePermission();

        $cohortDates = $this->getCohortsEvolutionPeriods();
        $displayDateRange = $this->getDateRangeToDisplay($cohortDates);

        $period = Common::getRequestVar('period');

        /** @var Evolution $view */
        $view = Factory::build(Evolution::ID, 'Cohorts.getCohortsOverTime', 'Cohorts.getEvolutionGraph');
        $view->config->show_periods = false;
        $view->config->title = Piwik::translate('Cohorts_EvolutionGraph');
        $view->config->show_limit_control = false;

        if (property_exists($view->config, 'disable_comparison')) {
            $view->config->disable_comparison = true;
        }

        $metrics = GetCohorts::getAvailableCohortsMetrics($includeTemporary = false, $includeProcessed = true);
        $view->config->selectable_columns = $metrics;

        $view->requestConfig->request_parameters_to_modify['cohorts'] = $cohortDates;
        $view->requestConfig->request_parameters_to_modify['displayDateRange'] = $displayDateRange;
        // Set the lastN number so that the annotations don't try to load too many annotations and cause a JS error
        $view->config->custom_parameters['evolution_' . $period . '_last_n'] = $this->getTheLastNValueBasedOnPeriods($period, $cohortDates);

        $view->config->filters[] = [function (DataTable $table) use ($period) {
            GetCohorts::prettifyCohortsLabelsInTable($table, $period);
        }];

        // configure displayed columns
        $columns = Common::getRequestVar('columns', false);
        if (false !== $columns) {
            $columns = Piwik::getArrayFromApiParameter($columns);
        }
        if (false !== $columns) {
            $columns = !is_array($columns) ? array($columns) : $columns;
        }

        if (!empty($columns)) {
            $view->config->columns_to_display = $columns;
        } elseif (empty($view->config->columns_to_display)) {
            $view->config->columns_to_display = [GetCohorts::DEFAULT_METRIC];
        }

        // configure displayed rows
        $visibleRows = Common::getRequestVar('rows', false);
        if ($visibleRows !== false) {
            // this happens when the row picker has been used
            $visibleRows = Piwik::getArrayFromApiParameter($visibleRows);
            $visibleRows = array_map('urldecode', $visibleRows);
        } else {
            $firstRow = GetCohorts::prettifyCohortsLabel(explode(',', $cohortDates)[0], $period);
            $label = Common::getRequestVar('label', $firstRow);

            if (!empty($view->config->rows_to_display)) {
                $rows = $view->config->rows_to_display;
                $rows = !is_array($rows) ? [$rows] : $rows;
                $visibleRows = array_map('urldecode', $rows);
            } else {
                $visibleRows = [$label];
            }

            $view->requestConfig->request_parameters_to_modify['rows'] = $label;
        }
        $view->config->row_picker_match_rows_by = 'label';
        $view->config->rows_to_display = $visibleRows;

        // translations
        $translations = GetCohorts::getAvailableCohortsMetricsTranslations();
        foreach ($translations as $metric => $translation) {
            $view->config->addTranslation($metric, $translation);
        }

        return $this->renderView($view);
    }

    private function getCohortsEvolutionPeriods()
    {
        $request = Request::fromRequest();
        $date = $request->getStringParameter('date');
        $period = $request->getStringParameter('period');
        $filterLimit = $request->getIntegerParameter('filter_limit', -1);

        $cohortRanges = new CohortRanges();
        return $cohortRanges->getMultipleDateForCohortLength($date, $period, $filterLimit, true);
    }

    private function getDateRangeToDisplay($cohortDates)
    {
        $period = Common::getRequestVar('period');

        $cohortPeriodRange = Period\Factory::build($period, $cohortDates);
        if ($period == 'range') {
            return $cohortPeriodRange->getRangeString();
        }

        $cohortPeriods = $cohortPeriodRange->getSubperiods();

        $configuration = new Configuration();
        $periodsFromStart = $configuration->getPeriodsFromStartToShow();

        // Get today's date in the site's timezone so that we make sure that we show up to the correct date
        $idSite = Request::fromRequest()->getIntegerParameter('idSite');
        $today = Date::factoryInTimezone('today', Site::getTimezoneFor($idSite));

        $evolutionPeriodStart = reset($cohortPeriods)->getDateStart();
        $evolutionPeriodEnd = end($cohortPeriods)->getDateEnd()->addPeriod($periodsFromStart, $period);
        if ($evolutionPeriodEnd->isLater($today)) {
            $evolutionPeriodEnd = $today;
        }

        $evolutionPeriodDateStr = $evolutionPeriodStart->toString() . ',' . $evolutionPeriodEnd->toString();

        return $evolutionPeriodDateStr;
    }

    private function getTheLastNValueBasedOnPeriods(string $period, string $cohortDates): int{
        $cohortPeriodRange = Period\Factory::build($period, $cohortDates);
        $cohortPeriods = $cohortPeriodRange->getSubperiods();

        return count($cohortPeriods);
    }
}
