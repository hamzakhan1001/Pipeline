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

namespace Piwik\Plugins\CrashAnalytics\Activity;

use Piwik\Container\StaticContainer;
use Piwik\Plugins\ActivityLog\Activity\Activity;
use Piwik\Plugins\CrashAnalytics\Dao\LogCrash;
use Piwik\Site;

class BaseActivity extends Activity
{
    protected function getCrashNameFromActivityData($activityData)
    {
        if (!empty($activityData['crash']['name'])) {
            return $activityData['crash']['name'];
        }

        if (!empty($activityData['crash']['id'])) {
            return $activityData['crash']['id'];
        }

        return '';
    }

    protected function getCrashResourceFromActivityData(array $activityData)
    {
        if (!empty($activityData['crash']['resource_uri'])) {
            return ' @ ' . $activityData['crash']['resource_uri'];
        }

        return '';
    }

    protected function getSiteNameFromActivityData($activityData)
    {
        if (!empty($activityData['site']['site_name'])) {
            return $activityData['site']['site_name'];
        }

        if (!empty($activityData['site']['site_id'])) {
            return $activityData['site']['site_id'];
        }

        return '';
    }

    protected function formatActivityData($idSite, $idLogCrash, $ignore)
    {
        if (!is_numeric($idSite) || !is_numeric($idLogCrash)) {
            return;
        }

        return array(
            'site' => $this->getSiteData($idSite),
            'version' => 'v1',
            'crash' => $this->getCrashData($idLogCrash, $idSite),
            'ignore' => (bool)$ignore,
        );
    }

    private function getSiteData($idSite)
    {
        return array(
            'site_id'   => $idSite,
            'site_name' => Site::getNameFor($idSite)
        );
    }

    private function getCrashData($idLogCrash, $idSite)
    {
        $crash = $this->getDao()->getCrash($idSite, $idLogCrash);

        return array(
            'id' => $idLogCrash,
            'name' => $crash['message'],
            'resource_uri' => $crash['resource_uri'] ?: '',
        );
    }

    private function getDao()
    {
        // we do not get it via DI as it would slow down creation of all activities on all requests. Instead only
        // create instance when needed
        return StaticContainer::get(LogCrash::class);
    }
}