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
namespace Piwik\Plugins\ActivityLog;

use Piwik\Log;

class Tasks extends \Piwik\Plugin\Tasks
{
    /**
     * @var Model
     */
    private $model;

    /**
     * @var SystemSettings
     */
    private $settings;

    public function __construct(Model $model, SystemSettings $settings)
    {
        $this->model    = $model;
        $this->settings = $settings;
    }

    public function schedule()
    {
        if ($this->settings->ipAnonymize->getValue() > 0) {
            $this->daily('anonymizeIps');
        }
    }

    /**
     * To test execute the following command:
     * `./console core:run-scheduled-tasks "Piwik\Plugins\ActivityLog\Tasks.anonymizeIps"`
     *
     * @throws \Exception
     */
    public function anonymizeIps()
    {
        Log::info(sprintf('Anonymizing IP addresses older than %1$s days', $this->settings->ipAnonymize->getValue()));
        $this->model->anonymizeIps(time() - ($this->settings->ipAnonymize->getValue() + 14) * 86400, time() - $this->settings->ipAnonymize->getValue() * 86400); // anonymize all entries older than X days
    }
}
