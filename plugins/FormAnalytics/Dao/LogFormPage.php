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

namespace Piwik\Plugins\FormAnalytics\Dao;

use Piwik\Common;
use Piwik\Db;
use Piwik\DbHelper;

class LogFormPage
{
    public const MAX_FIELD_NAME_LENGTH = 75;

    private $table = 'log_form_page';
    private $tablePrefixed = '';

    public function __construct()
    {
        $this->tablePrefixed = Common::prefixTable($this->table);
    }

    private function getDb()
    {
        return Db::get();
    }

    public function install()
    {
        DbHelper::createTable($this->table, "
                  `idlogformpage` BIGINT(15) NOT NULL AUTO_INCREMENT,
                  `idlogform` BIGINT(15) NOT NULL,
                  `idaction_url` INT(10) UNSIGNED NULL,  
                  `num_views` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT 1,
                  `num_starts` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT 1,
                  `num_submissions` SMALLINT(3) UNSIGNED NOT NULL DEFAULT 0, 
                  `time_hesitation` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT 0,
                  `time_spent` INT(11) UNSIGNED NOT NULL DEFAULT 0,
                  `time_to_first_submission` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT 0,
                  `entry_field_name` VARCHAR(" . self::MAX_FIELD_NAME_LENGTH . ") NULL DEFAULT NULL,
                  `exit_field_name` VARCHAR(" . self::MAX_FIELD_NAME_LENGTH . ") NULL DEFAULT NULL,
                  PRIMARY KEY(`idlogformpage`),
                  UNIQUE unique_form_actionurl (`idlogform`, `idaction_url`)");
    }

    public function uninstall()
    {
        Db::query(sprintf('DROP TABLE IF EXISTS `%s`', $this->tablePrefixed));
    }

    public function getAllRecords()
    {
        return $this->getDb()->fetchAll('SELECT * FROM ' . $this->tablePrefixed);
    }

    public function findIdLogFormPage($idLogForm, $idActionUrl)
    {
        $sql = sprintf('SELECT idlogformpage FROM %s WHERE idlogform = ? AND idaction_url = ? LIMIT 1', $this->tablePrefixed);
        $bind = array($idLogForm, $idActionUrl);
        $idLogForm = Db::fetchOne($sql, $bind);

        if (!empty($idLogForm)) {
            return $idLogForm;
        }
    }

    public function record($idLogForm, $idActionUrl, $isViewed, $isStarted, $isSubmitted, $timeHesitation, $timeSpent, $timeToSubmission, $entryFieldName, $exitFieldName)
    {
        $entryFieldName = !empty($entryFieldName) ? Common::mb_substr($entryFieldName, 0, self::MAX_FIELD_NAME_LENGTH) : null;
        $exitFieldName = !empty($exitFieldName) ? Common::mb_substr($exitFieldName, 0, self::MAX_FIELD_NAME_LENGTH) : null;
        $isViewed = $isViewed ? 1 : 0;
        $isStarted = $isStarted ? 1 : 0;
        $isSubmitted = $isSubmitted ? 1 : 0;
        $timeHesitation  = $timeHesitation ? $timeHesitation : 0;
        $timeToSubmission = $timeToSubmission ? $timeToSubmission : 0;

        if (!empty($timeHesitation) && $timeHesitation > 7200000) {
            $timeHesitation = 7200000;
            // we limit hesitation time to 2 hours (7200000 ms). Unlikely a user is actually actively longer on it and
            // field size allows us to max store about 4 hours
        }

        $values = array(
            'idlogform' => $idLogForm,
            'idaction_url' => $idActionUrl,
            'num_views' => 1, // it is always 1 when we add a record, if there was no view we wouldn't add the record
            'num_starts' => $isStarted,
            'num_submissions' => $isSubmitted,
            'time_spent' => $timeSpent,
            'time_hesitation' => $timeHesitation,
            'time_to_first_submission' => $timeToSubmission,
            'entry_field_name' => $entryFieldName,
            'exit_field_name' => $exitFieldName,
        );

        $columns = implode('`,`', array_keys($values));
        $vals = Common::getSqlStringFieldsArray($values);

        $sql = sprintf('INSERT INTO %s (`%s`) VALUES (%s)', $this->tablePrefixed, $columns, $vals);
        $bind = array_values($values);
        $db = $this->getDb();

        try {
            $db->query($sql, $bind);
        } catch (\Exception $e) {
            if (Db::get()->isErrNo($e, \Piwik\Updater\Migration\Db::ERROR_CODE_DUPLICATE_ENTRY)) {
                // race condition where two tried to insert at same time... we need to update instead
                $idLogFormPage = $this->findIdLogFormPage($idLogForm, $idActionUrl);
                $this->updateRecord($idLogFormPage, $isViewed, $isStarted, $isSubmitted, $timeHesitation, $timeSpent, $timeToSubmission, $entryFieldName, $exitFieldName);
                return $idLogFormPage;
            }
            throw $e;
        }

        $idLogForm = $db->lastInsertId();
        return $idLogForm;
    }

    public function updateRecord($idLogFormPage, $isViewed, $isStarted, $isSubmitted, $timeHesitation, $timeSpent, $timeToSubmission, $entryFieldName, $exitFieldName)
    {
        $sql = 'num_views = num_views + ?,
                num_starts = num_starts + ?,
                num_submissions = num_submissions + ?,
                time_spent = time_spent + ?,
                time_hesitation = IF(time_hesitation > 0, time_hesitation, ?),
                time_to_first_submission = IF(time_to_first_submission > 0, time_to_first_submission, ?)';

        $bind = array();
        $bind[] = $isViewed ? 1 : 0;
        $bind[] = $isStarted ? 1 : 0;
        $bind[] = $isSubmitted ? 1 : 0;
        $bind[] = !empty($timeSpent) ? $timeSpent : 0;
        $bind[] = $timeHesitation ? $timeHesitation : 0;
        $bind[] = $timeToSubmission ? $timeToSubmission : 0;

        $entryFieldName = !empty($entryFieldName) ? Common::mb_substr($entryFieldName, 0, self::MAX_FIELD_NAME_LENGTH) : null;
        $exitFieldName = !empty($exitFieldName) ? Common::mb_substr($exitFieldName, 0, self::MAX_FIELD_NAME_LENGTH) : null;

        if (!empty($entryFieldName)) {
            $sql .= ', entry_field_name = IFNULL(entry_field_name, ?)';
            $bind[] = $entryFieldName;
        }

        if (!empty($exitFieldName)) {
            $sql .= ', exit_field_name = ?';
            $bind[] = $exitFieldName;
        }

        $sql = sprintf(
            'UPDATE %s SET %s WHERE idlogformpage = ?',
            $this->tablePrefixed,
            $sql
        );
        $bind[] = $idLogFormPage;

        $db = $this->getDb();
        $db->query($sql, $bind);
    }
}
