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

namespace Piwik\Plugins\AdvertisingConversionExport;

use Piwik\Piwik;
use Piwik\Plugins\Live\VisitorDetailsAbstract;
use Piwik\Plugins\AdvertisingConversionExport\Dao\LogClickId;

class VisitorDetails extends VisitorDetailsAbstract
{
    protected $clickIds = null;

    public function provideActionsForVisitIds(&$actions, $visitIds)
    {
        if (empty($visitIds)) {
            return;
        }

        // use this method to fetch all tracked advertising records
        $this->clickIds = array_fill_keys($visitIds, null);

        $dao      = new LogClickId();
        $clickIds = $dao->findIdVisits($visitIds);

        // use while / array_shift combination instead of foreach to save memory
        while (is_array($clickIds) && count($clickIds)) {
            $clickId                             = array_shift($clickIds);
            $this->clickIds[$clickId['idvisit']] = $clickId;
        }
    }

    public function extendVisitorDetails(&$visitor)
    {
        $idVisit = $visitor['idVisit'];

        // set default values
        $visitor['adClickId']      = '';
        $visitor['adProviderId']   = '';
        $visitor['adProviderName'] = '';

        $advertisingData = $this->getAdvertisingData($idVisit);

        if (empty($advertisingData)) {
            return;
        }

        $provider = null;

        foreach (AdvertisingConversionExport::getAvailableClickIdProviders() as $clickIdProvider) {
            if ($clickIdProvider->getId() == $advertisingData['adprovider']) {
                $provider = $clickIdProvider;
                break;
            }
        }

        if ($provider) {
            $visitor['adClickId']      = $advertisingData['adclickid'] ?: '';
            $visitor['adProviderId']   = $advertisingData['adprovider'];
            $visitor['adProviderName'] = $provider->getName();
            $visitor['adProviderIcon'] = $provider->getLogoUrl();
        }
    }

    protected function getAdvertisingData($idVisit)
    {
        if (empty($this->clickIds) || !array_key_exists($idVisit, $this->clickIds)) {
            // if not prefetched
            $dao    = new LogClickId();
            $visits = $dao->findIdVisits([$idVisit]);
            return reset($visits);
        }

        return $this->clickIds[$idVisit];
    }

    public function renderIcons($visitorDetails)
    {
        if (!empty($visitorDetails['adProviderId'])) {
            $title = Piwik::translate('AdvertisingConversionExport_PaidTrafficSource', [
                $visitorDetails['adProviderName'],
            ]);

            $title = htmlentities($title, ENT_COMPAT | ENT_HTML401, 'UTF-8');

            return '<span title="' . $title . '" profile-header-text="' . $visitorDetails['adProviderName'] . '" class="visitorIconClickId visitorLogTooltip"><img src="'.$visitorDetails['adProviderIcon'].'" height="16"></span>';
        }

        return '';
    }
}