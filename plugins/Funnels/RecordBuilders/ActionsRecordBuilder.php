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

namespace Piwik\Plugins\Funnels\RecordBuilders;

use Piwik\DataTable;
use Piwik\Plugins\Funnels\Metrics;

abstract class ActionsRecordBuilder extends Base
{
    protected function addRowsToDataArray(DataTable $record, $cursor): void
    {
        $emptyRow = [Metrics::NUM_HITS => 0];

        while ($row = $cursor->fetch()) {
            $stepPosition = $row['label'];
            $sublabel = $row['sublabel'] ?? '';
            unset($row['label']);
            unset($row['sublabel']);

            if (!empty($sublabel)) {
                $sublabel = rtrim($sublabel, '/');
            }

            // toplevel row has no columns but label
            $toplevelRow = $record->sumRowWithLabel($stepPosition, []);

            $columns = array_merge($emptyRow, $row);
            $toplevelRow->sumRowWithLabelToSubtable($sublabel, $columns, $this->columnAggregationOps);
        }
    }
}
