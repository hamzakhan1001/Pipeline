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
 * @link    https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */

namespace Piwik\Plugins\SearchEngineKeywordsPerformance\Model;

use Piwik\Common;
use Piwik\Db;
use Piwik\DbHelper;

class Bing
{
    private static $rawTableName = 'bing_stats';
    private $table;
    public function __construct()
    {
        $this->table = Common::prefixTable(self::$rawTableName);
    }
    /**
     * Installs required database table
     */
    public static function install()
    {
        $table = "`url` VARCHAR( 170 ) NOT NULL ,\n\t\t\t\t\t  `date` DATE NOT NULL ,\n\t\t\t\t\t  `data` MEDIUMBLOB,\n\t\t\t\t\t  `type` VARCHAR( 15 ) NOT NULL,\n\t\t\t\t\t  PRIMARY KEY ( `url` , `date` , `type` )";
        // Key length = 170 + 3 byte (date) + 15 = 188
        DbHelper::createTable(self::$rawTableName, $table);
    }
    /**
     * Saves keywords for given url and day
     *
     * @param string $url      url, eg. http://matomo.org
     * @param string $date     a day string, eg. 2016-12-24
     * @param string $keywords serialized keyword data
     * @return bool
     */
    public function archiveKeywordData($url, $date, $keywords)
    {
        return $this->archiveData($url, $date, $keywords, 'keywords');
    }
    /**
     * Returns the saved keyword data for given parameters (or null if not available)
     *
     * @param string $url  url, eg. http://matomo.org
     * @param string $date a day string, eg. 2016-12-24
     * @return null|string serialized keyword data
     */
    public function getKeywordData($url, $date)
    {
        return $this->getData($url, $date, 'keywords');
    }
    /**
     * Returns the latest date keyword data is available for
     *
     * @param string $url  url, eg. http://matomo.org
     * @return null|string
     */
    public function getLatestDateKeywordDataIsAvailableFor($url)
    {
        $date = Db::fetchOne('SELECT `date` FROM ' . $this->table . ' WHERE `url` = ? AND `type` = ? ORDER BY `date` DESC LIMIT 1', [$url, 'keywords']);
        return $date;
    }
    /**
     * Saves crawl stats for given url and day
     *
     * @param string $url      url, eg. http://matomo.org
     * @param string $date     a day string, eg. 2016-12-24
     * @param string $keywords serialized keyword data
     * @return bool
     */
    public function archiveCrawlStatsData($url, $date, $keywords)
    {
        return $this->archiveData($url, $date, $keywords, 'crawlstats');
    }
    /**
     * Returns the saved crawl stats for given parameters (or null if not available)
     *
     * @param string $url  url, eg. http://matomo.org
     * @param string $date a day string, eg. 2016-12-24
     * @return null|string serialized keyword data
     */
    public function getCrawlStatsData($url, $date)
    {
        return $this->getData($url, $date, 'crawlstats');
    }
    /**
     * Saves crawl error for given url
     *
     * @param string $url      url, eg. http://matomo.org
     * @param string $keywords serialized keyword data
     * @return bool
     */
    public function archiveCrawlErrors($url, $keywords)
    {
        return $this->archiveData($url, '0000-00-00', $keywords, 'crawlerrors');
    }
    /**
     * Returns the saved crawl stats for given parameters (or null if not available)
     *
     * @param string $url  url, eg. http://matomo.org
     * @return null|string serialized keyword data
     */
    public function getCrawlErrors($url)
    {
        return $this->getData($url, '0000-00-00', 'crawlerrors');
    }
    /**
     * Returns the saved data for given parameters (or null if not available)
     *
     * @param string $url  url, eg. http://matomo.org
     * @param string $date a day string, eg. 2016-12-24
     * @param string $type type of data, like keywords, crawlstats,...
     * @return null|string serialized data
     */
    protected function getData($url, $date, $type)
    {
        $keywordData = Db::fetchOne('SELECT `data` FROM ' . $this->table . ' WHERE `url` = ? AND `date` = ? AND `type` = ?', [$url, $date, $type]);
        if ($keywordData) {
            return $this->uncompress($keywordData);
        }
        return null;
    }
    /**
     * Saves data for given type, url and day
     *
     * @param string $url      url, eg. http://matomo.org
     * @param string $date     a day string, eg. 2016-12-24
     * @param string $keywords serialized keyword data
     * @param string $type     type of data, like keywords, crawlstats,...
     * @return bool
     */
    protected function archiveData($url, $date, $data, $type)
    {
        $query = "REPLACE INTO " . $this->table . " (`url`, `date`, `data`, `type`) VALUES (?,?,?,?)";
        $bindSql = [];
        $bindSql[] = $url;
        $bindSql[] = $date;
        $bindSql[] = $this->compress($data);
        $bindSql[] = $type;
        Db::query($query, $bindSql);
        return \true;
    }
    protected function compress($data)
    {
        if (Db::get()->hasBlobDataType()) {
            $data = gzcompress($data);
        }
        return $data;
    }
    protected function uncompress($data)
    {
        if (Db::get()->hasBlobDataType()) {
            $data = gzuncompress($data);
        }
        return $data;
    }
}
