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

namespace Piwik\Plugins\FormAnalytics;

use Piwik\Config;

class Configuration
{
    public const KEY_MAX_NO_OF_FORM_REQUEST_ALLOWED = 'max_no_of_form_requests_allowed';
    public const DEFAULT_MAX_NO_OF_FORM_REQUEST_ALLOWED = 500;
    public const KEY_MAX_NO_OF_FORM_SUBMISSION_REQUEST_ALLOWED = 'max_no_of_form_submission_requests_allowed';
    public const DEFAULT_MAX_NO_OF_FORM_SUBMISSION_REQUEST_ALLOWED = 500;
    public const KEY_MAX_NO_OF_FORM_FIELDS_ALLOWED = 'max_no_of_form_fields_allowed';
    public const DEFAULT_MAX_NO_OF_FORM_FIELDS_ALLOWED = 2000;

    public function install()
    {
        $config = $this->getConfig();
        $config->FormAnalytics = array(
            self::KEY_MAX_NO_OF_FORM_REQUEST_ALLOWED => self::DEFAULT_MAX_NO_OF_FORM_REQUEST_ALLOWED,
            self::KEY_MAX_NO_OF_FORM_SUBMISSION_REQUEST_ALLOWED => self::DEFAULT_MAX_NO_OF_FORM_SUBMISSION_REQUEST_ALLOWED,
            self::KEY_MAX_NO_OF_FORM_FIELDS_ALLOWED => self::DEFAULT_MAX_NO_OF_FORM_FIELDS_ALLOWED,
        );
        $config->forceSave();
    }

    public function uninstall()
    {
        $config = $this->getConfig();
        $config->FormAnalytics = array();
        $config->forceSave();
    }

    private function getConfig()
    {
        return Config::getInstance();
    }

    private function getConfigValue($name, $default)
    {
        $config = $this->getConfig();
        $values = $config->FormAnalytics;
        if (isset($values[$name])) {
            return $values[$name];
        }

        return $default;
    }

    public function getNumberOfFormRequestsAllowed()
    {
        $value =  $this->getConfigValue(self::KEY_MAX_NO_OF_FORM_REQUEST_ALLOWED, self::DEFAULT_MAX_NO_OF_FORM_REQUEST_ALLOWED);
        if (!is_numeric($value)) {
            $value = self::DEFAULT_MAX_NO_OF_FORM_REQUEST_ALLOWED;
        }

        return $value;
    }

    public function getNumberOfFormSubmissionRequestsAllowed()
    {
        $value =  $this->getConfigValue(self::KEY_MAX_NO_OF_FORM_SUBMISSION_REQUEST_ALLOWED, self::DEFAULT_MAX_NO_OF_FORM_SUBMISSION_REQUEST_ALLOWED);
        if (!is_numeric($value)) {
            $value = self::DEFAULT_MAX_NO_OF_FORM_SUBMISSION_REQUEST_ALLOWED;
        }

        return $value;
    }

    public function getNumberOfFormFieldsAllowed()
    {
        $value =  $this->getConfigValue(self::KEY_MAX_NO_OF_FORM_FIELDS_ALLOWED, self::DEFAULT_MAX_NO_OF_FORM_FIELDS_ALLOWED);
        if (!is_numeric($value)) {
            $value = self::DEFAULT_MAX_NO_OF_FORM_FIELDS_ALLOWED;
        }

        return $value;
    }
}
