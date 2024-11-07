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

use Piwik\Config;

class Configuration
{
    public const KEY_ESTIMATED_UNIQUE_VISITOR_ENABLED = 'enableEstimatedUniqueVisitors';
    public const DEFAULT_ESTIMATED_UNIQUE_VISITOR_ENABLED = 0;

    public const KEY_HYPERLOGLOG_ERROR_RATE = 'hyperLogErrorRate';
    public const DEFAULT_HYPERLOGLOG_ERROR_RATE = 0.01;

    public const KEY_MAXIMUM_HYPERLOLOG_BUCKET_ARCHIVING_ROWS = 'datatable_archiving_maximum_hyperloglog_rows';
    public const DEFAULT_MAXIMUM_HYPERLOLOG_BUCKET_ARCHIVING_ROWS = 64000;

    public const KEY_ARCHIVE_UNIQUE_VISITOR_ENABLED = 'archive_unique_visitors_enabled';

    public const DEFAULT_ARCHIVE_UNIQUE_VISITOR_ENABLED = 1;

    public const KEY_SHOW_UNIQUE_VISITOR = 'show_unique_visitors';

    public const DEFAULT_SHOW_UNIQUE_VISITOR = 1;

    public const KEY_SHOW_ESTIMATED_UNIQUE_VISITOR = 'show_estimated_unique_visitors';

    public const DEFAULT_SHOW_ESTIMATED_UNIQUE_VISITOR = 0;

    public function install()
    {
        $config = $this->getConfig();
        if (!isset($config->AbTesting[self::KEY_ESTIMATED_UNIQUE_VISITOR_ENABLED])) {
            $config->AbTesting[self::KEY_ESTIMATED_UNIQUE_VISITOR_ENABLED] = self::DEFAULT_ESTIMATED_UNIQUE_VISITOR_ENABLED;
        }
        if (!isset($config->AbTesting[self::KEY_HYPERLOGLOG_ERROR_RATE])) {
            $config->AbTesting[self::KEY_HYPERLOGLOG_ERROR_RATE] = self::DEFAULT_HYPERLOGLOG_ERROR_RATE;
        }
        if (!isset($config->AbTesting[self::KEY_MAXIMUM_HYPERLOLOG_BUCKET_ARCHIVING_ROWS])) {
            $config->AbTesting[self::KEY_MAXIMUM_HYPERLOLOG_BUCKET_ARCHIVING_ROWS] = self::DEFAULT_MAXIMUM_HYPERLOLOG_BUCKET_ARCHIVING_ROWS;
        }

        if (!isset($config->AbTesting[self::KEY_ARCHIVE_UNIQUE_VISITOR_ENABLED])) {
            $config->AbTesting[self::KEY_ARCHIVE_UNIQUE_VISITOR_ENABLED] = self::DEFAULT_ARCHIVE_UNIQUE_VISITOR_ENABLED;
        }

        if (!isset($config->AbTesting[self::KEY_SHOW_UNIQUE_VISITOR])) {
            $config->AbTesting[self::KEY_SHOW_UNIQUE_VISITOR] = self::DEFAULT_SHOW_UNIQUE_VISITOR;
        }

        if (!isset($config->AbTesting[self::KEY_SHOW_ESTIMATED_UNIQUE_VISITOR])) {
            $config->AbTesting[self::KEY_SHOW_ESTIMATED_UNIQUE_VISITOR] = self::DEFAULT_SHOW_ESTIMATED_UNIQUE_VISITOR;
        }

        $config->forceSave();
    }

    public function uninstall()
    {
        $config = $this->getConfig();
        $config->AbTesting = array();
        $config->forceSave();
    }

    public function isUniqueVisitorArchivingEnabled()
    {
        $config = $this->getConfig();

        return (bool) ($config->AbTesting[self::KEY_ARCHIVE_UNIQUE_VISITOR_ENABLED] ?? self::DEFAULT_ARCHIVE_UNIQUE_VISITOR_ENABLED);
    }

    public function shouldShowUniqueVisitors()
    {
        $config = $this->getConfig();

        return $this->isUniqueVisitorArchivingEnabled() && ($config->AbTesting[self::KEY_SHOW_UNIQUE_VISITOR] ?? self::DEFAULT_SHOW_UNIQUE_VISITOR);
    }

    public function isEstimatedUniqueVisitorArchivingEnabled()
    {
        $config = $this->getConfig();

        return (bool) ($config->AbTesting[self::KEY_ESTIMATED_UNIQUE_VISITOR_ENABLED] ?? self::DEFAULT_ESTIMATED_UNIQUE_VISITOR_ENABLED);
    }

    public function shouldShowEstimatedUniqueVisitors()
    {
        $config = $this->getConfig();

        return $this->isEstimatedUniqueVisitorArchivingEnabled() && ($config->AbTesting[self::KEY_SHOW_ESTIMATED_UNIQUE_VISITOR] ?? self::DEFAULT_SHOW_ESTIMATED_UNIQUE_VISITOR);
    }

    public function getHyperLogLogErrorRate()
    {
        $config = $this->getConfig();

        return $config->AbTesting[self::KEY_HYPERLOGLOG_ERROR_RATE] ?? self::DEFAULT_HYPERLOGLOG_ERROR_RATE;
    }

    public function getMaximumHyperLogBucketArchivingRows()
    {
        $config = $this->getConfig();

        return $config->AbTesting[self::KEY_MAXIMUM_HYPERLOLOG_BUCKET_ARCHIVING_ROWS] ?? self::DEFAULT_MAXIMUM_HYPERLOLOG_BUCKET_ARCHIVING_ROWS;
    }

    private function getConfig()
    {
        return Config::getInstance();
    }
}
