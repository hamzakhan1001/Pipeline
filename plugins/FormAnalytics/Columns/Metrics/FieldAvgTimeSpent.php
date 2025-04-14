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

namespace Piwik\Plugins\FormAnalytics\Columns\Metrics;

use Piwik\Columns\Dimension;
use Piwik\DataTable\Row;
use Piwik\Metrics\Formatter;
use Piwik\Piwik;
use Piwik\Plugin\ProcessedMetric;
use Piwik\Plugins\FormAnalytics\Metrics as PluginMetrics;

class FieldAvgTimeSpent extends ProcessedMetric
{
    public function getName()
    {
        return PluginMetrics::AVG_FIELD_TIME_SPENT;
    }

    public function getTranslatedName()
    {
        return Piwik::translate('FormAnalytics_ColumnAvgTimeSpent');
    }

    public function compute(Row $row)
    {
        $timeSpent = $this->getMetric($row, PluginMetrics::SUM_FIELD_TIME_SPENT);

        if (!empty($timeSpent)) {
            $timeSpent = $timeSpent / 1000; // convert ms to seconds
        }

        $numInteractions = $this->getMetric($row, PluginMetrics::SUM_FIELD_UNIQUE_INTERACTIONS);

        return Piwik::getQuotientSafe($timeSpent, $numInteractions, $precision = 3);
    }

    public function getDependentMetrics()
    {
        return array(PluginMetrics::SUM_FIELD_TIME_SPENT, PluginMetrics::SUM_FIELD_UNIQUE_INTERACTIONS);
    }

    public function format($value, Formatter $formatter)
    {
        if ($value >= 30) {
            $value = (int) $value;
        } elseif ($value >= 2) {
            $value = round($value, 1);
        } else {
            $value = round($value, 2);
        }

        return $formatter->getPrettyTimeFromSeconds($value, $asSentence = true);
    }

    public function getSemanticType(): ?string
    {
        return Dimension::TYPE_NUMBER;
    }
}
