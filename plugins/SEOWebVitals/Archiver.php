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

namespace Piwik\Plugins\SEOWebVitals;

use Piwik\DataTable;
use Piwik\Plugins\SEOWebVitals\Dao\PageSpeedReport;

class Archiver extends \Piwik\Plugin\Archiver
{
    public const RECORD_NAME_WEB_VITALS = 'SEOWebVitals_webvitals';

    public static function shouldRunEvenWhenNoVisits(): bool
    {
        return true;
    }

    public static function getColumnAggregationOpteration(): array
    {
        $operations = [
            Metrics::METRIC_PERFORMANCE_SCORE => null,
            Metrics::METRIC_AUDIT_NUM_CHECKS => null,
            Metrics::METRIC_LOAD_EXPERIENCE_NUM_CHECKS => null,
        ];
        foreach (Metrics::SUB_LEVEL_ROW_METRICS as $metric) {
            $operations[$metric] = null;
        }
        foreach (array_keys(Metrics::TOP_LEVEL_NUMERIC_CATEGORY_MAPPING) as $metric) {
            $operations[$metric] = null;
        }
        foreach (array_values(Metrics::TOP_LEVEL_NUMERIC_CATEGORY_MAPPING) as $metric) {
            $operations[$metric] = null;
        }

        foreach ($operations as $operation => $val) {
            $operations[$operation] = function ($thisValue, $otherValue, $thisRow, $otherRow) {
                if (!is_numeric($thisValue) && !is_numeric($otherValue)) {
                    return '';
                }
                if (!is_numeric($thisValue)) {
                    return $otherValue;
                }
                if (!is_numeric($otherValue)) {
                    return $thisValue;
                }
                return $thisValue + $otherValue;
            };
        }

        $operations[PageSpeedReport::ERROR_SITE_NOT_ACCESSIBLE] = function ($thisValue, $otherValue, $thisRow, $otherRow) {
            /** @var DataTable\Row $thisRow */
            /** @var DataTable\Row $otherRow */
            if (
                $thisRow->getColumn(PageSpeedReport::ERROR_SITE_NOT_ACCESSIBLE)
                && $otherRow->getColumn(PageSpeedReport::ERROR_SITE_NOT_ACCESSIBLE)
            ) {
                return 1;
            }
            return 0;
        };

        $operations[PageSpeedReport::ERROR_SSL_REQUIRED] = function ($thisValue, $otherValue, $thisRow, $otherRow) {
            /** @var DataTable\Row $thisRow */
            /** @var DataTable\Row $otherRow */
            if (
                $thisRow->getColumn(PageSpeedReport::ERROR_SSL_REQUIRED)
                && $otherRow->getColumn(PageSpeedReport::ERROR_SSL_REQUIRED)
            ) {
                return 1;
            }
            return 0;
        };

        $operations[PageSpeedReport::ERROR_ACCESS_DENIED] = function ($thisValue, $otherValue, $thisRow, $otherRow) {
            /** @var DataTable\Row $thisRow */
            /** @var DataTable\Row $otherRow */
            if (
                $thisRow->getColumn(PageSpeedReport::ERROR_ACCESS_DENIED)
                && $otherRow->getColumn(PageSpeedReport::ERROR_ACCESS_DENIED)
            ) {
                return 1;
            }
            return 0;
        };

        $operations[Metrics::METRIC_AUDIT_DISPLAY_VALUE] = function () {
            return '';
        };
        return Metrics::appendAllStrategies($operations);
    }
}
