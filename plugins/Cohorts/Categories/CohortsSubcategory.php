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

namespace Piwik\Plugins\Cohorts\Categories;

use Piwik\Category\Subcategory;
use Piwik\Piwik;
use Piwik\Url;

class CohortsSubcategory extends Subcategory
{
    protected $categoryId = 'General_Visitors';
    protected $id = 'Cohorts_Cohorts';
    protected $order = 91;
    protected $icon = 'icon-refresh';

    public function getHelp()
    {
        return '<p>' . Piwik::translate('Cohorts_CohortsSubcategoryHelp1') . '</p>'
            . '<p><a href="' . Url::addCampaignParametersToMatomoLink('https://matomo.org/faq/reports/analyse-cohorts/', null, null, 'App.Cohorts.getCohortsOverTime')
            . '" rel="noreferrer noopener" target="_blank">' . Piwik::translate('Cohorts_CohortsSubcategoryHelp2') . '</a></p>';
    }
}
