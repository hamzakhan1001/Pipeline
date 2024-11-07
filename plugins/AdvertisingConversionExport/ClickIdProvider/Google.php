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

use Piwik\Plugins\AdvertisingConversionExport\Export\Adapter\GoogleAds;

class Google extends ClickIdProviderAbstract
{
    public const ID = 'Google';
    public const CLICK_ID_REQUEST_PARAM = 'gclid';

    public function getName(): string
    {
        return 'Google Ads';
    }

    public function getLogoUrl(): string
    {
        return 'plugins/AdvertisingConversionExport/images/Google.svg';
    }

    public function getExportID(): string
    {
        return GoogleAds::ID;
    }
}
