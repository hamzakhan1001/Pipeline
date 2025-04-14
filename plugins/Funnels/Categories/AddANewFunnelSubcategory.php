<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

namespace Piwik\Plugins\Funnels\Categories;

use Piwik\Category\Subcategory;

class AddANewFunnelSubcategory extends Subcategory
{
    protected $categoryId = 'Funnels_Funnels';
    protected $id = 'Funnels_AddNewFunnel';
    protected $order = 9999;
}
