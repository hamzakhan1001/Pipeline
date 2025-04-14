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

namespace Piwik\Plugins\AdvertisingConversionExport\Categories;

use Piwik\Category\Subcategory;
use Piwik\Piwik;
use Piwik\Url;

class ManageConversionExportsSubcategory extends Subcategory
{
    protected $categoryId = 'Goals_Goals';
    protected $id = 'AdvertisingConversionExport_ConversionExports';
    protected $order = 10000;

    public function getHelp()
    {
        return Piwik::translate('AdvertisingConversionExport_CategoryHelpLearnMore', [
            '<a href="' . Url::addCampaignParametersToMatomoLink('https://matomo.org/guide/manage-matomo/advertising-conversion-export/', null, null, 'AdvertisingConversionExport.getConversionExports')
            . '" rel="noreferrer noopener" target="_blank">', '</a>',
            '<a href="' . Url::addCampaignParametersToMatomoLink('https://matomo.org/faq/reports/how-do-i-get-the-advertising-conversion-export-feature/', null, null, 'AdvertisingConversionExport.getConversionExports')
            . '" rel="noreferrer noopener" target="_blank">', '</a>'
        ]);
    }
}
