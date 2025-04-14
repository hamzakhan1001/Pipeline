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

namespace Piwik\Plugins\Funnels;

use Piwik\Archive;
use Piwik\Archive\ArchiveInvalidator;
use Piwik\Common;
use Piwik\Container\StaticContainer;
use Piwik\DataTable;
use Piwik\Date;
use Piwik\Piwik;
use Piwik\Plugins\Funnels\Archiver\LogFunnelOptionLogic;
use Piwik\Plugins\Funnels\Db\Pattern;
use Piwik\Plugins\Funnels\Input\Step;
use Exception;
use Piwik\Plugins\Funnels\Input\Validator;
use Piwik\Plugins\Funnels\Model\FunnelNotFoundException;
use Piwik\Plugins\Funnels\Model\FunnelsModel;
use Piwik\Plugin\API as PluginApi;

/**
 * API for plugin Funnels
 *
 * @method static \Piwik\Plugins\Funnels\API getInstance()
 */
class API extends PluginApi
{
    /**
     * @var FunnelsModel
     */
    private $funnels;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * @var Pattern
     */
    private $pattern;

    /**
     * @var ArchiveInvalidator
     */
    private $archiveInvalidator;

    public function __construct(FunnelsModel $funnel, Validator $validator, Pattern $pattern, ArchiveInvalidator $invalidator)
    {
        $this->funnels = $funnel;
        $this->validator = $validator;
        $this->pattern = $pattern;
        $this->archiveInvalidator = $invalidator;
    }

    /**
     * Get summary metrics for a specific funnel like the number of conversions, the conversion rate, the number of
     * entries etc.
     *
     * @param $idSite
     * @param $period
     * @param $date
     * @param bool|int $idFunnel  Either idFunnel or idGoal has to be set
     * @param bool|int $idGoal    Either idFunnel or idGoal has to be set. If goal given, will return the latest funnel for that goal
     * @param bool $segment
     * @return DataTable|DataTable\Map
     */
    public function getMetrics($idSite, $period, $date, $idFunnel = false, $idGoal = false, $segment = false)
    {
        $this->validator->checkReportViewPermission($idSite);

        $funnel = $this->getFunnelForReport($idSite, $idFunnel, $idGoal);
        $idFunnel = $funnel['idfunnel'];
        $revision = $funnel['revision'] ?? 0;

        $recordNames = Archiver::getNumericRecordNames($idFunnel, $revision);

        $archive = Archive::build($idSite, $period, $date, $segment);
        $table = $archive->getDataTableFromNumeric($recordNames);

        $columnMapping = array();
        foreach ($recordNames as $recordName) {
            $columnMapping[$recordName] = Archiver::getNumericColumnNameFromRecordName($recordName, $idFunnel, $revision);
        }

        $table->filter('ReplaceColumnNames', array($columnMapping));

        return $table;
    }

    private function getIdFunnelForReport($idSite, $idFunnel, $idGoal)
    {
        $funnel = $this->getFunnelForReport($idSite, $idFunnel, $idGoal);

        return $funnel['idfunnel'] ?? null;
    }

    private function getFunnelForReport($idSite, $idFunnel, $idGoal)
    {
        $isEcommerceOrder = $idGoal === 0 || $idGoal === '0';

        if (empty($idFunnel) && FunnelsModel::isValidGoalId($idGoal)) {
            // fetching by idGoal is needed for email reports
            $this->funnels->checkGoalFunnelExists($idSite, $idGoal);
            $funnel = $this->funnels->getGoalFunnel($idSite, $idGoal);
        } elseif (empty($idFunnel) && empty($idGoal) && !$isEcommerceOrder) {
            throw new Exception('No idFunnel or idGoal given');
        } else {
            $funnel = $this->funnels->checkFunnelExists($idSite, $idFunnel);
        }

        return $funnel;
    }

    /**
     * Get funnel flow information. The returned datatable will include a row for each step within the funnel
     * showing information like how many visits have entered or left the funnel at a certain position, how many
     * have completed a certain step etc.
     *
     * @param $idSite
     * @param $period
     * @param $date
     * @param bool|int $idFunnel  Either idFunnel or idGoal has to be set
     * @param bool|int $idGoal    Either idFunnel or idGoal has to be set. If goal given, will return the latest funnel for that goal
     * @param bool $segment
     * @return DataTable
     * @throws Exception
     */
    public function getFunnelFlow($idSite, $period, $date, $idFunnel = false, $idGoal = false, $segment = false)
    {
        $this->validator->checkReportViewPermission($idSite);

        $idFunnel = $this->getIdFunnelForReport($idSite, $idFunnel, $idGoal);
        $funnel = $this->funnels->getFunnel($idFunnel);

        $record = Archiver::completeRecordName(Archiver::FUNNELS_FLOW_RECORD, $funnel['idfunnel'], $funnel['revision']);

        $table = $this->getDataTable($record, $idSite, $period, $date, $segment, $expanded = false, $idSubtable = false);
        $table->filter('Piwik\Plugins\Funnels\DataTable\Filter\ForceSortByStepPosition');
        $table->filter('Piwik\Plugins\Funnels\DataTable\Filter\ComputeBackfills');
        $table->filter('Piwik\Plugins\Funnels\DataTable\Filter\RemoveExitsFromLastStep', array($funnel));
        $table->queueFilter('Piwik\Plugins\Funnels\DataTable\Filter\AddStepDefinitionMetadata', array($funnel));
        $table->queueFilter('Piwik\Plugins\Funnels\DataTable\Filter\ReplaceFunnelStepLabel', array($funnel));

        return $table;
    }

    /**
     * Get funnel flow information. The returned datatable will include a row for each step within the funnel
     * showing information like how many visits have entered or left the funnel at a certain position, how many
     * have completed a certain step etc.
     *
     * @param $idSite
     * @param $period
     * @param $date
     * @param bool|int $idFunnel  Either idFunnel or idGoal has to be set
     * @param bool|int $idGoal    Either idFunnel or idGoal has to be set. If goal given, will return the latest funnel for that goal
     * @param bool|string $segment
     * @return DataTable
     * @throws Exception
     */
    public function getFunnelFlowTable($idSite, $period, $date, $idFunnel = false, $idGoal = false, $segment = false)
    {
        // The permission check is handled by this method
        $table = $this->getFunnelFlow($idSite, $period, $date, $idFunnel, $idGoal, $segment);

        $funnel = $this->funnels->getFunnel($idFunnel);

        $table->filter('Piwik\Plugins\Funnels\DataTable\Filter\PrepareColumnsAndMetadata', [$funnel]);
        $table->queueFilter('Piwik\Plugins\Funnels\DataTable\Filter\UpdateLabelWithPrefix');

        return $table;
    }

    /**
     * Get subTable funnel flow information. The returned datatable will include a row for proceeded, entries, and
     * exists. If they have any values, they'll have a subTable of their own.
     *
     * @param $idSite
     * @param $period
     * @param $date
     * @param int $stepPosition
     * @param bool|int $idFunnel  Either idFunnel or idGoal has to be set
     * @param bool|int $idGoal    Either idFunnel or idGoal has to be set. If goal given, will return the latest funnel for that goal
     * @param bool|string $segment
     * @return DataTable
     * @throws Exception
     */
    public function getFunnelStepSubtable($idSite, $period, $date, $stepPosition, $idFunnel = false, $idGoal = false, $segment = false)
    {
        // The permission check is handled by this method
        $table = $this->getFunnelFlow($idSite, $period, $date, $idFunnel, $idGoal, $segment);

        $subTable = new DataTable();
        $subTable->filter('Piwik\Plugins\Funnels\DataTable\Filter\CompileSubtableUsingFlowData', [$table, $stepPosition]);
        $subTable->queueFilter('Piwik\Plugins\Funnels\DataTable\Filter\SortRowsAndTranslateLabels');

        return $subTable;
    }

    /**
     * Get all entry actions for the given funnel at the given step.
     *
     * @param $idSite
     * @param $period
     * @param $date
     * @param $idFunnel
     * @param bool $segment
     * @param bool $step
     * @param bool $expanded
     * @param bool $idSubtable
     * @param bool $flat
     * @return DataTable
     */
    public function getFunnelEntries($idSite, $period, $date, $idFunnel, $segment = false, $step = false, $expanded = false, $idSubtable = false, $flat = false)
    {
        $record = Archiver::FUNNELS_ENTRIES_RECORD;

        if ($flat) {
            $expanded = 1;
        }
        $table = $this->getActionReport($record, $idSite, $period, $date, $idFunnel, $segment, $step, $expanded, $idSubtable, $flat);
        $table->filter('Piwik\Plugins\Funnels\DataTable\Filter\ReplaceEntryLabel');

        return $table;
    }

    /**
     * Get all exit actions for the given funnel at the given step.
     *
     * @param $idSite
     * @param $period
     * @param $date
     * @param $idFunnel
     * @param bool $segment
     * @param bool $step
     * @return DataTable
     */
    public function getFunnelExits($idSite, $period, $date, $idFunnel, $segment = false, $step = false)
    {
        $record = Archiver::FUNNELS_EXITS_RECORD;

        $table = $this->getActionReport($record, $idSite, $period, $date, $idFunnel, $segment, $step);
        $table->filter('Piwik\Plugins\Funnels\DataTable\Filter\CheckForExitUrlsMatchingStep', [$idSite, $idFunnel, $step]);
        $table->filter('Piwik\Plugins\Funnels\DataTable\Filter\ReplaceExitLabel');

        return $table;
    }

    private function getActionReport($record, $idSite, $period, $date, $idFunnel, $segment = false, $step = false, $expanded = false, $idSubtable = false, $flat = false)
    {
        $this->validator->checkReportViewPermission($idSite);
        $funnel = $this->funnels->checkFunnelExists($idSite, $idFunnel);

        $record = Archiver::completeRecordName($record, $idFunnel, $funnel['revision']);

        $root = $this->getDataTable($record, $idSite, $period, $date, $segment, $expanded, $idSubtable, $flat);

        if (!empty($idSubtable)) {
            // a subtable was requested specifically. This is usually the case when fetching the referrers for entries

            return $root;
        }

        if (!empty($step)) {
            if ($root && $root instanceof DataTable\Map) {
                $clone = $root->getEmptyClone();
                foreach ($root->getDataTables() as $label => $table) {
                    $period = $table->getMetadata('period');
                    $periodName = $period->getLabel();
                    $periodDate = $period->getDateStart()->toString();
                    $stepTable = $this->getStepTableFromParentTable(
                        $table,
                        $step,
                        $idSubtable,
                        $record,
                        $idSite,
                        $periodName,
                        $periodDate,
                        $segment,
                        $expanded,
                        $flat
                    );
                    $clone->addTable($stepTable, $label);
                }

                return $clone;
            }
            return $this->getStepTableFromParentTable(
                $root,
                $step,
                $idSubtable,
                $record,
                $idSite,
                $period,
                $date,
                $segment,
                $expanded,
                $flat
            );
        }

        $funnel = $this->funnels->getFunnel($idFunnel);

        $root->filter('Piwik\Plugins\Funnels\DataTable\Filter\ForceSortByStepPosition');
        $root->queueFilter('Piwik\Plugins\Funnels\DataTable\Filter\ReplaceFunnelStepLabel', array($funnel));

        return $root;
    }

    /**
     * @param $recordName
     * @param $idSite
     * @param $period
     * @param $date
     * @param $segment
     * @param $expanded
     * @param $idSubtable
     * @return DataTable
     */
    private function getDataTable($recordName, $idSite, $period, $date, $segment, $expanded, $idSubtable, $flat = false)
    {
        $table = Archive::createDataTableFromArchive($recordName, $idSite, $period, $date, $segment, $expanded, $flat, $idSubtable);

        return $table;
    }

    /**
     * Get funnel information for this goal.
     *
     * @param int $idSite
     * @param int $idGoal
     * @return array|null   Null when no funnel has been configured yet, the funnel otherwise.
     * @throws Exception
     */
    public function getGoalFunnel($idSite, $idGoal)
    {
        $this->validator->checkReportViewPermission($idSite);

        // it is important to not throw an exception if a goal does not exist yet. Otherwise we would see a notification
        // in the Manage Goals UI when a user is editing a goal and has not configured a funnel yet for that goal.
        $this->funnels->checkGoalExists($idSite, $idGoal);

        if (intval($idGoal) === 0) {
            return $this->getSalesFunnelForSite($idSite);
        }

        return $this->funnels->getGoalFunnel($idSite, $idGoal);
    }

    /**
     * Get funnel information for this goal.
     *
     * @param int $idSite
     * @return array|null   Null when no funnel has been configured yet, the funnel otherwise.
     * @throws Exception
     */
    public function getSalesFunnelForSite($idSite)
    {
        $this->validator->checkReportViewPermission($idSite);

        return $this->funnels->getSalesFunnelForSite($idSite);
    }

    /**
     * Get funnel information by ID.
     *
     * @param int $idSite
     * @param int $idFunnel
     * @return array|null   Null when no funnel has been configured yet, the funnel otherwise.
     * @throws Exception
     */
    public function getFunnel(int $idSite, int $idFunnel)
    {
        $this->validator->checkReportViewPermission($idSite);

        $funnel = $this->funnels->getFunnel($idFunnel);
        $this->funnels->checkFunnelMatchesSite($idSite, $funnel);

        return $funnel;
    }

    /**
     * Get activated funnels for the current site.
     * @param int $idSite
     * @return array
     * @hide
     */
    public function getAllActivatedFunnelsForSite($idSite)
    {
        $this->validator->checkReportViewPermission($idSite);

        return $this->funnels->getAllActivatedFunnelsForSite($idSite);
    }

    /**
     * @param $idSite
     * @return bool
     * @hide
     */
    public function hasAnyActivatedFunnelForSite($idSite)
    {
        $this->validator->checkReportViewPermission($idSite);

        return $this->funnels->hasAnyActivatedFunnelForSite($idSite);
    }

    /**
     * Deletes the given goal funnel.
     *
     * @param int $idSite
     * @param int $idGoal
     * @throws Exception
     */
    public function deleteGoalFunnel($idSite, $idGoal)
    {
        $this->validator->checkWritePermission($idSite);

        $idFunnel = $this->funnels->deleteGoalFunnel($idSite, $idGoal);
        if (!empty($idFunnel)) {
            $this->removeInvalidationsSafely($idSite, $idFunnel);
        }
    }

    /**
     * Deletes the given goal funnel.
     *
     * @param int $idSite
     * @param int $idFunnel
     * @throws Exception
     */
    public function deleteNonGoalFunnel(int $idSite, int $idFunnel)
    {
        $this->validator->checkWritePermission($idSite);

        $idFunnel = $this->funnels->deleteNonGoalFunnel($idSite, $idFunnel);
        if (!empty($idFunnel)) {
            $this->removeInvalidationsSafely($idSite, $idFunnel);
        }
    }

    /**
     * Sets (overwrites) a funnel for this goal.
     *
     * @param int $idSite
     * @param int $idGoal
     * @param int $isActivated   "0" or "1". As soon as a funnel is activated, a report will be generated for this funnel
     * @param array $steps   If $isActivated = true, there has to be at least one step
     * @return int   The id of the created or updated funnel
     * @throws Exception
     */
    public function setGoalFunnel($idSite, $idGoal, $isActivated, $steps)
    {
        $this->validator->checkWritePermission($idSite);
        $steps = $this->unsanitizeSteps($steps);
        $this->validator->validateFunnelConfiguration($isActivated, $steps);
        $this->funnels->checkGoalExists($idSite, $idGoal);

        $now = Date::now()->getDatetime();
        $isActivated = !empty($isActivated);

        if (empty($steps)) {
            $steps = array();
        }

        $shouldRearchive = false;
        if ($idSite && $idGoal && $isActivated) {
            $funnel = $this->funnels->getGoalFunnel($idSite, $idGoal);
            if (!empty($funnel['steps']) && $steps != $funnel['steps']) {
                // existing funnel whose steps changed
                $shouldRearchive = true;
            } elseif (empty($funnel)) {
                // new funnel, we always need to rearchive
                $shouldRearchive = true;
            }
        }

        // remove invalidations for the old funnel ID if any are queued so we don't have to re-archive them
        try {
            if ($shouldRearchive) {
                $oldIdFunnel = $this->getIdFunnelForReport($idSite, false, $idGoal);
                $this->removeInvalidationsSafely($idSite, $oldIdFunnel);
            }
        } catch (FunnelNotFoundException $ex) {
            // ignore
        }

        $idFunnel = $this->funnels->setGoalFunnel($idSite, $idGoal, $isActivated, $steps, $now, $shouldRearchive);

        if ($shouldRearchive) {
            $this->scheduleReArchiving($idSite, $idFunnel);
        }

        return $idFunnel;
    }

    /**
     * Saves a funnel not tied to a goal.
     *
     * @param int $idSite
     * @param int $idFunnel ID of the funnel since we can't use the idSite and idGoal to identify it
     * @param string $funnelName The name used to identify the funnel since it's not tied to a goal
     * @param array $steps If $isActivated = true, there has to be at least one step
     * @return int   The id of the created or updated funnel
     * @throws Exception
     */
    public function saveNonGoalFunnel(int $idSite, int $idFunnel, string $funnelName, array $steps): int
    {
        // At this point we aren't going to activate/deactivate funnels, so it's always activated
        $isActivated = true;
        $this->validator->checkWritePermission($idSite);
        $steps = $this->unsanitizeSteps($steps);
        $this->validator->validateFunnelConfiguration($isActivated, $steps);

        $now = Date::now()->getDatetime();
        $isActivated = !empty($isActivated);

        if (empty($steps)) {
            $steps = [];
        }

        $shouldReArchive = $idFunnel === 0;
        // If this is an existing funnel, let's see if the steps have changed
        if (!$shouldReArchive) {
            $funnel = $this->funnels->getFunnel($idFunnel);
            // Check the persisted site ID in case they provided a different site ID in the request
            $this->funnels->checkFunnelMatchesSite($idSite, $funnel);
            if (!empty($funnel['steps']) && $steps != $funnel['steps']) {
                $shouldReArchive = true;
            }
        }

        // remove invalidations for the funnel if any are queued since we're about to schedule re-archiving
        if ($idFunnel > 0) {
            $this->removeInvalidationsSafely($idSite, $idFunnel);
        }

        $idFunnel = $this->funnels->saveNonGoalFunnel($idSite, $idFunnel, $isActivated, $steps, $now, $funnelName, $shouldReArchive);

        if ($shouldReArchive) {
            $this->scheduleReArchiving($idSite, $idFunnel);
        }

        return $idFunnel;
    }

    private function unsanitizeSteps($steps)
    {
        if (!empty($steps) && is_array($steps)) {
            foreach ($steps as $index => $step) {
                if (!empty($step['pattern']) && is_string($step['pattern'])) {
                    $steps[$index]['pattern'] = Common::unsanitizeInputValue($step['pattern']);
                }
            }
        }

        return $steps;
    }

    /**
     * Get a list of available pattern types that can be used to configure a funnel step.
     * @return array
     * @throws Exception
     */
    public function getAvailablePatternMatches()
    {
        $this->validator->checkHasSomeWritePermission();

        return Pattern::getSupportedPatterns();
    }

    /**
     * Tests whether a URL matches any of the step patterns.
     *
     * @param string $url eg 'http://www.example.com/path/dir' or a value for event category, event name, page title, ...
     * @param array $steps eg array(array('pattern_type' => 'path_contains', 'pattern' => 'path/dir'))
     * @return array
     * @throws Exception
     */
    public function testUrlMatchesSteps($url, $steps)
    {
        Piwik::checkUserHasSomeViewAccess();

        if ($url === '' || $url === false || $url === null) {
            return array('url' => '', 'tests' => array());
        }

        if (!is_array($steps)) {
            throw new Exception(Piwik::translate('Funnels_ErrorNotAnArray', 'steps'));
        }

        $url = Common::unsanitizeInputValue($url);
        $steps = $this->unsanitizeSteps($steps);

        $results = array();

        foreach ($steps as $index => $step) {
            $stepInput = new Step($step, $index);
            $stepInput->checkPatternType();
            $stepInput->checkPattern();

            // Not need to make the database call since we can't really validate goals against a URL
            if (Pattern::TYPE_GOAL_EQUALS === $step['pattern_type']) {
                continue;
            }

            $matching = $this->pattern->matchesUrl($url, $step['pattern_type'], $step['pattern']);

            $results[] = array(
                'matches' => $matching,
                'pattern_type' => $step['pattern_type'],
                'pattern' => $step['pattern'],
            );
        }

        return array('url' => $url, 'tests' => $results);
    }

    /**
     * @param DataTable $root
     * @param string $step
     * @param $idSubtable
     * @param string $record
     * @param $idSite
     * @param $period
     * @param $date
     * @param string $segment
     * @param bool $expanded
     * @return DataTable
     */
    private function getStepTableFromParentTable(
        DataTable $root,
        $step,
        $idSubtable,
        $record,
        $idSite,
        $period,
        $date,
        $segment,
        $expanded,
        $flat
    ) {
        $stepRow = $root->getRowFromLabel($step);

        if (!empty($stepRow)) {
            $idSubtable = $stepRow->getIdSubDataTable();
        }

        if (empty($idSubtable)) {
            return new DataTable();
        }

        if ($expanded) {
            $idSubtable = null;
        }
        $stepTable = $this->getDataTable($record, $idSite, $period, $date, $segment, $expanded, $idSubtable, $flat);

        if ($expanded) {
            $stepRow = $stepTable->getRowFromLabel($step);
            $stepTable = $stepRow->getSubtable();
        }


        $stepTable->filter(
            'ColumnCallbackAddMetadata',
            array(
                'label',
                'url',
                function ($label) {
                    if (
                        $label === Archiver::LABEL_NOT_DEFINED
                        || $label === Archiver::LABEL_VISIT_ENTRY
                        || $label === Archiver::LABEL_VISIT_EXIT
                        || $label === DataTable::ID_SUMMARY_ROW
                        || $label === -2
                    ) { // totals row... cannot use constant since the constant was added only in recent versions
                        return false;
                    }

                    return $label;
                },
                $functionParams = null,
                $applyToSummary = false
            )
        );

        return $stepTable;
    }

    /**
     * Calls removeInvalidationsSafely() for all the numeric archive names
     *
     * @param int $idSite
     * @param int $idFunnel
     */
    private function removeInvalidationsSafely(int $idSite, int $idFunnel)
    {
        $funnel = $this->funnels->getFunnel($idFunnel);

        $archiveNames = Archiver::getAllRecordNames($idFunnel, $funnel['revision'] ?? 0);
        foreach ($archiveNames as $archiveName) {
            $this->archiveInvalidator->removeInvalidationsSafely([$idSite], 'Funnels', $archiveName);
        }
    }

    /**
     * Calls scheduleReArchiving() for all the numeric archive names
     *
     * @param int $idSite
     * @param int $idFunnel
     */
    private function scheduleReArchiving(int $idSite, int $idFunnel)
    {
        // Invalidate the funnel options for the site so that the log_funnel records will be rebuilt
        // Since we're invalidating all archives for this funnel, we should also invalidate all options
        StaticContainer::get(LogFunnelOptionLogic::class)->invalidateFunnelOptionsForSite($idSite, true);

        $funnel = $this->funnels->getFunnel($idFunnel);

        $archiveNames = Archiver::getAllRecordNames($idFunnel, $funnel['revision']);
        foreach ($archiveNames as $archiveName) {
            $this->archiveInvalidator->scheduleReArchiving([$idSite], 'Funnels', $archiveName);
        }
    }
}
