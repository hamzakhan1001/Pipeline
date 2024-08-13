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

namespace Piwik\Plugins\CrashAnalytics\Tracker;

use Piwik\Date;
use Piwik\Plugins\CrashAnalytics\Dao\LogCrash;
use Piwik\Plugins\CrashAnalytics\Dao\LogCrashEvent;
use Piwik\Tracker\Cache;
use Piwik\Tracker\PageUrl;
use Piwik\Tracker\Request;
use Piwik\Tracker\TableLogAction;
use Piwik\Tracker\Visit\VisitProperties;
use Piwik\Log\LoggerInterface;

class RequestProcessor extends \Piwik\Tracker\RequestProcessor
{
    const TRACKING_PARAM_ERROR_MESSAGE = 'cra';
    const TRACKING_PARAM_ERROR_STACK = 'cra_st';
    const TRACKING_PARAM_ERROR_CATEGORY = 'cra_ct';
    const TRACKING_PARAM_ERROR_TYPE = 'cra_tp';
    const TRACKING_PARAM_RESOURCE_URI = 'cra_ru';
    const TRACKING_PARAM_RESOURCE_LINE = 'cra_rl';
    const TRACKING_PARAM_RESOURCE_COLUMN = 'cra_rc';

    /**
     * @var LogCrash
     */
    private $logCrash;

    /**
     * @var LogCrashEvent
     */
    private $logCrashEvent;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LogCrash $logCrash, LogCrashEvent $logCrashEvent, LoggerInterface $logger)
    {
        $this->logCrash = $logCrash;
        $this->logCrashEvent = $logCrashEvent;
        $this->logger = $logger;
    }

    public function processRequestParams(VisitProperties $visitProperties, Request $request)
    {
        $params = $request->getParams();
        if (empty($params[self::TRACKING_PARAM_ERROR_MESSAGE])) {
            return false;
        }

        $message = $params[self::TRACKING_PARAM_ERROR_MESSAGE];
        [$resourceUri] = $this->getLocationOfError($params);
        if (empty($resourceUri)) {
            return false;
        }

        $hash = $this->logCrash->getHash($message, $resourceUri);

        $cache = Cache::getCacheWebsiteAttributes($request->getIdSite());
        $ignoredHashes = $cache['CrashAnalytics']['ignored'] ?? [];
        if (in_array($hash, $ignoredHashes)) { // ignored crash
            $this->logger->debug('crash is ignored, aborting request processing (message = {message}, resourceUri = {resourceUri}, hash = {hash})', [
                'resourceUri' => $resourceUri,
                'message' => $message,
                'hash' => $hash,
            ]);
            return true;
        }

        return false;
    }

    public function afterRequestProcessed(VisitProperties $visitProperties, Request $request)
    {
        $params = $request->getParams();

        if (!empty($params[self::TRACKING_PARAM_ERROR_MESSAGE])) {
            // we need to make sure no action will be recorded! especially since we might go into record logs!
            $request->setMetadata('Actions', 'action', null);
            // make sure no goals will be recorded!
            $request->setMetadata('Goals', 'goalsConverted', array());

            if (!$this->shouldUpdateLastVisit($visitProperties, $request, 300)) {
                $request->setMetadata('CrashAnalytics', 'ignoreUpdateVisit', true);

                $this->logger->debug('crash within 300s of last action, will not update visit properties');
            }
        }
    }

    public function onExistingVisit(&$valuesToUpdate, VisitProperties $visitProperties, Request $request)
    {
        $params = $request->getParams();

        // code adapted from MediaAnalytics
        if ($request->getMetadata('CrashAnalytics', 'ignoreUpdateVisit')) {
            // we update visit_last_action_time only if visit_last_action_time was updated more than 5 min ago
            // we do not update all the time or every minute as not needed and to save resources
            $valuesToUpdate = array();
        } elseif (!empty($params[self::TRACKING_PARAM_ERROR_MESSAGE])) {
            foreach ($valuesToUpdate as $index => $val) {
                if (!in_array($index, array('visit_last_action_time', 'visit_total_time'))) {
                    // we do not want to update  visitor info for such requests apart to keep the users session alive
                    unset($valuesToUpdate[$index]);
                }
            }
        }
    }

    public function recordLogs(VisitProperties $visitProperties, Request $request)
    {
        $params = $request->getParams();
        if (empty($params[self::TRACKING_PARAM_ERROR_MESSAGE])) {
            return;
        }

        $message = $params[self::TRACKING_PARAM_ERROR_MESSAGE];
        [$fullResourceUri, $resourceLine, $resourceColumn, $stack] = $this->getLocationOfError($params);

        $resourceUriNormalizer = $this->makeResourceUriNormalizer($request);
        $resourceUri = $resourceUriNormalizer->normalize((int) $request->getIdSite(), $fullResourceUri);

        $crash = [
            'idsite' => $request->getIdSite(),
            'crash_type' => $params[self::TRACKING_PARAM_ERROR_TYPE] ?? 'Unknown',
            'message' => $message,
            'resource_uri' => $resourceUri,
            'stack_trace' => $stack,
            'resource_line' =>  $resourceLine,
            'resource_column' => $resourceColumn,
        ];
        [$idLogCrash, $prevLastSeen] = $this->logCrash->record($crash, $request->getCurrentTimestamp());

        if (empty($idLogCrash)) { // ignored
            $this->logger->debug('crash is ignored in DB, aborting request processing (message = {message}, resourceUri = {resourceUri})', [
                'resourceUri' => $resourceUri,
                'message' => $message,
            ]);
            return;
        }

        $idActionUrl = $visitProperties->getProperty('visit_exit_idaction_url') ?? $visitProperties->getProperty('visit_entry_idaction_url');
        $idActionName = $visitProperties->getProperty('visit_exit_idaction_name') ?? $visitProperties->getProperty('visit_entry_idaction_name');

        // using action ID TYPE_PAGE_URL. we don't really want to define an entirely new Action type since we are just
        // using the log_action table to store the source.
        $fullResourceUriIdAction = null;
        if ($fullResourceUri) {
            $urlInfo = PageUrl::normalizeUrl($fullResourceUri);
            [$fullResourceUriIdAction] = TableLogAction::loadIdsAction([
                [$urlInfo['url'], LogCrashEvent::TYPE_ACTION_RESOURCE_URI, $urlInfo['prefixId']],
            ]);
        }

        $crashEvent = [
            'idsite' => $request->getIdSite(),
            'idvisit' => $visitProperties->getProperty('idvisit'),
            'idvisitor' => $visitProperties->getProperty('idvisitor'),
            'idlogcrash' => $idLogCrash,
            'stack' => $stack,
            'idaction_resource_uri' => empty($fullResourceUriIdAction) ? 0 : $fullResourceUriIdAction,
            'resource_line' =>  $resourceLine,
            'resource_column' => $resourceColumn,
            'server_time' => date('Y-m-d H:i:s', $request->getCurrentTimestamp()),
            'created_time' => date('Y-m-d H:i:s', time()),
            'idpageview' => $request->getParam('pv_id'),
            'idaction_url' => $idActionUrl,
            'idaction_name' => $idActionName,
            'prev_last_seen' => $prevLastSeen,
            'category' => $params[self::TRACKING_PARAM_ERROR_CATEGORY] ?? '',
        ];
        $idLogCrashEvent = $this->logCrashEvent->record($crashEvent);

        $this->logger->debug('recorded crash {id}', ['idLogCrashEvent' => $idLogCrashEvent]);
    }

    private function getLocationOfError($params)
    {
        $stack = $params[self::TRACKING_PARAM_ERROR_STACK] ?? null;
        $resourceUri = $params[self::TRACKING_PARAM_RESOURCE_URI] ?? null;
        $resourceLine = $params[self::TRACKING_PARAM_RESOURCE_LINE] ?? null;
        $resourceColumn = $params[self::TRACKING_PARAM_RESOURCE_COLUMN] ?? null;

        return [$resourceUri, $resourceLine, $resourceColumn, $stack];
    }

    // code taken from MediaAnalytics
    private function shouldUpdateLastVisit(VisitProperties $visitProperties, Request $request, $seconds)
    {
        $lastActionTime = $visitProperties->getProperty('visit_last_action_time');
        if (!empty($lastActionTime)) {
            // it is only numeric when directly being called afterRequestProcessed() and not eg handleExistingVisit
            // because the VisitLastActionTime dimension will overwrite the original value of the visitor.
            // we want to make sure to work on the value from the DB
            if (is_numeric($lastActionTime)) {
                $lastActionTime = (int) $lastActionTime;
            }
            $lastActionTimeDate = Date::factory($lastActionTime)->addPeriod($seconds, 'seconds');
            $dateVisitWillBeUpdatedTo = Date::factory((int) $request->getCurrentTimestamp());
            if ($lastActionTimeDate->isEarlier($dateVisitWillBeUpdatedTo)) {
                // we update visit_last_action_time only if visit_last_action_time was updated more than 5 min ago
                // we do not update all the time or every minute as not needed and to save resources
                return true;
            }
        }
        return false;
    }

    private function makeResourceUriNormalizer(Request $request): ResourceUriNormalizer
    {
        $cache = Cache::getCacheWebsiteAttributes($request->getIdSite());
        $versioningUrlParameters = $cache['CrashAnalytics']['versioning_url_parameters'];
        $groupHashedSourceFiles = (bool) $cache['CrashAnalytics']['group_hashed_source_files'];
        return new ResourceUriNormalizer($versioningUrlParameters, $groupHashedSourceFiles);
    }
}
