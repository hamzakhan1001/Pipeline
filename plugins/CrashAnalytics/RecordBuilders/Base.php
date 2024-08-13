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

namespace Piwik\Plugins\CrashAnalytics\RecordBuilders;

use Piwik\ArchiveProcessor\RecordBuilder;
use Piwik\Container\StaticContainer;
use Piwik\DataTable;
use Piwik\Plugins\CrashAnalytics\Configuration;
use Piwik\Plugins\CrashAnalytics\Metrics;

abstract class Base extends RecordBuilder
{
    /**
     * @var int
     */
    protected $rankingQueryLimit;

    public function __construct()
    {
        parent::__construct();

        $configuration = StaticContainer::get(Configuration::class);

        $maxRows = $configuration->getDataTableArchivingMaximumRows();
        $this->maxRowsInTable = $maxRows;
        $this->maxRowsInSubtable = $maxRows;

        $this->rankingQueryLimit = $configuration->getRankingQueryLimit();
        $this->columnAggregationOps = Metrics::getMetricAggregationOps();

        $this->columnToSortByBeforeTruncation = Metrics::CRASH_OCCURRENCES;
    }

    protected function setTableAggregationOpsRecursively(DataTable $table)
    {
        $table->setMetadata(DataTable::COLUMN_AGGREGATION_OPS_METADATA_NAME, $this->columnAggregationOps);
        $table->filterSubtables(function (DataTable $t) {
            $t->setMetadata(DataTable::COLUMN_AGGREGATION_OPS_METADATA_NAME, $this->columnAggregationOps);
        });
    }
}
