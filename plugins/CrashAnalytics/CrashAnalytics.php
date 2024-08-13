<?php 
/**
 * Plugin Name: Crash Analytics (Matomo Plugin)
 * Plugin URI: https://plugins.matomo.org/CrashAnalytics
 * Description: Detect crashes to improve the user experience, increase conversions and recover revenue. Resolve them with insights to minimise developer hours.
 * Author: InnoCraft
 * Author URI: https://plugins.matomo.org/CrashAnalytics
 * Version: 5.0.2
 */
?><?php
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

use Piwik\Common;
use Piwik\Config;
use Piwik\Container\StaticContainer;
use Piwik\Http;
use Piwik\Piwik;
use Piwik\Plugins\CrashAnalytics\Dao\LogCrash;
use Piwik\Plugins\CrashAnalytics\Dao\LogCrashEvent;
use Piwik\Plugins\CrashAnalytics\Dao\LogCrashGroup;
use Piwik\Plugins\CrashAnalytics\Dao\LogCrashStack;
use Piwik\Plugins\CrashAnalytics\Fake\FakeErrors;
use Piwik\Plugins\CrashAnalytics\Tracker\BrowserInconsistencies;
use Piwik\Plugins\CrashAnalytics\Tracker\RequestProcessor;
use Piwik\Plugins\Live\Live;

 
if (defined( 'ABSPATH')
&& function_exists('add_action')) {
    $path = '/matomo/app/core/Plugin.php';
    if (defined('WP_PLUGIN_DIR') && WP_PLUGIN_DIR && file_exists(WP_PLUGIN_DIR . $path)) {
        require_once WP_PLUGIN_DIR . $path;
    } elseif (defined('WPMU_PLUGIN_DIR') && WPMU_PLUGIN_DIR && file_exists(WPMU_PLUGIN_DIR . $path)) {
        require_once WPMU_PLUGIN_DIR . $path;
    } else {
        return;
    }
    add_action('plugins_loaded', function () {
        if (function_exists('matomo_add_plugin')) {
            matomo_add_plugin(__DIR__, __FILE__, true);
        }
    });
}

class CrashAnalytics extends \Piwik\Plugin
{
    const LIMIT_IGNORED_HASHES_IN_TRACKER = 200;
    const TRACKER_READY_HOOK_NAME = '/*!! crashAnalyticsTrackerReadyHook */';
    const TRACKER_READY_HOOK_NAME_WHEN_MINIFIED = '/*!!! crashAnalyticsTrackerReadyHook */';
    const RATE_OF_PAGEVIEW_CRASH_FOR_ENTERPRISE_DEMO = 3; // 3%

    /**
     * @var \Faker\Generator
     */
    private static $enterpriseDemoFaker;

    public function registerEvents()
    {
        return [
            'CronArchive.getArchivingAPIMethodForPlugin' => 'getArchivingAPIMethodForPlugin',
            'Metrics.getDefaultMetricTranslations' => 'addMetricTranslations',
            'Metrics.getDefaultMetricDocumentationTranslations' => 'getDefaultMetricDocumentationTranslations',
            'Metrics.getDefaultMetricSemanticTypes' => 'addMetricSemanticTypes',
            'VisitorGenerator.VisitsFake.trackVisit' => 'trackFakeCrashes',
            'AssetManager.getJavaScriptFiles' => 'getJsFiles',
            'AssetManager.getStylesheetFiles' => 'getStylesheetFiles',
            'Translate.getClientSideTranslationKeys' => 'getClientSideTranslationKeys',
            'Tracker.Cache.getSiteAttributes' => 'getTrackerCacheSiteAttributes',
            'CustomJsTracker.manipulateJsTracker'  => 'modifyTrackerJs',
            'CustomReports.addDimensionsToIgnore' => 'addDimensionsToIgnore',
            'EnterpriseDemo.LiveVisitsFromLog.track' => 'trackFakeVisitsForEnterpriseDemo',
            'Template.jsGlobalVariables' => 'addJsGlobalVariables',
            'Db.getActionReferenceColumnsByTable' => 'addActionReferenceColumnsByTable',
        ];
    }

    public function addActionReferenceColumnsByTable(&$result)
    {
        $result['log_crash_event'] = ['idaction_resource_uri', 'idaction_url', 'idaction_name'];
    }

    public function addJsGlobalVariables(&$output)
    {
        $idSite = Common::getRequestVar('idSite', false, 'int');
        $isUserHasWriteAccess = $idSite > 0 ? Piwik::isUserHasWriteAccess($idSite) : false;

        $reArchiveReportsLastN = (int)(Config::getInstance()->General['rearchive_reports_in_past_last_n_months'] ?? 0);
        $globalVars = [
            'hasWriteAccess' => $isUserHasWriteAccess,
            'reArchiveReportsLastN' => $reArchiveReportsLastN,
        ];

        $output .= 'piwik.CrashAnalytics = ' . json_encode($globalVars) . ";\n";
    }

    public function addDimensionsToIgnore(&$dimensionsToIgnore)
    {
        $dimensionsToIgnore[] = 'CrashAnalytics.CrashVisit';
        $dimensionsToIgnore[] = 'CrashAnalytics.CrashPageview';
        $dimensionsToIgnore[] = 'CrashAnalytics.CrashIgnoredTime';
        $dimensionsToIgnore[] = 'CrashAnalytics.Crash';
    }

    public function getTrackerCacheSiteAttributes(&$content, $idSite)
    {
        $logCrash = StaticContainer::get(LogCrash::class);
        if (!isset($content['CrashAnalytics'])) {
            $content['CrashAnalytics'] = [];
        }

        $settings = new MeasurableSettings($idSite);
        $content['CrashAnalytics']['days_until_crash_considered_disappeared'] = $settings->daysUntilConsideredDisappeared->getValue();

        $content['CrashAnalytics']['ignored'] = $logCrash->getIgnoredCrashHashesForSite($idSite, self::getLimitIgnoredCrashesInTracker());

        $systemSettings = new SystemSettings();
        $content['CrashAnalytics']['versioning_url_parameters'] = $systemSettings->versioningUrlParameters->getValue();
        $content['CrashAnalytics']['group_hashed_source_files'] = (bool) $systemSettings->groupHashedSourceFiles->getValue();
    }

    public function modifyTrackerJs(&$content)
    {
        $logCrash = StaticContainer::get(LogCrash::class);
        $latestIgnoredCrashes = $logCrash->getLatestIgnoredCrashHashes(self::getLimitIgnoredCrashesInTracker());
        if (empty($latestIgnoredCrashes)) {
            return;
        }

        // add ignored crash hashes
        $ignoredCrashesSnippet = 'Piwik.CrashAnalytics.ignored.assign(' . json_encode($latestIgnoredCrashes) . ");";
        $replace = $ignoredCrashesSnippet . "\n";

        $content = str_replace(array(self::TRACKER_READY_HOOK_NAME_WHEN_MINIFIED, self::TRACKER_READY_HOOK_NAME), $replace, $content);
    }

    public function getClientSideTranslationKeys(&$translationKeys)
    {
        $translationKeys[] = 'CrashAnalytics_ClickToSeeAllCrashes';
        $translationKeys[] = 'CrashAnalytics_XCrashes';
        $translationKeys[] = 'CrashAnalytics_CrashDetails';
        $translationKeys[] = 'CrashAnalytics_FailedToLoadCrash';
        $translationKeys[] = 'CrashAnalytics_CrashDataMissing';
        $translationKeys[] = 'CrashAnalytics_SeeCrashDetails';
        $translationKeys[] = 'CrashAnalytics_Summary';
        $translationKeys[] = 'CrashAnalytics_Message';
        $translationKeys[] = 'CrashAnalytics_Type';
        $translationKeys[] = 'CrashAnalytics_Category';
        $translationKeys[] = 'CrashAnalytics_Source';
        $translationKeys[] = 'CrashAnalytics_RecentStackTrace';
        $translationKeys[] = 'CrashAnalytics_FirstSeen';
        $translationKeys[] = 'CrashAnalytics_LastSeen';
        $translationKeys[] = 'CrashAnalytics_LastReappeared';
        $translationKeys[] = 'CrashAnalytics_CopyCrashInformation';
        $translationKeys[] = 'CrashAnalytics_EmailCrashInformation';
        $translationKeys[] = 'CrashAnalytics_IgnoreThisCrash';
        $translationKeys[] = 'CrashAnalytics_Context';
        $translationKeys[] = 'CrashAnalytics_LineColumn';
        $translationKeys[] = 'CrashAnalytics_SeeCrashDetails';
        $translationKeys[] = 'CrashAnalytics_BrowserLanguage';
        $translationKeys[] = 'CrashAnalytics_BrowserPlugins';
        $translationKeys[] = 'CrashAnalytics_LastNActionsBeforeCrash';
        $translationKeys[] = 'CrashAnalytics_SourceAndStackTrace';
        $translationKeys[] = 'DevicesDetection_Device';
        $translationKeys[] = 'DevicesDetection_DeviceType';
        $translationKeys[] = 'DevicesDetection_ColumnBrowser';
        $translationKeys[] = 'DevicesDetection_ColumnOperatingSystem';
        $translationKeys[] = 'Resolution_ColumnResolution';
        $translationKeys[] = 'UsersManager_User';
        $translationKeys[] = 'CrashAnalytics_CrashContext';
        $translationKeys[] = 'CrashAnalytics_CrashDetailsVisitorLogDisabledMessage';
        $translationKeys[] = 'CrashAnalytics_CrashSummary';
        $translationKeys[] = 'CrashAnalytics_Message';
        $translationKeys[] = 'CrashAnalytics_Type';
        $translationKeys[] = 'CrashAnalytics_Location';
        $translationKeys[] = 'CrashAnalytics_LastActionsBeforeTheCrash';
        $translationKeys[] = 'CrashAnalytics_ContextInformation';
        $translationKeys[] = 'CrashAnalytics_CrashInformation';
        $translationKeys[] = 'CrashAnalytics_DateCrashOccurrence';
        $translationKeys[] = 'CrashAnalytics_Browser';
        $translationKeys[] = 'CrashAnalytics_OperatingSystem';
        $translationKeys[] = 'CrashAnalytics_Device';
        $translationKeys[] = 'CrashAnalytics_ThisCrashIgnoredOn';
        $translationKeys[] = 'CrashAnalytics_ConfirmIgnore';
        $translationKeys[] = 'CrashAnalytics_IgnoredCrashesWidget';
        $translationKeys[] = 'CrashAnalytics_ManageIgnoreIntro1';
        $translationKeys[] = 'CrashAnalytics_ManageIgnoreIntro2';
        $translationKeys[] = 'CrashAnalytics_IgnoredSince';
        $translationKeys[] = 'CrashAnalytics_NoCrashesIgnored';
        $translationKeys[] = 'CrashAnalytics_UnignoreThisCrash';
        $translationKeys[] = 'CrashAnalytics_ConfirmUnignore';
        $translationKeys[] = 'CrashAnalytics_ReplayThisSession';
        $translationKeys[] = 'CrashAnalytics_NoStackTraceFound';
        $translationKeys[] = 'CrashAnalytics_NoVisitsFoundForThisCrash';
        $translationKeys[] = 'CrashAnalytics_CrashContextDisabledMessage1';
        $translationKeys[] = 'CrashAnalytics_CrashContextDisabledMessage2';
        $translationKeys[] = 'CrashAnalytics_NotFound';
        $translationKeys[] = 'CrashAnalytics_RecentPageUrl';
        $translationKeys[] = 'CrashAnalytics_MergeCrashes';
        $translationKeys[] = 'CrashAnalytics_Merge';
        $translationKeys[] = 'CrashAnalytics_MergeSuccess';
        $translationKeys[] = 'CrashAnalytics_UnmergeCrashes';
        $translationKeys[] = 'CrashAnalytics_UnmergeThisCrash';
        $translationKeys[] = 'CrashAnalytics_UnmergeSuccess';
        $translationKeys[] = 'CrashAnalytics_Merging';
        $translationKeys[] = 'CrashAnalytics_MergeCrashesIntro1';
        $translationKeys[] = 'CrashAnalytics_EnterSearchTerm';
        $translationKeys[] = 'CrashAnalytics_CrashMessage';
        $translationKeys[] = 'CrashAnalytics_AreYouSureYouWantToMerge';
        $translationKeys[] = 'CrashAnalytics_UnmergeCrashesIntro';
        $translationKeys[] = 'CrashAnalytics_Messages';
        $translationKeys[] = 'CrashAnalytics_AreYouSureYouWantToUnmerge';
        $translationKeys[] = 'General_Previous';
        $translationKeys[] = 'General_Next';
        $translationKeys[] = 'CrashAnalytics_Inline';
        $translationKeys[] = 'CrashAnalytics_NoCrashesToMergeWith';
        $translationKeys[] = 'CrashAnalytics_CrashHasAlreadyBeenMerged';
        $translationKeys[] = 'CrashAnalytics_IfMergedTheseCrashesWillAppearAs';
        $translationKeys[] = 'CrashAnalytics_ThisWillOnlyApplyToFutureReports';
        $translationKeys[] = 'CrashAnalytics_ThisWillApplyToFutureReportsAndSomeInPast';
        $translationKeys[] = 'CrashAnalytics_InlineCrashesCannotBeMerged';
        $translationKeys[] = 'CrashAnalytics_NoCrashesMerged';
        $translationKeys[] = 'CrashAnalytics_GroupedHashTooltipInDetails';
    }

    public function getJsFiles(&$jsFiles)
    {
        $jsFiles[] = "plugins/CrashAnalytics/javascripts/LiveCrashDataTable.js";
    }

    public function getStylesheetFiles(&$stylesheets)
    {
        $stylesheets[] = "plugins/CrashAnalytics/stylesheets/live.less";
        $stylesheets[] = "plugins/CrashAnalytics/vue/src/CrashDetails/CrashDetails.less";
        $stylesheets[] = "plugins/CrashAnalytics/vue/src/CrashLog/CrashContextCard.less";
        $stylesheets[] = "plugins/CrashAnalytics/vue/src/CrashSourceLink/CrashSourceLink.less";
        $stylesheets[] = "plugins/CrashAnalytics/vue/src/CrashLog/CrashLog.less";
        $stylesheets[] = "plugins/CrashAnalytics/vue/src/CrashLog/SimplePeriodSelector.less";
        $stylesheets[] = "plugins/CrashAnalytics/vue/src/MergeCrashes/MergeCrashes.less";
        $stylesheets[] = "plugins/CrashAnalytics/vue/src/UnmergeCrashes/UnmergeCrashes.less";
        $stylesheets[] = "plugins/CrashAnalytics/vue/src/ManageIgnoredCrashes/ManageIgnoredCrashes.less";
    }

    public function trackFakeVisitsForEnterpriseDemo($matomoPhpEndpoint, $ua, $lang, $requestBody)
    {
        if (empty(self::$enterpriseDemoFaker)) {
            require_once __DIR__ . '/../VisitorGenerator/vendor/autoload.php';
            self::$enterpriseDemoFaker = \Faker\Factory::create('en_EN');
        }

        if (strpos($requestBody, 'action_name=') === false) { // only track crashes after pageviews
            return;
        }

        $faker = self::$enterpriseDemoFaker;

        $chanceOfCrash = defined('PIWIK_TEST_MODE') ? 100 : self::RATE_OF_PAGEVIEW_CRASH_FOR_ENTERPRISE_DEMO;
        if (!$faker->boolean($chanceOfCrash)) {
            return;
        }

        parse_str($requestBody, $requestBodyParams);
        if (empty($requestBodyParams['url'])) {
            return;
        }

        $pageUrl = parse_url($requestBodyParams['url']);
        if (empty($pageUrl['host'])) {
            return;
        }

        $siteUrl = ($pageUrl['scheme'] ?? 'https') . '://' . $pageUrl['host'] . '/';
        [$message, $crashType, $category, $stack, $resourceUri, $line, $column] = $this->getRandomCrashToTrack($faker, $siteUrl);

        // remove action_name since we're not tracking another pageview
        $requestBody = preg_replace('/(^|[?&])action_name=[^&]+/', '$1', $requestBody);

        $params = [
            'ca' => 1,
            RequestProcessor::TRACKING_PARAM_ERROR_MESSAGE => $message,
            RequestProcessor::TRACKING_PARAM_ERROR_STACK => $stack,
            RequestProcessor::TRACKING_PARAM_ERROR_CATEGORY => $category,
            RequestProcessor::TRACKING_PARAM_ERROR_TYPE => $crashType,
            RequestProcessor::TRACKING_PARAM_RESOURCE_URI => $resourceUri,
            RequestProcessor::TRACKING_PARAM_RESOURCE_LINE => $line,
            RequestProcessor::TRACKING_PARAM_RESOURCE_COLUMN => $column,
        ];

        foreach ($params as $name => $value) {
            if (!isset($value)) {
                continue;
            }

            $requestBody .= '&' . $name . '=' . urlencode($value);
        }

        Http::sendHttpRequestBy(
            Http::getTransportMethod(),
            $matomoPhpEndpoint,
            $timeout = 40,
            $ua,
            $path = null,
            $file = null,
            $follow = 0,
            $lang,
            $acceptInvalidSsl = false,
            $byteRange = false,
            $getExtendedInfo = false,
            $httpMethod = 'POST',
            $httpUsername = null,
            $httpPassword = null,
            $requestBody,
            $additionalHeaders = [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Content-Length' => strlen($requestBody),
            ]
        );
    }

    public function trackFakeCrashes(\MatomoTracker $t, \Faker\Generator $faker)
    {
        if (!$faker->boolean(50)) {
            return;
        }

        $t->clearCustomTrackingParameters();

        $pageUrl = parse_url($t->pageUrl);
        if (empty($pageUrl['host'])) {
            return;
        }

        $siteUrl = ($pageUrl['scheme'] ?? 'https') . '://' . $pageUrl['host'] . '/';
        [$message, $crashType, $category, $stack, $resourceUri, $line, $column] = $this->getRandomCrashToTrack($faker, $siteUrl);

        $url = $t->getUrlTrackCrash($message, $crashType, $category, $stack, $resourceUri, $line, $column);
        $t->storedTrackingActions[] = $url;
    }

    public function addMetricSemanticTypes(array &$types): void
    {
        $types = array_merge($types, Metrics::getMetricSemanticTypes());
    }

    public function addMetricTranslations(&$translations)
    {
        $translations = array_merge($translations, Metrics::getMetricTranslations());
    }

    public function getDefaultMetricDocumentationTranslations(&$translations)
    {
        $translations = array_merge($translations, Metrics::getMetricsDocumentationTranslations());
    }

    public function isTrackerPlugin()
    {
        return true;
    }

    // support archiving just this plugin via core:archive
    public function getArchivingAPIMethodForPlugin(&$method, $plugin)
    {
        if ($plugin == 'CrashAnalytics') {
            $method = 'CrashAnalytics.get';
        }
    }

    public function install()
    {
        $logCrashStack = new LogCrashStack();
        $logCrashStack->install();

        $logCrashGroup = new LogCrashGroup();
        $logCrashGroup->install();

        $logCrash = new LogCrash(new BrowserInconsistencies(), $logCrashGroup);
        $logCrash->install();

        $logCrashEvent = new LogCrashEvent($logCrashStack);
        $logCrashEvent->install();
    }

    public function uninstall()
    {
        $logCrashStack = new LogCrashStack();
        $logCrashStack->uninstall();

        $logCrashGroup = new LogCrashGroup();
        $logCrashGroup->uninstall();

        $logCrash = new LogCrash(new BrowserInconsistencies(), $logCrashGroup);
        $logCrash->uninstall();

        $logCrashEvent = new LogCrashEvent($logCrashStack);
        $logCrashEvent->uninstall();
    }

    public static function isCrashContextEnabledFor($idSite = null)
    {
        if (Live::isVisitorLogEnabled($idSite)) {
            return true;
        }

        $systemSettings = new SystemSettings();
        if ($systemSettings->disableCrashContext && $systemSettings->disableCrashContext->getValue()) {
            return false;
        }

        return true;
    }

    public static function getLimitIgnoredCrashesInTracker()
    {
        $result = null;
        try {
            $result = StaticContainer::get('CrashAnalytics.limitIgnoredHashesInTrackerCache');
        } catch (\Exception $ex) {
            // ignore
        }
        return $result ?: self::LIMIT_IGNORED_HASHES_IN_TRACKER;
    }

    private function getRandomCrashToTrack(\Faker\Generator $faker, $siteUrl)
    {
        $error = $faker->randomElement(FakeErrors::$errors);
        $message = $error['message'];
        $crashType = $error['crash_type'];

        $stack = null;
        $resourceUri = null;
        $line = null;
        $column = null;
        if ($faker->boolean(80)) {
            $errorStack = $faker->randomElement(FakeErrors::$stacks);
            $stack = $errorStack['stack'];
            $resourceUri = $errorStack['uri'];
            if (!preg_match('/^https?/', $resourceUri)) {
                $resourceUri = $siteUrl . $resourceUri;
            }

            $line = $errorStack['line'];
            $column = $errorStack['column'];
        }

        $category = null;
        if ($faker->boolean(33)) {
            $category = $faker->randomElement(FakeErrors::$categories);
        }

        return [$message, $crashType, $category, $stack, $resourceUri, $line, $column];
    }
}
