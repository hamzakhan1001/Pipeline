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

namespace Piwik\Plugins\AdvertisingConversionExport;

use Piwik\Common;
use Piwik\Config;

class Configuration
{
    public const KEY_SALT = 'salt';

    public function install()
    {
        $config = $this->getConfig();

        $reports = $config->AdvertisingConversionExport;
        if (empty($reports)) {
            $reports = array();
        }

        if (empty($reports[self::KEY_SALT])) {
            $reports[self::KEY_SALT] = Common::generateUniqId();
        }

        $config->AdvertisingConversionExport = $reports;

        $config->forceSave();
    }

    public function getSalt()
    {
        $config = $this->getConfig();

        return (!empty($config->AdvertisingConversionExport[self::KEY_SALT]) ? $config->AdvertisingConversionExport[self::KEY_SALT] : '');
    }

    public function setSalt($salt)
    {
        $config = $this->getConfig();
        $reports = $config->AdvertisingConversionExport;
        $reports[self::KEY_SALT] = $salt;
        $config->AdvertisingConversionExport = $reports;

        $config->forceSave();
    }

    private function getConfig()
    {
        return Config::getInstance();
    }
}
