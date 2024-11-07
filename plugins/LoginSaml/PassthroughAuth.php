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

namespace Piwik\Plugins\LoginSaml;

use Piwik\Auth;
use Piwik\AuthResult;
use Piwik\Plugins\UsersManager\Model;

class PassthroughAuth implements Auth
{
    /**
     * @var string
     */
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function getName()
    {
        return 'Login';
    }

    public function setTokenAuth($token_auth)
    {
        // empty
    }

    public function getLogin()
    {
        return $this->user['login'];
    }

    public function getTokenAuthSecret()
    {
        return null;
    }

    public function setLogin($login)
    {
        $this->user['login'] = $login;
    }

    public function setPassword($password)
    {
        // empty
    }

    public function setPasswordHash($passwordHash)
    {
        // empty
    }

    public function authenticate()
    {
        $userModel = new Model();
        $tokenAuth = $userModel->generateRandomTokenAuth();

        $code = !empty($this->user['superuser_access']) ? AuthResult::SUCCESS_SUPERUSER_AUTH_CODE : AuthResult::SUCCESS;
        return new AuthResult($code, $this->user['login'], $tokenAuth);
    }
}
