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

namespace Piwik\Plugins\MediaAnalytics\RecordBuilders;

use Piwik\ArchiveProcessor;
use Piwik\ArchiveProcessor\RecordBuilder;
use Piwik\Container\StaticContainer;
use Piwik\Plugins\MediaAnalytics\Archiver;
use Piwik\Plugins\MediaAnalytics\Archiver\Aggregator;
use Piwik\Plugins\MediaAnalytics\Configuration;
use Piwik\Plugins\MediaAnalytics\Dao\LogMediaPlays;
use Piwik\Plugins\MediaAnalytics\Metrics;
use Piwik\Plugins\MediaAnalytics\RecordBuilders\DataTableBuilders\HourTableBuilder;

abstract class Base extends RecordBuilder
{
    /**
     * @var Configuration
     */
    protected $configuration;

    public function __construct()
    {
        parent::__construct();

        $this->configuration = StaticContainer::get(Configuration::class);
        $this->maxRowsInTable = $this->configuration->getMaximumRowsInDataTable();
        $this->maxRowsInSubtable = $this->configuration->getMaximumRowsInSubTable();

        $this->columnToSortByBeforeTruncation = Metrics::METRIC_NB_PLAYS;

        $this->columnAggregationOps = Archiver::getColumnAggregationOpteration();
    }

    /**
     * @param DataTableBuilder[] $dataTableBuilders
     * @param $where
     * @param $groupByColumn
     * @param bool $withSubtableReport
     * @internal param $select
     */
    protected function makeRegularReport(
        ArchiveProcessor $archiveProcessor,
        $dataTableBuilders,
        $where,
        $groupByColumn,
        $withSubtableReport = false
    ) {
        $aggregator = new Aggregator(
            $archiveProcessor->getLogAggregator(),
            $archiveProcessor->getParams()->getSegment(),
            $this->configuration
        );

        $aggregationMethods = ['queryImpressions', 'queryPlays'];
        foreach ($aggregationMethods as $method) {
            $cursor = $aggregator->$method($where, $groupByColumn);

            while ($row = $cursor->fetch()) {
                foreach ($dataTableBuilders as $processor) {
                    $processor->addRow($row);
                }
            }

            $cursor->closeCursor();
            unset($cursor);
        }

        if ($withSubtableReport) {
            $this->archiveSecondaryDimensionSpentTime($aggregator, $dataTableBuilders, $groupByColumn, $where);
            $this->archiveSecondaryDimensionMediaProgress($aggregator, $dataTableBuilders, $groupByColumn, $where);
            $this->archiveSecondaryDimensionResolution($aggregator, $dataTableBuilders, $groupByColumn, $where);
            $this->archiveSecondaryDimensionHours($archiveProcessor, $aggregator, $dataTableBuilders, $groupByColumn, $where);
            $this->archiveSecondaryDimensionMediaSegments($aggregator, $dataTableBuilders, $groupByColumn, $where);
        }
    }

    /**
     * @param DataTableBuilder[] $dataTableBuilders
     */
    private function archiveSecondaryDimensionSpentTime(Aggregator $aggregator, $dataTableBuilders, $groupByColumn, $where)
    {
        $cursor = $aggregator->querySpentTime($groupByColumn, $where);

        while ($row = $cursor->fetch()) {
            $parentLabel = $row['parentLabel'];
            unset($row['parentLabel']);

            $label = Archiver::putValueIntoSecondsBucket($row['label']);

            foreach ($dataTableBuilders as $builder) {
                $builder->addRowToSubtable(Archiver::SECONDARY_DIMENSION_SPENT_TIME, $parentLabel, $label, $row);
            }
        }
        $cursor->closeCursor();
    }

    /**
     * @param DataTableBuilder[] $dataTableBuilders
     */
    private function archiveSecondaryDimensionMediaProgress(Aggregator $aggregator, $dataTableBuilders, $groupByColumn, $where)
    {
        $cursor = $aggregator->queryMediaProgress($groupByColumn, $where);
        while ($row = $cursor->fetch()) {
            $parentLabel = $row['parentLabel'];
            unset($row['parentLabel']);

            foreach ($dataTableBuilders as $builder) {
                $builder->addRowToSubtable(Archiver::SECONDARY_DIMENSION_MEDIA_PROGRESS, $parentLabel, $row['label'], $row);
            }
        }
        $cursor->closeCursor();
    }

    /**
     * @param DataTableBuilder[] $dataTableBuilders
     */
    private function archiveSecondaryDimensionMediaSegments(Aggregator $aggregator, $dataTableBuilders, $groupByColumn, $where)
    {
        $segments = LogMediaPlays::getSegments();
        $groupedSegments = LogMediaPlays::getSmallGapsSegmentsMadeRegularSize();

        $cursor = $aggregator->queryMediaSegments($groupByColumn, $where);
        while ($row = $cursor->fetch()) {
            $parentLabel = $row['parentLabel'];
            unset($row['parentLabel']);

            // we only keep rows that are lower or as high as the max length. no need to keep any other rows
            $maxMediaLength = LogMediaPlays::moveMaxLengthIntoSegment($segments, $row[Metrics::METRIC_MAX_MEDIA_LENGTH]);

            $rows = array();

            // for more efficiency we store this in a "metadata" row which we remove when the table is being requested through the API
            // we cannot fetch this from the regular report since we don't know the parent row of a subtable
            $rows[] = array(
                'label' => Archiver::METADATA_ROW,
                Metrics::METRIC_MAX_MEDIA_LENGTH => $maxMediaLength,
                Metrics::METRIC_SUM_PLAYS => $row[Metrics::METRIC_SUM_PLAYS],
            );

            foreach ($groupedSegments as $groupedSegment) {
                if ($groupedSegment > $maxMediaLength) {
                    continue; // not interested
                }

                $segmentColumn = LogMediaPlays::makeSegmentGroupColumn($groupedSegment);

                if ($row['sum_' . $segmentColumn] > 0) {
                    $rows[] = array('label' => $groupedSegment . Archiver::GROUPED_MEDIA_SEGMENT_APPENDIX, Metrics::METRIC_NB_PLAYS => $row['sum_' . $segmentColumn]);
                }
            }

            foreach ($segments as $segment) {
                if ($segment > $maxMediaLength) {
                    continue; // not interested
                }

                $segmentColumn = LogMediaPlays::makeSegmentColumn($segment);

                if ($row['sum_' . $segmentColumn] > 0) {
                    $rows[] = array('label' => $segment, Metrics::METRIC_NB_PLAYS => $row['sum_' . $segmentColumn]);
                }
            }

            foreach ($rows as $row) {
                foreach ($dataTableBuilders as $builder) {
                    $builder->addRowToSubtable(Archiver::SECONDARY_DIMENSION_MEDIA_SEGMENTS, $parentLabel, $row['label'], $row);
                }
            }
        }
        $cursor->closeCursor();
    }

    /**
     * @param DataTableBuilder[] $dataTableBuilders
     */
    private function archiveSecondaryDimensionResolution(Aggregator $aggregator, $dataTableBuilders, $groupByColumn, $where)
    {
        $cursor = $aggregator->queryResolution($groupByColumn, $where);

        $resource = array();

        while ($row = $cursor->fetch()) {
            $parentLabel = $row['parentLabel']; // ==> resource or name
            unset($row['parentLabel']);

            if (!isset($resource[$parentLabel])) {
                $resource[$parentLabel] = 1;
            } elseif ($resource[$parentLabel] > 10) {
                // we only save the top 10 resolutions per resource for each day. This means the aggregated sums
                // might not be 100% correct but that should be fine as usually there are not too many resolutions.
                // this works because they are ordered by plays, won't be possible to sort by something else
                continue;
            } else {
                $resource[$parentLabel]++;
            }

            foreach ($dataTableBuilders as $builder) {
                $builder->addRowToSubtable(Archiver::SECONDARY_DIMENSION_RESOLUTION, $parentLabel, $row['label'], $row);
            }
        }
        $cursor->closeCursor();
    }

    /**
     * @param DataTableBuilder[] $dataTableBuilders
     */
    private function archiveSecondaryDimensionHours(ArchiveProcessor $archiveProcessor, Aggregator $aggregator, $dataTableBuilders, $groupByColumn, $where)
    {
        $cursor = $aggregator->queryHours($groupByColumn, $where);

        $hourDataArray = new HourTableBuilder($archiveProcessor->getParams());

        while ($row = $cursor->fetch()) {
            // todo: should it be 5?
            if ($row[Metrics::METRIC_NB_PLAYS] < 1) {
                // ignore any resolution that had less than 5 plays, just to not save too many of them
                continue;
            }

            $label = $row['label'];

            $convertedLabel = $label;
            if (is_numeric($label)) {
                $convertedLabel = $hourDataArray->convertTimeToLocalTimezone($label);
            }

            $parentLabel = $row['parentLabel'];
            unset($row['parentLabel']);

            foreach ($dataTableBuilders as $builder) {
                // Make sure that we convert the hour labels to the local timezone. Only HoursDataArray does this already.
                $labelToUse = $builder instanceof HourTableBuilder ? $label : $convertedLabel;
                $builder->addRowToSubtable(Archiver::SECONDARY_DIMENSION_HOURS, $parentLabel, $labelToUse, $row);
            }
        }
        $cursor->closeCursor();
    }
}
