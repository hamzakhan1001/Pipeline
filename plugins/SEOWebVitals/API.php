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

namespace Piwik\Plugins\SEOWebVitals;

use Piwik\API\Request;
use Piwik\Archive;
use Piwik\DataTable;
use Piwik\Date;
use Piwik\Piwik;
use Piwik\Plugins\SEOWebVitals\Dao\Pages;
use Piwik\Plugins\SEOWebVitals\DataTable\Filter\Audits;
use Piwik\Plugins\SEOWebVitals\DataTable\Filter\CalculateAverages;
use Piwik\Plugins\SEOWebVitals\DataTable\Filter\ShortenUrl;
use Piwik\Site;

/**
 * API for plugin SEOWebVitals
 *
 * @method static \Piwik\Plugins\SEOWebVitals\API getInstance()
 */
class API extends \Piwik\Plugin\API
{
    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * Automatically configure the most popular page URLs to be monitored by SEO Web Vitals for the given site.
     *
     * Only works if no URLs have been configured already.
     *
     * @param $idSite
     * @return string[]
     * @throws \Exception
     */
    public function configureTopPageUrls($idSite)
    {
        Piwik::checkUserHasAdminAccess($idSite);

        $sites = new Pages();
        $urlsToMonitor = $sites->getPageUrlsToMonitor($idSite);

        if (!empty($urlsToMonitor)) {
            // no translation cause it can't be triggered by the UI
            throw new \Exception('Some URLs are already configured, cannot set top urls');
        }

        $numUrlsToConfigure = 5;
        $maxUrlsPerSite = $this->configuration->getMaxUrlsPerSite();
        if ($maxUrlsPerSite > -1 && $maxUrlsPerSite < $numUrlsToConfigure) {
            // prevent error if eg only 2 urls are allowed to be configured automatically.
            $numUrlsToConfigure = $maxUrlsPerSite;
        }

        $siteUrls = Request::processRequest('Actions.getPageUrls', [
            'idSite' => $idSite,
            'segment' => '',
            'flat' => 1,
            'filter_limit' => $numUrlsToConfigure,
            'filter_sort_column' => 'nb_visits',
            'filter_sort_order' => 'desc',
            'period' => 'range',
            'date' => Date::now()->subMonth(1)->toString() . ',' . Date::now()->toString()
        ], []);
        $siteUrls = array_map(function($row)  {
            /** @var DataTable\Row $row */
            return $row->getMetadata('url');
        }, $siteUrls->getRowsWithoutSummaryRow());
        $siteUrls = array_filter($siteUrls);
        $siteUrls = array_filter($siteUrls, function ($siteUrl) {
            $siteUrl = trim($siteUrl);
            return Pages::startsWithHttpProtocol($siteUrl);
        });

        if (!empty($siteUrls)) {
            $params = [
                'idSite' => $idSite,
                'settingValues' => [
                    'SEOWebVitals' => [
                        ['name' => 'check_urls', 'value' => $siteUrls]
                    ]
                ]
            ];

            Request::processRequest('SitesManager.updateSite', $params, []);
        }

        return $siteUrls;
    }

    /**
     * Get Web Vitals report data.
     * @param $idSite
     * @param $period
     * @param $date
     * @param null $idSubtable
     * @param false $expanded
     * @param false $flat
     * @return DataTable|DataTable\Map
     * @throws \Exception
     */
    public function getWebVitals($idSite, $period, $date, $idSubtable = null, $expanded = false, $flat = false)
    {
        Piwik::checkUserHasViewAccess($idSite);

        $segment = false;
        $dataTable = Archive::createDataTableFromArchive(Archiver::RECORD_NAME_WEB_VITALS, $idSite, $period, $date, $segment, $expanded, $flat, $idSubtable);
        $dataTable->disableFilter('ReplaceColumnNames');

        $operations = Archiver::getColumnAggregationOpteration();
        $dataTable->filter(function ($dataTable) use ($operations) {
            $dataTable->setMetadata(DataTable::COLUMN_AGGREGATION_OPS_METADATA_NAME, $operations);
        });

        if ($period !== 'day') {
            $dataTable->filter(CalculateAverages::class);
            if ($expanded || $flat) {
                $dataTable->filterSubtables(CalculateAverages::class);
            }
        }

        if (!empty($idSubtable)) {
            $dataTable->filter(Audits::class);
        } else {
            $dataTable->filter(ShortenUrl::class);
            if ($expanded || $flat) {
                $dataTable->filterSubtables(Audits::class);
            }
        }

        return $dataTable;
    }
}
