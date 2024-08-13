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

namespace Piwik\Plugins\CrashAnalytics;

use Piwik\Piwik;
use Piwik\Plugins\CrashAnalytics\Dao\LogCrash;
use Piwik\Settings\FieldConfig;
use Piwik\Settings\Measurable\MeasurableSetting;

class MeasurableSettings extends \Piwik\Settings\Measurable\MeasurableSettings
{
    /** @var MeasurableSetting|null */
    public $daysUntilConsideredDisappeared;

    protected function init()
    {
        $this->daysUntilConsideredDisappeared = $this->makeDaysUntilConsideredDisappearedSetting();
    }

    private function makeDaysUntilConsideredDisappearedSetting()
    {
        $defaultValue = LogCrash::DEFAULT_DAYS_UNTIL_CONSIDERED_DISAPPEARED;
        $type = FieldConfig::TYPE_INT;
 
        return $this->makeSetting('days_until_disappeared', $defaultValue, $type, function (FieldConfig $field) {
            $field->title = Piwik::translate('CrashAnalytics_DaysUntilConsideredDisappeared');
            $field->inlineHelp = Piwik::translate('CrashAnalytics_DaysUntilConsideredDisappearedDescription');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
        });
    }
}
