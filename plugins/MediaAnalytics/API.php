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

namespace Piwik\Plugins\MediaAnalytics;

use Piwik\Archive;
use Piwik\Common;
use Piwik\DataTable;
use Piwik\Date;
use Piwik\Piwik;
use Piwik\Plugin\ReportsProvider;
use Piwik\Plugins\MediaAnalytics\Dao\LogTable;
use Piwik\SettingsPiwik;
use Piwik\Site;

/**
 * The MediaAnalytics API lets you request your reports about how your Video and Audio are accessed and viewed on your websites and apps.
 * Some of the methods return Real Time information (similarly to the Live! API), while others return all your videos and audios and their key metrics.
 *
 * <br/><br/>
 * The real time methods can return information about the last N minutes (or last N hours). They include the following: <ul>
 * <li>the method `getCurrentNumPlays` returns  the number of video plays (and audio plays) in the last N minutes</li>
 * <li>the method `getCurrentSumTimeSpent` returns the the total time users spent playing your media in the last N minutes</li>
 * <li> the method `getCurrentMostPlays` returns the most popular videos in the last N minutes.</li>
 * </ul>
 * <br/>
 * The other methods return the aggregated analytics reports for Video and Audio:
 * <ul>
 * <li>`MediaAnalytics.get` returns the overall metrics for your videos and audios: `nb_plays, nb_unique_visitors_plays,
 *  nb_impressions, nb_unique_visitors_impressions, nb_finishes, sum_total_time_watched, sum_total_audio_plays,
 *  sum_total_audio_impressions, sum_total_video_plays, sum_total_video_impressions, play_rate, finish_rate, impression_rate`.</li>
 * <li>`getVideoTitles` and `getAudioTitles` return the list of videos / audio by video title and audio title. </li>
 * <li>`getGroupedVideoResources` and `getGroupedAudioResources` return the list of watched videos / audio grouped by
 *  resource URL. The "grouped media resource" report displays a flat report which includes both the domain and the path
 *  to the media resource, whereas the regular "media resource" report displays a hierarchical view of your media resources by domain.</li>
 * <li>`getVideoHours` and `getAudioHours` return the list of videos / audio by by hour (to see how your media is consumed at a different time of the day). </li>
 * <li>`getVideoTitles` and `getAudioTitles` return the list of videos / audio by video title and audio title. </li>
 * <li>`getVideoResolutions` return the list of videos by player resolution (see how your videos are consumed when the video resolution varies). </li>
 * <li>`getPlayers` return the watched media by media player. </li>
 * </ul>
 *

 *
 * @method static API getInstance()
 */
class API extends \Piwik\Plugin\API
{
    public const MAX_LAST_N_HOURS = 24;

    /**
     * @var LogTable
     */
    private $logTable;

    public function __construct(LogTable $logTable)
    {
        $this->logTable = $logTable;
    }

    /**
     * @param $idSite
     * @return mixed
     * @hide
     */
    public function hasRecords($idSite)
    {
        Piwik::checkUserHasViewAccess($idSite);

        return $this->logTable->hasRecords($idSite);
    }

    public function get($idSite, $period, $date, $segment = false, $columns = false)
    {
        Piwik::checkUserHasViewAccess($idSite);
        $archive = Archive::build($idSite, $period, $date, $segment);

        $requestedColumns = Piwik::getArrayFromApiParameter($columns);

        $report = ReportsProvider::factory('MediaAnalytics', 'get');
        $columns = $report->getMetricsRequiredForReport(null, $requestedColumns);

        if (!SettingsPiwik::isUniqueVisitorsEnabled($period) || !Archiver::isUniqueVisitorsEnabled($period)) {
            $key = array_search(Metrics::METRIC_NB_UNIQUE_VISITORS, $columns);
            if ($key !== false) {
                array_splice($columns, $key, 1);
            }
        }

        $recordNames = array_map(function ($metricName) {
            if ($metricName === Metrics::METRIC_NB_UNIQUE_VISITORS) {
                return $metricName;
            }
            return Archiver::NUMERIC_RECORD_PREFIX . $metricName;
        }, $columns);

        $dataTable = $archive->getDataTableFromNumeric($recordNames);
        $dataTable->filter(function (DataTable $table) {
            foreach ($table->getRows() as $row) {
                $columns = $row->getColumns();
                foreach ($columns as $column => $value) {
                    if (strpos($column, Archiver::NUMERIC_RECORD_PREFIX) === 0) {
                        $row->setColumn(substr($column, strlen(Archiver::NUMERIC_RECORD_PREFIX)), $value);
                        $row->deleteColumn($column);
                    }
                }
            }
        });

        if (!empty($requestedColumns)) {
            $dataTable->queueFilter('ColumnDelete', array($columnsToRemove = array(), $requestedColumns));
        }

        if (!SettingsPiwik::isUniqueVisitorsEnabled($period) || !Archiver::isUniqueVisitorsEnabled($period)) {
            $dataTable->queueFilter('ColumnDelete', array($columnsToRemove = array(Metrics::METRIC_IMPRESSION_RATE)));
        }

        return $dataTable;
    }

    public function getCurrentNumPlays($idSite, $lastMinutes, $segment = false)
    {
        Piwik::checkUserHasViewAccess($idSite);
        $lastMinutes = (int)$lastMinutes;
        $this->checkLastNMinutes($lastMinutes);
        $serverTime = $this->getServerTimeForXMinutesAgo($lastMinutes);

        $numPlays = $this->logTable->getNumPlays($idSite, $serverTime, $segment);

        if (empty($numPlays)) {
            return 0;
        }

        return $numPlays;
    }

    public function getCurrentSumTimeSpent($idSite, $lastMinutes, $segment = false)
    {
        Piwik::checkUserHasViewAccess($idSite);
        $lastMinutes = (int)$lastMinutes;
        $this->checkLastNMinutes($lastMinutes);
        $serverTime = $this->getServerTimeForXMinutesAgo($lastMinutes);

        $spentTime = $this->logTable->getSumWatchedTime($idSite, $serverTime, $segment);

        if (empty($spentTime)) {
            return 0;
        }

        return $spentTime;
    }

    public function getCurrentMostPlays($idSite, $lastMinutes, $filter_limit = 5, $segment = false)
    {
        Piwik::checkUserHasViewAccess($idSite);
        if (!is_numeric($filter_limit)) {
            throw new \Exception(Piwik::translate('MediaAnalytics_InvalidParameterErrorMessage', ['filter_limit', $filter_limit]));
        }
        $lastMinutes = (int)$lastMinutes;
        $this->checkLastNMinutes($lastMinutes);
        $serverTime = $this->getServerTimeForXMinutesAgo($lastMinutes);

        $rows = $this->logTable->getMostPlays($idSite, $serverTime, $filter_limit, $segment);

        if (empty($rows)) {
            return new DataTable();
        }

        $replacements = array('http://', 'https://', 'www.');
        foreach ($rows as &$row) {
            foreach ($replacements as $replacement) {
                if (!empty($row['label']) && strpos($row['label'], $replacement) === 0) {
                    $row['label'] = substr($row['label'], strlen($replacement));
                }
            }
        }

        $dataTable = DataTable::makeFromSimpleArray($rows);
        return $dataTable;
    }

    private function getServerTimeForXMinutesAgo($lastMinutes)
    {
        // we do not use time() directly because this way we can mock time() in tests
        $time = Date::now()->getTimestampUTC();

        if (defined('PIWIK_TEST_MODE')) {
            $testNow = \Piwik\Container\StaticContainer::get('test.vars.testMockNowDate');
            if ($testNow) {
                $time = $testNow;
            }
        }

        return Date::factory($time - ((int)$lastMinutes * 60))->getDatetime();
    }

    /**
     * @param int    $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @param bool|int $idSubtable
     * @param bool|string $secondaryDimension
     * @param bool $expanded
     * @param bool $_expandAll internal usage only
     * @param bool $flat
     * @return DataTable
     */
    public function getVideoResources($idSite, $period, $date, $segment = false, $idSubtable = false, $secondaryDimension = false, $expanded = false, $_expandAll = false, $flat = false)
    {
        Piwik::checkUserHasViewAccess($idSite);

        if (!empty($expanded)) {
            $expandedDepth = $_expandAll ? 999 : 1;
        } else {
            $expandedDepth = null;
        }

        $dataTable = $this->getDataTable(Archiver::RECORD_VIDEO_RESOURCES, $idSite, $period, $date, $segment, $idSubtable, $secondaryDimension, $expandedDepth, $flat);

        if (empty($idSubtable)) {
            $dataTable->queueFilter('MetadataCallbackAddMetadata', array(array(), 'openable', function () {
                return 1;
            }));
        } elseif (!empty($idSubtable) && empty($secondaryDimension)) {
            $dataTable->filter('Piwik\Plugins\MediaAnalytics\DataTable\Filter\AddResourceSegment');
        }

        if ($flat) {
            $dataTable->filterSubtables('RemoveSubtables');
        }

        return $dataTable;
    }

    /**
     * @param int    $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @param bool|int $idSubtable
     * @param bool|string $secondaryDimension
     * @param bool $expanded
     * @param bool $_expandAll internal usage only
     * @return DataTable
     */
    public function getAudioResources($idSite, $period, $date, $segment = false, $idSubtable = false, $secondaryDimension = false, $expanded = false, $_expandAll = false, $flat = false)
    {
        Piwik::checkUserHasViewAccess($idSite);

        if (!empty($expanded)) {
            $expandedDepth = $_expandAll ? 999 : 1;
        } else {
            $expandedDepth = null;
        }

        $dataTable = $this->getDataTable(Archiver::RECORD_AUDIO_RESOURCES, $idSite, $period, $date, $segment, $idSubtable, $secondaryDimension, $expandedDepth, $flat);

        if (empty($idSubtable)) {
            $dataTable->queueFilter('MetadataCallbackAddMetadata', array(array(), 'openable', function () {
                return 1;
            }));
        } elseif (!empty($idSubtable) && empty($secondaryDimension)) {
            $dataTable->filter('Piwik\Plugins\MediaAnalytics\DataTable\Filter\AddResourceSegment');
        }

        if ($flat) {
            $dataTable->filterSubtables('RemoveSubtables');
        }

        return $dataTable;
    }

    /**
     * @param int    $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @param bool|int $idSubtable
     * @param bool|string $secondaryDimension
     * @return DataTable
     */
    public function getVideoTitles($idSite, $period, $date, $segment = false, $idSubtable = false, $secondaryDimension = false)
    {
        Piwik::checkUserHasViewAccess($idSite);
        $dataTable = $this->getDataTable(Archiver::RECORD_VIDEO_TITLES, $idSite, $period, $date, $segment, $idSubtable, $secondaryDimension, false);

        if (empty($idSubtable)) {
            $dataTable->queueFilter('AddSegmentByLabel', array('media_title'));
        }

        if (empty($secondaryDimension) && Common::getRequestVar('flat', '0', 'string') == '1') {
            $dataTable->filter('RemoveSubtables');
        }

        return $dataTable;
    }

    /**
     * @param int    $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @param bool|int $idSubtable
     * @param bool|string $secondaryDimension
     * @return DataTable
     */
    public function getAudioTitles($idSite, $period, $date, $segment = false, $idSubtable = false, $secondaryDimension = false)
    {
        Piwik::checkUserHasViewAccess($idSite);
        $dataTable = $this->getDataTable(Archiver::RECORD_AUDIO_TITLES, $idSite, $period, $date, $segment, $idSubtable, $secondaryDimension, false);

        if (empty($idSubtable)) {
            $dataTable->queueFilter('AddSegmentByLabel', array('media_title'));
        }

        if (empty($secondaryDimension) && Common::getRequestVar('flat', '0', 'string') == '1') {
            $dataTable->filter('RemoveSubtables');
        }

        return $dataTable;
    }

    /**
     * @param int    $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @param bool|int $idSubtable
     * @param bool|string $secondaryDimension
     * @return DataTable
     */
    public function getGroupedVideoResources($idSite, $period, $date, $segment = false, $idSubtable = false, $secondaryDimension = false)
    {
        Piwik::checkUserHasViewAccess($idSite);
        $dataTable =  $this->getDataTable(Archiver::RECORD_VIDEO_GROUPEDRESOURCES, $idSite, $period, $date, $segment, $idSubtable, $secondaryDimension, false);

        if (empty($secondaryDimension) && Common::getRequestVar('flat', '0', 'string') == '1') {
            $dataTable->filter('RemoveSubtables');
        }

        return $dataTable;
    }

    /**
     * @param int    $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @param bool|int $idSubtable
     * @param bool|string $secondaryDimension
     * @return DataTable
     */
    public function getGroupedAudioResources($idSite, $period, $date, $segment = false, $idSubtable = false, $secondaryDimension = false)
    {
        Piwik::checkUserHasViewAccess($idSite);
        $dataTable = $this->getDataTable(Archiver::RECORD_AUDIO_GROUPEDRESOURCES, $idSite, $period, $date, $segment, $idSubtable, $secondaryDimension, false);

        if (empty($secondaryDimension) && Common::getRequestVar('flat', '0', 'string') == '1') {
            $dataTable->filter('RemoveSubtables');
        }

        return $dataTable;
    }

    /**
     * @param int    $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @return DataTable
     */
    public function getVideoHours($idSite, $period, $date, $segment = false)
    {
        Piwik::checkUserHasViewAccess($idSite);
        $dataTable = $this->getDataTable(Archiver::RECORD_VIDEO_HOURS, $idSite, $period, $date, $segment, false);

        $timezone = Site::getTimezoneFor($idSite);

        $dataTable->filter('Piwik\Plugins\MediaAnalytics\DataTable\Filter\RemoveHoursInFuture', array($timezone, $period, $date));
        $dataTable->filter('Piwik\Plugins\MediaAnalytics\DataTable\Filter\PrettyHoursLabel');

        return $dataTable;
    }

    /**
     * @param int    $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @return DataTable
     */
    public function getAudioHours($idSite, $period, $date, $segment = false)
    {
        Piwik::checkUserHasViewAccess($idSite);
        $dataTable = $this->getDataTable(Archiver::RECORD_AUDIO_HOURS, $idSite, $period, $date, $segment, false);

        $timezone = Site::getTimezoneFor($idSite);

        $dataTable->filter('Piwik\Plugins\MediaAnalytics\DataTable\Filter\RemoveHoursInFuture', array($timezone, $period, $date));
        $dataTable->filter('Piwik\Plugins\MediaAnalytics\DataTable\Filter\PrettyHoursLabel');

        return $dataTable;
    }

    /**
     * @param int    $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @return DataTable
     */
    public function getVideoResolutions($idSite, $period, $date, $segment = false)
    {
        Piwik::checkUserHasViewAccess($idSite);
        return $this->getDataTable(Archiver::RECORD_VIDEO_RESOLUTIONS, $idSite, $period, $date, $segment, false);
    }

    /**
     * @param int    $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @return DataTable
     */
    public function getPlayers($idSite, $period, $date, $segment = false)
    {
        Piwik::checkUserHasViewAccess($idSite);
        $dataTable = $this->getDataTable(Archiver::RECORD_PLAYER_NAMES, $idSite, $period, $date, $segment, false);
        $dataTable->queueFilter('AddSegmentByLabel', array('media_player'));

        return $dataTable;
    }

    /**
     * @param $recordName
     * @param $idSite
     * @param $period
     * @param $date
     * @param $segment
     * @param null|int $idSubtable
     * @param bool|string $secondaryDimension
     * @param $expandedDepth
     * @return DataTable
     */
    private function getDataTable($recordName, $idSite, $period, $date, $segment, $idSubtable = null, $secondaryDimension = false, $expandedDepth = false, $flat = false)
    {
        if ($idSubtable === false) {
            $idSubtable = null;
        }

        if ($expandedDepth === false) {
            $expandedDepth = null;
        }

        $table = Archive::createDataTableFromArchive($recordName, $idSite, $period, $date, $segment, (bool) $expandedDepth, $flat, $idSubtable, $expandedDepth);
        $table->disableFilter('ReplaceColumnNames');

        if (method_exists($table, 'setMetadata')) {
            $table->setMetadata(DataTable::COLUMN_AGGREGATION_OPS_METADATA_NAME, Archiver::getColumnAggregationOpteration());
        }

        if ($secondaryDimension) {
            if ($table instanceof DataTable\Map) {
                throw new \Exception('Requesting multiple dates or sites is currently not supported when a secondary dimension is set.');
            }

            /** @var DataTable $dataTable */
            $row = $table->getRowFromLabel($secondaryDimension);

            if (empty($row)) {
                return $table;
            }

            // check if subtable is already loaded otherwise load it directly
            $subTable = $row->getSubtable();

            if ($subTable instanceof DataTable) {
                $table = $subTable;
            } else {
                $actualIdSubtable = $row->getIdSubDataTable();

                $table->setRows(array());

                if (empty($actualIdSubtable)) {
                    return $table;
                }

                DataTable\Manager::getInstance()->deleteTable($table->getId());
                $table = null;

                $table = Archive::createDataTableFromArchive($recordName, $idSite, $period, $date, $segment, $expanded = false, $flat = false, $actualIdSubtable);
                $table->disableFilter('ReplaceColumnNames');
            }

            switch ($secondaryDimension) {
                case Archiver::SECONDARY_DIMENSION_MEDIA_PROGRESS:
                    $table->filter('Piwik\Plugins\MediaAnalytics\DataTable\Filter\AddMissingPercentages');
                    $table->queueFilter('Piwik\Plugins\MediaAnalytics\DataTable\Filter\PrettyPercentLabel');
                    break;
                case Archiver::SECONDARY_DIMENSION_HOURS:
                    $table->queueFilter('Piwik\Plugins\MediaAnalytics\DataTable\Filter\PrettyHoursLabel');
                    break;

                case Archiver::SECONDARY_DIMENSION_SPENT_TIME:
                    $table->filter('Piwik\Plugins\MediaAnalytics\DataTable\Filter\AddMissingSpentTime');
                    $table->queueFilter('Piwik\Plugins\MediaAnalytics\DataTable\Filter\PrettyTimeLabel');
                    break;

                case Archiver::SECONDARY_DIMENSION_MEDIA_SEGMENTS:
                    $table->filter(function (DataTable $table) {
                        $tableSummary = $table->getRowFromLabel(Archiver::METADATA_ROW);
                        $tableSummaryId = $table->getRowIdFromLabel(Archiver::METADATA_ROW);
                        if ($tableSummary) {
                            $table->deleteRow($tableSummaryId);
                            $sumPlays = $tableSummary->getColumn(Metrics::METRIC_SUM_PLAYS);
                            $maxLength = $tableSummary->getColumn(Metrics::METRIC_MAX_MEDIA_LENGTH);
                        } else {
                            $sumPlays = 0;
                            $maxLength = 0;
                        }

                        $table->filter('Piwik\Plugins\MediaAnalytics\DataTable\Filter\AddMissingSegments', array(
                            $sumPlays, $maxLength
                        ));
                        $table->filter('ColumnCallbackAddColumn', array(array(), Metrics::METRIC_SUM_PLAYS, function () use ($sumPlays) {
                            return $sumPlays;
                        }));
                    });

                    $table->queueFilter('Piwik\Plugins\MediaAnalytics\DataTable\Filter\PrettyTimeLabel');
                    break;
            }
        }

        $table->disableFilter('AddColumnsProcessedMetrics');
        $table->queueFilter('Piwik\Plugins\MediaAnalytics\DataTable\Filter\RenameUnknownLabel');

        return $table;
    }

    /**
     * Check whether the provided lastMinutes value is within the allowed range. If the value is too low or greater than
     * the maxMinutes value, an exception is thrown.
     *
     * @param int $lastMinutes The parameter value provided to the API
     * @return void
     * @internal
     * @throws Exception If the provided values aren't valid
     */
    private function checkLastNMinutes(int $lastMinutes)
    {
        (new \Piwik\Validators\NumberRange(0, self::MAX_LAST_N_HOURS * 60))->validate($lastMinutes);
    }
}
