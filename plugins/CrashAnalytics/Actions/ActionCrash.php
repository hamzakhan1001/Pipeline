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

namespace Piwik\Plugins\CrashAnalytics\Actions;

use Piwik\Plugins\CrashAnalytics\Tracker\RequestProcessor;
use Piwik\Tracker\Action;
use Piwik\Tracker\Request;

class ActionCrash extends Action
{
    const TYPE_CRASH = 110;

    public function __construct(Request $request)
    {
        parent::__construct(self::TYPE_CRASH, $request);
    }

    public static function shouldHandle(Request $request)
    {
        $params = $request->getParams();
        return !empty($params[RequestProcessor::TRACKING_PARAM_ERROR_MESSAGE]);
    }

    protected function getActionsToLookup()
    {
        return []; // this is just a dummy Action class so we can use the `ca=1` parameter
    }
}