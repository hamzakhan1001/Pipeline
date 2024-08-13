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
use Piwik\Archive;
use Piwik\Common;
use Piwik\DataTable;
use Piwik\Date;
use Piwik\Db;
use Piwik\Intl\Data\Provider\DateTimeFormatProvider;
use Piwik\Period\Factory;
use Piwik\Piwik;
use Piwik\Plugin\Metric;
use Piwik\Plugin\ReportsProvider;
use Piwik\Plugins\CrashAnalytics\Columns\Metrics\PageviewCrashRate;
use Piwik\Plugins\CrashAnalytics\Columns\Metrics\VisitsCrashRate;
use Piwik\Plugins\CrashAnalytics\Dao\LogCrash;
use Piwik\Plugins\CrashAnalytics\Dao\LogCrashEvent;
use Piwik\Plugins\CrashAnalytics\RecordBuilders\AllCrashes;
use Piwik\Plugins\CrashAnalytics\RecordBuilders\CrashesByCategory;
use Piwik\Plugins\CrashAnalytics\RecordBuilders\CrashesByPageTitle;
use Piwik\Plugins\CrashAnalytics\RecordBuilders\CrashesByPageUrl;
use Piwik\Plugins\CrashAnalytics\RecordBuilders\CrashesBySource;
use Piwik\Plugins\CrashAnalytics\RecordBuilders\DisappearedCrashes;
use Piwik\Plugins\Live\Live;
use Piwik\Plugins\Live\Model as LiveModel;
use Piwik\Plugins\Live\Visualizations\VisitorLog;
use Piwik\Segment;
use Piwik\Site;
use Piwik\Tracker\Cache;

require_once PIWIK_INCLUDE_PATH . '/plugins/DevicesDetection/functions.php';

/**
 * The <a href='http://plugins.matomo.org/CrashAnalytics' target='_blank'>Crash Analytics</a> API lets you 1) ignore/unignore crashes tracked
 * by Matomo 2) request information about individual crashes and 3) request all your Crash Analytics reports and metrics.
 *
 * 1) You can ignore crashes so they will no longer be tracked, or unignore previously ignored crashes so they will
 * reappear again in your reports.
 * <br/><br/>
 * 2) You can merge different crashes together so they will be treated as a single crash in reports, or unmerge previously
 * merged groups. You can also get the list of all merged crash groups for a site.
 * <br/><br/>
 * 3) You can request summarized information about a single crash as well as query the entire list of raw tracked crash information:
 * <br/>- get a list of all the different crash types that were tracked via CrashAnalytics.getCrashTypes
 * <br/>- get the list of currently ignored crashes via CrashAnalytics.getIgnoredCrashes
 * <br/>- get summarized information about a single crash via CrashAnalytics.getCrashSummary
 * <br/>- get information about the actions that preceeded a crash via CrashAnalytics.getCrashVisitContext
 * <br/>- query every crash that has been tracked for a site via CrashAnalytics.getAllCrashes
 * <br/><br/>
 * 4) Request all metrics and reports about crashes that occur on your website:
 * <br/>- How often different crash messages appear and which source file originated them
 * <br/>- Which crashes have disappeared and not been seen in the last several days
 * <br/>- Which crashes have recently reappeared after an absence
 * <br/>- Which crashes are new and have never been seen before
 * <br/>- Which pages have the most crashes and what those crashes are
 * <br/>- Which source files generate the most crashes and what those crashes are
 * <br/>- Which crash categories appear the most and what crashes appear for those categories
 * <br/>- Which crashes originate from first party source files (in other words, source files hosted by your website)
 * <br/>- Which crashes originate from third party source files (in other words, source files from third party websites, generally outside your control)
 * <br/>- What crashes are currently occurring on your website, within the last N minutes
 * <br/>- Which of the crashes that are currently occurring are new
 * <br/>- Which of the crashes that are currently occurring were absent but have reappeared
 * <br/>- What crashes have just been absent long enough to be considered "disappeared"
 *
 * <br/><br/>And the following metrics:
 * <br/>- How many times a crash occurs
 * <br/>- How often a visit encounters at least one crash
 * <br/>- How many unique crashes were tracked
 * <br/>- How many new crashes were tracked
 * <br/>- How many crashes that were tracked were absent for some time, but have since reappeared
 * <br/>- How often a page view encounters at least one crash
 * <br/>- How many crashes are currently ignored
 *
 * @method static \Piwik\Plugins\CrashAnalytics\API getInstance()
 */
class API extends \Piwik\Plugin\API
{
    const MAX_LAST_N_HOURS = 12;
    const CRASH_DETAILS_NUM_ACTIONS_BEFORE_CRASH_TO_DISPLAY = 5;
    const MAX_GET_ALL_CRASHES_LIMIT = 10000;

    /**
     * @var RecordProcessing
     */
    private $recordProcessing;

    /**
     * @var LogCrashEvent
     */
    private $logCrashEvent;

    /**
     * @var LogCrash
     */
    private $logCrash;

    /**
     * @var LiveModel
     */
    private $liveModel;

    /**
     * @var Archive\ArchiveInvalidator
     */
    private $archiveInvalidator;

    public function __construct(RecordProcessing $recordProcessing, LogCrashEvent $logCrashEvent, LogCrash $logCrash,
                                LiveModel $liveModel, Archive\ArchiveInvalidator $archiveInvalidator)
    {
        $this->recordProcessing = $recordProcessing;
        $this->logCrashEvent = $logCrashEvent;
        $this->logCrash = $logCrash;
        $this->liveModel = $liveModel;
        $this->archiveInvalidator = $archiveInvalidator;
    }

    /**
     * @hide
     */
    public function searchCrashMessagesForMerge($idSite, $resourceUri = '', $searchTerm = '', $limit = 10, $offset = 0, $excludeIdLogCrashes = [])
    {
        Piwik::checkUserHasWriteAccess($idSite); // only used for merging crashes, so we check for write access instead of view

        $resourceUri = Common::unsanitizeInputValue($resourceUri);
        $searchTerm = Common::unsanitizeInputValue($searchTerm);

        if (is_string($excludeIdLogCrashes)) {
            $excludeIdLogCrashes = explode(',', $excludeIdLogCrashes);
        }

        $crashes = $this->logCrash->searchCrashMessagesForMerge($idSite, $searchTerm, $resourceUri, $limit, $offset, $excludeIdLogCrashes);
        return $crashes;
    }

    /**
     * Merges multiple crashes so they will be treated as the same crash in reports.
     *
     * @param int $idSite
     * @param int[] $idlogcrashes
     * @return void
     */
    public function mergeCrashes($idSite, $idLogCrashes)
    {
        Piwik::checkUserHasWriteAccess($idSite);

        $idlogcrashes = is_array($idLogCrashes) ? $idLogCrashes : implode(',', strval($idLogCrashes));
        $this->logCrash->mergeCrashes($idlogcrashes);

        $this->archiveInvalidator->reArchiveReport([$idSite], 'CrashAnalytics');
    }

    /**
     * Unmerge a previously merged crash group.
     *
     * @param int $idSite
     * @param int $idLogCrash
     * @return void
     */
    public function unmergeCrashGroup($idSite, $idLogCrash)
    {
        Piwik::checkUserHasWriteAccess($idSite);
        $this->checkIdLogCrash($idLogCrash);

        $this->logCrash->unmergeCrashGroup($idLogCrash);

        $this->archiveInvalidator->reArchiveReport([$idSite], 'CrashAnalytics');
    }

    /**
     * Gets every merged crash group for a site.
     *
     * @param int $idSite
     * @return array
     */
    public function getCrashGroups($idSite)
    {
        Piwik::checkUserHasWriteAccess($idSite);

        $crashGroups = $this->logCrash->getCrashGroups($idSite);

        foreach ($crashGroups as &$crashes) {
            foreach ($crashes as &$crash) {
                $this->enrichCrash($crash);
            }
        }

        return $crashGroups;
    }

    /**
     * Gets the list of unique crash types that were tracked for a specific site.
     *
     * @param int $idSite
     * @param int $filter_limit
     * @return string[]
     */
    public function getCrashTypes($idSite, $filter_limit = false)
    {
        Piwik::checkUserHasViewAccess($idSite);

        $crashTypes = $this->logCrash->getUniqueCrashTypes($idSite, $filter_limit);
        return $crashTypes;
    }

    /**
     * Set whether a crash should be ignored when tracking or whether it should no longer be ignored.
     *
     * @param int $idSite
     * @param int $idLogCrash
     * @param bool|int $ignore If true or non-zero, the crash will be ignored. Ignored crashes are not
     *                         logged when encountered during tracking. If false or 0, the crash will
     *                         be unignored.
     * @return void
     */
    public function setIgnoreCrash($idSite, $idLogCrash, $ignore = true)
    {
        Piwik::checkUserHasWriteAccess($idSite);
        $this->checkIdLogCrash($idLogCrash);

        $crashUpdated = $this->logCrash->setCrashIgnore($idSite, $idLogCrash, (bool)$ignore);
        if ($crashUpdated) {
            Cache::regenerateCacheWebsiteAttributes($idSite);

            Piwik::postEvent('CustomJsTracker.updateTracker');
        }
    }

    /**
     * Get the list of currently ignored crashes for a site.
     *
     * @param int $idSite
     * @return array The list of ignored crashes. Each entry contains information about the specific crash,
     *               including the crash message, originating source and other information.
     * @throws \Exception
     */
    public function getIgnoredCrashes($idSite)
    {
        Piwik::checkUserHasViewAccess($idSite);

        $crashes = $this->logCrash->getIgnoredCrashesForSite($idSite);
        foreach ($crashes as &$crash) {
            $this->enrichCrash($crash);
        }
        return $crashes;
    }

    /**
     * Gets information for a specific crash including it's message, originating source and other information,
     * if one can be found. The most recently tracked crash and page URL that encountered the crash will
     * also be included.
     *
     * Note: if all crash events for a crash have been deleted or purged, then it is possible that
     * no crash event will exist for a crash. In all other cases, however, the information should
     * exist.
     *
     * @param int $idSite
     * @param int $idLogCrash
     * @return array
     * @throws \Exception
     */
    public function getCrashSummary($idSite, $idLogCrash)
    {
        Piwik::checkUserHasViewAccess($idSite);
        $this->checkIdLogCrash($idLogCrash);

        $crash = $this->logCrash->getCrash($idSite, $idLogCrash);
        if (empty($crash)) {
            throw new \Exception(Piwik::translate('CrashAnalytics_CrashDoesNotExist'));
        }

        $this->enrichCrash($crash);

        $summary = [
            'idlogcrash' => $crash['idlogcrash'],
            'group_idlogcrash' => $crash['group_idlogcrash'],
            'message' => $crash['message'],
            'crash_type' => $crash['crash_type'],
            'resource_uri' => $crash['resource_uri'],
            'resource_line' => $crash['resource_line'],
            'resource_column' => $crash['resource_column'],
            'stack_trace' => $crash['stack_trace'],
            'datetime_first_seen' => $crash['datetime_first_seen'],
            'datetime_first_seen_pretty' => $crash['datetime_first_seen_pretty'],
            'datetime_last_seen' => $crash['datetime_last_seen'],
            'datetime_last_seen_pretty' => $crash['datetime_last_seen_pretty'],
            'datetime_last_reappeared' => $crash['datetime_last_reappeared'],
            'datetime_last_reappeared_pretty' => $crash['datetime_last_reappeared_pretty'],
            'datetime_ignored_error' => $crash['datetime_ignored_error'],
            'datetime_ignored_error_pretty' => $crash['datetime_ignored_error_pretty'],
        ];

        $crashEvent = $this->logCrashEvent->getMostRecentCrashEvent($idSite, $idLogCrash);
        if (!empty($crashEvent)) {
            $this->enrichCrashEvent($crashEvent);
            $summary['category'] = $crashEvent['category'];
            $summary['crash_page_url'] = $crashEvent['crash_page_url'];
        }

        return $summary;
    }

    /**
     * Gets the crash visit context, which includes information about the most recent visits that encountered the
     * crash and the actions that occurred just before the crash.
     *
     * The result of this method can differ based on settings in your Matomo. If the crash context is disabled
     * entirely, this method will simply return an error.
     *
     * If the crash context is enabled, but the visits log is disabled, then the information about the most recent visits
     * will be limited. The only information returned will be browser, operating system and device information. Information
     * about preceding actions will not be included.
     *
     * If the crash context and visits log are enabled, then full information will be available.
     *
     * @param int $idLogCrash
     * @param int $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @param int $filter_limit
     * @param int $filter_offset
     * @param bool|int $fetchRecentActions Whether to fetch the most recent actions or not. By default they are fetched,
     *                                     but you may want to skip this for performance reasons.
     * @return array
     * @throws \Exception
     */
    public function getCrashVisitContext($idLogCrash, $idSite, $period, $date, $segment = false, $filter_limit = 5, $filter_offset = 0, $fetchRecentActions = true)
    {
        Piwik::checkUserHasViewAccess($idSite);

        if ($idSite != (int)$idSite) {
            throw new \Exception("Only one idSite value is permitted for CrashAnalytics." . __FUNCTION__);
        }

        if (!CrashAnalytics::isCrashContextEnabledFor($idSite)) {
            throw new \Exception('Crash context display is currently disabled.');
        }

        // when visitor log is disabled, this method only returns the 5 more recent crashes on the day the latest crash occurred
        $isVisitorLogEnabled = Live::isVisitorLogEnabled($idSite);
        if (!$isVisitorLogEnabled) {
            $filter_limit = 5;
            $filter_offset = 0;
            $segment = false;
            $period = 'year';

            $crash = $this->logCrash->getCrash($idSite, $idLogCrash);
            if (empty($crash)) {
                return [];
            }

            $date = Date::factory($crash['datetime_last_seen'])->toString();
        }

        $timezone = Site::getTimezoneFor($idSite);

        $segmentObj = new Segment($segment, [$idSite]);
        $periodObj = Factory::makePeriodFromQueryParams($timezone, $period, $date);

        $crashes = $this->logCrashEvent->getLastCrashEventsInPeriod($idLogCrash, $idSite, $periodObj, $segmentObj, $filter_limit,
            $filter_offset, $isVisitorLogEnabled ? DateTimeFormatProvider::DATETIME_FORMAT_LONG : Date::DATE_FORMAT_LONG);
        if (empty($crashes)) {
            return $crashes;
        }

        $idVisits = array_column($crashes, 'idVisit');

        if ($isVisitorLogEnabled) {
            $idVisits = array_map(function ($id) { return 'visitId==' . $id; }, $idVisits);
            $idVisits = implode(',', $idVisits);

            /** @var DataTable $visits */
            $visits = Request::processRequest('Live.getLastVisitsDetails', [
                'idSite' => $idSite,
                'period' => $period,
                'date' => $date,
                'segment' => $idVisits,
                'filter_limit' => $filter_limit,
                'filter_offset' => $filter_offset,
                'doNotFetchActions' => !$fetchRecentActions,
            ]);

            VisitorLog::groupActionsByPageviewId($visits);

            $visitsByIdVisit = [];
            foreach ($visits->getRows() as $row) {
                $visitsByIdVisit[$row->getColumn('idVisit')] = $row->getColumns();
            }
        } else {
            // can't use the Live API in this case, so we query the log_visit table directly
            $visits = $this->queryMinimalVisitInfo($idVisits);
            $visitsByIdVisit = array_column($visits, null, 'idVisit');
        }

        $crashActions = new CrashActions();
        foreach ($crashes as &$crash) {
            $idVisit = $crash['idVisit'];
            $visit = $visitsByIdVisit[$idVisit];

            $crash['visit'] = $visit;

            // replace actionDetails w/ 5 most recent actions before crash
            if ($isVisitorLogEnabled) {
                [$actionsBeforeCrash] = $crashActions->getActionsBeforeCrash($crash['crashEventId'], $visit);

                unset($crash['visit']['actionDetails']);
                unset($crash['visit']['actionGroups']);
                $crash['actionsBeforeCrash'] = $actionsBeforeCrash;
            } else {
                unset($crash['actionsBeforeCrash']);
                $crash['visit'] = [
                    'browserFamily' => $crash['visit']['browserFamily'],
                    'browserFamilyDescription' => $crash['visit']['browserFamilyDescription'],
                    'browser' => $crash['visit']['browser'],
                    'browserName' => $crash['visit']['browserName'],
                    'browserIcon' => $crash['visit']['browserIcon'],
                    'browserCode' => $crash['visit']['browserCode'],
                    'browserVersion' => $crash['visit']['browserVersion'],
                    'operatingSystem' => $crash['visit']['operatingSystem'],
                    'operatingSystemName' => $crash['visit']['operatingSystemName'],
                    'operatingSystemIcon' => $crash['visit']['operatingSystemIcon'],
                    'operatingSystemCode' => $crash['visit']['operatingSystemCode'],
                    'operatingSystemVersion' => $crash['visit']['operatingSystemVersion'],
                    'deviceType' => $crash['visit']['deviceType'],
                    'deviceTypeIcon' => $crash['visit']['deviceTypeIcon'],
                ];
            }
        }

        return $crashes;
    }

    /**
     * Gets the list of every crash tracked for a site.
     *
     * @param int $idSite
     * @param string $filter_sort_column the crash property to sort by
     * @param string $filter_sort_order 'asc' or 'desc'
     * @param int $filter_limit (cannot be greater than 10000)
     * @param int $filter_offset
     * @return array
     */
    public function getAllCrashes($idSite, $filter_sort_column = 'datetime_last_seen', $filter_sort_order = 'desc', $filter_limit = 10, $filter_offset = 0)
    {
        Piwik::checkUserHasViewAccess($idSite);

        $filter_limit = min(self::MAX_GET_ALL_CRASHES_LIMIT, max($filter_limit, 1));

        $crashes = $this->logCrash->getAllCrashes($idSite, $filter_sort_column, $filter_sort_order, $filter_limit, $filter_offset);
        foreach ($crashes as &$crash) {
            $this->enrichCrash($crash);
        }
        return $crashes;
    }

    /**
     * Gets an overview report for crashes encountered. Includes overall metrics like the total
     * number of crashes encountered, how many were new, how many disappeared within the period, etc.
     *
     * @param int $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @return DataTable|DataTable\Map
     */
    public function get($idSite, $period, $date, $segment = false, $columns = false)
    {
        Piwik::checkUserHasViewAccess($idSite);

        $report = ReportsProvider::factory("CrashAnalytics", "get");
        $archive = Archive::build($idSite, $period, $date, $segment);

        $requestedColumns = Piwik::getArrayFromApiParameter($columns);

        $columns = $report->getMetricsRequiredForReport($allColumns = null, $requestedColumns);

        $inDbColumnNames = array_map(function ($value) {
            return 'CrashAnalytics_' . $value;
        }, $columns);
        $dataTable = $archive->getDataTableFromNumeric($inDbColumnNames);

        $newNameMapping = array_combine($inDbColumnNames, $columns);
        $dataTable->filter('ReplaceColumnNames', [$newNameMapping]);

        $this->recordProcessing->addVisitsCrashRate($dataTable, $idSite, $period, $date, $segment);

        $dataTable->deleteColumns(array_diff($requestedColumns, $columns));

        $columnsToShow = $requestedColumns ?: $report->getAllMetrics();
        $dataTable->queueFilter('ColumnDelete', [$columnsToRemove = [], $columnsToShow]);

        return $dataTable;
    }

    /**
     * Gets a report displaying crash message / originating source combinations encountered.
     *
     * @param int $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @return DataTable|DataTable\Map
     * @throws \Exception
     */
    public function getAllCrashMessages($idSite, $period, $date, $segment = false)
    {
        Piwik::checkUserHasViewAccess($idSite);

        $dataTable = $this->getDataTable(AllCrashes::ALL_CRASHES_RECORD_NAME, $idSite, $period, $date, $segment);
        $dataTable->filter($this->recordProcessing->moveColumnsToMetadata(['idlogcrash']));
        $this->recordProcessing->removeIgnoredCrashes($dataTable, $idSite);
        $dataTable->filter($this->recordProcessing->splitLabel());
        $dataTable->queueFilter($this->recordProcessing->setMissingSourceLabel());
        $this->recordProcessing->setDynamicCrashData($dataTable);
        $dataTable->queueFilter($this->recordProcessing->addCrashIdSegment());
        return $dataTable;
    }

    /**
     * Gets a report displaying crash message / originating source combinations with all
     * crashes with no source excluded.
     *
     * @param int $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @return DataTable|DataTable\Map
     */
    public function getCrashMessages($idSite, $period, $date, $segment = false)
    {
        Piwik::checkUserHasViewAccess($idSite);

        $dataTable = $this->getAllCrashMessages($idSite, $period, $date, $segment);
        $dataTable->filter($this->recordProcessing->removeCrashesWithUnknownSource());
        return $dataTable;
    }

    /**
     * Gets a report displaying crash messages for all crashes that have no source.
     *
     * @param int $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @return DataTable|DataTable\Map
     */
    public function getUnidentifiedCrashMessages($idSite, $period, $date, $segment = false)
    {
        Piwik::checkUserHasViewAccess($idSite);

        $dataTable = $this->getAllCrashMessages($idSite, $period, $date, $segment);
        $dataTable->filter($this->recordProcessing->keepCrashesWithUnknownSource());
        $dataTable->deleteColumn('crash_source');
        return $dataTable;
    }

    /**
     * Gets the disappeared crashes report.
     *
     * @param int $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @return DataTable|DataTable\Map
     */
    public function getDisappearedCrashes($idSite, $period, $date, $segment = false)
    {
        Piwik::checkUserHasViewAccess($idSite);

        $dataTable = $this->getDataTable(DisappearedCrashes::DISAPPEARED_RECORD_NAME, $idSite, $period, $date, $segment, false, false, null, false);
        $dataTable->filter($this->recordProcessing->moveColumnsToMetadata(['idlogcrash']));
        $this->recordProcessing->removeIgnoredCrashes($dataTable, $idSite);
        $dataTable->filter($this->recordProcessing->splitLabel());
        $dataTable->queueFilter($this->recordProcessing->setMissingSourceLabel());
        $this->recordProcessing->setDynamicCrashData($dataTable);
        return $dataTable;
    }

    /**
     * Gets the reappeared crashes report.
     *
     * @param int $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @return DataTable|DataTable\Map
     */
    public function getReappearedCrashes($idSite, $period, $date, $segment = false)
    {
        Piwik::checkUserHasViewAccess($idSite);

        $dataTable = $this->getAllCrashMessages($idSite, $period, $date, $segment);
        $dataTable->filter($this->recordProcessing->keepReappearedCrashes());
        $this->recordProcessing->removeIgnoredCrashes($dataTable, $idSite);
        return $dataTable;
    }

    /**
     * Gets the new crashes report.
     *
     * @param int $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @return DataTable|DataTable\Map
     */
    public function getNewCrashes($idSite, $period, $date, $segment = false)
    {
        Piwik::checkUserHasViewAccess($idSite);

        $dataTable = $this->getAllCrashMessages($idSite, $period, $date, $segment);
        $dataTable->filter($this->recordProcessing->keepNewCrashes());
        $this->recordProcessing->removeIgnoredCrashes($dataTable, $idSite);
        return $dataTable;
    }

    /**
     * Gets the crashes by page URL report.
     *
     * @param int $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @param bool|int $expanded
     * @param bool|int $flat
     * @return DataTable|DataTable\Map
     */
    public function getCrashesByPageUrl($idSite, $period, $date, $segment = false, $expanded = false, $flat = false)
    {
        Piwik::checkUserHasViewAccess($idSite);

        $dataTable = $this->getDataTable(CrashesByPageUrl::RECORD_NAME, $idSite, $period, $date, $segment, $expanded, $flat);
        $this->addNbHitsAndPageviewCrashRate($dataTable, 'getPageUrls', $idSite, $period, $date, $segment, true);

        $filterMethod = $flat ? 'filter' : 'queueFilter';
        $dataTable->$filterMethod($this->recordProcessing->changeEmptyLabel(Piwik::translate('General_Unknown')));

        $dataTable->queueFilter(DataTable\Filter\AddSegmentByLabel::class, ['pageUrl']);
        if ($expanded || $flat) {
            $this->forEverySubtable($dataTable, function (DataTable $subtable, $rowId, DataTable $parentTable) use ($idSite) {
                $subtable->filter($this->recordProcessing->moveColumnsToMetadata(['idlogcrash']));
                $this->recordProcessing->removeIgnoredCrashes($subtable, $idSite);
                if ($subtable->getRowsCount() == 0) {
                    $parentTable->deleteRow($rowId);
                    return;
                }
                $subtable->filter($this->recordProcessing->splitLabel());
                $subtable->filter($this->recordProcessing->setMissingSourceLabel());
                $this->recordProcessing->setDynamicCrashData($subtable, true);
                $subtable->filter($this->recordProcessing->addCrashIdSegment());
            });
        }
        return $dataTable;
    }

    /**
     * Gets a subtable for the crashes by page URL report.
     *
     * @param int $idSite
     * @param string $period
     * @param string $date
     * @param int $idSubtable
     * @param bool|string $segment
     * @return DataTable|DataTable\Map
     */
    public function getCrashesForPageUrl($idSite, $period, $date, $idSubtable, $segment = false)
    {
        Piwik::checkUserHasViewAccess($idSite);

        $dataTable = $this->getDataTable(CrashesByPageUrl::RECORD_NAME, $idSite, $period, $date, $segment, $expanded = false, $flat = false, $idSubtable);
        $dataTable->filter($this->recordProcessing->moveColumnsToMetadata(['idlogcrash']));
        $this->recordProcessing->removeIgnoredCrashes($dataTable, $idSite);
        $dataTable->filter($this->recordProcessing->splitLabel());
        $dataTable->queueFilter($this->recordProcessing->setMissingSourceLabel());
        $this->recordProcessing->setDynamicCrashData($dataTable);
        $dataTable->queueFilter($this->recordProcessing->addCrashIdSegment());
        return $dataTable;
    }

    /**
     * Gets the crashes by page title report.
     *
     * @param int $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @param bool|int $expanded
     * @param bool|int $flat
     * @return DataTable|DataTable\Map
     */
    public function getCrashesByPageTitle($idSite, $period, $date, $segment = false, $expanded = false, $flat = false)
    {
        Piwik::checkUserHasViewAccess($idSite);

        $dataTable = $this->getDataTable(CrashesByPageTitle::RECORD_NAME, $idSite, $period, $date, $segment, $expanded, $flat);
        $this->addNbHitsAndPageviewCrashRate($dataTable, 'getPageTitles', $idSite, $period, $date, $segment, false);

        $filterMethod = $flat ? 'filter' : 'queueFilter';
        $dataTable->$filterMethod($this->recordProcessing->changeEmptyLabel(Piwik::translate('General_Unknown')));

        $dataTable->queueFilter(DataTable\Filter\AddSegmentByLabel::class, ['pageTitle']);
        if ($expanded || $flat) {
            $this->forEverySubtable($dataTable, function (DataTable $subtable, $rowId, DataTable $parentTable) use ($idSite) {
                $subtable->filter($this->recordProcessing->moveColumnsToMetadata(['idlogcrash']));
                $this->recordProcessing->removeIgnoredCrashes($subtable, $idSite);
                if ($subtable->getRowsCount() == 0) {
                    $parentTable->deleteRow($rowId);
                    return;
                }
                $subtable->filter($this->recordProcessing->splitLabel());
                $subtable->filter($this->recordProcessing->setMissingSourceLabel());
                $this->recordProcessing->setDynamicCrashData($subtable, true);
                $subtable->filter($this->recordProcessing->addCrashIdSegment());
            });
        }
        return $dataTable;
    }

    /**
     * Gets a subtable for the crashes by page title report.
     *
     * @param int $idSite
     * @param string $period
     * @param string $date
     * @param int $idSubtable
     * @param bool|string $segment
     * @return DataTable|DataTable\Map
     */
    public function getCrashesForPageTitle($idSite, $period, $date, $idSubtable, $segment = false)
    {
        Piwik::checkUserHasViewAccess($idSite);

        $dataTable = $this->getDataTable(CrashesByPageTitle::RECORD_NAME, $idSite, $period, $date, $segment, $expanded = false, $flat = false, $idSubtable);
        $dataTable->filter($this->recordProcessing->moveColumnsToMetadata(['idlogcrash']));
        $this->recordProcessing->removeIgnoredCrashes($dataTable, $idSite);
        $dataTable->filter($this->recordProcessing->splitLabel());
        $dataTable->queueFilter($this->recordProcessing->setMissingSourceLabel());
        $this->recordProcessing->setDynamicCrashData($dataTable);
        $dataTable->queueFilter($this->recordProcessing->addCrashIdSegment());
        return $dataTable;
    }

    /**
     * Gets the crashes by originating source file report.
     *
     * @param int $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @param bool|int $expanded
     * @param bool|int $flat
     * @return DataTable|DataTable\Map
     */
    public function getCrashesBySource($idSite, $period, $date, $segment = false, $expanded = false, $flat = false)
    {
        Piwik::checkUserHasViewAccess($idSite);

        $dataTable = $this->getDataTable(CrashesBySource::RECORD_NAME, $idSite, $period, $date, $segment, $expanded, $flat);

        $filterMethod = $flat ? 'filter' : 'queueFilter';
        $dataTable->$filterMethod($this->recordProcessing->changeEmptyLabel(Piwik::translate('General_Unknown')));

        $dataTable->queueFilter(DataTable\Filter\AddSegmentByLabel::class, ['crashSource']);
        if ($expanded || $flat) {
            $this->forEverySubtable($dataTable, function (DataTable $subtable, $rowId, DataTable $parentTable) use ($idSite) {
                $subtable->filter($this->recordProcessing->moveColumnsToMetadata(['idlogcrash']));
                $this->recordProcessing->removeIgnoredCrashes($subtable, $idSite);
                if ($subtable->getRowsCount() == 0) {
                    $parentTable->deleteRow($rowId);
                    return;
                }
                $this->recordProcessing->setDynamicCrashData($subtable, true);
                $subtable->filter($this->recordProcessing->addCrashIdSegment());
            });
        }
        return $dataTable;
    }

    /**
     * Get a subtable for the crashes by originating source file report.
     *
     * @param int $idSite
     * @param string $period
     * @param string $date
     * @param int $idSubtable
     * @param bool|string $segment
     * @return DataTable|DataTable\Map
     */
    public function getCrashesForSource($idSite, $period, $date, $idSubtable, $segment = false)
    {
        $dataTable = $this->getDataTable(CrashesBySource::RECORD_NAME, $idSite, $period, $date, $segment, $expanded = false, $flat = false, $idSubtable);
        $dataTable->filter($this->recordProcessing->moveColumnsToMetadata(['idlogcrash']));
        $this->recordProcessing->removeIgnoredCrashes($dataTable, $idSite);
        $this->recordProcessing->setDynamicCrashData($dataTable);
        $dataTable->queueFilter($this->recordProcessing->addCrashIdSegment());
        return $dataTable;
    }

    /**
     * Gets the crashes by crash category report.
     *
     * @param int $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @param bool|int $expanded
     * @param bool|int $flat
     * @return DataTable|DataTable\Map
     */
    public function getCrashesByCategory($idSite, $period, $date, $segment = false, $expanded = false, $flat = false)
    {
        Piwik::checkUserHasViewAccess($idSite);

        $dataTable = $this->getDataTable(CrashesByCategory::RECORD_NAME, $idSite, $period, $date, $segment, $expanded, $flat);
        $dataTable->queueFilter(DataTable\Filter\AddSegmentByLabel::class, ['crashCategory']);

        if ($expanded || $flat) {
            $this->forEverySubtable($dataTable, function (DataTable $subtable, $rowId, DataTable $parentTable) use ($idSite) {
                $subtable->filter($this->recordProcessing->moveColumnsToMetadata(['idlogcrash']));
                $this->recordProcessing->removeIgnoredCrashes($subtable, $idSite);
                if ($subtable->getRowsCount() == 0) {
                    $parentTable->deleteRow($rowId);
                    return;
                }
                $subtable->filter($this->recordProcessing->splitLabel());
                $subtable->filter($this->recordProcessing->setMissingSourceLabel());
                $this->recordProcessing->setDynamicCrashData($subtable, true);
                $subtable->filter($this->recordProcessing->addCrashIdSegment());
            });
        }

        $changeEmptyRowFilterMethod = $flat ? 'filter' : 'queueFilter';
        $dataTable->$changeEmptyRowFilterMethod($this->recordProcessing->changeEmptyLabel(Piwik::translate('CrashAnalytics_NoCategorySet')));

        return $dataTable;
    }

    /**
     * Gets a subtable for the crashes by crash category report.
     *
     * @param int $idSite
     * @param string $period
     * @param string $date
     * @param int $idSubtable
     * @param bool|string $segment
     * @return DataTable|DataTable\Map
     */
    public function getCrashesForCategory($idSite, $period, $date, $idSubtable, $segment = false)
    {
        Piwik::checkUserHasViewAccess($idSite);

        $dataTable = $this->getDataTable(CrashesByCategory::RECORD_NAME, $idSite, $period, $date, $segment, $expanded = false, $flat = false, $idSubtable);
        $dataTable->filter($this->recordProcessing->moveColumnsToMetadata(['idlogcrash']));
        $this->recordProcessing->removeIgnoredCrashes($dataTable, $idSite);
        $dataTable->filter($this->recordProcessing->splitLabel());
        $dataTable->queueFilter($this->recordProcessing->setMissingSourceLabel());
        $this->recordProcessing->setDynamicCrashData($dataTable);
        $dataTable->queueFilter($this->recordProcessing->addCrashIdSegment());
        return $dataTable;
    }

    /**
     * Gets the crashes by first party source file report.
     *
     * @param int $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @return DataTable|DataTable\Map
     */
    public function getCrashesByFirstParty($idSite, $period, $date, $segment = false)
    {
        Piwik::checkUserHasViewAccess($idSite);

        $dataTable = $this->getAllCrashMessages($idSite, $period, $date, $segment);
        $dataTable->filter($this->recordProcessing->removeSummaryRow());
        $dataTable->filter(function (DataTable $table) {
            $idSiteForTable = $table->getMetadata('site')->getId();
            $siteUrls = Request::processRequest('SitesManager.getSiteUrlsFromId', ['idSite' => $idSiteForTable]);

            $function = $this->recordProcessing->keepFirstPartySources($siteUrls);
            $function($table);
        });
        return $dataTable;
    }

    /**
     * Gets the crashes by third party source file report.
     *
     * @param int $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @return DataTable|DataTable\Map
     */
    public function getCrashesByThirdParty($idSite, $period, $date, $segment = false)
    {
        Piwik::checkUserHasViewAccess($idSite);

        $dataTable = $this->getAllCrashMessages($idSite, $period, $date, $segment);
        $dataTable->filter($this->recordProcessing->removeSummaryRow());
        $dataTable->filter(function (DataTable $table) {
            $idSiteForTable = $table->getMetadata('site')->getId();
            $siteUrls = Request::processRequest('SitesManager.getSiteUrlsFromId', ['idSite' => $idSiteForTable]);

            $function = $this->recordProcessing->keepThirdPartySources($siteUrls);
            $function($table);
        });
        return $dataTable;
    }

    /**
     * Gets the realtime crash overview report.
     *
     * @param int $idSite
     * @param bool|string $segment
     * @param int $lastMinutes the number of minutes in the past to look at. Defaults to 30, cannot be more
     *                         than 12 hours.
     * @return DataTable
     */
    public function getLastCrashesOverview($idSite, $segment = false, $lastMinutes = 30)
    {
        Piwik::checkUserHasViewAccess($idSite);
        $this->checkLastNMinutes($lastMinutes);

        $segment = new Segment($segment, [$idSite]);

        $metrics = $this->logCrashEvent->getLastCrashesOverview($idSite, $segment, $lastMinutes);

        $dataTable = new DataTable();
        $dataTable->addRowFromSimpleArray($metrics);

        $nbVisits = $this->liveModel->getNumVisits($idSite, $lastMinutes, $segment);

        $extraProcessedMetrics = $dataTable->getMetadata(DataTable::EXTRA_PROCESSED_METRICS_METADATA_NAME) ?: [];
        $extraProcessedMetrics[] = new VisitsCrashRate($nbVisits);
        $dataTable->setMetadata(DataTable::EXTRA_PROCESSED_METRICS_METADATA_NAME, $extraProcessedMetrics);

        $dataTable->setMetadata(DataTable::COLUMN_AGGREGATION_OPS_METADATA_NAME, Metrics::getMetricAggregationOps());

        return $dataTable;
    }

    /**
     * Gets the realtime top crashes report.
     *
     * @param int $idSite
     * @param bool|string $segment
     * @param int $lastMinutes the number of minutes in the past to look at. Defaults to 30, cannot be more
     *                         than 12 hours.
     * @param int $filter_limit
     * @return DataTable
     */
    public function getLastTopCrashes($idSite, $segment = false, $lastMinutes = 30, $filter_limit = 5)
    {
        Piwik::checkUserHasViewAccess($idSite);
        $this->checkLastNMinutes($lastMinutes);

        $segment = new Segment($segment, [$idSite]);

        $rows = $this->logCrashEvent->getLastCrashes($idSite, $segment, $lastMinutes, $where = '', $filter_limit,
            $orderBy = Metrics::CRASH_OCCURRENCES . ' DESC, log_crash_group.datetime_last_seen DESC');

        $dataTable = DataTable::makeFromSimpleArray($rows);
        $dataTable->setMetadata(DataTable::COLUMN_AGGREGATION_OPS_METADATA_NAME, Metrics::getMetricAggregationOps());
        $dataTable->filter($this->recordProcessing->moveColumnsToMetadata(['idlogcrash']));
        $dataTable->filter($this->recordProcessing->splitLabel());
        $dataTable->queueFilter($this->recordProcessing->setMissingSourceLabel());
        $dataTable->queueFilter($this->recordProcessing->addCrashIdSegment());
        return $dataTable;
    }

    /**
     * Gets the realtime new crashes report.
     *
     * @param int $idSite
     * @param bool|string $segment
     * @param int $lastMinutes the number of minutes in the past to look at. Defaults to 30, cannot be more
     *                         than 12 hours.
     * @param int $filter_limit
     * @return DataTable
     */
    public function getLastNewCrashes($idSite, $segment = false, $lastMinutes = 30, $filter_limit = 10)
    {
        Piwik::checkUserHasViewAccess($idSite);
        $this->checkLastNMinutes($lastMinutes);

        $segment = new Segment($segment, $idSite);

        $lastNDatetime = Date::now()->subSeconds(60 * $lastMinutes)->getDatetime();

        $rows = $this->logCrashEvent->getLastCrashes($idSite, $segment, $lastMinutes,
            'log_crash_group.datetime_first_seen >= \'' . $lastNDatetime .  '\'', $filter_limit,
            $orderBy = 'log_crash_group.datetime_first_seen DESC', []);

        $dateColumns = ['crash_first_seen', 'crash_last_seen', 'crash_last_reappeared'];
        $metadataColumns = ['idlogcrash'];

        $dataTable = DataTable::makeFromSimpleArray($rows);
        $dataTable->setMetadata(DataTable::COLUMN_AGGREGATION_OPS_METADATA_NAME, Metrics::getMetricAggregationOps());
        $dataTable->queueFilter($this->recordProcessing->moveColumnsToMetadata($metadataColumns));
        $dataTable->filter($this->recordProcessing->splitLabel());
        $dataTable->queueFilter($this->recordProcessing->setMissingSourceLabel());
        $dataTable->queueFilter($this->recordProcessing->formatLastNDate($dateColumns));
        $dataTable->queueFilter($this->recordProcessing->addCrashIdSegment());
        return $dataTable;
    }

    /**
     * Gets the realtime reappeared crashes report.
     *
     * @param int $idSite
     * @param bool|string $segment
     * @param int $lastMinutes the number of minutes in the past to look at. Defaults to 30, cannot be more
     *                         than 12 hours.
     * @param int $filter_limit
     * @return DataTable
     */
    public function getLastReappearedCrashes($idSite, $segment = false, $lastMinutes = 30, $filter_limit = 10)
    {
        Piwik::checkUserHasViewAccess($idSite);
        $this->checkLastNMinutes($lastMinutes);

        $segment = new Segment($segment, [$idSite]);

        $lastNDatetime = Date::now()->subSeconds(60 * $lastMinutes)->getDatetime();

        $rows = $this->logCrashEvent->getLastCrashes($idSite, $segment, $lastMinutes,
            'log_crash_group.datetime_last_reappeared >= \'' . $lastNDatetime . '\'', $filter_limit,
            $orderBy = 'log_crash_group.datetime_last_reappeared DESC', []);

        $dateColumns = ['crash_first_seen', 'crash_last_seen', 'crash_last_reappeared'];
        $metadataColumns = ['idlogcrash'];

        $dataTable = DataTable::makeFromSimpleArray($rows);
        $dataTable->setMetadata(DataTable::COLUMN_AGGREGATION_OPS_METADATA_NAME, Metrics::getMetricAggregationOps());
        $dataTable->queueFilter($this->recordProcessing->moveColumnsToMetadata($metadataColumns));
        $dataTable->filter($this->recordProcessing->splitLabel());
        $dataTable->queueFilter($this->recordProcessing->setMissingSourceLabel());
        $dataTable->queueFilter($this->recordProcessing->formatLastNDate($dateColumns));
        $dataTable->queueFilter($this->recordProcessing->addCrashIdSegment());
        return $dataTable;
    }

    /**
     * Gets the realtime disappeared crashes report.
     *
     * @param int $idSite
     * @param bool|string $segment
     * @param int $lastMinutes the number of minutes in the past to look at. Defaults to 30, cannot be more
     *                         than 12 hours.
     * @param int $filter_limit
     * @return DataTable
     */
    public function getLastDisappearedCrashes($idSite, $segment = false, $lastMinutes = 30, $filter_limit = 10)
    {
        Piwik::checkUserHasViewAccess($idSite);
        $this->checkLastNMinutes($lastMinutes);

        $segment = new Segment($segment, [$idSite]);

        $rows = $this->logCrashEvent->getLastDisappearedCrashes($idSite, $segment, $lastMinutes, $filter_limit);

        $dateColumns = ['crash_first_seen', 'crash_last_seen', 'crash_last_reappeared'];
        $metadataColumns = ['idlogcrash'];

        $dataTable = DataTable::makeFromSimpleArray($rows);
        $dataTable->setMetadata(DataTable::COLUMN_AGGREGATION_OPS_METADATA_NAME, Metrics::getMetricAggregationOps());
        $dataTable->queueFilter($this->recordProcessing->moveColumnsToMetadata($metadataColumns));
        $dataTable->filter($this->recordProcessing->splitLabel());
        $dataTable->queueFilter($this->recordProcessing->setMissingSourceLabel());
        $dataTable->queueFilter($this->recordProcessing->formatLastNDate($dateColumns));
        $dataTable->queueFilter($this->recordProcessing->addCrashIdSegment());
        return $dataTable;
    }

    private function getDataTable($recordName, $idSite, $period, $date, $segment, $expanded = false, $flat = false, $idSubtable = null, $addCrashRate = true)
    {
        $dataTable = Archive::createDataTableFromArchive($recordName, $idSite, $period, $date, $segment, $expanded, $flat, $idSubtable);

        $dataTable->filter(function (DataTable $table) {
            $table->setMetadata(DataTable::COLUMN_AGGREGATION_OPS_METADATA_NAME, Metrics::getMetricAggregationOps());
        });

        if ($addCrashRate) {
            $this->recordProcessing->addVisitsCrashRate($dataTable, $idSite, $period, $date, $segment);
        }

        $dataTable->queueFilter('ReplaceSummaryRowLabel');
        return $dataTable;
    }

    private function addNbHitsAndPageviewCrashRate(DataTable\DataTableInterface $dataTable, $actionsMethod, $idSite, $period, $date, $segment, $isUrl)
    {
        $actionsReport = Request::processRequest("Actions.$actionsMethod", [
            'idSite' => $idSite,
            'period' => $period,
            'date' => $date,
            'segment' => $segment,
            'flat' => 1,
            'filter_limit' => -1,
            'filter_offset' => 0,
        ]);

        $this->recordProcessing->multiFilter($dataTable, [$actionsReport], function (DataTable $thisTable, $actionsTable) use ($isUrl) {
            if (empty($actionsTable)) {
                return;
            }

            foreach ($thisTable->getRowsWithoutSummaryRow() as $row) {
                $pageviewUrlOrTitle = $row->getColumn('label');
                if ($isUrl && is_numeric($pageviewUrlOrTitle)) {
                    continue;
                }

                if ($isUrl) {
                    if (!preg_match('/^https?:/', $pageviewUrlOrTitle)) {
                        $pageviewUrlOrTitle = 'http://' . $pageviewUrlOrTitle;
                    }

                    $parsed = parse_url($pageviewUrlOrTitle);
                    if (empty($parsed['path'])) {
                        continue;
                    }

                    $pageviewUrlOrTitle = $parsed['path'];
                    if (!empty($pageviewUrlOrTitle['query'])) {
                        $pageviewUrlOrTitle .= '?' . $pageviewUrlOrTitle['query'];
                    }
                    if (!empty($pageviewUrlOrTitle['fragment'])) {
                        $pageviewUrlOrTitle .= '#' . $pageviewUrlOrTitle['fragment'];
                    }
                }

                $pageActionRow = $actionsTable->getRowFromLabel($pageviewUrlOrTitle);
                if (empty($pageActionRow)) {
                    continue;
                }

                $hits = Metric::getMetric($pageActionRow, 'nb_hits');
                $row->setColumn('nb_hits', $hits);
            }

            $extraProcessedMetrics = $thisTable->getMetadata(DataTable::EXTRA_PROCESSED_METRICS_METADATA_NAME) ?: [];
            $extraProcessedMetrics[] = new PageviewCrashRate();
            $thisTable->setMetadata(DataTable::EXTRA_PROCESSED_METRICS_METADATA_NAME, $extraProcessedMetrics);
        });
    }

    private function forEverySubtable(DataTable\DataTableInterface $dataTable, $callback)
    {
        $dataTable->filter(function (DataTable $table) use ($callback) {
            foreach ($table->getRows() as $rowId => $row) {
                $subtable = $row->getSubtable();
                if ($subtable) {
                    $callback($subtable, $rowId, $table);
                }
            }
        });
    }

    private function checkLastNMinutes($lastMinutes)
    {
        $lastMinutes = (int)$lastMinutes;
        if ($lastMinutes <= 0) {
            throw new \Exception("Invalid lastNMinutes value provided: $lastMinutes");
        }

        if ($lastMinutes > self::MAX_LAST_N_HOURS * 60) {
            throw new \Exception("Invalid lastNMinutes value: $lastMinutes. The max value is 8 hours.");
        }
    }

    private function getPrettyDateTime($d)
    {
        if (empty($d)) {
            return null;
        }

        $d = Date::factory($d);
        return $d->getLocalized(Date::DATE_FORMAT_LONG) . ' ' . $d->toString('H:i:s');
    }

    /**
     * @param int[] $idVisits
     */
    private function queryMinimalVisitInfo($idVisits)
    {
        if (empty($idVisits)) {
            return [];
        }

        $sql = "SELECT
            log_visit.idvisit as idVisit,
            log_visit.config_browser_name as browserCode,
            log_visit.config_browser_engine as browserFamily,
            log_visit.config_browser_version as browserVersion,
            log_visit.config_os as operatingSystemCode,
            log_visit.config_os_version as operatingSystemVersion,
            log_visit.config_device_type as deviceType
        FROM " . Common::prefixTable('log_visit') . " log_visit
       WHERE log_visit.idvisit IN (" . implode(',', $idVisits) . ")";

        $result = Db::getReader()->fetchAll($sql);
        foreach ($result as &$row) {
            $row['browserFamilyDescription'] = \Piwik\Plugins\DevicesDetection\getBrowserEngineName($row['browserFamily']);
            $row['browser'] = \Piwik\Plugins\DevicesDetection\getBrowserNameWithVersion($row['browserCode'] . ";" . $row['browserVersion']);
            $row['browserName'] = \Piwik\Plugins\DevicesDetection\getBrowserName($row['browserCode']);
            $row['browserIcon'] = \Piwik\Plugins\DevicesDetection\getBrowserLogo($row['browserCode'] . ";" . $row['browserVersion']);

            $row['operatingSystem'] = \Piwik\Plugins\DevicesDetection\getOsFullName($row['operatingSystemCode'] . ";" . $row['operatingSystemVersion']);
            $row['operatingSystemName'] = \Piwik\Plugins\DevicesDetection\getOsFullName($row['operatingSystemCode']);
            $row['operatingSystemIcon'] = \Piwik\Plugins\DevicesDetection\getOsLogo($row['operatingSystemCode']);

            $row['deviceType'] = \Piwik\Plugins\DevicesDetection\getDeviceTypeLabel($row['deviceType']);
            $row['deviceTypeIcon'] = \Piwik\Plugins\DevicesDetection\getDeviceTypeLogo($row['deviceType']);
        }
        return $result;
    }

    private function enrichCrash(&$crash)
    {
        unset($crash['common_crash_type_id']);

        $crash['idlogcrash'] = (int)$crash['idlogcrash'];
        $crash['resource_uri'] = $crash['resource_uri'] ?? null;
        $crash['stack_trace'] = $crash['stack_trace'] ?? null;

        $crash['datetime_first_seen_pretty'] = $this->getPrettyDateTime($crash['datetime_first_seen']);
        $crash['datetime_last_seen_pretty'] = $this->getPrettyDateTime($crash['datetime_last_seen']);
        $crash['datetime_last_reappeared_pretty'] = $this->getPrettyDateTime($crash['datetime_last_reappeared']);
        $crash['datetime_ignored_error_pretty'] = $this->getPrettyDateTime($crash['datetime_ignored_error']);

        if (isset($crash['datetime_first_seen'])) {
            $firstSeen = Date::factory($crash['datetime_first_seen']);
            $crash['date_first_seen'] = $firstSeen->toString();
            $crash['date_first_seen_pretty'] = $firstSeen->getLocalized(Date::DATE_FORMAT_SHORT);
        }

        if (isset($crash['datetime_last_seen'])) {
            $lastSeen = Date::factory($crash['datetime_last_seen']);
            $crash['date_last_seen'] = $lastSeen->toString();
            $crash['date_last_seen_pretty'] = $lastSeen->getLocalized(Date::DATE_FORMAT_SHORT);
        }

        if (isset($crash['datetime_last_reappeared'])) {
            $lastReappeared = Date::factory($crash['datetime_last_reappeared']);
            $crash['date_last_reappeared'] = $lastReappeared->toString();
            $crash['date_last_reappeared_pretty'] = $lastReappeared->getLocalized(Date::DATE_FORMAT_SHORT);
        }

        if (isset($crash['datetime_ignored_error'])) {
            $ignoredTime = Date::factory($crash['datetime_ignored_error']);
            $crash['date_ignored_error'] = $ignoredTime->toString();
            $crash['date_ignored_error_pretty'] = $ignoredTime->getLocalized(Date::DATE_FORMAT_SHORT);
        }

        $crash['resource_line'] = isset($crash['resource_line']) ? (int)$crash['resource_line'] : null;
        $crash['resource_column'] = isset($crash['resource_column']) ? (int)$crash['resource_column'] : null;

        unset($crash['crc32_hash']);
    }

    private function enrichCrashEvent(&$crashEvent)
    {
        $crashEvent['category'] = $crashEvent['category'] ?? null;

        $crashEvent['crash_page_url'] = $this->logCrashEvent->reconstructPageUrl(
            $crashEvent['crash_page_url'] ?? null,
            $crashEvent['crash_page_url_prefix'] ?? null,
            $crashEvent['idsite']
        );
        unset($crashEvent['crash_page_url_prefix']);
    }

    private function checkIdLogCrash($idLogCrash)
    {
        $idLogCrash = (int)$idLogCrash;
        if ($idLogCrash <= 0) {
            throw new \Exception('invalid idlogcrash supplied, it should be a valid integer');
        }
    }
}
