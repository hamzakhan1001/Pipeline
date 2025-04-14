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

namespace Piwik\Plugins\MediaAnalytics\RecordBuilders\DataTableBuilders;

use Piwik\Plugins\MediaAnalytics\Archiver;
use Piwik\Plugins\MediaAnalytics\RecordBuilders\DataTableBuilder;
use Piwik\RankingQuery;

class ResourceTableBuilder extends DataTableBuilder
{
    public function addRow(array $resultSetRow): void
    {
        $fullLabel = $resultSetRow['label'];
        unset($resultSetRow['label']);

        if (empty($fullLabel)) {
            $label = Archiver::LABEL_NOT_DEFINED;
            $subLabel = null;
        } elseif ($fullLabel === RankingQuery::LABEL_SUMMARY_ROW) {
            $label = RankingQuery::LABEL_SUMMARY_ROW;
            $subLabel = '';
        } else {
            $parts = $this->getResourceParts($fullLabel);
            $label = $parts['host'];
            $subLabel = $parts['resource'];
        }

        $columns = self::createColumnsFromResultSetRow($resultSetRow);

        $topLevelRow = $this->dataTable->sumRowWithLabel($label, $columns, $this->queryRowColumnAggregationOps);
        if (!empty($subLabel)) {
            $topLevelRow->sumRowWithLabelToSubtable($subLabel, array_merge($columns, ['url' => $fullLabel]), $this->queryRowColumnAggregationOps);
        }
    }

    public function addRowToSubtable(string $secondaryDimension, $parentLabel, $label, array $resultSetRow): void
    {
        if (empty($parentLabel)) {
            return; // we do not compute subtable metrics for unknown labels
        }

        $parts = $this->getResourceParts($parentLabel);
        $parentLabel = $parts['host'];
        $subLabel = $parts['resource'];

        $firstLevelRow = $this->dataTable->getRowFromLabel($parentLabel);
        if (!$firstLevelRow) {
            return;
        }

        $parentSubtable = $firstLevelRow->getSubtable();
        if (!$parentSubtable) {
            return;
        }

        $subLabelRow = $parentSubtable->getRowFromLabel($subLabel);
        if (!$subLabelRow) {
            return;
        }

        $secondaryRow = $subLabelRow->sumRowWithLabelToSubtable($secondaryDimension, []);

        unset($resultSetRow['label']);
        $secondaryRow->sumRowWithLabelToSubtable($label, $resultSetRow, $this->queryRowColumnAggregationOps);
    }

    protected function getResourceParts($resource)
    {
        if (empty($resource)) {
            return $resource;
        }

        $resource = strtolower($resource);
        $parsed = parse_url($resource);

        $resource = '/';

        if (isset($parsed['path'])) {
            $resource .= trim($parsed['path'], '/');
        }

        if (isset($parsed['query'])) {
            $resource .= '?' . $parsed['query'];
        }

        return array(
            'host' => isset($parsed['host']) ? $parsed['host'] : '',
            'resource' => $resource,
        );
    }
}
