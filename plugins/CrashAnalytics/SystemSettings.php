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
use Piwik\Plugins\Live\Live;
use Piwik\Settings\FieldConfig;
use Piwik\Settings\Plugin\SystemSetting;
use Piwik\Settings\Setting;

class SystemSettings extends \Piwik\Settings\Plugin\SystemSettings
{
    const DEFAULT_VERSIONING_PARAMS = [
        'v', 'ver', 'version', 'cachebuster', 'cb', 'timestamp', 'ts', 'rnd',
        'random', 'rev', 'revision', 'build', 'b', 'id', 'ref',
    ];

    /**
     * Note: if the visitor log is not enabled, this property will be null.
     *
     * @var Setting|null
     */
    public $disableCrashContext;

    /**
     * @var Setting
     */
    public $versioningUrlParameters;

    /**
     * @var Setting
     */
    public $groupHashedSourceFiles;

    protected function init()
    {
        $this->title = Piwik::translate('CrashAnalytics_CrashAnalytics');

        $this->versioningUrlParameters = $this->createVersioningUrlParametersSetting();
        $this->groupHashedSourceFiles = $this->createGroupHashedSourceFilesSetting();

        if (!Live::isVisitorLogEnabled()) {
            $isWritable = Piwik::hasUserSuperUserAccess();
            $this->disableCrashContext = $this->createDisableCrashContextSetting();
            $this->disableCrashContext->setIsWritableByCurrentUser($isWritable);
        }
    }

    private function createVersioningUrlParametersSetting(): SystemSetting
    {
        return $this->makeSetting('versioning_url_params', self::DEFAULT_VERSIONING_PARAMS, FieldConfig::TYPE_ARRAY, function (FieldConfig $field) {
            $field->title = Piwik::translate('CrashAnalytics_VersioningUrlParams');
            $field->inlineHelp = Piwik::translate('CrashAnalytics_VersioningUrlParamsDesc') . '<br/><br/>'
                . Piwik::translate('General_Default') . ': '  . implode(', ', self::DEFAULT_VERSIONING_PARAMS);
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
        });
    }

    private function createDisableCrashContextSetting(): SystemSetting
    {
        return $this->makeSetting('disable_crash_context', false, FieldConfig::TYPE_BOOL, function (FieldConfig $field) {
            $field->title = Piwik::translate('CrashAnalytics_DisableCrashContext');
            $field->inlineHelp = Piwik::translate('CrashAnalytics_DisableCrashContextHelp');
            $field->uiControl = FieldConfig::UI_CONTROL_CHECKBOX;
        });
    }

    private function createGroupHashedSourceFilesSetting(): SystemSetting
    {
        return $this->makeSetting('group_hashed_source_files', false, FieldConfig::TYPE_BOOL, function (FieldConfig $field) {
            $field->title = Piwik::translate('CrashAnalytics_GroupHashSourceFiles');
            $field->inlineHelp = Piwik::translate('CrashAnalytics_GroupHashSourceFilesHelp1') . '<br/><br/>'
                . Piwik::translate('CrashAnalytics_GroupHashSourceFilesHelp2');
            $field->uiControl = FieldConfig::UI_CONTROL_CHECKBOX;
        });
    }
}
