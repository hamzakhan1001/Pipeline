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

namespace Piwik\Plugins\CrashAnalytics\RecordBuilders;

use Piwik\Plugins\CrashAnalytics\Metrics;

class CrashesByPageUrl extends CrashesByDimension
{
    const RECORD_NAME = 'CrashAnalytics_ByPageUrl';

    public function getDimensionColumn(): string
    {
        return 'log_crash_event.idaction_url';
    }

    public function getLabelSelect(): string
    {
        return 'log_action.name';
    }

    public function getExtraFrom(): array
    {
        return [
            [
                'table' => 'log_action',
                'joinOn' => 'log_action.idaction = log_crash_event.idaction_url',
            ],
        ];
    }

    public function getExtraMetrics(): array
    {
        return [Metrics::PAGEVIEWS_WITH_CRASH => 'max'];
    }
}
