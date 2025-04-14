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

namespace Piwik\Plugins\CrashAnalytics;

use Piwik\API\Request;
use Piwik\Common;
use Piwik\Piwik;
use Piwik\Plugin\Controller as PluginController;
use Piwik\Plugin\ReportsProvider;
use Piwik\Plugins\CrashAnalytics\Columns\Metrics\VisitsCrashRate;
use Piwik\Plugins\CrashAnalytics\Widgets\GetManageIgnoredCrashes;
use Piwik\Plugins\CrashAnalytics\Widgets\GetUnmergeCrashes;
use Piwik\Plugins\Live\Live;
use Piwik\Plugins\Live\Visualizations\VisitorLog;
use Piwik\View;

class Controller extends PluginController
{
    public function manage()
    {
        $widget = new GetManageIgnoredCrashes();
        $widgetContent = $widget->render();

        $unmergeCrashes = new GetUnmergeCrashes();
        $unmergeCrashesWidgetContent = $unmergeCrashes->render();

        return $this->renderTemplate('manage', [
            'widgetContent' => $widgetContent,
            'unmergeCrashesWidgetContent' => $unmergeCrashesWidgetContent,
        ]);
    }

    public function getEvolutionGraph()
    {
        $this->checkSitePermission();

        $columns = Common::getRequestVar('columns', false);
        if (false !== $columns) {
            $columns = Piwik::getArrayFromApiParameter($columns);
        }

        $view = $this->getLastUnitGraph($this->pluginName, __FUNCTION__, 'CrashAnalytics.get');

        if (!empty($columns)) {
            $view->config->columns_to_display = $columns;
        } elseif (empty($view->config->columns_to_display)) {
            $view->config->columns_to_display = array(Metrics::CRASH_OCCURRENCES, Metrics::NEW_CRASHES, VisitsCrashRate::METRIC_NAME);
        }

        $translations = Metrics::getMetricTranslations();
        foreach ($translations as $index => $translation) {
            $view->config->addTranslation($index, Piwik::translate($translation));
        }

        $view->config->documentation = Piwik::translate('General_EvolutionOverPeriod');

        return $this->renderView($view);
    }

    public function getCrashRecentActions()
    {
        $this->checkSitePermission();

        $isVisitorLogEnabled = Live::isVisitorLogEnabled($this->idSite);
        if (!$isVisitorLogEnabled) {
            return 'Visitor log disabled!';
        }

        if (!CrashAnalytics::isCrashContextEnabledFor($this->idSite)) {
            return 'Crash context disabled!';
        }

        $idLogCrashEvent = Common::getRequestVar('idLogCrashEvent', false, 'int');
        $idVisit = Common::getRequestVar('idVisit', false, 'int');

        $dataTable = Request::processRequest('Live.getLastVisitsDetails', [
            'segment' => 'visitId==' . $idVisit,
        ]);

        VisitorLog::groupActionsByPageviewId($dataTable);

        $row = $dataTable->getFirstRow();
        if (empty($row) || empty($row->getColumn('actionDetails'))) {
            return '<em>' . Piwik::translate('CrashAnalytics_NoActionsFoundForThisVisit') . '</em>';
        }

        $crashActions = new CrashActions();
        [$actionsBeforeCrash, $actionGroupsBeforeCrash] = $crashActions->getActionsBeforeCrash($idLogCrashEvent, $row->getColumns());

        $row->setColumn('actionDetails', $actionsBeforeCrash);
        $row->setColumn('actionGroups', $actionGroupsBeforeCrash);

        $view = new View('@Live/_actionsList.twig');
        $view->actionGroups = $row->getColumn('actionGroups');
        $view->visitInfo = $row;
        return $view->render();
    }
}
