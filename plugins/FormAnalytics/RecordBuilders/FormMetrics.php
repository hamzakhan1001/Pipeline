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

namespace Piwik\Plugins\FormAnalytics\RecordBuilders;

use Piwik\ArchiveProcessor;
use Piwik\ArchiveProcessor\Record;
use Piwik\Plugins\FormAnalytics\Archiver;
use Piwik\Plugins\FormAnalytics\Archiver\LogAggregator;
use Piwik\Plugins\FormAnalytics\Metrics;

class FormMetrics extends Base
{
    public function getRecordMetadata(ArchiveProcessor $archiveProcessor): array
    {
        $idSite = $archiveProcessor->getParams()->getSite()->getId();
        if (empty($idSite)) {
            return [];
        }

        $metrics = Metrics::getNumericFormMetrics();

        $records = [];

        $formIds = $this->getActivatedFormIds($idSite);
        $formIds[] = false;
        foreach ($formIds as $idSiteForm) {
            foreach ($metrics as $metric) {
                $records[] = Record::make(Record::TYPE_NUMERIC, Archiver::buildNumericFormRecordName($metric, $idSiteForm));
            }
        }

        return $records;
    }

    protected function aggregate(ArchiveProcessor $archiveProcessor): array
    {
        $idSite = $archiveProcessor->getParams()->getSite()->getId();
        if (empty($idSite)) {
            return [];
        }

        $aggregator = new LogAggregator($archiveProcessor->getLogAggregator());

        $cursor = $aggregator->aggregateFormMetrics();

        $metrics = Metrics::getNumericFormMetrics();

        $numericEntries = [];

        while ($row = $cursor->fetch()) {
            $idSiteForm = $row['label'];
            foreach ($metrics as $metric) {
                if (isset($row[$metric])) {
                    $column = Archiver::buildNumericFormRecordName($metric, $idSiteForm);
                    $totalColumn = Archiver::buildNumericFormRecordName($metric);

                    if (isset($numericEntries[$column])) {
                        $numericEntries[$column] += $row[$metric];
                    } else {
                        $numericEntries[$column] = $row[$metric];
                    }

                    if (isset($numericEntries[$totalColumn])) {
                        $numericEntries[$totalColumn] += $row[$metric];
                    } else {
                        $numericEntries[$totalColumn] = $row[$metric];
                    }
                }
            }
        }

        $cursor->closeCursor();
        unset($cursor);

        return $numericEntries;
    }
}
