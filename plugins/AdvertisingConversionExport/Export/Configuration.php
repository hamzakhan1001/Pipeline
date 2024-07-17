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

namespace Piwik\Plugins\AdvertisingConversionExport\Export;

use Exception;
use Piwik\Config;
use Piwik\Piwik;
use Piwik\Plugins\AdvertisingConversionExport\AdvertisingConversionExport;
use Piwik\Plugins\AdvertisingConversionExport\Export\Configuration\Goal;
use Piwik\Segment;
use Piwik\Site;

class Configuration
{
    const CLICK_ID_ATTRIBUTION_TYPE_FIRST = 'first';
    const CLICK_ID_ATTRIBUTION_TYPE_LAST = 'last';
    const CLICK_ID_ATTRIBUTION_TYPE_ALL = 'all';
    const KEY_MAX_EXECUTION_TIME = 'advertising_conversion_export_max_execution_time';
    const DEFAULT_MAX_EXECUTION_TIME = 0;
    const KEY_QUERY_LIMIT = 'advertising_conversion_export_query_limit';
    const DEFAULT_QUERY_LIMIT = 0;
    const KEY_EXPORT_ENABLED = 'enable_export';
    const DEFAULT_EXPORT_ENABLED = 1;

    protected static $clickIdAttributionTypes = [
        self::CLICK_ID_ATTRIBUTION_TYPE_FIRST,
        self::CLICK_ID_ATTRIBUTION_TYPE_LAST,
        self::CLICK_ID_ATTRIBUTION_TYPE_ALL,
    ];

    /** @var int */
    public $idSite;

    /** @var Goal[] */
    public $goals;

    /** @var string */
    public $segment;

    /** @var int */
    public $daysToExport = 7;

    /** @var int */
    public $daysToLookBack = 30;

    /** @var string */
    public $clickIdAttribution = 'last';

    /** @var boolean */
    public $onlyDirectAttribution = true;

    /** @var boolean */
    public $externalAttributedConversion = false;

    /** @var string */
    public $attributionModel = 'dataDriven';

    /** @var float */
    public $attributedCredit = 1;

    /** @var int */
    public $exportID;

    protected function __construct(int $idSite, int $exportID, array $goals, string $segment, int $daysToExport, bool $onlyDirectAttribution, ?int $daysToLookBack, ?string $clickIdAttribution, ?bool $externalAttributedConversion, ?string $attributionModel, ?float $attributedCredit)
    {
        $this->idSite                       = $idSite;
        $this->segment                      = $segment;
        $this->daysToExport                 = $daysToExport ?? $this->daysToExport;
        $this->onlyDirectAttribution        = $onlyDirectAttribution;
        $this->daysToLookBack               = $daysToLookBack ?? $this->daysToLookBack;
        $this->clickIdAttribution           = $clickIdAttribution ?? $this->clickIdAttribution;
        $this->externalAttributedConversion = $externalAttributedConversion ?? $this->externalAttributedConversion;
        $this->attributionModel             = $attributionModel ?? $this->attributionModel;
        $this->attributedCredit             = $attributedCredit ?? $this->attributedCredit;
        $this->goals                        = $this->makeGoalConfig($goals);
        $this->exportID                     = $exportID;
    }

    public static function build(int $idSite, array $configurationArray, int $exportID)
    {
        self::checkIsExportEnabled();
        // If the days to export is empty or invalid, set it to the default value of 7
        if (empty($configurationArray['daysToExport']) || strtolower($configurationArray['daysToExport']) === 'nan') {
            $configurationArray['daysToExport'] = 7;
        }

        // If externalAttributedConversion is empty or invalid, set it to disabled
        if (!isset($configurationArray['externalAttributedConversion'])) {
            $configurationArray['externalAttributedConversion'] = false;
        }

        return new self($idSite, $exportID, $configurationArray['goals'], $configurationArray['segment'], $configurationArray['daysToExport'], (bool)$configurationArray['onlyDirectAttribution'], $configurationArray['daysToLookBack'] ?? null, $configurationArray['clickIdAttribution'] ?? null, (bool)$configurationArray['externalAttributedConversion'] ?? null, $configurationArray['attributionModel'] ?? null, $configurationArray['attributedCredit'] ?? null);
    }

    /**
     * @throws Exception
     */
    public function validate(): void
    {
        // check site is valid
        new Site($this->idSite);

        // check all configured goals are valid
        foreach ($this->goals as $goal) {
            $goal->validate();
        }

        if (!in_array($this->clickIdAttribution, self::$clickIdAttributionTypes)) {
            throw new \Exception('Click Id Attribution must be one of this types: ' . implode(', ', self::$clickIdAttributionTypes));
        }

        if ($this->externalAttributedConversion) {

            $validAttributionModelNames = [];
            $isValidAttributionModel = false;
            foreach (AdvertisingConversionExport::getAttributionModels() as $attributionModel) {
                if ($attributionModel->getId() === $this->attributionModel) {
                    $isValidAttributionModel = true;
                    break;
                }
                $validAttributionModelNames[] = $attributionModel->getId();
            }
            if (!$isValidAttributionModel) {
                $exception = Piwik::translate('AdvertisingConversionExport_DaysToExportInvalid');
                throw new \Exception(Piwik::translate('AdvertisingConversionExport_AttributionModelInvalid') . implode(', ', $validAttributionModelNames));
            }

            if (!is_numeric($this->attributedCredit) || $this->attributedCredit <= 0 || $this->attributedCredit > 1) {
                throw new \Exception(Piwik::translate('AdvertisingConversionExport_AttributedCreditInvalid'));
            }
        }

        // check segment is valid
        new Segment($this->segment, [$this->idSite]);
    }

    protected function makeGoalConfig($goals): array
    {
        $goalConfigs = [];

        foreach ($goals as $goal) {
            $goalConfig                       = Goal::build($this->idSite, $goal);
            $goalConfigs[$goalConfig->idGoal] = $goalConfig;
        }

        return $goalConfigs;
    }

    /**
     * @param $idGoal
     * @return Goal|null
     */
    public function getGoalConfig($idGoal): ?Goal
    {
        return $this->goals[$idGoal] ?? null;
    }

    public function getConfiguredGoals($onlyValid = true)
    {
        if (!$onlyValid) {
            return $this->goals;
        }

        return array_filter($this->goals, function ($goal) {
            return $goal->isValid();
        });
    }

    public function getSite(): Site
    {
        return new Site($this->idSite);
    }

    public function getMaxExecutionTimeMySQLHint()
    {
        $config = Config::getInstance();
        $maxExecutionTime = isset($config->AdvertisingConversionExport[self::KEY_MAX_EXECUTION_TIME]) ? $config->AdvertisingConversionExport[self::KEY_MAX_EXECUTION_TIME] : self::DEFAULT_MAX_EXECUTION_TIME;
        if ($maxExecutionTime === false || $maxExecutionTime === '' || $maxExecutionTime === null || !is_numeric($maxExecutionTime)) {
            $maxExecutionTime = self::DEFAULT_MAX_EXECUTION_TIME;
        }

        $maxExecutionTimeHint = '';
        if (is_numeric($maxExecutionTime) && $maxExecutionTime > 0) {
            $timeInMs = $maxExecutionTime * 1000;
            $timeInMs = (int) $timeInMs;
            $maxExecutionTimeHint = ' /*+ MAX_EXECUTION_TIME(' . $timeInMs . ') */ ';
        }
        return $maxExecutionTimeHint;
    }

    public function getQueryLimit()
    {
        $config = Config::getInstance();
        $limit = self::DEFAULT_QUERY_LIMIT;
        if (isset($config->AdvertisingConversionExport[self::KEY_QUERY_LIMIT]) && is_numeric($config->AdvertisingConversionExport[self::KEY_QUERY_LIMIT]) && $config->AdvertisingConversionExport[self::KEY_QUERY_LIMIT] > 0) {
            $limit = $config->AdvertisingConversionExport[self::KEY_QUERY_LIMIT];
        }

        return $limit;
    }

    public static function checkIsExportEnabled()
    {
        $config = Config::getInstance();
        $isExportEnabled = self::DEFAULT_EXPORT_ENABLED;
        if (isset($config->AdvertisingConversionExport[self::KEY_EXPORT_ENABLED]) && is_numeric($config->AdvertisingConversionExport[self::KEY_EXPORT_ENABLED])) {
            $isExportEnabled = $config->AdvertisingConversionExport[self::KEY_EXPORT_ENABLED];
        }

        if (!$isExportEnabled) {
            throw new Exception('Export Disabled');
        }

        return true;
    }

    public function getAttributionModelExportName(): string
    {
        $attributionModels = AdvertisingConversionExport::getAttributionModels();
        foreach ($attributionModels as $attributionModel) {
            if ($attributionModel->getId() === $this->attributionModel) {
                return $attributionModel->getExportName();
            }
        }
        return $attributionModels[array_key_first($attributionModels)]->getExportName();
    }
}
