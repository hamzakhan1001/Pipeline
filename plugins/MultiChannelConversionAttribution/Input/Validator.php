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

namespace Piwik\Plugins\MultiChannelConversionAttribution\Input;

use Piwik\Piwik;
use Exception;
use Piwik\Plugins\MultiChannelConversionAttribution\Configuration;
use Piwik\Plugins\MultiChannelConversionAttribution\SystemSettings;
use Piwik\Site;

class Validator
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var SystemSettings
     */
    private $systemSettings;

    public function __construct(Configuration $configuration, SystemSettings $systemSettings)
    {
        $this->configuration = $configuration;
        $this->systemSettings = $systemSettings;
    }

    private function supportsMethod($method)
    {
        return method_exists('Piwik\Piwik', $method);
    }

    public function checkWritePermission($idSite)
    {
        if ($this->supportsMethod('checkUserHasWriteAccess')) {
            // since Matomo 3.6.0
            Piwik::checkUserHasWriteAccess($idSite);
        } else {
            Piwik::checkUserHasAdminAccess($idSite);
        }

        $this->checkSiteExists($idSite);
    }

    private function checkSiteExists($idSite)
    {
        new Site($idSite);
    }

    public function checkReportViewPermission($idSite)
    {
        Piwik::checkUserHasViewAccess($idSite);
        $this->checkSiteExists($idSite);
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

    public function checkAttributionConfiguration($isEnabled)
    {
        if (!in_array($isEnabled, array(0, 1, true, false, '0', '1'), true)) {
            $message = Piwik::translate('MultiChannelConversionAttribution_ErrorXNotWhitelisted', array('isEnabled', '0, 1'));
            throw new Exception($message);
        }
    }

    public function checkCampaignDimensionCombination($campaignDimensionCombinationId)
    {
        if (empty($campaignDimensionCombinationId)) {
            return; // we will use default
        }

        $campaignDimensionCombinationOptions = $this->systemSettings->getTransformedCampaignDimensionCombinationOptions();

        $found = false;
        foreach ($campaignDimensionCombinationOptions as $campaignDimensionCombinationOption) {
            if ($campaignDimensionCombinationOption['key'] === $campaignDimensionCombinationId) {
                $found = true;
                break;
            }
        }

        if (!$found) {
            throw new Exception(Piwik::translate('MultiChannelConversionAttribution_ExceptionMessageCampaignCombinationDoesNotExist'));
        }
    }
}
