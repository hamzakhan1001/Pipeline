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

namespace Piwik\Plugins\CustomReports\Input;

use Piwik\Piwik;
use Piwik\Site;

class Validator
{
    private function supportsMethod($method)
    {
        return method_exists('Piwik\Piwik', $method);
    }

    public function checkHasSomeWritePermission()
    {
        if ($this->supportsMethod('checkUserHasSomeWriteAccess')) {
            // since Matomo 3.6.0
            Piwik::checkUserHasSomeWriteAccess();
            return;
        }

        Piwik::checkUserHasSomeAdminAccess();
    }

    public function checkWritePermission($idSite)
    {
        if (self::isAllWebsitesRequest($idSite)) {
            Piwik::checkUserHasSuperUserAccess();
        } else {
            $this->checkSiteExists($idSite);

            if ($this->supportsMethod('checkUserHasWriteAccess')) {
                // since Matomo 3.6.0
                Piwik::checkUserHasWriteAccess($idSite);
                return;
            }

            Piwik::checkUserHasAdminAccess($idSite);
        }
    }

    public static function isAllWebsitesRequest($idSite)
    {
        return $idSite === 0 || $idSite === '0' || $idSite === 'all' || $idSite === false;
    }

    public function checkReportViewPermission($idSite)
    {
        $this->checkSiteExists($idSite);
        Piwik::checkUserHasViewAccess($idSite);
    }

    public function checkSiteExists($idSite)
    {
        if (self::isAllWebsitesRequest($idSite)) {
            return;
        }

        new Site($idSite);
    }

    public function canViewReport($idSite)
    {
        if (empty($idSite)) {
            return false;
        }

        return Piwik::isUserHasViewAccess($idSite);
    }

    public function canWrite($idSite)
    {
        if (empty($idSite)) {
            return false;
        }

        if ($this->supportsMethod('isUserHasWriteAccess')) {
            // since Matomo 3.6.0
            return Piwik::isUserHasWriteAccess($idSite);
        }

        return Piwik::isUserHasAdminAccess($idSite);
    }
}
