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

namespace Piwik\Plugins\AbTesting;

use Piwik\API\Request;
use Piwik\Columns\Dimension;
use Piwik\Container\StaticContainer;
use Piwik\Piwik;
use Piwik\Plugins\AbTesting\Columns\Metrics\BounceRate;
use Piwik\Plugins\AbTesting\Columns\Metrics\ConversionRate;
use Piwik\Plugins\AbTesting\Columns\Metrics\DetectedEffect;
use Piwik\Plugins\AbTesting\Columns\Metrics\RemainingVisitors;
use Piwik\Plugins\AbTesting\Columns\Metrics\SignificanceRate;
use Piwik\Site;

class Metrics
{
    public const METRIC_AVERAGE_PREFIX = 'avg_';
    public const METRIC_VISITS = 'nb_visits';
    public const METRIC_VISITS_ENTERED = 'nb_visits_entered';
    public const METRIC_UNIQUE_VISITORS_ENTERED = 'nb_uniq_visitors_entered';
    /**
     * Unique visitors === Unique visitors entered when viewing the whole range. We still process different values
     * in case someone requests the API eg for a day or not for the full experiment day range
     */
    public const METRIC_UNIQUE_VISITORS = 'nb_uniq_visitors';
    public const METRIC_UNIQUE_VISITORS_ENTERED_AGGREGATED = 'nb_uniq_visitors_entered_aggregated';
    public const METRIC_ESTIMATED_UNIQUE_VISITORS_ENTERED_AGGREGATED = 'nb_est_uniq_visitors_entered_aggregated';
    public const METRIC_UNIQUE_VISITORS_AGGREGATED = 'nb_uniq_visitors_aggregated';
    public const METRIC_ESTIMATED_UNIQUE_VISITORS_AGGREGATED = 'nb_est_uniq_visitors_aggregated';
    public const METRIC_PAGEVIEWS = 'nb_pageviews';
    public const METRIC_BOUNCE_COUNT = 'bounce_count';
    public const METRIC_SUM_VISIT_LENGTH = 'sum_visit_length';
    public const METRIC_TOTAL_REVENUE = 'nb_revenue';
    public const METRIC_TOTAL_CONVERSIONS = 'nb_conversions';
    public const METRIC_TOTAL_ORDERS = 'nb_orders';
    public const METRIC_TOTAL_ORDERS_REVENUE = 'nb_orders_revenue';

    public const METRIC_GOAL_APPENDIX = '_goal_';

    public const ESTIMATED_UNIQUE_VISITORS_DOCUMENTATION_BASE_VALUE = 500;

    public static function getGoalIdFromMetricName($metricName)
    {
        $metricName = str_replace(self::METRIC_AVERAGE_PREFIX, '', $metricName);

        $perGoalMetrics = array(static::METRIC_TOTAL_REVENUE, static::METRIC_TOTAL_CONVERSIONS);

        foreach ($perGoalMetrics as $metric) {
            $start = $metric . static::METRIC_GOAL_APPENDIX;

            if (strpos($metricName, $start) === 0) {
                return (int) str_replace($start, '', $metricName);
            }
        }
    }

    public static function isConversionMetric($metricName)
    {
        return strpos($metricName, 'conversion') !== false;
    }

    public static function isRevenueMetric($metricName)
    {
        return strpos($metricName, 'revenue') !== false;
    }

    public static function isBounceMetric($metricName)
    {
        return strpos($metricName, 'bounce') !== false;
    }

    public static function getMetricNameConversionGoal($idGoal)
    {
        return static::METRIC_TOTAL_CONVERSIONS . static::METRIC_GOAL_APPENDIX . (int) $idGoal;
    }

    public static function getMetricNameRevenueGoal($idGoal)
    {
        return static::METRIC_TOTAL_REVENUE . static::METRIC_GOAL_APPENDIX . (int) $idGoal;
    }

    public static function isGoalSpecificSuccessMetric($metricName)
    {
        $idGoal = self::getGoalIdFromMetricName($metricName);

        return !empty($idGoal);
    }

    public function getSuccessMetrics($idSite)
    {
        $metrics = array(
            array('value' => static::METRIC_PAGEVIEWS, 'name' => Piwik::translate('General_ColumnPageviews')),
            array('value' => static::METRIC_BOUNCE_COUNT, 'name' => Piwik::translate('General_ColumnBounces')),
            array('value' => static::METRIC_SUM_VISIT_LENGTH, 'name' => Piwik::translate('AbTesting_ColumnTimeOnSite'))
        );

        $hasEcommerce = Site::isEcommerceEnabledFor($idSite);
        $goals = Request::processRequest('Goals.getGoals', array('idSite' => $idSite, 'filter_limit' => '-1'));

        // possible TODO: When a goal is added after the experiment is started, it may affect the experiment so
        // we might want to include only goals that existed at experiment start at some point, or have an option for it.
        if ($hasEcommerce || !empty($goals)) {
            $metrics[] = array('value' => static::METRIC_TOTAL_CONVERSIONS, 'name' => Piwik::translate('AbTesting_ColumnTotalConversions'));
            $metrics[] = array('value' => static::METRIC_TOTAL_REVENUE, 'name' => Piwik::translate('AbTesting_ColumnTotalRevenue'));
        }

        if ($hasEcommerce) {
            $metrics[] = array('value' => static::METRIC_TOTAL_ORDERS, 'name' => Piwik::translate('AbTesting_EcommerceOrders'));
            $metrics[] = array('value' => static::METRIC_TOTAL_ORDERS_REVENUE, 'name' => Piwik::translate('AbTesting_EcommerceOrdersRevenue'));
        }

        $translator = StaticContainer::get('Piwik\Translation\Translator');

        foreach ($goals as $goal) {
            $metrics[] = array(
                'value' => self::getMetricNameConversionGoal($goal['idgoal']),
                'name' =>  Piwik::translate('Goals_ColumnConversions') . ' "' . Piwik::translate('Goals_GoalX', $translator->clean($goal['name'])) . '"'
            );
            $metrics[] = array(
                'value' => self::getMetricNameRevenueGoal($goal['idgoal']),
                'name' =>  Piwik::translate('General_ColumnRevenue') . ' "' . Piwik::translate('Goals_GoalX', $translator->clean($goal['name'])) . '"'
            );
        }

        return $metrics;
    }

    public function getMetricOverviewNames($selectedSuccessMetrics, $hasUniqueMetrics = true, $showUniqueMetricsForcefully = false)
    {
        $metricNames = array(
            'label',
            Metrics::METRIC_VISITS,
            Metrics::METRIC_VISITS_ENTERED,
        );

        $configuration = StaticContainer::get(Configuration::class);

        if ($hasUniqueMetrics) {
            if ($configuration->shouldShowUniqueVisitors() || $showUniqueMetricsForcefully) {
                $metricNames[] = Metrics::METRIC_UNIQUE_VISITORS;
            }
            if ($configuration->shouldShowEstimatedUniqueVisitors()) {
                $metricNames[] = Metrics::METRIC_ESTIMATED_UNIQUE_VISITORS_AGGREGATED;
            }
        }

        foreach ($selectedSuccessMetrics as $successMetric) {
            if (empty($successMetric['metric'])) {
                continue;
            }

            if (self::isBounceMetric($successMetric['metric'])) {
                $metricNames[] = BounceRate::METRIC_NAME;
            } else {
                $metricNames[] = self::METRIC_AVERAGE_PREFIX . $successMetric['metric'];
            }
        }

        return $metricNames;
    }

    public function getMetricOverviewTranslations($idSite)
    {
        $translations = array(
            Metrics::METRIC_VISITS_ENTERED => Piwik::translate('AbTesting_VisitsActivelyEntered'),
            Metrics::METRIC_UNIQUE_VISITORS_ENTERED => Piwik::translate('AbTesting_UniqueVisitorsActivelyEntered'),
            Metrics::METRIC_ESTIMATED_UNIQUE_VISITORS_AGGREGATED => Piwik::translate('AbTesting_EstimatedUniqueVisitors'),
            Metrics::METRIC_ESTIMATED_UNIQUE_VISITORS_ENTERED_AGGREGATED => Piwik::translate('AbTesting_EstimatedUniqueVisitorsEntered')
        );

        foreach ($this->getSuccessMetrics($idSite) as $metric) {
            $metricName = $metric['value'];
            $metricAverageTitle = Piwik::translate('AbTesting_AverageX', $metric['name']);
            $metricTitle = $metric['name'];

            if ($metricName === self::METRIC_TOTAL_CONVERSIONS) {
                $metricAverageTitle = Piwik::translate('AbTesting_ColumnTotalConversionsPerVisit');
            }

            if ($metricName === self::METRIC_TOTAL_ORDERS) {
                $metricAverageTitle = Piwik::translate('AbTesting_ColumnOrdersPerVisit');
            }

            if ($metricName === self::METRIC_TOTAL_REVENUE) {
                $metricAverageTitle = Piwik::translate('AbTesting_ColumnTotalRevenuePerVisit');
            }

            if ($metricName === self::METRIC_TOTAL_ORDERS_REVENUE) {
                $metricAverageTitle = Piwik::translate('AbTesting_ColumnOrdersRevenuePerVisit');
            }

            if (self::isConversionMetric($metricName) && self::isGoalSpecificSuccessMetric($metricName)) {
                $metricAverageTitle = Piwik::translate('General_ColumnConversionRate') . ' "' .  $metricTitle . '"';
            }

            $translations[self::METRIC_AVERAGE_PREFIX . $metric['value']] = $metricAverageTitle;
            $translations[$metric['value']] = $metricTitle;
        }

        return $translations;
    }

    public function getMetricDetailNames($successMetric, $hasUniqueMetrics = true, $showUniqueMetricsForcefully = false)
    {
        $base = array('label');

        $configuration = StaticContainer::get(Configuration::class);

        if (self::isBounceMetric($successMetric)) {
            $base[] = Metrics::METRIC_VISITS_ENTERED;
            if ($hasUniqueMetrics) {
                if ($configuration->shouldShowUniqueVisitors() || $showUniqueMetricsForcefully) {
                    $base[] = Metrics::METRIC_UNIQUE_VISITORS_ENTERED;
                }
                if ($configuration->shouldShowEstimatedUniqueVisitors()) {
                    $base[] = Metrics::METRIC_ESTIMATED_UNIQUE_VISITORS_ENTERED_AGGREGATED;
                }
            }
        } else {
            $base[] = Metrics::METRIC_VISITS;
            if ($hasUniqueMetrics) {
                if ($configuration->shouldShowUniqueVisitors() || $showUniqueMetricsForcefully) {
                    $base[] = Metrics::METRIC_UNIQUE_VISITORS;
                }
                if ($configuration->shouldShowEstimatedUniqueVisitors()) {
                    $base[] = Metrics::METRIC_ESTIMATED_UNIQUE_VISITORS_AGGREGATED;
                }
            }
        }

        if ($successMetric !== self::METRIC_SUM_VISIT_LENGTH) {
            $base[] = $successMetric;
        }

        if (self::isConversionMetric($successMetric)) {
            $base[] = ConversionRate::METRIC_NAME;
        } elseif (self::isBounceMetric($successMetric)) {
            $base[] = BounceRate::METRIC_NAME;
        } else {
            $base[] = Metrics::METRIC_AVERAGE_PREFIX . $successMetric;
        }

        $base[] = DetectedEffect::METRIC_NAME;
        $base[] = RemainingVisitors::METRIC_NAME;
        $base[] = SignificanceRate::METRIC_NAME;

        return $base;
    }

    public function getMetricDocumentations()
    {
        $configuration = new Configuration();
        $errorRate = $configuration->getHyperLogLogErrorRate();
        $accuracyRate = ((1 - $errorRate) * 100) . '%';
        $rangeValue = (int) (self::ESTIMATED_UNIQUE_VISITORS_DOCUMENTATION_BASE_VALUE * $errorRate);
        $rangeValueStart = self::ESTIMATED_UNIQUE_VISITORS_DOCUMENTATION_BASE_VALUE - $rangeValue;
        $rangeValueEnd = self::ESTIMATED_UNIQUE_VISITORS_DOCUMENTATION_BASE_VALUE + $rangeValue;
        return array(
            self::METRIC_VISITS => Piwik::translate('AbTesting_ColumnVisitsDocumentation'),
            self::METRIC_UNIQUE_VISITORS => Piwik::translate('AbTesting_ColumnUniqueVisitorsDocumentation'),
            self::METRIC_UNIQUE_VISITORS_ENTERED => Piwik::translate('AbTesting_ColumnUniqueVisitorsDocumentation'),
            self::METRIC_ESTIMATED_UNIQUE_VISITORS_AGGREGATED => Piwik::translate('AbTesting_ColumnEstimatedUniqueVisitorsDocumentationMessage', array($accuracyRate, $rangeValueStart, $rangeValueEnd)),
            self::METRIC_ESTIMATED_UNIQUE_VISITORS_ENTERED_AGGREGATED => Piwik::translate('AbTesting_ColumnEstimatedUniqueVisitorsDocumentationMessage', array($accuracyRate, $rangeValueStart, $rangeValueEnd)),
            self::METRIC_VISITS_ENTERED => Piwik::translate('AbTesting_ColumnVisitsEnteredDocumentation'),
            BounceRate::METRIC_NAME => Piwik::translate('AbTesting_ColumnBounceRateDocumentation'),
            self::METRIC_PAGEVIEWS => Piwik::translate('General_ColumnPageviewsDocumentation'),
            self::METRIC_BOUNCE_COUNT => Piwik::translate('General_ColumnBouncesDocumentation'),
            self::METRIC_AVERAGE_PREFIX . self::METRIC_SUM_VISIT_LENGTH => Piwik::translate('General_ColumnAvgTimeOnSiteDocumentation'),
        );
    }

    public function getMetricSemanticTypes()
    {
        return [
            self::METRIC_VISITS => Dimension::TYPE_NUMBER,
            self::METRIC_UNIQUE_VISITORS => Dimension::TYPE_NUMBER,
            self::METRIC_UNIQUE_VISITORS_ENTERED => Dimension::TYPE_NUMBER,
            self::METRIC_ESTIMATED_UNIQUE_VISITORS_AGGREGATED => Dimension::TYPE_NUMBER,
            self::METRIC_ESTIMATED_UNIQUE_VISITORS_ENTERED_AGGREGATED => Dimension::TYPE_NUMBER,
            self::METRIC_VISITS_ENTERED => Dimension::TYPE_NUMBER,
            self::METRIC_PAGEVIEWS => Dimension::TYPE_NUMBER,
            self::METRIC_BOUNCE_COUNT => Dimension::TYPE_NUMBER,
        ];
    }

    public function getMetricDetailTranslations($idSite, $metricName)
    {
        $translations = $this->getMetricOverviewTranslations($idSite);
        $avgMetricName = self::METRIC_AVERAGE_PREFIX . $metricName;

        $conversionRateName = Piwik::translate('General_ColumnConversionRate');
        if ($metricName === self::METRIC_TOTAL_CONVERSIONS) {
            $conversionRateName = Piwik::translate('AbTesting_ColumnConversionsPerVisit');
        }

        if ($metricName === self::METRIC_TOTAL_REVENUE) {
            $conversionRateName = Piwik::translate('AbTesting_ColumnRevenuePerVisit');
        }

        $metricTitle = isset($translations[$metricName]) ? $translations[$metricName] : $metricName;
        $avgMetricTitle = isset($translations[$avgMetricName]) ? $translations[$avgMetricName] : $avgMetricName;

        if ($metricName === self::METRIC_TOTAL_ORDERS) {
            $metricTitle = Piwik::translate('General_EcommerceOrders');
            $avgMetricTitle = Piwik::translate('AbTesting_ColumnOrdersPerVisit');
            $conversionRateName = $avgMetricTitle;
        } elseif (self::isRevenueMetric($metricName)) {
            $metricTitle = Piwik::translate('General_ColumnRevenue');
            $avgMetricTitle = Piwik::translate('AbTesting_ColumnRevenuePerVisit');
        } elseif (self::isConversionMetric($metricName)) {
            $metricTitle = Piwik::translate('Goals_ColumnConversions');
        }

        $detailTranslations = array(
            $metricName => $metricTitle,
            $avgMetricName => $avgMetricTitle,
            ConversionRate::METRIC_NAME => $conversionRateName,
            BounceRate::METRIC_NAME => Piwik::translate('General_ColumnBounceRate'),
            DetectedEffect::METRIC_NAME => Piwik::translate('AbTesting_ColumnDetectedEffect'),
            RemainingVisitors::METRIC_NAME => Piwik::translate('AbTesting_ColumnRemainingVisitors'),
            SignificanceRate::METRIC_NAME => Piwik::translate('AbTesting_ColumnSignificanceRate'),
        );

        return array_merge($translations, $detailTranslations);
    }
}
