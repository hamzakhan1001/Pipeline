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

namespace Piwik\Plugins\AdvertisingConversionExport\ClickIdProvider;

use Piwik\Plugins\AdvertisingConversionExport\Export\Adapter\MicrosoftAds;

class Bing extends ClickIdProviderAbstract
{
    const ID = 'Bing';
    const CLICK_ID_REQUEST_PARAM = 'msclkid';

    public function getName(): string
    {
        return 'Bing Ads';
    }

    public function getLogoUrl(): string
    {
        return 'plugins/AdvertisingConversionExport/images/Bing.png';
    }

    public function getExportID(): string
    {
        return MicrosoftAds::ID;
    }
}
