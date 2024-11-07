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

namespace Piwik\Plugins\Funnels\DataTable\Filter;

use Piwik\Container\StaticContainer;
use Piwik\DataTable;
use Piwik\NumberFormatter;
use Piwik\Piwik;
use Piwik\Plugin\Manager;
use Piwik\Plugins\Funnels\Metrics;
use Piwik\Plugins\Live\Live;

class PrepareColumnsAndMetadata extends DataTable\BaseFilter
{
    /**
     * @var array
     */
    private $funnel;

    /**
     * @var array
     */
    private $steps;

    /**
     * @var boolean
     */
    private $isClosed = false;

    /**
     * @var boolean
     */
    private $isVisitorLogEnabled = false;

    public function __construct(DataTable $table, $funnel)
    {
        parent::__construct($table);

        $this->funnel = $funnel;
        $this->steps = $funnel['steps'] ?? [];
        // If all steps have a required value of 1, then the funnel is closed
        $requiredValues = array_unique(array_column($this->steps, 'required'));
        $this->isClosed = count($requiredValues) === 1 && !empty($requiredValues[0]);
        $this->isVisitorLogEnabled = Manager::getInstance()->isPluginActivated('Live') && Live::isVisitorLogEnabled();
    }

    /**
     * @param DataTable $table
     */
    public function filter($table)
    {
        $numberFormatter = StaticContainer::get(NumberFormatter::class);

        foreach ($table->getRows() as $row) {
            $row->setMetadata('isVisitorLogEnabled', $this->isVisitorLogEnabled);
            $label = $row->getColumn('label');
            $visitsCount = $row->getColumn(Metrics::NUM_STEP_VISITS);
            $proceedsCount = $row->getColumn(Metrics::NUM_STEP_PROCEEDS);
            $progressionsCount = $row->getColumn(Metrics::NUM_STEP_PROGRESSIONS);
            $entriesCount = $row->getColumn(Metrics::NUM_STEP_ENTRIES);
            $skipsCount = $row->getColumn(Metrics::NUM_STEP_SKIPS);
            $exitsCount = $row->getColumn(Metrics::NUM_STEP_EXITS);

            // Clear the columns so that we can start fresh
            $row->setColumns(['label' => $label]);

            $row->setColumn(Metrics::NUM_STEP_VISITS, $visitsCount);

            // If the funnel isn't closed, add some extra columns
            if (!$this->isClosed) {
                $row->setColumn(Metrics::NUM_STEP_PROGRESSIONS, $progressionsCount);
                $row->setColumn(Metrics::NUM_STEP_ENTRIES, $entriesCount);
                $row->setColumn(Metrics::NUM_STEP_SKIPS, $skipsCount);
            }

            $row->setColumn(Metrics::NUM_STEP_PROCEEDS, $proceedsCount);
            if ($proceedsCount) {
                $proceedsRate = $visitsCount ? $proceedsCount / $visitsCount : 0;
                $row->setMetadata(Metrics::RATE_PROCEEDED, $numberFormatter->formatPercent($proceedsRate * 100, 1, 0));
            }
            $row->setColumn(Metrics::NUM_STEP_EXITS, $exitsCount);
            if ($exitsCount) {
                $exitRate = $visitsCount ? $exitsCount / $visitsCount : 0;
                $row->setMetadata(Metrics::RATE_EXITED, $numberFormatter->formatPercent($exitRate * 100, 1, 0));
            }
            $row->setColumn(Piwik::translate('General_Actions'), 0);
        }
    }
}
