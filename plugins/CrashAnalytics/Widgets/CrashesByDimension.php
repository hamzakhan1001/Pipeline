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
namespace Piwik\Plugins\CrashAnalytics\Widgets;

use Piwik\Plugins\CoreHome\CoreHome;
use Piwik\Widget\WidgetContainerConfig;

class CrashesByDimension extends WidgetContainerConfig
{
    protected $layout = CoreHome::WIDGET_CONTAINER_LAYOUT_BY_DIMENSION;
    protected $id = 'Crashes';
    protected $categoryId = 'CrashAnalytics_Crashes';
    protected $subcategoryId = 'CrashAnalytics_AllCrashes';
    protected $order = 200;
    protected $isWidgetizable = false;
}
