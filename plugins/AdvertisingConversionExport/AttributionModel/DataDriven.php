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

namespace Piwik\Plugins\AdvertisingConversionExport\AttributionModel;

use Piwik\Piwik;

class DataDriven extends AttributionModelAbstract
{
    public const ID = 'dataDriven';

    public function getExportName(): string
    {
        return 'Data-driven';
    }

    public function getTranslatedName(): string
    {
        return Piwik::translate('AdvertisingConversionExport_DataDrivenAttributionModel');
    }
}
