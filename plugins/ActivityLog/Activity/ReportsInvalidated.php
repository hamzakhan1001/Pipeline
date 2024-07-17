<?php

namespace Piwik\Plugins\ActivityLog\Activity;

use Piwik\Piwik;
use Piwik\Plugins\SitesManager\API as SitesManagerAPI;
use Piwik\Site;

class ReportsInvalidated extends Activity
{
    protected $eventName = 'InvalidateReports.invalidateReports';

    /**
     * Returns data to be used for logging the event
     *
     * @param array $eventData Array of data passed to postEvent method
     * @return array
     */
    public function extractParams($eventData)
    {
        list($finalAPIParameters) = $eventData;

        // $finalAPIParameters = [ idSites, dates, period, segment, cascadeDown, _forceInvalidateNonexistent ]
        // If it's coming from the console command, it should also include [plugin, ignoreLogDeletionLimit]

        $idSites = $finalAPIParameters['idSites'];
        if ($idSites === 'all') {
            $idSites = SitesManagerAPI::getInstance()->getSitesIdWithAdminAccess();
        } else {
            $idSites = Site::getIdSitesFromIdSitesString($idSites);
        }

        if (!empty($finalAPIParameters['dates'])) {
            $dateArray = explode(',', $finalAPIParameters['dates']);
            $finalAPIParameters['dates'] = count($dateArray) > 1 ? "{$dateArray[0]} - {$dateArray[count($dateArray) - 1]}" : $finalAPIParameters['dates'];
        }

        $return = [
            'items' => [
                [
                    'type' => 'reportsinvalidated',
                    'data' => $finalAPIParameters
                ]
            ]
        ];
        foreach ($idSites as $idSite) {
            $return['items'][] = [
                'type' => 'measurable',
                'data' => [
                    'id'   => $idSite,
                    'name' => Site::getNameFor($idSite),
                    'type' => Site::getTypeFor($idSite),
                    'urls' => SitesManagerAPI::getInstance()->getSiteUrlsFromId($idSite)
                ]
            ];
        }

        return $return;
    }

    /**
     * Returns the translated description of the logged event
     *
     * @param array $activityData
     * @param string $performingUser
     * @return string
     */
    public function getTranslatedDescription($activityData, $performingUser)
    {
        return Piwik::translate('ActivityLog_ReportsInvalidated');
    }

    /**
     * Returns the parameters stored in the given activity data
     *
     * This overrides the parent implementation to fix some of the parameters that may have been persisted incorrectly
     *
     * @param array $activityData
     * @return array
     */
    public function getParameters($activityData)
    {
        // Account for typo in old activities that were recorded
        $params = parent::getParameters($activityData);
        if (empty($params['items'])) {
            return $params;
        }
        $items = &$params['items'];

        foreach ($items as &$item) {
            if (empty($item['type']) || $item['type'] !== 'reportsinvalidated' || !is_array($item['data'])) {
                continue;
            }
            $data = $item['data'];

            // If the parameters contain the typo, replace it with the correct spelling and same value
            if (key_exists('_forceInvalidateNonexistant', $data) && !key_exists('_forceInvalidateNonexistent', $data)) {
                $item['data']['_forceInvalidateNonexistent'] = $data['_forceInvalidateNonexistant'];
                unset($item['data']['_forceInvalidateNonexistant']);
            }
        }

        return $params;
    }
}