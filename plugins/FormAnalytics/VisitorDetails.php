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

namespace Piwik\Plugins\FormAnalytics;

use Piwik\Common;
use Piwik\Config;
use Piwik\Date;
use Piwik\DbHelper;
use Piwik\Piwik;
use Piwik\Plugins\FormAnalytics\Model\FormsModel;
use Piwik\Plugins\Live\Model;
use Piwik\Plugins\Live\VisitorDetailsAbstract;
use Piwik\View;

class VisitorDetails extends VisitorDetailsAbstract
{
    public const FORM_TYPE      = 'form';

    protected $formConversions = [];

    /**
     * @internal tests only
     * @var bool
     */
    public $forceSleepInQueryLogForm = false;

    /**
     * @internal tests only
     * @var bool
     */
    public $forceSleepInQueryLogLink = false;

    public function extendVisitorDetails(&$visitor)
    {
        if (!array_key_exists($visitor['idVisit'], $this->formConversions)) {
            $this->queryFormInteractionsForVisitIds([$visitor['idVisit']]);
        }

        $visitor['formConversions'] = isset($this->formConversions[$visitor['idVisit']]) ? $this->formConversions[$visitor['idVisit']] : 0;
    }

    public function provideActionsForVisitIds(&$actions, $visitIds)
    {
        $formDetails = $this->queryFormInteractionsForVisitIds($visitIds);

        // use while / array_shift combination instead of foreach to save memory
        while (is_array($formDetails) && count($formDetails)) {
            $action = array_shift($formDetails);
            $idVisit = $action['idvisit'];
            unset($action['idvisit']);
            $actions[$idVisit][] = $action;
        }

        foreach ($visitIds as $visitId) {
            if (!isset($this->formConversions[$visitId])) {
                $this->formConversions[$visitId] = 0;
            }
        }
    }

    public function renderAction($action, $previousAction, $visitorDetails)
    {
        if ($action['type'] != self::FORM_TYPE) {
            return;
        }

        $view = new View('@FormAnalytics/_actionForm.twig');
        $view->action = $action;
        $view->previousAction = $previousAction;
        $view->visitInfo = $visitorDetails;
        $view->isWidgetized = Common::getRequestVar('widget', 0, 'int');
        return $view->render();
    }

    public function renderActionTooltip($action, $visitInfo)
    {
        if ($action['type'] != self::FORM_TYPE) {
            return [];
        }

        $view         = new View('@FormAnalytics/_actionTooltip');
        $view->action = $action;
        return [[ 100, $view->render() ]];
    }

    public function renderIcons($visitorDetails)
    {
        if (empty($visitorDetails['formConversions'])) {
            return '';
        }

        $view         = new View('@FormAnalytics/_visitorLogIcons');
        $view->formConversions = $visitorDetails['formConversions'];
        return $view->render();
    }

    public function initProfile($visits, &$profile)
    {
        $profile['uniqueFormConversions']   = 0;
        $profile['totalConversionsByForm'] = array();
    }

    public function handleProfileAction($action, &$profile)
    {
        if ($action['type'] != self::FORM_TYPE || empty($action['converted'])) {
            return;
        }

        $idForm    = $action['formId'];

        if (!isset($profile['totalConversionsByForm'][$idForm])) {
            $profile['totalConversionsByForm'][$idForm] = 0;
        }
        ++$profile['totalConversionsByForm'][$idForm];
    }

    public function finalizeProfile($visits, &$profile)
    {
        $profile['uniqueFormConversions'] = count($profile['totalConversionsByForm']);
    }

    /**
     * @param $visitIds
     * @return array
     * @throws \Exception
     */
    protected function queryFormInteractionsForVisitIds($visitIds)
    {
        if (empty($visitIds)) {
            return;
        }

        $extraWhere = '';
        if ($this->forceSleepInQueryLogForm) {
            $extraWhere = 'SLEEP(1) AND';
        }

        $visitIds = array_map('intval', $visitIds);
        $limit = (int)Config::getInstance()->General['visitor_log_maximum_actions_per_visit'] * count($visitIds);
        $sql = sprintf("SELECT /* FormAnalytics.queryFormInteractionsForVisitIds */
                        log_form.idvisit,
                        log_form.num_submissions,
                        log_form.num_starts,
                        log_form.time_spent AS time_spent_form,
                        log_form.time_hesitation AS time_hesitation_form,
                        log_form.form_last_action_time AS server_time,
                        site_form.name AS form_name,
                        site_form.idsiteform AS form_id,
                        site_form.status AS form_status,
                        log_form_field.idlogform,
                        log_form_field.idpageview,
                        log_form_field.field_name,
                        log_form_field.time_spent,
                        log_form_field.time_hesitation,
                        log_form_field.left_blank,
                        log_form_field.submitted,
                        log_form.converted,
                        log_form.time_to_first_submission,
						log_form.form_last_action_time AS server_time
					FROM " . Common::prefixTable('log_form') . " AS log_form
					LEFT JOIN " . Common::prefixTable('site_form') . " AS site_form
						ON log_form.idsiteform = site_form.idsiteform
					LEFT JOIN " . Common::prefixTable('log_form_field') . " AS log_form_field
						ON log_form.idlogform = log_form_field.idlogform
					WHERE $extraWhere log_form.idvisit IN (%s) AND log_form.time_spent > 0 AND site_form.status != '" . FormsModel::STATUS_DELETED . "'
					LIMIT 0, $limit", implode(",", $visitIds));

        $sql = DbHelper::addMaxExecutionTimeHintToQuery($sql, $this->getLiveQueryMaxExecutionTime());
        $db = $this->getDb();

        try {
            $fieldInteractions = $db->fetchAll($sql);
        } catch (\Exception $e) {
            Model::handleMaxExecutionTimeError($db, $e, '', Date::now(), Date::now(), null, 0, ['sql' => $sql]);
            throw $e;
        }

        $formInteractions = [];
        $pageviewsToLookUp = [];
        $uniqueIdLogForm = [];

        $idVisitsWithMultipleFormSubmissionsOnSameForm = [];

        foreach ($fieldInteractions as $fieldInteraction) {
            if (empty($fieldInteraction['idpageview'])) {
                // form view only (no field interactions)
                continue;
            }

            $idVisit = $fieldInteraction['idvisit'];

            if (
                $fieldInteraction['num_starts'] > 1
                && $fieldInteraction['num_submissions'] > 1
                && !isset($idVisitsWithMultipleFormSubmissionsOnSameForm[$idVisit])
            ) {
                $idVisitsWithMultipleFormSubmissionsOnSameForm[$idVisit] = $idVisit;
            }

            $formId   = $fieldInteraction['idpageview'] . $fieldInteraction['idlogform'];

            if (empty($formInteractions[$formId])) {
                $formInteractions[$formId] = [
                    'idvisit' => $idVisit,
                    'type' => self::FORM_TYPE,
                    'icon' => 'plugins/FormAnalytics/images/form.png',
                    'idpageview' => $fieldInteraction['idpageview'],
                    'title' => Piwik::translate('FormAnalytics_InteractedWithFormX', $fieldInteraction['form_name']),
                    'formName' => $fieldInteraction['form_name'],
                    'formId' => $fieldInteraction['form_id'],
                    'formStatus' => $fieldInteraction['form_status'],
                    'converted' => $fieldInteraction['converted'],
                    'submitted' => 0,
                    'serverTimePretty' => $fieldInteraction['server_time'], // will be overwritten by server_time of page view action later under circumstances if the form was submitted multiple times
                    'idlink_va' => $fieldInteraction['idlogform'], // for sorting
                    'timeToFirstSubmission' => $fieldInteraction['time_to_first_submission'],
                    'timeSpent' => $fieldInteraction['time_spent_form'],
                    'timeHesitation' => $fieldInteraction['time_hesitation_form'],
                    'leftBlank' => 0,
                    'fields' => []
                ];

                $pageviewsToLookUp[$fieldInteraction['idpageview']] = true;

                if (!isset($this->formConversions[$fieldInteraction['idvisit']])) {
                    $this->formConversions[$fieldInteraction['idvisit']] = 0;
                }

                //Only consider unique idlogform to count formConversions as the count gets inflated due to join of log_form with log_form_field table
                if (!isset($uniqueIdLogForm[$fieldInteraction['idlogform']])) {
                    $uniqueIdLogForm[$fieldInteraction['idlogform']] = 1;
                    $this->formConversions[$fieldInteraction['idvisit']] += $fieldInteraction['converted'];
                }
            }

            $formInteractions[$formId]['fields'][] = [
                'fieldName' => $fieldInteraction['field_name'],
                'timeSpent' => $fieldInteraction['time_spent'],
                'timeHesitation' => $fieldInteraction['time_hesitation'],
                'leftBlank' => $fieldInteraction['left_blank'],
                'submitted' => $fieldInteraction['submitted'],
            ];

            $formInteractions[$formId]['leftBlank'] += $fieldInteraction['left_blank'];

            if ($fieldInteraction['submitted']) {
                $formInteractions[$formId]['submitted'] = 1;
                $formInteractions[$formId]['title'] = Piwik::translate('FormAnalytics_SubmittedFormX', $fieldInteraction['form_name']);
            }
        }

        unset($fieldInteractions);

        if (!empty($idVisitsWithMultipleFormSubmissionsOnSameForm)) {
            // We've been modifying below part a few times trying to get it fast. for example in
            // https://github.com/innocraft/plugin-FormAnalytics/pull/135/files and
            // https://github.com/innocraft/plugin-FormAnalytics/pull/115/files and
            // https://github.com/innocraft/plugin-FormAnalytics/pull/146/files

            // Eventually, we figured out that in most cases below query does not need to be executed.
            // It only needs to be executed for visits where there were 2 form submissions on 2 different pages.
            // That's because by default we read the last form action time from `log_form` but a user may have interacted
            // on a form on 2 different page views. If we only relied on that time, then both actions in the visits log
            // would show the same time stamp which is incorrect. Because we don't have the server_time stored per `log_form_page`,
            // in this edge case we fall back to the server_time of the page aka the form submission will be attributed to the
            // time when the page was viewed.

            // note that the server_time (the time the page was loaded) may not be accurate either because a user might have only started
            // interacting with the form minutes after the page has loaded. we could potentially make it a little bit more accurate
            // by adding form `time_hesitation` and `time_spent` to it etc but not needed for now

            // further above in code you're seeing this check `$fieldInteraction['num_starts'] > 1 && $fieldInteraction['num_submissions'] > 1`
            // technically, we would need to execute this already for visits even only if they only `started > 1 && submissions > 0` as they
            // may start a form, submit it, then start a form again 20min later and then the `form_last_action_time` we attribute to the submission
            // will be too late as it be the server_time when they interacted the second time (unless the form was also converted in first submission
            // in which case `form_last_action_time` is correct or unless the form was started, then started again and then submitted in which case it is
            // also correct). In most cases it'll be more correct to use the `form_last_action_time` and it'll be faster this way to execute below
            // query for less visits.

            // If we wanted this more accurate we would be likely needing a `server_time` column on `log_form_field` but this would be storing
            // a lot more data for maybe little benefit (for now). Although even then we still wouldn't really know when exactly the form was submitted.

            // below we query for visits that started the form twice (meaning there was a page reload in between) and submitted
            // the form to try and get a server_time that may not be more accurate but makes a bit more "sense" in some cases
            // in the timeline of the visits log
            $idVisitsWithFormConversions = implode(',', array_map('intval', $idVisitsWithMultipleFormSubmissionsOnSameForm));

            $extraWhere = '';
            if ($this->forceSleepInQueryLogLink) {
                $extraWhere = 'SLEEP(1) AND';
            }

            // we fetch all idPageviews as otherwise the query would be getting too slow if we only fetched the needed idPageview.
            // rather we fetch a few more actions than having a slow query as we can scale php easily but not mysql
            // we exclude events and content tracking requests to speed up things a little
            $sqlPageViews = sprintf("SELECT /* FormAnalytics.queryFormInteractionsForVisitIds */
                                        log_link_visit_action.idvisit,
                                        log_link_visit_action.idpageview,
                                        log_link_visit_action.server_time
                                    FROM " . Common::prefixTable('log_link_visit_action') . " AS log_link_visit_action
                                    WHERE $extraWhere log_link_visit_action.idvisit IN (%s) 
                                        and idpageview != ''
                                         and idaction_event_category is null and idaction_content_name is null", $idVisitsWithFormConversions);

            $sqlPageViews = DbHelper::addMaxExecutionTimeHintToQuery($sqlPageViews, $this->getLiveQueryMaxExecutionTime());
            $pageViews = [];

            try {
                $rows = $db->fetchAll($sqlPageViews, []);
            } catch (\Exception $e) {
                Model::handleMaxExecutionTimeError($db, $e, '', Date::now(), Date::now(), null, 0, ['sql' => $sqlPageViews]);
                throw $e;
            }

            // use while / array_shift combination instead of foreach to save memory
            while (is_array($rows) && count($rows)) {
                $row = array_shift($rows);
                if (isset($pageviewsToLookUp[$row['idpageview']])) {
                    $pageViews[$row['idvisit']][$row['idpageview']] = [
                        'server_time' => $row['server_time'],
                    ];
                }
            }

            unset($rows);

            // combine actions values for form interactions

            foreach ($formInteractions as &$formInteraction) {
                if (isset($pageViews[$formInteraction['idvisit']][$formInteraction['idpageview']])) {
                    $pageview = $pageViews[$formInteraction['idvisit']][$formInteraction['idpageview']];
                    $formInteraction['serverTimePretty'] = $pageview['server_time'];
                }
            }
        }

        return $formInteractions;
    }

    private function getLiveQueryMaxExecutionTime()
    {
        return Config::getInstance()->General['live_query_max_execution_time'];
    }
}
