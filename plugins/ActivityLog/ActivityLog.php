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

namespace Piwik\Plugins\ActivityLog;

use Piwik\Access;
use Piwik\Common;
use Piwik\Piwik;
use Piwik\Plugins\ActivityLog\Activity\Manager;
use Piwik\Plugins\ActivityLog\Activity\PluginDeactivated;

class ActivityLog extends \Piwik\Plugin
{
    /**
     * Register all defined activities in event observer
     *
     * @return array
     */
    public function registerEvents()
    {
        $events = [
            'AssetManager.getStylesheetFiles' => 'getStylesheetFiles',
            'Translate.getClientSideTranslationKeys' => 'getClientSideTranslationKeys',
            'Db.getTablesInstalled' => 'getTablesInstalled',
            'API.CoreAdminHome.invalidateArchivedReports' => 'recordReportsInvalidatedForApiRequest',
            'Console.doRun' => 'checkConsoleCommandsToRecordReportsInvalidated'
        ];

        $activities = Manager::getInstance()->getMapOfEventToActivity();

        foreach ($activities as $event => $activityClass) {
            $events[$event] = [$activityClass, 'logEvent'];
        }

        return $events;
    }

    /**
     * Register the new tables, so Matomo knows about them.
     *
     * @param array $allTablesInstalled
     */
    public function getTablesInstalled(&$allTablesInstalled)
    {
        $allTablesInstalled[] = Common::prefixTable('activity_log');
    }

    /**
     * Post the event for recording the ReportsInvalidated activity. This expects the params from an API event.
     *
     * @param $eventData parameters from the API.CoreAdminHome.invalidateArchivedReports event
     * @return void
     */
    public function recordReportsInvalidatedForApiRequest(&$eventData)
    {
        Piwik::postEvent('InvalidateReports.invalidateReports', [&$eventData]);
    }

    /**
     * Should be executed when the Console.doRun event is triggered and checks if it's invalidating reports. If it is,
     * we post the event for recording the ReportsInvalidated activity.
     *
     * @param null|int $exitCode
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Input\OutputInterface $output
     * @return void
     * @throws \Exception
     */
    public function checkConsoleCommandsToRecordReportsInvalidated(&$exitCode, $input, $output)
    {
        // Make sure it's for invalidation, since we don't care about anything else.
        if (!$input->hasParameterOption('core:invalidate-report-data')) {
            return;
        }

        // Return if no dates were provided, since that's required.
        if (!$input->hasParameterOption('--dates')) {
            return;
        }

        // Stop if it's a dry run, since nothing actually got invalidated.
        if ($input->hasParameterOption('--dry-run')) {
            return;
        }

        // Set the parameter values using the parameter options or default values.
        $parameters = [
            'dates' => $input->getParameterOption('--dates'),
            'idSites' => $input->hasParameterOption('--sites') ? $input->getParameterOption('--sites') : 'all',
            'period' => $input->hasParameterOption('--periods') ? $input->getParameterOption('--periods') : 'all',
            'segment' => $input->hasParameterOption('--segment') ? $input->getParameterOption('--segment') : false,
            'cascadeDown' => $input->hasParameterOption('--cascade'),
            '_forceInvalidateNonexistent' => false,
            'plugin' => $input->hasParameterOption('--plugin') ? $input->getParameterOption('--plugin') : false,
            'ignoreLogDeletionLimit' => $input->hasParameterOption('--ignore-log-deletion-limit'),
        ];

        // Posting the event requires a logged in user while console uses anonymous user.
        Access::doAsSuperUser(function () use ($parameters) {
            Piwik::postEvent('InvalidateReports.invalidateReports', [$parameters]);
        });
    }

    public function isTrackerPlugin()
    {
        return true;
    }

    public function install()
    {
        $model = new Model();
        $model->install();
    }

    /**
     * Force logging when deactivating this plugin
     */
    public function deactivate()
    {
        $activity = new PluginDeactivated();
        $activity->logEvent('ActivityLog');
    }

    public function getStylesheetFiles(&$stylesheets)
    {
        $stylesheets[] = "plugins/ActivityLog/stylesheets/activitylog.less";
    }

    public function getClientSideTranslationKeys(&$translationKeys)
    {
        $translationKeys[] = "CorePluginsAdmin_Active";
        $translationKeys[] = "CorePluginsAdmin_Inactive";
        $translationKeys[] = "CorePluginsAdmin_Version";
        $translationKeys[] = "General_TrackingScopeAction";
        $translationKeys[] = "General_TrackingScopePage";
        $translationKeys[] = "General_TrackingScopeVisit";
        $translationKeys[] = "General_ColumnRevenue";
        $translationKeys[] = "General_Hour";
        $translationKeys[] = "General_Period";
        $translationKeys[] = "General_Report";
        $translationKeys[] = "General_Type";
        $translationKeys[] = "General_Plugin";
        $translationKeys[] = "General_Installed";
        $translationKeys[] = "General_NotInstalled";
        $translationKeys[] = "UsersManager_Email";
        $translationKeys[] = "UsersManager_PrivAdmin";
        $translationKeys[] = "UsersManager_PrivNone";
        $translationKeys[] = "UsersManager_PrivView";
        $translationKeys[] = "Live_GoalType";
        $translationKeys[] = "ScheduledReports_ReportFormat";
        $translationKeys[] = "SitesManager_Type";
        $translationKeys[] = "ActivityLog_Access";
        $translationKeys[] = "ActivityLog_FilterByUser";
        $translationKeys[] = "ActivityLog_ConsoleCommand";
        $translationKeys[] = "ActivityLog_System";
        $translationKeys[] = "ActivityLog_NoValueSet";
        $translationKeys[] = "ActivityLog_UserCountryWithIP";
        $translationKeys[] = "ActivityLog_UserCountry";
        $translationKeys[] = "ActivityLog_Capability";
        $translationKeys[] = "ActivityLog_SiteID";
        $translationKeys[] = 'ActivityLog_NoActivities';
        $translationKeys[] = 'ActivityLog_ActivityLog';
        $translationKeys[] = "ActivityLog_SiteIDs";
        $translationKeys[] = "ActivityLog_Dates";
        $translationKeys[] = "General_Segment";
        $translationKeys[] = "ActivityLog_CascadeDown";
        $translationKeys[] = "ActivityLog_ForceInvalidate";
        $translationKeys[] = "ActivityLog_Plugin";
        $translationKeys[] = "ActivityLog_IgnoreLogDeletionLimit";
        $translationKeys[] = "ActivityLog_ReportsInvalidated";
        $translationKeys[] = "ActivityLog_InvalidateReports";
        $translationKeys[] = "ActivityLog_GoogleClientConfig";
        $translationKeys[] = "ActivityLog_ClientId";
        $translationKeys[] = "ActivityLog_ProjectId";
        $translationKeys[] = "ActivityLog_RedirectUris";
        $translationKeys[] = "ActivityLog_JavascriptOrigins";
        $translationKeys[] = "ActivityLog_GoogleAnalyticsImport";
        $translationKeys[] = "ActivityLog_Property";
        $translationKeys[] = "ActivityLog_Account";
        $translationKeys[] = "ActivityLog_StreamIds";
        $translationKeys[] = "ActivityLog_ImportStartDate";
        $translationKeys[] = "ActivityLog_ImportEndDate";
        $translationKeys[] = "ActivityLog_LastDayImported";
        $translationKeys[] = "ActivityLog_LastDayArchived";
        $translationKeys[] = "ActivityLog_ReImports";
        $translationKeys[] = "ActivityLog_ExtraCustomDimensions";
        $translationKeys[] = "ActivityLog_None";
        $translationKeys[] = "ActivityLog_Dimension";
        $translationKeys[] = "ActivityLog_Scope";
        $translationKeys[] = "ActivityLog_TotalRecordsFound";
    }

    public static function supportsWriteRole()
    {
        // since Matomo 3.6.0
        return method_exists('Piwik\Piwik', 'checkUserHasSomeWriteAccess');
    }

    public static function checkPermission()
    {
        Piwik::checkUserIsNotAnonymous();

        $settings = new SystemSettings();
        $permissionLevel = $settings->viewPermission->getValue();

        switch ($permissionLevel) {
            case 'view':
                Piwik::checkUserHasSomeViewAccess();
                break;
            case 'write':
                if (self::supportsWriteRole()) {
                    Piwik::checkUserHasSomeWriteAccess();
                } else {
                    Piwik::checkUserHasSomeAdminAccess();
                }
                break;
            case 'admin':
                Piwik::checkUserHasSomeAdminAccess();
                break;
            case 'superuser':
                Piwik::checkUserHasSuperUserAccess();
                break;
        }
    }
}
