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

use Piwik\Container\Container;
use Piwik\Log\Logger;
use Piwik\DI;

return array(

    'Piwik\Plugins\LoginSaml\Logger' => DI::factory(function (Container $c) {
        $handler = new \Piwik\Plugins\Monolog\Handler\FileHandler(
            $c->get('LoginSaml.log.file.filename'),
            $c->get('LoginSaml.log.level')
        );

        // Use the default formatter
        $handler->setFormatter($c->get('Piwik\Plugins\Monolog\Formatter\LineMessageFormatter'));

        $logger = new Logger('LoginSaml', array($handler));

        return $logger;

    }),

    'LoginSaml.log.level' => DI::factory(function (Container $c) {
        if ($c->has('ini.LoginSaml.log_level')) {
            $level = $c->get('ini.LoginSaml.log_level');
            return constant('Piwik\Log\Logger::' . strtoupper($level));
        } else if ($c->has('ini.log.log_level')) {
            return $c->get('ini.log.log_level');
        } else {
            return Logger::ERROR;
        }
    }),

    'LoginSaml.log.filename' => DI::factory(function (Container $c) {
        if ($c->has('ini.LoginSaml.logger_file_path')) {
            $file = $c->get('ini.LoginSaml.logger_file_path');
            // Absolute path
            if (strpos($file, '/') === 0) {
                return $file;
            }
            // Relative to Matomo root
            return PIWIK_INCLUDE_PATH . '/' . $file;
        }
        // Default log file
        return $c->get('path.tmp') . '/logs/saml.log';
    }),

    'LoginSaml.log.file.filename' => DI::factory(function (Container $c) {
        if ($c->has('ini.LoginSaml.logger_file_path')) {
            $logPath = $c->get('ini.LoginSaml.logger_file_path');
            // Absolute path
            if (strpos($logPath, '/') === 0) {
                return $logPath;
            }
            // Remove 'tmp/' at the beginning
            if (strpos($logPath, 'tmp/') === 0) {
                $logPath = substr($logPath, strlen('tmp'));
            }
        } else {
            // Default log file
            $logPath = '/logs/saml.log';
        }
        $logPath = $c->get('path.tmp') . $logPath;
        if (is_dir($logPath)) {
            $logPath .= '/saml.log';
        }
        return $logPath;
    }),

    'diagnostics.required' => Piwik\DI::add(array(
        DI::get('Piwik\Plugins\LoginSaml\Diagnostic\LoginSamlCheck'),
    )),

    'observers.global' => \Piwik\DI::add([
        ['Login.userRequiresPasswordConfirmation', \Piwik\DI::value(function (&$requiresPasswordConfirmation, $login) {
            $samlEnabled = \Piwik\Plugins\LoginSaml\Config::isSamlEnabled();
            $enablePasswordConfirmation = \Piwik\Plugins\LoginSaml\Config::getConfigOption('enable_password_confirmation');
            if ($samlEnabled && !$enablePasswordConfirmation) {
                if (isset($_SESSION['saml_data']) && isset($_SESSION['saml_data']['saml_login']) && $_SESSION['saml_data']['saml_login']) {
                    $requiresPasswordConfirmation = false;
                }
            }
        })],
    ]),
    'Piwik\Plugins\Login\PasswordVerifier' => Piwik\DI::decorate(function ($previous) {
        $request = \Piwik\Request::fromRequest();
        $enablePasswordConfirmation = \Piwik\Plugins\LoginSaml\Config::getConfigOption('enable_password_confirmation');
        $samlEnabled = \Piwik\Plugins\LoginSaml\Config::isSamlEnabled();
        if ($samlEnabled && !$enablePasswordConfirmation &&  $request->getStringParameter('module', '') === 'Login' && $request->getStringParameter('action', '') === 'confirmPassword') {
            if (isset($_SESSION['saml_data']) && isset($_SESSION['saml_data']['saml_login']) && $_SESSION['saml_data']['saml_login']) {
                $previous->setPasswordVerifiedCorrectly();
            }
        }

        return $previous;
    }),
);
