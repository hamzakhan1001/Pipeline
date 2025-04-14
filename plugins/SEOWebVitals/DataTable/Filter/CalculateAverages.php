<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

namespace Piwik\Plugins\SEOWebVitals\DataTable\Filter;

use Piwik\DataTable\BaseFilter;
use Piwik\DataTable;
use Piwik\Piwik;
use Piwik\Plugins\SEOWebVitals\Dao\PageSpeedApi;
use Piwik\Plugins\SEOWebVitals\Metrics;

class CalculateAverages extends BaseFilter
{
    public function __construct($table)
    {
        parent::__construct($table);
    }

    /**
     * @param DataTable $table
     */
    public function filter($table)
    {
        // would be usually done in a processed metric I suppose...
        foreach (PageSpeedApi::getAllStrategies() as $strategy) {
            $metricsToSum = Metrics::appendStrategy(
                array_merge(
                    Metrics::TOP_LEVEL_NUMERIC_CATEGORY_MAPPING,
                    [Metrics::METRIC_PERFORMANCE_SCORE => true,
                        Metrics::METRIC_AUDIT_SCORE => true,
                        Metrics::METRIC_AUDIT_NUMERIC_VALUE => true,
                    ]
                ),
                $strategy
            );
            $categoryMetrics = Metrics::appendStrategy(array_flip(Metrics::TOP_LEVEL_NUMERIC_CATEGORY_MAPPING), $strategy);

            $metricNumLoadExperienceChecks = Metrics::appendStrategy(Metrics::METRIC_LOAD_EXPERIENCE_NUM_CHECKS, $strategy);
            $metricNumAuditChecks = Metrics::appendStrategy(Metrics::METRIC_AUDIT_NUM_CHECKS, $strategy);

            foreach ($table->getRowsWithoutSummaryRow() as $row) {
                $numEntriesWithValues = 0;
                if ($row->hasColumn($metricNumLoadExperienceChecks)) {
                    $numEntriesWithValues = $row->getColumn($metricNumLoadExperienceChecks);
                } elseif ($row->hasColumn($metricNumAuditChecks)) {
                    $numEntriesWithValues = $row->getColumn($metricNumAuditChecks);
                }

                if ($numEntriesWithValues > 1) {
                    // if there is only one check then we don't need to calculate anything
                    foreach ($row->getColumns() as $column => $value) {
                        //Added this check to handle error  "Trying to round unsupported operands for dividend and divisor" due to empty values coming from Google
                        if (!is_numeric($value) && (!empty($metricsToSum[$column]) || !empty($categoryMetrics[$column]))) {
                            $value = 0;
                        }
                        if (!empty($metricsToSum[$column])) {
                            if (strpos($column, Metrics::METRIC_LOAD_EXPERIENCE_CLS_NUMERICVALUE) !== false) {
                                $val = Piwik::getQuotientSafe($value, $numEntriesWithValues, 2);
                            } else {
                                $val = (int) Piwik::getQuotientSafe($value, $numEntriesWithValues, 0);
                            }
                            $row->setColumn($column, $val);
                        } elseif (!empty($categoryMetrics[$column])) {
                            $value = Piwik::getQuotientSafe($value, $numEntriesWithValues, 0);
                            $row->setColumn($column, $value);
                        }
                    }
                }
                $row->deleteColumn($metricNumLoadExperienceChecks);
                $row->deleteColumn($metricNumAuditChecks);
            }
        }
    }
}
