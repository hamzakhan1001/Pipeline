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
use Piwik\Piwik;
use Piwik\Plugins\Funnels\Db\Pattern;
use Piwik\Plugins\Funnels\Model\FunnelsModel;

class AddStepDefinitionMetadata extends DataTable\BaseFilter
{
    /**
     * @var array
     */
    private $patternsByStep = array();

    /**
     * @var null|int
     */
    private $lastStepPosition;

    /**
     * @var null|int
     */
    private $funnelName;

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

    public function __construct(DataTable $table, $funnel)
    {
        parent::__construct($table);

        if (!empty($funnel['steps'])) {
            foreach ($funnel['steps'] as $step) {
                if (!empty($step['pattern']) && !empty($step['pattern_type'])) {
                    $this->patternsByStep[$step['position']] = $step;
                }
            }
        }

        if (!empty($funnel[FunnelsModel::KEY_FINAL_STEP_POSITION]) && empty($funnel['isNonGoalFunnel'])) {
            $this->lastStepPosition = $funnel[FunnelsModel::KEY_FINAL_STEP_POSITION];
        }

        if (isset($funnel['name'])) {
            $this->funnelName = $funnel['name'];
        }

        $this->funnel = $funnel;
        $this->steps = $funnel['steps'] ?? [];
        // If all steps have a required value of 1, then the funnel is closed
        $requiredValues = array_unique(array_column($this->steps, 'required'));
        $this->isClosed = count($requiredValues) === 1 && !empty($requiredValues[0]);
    }

    /**
     * @param DataTable $table
     */
    public function filter($table)
    {
        $patterns = Pattern::getTranslationsForPatternTypes();

        foreach ($table->getRowsWithoutSummaryRow() as $row) {
            $stepPosition = $row->getColumn('label');

            if ($this->lastStepPosition == $stepPosition && !empty($this->funnelName)) {
                $converts = Piwik::translate('Funnels_ConvertsGoal');
                $definition = $converts . ': ' . $this->funnelName;

                $row->setMetadata('step_definition', $definition);
            } elseif (!empty($this->patternsByStep[$stepPosition])) {
                $step = $this->patternsByStep[$stepPosition];

                $patternType = $step['pattern_type'];
                if (!empty($patterns[$patternType])) {
                    $patternType = $patterns[$patternType];
                }

                if (!empty($step['required'])) {
                    $required = Piwik::translate('General_Yes');
                } else {
                    $required = Piwik::translate('General_No');
                }

                $definition  = Piwik::translate('Goals_Pattern') . ': ' . $patternType . ' "' . $step['pattern'] . '"';
                // Only show required value if the funnel is an open funnel
                if (!$this->isClosed) {
                    $definition .= "\n" . Piwik::translate('General_Required2') . ': ' . $required;
                }

                $row->setMetadata('step_definition', $definition);
            }
        }
    }
}
