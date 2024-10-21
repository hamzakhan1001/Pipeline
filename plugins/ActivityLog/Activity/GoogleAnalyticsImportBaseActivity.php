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

namespace Piwik\Plugins\ActivityLog\Activity;

class GoogleAnalyticsImportBaseActivity extends Activity
{
    // This is just to prevent the registration from throwing a duplicate activity event error
    protected $eventName = 'GoogleAnalyticsImportBaseActivity';

    public function extractParams($eventData)
    {
        if (empty($eventData[0]) || !is_array($eventData[0]) || empty($eventData[0]['ga'])) {
            return false;
        }

        $import = $eventData[0];

        return [
            'items' => [
                [
                    'type' => 'plugin',
                    'data' => [
                        'name' => 'GoogleAnalyticsImporter',
                    ]
                ],
                [
                    'type' => 'googleanalyticsimport',
                    'data' => [
                        'gaImportType' => $import['ga']['import_type'],
                        'gaProperty' => $import['ga']['property'],
                        'gaAccount' => $import['ga']['account'],
                        'gaView' => $import['ga']['view'],
                        'idSite' => $import['idSite'],
                        'status' => $import['status'],
                        'importRangeStart' => $import['import_range_start'],
                        'importRangeEnd' => $import['import_range_end'],
                        'lastDateImported' => $import['last_date_imported'],
                        'lastDayArchived' => $import['last_day_archived'],
                        'mainImportProgress' => $import['main_import_progress'],
                        'importStartTime' => $import['import_start_time'],
                        'importEndTime' => $import['import_end_time'],
                        'lastJobStartTime' => $import['last_job_start_time'],
                        'reimportRanges' => is_array($import['reimport_ranges']) ? array_map(function ($range) {
                            return is_array($range) ? implode(',', $range) : '';
                        }, $import['reimport_ranges']) : [],
                        'extraCustomDimensions' => $import['extra_custom_dimensions'],
                        'streamIds' => $import['streamIds'],
                    ]
                ],
            ]
        ];
    }
}
