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

class PlayerName extends MediaDimension
{
    protected $nameSingular = 'MediaAnalytics_PlayerName';
    protected $namePlural = 'MediaAnalytics_PlayerNames';
    protected $columnName = 'player_name';
    protected $type = self::TYPE_TEXT;

    public function configureSegments(SegmentsList $segmentsList, DimensionSegmentFactory $dimensionSegmentFactory)
    {
        $segment = new Segment();
        $segment->setSegment(Segment::NAME_MEDIA_PLAYER);
        $segment->setType(Segment::TYPE_DIMENSION);
        $segment->setName(Piwik::translate('MediaAnalytics_SegmentNameMediaPlayer'));
        $segment->setSqlSegment('log_media.player_name');
        $segment->setAcceptedValues(Piwik::translate('MediaAnalytics_SegmentDescriptionMediaPlayer'));
        $segment->setSuggestedValuesCallback(function ($idSite, $maxValuesToReturn) {
            $logTable = LogTable::getInstance();
            return $logTable->getMostUsedValuesForDimension('player_name', $idSite, $maxValuesToReturn);
        });
        $segmentsList->addSegment($dimensionSegmentFactory->createSegment($segment));
    }

    /**
     * The name of the dimension which will be visible for instance in the UI of a related report and in the mobile app.
     * @return string
     */
    public function getName()
    {
        return Piwik::translate($this->nameSingular);
    }
}
