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

namespace Piwik\Plugins\AdvertisingConversionExport\Export\Configuration;

use Piwik\API\Request;
use Piwik\Site;

class Goal
{
    const REVENUE_TYPE_GOAL = 'goal';
    const REVENUE_TYPE_NONE = 'null';
    const REVENUE_TYPE_CUSTOM = 'custom';

    public $idSite;
    public $idGoal;
    public $alias;
    public $revenueType;
    public $revenueValue = null;

    static protected $availableRevenueTypes = [
        self::REVENUE_TYPE_GOAL,
        self::REVENUE_TYPE_CUSTOM,
        self::REVENUE_TYPE_NONE,
    ];

    protected function __construct(int $idSite, ?int $idGoal, string $alias, string $revenueType, ?string $revenueValue)
    {
        $this->idSite      = $idSite;
        $this->idGoal      = $idGoal;
        $this->alias       = $alias;
        $this->revenueType = $revenueType;
        if ($revenueType === self::REVENUE_TYPE_CUSTOM) {
            $this->revenueValue = $revenueValue;
        }
    }

    public static function build(int $idSite, array $configurationArray)
    {
        return new self($idSite, is_numeric($configurationArray['idgoal']) ? $configurationArray['idgoal'] : null, $configurationArray['name'], $configurationArray['revenue'], $configurationArray['revenueValue'] ?? null);
    }

    public function isValid()
    {
        try {
            $this->validate();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function validate()
    {
        if (is_null($this->idGoal)) {
            throw new \Exception('No goal configured');
        }

        if (!in_array($this->revenueType, self::$availableRevenueTypes)) {
            throw new \Exception('Invalid revenue type configured');
        }

        $this->checkGoalExists($this->idSite, $this->idGoal);
    }

    public function checkGoalExists($idSite, $idGoal)
    {
        if ($idGoal == 0) {
            $site = new Site($idSite);
            if (!$site->isEcommerceEnabled()) {
                throw new \Exception('Ecommerce is disabled for given site');
            }
            return;
        }

        $goal = Request::processRequest('Goals.getGoal', ['idSite' => $idSite, 'idGoal' => $idGoal]);

        if (empty($goal['idgoal'])) {
            throw new \Exception('Configured goal does not exist');
        }
    }

    public function getConversionValue($goalConversionValue)
    {
        switch ($this->revenueType) {
            case self::REVENUE_TYPE_NONE:
                return '';
            case self::REVENUE_TYPE_CUSTOM:
                return $this->revenueValue;
            case self::REVENUE_TYPE_GOAL:
            default:
                return $goalConversionValue;
        }

    }
}
