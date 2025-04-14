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

namespace Piwik\Plugins\Funnels;

class Archiver extends \Piwik\Plugin\Archiver
{
    public const FUNNELS_ENTRIES_RECORD = 'Funnels_entries_';
    public const FUNNELS_EXITS_RECORD = 'Funnels_exits_';
    public const FUNNELS_FLOW_RECORD = 'Funnels_flow_';

    public const FUNNELS_NUM_ENTRIES_RECORD = 'Funnels_funnel_sum_entries_';
    public const FUNNELS_NUM_EXITS_RECORD = 'Funnels_funnel_sum_exits_';
    public const FUNNELS_NUM_CONVERSIONS_RECORD = 'Funnels_funnel_nb_conversions_';

    public const LABEL_NOT_DEFINED = 'Funnels_ValueNotSet';
    public const LABEL_VISIT_ENTRY = 'Funnels_VisitEntry';
    public const LABEL_VISIT_EXIT = 'Funnels_VisitExit';
    public const LABEL_DIRECT_ENTRY = 'Funnels_DirectEntry';

    public static function completeRecordName($recordName, $idFunnel, $revision = null)
    {
        return $recordName . (int) $idFunnel . (!empty($revision) ? '_' . (int) $revision : '');
    }

    public static function getNumericRecordNames($idFunnel, $revision = null)
    {
        return array(
            self::completeRecordName(self::FUNNELS_NUM_ENTRIES_RECORD, $idFunnel, $revision),
            self::completeRecordName(self::FUNNELS_NUM_EXITS_RECORD, $idFunnel, $revision),
            self::completeRecordName(self::FUNNELS_NUM_CONVERSIONS_RECORD, $idFunnel, $revision),
        );
    }

    /**
     * Get all the archive record names used for Funnels. This is like getNumericRecordNames, but includes blobs too.
     *
     * @param int $idFunnel
     * @return array Of string archive record names
     */
    public static function getAllRecordNames(int $idFunnel, $revision = null): array
    {
        return [
            self::completeRecordName(self::FUNNELS_ENTRIES_RECORD, $idFunnel, $revision),
            self::completeRecordName(self::FUNNELS_EXITS_RECORD, $idFunnel, $revision),
            self::completeRecordName(self::FUNNELS_FLOW_RECORD, $idFunnel, $revision),
            self::completeRecordName(self::FUNNELS_NUM_ENTRIES_RECORD, $idFunnel, $revision),
            self::completeRecordName(self::FUNNELS_NUM_EXITS_RECORD, $idFunnel, $revision),
            self::completeRecordName(self::FUNNELS_NUM_CONVERSIONS_RECORD, $idFunnel, $revision),
        ];
    }

    public static function getNumericColumnNameFromRecordName($recordName, $idFunnel, $revision = null)
    {
        // eg Funnels_nb_conversions_6 => nb_conversions
        $revisionString = !empty($revision) ? '_' . (int) $revision : '';
        return str_replace(array('Funnels_', '_' . $idFunnel . $revisionString), '', $recordName);
    }
}
