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

use Matomo\Cache\Transient;
use Piwik\ArchiveProcessor;
use Piwik\ArchiveProcessor\Record;
use Piwik\ArchiveProcessor\RecordBuilder;
use Piwik\CacheId;
use Piwik\Container\StaticContainer;
use Piwik\DataTable;
use Piwik\Plugins\FormAnalytics\Archiver;
use Piwik\Plugins\FormAnalytics\Archiver\LogAggregator;
use Piwik\Plugins\FormAnalytics\Dao\SiteForm;
use Piwik\Plugins\FormAnalytics\Model\FormsModel;

abstract class Base extends RecordBuilder
{
    /**
     * @var SiteForm
     */
    protected $formsDao;

    /**
     * @var Transient
     */
    private $cache;

    public function __construct()
    {
        parent::__construct();

        $this->formsDao = StaticContainer::get(SiteForm::class);
        $this->cache = StaticContainer::get(Transient::class);

        $this->maxRowsInSubtable = Archiver::MAX_ROWS_LIMIT;
        $this->maxRowsInTable = Archiver::MAX_ROWS_LIMIT;
    }

    protected function aggregateFormLogs(ArchiveProcessor $archiveProcessor, string $recordName, string $aggregatorMethod): array
    {
        $idSite = $archiveProcessor->getParams()->getSite()->getId();
        if (empty($idSite)) {
            return [];
        }

        $dataTables = $this->makeDataTablesForForms($idSite);

        $aggregator = new LogAggregator($archiveProcessor->getLogAggregator());
        $cursor = $aggregator->$aggregatorMethod();

        $this->addRowsToDataTables($dataTables, $cursor);

        $dataTablesByRecordName = $this->getDataTablesByRecordName($dataTables, $recordName);
        return $dataTablesByRecordName;
    }

    protected function getDataTablesByRecordName(array $dataTablesByIdSiteForm, string $recordName): array
    {
        $dataTablesByRecordName = [];
        foreach ($dataTablesByIdSiteForm as $idSiteForm => $record) {
            $wholeRecordName = Archiver::completeRecordName($recordName, $idSiteForm);
            $dataTablesByRecordName[$wholeRecordName] = $record;
        }
        return $dataTablesByRecordName;
    }

    protected function getActivatedFormIds($idSite): array
    {
        if (!isset($idSite) || false === $idSite) {
            return [];
        }

        $cacheKey = CacheId::siteAware('FormAnalytics.RecordBuilder.runningFormIds', [$idSite]);
        $formIds = $this->cache->fetch($cacheKey);
        if ($formIds === false) {
            $formIds = $this->formsDao->getFormIdsWithStatus($idSite, FormsModel::STATUS_RUNNING);
            $formIds = array_map('intval', $formIds);
            $this->cache->save($cacheKey, $formIds);
        }
        return $formIds;
    }

    protected function makeDataTablesForForms($idSite): array
    {
        $formIds = $this->getActivatedFormIds($idSite);

        $records = [];
        foreach ($formIds as $idSiteForm) {
            $records[$idSiteForm] = new DataTable();
        }
        return $records;
    }

    /**
     * @param DataTable[] $recordsByFormId
     * @return void
     */
    protected function addRowsToDataTables(array $recordsByFormId, $cursor): void
    {
        while ($row = $cursor->fetch()) {
            $idSiteForm = $row['idsiteform'];
            if (isset($recordsByFormId[$idSiteForm])) {
                $label = $row['label'];

                unset($row['idsiteform']);
                unset($row['label']);

                $recordRow = $this->getRecordRowFromCursorRow($row);
                $recordsByFormId[$idSiteForm]->sumRowWithLabel($label, $recordRow);
            }
        }
        $cursor->closeCursor();
    }

    protected function getRecordRowFromCursorRow(array $cursorRow): array
    {
        return $cursorRow;
    }

    protected function getRecordMetadataForFormBlobRecords(ArchiveProcessor $archiveProcessor, string $recordName): array
    {
        $idSite = $archiveProcessor->getParams()->getSite()->getId();
        if (empty($idSite)) {
            return [];
        }

        $idSiteForms = $this->getActivatedFormIds($idSite);

        $records = [];
        foreach ($idSiteForms as $idSiteForm) {
            $records[] = Record::make(Record::TYPE_BLOB, Archiver::completeRecordName($recordName, $idSiteForm));
        }
        return $records;
    }
}
