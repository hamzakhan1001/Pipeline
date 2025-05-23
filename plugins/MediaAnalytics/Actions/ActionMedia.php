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

namespace Piwik\Plugins\MediaAnalytics\Actions;

use Piwik\Common;
use Piwik\Tracker\Action;
use Piwik\Tracker\Request;

class ActionMedia extends Action
{
    public const TYPE_MEDIA = 94;

    public const PARAM_ID_VIEW = 'ma_id';
    public const PARAM_RESOURCE = 'ma_re';
    public const PARAM_MEDIA_TYPE = 'ma_mt';
    public const PARAM_PLAYER_NAME = 'ma_pn';
    public const PARAM_MEDIA_TITLE = 'ma_ti';
    public const PARAM_SPENT_TIME = 'ma_st';
    public const PARAM_PROGRESS = 'ma_ps';
    public const PARAM_MEDIA_LENGTH = 'ma_le';
    public const PARAM_MEDIA_WIDTH = 'ma_w';
    public const PARAM_MEDIA_HEIGHT = 'ma_h';
    public const PARAM_TIME_TO_INITIAL_PLAY = 'ma_ttp';
    public const PARAM_FULLSCREEN = 'ma_fs';
    public const PARAM_SEGMENTS = 'ma_se';

    public function __construct(Request $request)
    {
        parent::__construct(static::TYPE_MEDIA, $request);

        $url = $request->getParam('url');

        $this->setActionUrl($url);
    }

    public static function shouldHandle(Request $request)
    {
        $params = $request->getParams();
        $idView = Common::getRequestVar('ma_id', '', 'string', $params);
        $resource = Common::getRequestVar('ma_re', '', 'string', $params);

        return !empty($idView) && !empty($resource);
    }

    protected function getActionsToLookup()
    {
        return array();
    }

    // Do not track this Event URL as Entry/Exit Page URL (leave the existing entry/exit)
    public function getIdActionUrlForEntryAndExitIds()
    {
        return false;
    }

    // Do not track this Event Name as Entry/Exit Page Title (leave the existing entry/exit)
    public function getIdActionNameForEntryAndExitIds()
    {
        return false;
    }
}
