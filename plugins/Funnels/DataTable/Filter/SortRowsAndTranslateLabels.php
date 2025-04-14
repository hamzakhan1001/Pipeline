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

class SortRowsAndTranslateLabels extends DataTable\BaseFilter
{
    /**
     * @param DataTable $table
     */
    public function filter($table)
    {
        // Make sure that the proceeded row is above the entry/exit rows
        $table->sort(function (DataTable\Row $rowA, DataTable\Row $rowB) {
            if ($rowA->getColumn('label') === 'proceeded') {
                return -1;
            }

            // Sort skipped at the end
            if ($rowB->getColumn('label') === 'skipped' && $rowA->getColumn('label') !== 'exits') {
                return -1;
            }

            if ($rowA->getColumn('label') === 'entries' && $rowB->getColumn('label') === 'exits') {
                return -1;
            }

            return 1;
        }, 'label');

        // Update the labels with their translations
        foreach ($table->getRows() as $row) {
            $label = $row->getColumn('label');
            if ($label === 'proceeded') {
                $row->setColumn('label', Piwik::translate('Funnels_Proceeded'));
                continue;
            }
            if ($label === 'skipped') {
                $row->setColumn('label', Piwik::translate('Funnels_Skips'));
                continue;
            }
            if ($label === 'entries') {
                $row->setColumn('label', Piwik::translate('Funnels_Entries'));
                continue;
            }
            $row->setColumn('label', Piwik::translate('Funnels_Exits'));
        }
    }
}
