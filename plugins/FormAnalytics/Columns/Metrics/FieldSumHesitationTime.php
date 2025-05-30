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

class FieldSumHesitationTime extends ProcessedMetric
{
    public function getName()
    {
        return PluginMetrics::SUM_FIELD_HESITATION_TIME;
    }

    public function getTranslatedName()
    {
        return Piwik::translate('FormAnalytics_ColumnHesitationTime');
    }

    public function compute(Row $row)
    {
        // compute will not be executed since this column already exists and we only format value
        return $this->getMetric($row, PluginMetrics::SUM_FIELD_HESITATION_TIME);
    }

    public function getDependentMetrics()
    {
        return array(PluginMetrics::SUM_FIELD_HESITATION_TIME);
    }

    public function format($value, Formatter $formatter)
    {
        if (!empty($value)) {
            $value = round($value / 1000, 1);
            if ($value >= 3) {
                $value = (int) $value;
            }
        }
        return $formatter->getPrettyTimeFromSeconds($value, $asSentence = true);
    }

    public function getSemanticType(): ?string
    {
        return Dimension::TYPE_NUMBER;
    }
}
