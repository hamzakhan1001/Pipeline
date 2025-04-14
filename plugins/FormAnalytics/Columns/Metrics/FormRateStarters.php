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

class FormRateStarters extends ProcessedMetric
{
    public function getName()
    {
        return PluginMetrics::RATE_FORM_STARTERS;
    }

    public function getTranslatedName()
    {
        return Piwik::translate('FormAnalytics_ColumnRateStarters');
    }

    public function compute(Row $row)
    {
        $numViews = $this->getMetric($row, PluginMetrics::SUM_FORM_VIEWERS);
        $starters = $this->getMetric($row, PluginMetrics::SUM_FORM_STARTERS);

        return Piwik::getQuotientSafe($starters, $numViews, $precision = 3);
    }

    public function getDependentMetrics()
    {
        return array(PluginMetrics::SUM_FORM_VIEWERS, PluginMetrics::SUM_FORM_STARTERS);
    }

    public function format($value, Formatter $formatter)
    {
        return $formatter->getPrettyPercentFromQuotient($value);
    }

    public function getSemanticType(): ?string
    {
        return Dimension::TYPE_PERCENT;
    }
}
