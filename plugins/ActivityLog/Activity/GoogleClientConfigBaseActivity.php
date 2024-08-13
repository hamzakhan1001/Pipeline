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

class GoogleClientConfigBaseActivity extends Activity
{
    // This is just to prevent the registration from throwing a duplicate activity event error
    protected $eventName = 'GoogleClientConfigBaseActivity';

    /**
     * Take the array of event data and pares out the array for Google client config data.
     *
     * @param array $eventData The array of data from an event.
     * @return array|false Returns the array of config data. False is returned in the event data didn't contain a config
     */
    protected function getGoogleClientConfigArray(array $eventData)
    {
        // If there's no event data, or it's already an array and there's no web key
        if (empty($eventData[0]) || (is_array($eventData[0]) && empty($eventData[0]['web']))) {
            return false;
        }

        $config = $eventData[0];

        if (is_array($config)) {
            return $config['web'];
        }

        if (!is_string($config) || stripos($config, 'web') === false || stripos($config, 'project_id') === false) {
            return false;
        }

        $decodedJson = json_decode($config, true);
        if (!is_array($decodedJson) || empty($decodedJson)) {
            return false;
        }

        return $decodedJson['web'];
    }

    public function extractParams($eventData)
    {
        $web = $this->getGoogleClientConfigArray($eventData);
        if ($web === false) {
            return false;
        }

        return [
            'items' => [
                [
                    'type' => 'plugin',
                    'data' => [
                        'name' => 'GoogleAnalyticsImporter',
                    ]
                ],
                [
                    'type' => 'googleclientconfig',
                    'data' => [
                        'clientId' => $web['client_id'],
                        'projectId' => $web['project_id'],
                        'redirectUris' => $web['redirect_uris'],
                        'javascriptOrigins' => $web['javascript_origins'],
                    ]
                ],
            ]
        ];
    }
}