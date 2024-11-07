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

namespace Piwik\Plugins\MultiChannelConversionAttribution\RecordBuilders;

use Piwik\ArchiveProcessor;
use Piwik\ArchiveProcessor\Record;
use Piwik\ArchiveProcessor\RecordBuilder;
use Piwik\Common;
use Piwik\DataAccess\LogAggregator;
use Piwik\DataTable;
use Piwik\Plugins\MultiChannelConversionAttribution\Archiver;
use Piwik\Plugins\MultiChannelConversionAttribution\Metrics;
use Piwik\Plugins\MultiChannelConversionAttribution\Model\GoalAttributionModel;
use Piwik\Plugins\MultiChannelConversionAttribution\Models\Base;
use Piwik\Plugins\MultiChannelConversionAttribution\Models\LastNonDirect;
use Piwik\Plugins\MultiChannelConversionAttribution\Models\Linear;
use Piwik\Tracker\GoalManager;
use Piwik\Version;

class GoalAttribution extends RecordBuilder
{
    /**
     * @var array
     */
    private $campaignDimensionCombination;

    /**
     * @var array
     */
    private $idGoals;

    /**
     * @var array
     */
    private $recordColumns;

    /**
     * @var array
     */
    private $defaultRow = [];

    /**
     * @var array
     */
    private $lastNonDirectColumns;

    public function __construct(array $campaignDimensionCombination, array $idGoals, int $maxRowsInTable, int $maxRowsInSubtable)
    {
        parent::__construct();

        $this->maxRowsInTable = $maxRowsInTable;
        $this->maxRowsInSubtable = $maxRowsInSubtable;

        $this->columnToSortByBeforeTruncation = $this->getColumnToSort();

        $this->campaignDimensionCombination = $campaignDimensionCombination;
        $this->idGoals = $idGoals;

        $this->recordColumns = $this->getAttributionRecordColumns();
        foreach ($this->recordColumns as $column) {
            $this->defaultRow[$column] = 0;
        }

        $this->lastNonDirectColumns = $this->getLastNonDirectColumns();
        foreach ($this->lastNonDirectColumns as $column) {
            $this->defaultRow[$column] = 0;
        }
    }

    public function getRecordMetadata(ArchiveProcessor $archiveProcessor): array
    {
        $records = [];

        $allGoalsAttributionName = Archiver::completeChannelAttributionRecordName(GoalAttributionModel::ALL_GOAL_ID, $this->campaignDimensionCombination);
        $records[] = Record::make(Record::TYPE_BLOB, $allGoalsAttributionName);

        foreach ($this->idGoals as $idGoal) {
            $recordName = Archiver::completeChannelAttributionRecordName($idGoal, $this->campaignDimensionCombination);
            $records[] = Record::make(Record::TYPE_BLOB, $recordName);
        }

        return $records;
    }

    protected function aggregate(ArchiveProcessor $archiveProcessor): array
    {
        $idSite = $archiveProcessor->getParams()->getSite()->getId();
        if (empty($idSite)) {
            return [];
        }

        $idGoals = $this->idGoals;
        $campaignDimensionCombination = $this->campaignDimensionCombination;

        $records = [];

        $start = $archiveProcessor->getParams()->getDateStart();
        $logAggregator = $archiveProcessor->getLogAggregator();

        $channelRecordCombined = new DataTable(); // for all goals
        foreach ($idGoals as $idGoal) {
            $daysPriorToConversion = $campaignDimensionCombination['period'];
            $columnToQuery = 'logv.' . $campaignDimensionCombination['topLevel'];
            $columnToQueryNonDirect = 'log_vvv.' . $campaignDimensionCombination['topLevel'];
            if (!empty($campaignDimensionCombination['subLevel'])) {
                $columnToQuery = "concat(logv." . $campaignDimensionCombination['topLevel'] . ",' - ',logv." . $campaignDimensionCombination['subLevel'] . ")";
                $columnToQueryNonDirect = "concat(log_vvv." . $campaignDimensionCombination['topLevel'] . ",' - ',log_vvv." . $campaignDimensionCombination['subLevel'] . ")";
            }
            $sinceTime = $start->subDay($daysPriorToConversion)->getDatetime();

            $channelRecordGoal = new DataTable();

            $isEcommerce = $idGoal === GoalManager::IDGOAL_ORDER;

            // We want to exclude ecommerce from the All Goals attribution
            $recordsToAddTo = [$channelRecordGoal];
            if (!$isEcommerce) {
                $recordsToAddTo[] = $channelRecordCombined;
            }

            $cursor = $this->query($logAggregator, $idSite, $idGoal, $sinceTime, $columnToQuery);
            $this->addRowsToRecords($this->recordColumns, $recordsToAddTo, $cursor);
            unset($cursor);

            $cursor = $this->queryNonDirectVisits($logAggregator, $idSite, $idGoal, $sinceTime, $columnToQueryNonDirect);
            $this->addRowsToRecords($this->lastNonDirectColumns, $recordsToAddTo, $cursor);
            unset($cursor);

            $recordName = Archiver::completeChannelAttributionRecordName($idGoal, $campaignDimensionCombination);

            // inserting the blob manually rather than returning it so we don't have to hold on to a table for
            // every goal
            $this->insertBlobRecord(
                $archiveProcessor,
                $recordName,
                $channelRecordGoal,
                $this->maxRowsInTable,
                $this->maxRowsInSubtable,
                $this->columnToSortByBeforeTruncation
            );
            Common::destroy($channelRecordGoal);
            unset($channelRecordGoal);
        }

        //Insert All Goals
        $recordNameAllGoals = Archiver::completeChannelAttributionRecordName(GoalAttributionModel::ALL_GOAL_ID, $campaignDimensionCombination);
        $records[$recordNameAllGoals] = $channelRecordCombined;

        return $records;
    }

    private function queryNonDirectVisits(LogAggregator $aggregator, int $idSite, int $idGoal, string $sinceTime, string $columnToQueryNonDirect, bool $ignoreDirectVisits = true)
    {
        // we cannot add any bind as any argument as it would otherwise break segmentation

        $fromTable = version_compare(Version::VERSION, '5.2.0-b6', '>=')
            ? ['table' => 'log_conversion', 'useIndex' => 'index_idsite_datetime'] : 'log_conversion';
        $from = array($fromTable,
            array('table' => 'log_visit', 'joinOn' => 'log_conversion.idvisit = log_visit.idvisit'),
            array('table' => 'log_visit', 'tableAlias' => 'log_vpast', 'join' => 'RIGHT JOIN',
                'joinOn' => 'log_conversion.idvisitor = log_vpast.idvisitor'));

        $select = 'log_conversion.idvisitor, log_conversion.revenue, max(log_vpast.visit_last_action_time) as lastaction';
        $where = $aggregator->getWhereStatement('log_conversion', 'server_time');
        $extraWhere = '';
        if ($ignoreDirectVisits) {
            $extraWhere = ' AND log_vpast.referer_type != ' . Common::REFERRER_TYPE_DIRECT_ENTRY;
        }
        $where .= sprintf(
            'AND log_conversion.idgoal = %d 
                           AND log_vpast.idsite = %d AND log_vpast.visit_last_action_time >= \'%s\' 
                           AND log_vpast.visit_last_action_time <= log_visit.visit_last_action_time' . $extraWhere,
            (int) $idGoal,
            (int) $idSite,
            $sinceTime
        );

        $groupBy = 'log_conversion.idvisit, log_conversion.buster';
        $query = $aggregator->generateQuery($select, $from, $where, $groupBy, $orderBy = false);

        $model = new LastNonDirect();
        $conversionColumn = Metrics::completeAttributionMetric(Metrics::SUM_CONVERSIONS, $model);
        $revenueColumn = Metrics::completeAttributionMetric(Metrics::SUM_REVENUE, $model);

        $visitTable = Common::prefixTable('log_visit');
        $sql = sprintf('
          select log_vvv.referer_type as label, (case when log_vvv.referer_type=6 then ' . $columnToQueryNonDirect . ' else log_vvv.referer_name END) as sublabel, sum(revenue) as %s, count(*) as %s
          from (%s) as yyy  
          left join %s as log_vvv on log_vvv.idvisitor = yyy.idvisitor 
                                and log_vvv.idsite = %d 
                                and log_vvv.visit_last_action_time = lastaction
          group by label, sublabel', $revenueColumn, $conversionColumn, $query['sql'], $visitTable, (int) $idSite);

        $data = $aggregator->getDb()->query($sql, $query['bind']);
        if ($data->rowCount() == 0 && $ignoreDirectVisits) {
            return $this->queryNonDirectVisits($aggregator, $idSite, $idGoal, $sinceTime, $columnToQueryNonDirect, false);
        }
        return $data;
    }

    private function query(LogAggregator $aggregator, int $idSite, int $idGoal, string $sinceTime, string $columnToQuery)
    {
        $aggregationSelect = '';
        foreach (Base::getAll() as $model) {
            $query = $model->getAttributionQuery('num_pos', 'num_total');
            if (!empty($query)) {
                $aggregationSelect .= ', sum(' . $query . ') as ' . Metrics::completeAttributionMetric(Metrics::SUM_CONVERSIONS, $model);
                $aggregationSelect .= ', sum(if(revenue = 0, 0, revenue * ' . $query . ')) as ' . Metrics::completeAttributionMetric(Metrics::SUM_REVENUE, $model);
            }
        }

        // we cannot add any bind as any argument as it would otherwise break segmentation
        $maxNumVisitsBack = 110;
        $fromTable = version_compare(Version::VERSION, '5.2.0-b6', '>=')
            ? ['table' => 'log_conversion', 'useIndex' => 'index_idsite_datetime'] : 'log_conversion';
        $from = array($fromTable,
            array('table' => 'log_visit', 'joinOn' => 'log_conversion.idvisit = log_visit.idvisit'),
            array('table' => 'log_visit', 'tableAlias' => 'log_vpast', 'join' => 'RIGHT JOIN', 'joinOn' => 'log_conversion.idvisitor = log_vpast.idvisitor'));

        $select = 'log_conversion.idvisitor, log_conversion.idvisit, log_conversion.buster, log_conversion.revenue, log_visit.visit_last_action_time as lastactiontime, least(count(*),' . $maxNumVisitsBack . ') as num_total';
        $where = $aggregator->getWhereStatement('log_conversion', 'server_time');
        $where .= sprintf('AND log_conversion.idgoal = %d 
                           AND log_vpast.idsite = %d AND log_vpast.visit_last_action_time >= \'%s\' 
                           AND log_vpast.visit_last_action_time <= log_visit.visit_last_action_time', (int) $idGoal, (int) $idSite, $sinceTime);

        $groupBy = 'log_conversion.idvisit, log_conversion.idgoal, log_conversion.buster';
        $query = $aggregator->generateQuery($select, $from, $where, $groupBy, $orderBy = false);

        $logVisitTable = Common::prefixTable('log_visit');

        $outerWhere = 'num_pos < ' . $maxNumVisitsBack;

        $db = $aggregator->getDb();
        $db->query('SET @rnk=0, @curscore=0;');
        $sql = sprintf(
            '
       select referer_type as label, referer_name as sublabel %s from (  
            select (@rnk:=IF(@curscore = concat(r.idvisit, \'_\', r.buster),@rnk+1,1)) num_pos,
                 r.num_total as num_total,
                (@curscore:=concat(r.idvisit, \'_\', r.buster)) conversionId,
                logv.idvisitor, logv.referer_type, (case when logv.referer_type=6 then ' . $columnToQuery . ' else logv.referer_name end) as referer_name, r.revenue
            from (%s) as r
            RIGHT JOIN ' . $logVisitTable . ' logv on logv.idvisitor = r.idvisitor WHERE logv.idsite = %s 
                  AND logv.visit_last_action_time >= \'%s\' 
                  AND logv.visit_last_action_time <= lastactiontime
          ) as yyy where %s group by label, sublabel',
            $aggregationSelect,
            $query['sql'],
            $idSite,
            $sinceTime,
            $outerWhere
        );

        return $db->query($sql, $query['bind']);
    }

    private function getLastNonDirectColumns(): array
    {
        $model = new LastNonDirect();
        return [
            Metrics::completeAttributionMetric(Metrics::SUM_CONVERSIONS, $model),
            $revenueColumn = Metrics::completeAttributionMetric(Metrics::SUM_REVENUE, $model)
        ];
    }

    private function getAttributionRecordColumns(): array
    {
        $columns = [];
        foreach (Base::getAll() as $attribution) {
            if ($attribution->getAttributionQuery('1', '1')) {
                $columns[] = Metrics::completeAttributionMetric(Metrics::SUM_CONVERSIONS, $attribution);
                $columns[] = Metrics::completeAttributionMetric(Metrics::SUM_REVENUE, $attribution);
            }
        }
        return $columns;
    }


    /**
     * @param DataTable[] $records
     * @param $cursor
     */
    private function addRowsToRecords(array $columnNames, array $records, $cursor): void
    {
        while ($row = $cursor->fetch()) {
            $columns = $this->defaultRow;
            foreach ($columnNames as $name) {
                if (isset($row[$name])) {
                    $columns[$name] = round($row[$name], 4);
                }
            }

            $label = $this->getQueryRowLabelToUse($row['label']);
            $sublabel = $this->getQueryRowLabelToUse($row['sublabel']);

            foreach ($records as $record) {
                $topLevelRow = $record->sumRowWithLabel($label, $columns);
                if ($label != Common::REFERRER_TYPE_DIRECT_ENTRY) { // direct entry should not have a subtable
                    $topLevelRow->sumRowWithLabelToSubtable($sublabel, $columns);
                }
            }
        }
        $cursor->closeCursor();
    }

    private function getQueryRowLabelToUse(?string $rowLabel): string
    {
        if (empty($rowLabel) && $rowLabel !== '0') {
            return Archiver::LABEL_NOT_DEFINED;
        }
        return $rowLabel;
    }

    private function getColumnToSort(): string
    {
        // we should sort on one column as it is otherwise random which ones are shown and we have to decide for one
        // model. Using Linear for now as every interactions gets some attribution there but it might look much different
        // for lastInteraction etc. Could change it later
        return Metrics::completeAttributionMetric(Metrics::SUM_CONVERSIONS, new Linear());
    }
}
