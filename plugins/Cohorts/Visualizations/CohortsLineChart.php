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

namespace Piwik\Plugins\Cohorts\Visualizations;

use Piwik\Plugins\Cohorts\Visualizations\JqplotDataGenerator\LineChart;
use Piwik\Plugins\CoreVisualizations\Visualizations\JqplotGraph\Evolution;
use Piwik\Plugins\CoreVisualizations\Metrics\Formatter\Numeric;

class CohortsLineChart extends Evolution
{
    public const ID = 'cohortsLineChart';
    public const FOOTER_ICON_TITLE = '';
    public const FOOTER_ICON = '';

    public function beforeRender()
    {
        parent::beforeRender();

        $this->config->datatable_js_type = 'CohortsEvolutionGraphDataTable';
    }


    public function beforeLoadDataTable()
    {
        $this->metricsFormatter = new Numeric();
    }

    protected function makeDataGenerator($properties)
    {
        return new LineChart($properties, 'evolution', $this);
    }

    // This must be overridden to allow this visualisation to support single periods
    protected function checkRequestIsOnlyForMultiplePeriods()
    {
    }
}
