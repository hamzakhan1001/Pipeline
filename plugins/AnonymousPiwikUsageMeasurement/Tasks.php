<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\AnonymousPiwikUsageMeasurement;

use Piwik\Plugins\AnonymousPiwikUsageMeasurement\Tracker\CustomVariables;
use Piwik\Plugins\AnonymousPiwikUsageMeasurement\Tracker\Profiles;
use Piwik\Plugins\AnonymousPiwikUsageMeasurement\Tracker\Trackers;

class Tasks extends \Piwik\Plugin\Tasks
{
    /**
     * @var Trackers
     */
    private $trackers;

    /**
     * @var CustomVariables
     */
    private $customVars;

    /**
     * @var Profiles
     */
    private $profiles;

    public function __construct(Trackers $trackers, CustomVariables $customVars, Profiles $profiles)
    {
        $this->trackers = $trackers;
        $this->customVars = $customVars;
        $this->profiles = $profiles;
    }

    public function schedule()
    {
        $scheduledTime = $this->daily('sendSystemReport');
        $scheduledTime->setHour(rand(1, 23)); // make sure not all Piwik instances send data to matomo.org at same time
    }

    /**
     * To test execute the following command:
     * `./console core:run-scheduled-tasks "Piwik\Plugins\AnonymousPiwikUsageMeasurement\Tasks.sendSystemReport"`
     *
     * @throws \Exception
     */
    public function sendSystemReport()
    {
        $trackers   = $this->trackers->makeTrackers();
        $customVars = $this->customVars->getServerVisitCustomVariables();
        $profiles   = $this->profiles->popAll();

        foreach ($trackers as $tracker) {
            $tracker->enableBulkTracking();

            foreach ($customVars as $customVar) {
                $tracker->setCustomVariable($customVar['id'], $customVar['name'], $customVar['value'], 'visit');
            }

            $tracker->setAnonymousUrl('/system-report');
            $tracker->doTrackPageView('System-Report');

            foreach ($profiles as $profile) {
                $countAppendix =  ' (count)';
                $tracker->doTrackEvent($profile['category'] . $countAppendix, $profile['action'] . $countAppendix, $profile['name'] . $countAppendix, $profile['count']);

                if ($profile['count'] > 0) {
                    $speedAppendix =  ' (speed)';
                    $wallTimeAvg = round($profile['wall_time'] / $profile['count'], 1);
                    $tracker->doTrackEvent($profile['category'] . $speedAppendix, $profile['action'] . $speedAppendix, $profile['name'] . $speedAppendix, $wallTimeAvg);
                }
            }

            $tracker->doBulkTrack();
        }
    }
}
