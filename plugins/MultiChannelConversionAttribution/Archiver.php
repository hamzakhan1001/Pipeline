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

namespace Piwik\Plugins\MultiChannelConversionAttribution;

class Archiver extends \Piwik\Plugin\Archiver
{
    public const RECORD_CHANNEL_TYPES = "MultiChannelConversionAttribution_channelTypes";
    public const LABEL_NOT_DEFINED = 'MultiChannelConversionAttribution_LabelNotDefined';

    public static function completeChannelAttributionRecordName(int $idGoal, array $rowOption): string
    {
        return self::RECORD_CHANNEL_TYPES . '_' . $idGoal . '_prior' . (int) $rowOption['period'] . '_' . $rowOption['topLevel'] . (!empty($rowOption['subLevel']) ? '_' . $rowOption['subLevel'] : '');
    }
}
