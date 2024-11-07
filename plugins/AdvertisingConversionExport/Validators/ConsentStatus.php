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

namespace Piwik\Plugins\AdvertisingConversionExport\Validators;

use Piwik\Piwik;
use Piwik\Validators\BaseValidator;
use Piwik\Validators\Exception;

class ConsentStatus extends BaseValidator
{
    private $availableStatuses;

    public function __construct($availableStatuses = [])
    {
        $this->availableStatuses = $availableStatuses;
    }

    public function validate($value)
    {
        if (empty($value)) {
            return true;
        }

        if (in_array($value, $this->availableStatuses)) {
            throw new Exception(Piwik::translate('AdvertisingConversionExport_InvalidConsentStatusException'));
        }

        return true;
    }
}
