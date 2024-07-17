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
use Piwik\Plugins\FormAnalytics\Archiver;
use Piwik\Plugins\FormAnalytics\Metrics;

class FormPageUrls extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->columnToSortByBeforeTruncation = Metrics::SUM_FORM_VIEWS;
    }

    public function getRecordMetadata(ArchiveProcessor $archiveProcessor): array
    {
        return $this->getRecordMetadataForFormBlobRecords($archiveProcessor, Archiver::FORM_PAGE_URLS_RECORD);
    }

    protected function aggregate(ArchiveProcessor $archiveProcessor): array
    {
        return $this->aggregateFormLogs($archiveProcessor, Archiver::FORM_PAGE_URLS_RECORD, 'aggregatePageUrls');
    }
}
