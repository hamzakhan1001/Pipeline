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

namespace Piwik\Plugins\AdvertisingConversionExport\Columns;

use Piwik\Piwik;

class AdClickId extends ClickIdLogColumn
{
    protected $columnName = 'adclickid';
    protected $segmentName = 'adClickId';
    protected $type = self::TYPE_TEXT;
    protected $nameSingular = 'AdvertisingConversionExport_AdClickId';

    public function __construct()
    {
        $this->acceptValues = Piwik::translate('AdvertisingConversionExport_AdClickIdDescription');
    }
}
