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

use Piwik\Columns\DimensionSegmentFactory;
use Piwik\Piwik;
use Piwik\Plugins\MediaAnalytics\Dao\LogTable;
use Piwik\Plugins\MediaAnalytics\Segment;
use Piwik\Segment\SegmentsList;

class TimeToPlay extends MediaDimension
{
    protected $nameSingular = 'MediaAnalytics_SegmentNameTimeToInitialPlay';
    protected $columnName = 'time_to_initial_play';
    protected $type = self::TYPE_DURATION_S;

    public function configureSegments(SegmentsList $segmentsList, DimensionSegmentFactory $dimensionSegmentFactory)
    {
        $segment = new Segment();
        $segment->setSegment(Segment::NAME_TIME_TO_PLAY);
        $segment->setType(Segment::TYPE_METRIC);
        $segment->setName(Piwik::translate('MediaAnalytics_SegmentNameTimeToInitialPlay'));
        $segment->setSqlSegment('log_media.time_to_initial_play');
        $segment->setAcceptedValues(Piwik::translate('MediaAnalytics_SegmentDescriptionTimeToInitialPlay'));
        $segment->setSuggestedValuesCallback(function ($idSite, $maxValuesToReturn) {
            $logTable = LogTable::getInstance();
            return $logTable->getMostUsedValuesForDimension('time_to_initial_play', $idSite, $maxValuesToReturn);
        });
        $segmentsList->addSegment($dimensionSegmentFactory->createSegment($segment));
    }

    public function getName()
    {
        return Piwik::translate($this->nameSingular);
    }
}