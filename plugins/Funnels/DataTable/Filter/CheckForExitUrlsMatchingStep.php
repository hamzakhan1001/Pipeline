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
use Piwik\Plugins\Funnels\API;
use Piwik\Plugins\Funnels\Archiver;

class CheckForExitUrlsMatchingStep extends DataTable\BaseFilter
{
    /**
     * @var int $idSite
     */
    private $idSite;

    /**
     * @var int $idFunnel
     */
    private $idFunnel;

    /**
     * @var int $step
     */
    private $step;

    /**
     * @var array $matchMap
     */
    private $matchMap;

    public function __construct(DataTable $table, int $idSite, int $idFunnel, int $step)
    {
        parent::__construct($table);

        $this->idSite = $idSite;
        $this->idFunnel = $idFunnel;
        $this->step = $step;
        $this->matchMap = [];
    }

    /**
     * @param DataTable $table
     */
    public function filter($table)
    {
        $funnel = API::getInstance()->getFunnel($this->idSite, $this->idFunnel);
        $steps = $funnel['steps'];

        foreach ($table->getRows() as $index => $row) {
            $label = $row->getColumn('label');
            // Skip translation labels as there's no need to check them
            if (in_array($label, [Archiver::LABEL_VISIT_EXIT, Archiver::LABEL_NOT_DEFINED])) {
                continue;
            }

            if (!$this->doesUrlMatchStep($label, $steps)) {
                continue;
            }

            // Get the regular exits row and add the current row to it
            $exitsRow = $table->getRowFromLabel(Archiver::LABEL_VISIT_EXIT);
            // If the general exits row doesn't already exist, switch the current row to be the general row
            if (empty($exitsRow)) {
                $row->setColumn('label', Archiver::LABEL_VISIT_EXIT);
                continue;
            }

            // Since we are here, the row already exists. So, sum the rows and delete the current row
            $exitsRow->sumRow($row, false);
            $table->deleteRow($index);
        }

        $table->setLabelsHaveChanged();
    }

    public function doesUrlMatchStep(string $label, array $steps): bool
    {
        // If the property already has a value, use that. Otherwise, look it up using the API
        $matches = $this->matchMap[$label] = $this->matchMap[$label] ?? API::getInstance()->testUrlMatchesSteps($label, $steps);
        if (empty($matches['tests']) || empty($matches['tests'][$this->step - 1]) || empty($matches['tests'][$this->step - 1]['matches'])) {
            return false;
        }

        return true;
    }
}
