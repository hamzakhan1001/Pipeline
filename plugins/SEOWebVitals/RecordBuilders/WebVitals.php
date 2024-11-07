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

namespace Piwik\Plugins\SEOWebVitals\RecordBuilders;

use Piwik\ArchiveProcessor;
use Piwik\ArchiveProcessor\Record;
use Piwik\ArchiveProcessor\RecordBuilder;
use Piwik\Container\StaticContainer;
use Piwik\DataTable;
use Piwik\DataTable\Row;
use Piwik\Date;
use Piwik\Plugins\SEOWebVitals\Archiver;
use Piwik\Plugins\SEOWebVitals\Dao\Pages;
use Piwik\Plugins\SEOWebVitals\Dao\PageSpeedApi;
use Piwik\Plugins\SEOWebVitals\Dao\PageSpeedApi\SiteNotAccesibleException;
use Piwik\Plugins\SEOWebVitals\Dao\PageSpeedReport;
use Piwik\Plugins\SEOWebVitals\Dao\Reports;
use Piwik\Plugins\SEOWebVitals\Metrics;
use Piwik\SettingsPiwik;
use Piwik\Site;

class WebVitals extends RecordBuilder
{
    public function __construct()
    {
        parent::__construct();

        $this->columnAggregationOps = Archiver::getColumnAggregationOpteration();
    }

    public function getRecordMetadata(ArchiveProcessor $archiveProcessor): array
    {
        return [
            Record::make(Record::TYPE_BLOB, Archiver::RECORD_NAME_WEB_VITALS),
        ];
    }

    protected function aggregate(ArchiveProcessor $archiveProcessor): array
    {
        $idSite = $archiveProcessor->getParams()->getSite()->getId();
        if (empty($idSite)) {
            return [];
        }

        $sites = new Pages();
        $urlsToMonitor = $sites->getPageUrlsToMonitor($idSite);

        if (empty($urlsToMonitor)) {
            return [];
        }

        /** @var PageSpeedApi $pageSpeedApi */
        $pageSpeedApi = StaticContainer::get(PageSpeedApi::class);
        if (!$pageSpeedApi->hasApiKeyConfigured()) {
            // we only fetch reports once an api key has been configured to make sure we don't run into quota issues
            return [];
        }

        $record = new DataTable();
        $record->setMetadata(DataTable::COLUMN_AGGREGATION_OPS_METADATA_NAME, $this->columnAggregationOps);
        $record->filterSubtables(function (DataTable $subtable) {
            $subtable->setMetadata(DataTable::COLUMN_AGGREGATION_OPS_METADATA_NAME, $this->columnAggregationOps);
        });

        $date = $archiveProcessor->getParams()->getPeriod()->getDateStart();

        $strategies = PageSpeedApi::getAllStrategies();

        $reportsDao = new Reports();
        $mapOfReports = $reportsDao->getReportsByUrlByStrategy($idSite, $date);
        $metrics = new Metrics();

        foreach ($urlsToMonitor as $url) {
            if (!$pageSpeedApi->looksLikeValidUrl($url)) {
                continue;
            }

            foreach ($strategies as $strategy) {
                if (!empty($mapOfReports[$url][$strategy])) {
                    $response = $mapOfReports[$url][$strategy];
                } else {
                    $timezone = Site::getTimezoneFor($idSite);
                    $now = Date::factory('now', $timezone);

                    if ($archiveProcessor->getParams()->getPeriod()->toString() !== $now->toString()) {
                        // we cannot fetch this data for historical entries... we're still making sure though to rearchive
                        // any existing report if needed
                        return [];
                    }

                    try {
                        $response = $pageSpeedApi->fetch($url, $strategy);
                    } catch (SiteNotAccesibleException $e) {
                        $this->addRowToRecord($record, $strategy, ['label' => $url, PageSpeedReport::ERROR_SITE_NOT_ACCESSIBLE => 1]);

                        break;// no need to test other strategy in that case as it wouldn't work either
                    } catch (PageSpeedApi\SslRequiredException $e) {
                        $this->addRowToRecord($record, $strategy, ['label' => $url, PageSpeedReport::ERROR_SSL_REQUIRED => 1]);

                        break;// no need to test other strategy in that case as it wouldn't work either
                    } catch (PageSpeedApi\AccessDeniedException $e) {
                        $this->addRowToRecord($record, $strategy, ['label' => $url, PageSpeedReport::ERROR_ACCESS_DENIED => 1]);

                        break;// no need to test other strategy in that case as it wouldn't work either
                    }
                    $reportsDao->addReport($idSite, $date, $url, $strategy, $response->toArray());
                    $metrics->updateAuditMetrics($response->getAuditMetrics());
                }
                /** @var PageSpeedReport $response */

                if ($response->hasLoadingExperience()) {
                    $this->addRowToRecord($record, $strategy, [
                        'label' => $url,
                        Metrics::METRIC_LOAD_EXPERIENCE_NUM_CHECKS => 1,
                        Metrics::METRIC_PERFORMANCE_SCORE => $response->getPerformanceScore(),
                        Metrics::METRIC_LOAD_EXPERIENCE_CLS_CATEGORY => $response->getCumulativeLayoutShiftCategory(),
                        Metrics::METRIC_LOAD_EXPERIENCE_CLS_NUMERICVALUE => $response->getCumulativeLayoutShiftValue(),

                        Metrics::METRIC_LOAD_EXPERIENCE_FID_CATEGORY => $response->getFirstInputDelayCategory(),
                        Metrics::METRIC_LOAD_EXPERIENCE_FID_NUMERICVALUE => $response->getFirstInputDelayValue(),

                        Metrics::METRIC_LOAD_EXPERIENCE_INP_CATEGORY => $response->getInteractionToNextPaintCategory(),
                        Metrics::METRIC_LOAD_EXPERIENCE_INP_NUMERICVALUE => $response->getInteractionToNextPaintValue(),

                        Metrics::METRIC_LOAD_EXPERIENCE_LCP_CATEGORY => $response->getLargestContentfulPaintCategory(),
                        Metrics::METRIC_LOAD_EXPERIENCE_LCP_NUMERICVALUE => $response->getLargestContentfulPaintValue(),

                        Metrics::METRIC_LOAD_EXPERIENCE_FCP_CATEGORY => $response->getFirstContentfulPaintCategory(),
                        Metrics::METRIC_LOAD_EXPERIENCE_FCP_NUMERICVALUE => $response->getFirstContentfulPaintValue(),
                    ]);
                }

                if ($response->hasAudits()) {
                    foreach ($response->getAudits() as $key => $audit) {
                        if (
                            empty($audit['id'])
                            || $audit['scoreDisplayMode'] === 'informative'
                            || $audit['scoreDisplayMode'] === 'notApplicable'
                        ) {
                            continue;
                        }
                        $id = $audit['id'];
                        $score = '';
                        if (isset($audit['score'])) {
                            $score = $audit['score'] * 100;
                        }

                        $displayValue = '';
                        if (isset($audit['displayValue'])) {
                            $displayValue = $audit['displayValue'];
                        }
                        $numericValue = 0;
                        if (isset($audit['numericValue'])) {
                            $numericValue = (int) $audit['numericValue'];
                        }

                        $this->addRowToRecord($record, $strategy, [
                            'label' => $url,
                            'sublabel' => $id,
                            Metrics::METRIC_AUDIT_SCORE => $score,
                            Metrics::METRIC_AUDIT_NUMERIC_VALUE => $numericValue,
                            Metrics::METRIC_AUDIT_DISPLAY_VALUE => $displayValue
                        ]);
                    }
                }
            }
        }

        return [Archiver::RECORD_NAME_WEB_VITALS => $record];
    }

    public function isEnabled(ArchiveProcessor $archiveProcessor): bool
    {
        // we don't archive in these cases to reduce the amount of api calls as segmentation doesn't work anyway
        return $archiveProcessor->getParams()->getSegment()->isEmpty() && SettingsPiwik::isInternetEnabled();
    }

    public function addRowToRecord(DataTable $record, string $strategy, array $row): void
    {
        $label = $row['label'];
        unset($row['label']);
        $subLabel = null;

        if (isset($row['sublabel'])) {
            $subLabel = $row['sublabel'];
            unset($row['sublabel']);
        }

        $topLevelRow = $record->getRowFromLabel($label);
        if (empty($topLevelRow)) {
            $topLevelRow = new Row([Row::COLUMNS => ['label' => $label] + self::createEmptyRow()]);
            $record->addRow($topLevelRow);
        }

        if (isset($row[PageSpeedReport::ERROR_SITE_NOT_ACCESSIBLE])) {
            $topLevelRow->setColumn(PageSpeedReport::ERROR_SITE_NOT_ACCESSIBLE, PageSpeedReport::ERROR_SITE_NOT_ACCESSIBLE);
        }
        if (isset($row[PageSpeedReport::ERROR_SSL_REQUIRED])) {
            $topLevelRow->setColumn(PageSpeedReport::ERROR_SSL_REQUIRED, PageSpeedReport::ERROR_SSL_REQUIRED);
        }
        if (isset($row[PageSpeedReport::ERROR_ACCESS_DENIED])) {
            $topLevelRow->setColumn(PageSpeedReport::ERROR_ACCESS_DENIED, PageSpeedReport::ERROR_ACCESS_DENIED);
        }

        $topLevelMetrics = array_merge([Metrics::METRIC_LOAD_EXPERIENCE_NUM_CHECKS], Metrics::TOP_LEVEL_ROW_METRICS);
        foreach ($topLevelMetrics as $topLevelMetric) {
            if (isset($row[$topLevelMetric])) {
                $topLevelRow->setColumn(Metrics::appendStrategy($topLevelMetric, $strategy), $row[$topLevelMetric]);
            }
        }

        if ($subLabel) {
            $subtable = $topLevelRow->getSubtable();
            if (empty($subtable)) {
                $subtable = new DataTable();
                $topLevelRow->setSubtable($subtable);
            }

            $subtableRow = $subtable->getRowFromLabel($subLabel);
            if (empty($subtableRow)) {
                $subtableRow = new Row([Row::COLUMNS => ['label' => $subLabel] + self::createEmptySubtableRow()]);
                $subtable->addRow($subtableRow);
            }

            foreach ($row as $column => $value) {
                if (in_array($column, Metrics::SUB_LEVEL_ROW_METRICS, true)) {
                    $subtableRow->setColumn(Metrics::appendStrategy($column, $strategy), $value);
                }
            }
        }
    }

    public static function createEmptyRow(): array
    {
        return Metrics::appendAllStrategies([
            Metrics::METRIC_PERFORMANCE_SCORE => '',
            Metrics::METRIC_LOAD_EXPERIENCE_CLS_CATEGORY => '',
            Metrics::METRIC_LOAD_EXPERIENCE_CLS_NUMERICVALUE => 0,

            Metrics::METRIC_LOAD_EXPERIENCE_FID_CATEGORY => '',
            Metrics::METRIC_LOAD_EXPERIENCE_FID_NUMERICVALUE => 0,

            Metrics::METRIC_LOAD_EXPERIENCE_INP_CATEGORY => '',
            Metrics::METRIC_LOAD_EXPERIENCE_INP_NUMERICVALUE => 0,

            Metrics::METRIC_LOAD_EXPERIENCE_LCP_CATEGORY => '',
            Metrics::METRIC_LOAD_EXPERIENCE_LCP_NUMERICVALUE => 0,

            Metrics::METRIC_LOAD_EXPERIENCE_FCP_CATEGORY => '',
            Metrics::METRIC_LOAD_EXPERIENCE_FCP_NUMERICVALUE => 0,

            Metrics::METRIC_LOAD_EXPERIENCE_NUM_CHECKS => 0,
        ]);
    }

    public static function createEmptySubtableRow(): array
    {
        return Metrics::appendAllStrategies([
            Metrics::METRIC_AUDIT_SCORE => 0,
            Metrics::METRIC_AUDIT_NUM_CHECKS => 1,
        ]);
    }
}
