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
 * @link    https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */

namespace Piwik\Plugins\AdvertisingConversionExport\Tracker;

use Piwik\Common;
use Piwik\Plugins\AdvertisingConversionExport\AdvertisingConversionExport;
use Piwik\Plugins\AdvertisingConversionExport\Dao\LogClickId;
use Piwik\Plugins\AdvertisingConversionExport\SystemSettings;
use Piwik\Tracker;
use Piwik\Tracker\Request;
use Piwik\Tracker\Visit\VisitProperties;

class RequestProcessor extends Tracker\RequestProcessor
{
    /**
     * @var LogClickId
     */
    private $logTableDao;

    private $clickIdAndProvider = null;

    public function __construct(LogClickId $logTableDao)
    {
        $this->logTableDao = $logTableDao;
    }

    public function manipulateRequest(Request $request)
    {
        $this->clickIdAndProvider = $this->getClickIdAndProviderFromRequest($request);
    }

    public function recordLogs(VisitProperties $visitProperties, Request $request)
    {
        if ($request->getMetadata('CoreHome', 'isNewVisit') && !empty($this->clickIdAndProvider)) {
            Common::printDebug('[AdvertisingConversionExport] new click id found in request.');

            $visit = [
                'idvisit'     => $visitProperties->getProperty('idvisit'),
                'idvisitor'   => $visitProperties->getProperty('idvisitor'),
                'adclickid'   => $this->clickIdAndProvider['adclickid'],
                'adprovider'  => $this->clickIdAndProvider['provider'],
                'server_time' => date('Y-m-d H:i:s', $request->getCurrentTimestamp()),
            ];

            $this->logTableDao->insertVisit($visit);
        }
    }

    public function afterRequestProcessed(VisitProperties $visitProperties, Request $request)
    {
        if (empty($this->clickIdAndProvider)) {
            return; // abort if there is no clickid in the request
        }

        $idVisit = $visitProperties->getProperty('idvisit');

        // force new visit if click id parameter changed
        $existingVisit = !empty($idVisit) ? $this->logTableDao->findIdVisits([$idVisit]) : '';

        $visitorClickId = !empty($existingVisit[0]['adclickid']) ? $existingVisit[0]['adclickid'] : '';
        $visitorClickIdProvider = !empty($existingVisit[0]['adprovider']) ? $existingVisit[0]['adprovider'] : '';

        if (
            (!empty($this->clickIdAndProvider['adclickid']) && $visitorClickId != $this->clickIdAndProvider['adclickid']) ||
            (!empty($this->clickIdAndProvider['provider']) && $visitorClickIdProvider != $this->clickIdAndProvider['provider'])
        ) {
            Common::printDebug('[AdvertisingConversionExport] new click id found in request. Forcing a new visit.');
            $request->setMetadata('CoreHome', 'isNewVisit', true);
        }
    }

    /**
     * @param Request $request
     * @return bool|array
     */
    protected function getClickIdAndProviderFromRequest(Request $request)
    {
        $providers = AdvertisingConversionExport::getAvailableClickIdProviders();
        $idSite = $request->getIdSite();
        $cache = Tracker\Cache::getCacheWebsiteAttributes($idSite);

        $allConfiguredExportTypes = (!empty($cache[AdvertisingConversionExport::SITE_CONVERSION_AVAILABLE_EXPORTS]) ? $cache[AdvertisingConversionExport::SITE_CONVERSION_AVAILABLE_EXPORTS] : []);

        $rawParams = $request->getRawParams();

        //fixes for #PG-3165 as the url param was an array
        if (empty($rawParams['url']) || !is_string($rawParams['url'])) {
            return false; //as there is no point checking further if url is empty
        }

        parse_str(parse_url($rawParams['url'] ?? '', PHP_URL_QUERY) ?? '', $params);

        foreach ($providers as $provider) {
            if (empty($provider::CLICK_ID_REQUEST_PARAM)) {
                continue;
            }
            $requestClickId = Common::getRequestVar($provider::CLICK_ID_REQUEST_PARAM, '', null, $params);
            if (!empty($requestClickId)) {
                $systemSetting = new SystemSettings();
                return [
                    'adclickid' => (!empty($allConfiguredExportTypes[$provider->getExportID()]) || !in_array($provider::ID, $systemSetting->anonymize_click_ids->getValue())) ? $requestClickId : 'anonymized',
                    'provider'  => $provider::ID,
                ];
            }
        }

        return false;
    }
}
