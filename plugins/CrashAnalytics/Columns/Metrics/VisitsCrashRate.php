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

namespace Piwik\Plugins\CrashAnalytics\Columns\Metrics;

use Piwik\Columns\Dimension;
use Piwik\DataTable\Row;
use Piwik\Metrics\Formatter;
use Piwik\Piwik;
use Piwik\Plugin\ProcessedMetric;
use Piwik\Plugins\CrashAnalytics\Metrics;

class VisitsCrashRate extends ProcessedMetric
{
    const METRIC_NAME = 'visits_crash_rate';
    const TRANSLATION_ID = 'CrashAnalytics_VisitsCrashRate';
    const DOCUMENTATION_TRANSLATION_ID = 'CrashAnalytics_VisitsCrashRateDocumentation';

    private $nbVisits;

    public function __construct($nbVisits)
    {
        $this->nbVisits = $nbVisits;
    }

    public function getName()
    {
        return self::METRIC_NAME;
    }

    public function getTranslatedName()
    {
        return Piwik::translate(self::TRANSLATION_ID);
    }

    public function getDocumentation()
    {
        return Piwik::translate(self::DOCUMENTATION_TRANSLATION_ID);
    }

    public function compute(Row $row)
    {
        $visitsWithCrash = $this->getMetric($row, Metrics::VISITS_WITH_CRASH);
        return Piwik::getQuotientSafe($visitsWithCrash, $this->nbVisits, $precision = 2);
    }

    public function getDependentMetrics()
    {
        return [Metrics::VISITS_WITH_CRASH];
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
