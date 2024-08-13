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

namespace Piwik\Plugins\AbTesting;

class Archiver extends \Piwik\Plugin\Archiver
{
    const APPENDIX_TTEST_STDDEV_SAMP = '_stddev_samp';
    const APPENDIX_TTEST_SUM = '_sum';
    const APPENDIX_TTEST_COUNT = '_count';

    const ABTESTING_ARCHIVE_RECORD = "AbTesting_experiment_";

    const LABEL_NOT_DEFINED = 'AbTesting_ValueNotSet';

    /**
     * Get the record name for an experiment archive.
     * @param int $idExperiment
     * @return string
     */
    public static function getExperimentRecordName($idExperiment)
    {
        return static::ABTESTING_ARCHIVE_RECORD . (int) $idExperiment;
    }

    /**
     * Get the record name for an experiment archive.
     * @param int $idExperiment
     * @param int $metricName
     * @return string
     */
    public static function getExperimentSampleRecordName($idExperiment, $metricName)
    {
        return static::ABTESTING_ARCHIVE_RECORD . (int) $idExperiment . '_sample_' . $metricName;
    }
}
