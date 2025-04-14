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

namespace Piwik\Plugins\AbTesting\RecordBuilders;

use Piwik\ArchiveProcessor;
use Piwik\ArchiveProcessor\Record;
use Piwik\ArchiveProcessor\RecordBuilder;
use Piwik\Container\StaticContainer;
use Piwik\DataTable\Row;
use Piwik\DataTable;
use Piwik\Date;
use Piwik\Plugins\AbTesting\Archiver;
use Piwik\Plugins\AbTesting\Archiver\Aggregator;
use Piwik\Plugins\AbTesting\Configuration;

class BucketUniqueVisitors extends RecordBuilder
{
    /**
     * @var array
     */
    private $experiment;

    /**
     * @var Configuration
     */
    private $configuration;

    public const HASH_SIZE = 32;

    public function __construct(array $experiment)
    {
        parent::__construct();

        $this->experiment = $experiment;

        $this->configuration = StaticContainer::get(Configuration::class);

        $this->maxRowsInTable = $this->configuration->getMaximumHyperLogBucketArchivingRows();

        $this->columnAggregationOps = ['bucket_hash_min' => 'min'];
    }

    public function isEnabled(ArchiveProcessor $archiveProcessor): bool
    {
        return $this->configuration->isEstimatedUniqueVisitorArchivingEnabled();
    }

    public function getRecordMetadata(ArchiveProcessor $archiveProcessor): array
    {
        $idExperiment = $this->experiment['idexperiment'];

        return [
            Record::make(Record::TYPE_BLOB, Archiver::getExperimentEstimatedUniqueVisitorBucketRecordName($idExperiment)),
            Record::make(Record::TYPE_BLOB, Archiver::getExperimentEstimatedUniqueVisitorEnteredBucketRecordName($idExperiment)),
        ];
    }

    protected function aggregate(ArchiveProcessor $archiveProcessor): array
    {
        $idSite = $archiveProcessor->getParams()->getSite()->getId();
        if (!isset($idSite)) {
            return [];
        }

        $experiment = $this->experiment;
        $idExperiment = $experiment['idexperiment'];

        // skip finished experiment archiving for days after the experiment ended
        if ($experiment['status'] === 'finished' && !empty($experiment['end_date'])) {
            $endDate = Date::factory($experiment['end_date'])->setTime('23:59:59');
            if ($archiveProcessor->getParams()->getDateStart()->isLater($endDate)) {
                return [];
            }
        }

        $params = $archiveProcessor->getParams();
        $startDate = Date::factory($experiment['start_date'])->setTime('00:00:00');
        $today = Date::today();
        $records = [];

        if (!$today->isEarlier($startDate)) {
            $aggregator = new Aggregator($archiveProcessor->getLogAggregator());

            $estimatedUniqueVisitorsBucket = $aggregator->getEstimatedUniqueVisitorBuckets($experiment, $onlyEntered = false);
            if (!empty($estimatedUniqueVisitorsBucket)) {
                $records[Archiver::getExperimentEstimatedUniqueVisitorBucketRecordName($idExperiment)] = $this->makeRecordData($estimatedUniqueVisitorsBucket);
            }

            $estimatedUniqueVisitorsEnteredBucket = $aggregator->getEstimatedUniqueVisitorBuckets($experiment, $onlyEntered = true);
            if (!empty($estimatedUniqueVisitorsEnteredBucket)) {
                $records[Archiver::getExperimentEstimatedUniqueVisitorEnteredBucketRecordName($idExperiment)] = $this->makeRecordData($estimatedUniqueVisitorsEnteredBucket);
            }
        }

        return $records;
    }

    private function makeRecordData($data)
    {
        $table = new DataTable();
        $this->addBucketRowsToRecord($table, $data);

        return $table;
    }

    private function addBucketRowsToRecord(DataTable &$record, $data)
    {
        if (!empty($data)) {
            foreach ($data as $row) {
                if (isset($row['label']) && isset($row['bucket_num'])) {
                    $row['label'] = $row['label'] . '_' . $row['bucket_num'];
                    unset($row['bucket_num']);
                }
                $record->addRow(new Row([
                    Row::COLUMNS => $row
                ]));
            }
        }
    }

    public static function setEstimatedUniqueVisitors($rows, $metricName, &$estimatedUniqueVisitorsData)
    {
        if (empty($rows)) {
            return [];
        }

        $data = [];
        foreach ($rows as $row) {
            if (is_object($row) && property_exists($row, 'getColumns')) {
                $columns = $row->getColumns();
            } else {
                $columns = $row;
            }

            if ($columns['label'] === Archiver::LABEL_NOT_DEFINED) {
                continue;
            }
            $explodeLabel =  explode('_', $columns['label']);
            if (count($explodeLabel) > 1) {
                $columns['label'] = $explodeLabel[0];
                $columns['bucket_num'] = $explodeLabel[1];
            }
            $data[$columns['label']][] = $columns;
        }

        foreach ($data as $label => $bucketArray) {
            $estimatedUniqueVisitorsData[$label]['label'] = $label;
            $estimatedUniqueVisitorsData[$label][$metricName] = self::calculateUniqueValues($bucketArray, $label);
        }
    }

    private static function calculateUniqueValues($data, $label)
    {
        $bucketCount = Aggregator::getBucketCount();
        $totalRows = count($data);
        $sum_bucket_hash = 0;
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['bucket_hash'] = ((BucketUniqueVisitors::HASH_SIZE - 1) - floor(log($data[$i]['bucket_hash_min'], 2)));
            $sum_bucket_hash += pow(2, -1 * $data[$i]['bucket_hash']);
        }

        $numUniques = (pow($bucketCount, 2) * (0.7213 / (1 + 1.079 / $bucketCount))) / (($bucketCount - $totalRows) + $sum_bucket_hash);
        $numZeroBuckets = $bucketCount - count($data);

        $approxDistinctCount = $numUniques;
        if ($numUniques < (2.5 * $bucketCount) and $numZeroBuckets > 0) {
            $approxDistinctCount = ((0.7213 / (1 + 1.079 / $bucketCount)) * ($bucketCount * log(($bucketCount / $numZeroBuckets), 2)));
        }

        return ((int) $approxDistinctCount);
    }
}
