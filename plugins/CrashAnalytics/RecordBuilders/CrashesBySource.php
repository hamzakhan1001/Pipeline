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

class CrashesBySource extends CrashesByDimension
{
    const RECORD_NAME = 'CrashAnalytics_BySource';

    public function getDimensionColumn(): string
    {
        return 'log_crash_resolved.resource_uri';
    }

    public function getExtraFrom(): array
    {
        return [];
    }

    protected function getSubtableRowLabel($resultSetRow): string
    {
        return $resultSetRow['message'] ?: '';
    }
}
