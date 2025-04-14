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

namespace Piwik\Plugins\SEOWebVitals\Dao;

use Piwik\Plugins\SEOWebVitals\Dao\PageSpeedApi\Client;
use Piwik\Plugins\SEOWebVitals\Dao\PageSpeedApi\PageSpeedApiException;
use Piwik\Plugins\SEOWebVitals\Dao\PageSpeedApi\QuotaExceededException;
use Piwik\Plugins\SEOWebVitals\Dao\PageSpeedApi\SslRequiredException;
use Piwik\Plugins\SEOWebVitals\Dao\PageSpeedApi\AccessDeniedException;
use Piwik\UrlHelper;
use Piwik\Plugins\SEOWebVitals\Dao\PageSpeedApi\SiteNotAccesibleException;

class PageSpeedApi
{
    public const STRATEGY_DESKTOP = 'DESKTOP';
    public const STRATEGY_MOBILE = 'MOBILE';

    private $apiKey = '';

    /**
     * @var Client
     */
    private $client;

    public function __construct($apiKey, Client $client)
    {
        $this->apiKey = $apiKey;
        $this->client = $client;
    }

    public function hasApiKeyConfigured()
    {
        return !empty($this->apiKey);
    }

    public function looksLikeValidUrl($url)
    {
        return UrlHelper::isLookLikeUrl($url)
            && Pages::startsWithHttpProtocol($url);
    }

    /**
     * @param $url
     * @param $strategy
     * @return PageSpeedReport
     * @throws \Exception
     */
    public function fetch($url, $strategy)
    {
        $apiKey = '';
        if ($this->apiKey) {
            $apiKey = '&key=' . rawurlencode($this->apiKey);
        }
        if ($strategy === self::STRATEGY_DESKTOP || $strategy === self::STRATEGY_MOBILE) {
            $strategy = 'strategy=' . rawurlencode($strategy);
        }
        $apiUrl = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?' . $strategy . $apiKey . '&url=' . rawurlencode($url);

        $response = $this->client->fetch($apiUrl);
        if (empty($response)) {
            throw new PageSpeedApiException('Got no response from page speed insight api for URL: ' . $url);
        }
        $response = json_decode($response, true);
        if (empty($response)) {
            throw new PageSpeedApiException('Seems like page speed insight api returned no valid JSON: ' . $response . ' for url: ' . $url);
        }

        if (!empty($response['error']['code'])) {
            if ($response['error']['code'] === 403) {
                // Quota exceeded for quota metric 'Queries' and limit 'Queries per minute' of service 'pagespeedonline.googleapis.com' for consumer 'project_number:...'
                if (stripos($response['error']['message'], 'SSL') !== false) {
                    //since SSL error is thrown as 403
                    throw new SslRequiredException($response['error']['status'] . ': ' . $response['error']['message']);
                } else {
                    //Rest all errors are AccessDenied
                    throw new AccessDeniedException($response['error']['status'] . ': ' . $response['error']['message']);
                }
            }

            if ($response['error']['code'] === 429) {
                // Quota exceeded for quota metric 'Queries' and limit 'Queries per minute' of service 'pagespeedonline.googleapis.com' for consumer 'project_number:...'
                throw new QuotaExceededException($response['error']['status'] . ': ' . $response['error']['message']);
            }

            if ($response['error']['code'] === 500 || $response['error']['code'] === 400) {
                throw new SiteNotAccesibleException($response['error']['message']);
            }

            throw new PageSpeedApiException($response['error']['status'] . ': ' . $response['error']['message']);
        }

        $report = new PageSpeedReport($response);
        $report->removeUnneededFields();

        return $report;
    }

    public static function getAllStrategies()
    {
        return [self::STRATEGY_MOBILE, self::STRATEGY_DESKTOP];
    }
}
