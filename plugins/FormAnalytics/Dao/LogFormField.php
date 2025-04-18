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
use Piwik\Plugins\FormAnalytics\Tracker\RequestProcessor;

class LogFormField
{
    public const MAX_FIELD_NAME_LENGTH = 75;
    public const MAX_LIMIT_TYNIINT = 255;
    public const MAX_LIMIT_SMALLINT = 65535;
    public const MAX_LIMIT_MEDIUMINT = 16777210;

    private $db;

    private $table = 'log_form_field';
    private $tablePrefixed = '';

    public function __construct()
    {
        $this->tablePrefixed = Common::prefixTable($this->table);
    }

    /**
     * tests only
     * @ignore
     * @internal
     * @param $db
     */
    public function setDatabase($db)
    {
        $this->db = $db;
    }

    private function getDb()
    {
        if (!empty($this->db)) {
            return $this->db;
        }
        return Db::get();
    }

    public function install()
    {
        DbHelper::createTable($this->table, "
                  `idlogform` bigint(15) NOT NULL,
                  `idlogformpage` bigint(15) NOT NULL,
                  `idformview` CHAR(" . RequestProcessor::MAX_FORM_ID_VIEW_LENGTH . ") NOT NULL,
                  `idpageview` CHAR(" . RequestProcessor::MAX_FORM_ID_VIEW_LENGTH . ") NULL DEFAULT NULL,
                  `field_name` VARCHAR(" . self::MAX_FIELD_NAME_LENGTH . ") NOT NULL,
                  `time_spent` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT 0,
                  `time_hesitation` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT 0,
                  `field_size` MEDIUMINT(8) NOT NULL DEFAULT -1,
                  `left_blank` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
                  `submitted` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
                  `num_changes` TINYINT(3) UNSIGNED NOT NULL DEFAULT 0,
                  `num_focus` TINYINT(3) UNSIGNED NOT NULL DEFAULT 0,
                  `num_deletes` SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
                  `num_cursor` SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
                  PRIMARY KEY (`idlogform`, `field_name`, `idformview`)");
        // idpageview => useful for visitor log
    }

    public function uninstall()
    {
        Db::query(sprintf('DROP TABLE IF EXISTS `%s`', $this->tablePrefixed));
    }

    public function getAllRecords()
    {
        return $this->getDb()->fetchAll('SELECT * FROM ' . $this->tablePrefixed);
    }

    public function hasRecord($idLogForm, $fieldName, $idFormView)
    {
        $sql = sprintf('SELECT idlogform FROM %s WHERE idlogform = ? AND field_name = ? AND idformview = ? LIMIT 1', $this->tablePrefixed);
        $bind = array($idLogForm, $fieldName, $idFormView);
        $hasRecord = Db::fetchOne($sql, $bind);

        return !empty($hasRecord);
    }

    public function record(
        $idLogForm,
        $idLogFormPage,
        $idFormView,
        $idPageView,
        $isSubmitted,
        $fieldName,
        $fieldSize,
        $isBlank,
        $timeSpent,
        $hesitationTime,
        $numChanges,
        $numFocus,
        $numDeletes,
        $numCursor
    ) {
        // if exists, then update
        // otherwise create
        $this->format(
            $idFormView,
            $fieldName,
            $fieldSize,
            $timeSpent,
            $hesitationTime,
            $numChanges,
            $numFocus,
            $numDeletes,
            $numCursor
        );

        $values = array(
            'idlogform' => $idLogForm,
            'idlogformpage' => $idLogFormPage,
            'idformview' => $idFormView,
            'idpageview' => $idPageView,
            'field_name' => $fieldName,
            'time_spent' => $timeSpent,
            'time_hesitation' => $hesitationTime,
            'field_size' => $fieldSize,
            'left_blank' => $isBlank ? 1 : 0,
            'submitted' => $isSubmitted ? 1 : 0,
            'num_changes' => !empty($numChanges) ? $numChanges : 0,
            'num_focus' => !empty($numFocus) ? $numFocus : 0,
            'num_deletes' => !empty($numDeletes) ? $numDeletes : 0,
            'num_cursor' => !empty($numCursor) ? $numCursor : 0,
        );

        $columns = implode('`,`', array_keys($values));
        $vals = Common::getSqlStringFieldsArray($values);

        $sql = sprintf('INSERT INTO %s (`%s`) VALUES (%s)', $this->tablePrefixed, $columns, $vals);

        // for some fields we only use highest values eg because of race conditons when 2 requests were sent
        // at same time we want to make sure to use only the higher one etc

        $bind = array_values($values);

        $db = $this->getDb();

        try {
            $db->query($sql, $bind);
        } catch (\Exception $e) {
            if ($db->isErrNo($e, \Piwik\Updater\Migration\Db::ERROR_CODE_DUPLICATE_ENTRY)) {
                // race condition where two tried to insert at same time... we need to update instead
                $this->updateRecord(
                    $idLogForm,
                    $idFormView,
                    $isSubmitted,
                    $fieldName,
                    $fieldSize,
                    $isBlank,
                    $timeSpent,
                    $hesitationTime,
                    $numChanges,
                    $numFocus,
                    $numDeletes,
                    $numCursor
                );
                return;
            }
            throw $e;
        }
    }

    private function format(
        &$idFormView,
        &$fieldName,
        &$fieldSize,
        &$timeSpent,
        &$hesitationTime,
        &$numChanges,
        &$numFocus,
        &$numDeletes,
        &$numCursor
    ) {

        $fieldName = !empty($fieldName) ? substr($fieldName, 0, self::MAX_FIELD_NAME_LENGTH) : '';
        $idFormView = !empty($idFormView) ? substr($idFormView, 0, 6) : '';
        $hesitationTime = !empty($hesitationTime) ? $hesitationTime : 0;

        $timeSpent = !empty($timeSpent) ? $timeSpent : 0;
        $timeSpent = $timeSpent > self::MAX_LIMIT_MEDIUMINT ? self::MAX_LIMIT_MEDIUMINT : $timeSpent;

        $fieldSize = !empty($fieldSize) ? $fieldSize : 0;
        $fieldSize = $fieldSize > self::MAX_LIMIT_MEDIUMINT ? self::MAX_LIMIT_MEDIUMINT : $fieldSize;

        $numChanges = !empty($numChanges) ? $numChanges : 0;
        $numChanges = $numChanges > self::MAX_LIMIT_TYNIINT ? self::MAX_LIMIT_TYNIINT : $numChanges;

        $numFocus = !empty($numFocus) ? $numFocus : 0;
        $numFocus = $numFocus > self::MAX_LIMIT_TYNIINT ? self::MAX_LIMIT_TYNIINT : $numFocus;

        $numDeletes = !empty($numDeletes) ? $numDeletes : 0;
        $numDeletes = $numDeletes > self::MAX_LIMIT_SMALLINT ? self::MAX_LIMIT_SMALLINT : $numDeletes;

        $numCursor = !empty($numCursor) ? $numCursor : 0;
        $numCursor = $numCursor > self::MAX_LIMIT_SMALLINT ? self::MAX_LIMIT_SMALLINT : $numCursor;

        if ($hesitationTime > 7200000) {
            $hesitationTime = 7200000;
            // we limit hesitation time to 2 hours (7200000 ms). Unlikely a user is actually actively longer on it and
            // field size allows us to max store about 4 hours
        }
    }

    public function updateRecord(
        $idLogForm,
        $idFormView,
        $isSubmitted,
        $fieldName,
        $fieldSize,
        $isBlank,
        $timeSpent,
        $hesitationTime,
        $numChanges,
        $numFocus,
        $numDeletes,
        $numCursor
    ) {
        $this->format(
            $idFormView,
            $fieldName,
            $fieldSize,
            $timeSpent,
            $hesitationTime,
            $numChanges,
            $numFocus,
            $numDeletes,
            $numCursor
        );

        $sql = 'field_size = ?, left_blank = ?';

        $bind = array();
        $bind[] = $fieldSize;
        $bind[] = !empty($isBlank) ? 1 : 0;

        // we add them manually only if needed just because there might be many such inserts and little performance
        // tweaks can make a difference

        if (!empty($isSubmitted)) {
            $sql .= ', submitted = 1';
        }

        if (!empty($timeSpent)) {
            // we only update if value > 0 as otherwise we know for sure it can never go into the if
            $sql .= ', time_spent = IF(time_spent > ?, time_spent, ?)';
            $bind[] = $timeSpent;
            $bind[] = $timeSpent;
        }

        if (!empty($hesitationTime)) {
            // we only update if value > 0 as otherwise we know for sure it can never go into the if
            $sql .= ', time_hesitation = IF(time_hesitation > ?, time_hesitation, ?)';
            $bind[] = $hesitationTime;
            $bind[] = $hesitationTime;
        }

        if (!empty($numChanges)) {
            $numChanges = $numChanges > self::MAX_LIMIT_TYNIINT ? self::MAX_LIMIT_TYNIINT : $numChanges;

            // we only update if value > 0 as otherwise we know for sure it can never go into the if
            $sql .= ', num_changes = IF(num_changes > ?, num_changes, ?)';
            $bind[] = $numChanges;
            $bind[] = $numChanges;
        }

        if (!empty($numFocus)) {
            $numFocus = $numFocus > self::MAX_LIMIT_TYNIINT ? self::MAX_LIMIT_TYNIINT : $numFocus;
            $sql .= ', num_focus = IF(num_focus > ?, num_focus, ?)';
            $bind[] = $numFocus;
            $bind[] = $numFocus;
        }

        if (!empty($numDeletes)) {
            $numDeletes = $numDeletes > self::MAX_LIMIT_SMALLINT ? self::MAX_LIMIT_SMALLINT : $numDeletes;
            $sql .= ', num_deletes = IF(num_deletes > ?, num_deletes, ?)';
            $bind[] = $numDeletes;
            $bind[] = $numDeletes;
        }

        if (!empty($numCursor)) {
            $numCursor = $numCursor > self::MAX_LIMIT_SMALLINT ? self::MAX_LIMIT_SMALLINT : $numCursor;
            $sql .= ', num_cursor = IF(num_cursor > ?, num_cursor, ?)';
            $bind[] = $numCursor;
            $bind[] = $numCursor;
        }

        $sql = sprintf(
            'UPDATE %s SET %s WHERE idlogform = ? AND field_name = ? AND idformview = ?',
            $this->tablePrefixed,
            $sql
        );
        $bind[] = $idLogForm;
        $bind[] = $fieldName;
        $bind[] = $idFormView;

        $db = $this->getDb();
        $db->query($sql, $bind);
    }
}
