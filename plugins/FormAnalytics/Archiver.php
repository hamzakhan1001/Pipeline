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

namespace Piwik\Plugins\FormAnalytics;

class Archiver extends \Piwik\Plugin\Archiver
{
    public const FORM_NUMERIC_RECORD_PREFIX = 'FormAnalytics';

    public const FORM_FIELDS_RECORD = 'FormAnalytics_fields';
    public const FORM_PAGE_URLS_RECORD = 'FormAnalytics_form_pageurls';
    public const FORM_DROP_OFF_RECORD = 'FormAnalytics_dropoff_fields';
    public const FORM_ENTRY_FIELDS_RECORD = 'FormAnalytics_entry_fields';

    public const MAX_ROWS_LIMIT = 500;

    public static function completeRecordName($recordName, $idSiteForm)
    {
        return $recordName . '_' . (int) $idSiteForm;
    }

    public static function getMetricNameFromNumericRecordName($recordName, $idSiteForm = false)
    {
        $metricName = str_replace(self::FORM_NUMERIC_RECORD_PREFIX . '_', '', $recordName);

        if (!empty($idSiteForm)) {
            $metricName = str_replace('_' . $idSiteForm, '', $metricName);
        }

        // eg $metricName => nb_conversions
        return $metricName;
    }

    public static function buildNumericFormRecordName($metric, $idSiteForm = false)
    {
        $record = self::FORM_NUMERIC_RECORD_PREFIX . '_' . $metric;

        if (!empty($idSiteForm)) {
            $record .= '_' . (int) $idSiteForm;
        }

        // eg FormAnalytics_Form_nb_conversions_6 => nb_conversions
        return $record;
    }

    public static function getNumericFormRecordNames($metrics, $idSiteForm = false)
    {
        $recordNames = array();
        foreach ($metrics as $metric) {
            $recordNames[] = self::buildNumericFormRecordName($metric, $idSiteForm);
        }
        return $recordNames;
    }
}
