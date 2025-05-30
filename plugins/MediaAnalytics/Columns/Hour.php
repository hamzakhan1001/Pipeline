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

namespace Piwik\Plugins\MediaAnalytics\Columns;

use Piwik\Metrics\Formatter;
use Piwik\Piwik;
use Piwik\Plugins\CoreHome\Columns\VisitLastActionTime;

class Hour extends MediaDimension
{
    protected $nameSingular = 'MediaAnalytics_Hour';
    protected $sqlSegment = 'HOUR(log_media.server_time)';
    protected $acceptValues = '0, 1, 2, 3, ..., 20, 21, 22, 23';
    protected $columnName = 'server_time';
    protected $type = self::TYPE_DATETIME;

    /**
     * The name of the dimension which will be visible for instance in the UI of a related report and in the mobile app.
     * @return string
     */
    public function getName()
    {
        return Piwik::translate($this->nameSingular);
    }

    public function formatValue($value, $idSite, Formatter $formatter)
    {
        $hourInTz = VisitLastActionTime::convertHourToHourInSiteTimezone($value, $idSite);

        return \Piwik\Plugins\VisitTime\getTimeLabel($hourInTz);
    }
}
