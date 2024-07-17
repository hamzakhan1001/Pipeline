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

class Facebook extends ClickIdProviderAbstract
{
    const ID = 'Facebook';
    const CLICK_ID_REQUEST_PARAM = 'fbclid';

    public function getName(): string
    {
        return 'Facebook Ads';
    }

    public function getLogoUrl(): string
    {
        return 'plugins/AdvertisingConversionExport/images/Facebook.svg';
    }

    public function getExportID(): string
    {
        return '';
    }
}
