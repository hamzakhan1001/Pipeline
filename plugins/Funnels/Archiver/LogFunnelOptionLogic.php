<?php

namespace Piwik\Plugins\Funnels\Archiver;

use Piwik\ArchiveProcessor\Rules;
use Piwik\Common;
use Piwik\Config;
use Piwik\Date;
use Piwik\Db;
use Piwik\Option;
use Piwik\Piwik;
use Piwik\Site;
use Piwik\Plugins\SitesManager\API as SitesManagerApi;

class LogFunnelOptionLogic
{
    public const MAX_LINK_VISIT_ACTION_OPTION_NAME_PREFIX = 'max_idlink_va';
    public const FUNNEL_ARCHIVING_TODAY_OPTION_NAME_PREFIX = 'funnel_archiving_today';

    /**
     * Builds the name to use for the option for the site and date.
     *
     * @param int $idSite
     * @param string $dateString
     * @return string
     */
    public static function buildMaxActionOptionName(int $idSite, string $dateString): string
    {
        return self::MAX_LINK_VISIT_ACTION_OPTION_NAME_PREFIX . "_{$idSite}_{$dateString}";
    }

    /**
     * Build the option name used to track the most recent archiving of a site for today.
     *
     * @param int $idSite
     * @return string
     */
    public function buildLatestTodayFunnelArchiveOptionName(int $idSite): string
    {
        return self::FUNNEL_ARCHIVING_TODAY_OPTION_NAME_PREFIX . "_{$idSite}_timestamp";
    }

    /**
     * Gets the newest action in the date range for the specified site. It then saves the ID to the options table to be
     * referenced the next time that date is archived for the site.
     *
     * @param int $idSite
     * @param int $startDateTimestamp Unix timestamp Integer so that we know it's in UTC
     * @param int $endDateTimestamp Unix timestamp Integer so that we know it's in UTC
     * @return void
     */
    public function populateMaxLinkVisitActionsForDay(int $idSite, int $startDateTimestamp, int $endDateTimestamp)
    {
        $maxLinkVisitActionId = $this->getMaxLinkVisitAction($idSite, $startDateTimestamp, $endDateTimestamp);
        if ($maxLinkVisitActionId <= 0) {
            return;
        }

        $endDay = Date::factory($endDateTimestamp)->toString();

        Option::set(self::buildMaxActionOptionName($idSite, $endDay), $maxLinkVisitActionId);
    }

    /**
     * Get the log_link_visit_action with the highest idlink_va in the date range for the specified site.
     *
     * @param int $idSite
     * @param int $startDateTimestamp Unix timestamp Integer so that we know it's in UTC
     * @param int $endDateTimestamp Unix timestamp Integer so that we know it's in UTC
     * @return int ID for the action most recently inserted during the specified datetime range. 0 if none found
     */
    public function getMaxLinkVisitAction(int $idSite, int $startDateTimestamp, int $endDateTimestamp): int
    {
        $table = Common::prefixTable('log_link_visit_action');
        $sql = "SELECT idlink_va
        FROM {$table} USE INDEX (index_idsite_servertime)
        WHERE idsite = ? AND server_time >= ? AND server_time <= ?
        ORDER BY idlink_va DESC
        LIMIT 1";

        $startDateTime = Date::factory($startDateTimestamp)->toString(Date::DATE_TIME_FORMAT);
        $endDateTime = Date::factory($endDateTimestamp)->toString(Date::DATE_TIME_FORMAT);

        return intval(Db::fetchOne($sql, [$idSite, $startDateTime, $endDateTime]));
    }

    /**
     * Check if the there's a more recent action since the last time this date range was archived for the site.
     *
     * @param int $idSite
     * @param int $startDateTimestamp Unix timestamp Integer so that we know it's in UTC
     * @param int $endDateTimestamp Unix timestamp Integer so that we know it's in UTC
     * @return bool
     */
    public function hasThereBeenNewActionsSinceLastArchive(int $idSite, int $startDateTimestamp, int $endDateTimestamp): bool
    {
        $maxLinkVisitAction = $this->getMaxLinkVisitAction($idSite, $startDateTimestamp, $endDateTimestamp);
        // If there's no max action, then nothing has probably changed
        if ($maxLinkVisitAction <= 0) {
            return false;
        }
        $endDay = Date::factory($endDateTimestamp)->toString();

        $maxLinkVisitActionIdOption = Option::get(self::buildMaxActionOptionName($idSite, $endDay));
        // If there's no option or the current ID is greater, then things have changed
        if ($maxLinkVisitActionIdOption === false || $maxLinkVisitAction > intval($maxLinkVisitActionIdOption)) {
            return true;
        }

        return false;
    }

    /**
     * Update the latest time that a site has been archived for today.
     *
     * @param int $idSite
     * @return void
     */
    public function updateLatestTodayFunnelArchiveOption(int $idSite)
    {
        Option::set($this->buildLatestTodayFunnelArchiveOptionName($idSite), time());
    }

    /**
     * Check if the site was archived today and if it was long enough ago that we can archive again.
     *
     * @param int $idSite
     * @return bool
     */
    public function isOverTodaysRequiredWaitTime(int $idSite): bool
    {
        // If the config is forcing archiving for testing, return true
        $config = Config::getInstance();
        if (isset($config->Debug['always_archive_data_day']) && $config->Debug['always_archive_data_day'] == 1) {
            return true;
        }

        $optionValue = Option::get($this->buildLatestTodayFunnelArchiveOptionName($idSite));
        // If the option can't be found, return true. This means that funnels haven't been archived today
        if ($optionValue === false) {
            return true;
        }

        $waitSeconds = Rules::getTodayArchiveTimeToLiveDefault();

        // Return whether the last time plus the required minimum seconds between archiving today is less than now
        return (intval($optionValue) + $waitSeconds) < time();
    }

    /**
     * This takes the parameters from an invalidation event and determines if we need to invalidate funnel options.
     *
     * @param $parameters
     * @return void
     */
    public function invalidateFunnelOptionsIfNecessary($parameters)
    {
        $idSites = $parameters['idSites'] ?? '';
        if ($idSites === 'all') {
            $idSites = SitesManagerAPI::getInstance()->getSitesIdWithAdminAccess();
        } else {
            $idSites = Site::getIdSitesFromIdSitesString($idSites);
            // Do a quick permission check if a list of sites is provided and the command wasn't executed via CLI
            if (!Common::isPhpCliMode()) {
                Piwik::checkUserHasAdminAccess($idSites);
            }
        }

        // If invalidating for a specific plugin and it's not Funnels, skip
        if (!empty($parameters['plugin']) && $parameters['plugin'] !== 'Funnels') {
            return;
        }

        // Iterate over the selected sites and invalidate their options
        foreach ($idSites as $idSite) {
            // Make sure that the site ID is valid
            $idSite = intval($idSite);
            if ($idSite <= 0) {
                continue;
            }

            $this->invalidateFunnelOptionsForSite($idSite);
        }
    }

    /**
     * This invalidates all the max LVA ID options for a specific site, except for yesterday and today. This is
     * simply much easier than figuring out the exact dates to invalidate based off of the dates and periods. It also
     * avoids duplicate code since we don't have to figure out the dates based on the dates and periods.
     *
     * @param int $idSite
     * @param bool $isCreationUpdate Indicates whether the invalidation is for a funnel create/update. This is important
     * because archiving for yesterday won't happen correctly without clearing the options for yesterday and today if
     * the funnel hasn't been archived before or needs to be completely re-archived.
     * @return void
     */
    public function invalidateFunnelOptionsForSite(int $idSite, bool $isCreationUpdate = false)
    {
        // Get the max ID options for yesterday and today and save them since we don't want to delete them
        $yesterday = Date::yesterday()->toString();
        $today = Date::today()->toString();
        $yesterdayOption = Option::get(self::buildMaxActionOptionName($idSite, $yesterday));
        $todayOption = Option::get(self::buildMaxActionOptionName($idSite, $today));

        // Delete all the max LVA ID options for the specified site
        Option::deleteLike(self::MAX_LINK_VISIT_ACTION_OPTION_NAME_PREFIX . "_{$idSite}_%");

        // Add the options back in for today and yesterday. Since 0 and false aren't valid IDs, we can use empty()
        if (!empty($yesterdayOption) && !$isCreationUpdate) {
            Option::set(self::buildMaxActionOptionName($idSite, $yesterday), $yesterdayOption);
        }
        if (!empty($todayOption) && !$isCreationUpdate) {
            Option::set(self::buildMaxActionOptionName($idSite, $today), $todayOption);
        }
    }
}
