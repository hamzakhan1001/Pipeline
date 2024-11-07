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

namespace Piwik\Plugins\SEOWebVitals\Dao;

use Piwik\Common;
use Piwik\Date;
use Piwik\Db;
use Piwik\DbHelper;

class Reports
{
    private $table = 'log_webvitals_report';
    private $tablePrefixed = '';

    public const STRATEGYMAP = [
        PageSpeedApi::STRATEGY_MOBILE => 2,
        PageSpeedApi::STRATEGY_DESKTOP => 3,
    ];

    public function __construct()
    {
        $this->tablePrefixed = Common::prefixTable($this->table);
    }

    public function install()
    {
        DbHelper::createTable($this->table, "
                  `idlogwebvitalsreport` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                  `idsite` INT(11) UNSIGNED NOT NULL,
                  `date` VARCHAR(10) NOT NULL,
                  `strategy` TINYINT(1) NOT NULL,
                  `url` VARCHAR(1024) NOT NULL,
                  `report` MEDIUMBLOB NOT NULL ,
                  PRIMARY KEY (idlogwebvitalsreport),
                  INDEX unique_site_date (`idsite`, `date`)");
        //  we have an index on idSite, name to not create 2 or several forms at the same time during tracking
    }

    public function uninstall()
    {
        Db::query(sprintf('DROP TABLE IF EXISTS `%s`', $this->tablePrefixed));
    }

    private function getDb()
    {
        return Db::get();
    }

    private function compress($data)
    {
        if (!empty($data)) {
            return gzcompress($data);
        }

        return $data;
    }

    private function uncompress($data)
    {
        if (!empty($data)) {
            return gzuncompress($data);
        }

        return $data;
    }

    private function encodeStrategy($strategy)
    {
        if (isset(self::STRATEGYMAP[$strategy])) {
            return self::STRATEGYMAP[$strategy];
        }
        throw new \Exception('Unknown strategy used: ' . $strategy);
    }

    private function encodeFieldsWhereNeeded($columns)
    {
        foreach ($columns as $column => $value) {
            if ($column === 'report') {
                $columns[$column] = $this->compress(json_encode($value));
            } elseif ($column === 'strategy') {
                $columns[$column] = $this->encodeStrategy($value);
            }
        }

        return $columns;
    }

    public function getReportsByUrlByStrategy($idSite, Date $date)
    {
        $table = $this->tablePrefixed;
        $reports = $this->getDb()->fetchAll("SELECT * FROM $table WHERE idsite = ? and date = ?", array($idSite, $date->toString()));

        $map = [];
        foreach ($reports as $report) {
            $report = $this->enrichReport($report);
            $url = $report['url'];
            $strategy = $report['strategy'];
            if (!isset($map[$url])) {
                $map[$url] = [];
            }

            if (!empty($report['report'])) {
                $map[$url][$strategy] = new PageSpeedReport($report['report']);
            }
        }

        return $map;
    }

    public function getReportId($idSite, Date $date, $url, $strategy)
    {
        $table = $this->tablePrefixed;
        $strategy = $this->encodeStrategy($strategy);
        $id = $this->getDb()->fetchOne("SELECT idlogwebvitalsreport FROM $table WHERE idsite = ? and `date` = ? and strategy = ? and url = ? LIMIT 1", array($idSite, $date->toString(), $strategy, $url));
        if (!empty($id)) {
            return (int) $id;
        }
    }

    public function addReport($idSite, Date $date, $url, $strategy, $report)
    {
        $columns = array(
            'idsite' => $idSite,
            'date' => $date->toString(),
            'url' => $url,
            'strategy' => $strategy,
            'report' => $report,
        );
        $columns = $this->encodeFieldsWhereNeeded($columns);

        $bind = array_values($columns);
        $placeholder = Common::getSqlStringFieldsArray($columns);

        $reportId = $this->getReportId($idSite, $date, $url, $strategy);

        if ($reportId) {
            return $reportId;
        }

        $sql = sprintf(
            'INSERT INTO %s (`%s`) VALUES(%s)',
            $this->tablePrefixed,
            implode('`,`', array_keys($columns)),
            $placeholder
        );

        $db = $this->getDb();

        try {
            $db->query($sql, $bind);
        } catch (\Exception $e) {
            if (
                $e->getCode() == 23000
                || strpos($e->getMessage(), 'Duplicate entry') !== false
                || strpos($e->getMessage(), ' 1062 ') !== false
            ) {
                throw new \Exception('Duplicate report found');
            }
            throw $e;
        }

        return (int) $db->lastInsertId();
    }

    private function enrichReport($report)
    {
        if (empty($report)) {
            return $report;
        }

        $reportReport = $this->uncompress($report['report']);
        if (!empty($reportReport)) {
            $report['report'] = @json_decode($reportReport, true);
        } else {
            $report['report'] = '';
        }
        $report['strategy'] = array_search($report['strategy'], self::STRATEGYMAP);

        return $report;
    }
}
