<?php

/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */
namespace Matomo\Dependencies\SearchEngineKeywordsPerformance\Google\Service\Oauth2;

class Tokeninfo extends \Matomo\Dependencies\SearchEngineKeywordsPerformance\Google\Model
{
    protected $internal_gapi_mappings = ["expiresIn" => "expires_in", "issuedTo" => "issued_to", "userId" => "user_id", "verifiedEmail" => "verified_email"];
    public $audience;
    public $email;
    public $expiresIn;
    public $issuedTo;
    public $scope;
    public $userId;
    public $verifiedEmail;
    public function setAudience($audience)
    {
        $this->audience = $audience;
    }
    public function getAudience()
    {
        return $this->audience;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setExpiresIn($expiresIn)
    {
        $this->expiresIn = $expiresIn;
    }
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }
    public function setIssuedTo($issuedTo)
    {
        $this->issuedTo = $issuedTo;
    }
    public function getIssuedTo()
    {
        return $this->issuedTo;
    }
    public function setScope($scope)
    {
        $this->scope = $scope;
    }
    public function getScope()
    {
        return $this->scope;
    }
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
    public function getUserId()
    {
        return $this->userId;
    }
    public function setVerifiedEmail($verifiedEmail)
    {
        $this->verifiedEmail = $verifiedEmail;
    }
    public function getVerifiedEmail()
    {
        return $this->verifiedEmail;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
class_alias(Tokeninfo::class, 'Matomo\\Dependencies\\SearchEngineKeywordsPerformance\\Google_Service_Oauth2_Tokeninfo');
