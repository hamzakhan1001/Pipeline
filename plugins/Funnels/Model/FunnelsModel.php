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

namespace Piwik\Plugins\Funnels\Model;

use Exception;
use Piwik\API\Request;
use Piwik\Cache as PiwikCache;
use Piwik\Container\StaticContainer;
use Piwik\Date;
use Piwik\Exception\UnexpectedWebsiteFoundException;
use Piwik\Piwik;
use Piwik\Tracker\GoalManager;
use Piwik\Plugins\Funnels\Dao\Funnel as FunnelDao;
use Piwik\Plugins\Funnels\Dao\LogTable;
use Piwik\Site;

class FunnelsModel
{
    public const KEY_FINAL_STEP_POSITION = 'final_step_position';

    /**
     * @var FunnelDao
     */
    private $funnelDao;

    /**
     * @var LogTable
     */
    private $logTable;

    private $goalsCache = array();

    public function __construct(FunnelDao $funnelDao, LogTable $logTable)
    {
        $this->funnelDao = $funnelDao;
        $this->logTable = $logTable;
    }

    public static function isValidGoalId($idGoal)
    {
        // 0 for ecommerce order
        return !empty($idGoal) || $idGoal === '0' || $idGoal === 0;
    }

    public function checkFunnelExists($idSite, $idFunnel)
    {
        $funnel = $this->funnelDao->getFunnel($idFunnel);

        if (empty($funnel) || $funnel['idsite'] != $idSite) {
            throw new FunnelNotFoundException();
        }

        return $funnel;
    }

    public function checkGoalFunnelExists($idSite, $idGoal)
    {
        $funnel = $this->funnelDao->getGoalFunnel($idSite, $idGoal);

        if (empty($funnel)) {
            throw new FunnelNotFoundException(Piwik::translate('Funnels_ErrorGoalFunnelDoesNotExist'));
        }
    }

    public function checkGoalExists($idSite, $idGoal)
    {
        $goal = $this->getGoal($idSite, $idGoal);

        if (empty($goal)) {
            throw new Exception(Piwik::translate('Funnels_ErrorGoalDoesNotExist'));
        }
    }

    /**
     * Checks whether the loaded funnel array matches the provided site ID.
     *
     * @param int $idSite
     * @param array|null $funnel
     * @return void
     * @throws Exception If the funnel array is empty, doesn't have a idsite index, or the idsite doesn't match
     */
    public function checkFunnelMatchesSite(int $idSite, ?array $funnel)
    {
        if (!is_array($funnel) || empty($funnel['idsite']) || intval($funnel['idsite']) !== $idSite) {
            throw new Exception(Piwik::translate('Funnels_ErrorFunnelDoesNotExistForSite'));
        }
    }

    public function getFunnel($idFunnel)
    {
        $funnel = $this->funnelDao->getFunnel($idFunnel);

        return $this->enrichFunnel($funnel);
    }

    public function getGoalFunnel($idSite, $idGoal)
    {
        $funnel = $this->funnelDao->getGoalFunnel($idSite, $idGoal);

        return $this->enrichFunnel($funnel);
    }

    public function getSalesFunnelForSite($idSite)
    {
        $funnel = $this->funnelDao->getSalesFunnelForSite($idSite);

        return $this->enrichFunnel($funnel);
    }

    public function deleteGoalFunnel($idSite, $idGoal)
    {
        // do not use $this->getGoalFunnel() because that method checks if the goal exists and the goal might have been
        // deleted meanwhile.
        $funnel = $this->funnelDao->getGoalFunnel($idSite, $idGoal);

        if (!empty($funnel['idfunnel'])) {
            $now = Date::now()->getDatetime();
            $this->funnelDao->disableFunnel($funnel['idfunnel'], $now);
            $this->getFunnelsTransientCache()->delete($this->getCacheId($idSite));

            return $funnel['idfunnel'];
        }
    }

    public function deleteNonGoalFunnel($idSite, $idFunnel)
    {
        $funnel = $this->funnelDao->getFunnel($idFunnel);
        try {
            $this->checkFunnelMatchesSite(intval($idSite), $funnel);
        } catch (Exception $e) {
            return 0;
        }

        if (!empty($funnel['idfunnel'])) {
            $now = Date::now()->getDatetime();
            $this->funnelDao->disableFunnel($funnel['idfunnel'], $now);
            $this->getFunnelsTransientCache()->delete($this->getCacheId($idSite));

            return $funnel['idfunnel'];
        }

        return 0;
    }

    public function getAllActivatedFunnelsForSite($idSite)
    {
        $cacheId = $this->getCacheId($idSite);
        $cache = $this->getFunnelsTransientCache();
        if ($cache->contains($cacheId)) {
            return $cache->fetch($cacheId);
        }

        $funnels = $this->funnelDao->getAllActivatedFunnelsForSite($idSite);

        $enriched = $this->enrichFunnels($funnels);
        $cache->save($cacheId, $enriched);
        return $enriched;
    }

    private function getCacheId($idSite)
    {
        return 'Funnels.getAllActivatedFunnelsForSite.' . (int) $idSite;
    }

    private function getFunnelsTransientCache()
    {
        return PiwikCache::getTransientCache();
    }

    public function hasAnyActivatedFunnelForSite($idSite)
    {
        // we could reuse getAllActivatedFunnelsForSite() and do !empty(->getAllActivatedFunnelsForSite()) but this is
        // much faster
        return $this->funnelDao->hasAnyActivatedFunnelForSite($idSite);
    }

    public function setGoalFunnel($idSite, $idGoal, $isActivated, $steps, $now, $shouldIncrementRevision)
    {
        $this->checkGoalExists($idSite, $idGoal);

        if (!empty($isActivated) && empty($steps)) {
            throw new Exception(Piwik::translate('Funnels_ErrorActivatedFunnelWithNoSteps'));
        }

        // If the goal ID is zero, use the method for looking up the sales funnel
        $funnel = ($idGoal === 0 || $idGoal === '0') ? $this->getSalesFunnelForSite($idSite) : $this->getGoalFunnel($idSite, $idGoal);

        // If the funnel already exists, update it
        if (!empty($funnel['idfunnel'])) {
            $this->funnelDao->updateFunnel($funnel['idfunnel'], $isActivated, $steps, $shouldIncrementRevision);

            return $funnel['idfunnel'];
        }

        $idFunnel = $this->funnelDao->createGoalFunnel($idSite, $idGoal, $isActivated, $steps, $now);
        $this->getFunnelsTransientCache()->delete($this->getCacheId($idSite));
        return $idFunnel;
    }

    public function saveNonGoalFunnel($idSite, $idFunnel, $isActivated, $steps, $now, $funnelName, $shouldIncrementRevision)
    {
        if (!empty($isActivated) && empty($steps)) {
            throw new Exception(Piwik::translate('Funnels_ErrorActivatedFunnelWithNoSteps'));
        }

        // If the funnel already exists, update it
        if (!empty($idFunnel)) {
            $funnel = $this->getFunnel($idFunnel);
            $this->funnelDao->updateFunnel($idFunnel, $isActivated, $steps, $shouldIncrementRevision);
            if (!empty($funnel['name']) && $funnel['name'] !== $funnelName) {
                $this->funnelDao->updateFunnelName($idFunnel, $funnelName);
            }
            return $idFunnel;
        }

        $idFunnel = $this->funnelDao->createNonGoalFunnel($idSite, $funnelName, $isActivated, $steps, $now);

        $this->getFunnelsTransientCache()->delete($this->getCacheId($idSite));
        return $idFunnel;
    }

    private function enrichFunnel($funnel)
    {
        if (empty($funnel)) {
            return null;
        }

        $funnel['isSalesFunnel'] = false;

        // If there's no goal assigned and the name column is set, that's all we need
        if (intval($funnel['idgoal']) === 0 && !empty($funnel['name'])) {
            $funnel[self::KEY_FINAL_STEP_POSITION] = count($funnel['steps']);
            $funnel['isNonGoalFunnel'] = true;

            return $funnel;
        }

        if (intval($funnel['idgoal']) === 0) {
            $funnel['isSalesFunnel'] = true;
        }

        $goal = $this->getGoal($funnel['idsite'], $funnel['idgoal']);

        if (empty($goal['name'])) {
            return null;
        }

        $funnel['name'] = str_replace('%', '%%', StaticContainer::get('Piwik\Translation\Translator')->clean($goal['name']));
        $funnel[self::KEY_FINAL_STEP_POSITION] = count($funnel['steps']) + 1;

        return $funnel;
    }

    private function enrichFunnels($funnels)
    {
        $all = array();

        if (!empty($funnels)) {
            foreach ($funnels as $funnel) {
                $funnel = $this->enrichFunnel($funnel);
                if (!empty($funnel)) {
                    $all[] = $funnel;
                }
            }
        }

        return $all;
    }

    public function clearGoalsCache($idSite = null)
    {
        $this->goalsCache = array();
        if ($idSite) {
            $this->getFunnelsTransientCache()->delete($this->getCacheId($idSite));
        }
    }

    public function getNumGoals($idSite)
    {
        $goals = $this->getAllGoals($idSite);
        return count($goals);
    }

    public function getAllGoals($idSite)
    {
        if (!isset($this->goalsCache[$idSite])) {
            $this->goalsCache[$idSite] = Request::processRequest('Goals.getGoals', array(
                'idSite' => $idSite,
                'filter_limit' => '-1', // when requesting a report it might eg set filter_limit=5, we need to overwrite this
                'filter_offset' => 0,
                'filter_truncate' => '-1',
                'filter_pattern' => '',
                'hideColumns' => '',
                'showColumns' => '',
                'filter_pattern_recursive' => ''
            ));

            if ($this->hasEcommerce($idSite)) {
                $this->goalsCache[$idSite][GoalManager::IDGOAL_ORDER] = array(
                    'idgoal' => GoalManager::IDGOAL_ORDER,
                    'name' => Piwik::translate('Ecommerce_Sales')
                );
            }
        }

        return $this->goalsCache[$idSite];
    }

    private function hasEcommerce($idSite)
    {
        try {
            if (Site::isEcommerceEnabledFor($idSite)) {
                return true;
            }
        } catch (UnexpectedWebsiteFoundException $e) {
            // ignore this error, site was just deleted
        }

        return false;
    }

    private function getGoal($idSite, $idGoal)
    {
        $goals = $this->getAllGoals($idSite);

        if (isset($goals[$idGoal])) {
            return $goals[$idGoal];
        }
    }
}
