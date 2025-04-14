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

namespace Piwik\Plugins\Funnels\Categories;

use Piwik\Category\Subcategory;
use Piwik\Piwik;

class FunnelsOverviewSubcategory extends Subcategory
{
    protected $categoryId = 'Funnels_Funnels';
    protected $id = 'General_Overview';
    protected $order = 5;

    public function getHelp()
    {
        return '<p>' . Piwik::translate('Funnels_FunnelsOverviewSubcategoryHelp1') . '</p>';
    }
}
