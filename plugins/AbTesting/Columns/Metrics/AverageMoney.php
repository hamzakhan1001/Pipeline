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

namespace Piwik\Plugins\AbTesting\Columns\Metrics;

use Piwik\Archive\DataTableFactory;
use Piwik\Columns\Dimension;
use Piwik\DataTable;
use Piwik\DataTable\Row;
use Piwik\Metrics\Formatter;
use Piwik\Piwik;
use Piwik\Plugins\AbTesting\Metrics as PluginMetrics;

class AverageMoney extends ProcessedMetric
{
    /**
     * @var string
     */
    private $metric;

    /**
     * @var string
     */
    private $metricAverageName;

    /**
     * @var string
     */
    private $translation;

    /**
     * @var int
     */
    private $idSite;

    public function __construct($metricName, $metricTranslation)
    {
        $this->metricAverageName = $metricName;
        $this->metric = str_replace(PluginMetrics::METRIC_AVERAGE_PREFIX, '', $metricName);
        $this->translation = $metricTranslation;
    }

    public function getName()
    {
        return $this->metricAverageName;
    }

    public function compute(Row $row)
    {
        $revenue = $this->getMetric($row, $this->metric);
        $conversions = $this->getMetric($row, PluginMetrics::METRIC_VISITS);

        return Piwik::getQuotientSafe($revenue, $conversions, $precision = 2);
    }

    public function getTranslatedName()
    {
        return $this->translation;
    }

    public function getDependentMetrics()
    {
        return array($this->metric, PluginMetrics::METRIC_VISITS);
    }

    public function format($value, Formatter $formatter)
    {
        return $formatter->getPrettyMoney($value, $this->idSite);
    }

    public function beforeFormat($report, DataTable $table)
    {
        $this->idSite = DataTableFactory::getSiteIdFromMetadata($table);
        return !empty($this->idSite); // skip formatting if there is no site to get currency info from
    }

    public function getSemanticType(): ?string
    {
        return Dimension::TYPE_MONEY;
    }
}
