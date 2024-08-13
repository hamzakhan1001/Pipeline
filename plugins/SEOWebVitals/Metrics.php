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
 * @linkcom/
 * @license For license details seecom/license
 */

namespace Piwik\Plugins\SEOWebVitals;

use Piwik\Columns\Dimension;
use Piwik\Common;
use Piwik\Option;
use Piwik\Piwik;
use Piwik\Plugins\MobileAppMeasurable\Type as MobileAppType;
use Piwik\Plugins\SEOWebVitals\Dao\PageSpeedApi;
use Piwik\Settings\Setting;
use Piwik\Settings\FieldConfig;

class Metrics
{

    const METRIC_AUDIT_SCORE = 'nb_audit_score';
    const METRIC_AUDIT_NUMERIC_VALUE = 'nb_audit_numeric';
    const METRIC_AUDIT_DISPLAY_VALUE = 'audit_display_value';
    const METRIC_AUDIT_NUM_CHECKS = 'nb_audit_num_checks';

    const METRIC_PERFORMANCE_SCORE = 'performance_score';

    const METRIC_LOAD_EXPERIENCE_NUM_CHECKS = 'nb_load_experience_num_checks';

    const METRIC_LOAD_EXPERIENCE_CLS_CATEGORY = 'cls_category'; // CUMULATIVE_LAYOUT_SHIFT_SCORE
    const METRIC_LOAD_EXPERIENCE_CLS_NUMERICVALUE = 'nb_cls_numericvalue';

    const METRIC_LOAD_EXPERIENCE_LCP_CATEGORY = 'lcp_category'; // largest contentful paint
    const METRIC_LOAD_EXPERIENCE_LCP_NUMERICVALUE = 'nb_lcp_numericvalue';

    const METRIC_LOAD_EXPERIENCE_FCP_CATEGORY = 'fcp_category'; // largest contentful paint
    const METRIC_LOAD_EXPERIENCE_FCP_NUMERICVALUE = 'nb_fcp_numericvalue';

    const METRIC_LOAD_EXPERIENCE_FID_CATEGORY = 'fid_category'; // first input delay
    const METRIC_LOAD_EXPERIENCE_FID_NUMERICVALUE = 'nb_fid_numericvalue';

    const METRIC_LOAD_EXPERIENCE_INP_CATEGORY = 'inp_category'; // interaction to next paint
    const METRIC_LOAD_EXPERIENCE_INP_NUMERICVALUE = 'nb_inp_numericvalue';

    const OPTION_KEY_AUDIT_METRICS = 'SEOWebVitals_AuditMetrics';

    private $auditMetricsCached = null;

    const TOP_LEVEL_ROW_METRICS = [
        Metrics::METRIC_PERFORMANCE_SCORE,
        Metrics::METRIC_LOAD_EXPERIENCE_CLS_CATEGORY,
        Metrics::METRIC_LOAD_EXPERIENCE_CLS_NUMERICVALUE,

        Metrics::METRIC_LOAD_EXPERIENCE_FID_CATEGORY,
        Metrics::METRIC_LOAD_EXPERIENCE_FID_NUMERICVALUE,

        Metrics::METRIC_LOAD_EXPERIENCE_INP_CATEGORY,
        Metrics::METRIC_LOAD_EXPERIENCE_INP_NUMERICVALUE,

        Metrics::METRIC_LOAD_EXPERIENCE_LCP_CATEGORY,
        Metrics::METRIC_LOAD_EXPERIENCE_LCP_NUMERICVALUE,

        Metrics::METRIC_LOAD_EXPERIENCE_FCP_CATEGORY,
        Metrics::METRIC_LOAD_EXPERIENCE_FCP_NUMERICVALUE,
    ];

    const TOP_LEVEL_NUMERIC_CATEGORY_MAPPING = [
        Metrics::METRIC_LOAD_EXPERIENCE_CLS_NUMERICVALUE => Metrics::METRIC_LOAD_EXPERIENCE_CLS_CATEGORY,
        Metrics::METRIC_LOAD_EXPERIENCE_LCP_NUMERICVALUE => Metrics::METRIC_LOAD_EXPERIENCE_LCP_CATEGORY,
        Metrics::METRIC_LOAD_EXPERIENCE_FCP_NUMERICVALUE => Metrics::METRIC_LOAD_EXPERIENCE_FCP_CATEGORY,
        Metrics::METRIC_LOAD_EXPERIENCE_FID_NUMERICVALUE => Metrics::METRIC_LOAD_EXPERIENCE_FID_CATEGORY,
        Metrics::METRIC_LOAD_EXPERIENCE_INP_NUMERICVALUE => Metrics::METRIC_LOAD_EXPERIENCE_INP_CATEGORY
    ];

    const SUB_LEVEL_ROW_METRICS = [Metrics::METRIC_AUDIT_SCORE, Metrics::METRIC_AUDIT_NUMERIC_VALUE, Metrics::METRIC_AUDIT_DISPLAY_VALUE];

    public static function isStrategyMetric($metric, $strategy)
    {
        return strpos($metric, Metrics::appendStrategy('', $strategy)) !== false;
    }

    public static function appendStrategy($columnNameOrNames, $strategy)
    {
        $strategyLower = Common::mb_strtolower($strategy);
        $columnAppendix = '_' . $strategyLower;

        if (is_array($columnNameOrNames)) {
            $columnsWithAppendix = [];
            foreach ($columnNameOrNames as $column => $value) {
                if (is_string($value) && strpos($value, '%s') !== false) {
                    $columnsWithAppendix[$column . $columnAppendix] = Piwik::translate($value, ucfirst($strategyLower));
                } else {
                    $columnsWithAppendix[$column . $columnAppendix] = $value;
                }
            }
            return $columnsWithAppendix;
        } else {
            return $columnNameOrNames . $columnAppendix;
        }
    }

    public static function appendAllStrategies($columns)
    {
        $newColumns = [];
        foreach (PageSpeedApi::getAllStrategies() as $strategy) {
            $newColumns = array_merge($newColumns, Metrics::appendStrategy($columns, $strategy));
        }
        return $newColumns;
    }

    public function getDocumentationTranslations()
    {
        return self::appendAllStrategies([

            Metrics::METRIC_AUDIT_SCORE => Piwik::translate('SEOWebVitals_MetricAuditScorePercentageDescription'),
            Metrics::METRIC_PERFORMANCE_SCORE => Piwik::translate('SEOWebVitals_MetricPageSpeedScoreDescription'),
            Metrics::METRIC_AUDIT_NUMERIC_VALUE => Piwik::translate('SEOWebVitals_MetricNumericScoreDescription'),
            Metrics::METRIC_AUDIT_DISPLAY_VALUE => Piwik::translate('SEOWebVitals_MetricInformationDescription'),
            Metrics::METRIC_LOAD_EXPERIENCE_CLS_NUMERICVALUE => Piwik::translate('SEOWebVitals_MetricCLSDescription'),
            Metrics::METRIC_LOAD_EXPERIENCE_LCP_NUMERICVALUE => Piwik::translate('SEOWebVitals_MetricLCPDescription'),
            Metrics::METRIC_LOAD_EXPERIENCE_FCP_NUMERICVALUE => Piwik::translate('SEOWebVitals_MetricFCPDescription'),
            Metrics::METRIC_LOAD_EXPERIENCE_FID_NUMERICVALUE => Piwik::translate('SEOWebVitals_MetricFIDDescription'),
            Metrics::METRIC_LOAD_EXPERIENCE_INP_NUMERICVALUE => Piwik::translate('SEOWebVitals_MetricINPDescription'),
        ]);
    }

    public function getSemanticTypes()
    {
        return self::appendAllStrategies([
            Metrics::METRIC_AUDIT_SCORE => Dimension::TYPE_PERCENT,
            Metrics::METRIC_PERFORMANCE_SCORE => Dimension::TYPE_NUMBER,
            Metrics::METRIC_AUDIT_NUMERIC_VALUE => Dimension::TYPE_NUMBER,
            Metrics::METRIC_AUDIT_DISPLAY_VALUE => Dimension::TYPE_NUMBER,
            Metrics::METRIC_LOAD_EXPERIENCE_CLS_NUMERICVALUE => Dimension::TYPE_NUMBER,
            Metrics::METRIC_LOAD_EXPERIENCE_LCP_NUMERICVALUE => Dimension::TYPE_NUMBER,
            Metrics::METRIC_LOAD_EXPERIENCE_FCP_NUMERICVALUE => Dimension::TYPE_NUMBER,
            Metrics::METRIC_LOAD_EXPERIENCE_FID_NUMERICVALUE => Dimension::TYPE_NUMBER,
            Metrics::METRIC_LOAD_EXPERIENCE_INP_NUMERICVALUE => Dimension::TYPE_NUMBER,
        ]);
    }

    public function getTranslations()
    {
        return self::appendAllStrategies([
            Metrics::METRIC_AUDIT_SCORE => Piwik::translate('SEOWebVitals_MetricAuditScorePercentage'),
            Metrics::METRIC_PERFORMANCE_SCORE => Piwik::translate('SEOWebVitals_MetricPageSpeedScore'),
            Metrics::METRIC_AUDIT_NUMERIC_VALUE => Piwik::translate('SEOWebVitals_MetricNumericScore'),
            Metrics::METRIC_AUDIT_DISPLAY_VALUE => Piwik::translate('SEOWebVitals_MetricInformation'),
            Metrics::METRIC_LOAD_EXPERIENCE_CLS_NUMERICVALUE => '%s CLS',
            Metrics::METRIC_LOAD_EXPERIENCE_LCP_NUMERICVALUE => '%s LCP',
            Metrics::METRIC_LOAD_EXPERIENCE_FCP_NUMERICVALUE => '%s FCP',
            Metrics::METRIC_LOAD_EXPERIENCE_FID_NUMERICVALUE => '%s FID',
            Metrics::METRIC_LOAD_EXPERIENCE_INP_NUMERICVALUE => '%s INP',
        ]);
    }

    public function updateAuditMetrics($metrics)
    {
        $info = $this->loadAuditMetrics();
        $hasUpdate = false;
        foreach ($metrics as $id => $metric) {
            if (!isset($info[$id]) || $metric != $info[$id]) {
                $info[$id] = $metric;
                $hasUpdate = true; // we only want to update the entry if something changes
            }
        }
        if ($hasUpdate) {
            Option::set(self::OPTION_KEY_AUDIT_METRICS, json_encode($info));
            $this->auditMetricsCached = $info;
        }
        return $info;
    }

    private function loadAuditMetrics()
    {
        if (!empty($this->auditMetricsCached)) {
            // for performance reasons we don't want to json decode every time
            return $this->auditMetricsCached;
        }
        $this->auditMetricsCached = Option::get(self::OPTION_KEY_AUDIT_METRICS);
        if (!empty($this->auditMetricsCached) && is_string($this->auditMetricsCached)) {
            $this->auditMetricsCached = json_decode($this->auditMetricsCached, true);
        }
        if (empty($this->auditMetricsCached) || !is_array($this->auditMetricsCached)) {
            $this->auditMetricsCached = [];
        }
        return $this->auditMetricsCached;
    }

    public function getAuditTitle($auditId)
    {
        $auditMetrics = $this->loadAuditMetrics();
        if (isset($auditMetrics[$auditId]['title'])) {
            return $auditMetrics[$auditId]['title'];
        }
        return ucfirst(str_replace('-', ' ', $auditId));
    }

    public function getAuditDescription($auditId)
    {
        $auditMetrics = $this->loadAuditMetrics();
        if (isset($auditMetrics[$auditId]['description'])) {
            $description = $auditMetrics[$auditId]['description'];

            // these links wouldn't work in the UI so we aim to remove them
            $description = preg_replace('/\[Learn more\]\(https\:\/\/web.dev\/(.*?)\/\)\.?/i', '', $description);

            return trim($description);
        }
    }

}
