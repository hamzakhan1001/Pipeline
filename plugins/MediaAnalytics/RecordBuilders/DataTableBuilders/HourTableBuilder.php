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

use Piwik\ArchiveProcessor\Parameters;
use Piwik\Date;
use Piwik\Plugins\MediaAnalytics\Archiver;
use Piwik\Plugins\MediaAnalytics\RecordBuilders\DataTableBuilder;
use Piwik\RankingQuery;

class HourTableBuilder extends DataTableBuilder
{
    /**
     * @var string
     */
    private $startDateString;

    /**
     * @var string
     */
    private $timezone;

    /**
     * @var int[]
     */
    private $labelCache = [];

    public function __construct(Parameters $params)
    {
        parent::__construct();

        // Get these values to help with recording hours in the correct timezone
        $this->startDateString = Date::factory($params->getDateStart()->getDateStartUTC())->toString();
        $this->timezone = $params->getSite()->getTimezone();
    }

    public function convertTimeToLocalTimezone($label)
    {
        if (!isset($this->labelCache[$label])) {
            $datetime = $this->startDateString . ' ' . $label . ':00:00';
            $this->labelCache[$label] = (int) Date::factory($datetime, $this->timezone)->toString('H');
        }

        return $this->labelCache[$label];
    }

    protected function getLabelToUse(string $labelInDb): string
    {
        $label = $labelInDb;
        if ($this->isEmptyLabel($label)) {
            $label = Archiver::LABEL_NOT_DEFINED;
        } elseif ($label !== RankingQuery::LABEL_SUMMARY_ROW) {
            $label = $this->convertTimeToLocalTimezone($labelInDb);
        }
        return $label;
    }
}
