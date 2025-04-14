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

use Piwik\DataTable;
use Piwik\Plugins\Funnels\Metrics;

class ComputeBackfills extends DataTable\BaseFilter
{
    /**
     * @param DataTable $table
     */
    public function filter($table)
    {
        $steps = $table->getColumn('label');

        if (empty($steps)) {
            return;
        }

        $lastNumProceeded = $lastNumProceededBackfilled = $lastSkipped = 0;

        $numSteps = count($steps);

        foreach ($steps as $index => $label) {
            $row = $table->getRowFromLabel($label);

            $isFirstStep = $index === 0;
            $isLastStep = $numSteps === $index + 1;

            $numHits = (int) $row->getColumn(Metrics::NUM_STEP_VISITS_ACTUAL);
            $numEntries = (int) $row->getColumn(Metrics::NUM_STEP_ENTRIES);
            $numExits = (int) $row->getColumn(Metrics::NUM_STEP_EXITS);
            $row->setColumn(Metrics::NUM_STEP_VISITS, $numHits);
            $numProceeded = $numHits - $numExits;

            $skipped = max($lastNumProceededBackfilled - $numHits, 0);
            // If some of the proceeded from the previous step skipped this step, adjust for that
            if ($numHits < $lastNumProceeded - $skipped + $numEntries) {
                $skipped -= ($numHits - ($lastNumProceeded - $skipped + $numEntries));
            }

            // Make sure that we account for edge case where overlapping skips cancel each other out
            if ($numHits === $lastNumProceeded + $numEntries && $lastSkipped > 0) {
                $skipped = $lastSkipped;
            }

            if ($isLastStep) {
                $row->setColumn(Metrics::NUM_STEP_PROCEEDS, 0);
            } else {
                $row->setColumn(Metrics::NUM_STEP_SKIPS, $skipped);
                $row->setColumn(Metrics::NUM_STEP_PROCEEDS, $numProceeded);
            }

            $row->setColumn(Metrics::NUM_STEP_PROGRESSIONS, max($numHits - $numEntries, 0));

            $lastNumProceeded = $numProceeded;
            $lastNumProceededBackfilled = $isFirstStep ? $numProceeded : $lastNumProceededBackfilled + $numEntries - $numExits;
            $lastSkipped = $skipped;
        }
    }
}
