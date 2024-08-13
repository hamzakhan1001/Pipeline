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

namespace Piwik\Plugins\MultiChannelConversionAttribution;

use Piwik\Archive;
use Piwik\Piwik;
use Piwik\Plugins\MultiChannelConversionAttribution\Input\Validator;
use Piwik\Plugins\MultiChannelConversionAttribution\Model\GoalAttributionModel;

/**
 * Multi Channel Conversion Attribution API
 *
 * @method static \Piwik\Plugins\MultiChannelConversionAttribution\API getInstance()
 */
class API extends \Piwik\Plugin\API
{
    /**
     * @var GoalAttributionModel
     */
    private $model;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var $systemSettings
     */
    private $systemSettings;

    public function __construct(GoalAttributionModel $model, Validator $validator, Configuration $configuration, SystemSettings  $systemSettings)
    {
        $this->model = $model;
        $this->validator = $validator;
        $this->configuration = $configuration;
        $this->systemSettings = $systemSettings;
    }

    /**
     * Enables or disables attribution for an existing goal.
     *
     * @param int $idSite
     * @param int $idGoal
     * @param int $isEnabled
     */
    public function setGoalAttribution($idSite, $idGoal, $isEnabled)
    {
        $this->validator->checkWritePermission($idSite);

        $this->model->setAttribution($idSite, $idGoal, $isEnabled);
    }

    /**
     * Get attribution information for a specific goal.
     *
     * @param int $idSite
     * @param int $idGoal
     */
    public function getGoalAttribution($idSite, $idGoal)
    {
        $this->validator->checkReportViewPermission($idSite);

        return $this->model->getAttribution($idSite, $idGoal);
    }

    /**
     * Get the channel attribution report for a specific goal.
     *
     * @param int $idSite
     * @param string $period
     * @param string $date
     * @param int $idGoal
     * @param int $idCampaignDimensionCombination the campaign dimension combination id to fetch
     * @param string $segment
     * @param bool $expanded
     * @param bool $flat
     * @param bool|int $idSubtable
     * @return \Piwik\DataTable\DataTableInterface
     */
    public function getChannelAttribution($idSite, $period, $date, $idGoal, $idCampaignDimensionCombination = 0, $segment = false, $expanded = false, $flat = false, $idSubtable = false)
    {
        $this->validator->checkReportViewPermission($idSite);
        $campaignDimensionCombination = $this->checkCampaignDimensionCombination($idCampaignDimensionCombination);
        $this->model->checkAttributionEnabled($idSite, $idGoal);

        $recordName = Archiver::completeChannelAttributionRecordName($idGoal, $campaignDimensionCombination);

        $table = Archive::createDataTableFromArchive($recordName, $idSite, $period, $date, $segment, $expanded, $flat, $idSubtable);

        if (empty($idSubtable)) {
            $table->filter('Piwik\Plugins\MultiChannelConversionAttribution\DataTable\Filter\RenameChannelType');
        } else {
            $table->filter('Piwik\Plugins\MultiChannelConversionAttribution\DataTable\Filter\RenameChannelName');
        }

        return $table;
    }

    /**
     * Returns a list of available campaignDimensionCombinations that can be used when requesting an attribution report.
     * @return array
     */
    public function getAvailableCampaignDimensionCombinations()
    {
        Piwik::checkUserHasSomeViewAccess();

        return $this->systemSettings->getTransformedCampaignDimensionCombinationOptions();
    }

    /**
     * Gets the available attribution goals per site.
     * @param int $idSite
     * @return array
     * @throws \Exception
     * @hide
     */
    public function getSiteAttributionGoals($idSite)
    {
        Piwik::checkUserHasViewAccess($idSite);

        return $this->model->getSiteAttributionGoals($idSite);
    }

    private function checkCampaignDimensionCombination($campaignDimensionCombinationId)
    {
        if (is_numeric($campaignDimensionCombinationId)) {
            $campaignDimensionCombinationId = (int) $campaignDimensionCombinationId;
        }
        $this->validator->checkCampaignDimensionCombination($campaignDimensionCombinationId);

        $campaignDimensionCombinationOptions = $this->systemSettings->getTransformedCampaignDimensionCombinationOptions(true);
        if (empty($campaignDimensionCombinationId)) {
            $campaignDimensionCombinationId = 0;
        }

        return $campaignDimensionCombinationOptions[$campaignDimensionCombinationId];
    }

}
