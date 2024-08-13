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
use Piwik\Plugins\SEOWebVitals\Metrics;
use Piwik\Plugins\SEOWebVitals\SEOWebVitals;

class Audits extends BaseFilter
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
        $metrics = new Metrics();

        foreach ($table->getRows() as $row) {
            $label = $row->getColumn('label');
            $row->setMetadata('audit_id', $label);
            $row->setColumn('label', $metrics->getAuditTitle($label));

            $row->setMetadata('audit_description', $metrics->getAuditDescription($label));
        }
    }
}
