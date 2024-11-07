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

class CompileSubtableUsingFlowData extends DataTable\BaseFilter
{
    /**
     * @var int
     */
    private $stepPosition;

    /**
     * @var DataTable
     */
    private $flowTable;

    public function __construct(DataTable $table, DataTable $flowTable, int $stepPosition)
    {
        parent::__construct($table);

        $this->flowTable = $flowTable;
        $this->stepPosition = $stepPosition;
    }

    /**
     * @param DataTable $table
     */
    public function filter($table)
    {
        $stepPosition = $this->stepPosition;
        $row = $this->flowTable->getRowFromLabel((string) $stepPosition);
        $isLastStep = empty($this->flowTable->getRowFromLabel((string) $stepPosition + 1));

        $entriesCount = $row->getColumn(Metrics::NUM_STEP_ENTRIES);
        $exitsCount = $row->getColumn(Metrics::NUM_STEP_EXITS);


        $subTableArray = [
            [
                DataTable\Row::COLUMNS => [
                    'label' => 'entries',
                    Metrics::NUM_HITS => $entriesCount,
                ],
                DataTable\Row::METADATA => [
                    'table_depth' => 2,
                    'step_position' => $stepPosition,
                    'sub_step_type' => 'entry'
                ]
            ]
        ];

        // Always show exits row, except for last step
        if (!$isLastStep) {
            $subTableArray[] = [
                DataTable\Row::COLUMNS => [
                    'label' => 'exits',
                    Metrics::NUM_HITS => $exitsCount,
                ],
                DataTable\Row::METADATA => [
                    'table_depth' => 2,
                    'step_position' => $stepPosition,
                    'sub_step_type' => 'exit'
                ]
            ];
        }

        // Add the newly populated rows to the table
        if (!empty($subTableArray)) {
            $table->addRowsFromArray($subTableArray);
            foreach ($rows = $table->getRows() as $index => $row) {
                // No subTable needed for rows that don't have a hit count
                if ($row->getColumn(Metrics::NUM_HITS)) {
                    $row->setSubtable(new DataTable());
                }
            }
        }
    }
}
