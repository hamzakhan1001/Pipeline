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

namespace Piwik\Plugins\SEOWebVitals\Categories;

use Piwik\Category\Subcategory;
use Piwik\Piwik;
use Piwik\Url;

class WebVitalsSubcategory extends Subcategory
{
    protected $categoryId = 'Referrers_Referrers';
    protected $id = 'SEOWebVitals_SEOWebVitals';
    protected $order = 20;

    public function getHelp()
    {
        return '<p>' . Piwik::translate('SEOWebVitals_WebVitalsReportDocumentation') . '</p>'
            . '<p><a target="_blank" rel="noopener noreferrer" href="'
            . Url::addCampaignParametersToMatomoLink(
                'https://matomo.org/guide/reports/seo-web-vitals/',
                null,
                null,
                'App.SEOWebVitals.subcategory'
            ) . '"><span class="icon-info"></span> ' . Piwik::translate('SEOWebVitals_LearnMoreWebVitalAndImprove') . '</a></p>';
    }
}
