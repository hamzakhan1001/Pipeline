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

namespace Piwik\Plugins\MediaAnalytics\Archiver;

use Piwik\Container\StaticContainer;
use Piwik\DataAccess\LogAggregator;
use Piwik\Plugins\MediaAnalytics\Archiver;
use Piwik\Plugins\MediaAnalytics\Configuration;
use Piwik\Plugins\MediaAnalytics\Metrics;
use Piwik\RankingQuery;
use Piwik\Segment;

class Aggregator
{
    /**
     * @var LogAggregator
     */
    private $logAggregator;

    /**
     * @var Segment
     */
    private $segment;

    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(LogAggregator $aggregator, Segment $segment, Configuration $configuration)
    {
        $this->logAggregator = $aggregator;
        $this->segment = $segment;
        $this->configuration = $configuration;
    }

    public function queryImpressions(string $where, string $groupByColumn)
    {
        $select = sprintf(
            '%s as label,
             count(log_media.idvisit) as %s,
             count(distinct log_media.idvisitor) as %s,
             sum(case when log_media.watched_time > 1 then 1 else 0 end) as %s',
            $groupByColumn,
            Metrics::METRIC_NB_IMPRESSIONS,
            Metrics::METRIC_NB_IMPRESSIONS_BY_UNIQUE_VISITORS,
            Metrics::METRIC_NB_PLAYS
        );

        $rankingQuery = $this->getNewRankingQuery(Configuration::RANKING_QUERY_TYPE_PRIMARY);
        $rankingQuery->addLabelColumn('label');
        $rankingQuery->addColumn(Metrics::METRIC_NB_IMPRESSIONS, 'sum');
        $rankingQuery->addColumn(Metrics::METRIC_NB_IMPRESSIONS_BY_UNIQUE_VISITORS);

        return $this->query($select, '' . $where, 'label', Metrics::METRIC_NB_PLAYS . ' DESC',
            ['log_media'], $rankingQuery);
    }

    public function queryPlays(string $where, string $groupByColumn)
    {
        $select = sprintf(
            '%s as label,
             count(log_media.idvisit) as %s,
             count(distinct log_media.idvisitor) as %s,
             %s as %s,
             sum(log_media.time_to_initial_play) as %s,
             sum(if(log_media.time_to_initial_play is null, 0, 1)) as %s,
             sum(log_media.watched_time) as %s,
             sum(log_media.media_progress) as %s,
             sum(log_media.media_length) as %s,
             sum(if(log_media.media_length > 0, 1, 0)) as %s,
             sum(log_media.fullscreen) as %s',
            $groupByColumn,
            Metrics::METRIC_NB_PLAYS,
            Metrics::METRIC_NB_PLAYS_BY_UNIQUE_VISITORS,
            $this->getSelectFinishes(),
            Metrics::METRIC_NB_FINISHES,
            Metrics::METRIC_SUM_TIME_TO_PLAY,
            Metrics::METRIC_NB_PLAYS_WITH_TIME_TO_INITIAL_PLAY,
            Metrics::METRIC_SUM_TIME_WATCHED,
            Metrics::METRIC_SUM_TIME_PROGRESS,
            Metrics::METRIC_SUM_MEDIA_LENGTH,
            Metrics::METRIC_NB_PLAYS_WITH_MEDIA_LENGTH,
            Metrics::METRIC_SUM_FULLSCREEN_PLAYS
        );

        $rankingQuery = $this->getNewRankingQuery(Configuration::RANKING_QUERY_TYPE_PRIMARY);
        $rankingQuery->addLabelColumn('label');
        $rankingQuery->addColumn(Metrics::METRIC_NB_PLAYS, 'sum');
        $rankingQuery->addColumn(Metrics::METRIC_NB_PLAYS_BY_UNIQUE_VISITORS);
        $rankingQuery->addColumn(Metrics::METRIC_NB_FINISHES, 'sum');
        $rankingQuery->addColumn(Metrics::METRIC_SUM_TIME_TO_PLAY, 'sum');
        $rankingQuery->addColumn(Metrics::METRIC_NB_PLAYS_WITH_TIME_TO_INITIAL_PLAY, 'sum');
        $rankingQuery->addColumn(Metrics::METRIC_SUM_TIME_WATCHED, 'sum');
        $rankingQuery->addColumn(Metrics::METRIC_SUM_TIME_PROGRESS, 'sum');
        $rankingQuery->addColumn(Metrics::METRIC_SUM_MEDIA_LENGTH, 'sum');
        $rankingQuery->addColumn(Metrics::METRIC_NB_PLAYS_WITH_MEDIA_LENGTH, 'sum');
        $rankingQuery->addColumn(Metrics::METRIC_SUM_FULLSCREEN_PLAYS, 'sum');

        return $this->query($select, $this->getPlaysWhere($where), 'label',
            Metrics::METRIC_NB_PLAYS . ' DESC', ['log_media'], $rankingQuery);
    }

    public function query(string $select, string $where, string $groupBy, string $orderBy, ?array $from = ['log_media'],
                          RankingQuery $rankingQuery = null)
    {
        $condition = $this->logAggregator->getWhereStatement('log_media', 'server_time');
        if (!empty($where)) {
            $condition .= ' ' . $where . ' ';
        }

        $logQueryBuilder = StaticContainer::get('Piwik\DataAccess\LogQueryBuilder');
        $shouldForceInnerGroupBy = $this->segment && $this->segment->getString();

        if ($shouldForceInnerGroupBy) {
            $logQueryBuilder->forceInnerGroupBySubselect( 'log_media.idview');
        }

        try {
            // just fyi: we cannot add any bind as any argument as it would otherwise break segmentation
            $query = $this->logAggregator->generateQuery($select, $from, $condition, $groupBy, $orderBy);

        } catch (\Exception $e) {
            if ($shouldForceInnerGroupBy) {
                // important to unset it, otherwise could be applied to other archiver queries of other plugins etc.
                $logQueryBuilder->forceInnerGroupBySubselect('');
            }

            throw $e;
        }

        if ($shouldForceInnerGroupBy) {
            // important to unset it, otherwise could be applied to other archiver queries of other plugins etc.
            $logQueryBuilder->forceInnerGroupBySubselect('');
        }

        if (isset($rankingQuery)) {
            $query['sql'] = $rankingQuery->generateRankingQuery($query['sql']);
        }

        return $this->logAggregator->getDb()->query($query['sql'], $query['bind']);
    }

    public function querySpentTime(string $groupByColumn, string $where)
    {
        // todo group by idvisit or idvisitor?!?
        $select = $groupByColumn . ' as parentLabel, 
                  log_media.watched_time as label, 
                  count(log_media.watched_time) as ' . Metrics::METRIC_NB_PLAYS;
        $groupBy = $groupByColumn . ', log_media.watched_time';
        $rankingQuery = $this->getNewRankingQuery(Configuration::RANKING_QUERY_TYPE_SECONDARY);
        $rankingQuery->addLabelColumn('parentLabel');
        $rankingQuery->addColumn('label');
        $rankingQuery->addColumn(Metrics::METRIC_NB_PLAYS, 'sum');
        $orderBy = Metrics::METRIC_NB_PLAYS . ' DESC';
        return $this->query($select, $this->getPlaysWhere($where), $groupBy, $orderBy, ['log_media'], $rankingQuery);
    }

    public function queryMediaProgress(string $groupByColumn, string $where)
    {
        $select = $groupByColumn . ' as parentLabel, 
                  round((log_media.media_progress / log_media.media_length) * 100) as label, 
                  count(log_media.media_length) as ' . Metrics::METRIC_NB_PLAYS;

        $groupBy = $groupByColumn . ', label';
        $rankingQuery = $this->getNewRankingQuery(Configuration::RANKING_QUERY_TYPE_SECONDARY);
        $rankingQuery->addLabelColumn('parentLabel');
        $rankingQuery->addColumn('label');
        $rankingQuery->addColumn(Metrics::METRIC_NB_PLAYS, 'sum');
        $orderBy = Metrics::METRIC_NB_PLAYS . ' DESC';
        $where = $this->getPlaysWhere($where . ' AND log_media.media_length > 0');
        return $this->query($select, $where, $groupBy, $orderBy, ['log_media'], $rankingQuery);
    }

    public function queryMediaSegments(string $groupByColumn, string $where)
    {
        $select = sprintf($groupByColumn . ' as parentLabel, 
                  max(log_media.media_length) as %s,
                  count(*) as %s,', Metrics::METRIC_MAX_MEDIA_LENGTH, Metrics::METRIC_SUM_PLAYS);

        $dynamicSelectString = Archiver::getSecondaryDimensionMediaSegmentSelect('sum');
        $select .= $dynamicSelectString;
        $from = array(
            'log_media',
            array('table' => 'log_media_plays',
                'joinOn' => 'log_media_plays.idview = log_media.idview and log_media_plays.idvisit = log_media.idvisit'
            ));
        $rankingQuery = $this->getNewRankingQuery(Configuration::RANKING_QUERY_TYPE_SECONDARY);
        $rankingQuery->addLabelColumn('parentLabel');
        $rankingQuery->addColumn(Metrics::METRIC_MAX_MEDIA_LENGTH, 'max');
        $rankingQuery->addColumn(Metrics::METRIC_SUM_PLAYS, 'sum');
        // Add the columns from the dynamically generated select string.
        foreach (explode(',', $dynamicSelectString) as $selectColumn) {
            if (empty($selectColumn) || strpos($selectColumn, ' as ') === false) {
                continue;
            }

            $parts = explode(' as ', $selectColumn);
            $rankingQuery->addColumn($parts[1], 'sum');
        }
        $orderBy = Metrics::METRIC_SUM_PLAYS . ' DESC';

        return $this->query($select, $this->getPlaysWhere($where), $groupByColumn, $orderBy, $from, $rankingQuery);
    }

    public function queryResolution(string $groupByColumn, string $where)
    {
        $select = sprintf('%s as parentLabel, 
                          log_media.resolution as label, 
                          count(log_media.idvisit) as %s,
                          %s as %s,
                          sum(log_media.watched_time) as %s',
            $groupByColumn,
            Metrics::METRIC_NB_PLAYS,
            $this->getSelectFinishes(),
            Metrics::METRIC_NB_FINISHES,
            Metrics::METRIC_SUM_TIME_WATCHED);
        $groupBy = $groupByColumn . ', log_media.resolution';
        $rankingQuery = $this->getNewRankingQuery(Configuration::RANKING_QUERY_TYPE_SECONDARY);
        $rankingQuery->addLabelColumn('parentLabel');
        $rankingQuery->addColumn('label');
        $rankingQuery->addColumn(Metrics::METRIC_NB_PLAYS, 'sum');
        $rankingQuery->addColumn(Metrics::METRIC_NB_FINISHES, 'sum');
        $rankingQuery->addColumn(Metrics::METRIC_SUM_TIME_WATCHED, 'sum');
        $orderBy = Metrics::METRIC_NB_PLAYS . ' DESC';
        return $this->query($select, $this->getPlaysWhere($where), $groupBy, $orderBy, ['log_media'], $rankingQuery);
    }

    public function queryHours(string $groupByColumn, string $where)
    {
        $select = sprintf('%s as parentLabel, 
                          hour(log_media.server_time) as label, 
                          count(log_media.idvisit) as %s,
                          %s as %s, 
                          sum(log_media.watched_time) as %s',
            $groupByColumn,
            Metrics::METRIC_NB_PLAYS,
            $this->getSelectFinishes(),
            Metrics::METRIC_NB_FINISHES,
            Metrics::METRIC_SUM_TIME_WATCHED);
        $groupBy = $groupByColumn . ', label';
        $rankingQuery = $this->getNewRankingQuery(Configuration::RANKING_QUERY_TYPE_SECONDARY);
        $rankingQuery->addLabelColumn('parentLabel');
        $rankingQuery->addColumn('label');
        $rankingQuery->addColumn(Metrics::METRIC_NB_PLAYS, 'sum');
        $rankingQuery->addColumn(Metrics::METRIC_NB_FINISHES, 'sum');
        $rankingQuery->addColumn(Metrics::METRIC_SUM_TIME_WATCHED, 'sum');
        $orderBy = Metrics::METRIC_NB_PLAYS . ' DESC';
        return $this->query($select, $this->getPlaysWhere($where), $groupBy, $orderBy, ['log_media'], $rankingQuery);
    }

    /**
     * Gets a new instance of RankingQuery with the limit already set to the system archiving limit
     *
     * @return RankingQuery
     */
    private function getNewRankingQuery(string $type): RankingQuery
    {
        $rankingQueryLimit = $this->configuration->getRankingQueryLimit($type);
        return new RankingQuery($rankingQueryLimit);
    }

    // for finishes we have a slight tolerance if someone watches close to 2 seconds to the end we count it as finished
    // as there could be some race conditions or for some reasons the player might not report the correct progress etc
    public function getSelectFinishes(): string
    {
        return 'sum(if(log_media.media_length > 2 AND log_media.media_progress >= (log_media.media_length - 2), 1, 0))';
    }

    private function getPlaysWhere(string $where = ''): string
    {
        return ' AND log_media.watched_time > 1 ' . $where;
    }
}
