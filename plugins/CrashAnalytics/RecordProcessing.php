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
use Piwik\DataTable;
use Piwik\Date;
use Piwik\Metrics\Formatter;
use Piwik\Piwik;
use Piwik\Plugins\CrashAnalytics\Columns\Metrics\VisitsCrashRate;
use Piwik\Plugins\CrashAnalytics\Dao\LogCrash;
use Piwik\Tracker\Cache;
use Piwik\Url;

/**
 * Contains methods to used to manipulate report DataTables before they are returned in the API.
 *
 * Most methods return a closure so the caller can decide whether to use DataTable::filter()
 * or DataTable::queueFilter().
 */
class RecordProcessing
{
    /**
     * @var LogCrash
     */
    private $logCrash;

    private $datetimeColumns = [
        'datetime_first_seen' => 'crash_first_seen',
        'datetime_last_seen' => 'crash_last_seen',
        'datetime_last_reappeared' => 'crash_last_reappeared',
    ];

    public function __construct(LogCrash $logCrash)
    {
        $this->logCrash = $logCrash;
    }

    public function splitLabel()
    {
        $crashDeleted = Piwik::translate('CrashAnalytics_CrashDeleted');
        return function (DataTable $dt) use ($crashDeleted) {
            foreach ($dt->getRowsWithoutSummaryRow() as $row) {
                $labelParts = json_decode($row->getColumn('label'), true);

                $row->setColumn('label', $labelParts[0] ?? $crashDeleted);
                $row->setColumn('crash_source', $labelParts[1] ?? null);
            }
        };
    }

    public function setMissingSourceLabel()
    {
        $unknown = Piwik::translate('General_Unknown');

        return function (DataTable $dt) use ($unknown) {
            foreach ($dt->getRowsWithoutSummaryRow() as $row) {
                $crashSource = $row->getColumn('crash_source');
                if (empty($crashSource)) {
                    $row->setColumn('crash_source', $unknown);
                }
            }
        };
    }

    public function setDynamicCrashData(DataTable\DataTableInterface $dataTable, $isSubtable = false)
    {
        // if we're not sorting by one of the columns we're adding, or this isn't for a subtable in an expanded
        // report request, we can use queueFilter and make sure we look at less data overall. if we're sorting
        // by one of them, then we need to have all the data present before limiting/truncation is done.
        // and queued filters aren't run on subtables when expanded=1 so we have to use filter then.
        $filterMethod = $this->isSortingByDynamicCrashData() || $isSubtable ? 'filter' : 'queueFilter';

        $dataTable->$filterMethod(function (DataTable $dt) {
            $idlogcrashes = $dt->getRowsMetadata('idlogcrash');
            $idlogcrashes = array_filter($idlogcrashes);
            $idlogcrashes = array_unique($idlogcrashes);

            $extraData = $this->logCrash->fetchDynamicCrashData($idlogcrashes);

            foreach ($dt->getRows() as $row) {
                $idlogcrash = $row->getMetadata('idlogcrash');
                if (empty($extraData[$idlogcrash])) {
                    continue;
                }

                foreach ($this->datetimeColumns as $inDbName => $name) {
                    if (array_key_exists($inDbName, $extraData[$idlogcrash])) {
                        $value = $extraData[$idlogcrash][$inDbName] ? strtotime($extraData[$idlogcrash][$inDbName]) : $extraData[$idlogcrash][$inDbName];
                        $row->setColumn($name, $value);
                    }
                }
            }
        });

        // this one only needs to use filter() for subtables in expanded reports where queued filters on subtables
        // aren't run
        $filterMethod = $isSubtable ? 'filter' : 'queueFilter';
        $dataTable->$filterMethod(function (DataTable $dt) {
            foreach ($dt->getRows() as $row) {
                foreach ($this->datetimeColumns as $column) {
                    $value = $row->getColumn($column);
                    if (!empty($value)) {
                        $row->setColumn($column, Date::factory($value)->getDatetime());
                    }
                }
            }
        });
    }

    public function changeEmptyLabel($emptyRowLabel)
    {
        return function (DataTable $dt) use ($emptyRowLabel) {
            $row = $dt->getRowFromLabel('');
            if (!empty($row)) {
                $row->setColumn('label', $emptyRowLabel);
                $dt->setLabelsHaveChanged();
            }
        };
    }

    public function keepNewCrashes()
    {
        return function (DataTable $dt) {
            foreach ($dt->getRowsWithoutSummaryRow() as $id => $row) {
                $isNew = $row->getColumn(Metrics::NEW_CRASHES) > 0;
                if (!$isNew) {
                    $dt->deleteRow($id);
                }
            }
        };
    }

    public function keepReappearedCrashes()
    {
        return function (DataTable $dt) {
            foreach ($dt->getRowsWithoutSummaryRow() as $id => $row) {
                $isReappeared = $row->getColumn(Metrics::REAPPEARED_CRASHES) > 0;
                if (!$isReappeared) {
                    $dt->deleteRow($id);
                }
            }
        };
    }

    public function keepFirstPartySources($siteUrls)
    {
        return function (DataTable $dt) use ($siteUrls) {
            foreach ($dt->getRowsWithoutSummaryRow() as $id => $row) {
                $resourceUri = $row->getColumn('crash_source');
                if ($resourceUri === 'inline') {
                    continue;
                }

                $protocol = @parse_url($resourceUri, PHP_URL_SCHEME);
                if (empty($resourceUri)
                    || ($protocol !== 'https' && $protocol !== 'http')
                ) {
                    $dt->deleteRow($id);
                    continue;
                }

                $host = Url::getHostFromUrl($resourceUri);
                if (!$this->isHostPartOfUrls($host, $siteUrls)) {
                    $dt->deleteRow($id);
                }
            }
        };
    }

    public function keepThirdPartySources($siteUrls)
    {
        return function (DataTable $dt) use ($siteUrls) {
            foreach ($dt->getRowsWithoutSummaryRow() as $id => $row) {
                if ($this->isUnknownScriptError($row)) {
                    continue;
                }

                $resourceUri = $row->getColumn('crash_source');

                $protocol = @parse_url($resourceUri, PHP_URL_SCHEME);
                if (empty($resourceUri)
                    || ($protocol !== 'https' && $protocol !== 'http')
                ) {
                    $dt->deleteRow($id);
                    continue;
                }

                $host = Url::getHostFromUrl($resourceUri);
                if ($this->isHostPartOfUrls($host, $siteUrls)) {
                    $dt->deleteRow($id);
                }
            }
        };
    }

    public function moveColumnsToMetadata($columnsToMove)
    {
        return function (DataTable $dt) use ($columnsToMove) {
            foreach ($dt->getRows() as $row) {
                foreach ($columnsToMove as $column) {
                    $value = $row->getColumn($column);
                    if ($value === false) {
                        continue;
                    }

                    $row->deleteColumn($column);
                    $row->setMetadata($column, $value);
                }
            }
        };
    }

    public function moveMetadataToColumn($metadataToMove)
    {
        return function (DataTable $dt) use ($metadataToMove) {
            foreach ($dt->getRows() as $row) {
                foreach ($metadataToMove as $column) {
                    $value = $row->getMetadata($column);
                    $row->deleteMetadata($column);
                    $row->setColumn($column, $value);
                }
            }
        };
    }

    public function formatLastNDate($columnsToFormat)
    {
        $formatter = new Formatter();
        return function (DataTable $dt) use ($columnsToFormat, $formatter) {
            foreach ($dt->getRows() as $row) {
                foreach ($columnsToFormat as $column) {
                    $value = $row->getColumn($column);
                    if ($value === false) {
                        continue;
                    }

                    $secondsToNow = Date::now()->getTimestamp() - Date::factory($value)->getTimestamp();
                    $formatted = $formatter->getPrettyTimeFromSeconds($secondsToNow, true);
                    $formatted = Piwik::translate('General_TimeAgo', $formatted);
                    $row->setColumn($column . '_pretty', $formatted);
                }
            }
        };
    }

    public function removeIgnoredCrashes(DataTable\DataTableInterface $table, $idSite)
    {
        $cache = Cache::getCacheWebsiteAttributes($idSite);
        $ignoredHashes = $cache['CrashAnalytics']['ignored'] ?? [];
        if (empty($ignoredHashes)) {
            return;
        }

        // entire list of ignored crashes is not stored solely in tracker cache, so we have to query log_crash
        if (count($ignoredHashes) >= CrashAnalytics::getLimitIgnoredCrashesInTracker()) {
            $ignoredHashes = $this->logCrash->getIgnoredCrashHashesForSite($idSite);
        }

        $table->filter($this->removeCrashesByIdLogCrash($ignoredHashes));
    }

    public function removeCrashesByIdLogCrash($hashesByIdLogCrash)
    {
        return function (DataTable $table) use ($hashesByIdLogCrash) {
            foreach ($table->getRows() as $rowId => $row) {
                $idLogCrash = $row->getMetadata('idlogcrash');
                if (is_numeric($idLogCrash) && array_key_exists($idLogCrash, $hashesByIdLogCrash)) {
                    $table->deleteRow($rowId);
                }
            }
        };
    }

    public function addCrashIdSegment()
    {
        return function (DataTable $table) {
            foreach ($table->getRows() as $row) {
                $idLogCrash = $row->getMetadata('idlogcrash') ?: $row->getColumn('idlogcrash');
                if (!empty($idLogCrash)) {
                    $row->addMetadata('segment', 'crashId==' . (int)$idLogCrash);
                }
            }
        };
    }

    public function removeCrashesWithUnknownSource()
    {
        return function (DataTable $table) {
            foreach ($table->getRows() as $key => $row) {
                $crashSource = $row->getColumn('crash_source');
                if (empty($crashSource)) {
                    $table->deleteRow($key);
                }
            }
        };
    }

    public function keepCrashesWithUnknownSource()
    {
        return function (DataTable $table) {
            foreach ($table->getRows() as $key => $row) {
                $crashSource = $row->getColumn('crash_source');
                if (!empty($crashSource)) {
                    $table->deleteRow($key);
                }
            }
        };
    }

    private function isSortingByDynamicCrashData()
    {
        return in_array(Common::getRequestVar('filter_sort_column', false), $this->datetimeColumns)
            || in_array(Common::getRequestVar('filter_sort_column_secondary', false), $this->datetimeColumns);
    }

    private function isHostPartOfUrls($host, $urls)
    {
        if (empty($host)) {
            return true;
        }

        if ($this->isHostInUrls($host, $urls)) {
            return true;
        }

        return false;
    }

    private function isHostInUrls($hostToCheck, $urls)
    {
        $host = mb_strtolower($hostToCheck);

        foreach ($urls as $url) {
            if (mb_strtolower($url) === $host) {
                return true;
            }

            $parsedUrl = parse_url($url);
            if (empty($parsedUrl['host'])) {
                continue;
            }

            $siteHost = mb_strtolower($parsedUrl['host']);
            $checkSubdomain = empty($parsedUrl['path']) || $parsedUrl == '/';

            if ($siteHost === $host) {
                return true;
            }

            if ($checkSubdomain && Common::stringEndsWith($host, '.' . $siteHost)) {
                return true;
            }
        }

        return false;
    }

    public function addVisitsCrashRate(DataTable\DataTableInterface $table, $idSite, $period, $date, $segment)
    {
        $visitsMetrics = Request::processRequest('VisitsSummary.get', [
            'idSite' => $idSite,
            'period' => $period,
            'date' => $date,
            'segment' => $segment,
            'filter_offset' => 0,
            'columns' => 'nb_visits',
        ]);

        $this->multiFilter($table, [$visitsMetrics], function ($tableToAddTo, $visitsMetricsTable) {
            $visits = empty($visitsMetricsTable) || !$visitsMetricsTable->getRowsCount() ? 0 : (int)$visitsMetricsTable->getFirstRow()->getColumn('nb_visits');

            $extraProcessedMetrics = $tableToAddTo->getMetadata(DataTable::EXTRA_PROCESSED_METRICS_METADATA_NAME) ?: [];
            $extraProcessedMetrics[] = new VisitsCrashRate($visits);
            $tableToAddTo->setMetadata(DataTable::EXTRA_PROCESSED_METRICS_METADATA_NAME, $extraProcessedMetrics);

            $tableToAddTo->setMetadata('nb_visits', $visits); // for use by filters report classes to add tooltips
        });
    }

    public function removeSummaryRow()
    {
        return function (DataTable $table) {
            $table->deleteRow(DataTable::ID_SUMMARY_ROW);
        };
    }

    public function multiFilter(DataTable\DataTableInterface $dataTable, $otherTables, $callback)
    {
        if ($dataTable instanceof DataTable\Map) {
            foreach ($dataTable->getDataTables() as $key => $childTable) {
                $otherChildTables = array_map(function (DataTable\Map $otherTable) use ($key) {
                    if (!$otherTable->hasTable($key)) {
                        return null;
                    }
                    return $otherTable->getTable($key);
                }, $otherTables);
                $this->multiFilter($childTable, $otherChildTables, $callback);
            }
        } else {
            $callback(...array_merge([$dataTable], $otherTables));
        }
    }

    private function isUnknownScriptError(DataTable\Row $row)
    {
        $message = $row->getColumn('label');
        $message = strtolower($message);
        $message = rtrim($message, '.');
        $crashSource = $row->getColumn('crash_source');
        return empty($crashSource) && $message == 'script error';
    }
}
