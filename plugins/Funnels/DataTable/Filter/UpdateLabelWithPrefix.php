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
use Piwik\Plugins\Funnels\Reports\GetFunnelFlowTable;

class UpdateLabelWithPrefix extends DataTable\BaseFilter
{
    /**
     * @param DataTable $table
     */
    public function filter($table)
    {
        foreach ($table->getRows() as $row) {
            // We have to use a custom label in order for the evolution to work with the prefixed label
            $label = $row->getColumn('label');
            $row->setColumn(GetFunnelFlowTable::ROW_IDENTIFIER, $label);
        }
    }
}
