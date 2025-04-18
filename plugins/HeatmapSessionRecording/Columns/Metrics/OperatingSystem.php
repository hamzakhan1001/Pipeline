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

namespace Piwik\Plugins\HeatmapSessionRecording\Columns\Metrics;

use Piwik\DataTable\Row;
use Piwik\Metrics\Formatter;
use Piwik\Piwik;

class OperatingSystem extends BaseMetric
{
    public function getName()
    {
        return 'os';
    }

    public function getTranslatedName()
    {
        return Piwik::translate('HeatmapSessionRecording_ColumnOperatingSystem');
    }

    public function getDocumentation()
    {
        return Piwik::translate('HeatmapSessionRecording_ColumnOperatingSystemDocumentation');
    }

    public function compute(Row $row)
    {
        return $this->getMetric($row, 'config_os');
    }

    public function getDependentMetrics()
    {
        return array(
            'config_os',
        );
    }

    public function showsHtml()
    {
        return true;
    }

    public function format($value, Formatter $formatter)
    {
        if (empty($value) || $value === 'UNK') {
            return false;
        }

        $title = \Piwik\Plugins\DevicesDetection\getOsFullName($value);

        return '<img title="' . $title . '" style="height:16px;" src="' . \Piwik\Plugins\DevicesDetection\getOsLogo($value) . '">';
    }
}
