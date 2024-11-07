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
 * @link    https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */

namespace Piwik\Plugins\AdvertisingConversionExport\Export\Adapter;

use Exception;
use Piwik\Common;
use Piwik\Date;
use Piwik\Db;
use Piwik\Piwik;
use Piwik\Plugins\AdvertisingConversionExport\Export\Configuration;
use Piwik\Plugins\AdvertisingConversionExport\SystemSettings;
use Piwik\Plugins\Live\Exception\MaxExecutionTimeExceededException;
use Piwik\ProxyHttp;
use Piwik\Segment;
use Piwik\Updater\Migration\Db as DbMigration;

abstract class AdapterAbstract
{
    public const ID = '';

    /** @var Configuration */
    protected $configuration;

    /** @var SystemSettings */
    protected $systemSetting;

    /** @var bool  */
    protected $iterateAndReturnResultSet = false;

    public static function getId(): string
    {
        return static::ID;
    }

    public function __construct(?Configuration $configuration = null)
    {
        if ($configuration) {
            $this->setConfiguration($configuration);
        }

        $this->systemSetting = new SystemSettings();
    }

    abstract public static function getName(): string;

    abstract public static function getDescription(): string;

    /**
     * @return AdapterAbstract
     */
    abstract protected function getClickIdProvider();

    abstract public function generate(): string;

    public function sendHttpHeaders()
    {
        Common::sendHeader("Content-Disposition: attachment; filename=conversion-export.csv");
        Common::sendHeader('Content-Type: application/vnd.ms-excel', true);
        ProxyHttp::overrideCacheControlHeaders('no-cache');
    }

    public function setConfiguration(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    protected function getRequiredDimensions(): array
    {
        return [
            'log_clickid.adclickid',
            'log_conversion.idvisit',
            'log_conversion.idvisitor',
            'log_conversion.server_time',
            'log_conversion.idgoal',
            'log_conversion.revenue',
        ];
    }

    protected function fetchDirectlyAttributedConversions()
    {
        return $this->fetchConversions(
            'log_clickid'
        );
    }

    protected function fetchAllAttributedConversions()
    {
        if ($this->configuration->clickIdAttribution === 'all') {
            return $this->fetchConversions(
                [
                    'table'  => 'log_clickid',
                    'joinOn' => 'log_conversion.idvisitor = log_clickid.idvisitor 
                                AND log_conversion.server_time >= log_clickid.server_time
                                AND log_clickid.server_time > DATE_SUB(log_conversion.server_time, INTERVAL ' . (int)$this->configuration->daysToLookBack . ' DAY)',
                ]
            );
        }

        $sort = $this->configuration->clickIdAttribution === 'first' ? 'ASC' : 'DESC';

        return $this->fetchConversions(
            [
                'table'  => 'log_clickid',
                'joinOn' => 'log_conversion.idvisitor = log_clickid.idvisitor 
                                AND log_conversion.server_time >= log_clickid.server_time
                                AND log_clickid.adclickid = (
                                    SELECT adclickid FROM ' . Common::prefixTable('log_clickid') . ' AS cid 
                                    WHERE cid.idvisitor = log_conversion.idvisitor 
                                      AND server_time > DATE_SUB(log_conversion.server_time, INTERVAL ' . (int)$this->configuration->daysToLookBack . ' DAY)
                                      AND adprovider = "' . $this->getClickIdProvider()->getId() . '"
                                    ORDER BY server_time ' . $sort . ' 
                                    LIMIT 1
                                )',
            ]
        );
    }

    protected function fetchConversions($clickIdTable)
    {
        $daysToExport = $this->configuration->daysToExport;
        $segment      = $this->configuration->segment;
        $goals        = $this->configuration->goals;
        $idSite       = $this->configuration->getSite()->getId();
        $goalIds      = [];

        foreach ($goals as $goal) {
            $goalIds[] = (int) $goal->idGoal;
        }

        $toDate   = Date::factoryInTimezone('today', $this->configuration->getSite()->getTimezone());
        $fromDate = $toDate->subDay($daysToExport);

        $segment = new Segment($segment, [$idSite], $fromDate, $toDate);

        $from        = ['log_conversion', $clickIdTable];
        $select      = ' /*+ EXPORT_ID(' . $this->configuration->exportID . ') */ DISTINCT ' . implode(', ', $this->getRequiredDimensions());
        $where       = 'log_conversion.idsite = ? AND log_clickid.adclickid != ? AND log_conversion.server_time > ? AND log_conversion.server_time < ? AND log_conversion.idgoal IN (' . Common::getSqlStringFieldsArray($goalIds)
            . ') AND log_clickid.adclickid IS NOT NULL AND log_clickid.adprovider = ?';
        $whereBind   = [
            $idSite,
            'anonymized',
            $fromDate->toString('Y-m-d H:i:s'),
            $toDate->toString('Y-m-d H:i:s'),
        ];
        $whereBind   = array_merge($whereBind, $goalIds);
        $whereBind[] = $this->getClickIdProvider()->getId();

        $limit = $this->configuration->getQueryLimit();

        $query = $segment->getSelectQuery($select, $from, $where, $whereBind, 'log_conversion.server_time, log_clickid.adclickid', false, $limit);

        $maxExecutionTimeHint = $this->configuration->getMaxExecutionTimeMySQLHint();
        if ($maxExecutionTimeHint) {
            $query['sql'] = trim($query['sql']);
            $pos = stripos($query['sql'], 'SELECT');
            if ($pos !== false) {
                $query['sql'] = substr_replace($query['sql'], 'SELECT ' . $maxExecutionTimeHint, $pos, strlen('SELECT'));
            }
        }

        $db = Db::getReader();
        try {
            $queryResult = $db->query($query['sql'], $query['bind']);
        } catch (Exception $e) {
            $this->handleMaxExecutionTimeError($db, $e, $segment, $limit, $query);
            throw $e;
        }

        // We need to do this to resolve PG-3713, as the issue was not reproducible locally or on Cloud, but with the help of patches we were able to resolve this issue and hence we added this code.
        if ($this->iterateAndReturnResultSet) {
            $rows = [];
            while ($conversion = $queryResult->fetch()) {
                $rows[] = $conversion;
            }
            $queryResult->closeCursor();

            return $rows;
        }

        return $queryResult;
    }

    protected function convertTimezone($matomoTimezone)
    {
        if (substr($matomoTimezone, 0, 4) === 'UTC+') {
            $offset = substr($matomoTimezone, 4);
            return sprintf('+%04d', $offset * 100);
        }
        if (substr($matomoTimezone, 0, 4) === 'UTC-') {
            $offset = substr($matomoTimezone, 4);
            return sprintf('-%04d', $offset * 100);
        }

        return $matomoTimezone;
    }

    private function handleMaxExecutionTimeError($readerDb, $e, $segment, $limit, $parameters)
    {
        // we also need to check for the 'maximum statement execution time exceeded' text as the query might be
        // aborted at different stages and we can't really know all the possible codes at which it may be aborted etc
        $isMaxExecutionTimeError = $readerDb->isErrNo($e, DbMigration::ERROR_CODE_MAX_EXECUTION_TIME_EXCEEDED_QUERY_INTERRUPTED)
            || $readerDb->isErrNo($e, DbMigration::ERROR_CODE_MAX_EXECUTION_TIME_EXCEEDED_SORT_ABORTED)
            || strpos($e->getMessage(), 'maximum statement execution time exceeded') !== false;

        if (false === $isMaxExecutionTimeError) {
            return;
        }

        $message = Piwik::translate('Live_QueryMaxExecutionTimeExceededReasonDateRange');

        if (!empty($segment)) {
            $message .= ' ' . Piwik::translate('Live_QueryMaxExecutionTimeExceededReasonSegment');
        }

        $message = Piwik::translate('Live_QueryMaxExecutionTimeExceeded') . ' ' . $message;

        $params = array_merge($parameters, [
            'segment' => $segment, 'limit' => $limit
        ]);

        /**
         * @ignore
         * @internal
         */
        Piwik::postEvent('AdvertisingConversionExport.queryMaxExecutionTimeExceeded', [$params]);
        throw new MaxExecutionTimeExceededException($message);
    }
}
