<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

namespace Piwik\Plugins\SEOWebVitals\DataTable\Filter;

use Piwik\DataTable\BaseFilter;
use Piwik\DataTable;
use Piwik\Tracker\PageUrl;

class ShortenUrl extends BaseFilter
{
    public function __construct($table)
    {
        parent::__construct($table);
    }

    /**
     * @param DataTable $table
     */
    public function filter($table)
    {
        foreach ($table->getRows() as $row) {
            $label = $row->getColumn('label');
            $row->setColumn('label', str_replace(array_keys(PageUrl::$urlPrefixMap), '', $label));
            $row->setMetadata('url', $label);
        }
    }
}
