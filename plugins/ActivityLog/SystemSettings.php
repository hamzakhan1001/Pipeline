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

use Piwik\Piwik;
use Piwik\Settings\Plugin\SystemSetting;
use Piwik\Settings\FieldConfig;
use Piwik\Validators\NumberRange;

/**
 * Defines Settings for ActivityLog.
 */
class SystemSettings extends \Piwik\Settings\Plugin\SystemSettings
{
    /** @var SystemSetting */
    public $enableGravatar;

    /** @var SystemSetting */
    public $viewPermission;

    /** @var SystemSetting */
    public $ipAnonymize;

    protected function init()
    {
        $this->enableGravatar = $this->createEnableGravatarSetting();
        $this->viewPermission = $this->createViewPermissionSetting();
        $this->ipAnonymize    = $this->createIpAnonymizeSetting();
    }

    private function createEnableGravatarSetting(): SystemSetting
    {
        return $this->makeSetting('enableGravatar', $default = false, FieldConfig::TYPE_BOOL, function (FieldConfig $field) {
            $field->title = Piwik::translate('ActivityLog_EnableGravatar');
            $field->uiControl = FieldConfig::UI_CONTROL_CHECKBOX;
        });
    }

    private function createViewPermissionSetting(): SystemSetting
    {
        return $this->makeSetting('viewPermission', $default = 'view', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = Piwik::translate('ActivityLog_PermissionRequired');
            $field->uiControl = FieldConfig::UI_CONTROL_SINGLE_SELECT;
            $field->availableValues = array(
                'view' => Piwik::translate('ActivityLog_PermissionViewAccess')
            );

            if (ActivityLog::supportsWriteRole()) {
                $field->availableValues['write'] = Piwik::translate('ActivityLog_PermissionWriteAccess');
            }

            $field->availableValues['admin'] = Piwik::translate('ActivityLog_PermissionAdminAccess');
            $field->availableValues['superuser'] = Piwik::translate('ActivityLog_PermissionSuperUserAccess');
            $field->description = Piwik::translate('ActivityLog_PermissionDescription');
        });
    }

    private function createIpAnonymizeSetting(): SystemSetting
    {
        return $this->makeSetting('ipAnonymize', $default = 0, FieldConfig::TYPE_INT, function (FieldConfig $field) {
            $field->title = Piwik::translate('ActivityLog_AnonymizeIpAddresses');
            $field->description = Piwik::translate('ActivityLog_AnonymizeIpAddressesDesc');
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->validators[] = new NumberRange(0);
        });
    }

    public function save()
    {
        // anonymize all older records when value is saved
        if ($this->ipAnonymize->getValue() > 0) {
            $model = new Model();
            $model->anonymizeIps(mktime(0, 0, 0, 01, 01, 2016), time() - $this->ipAnonymize->getValue() * 86400);
        }

        parent::save();
    }
}
