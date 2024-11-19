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

        foreach ($table->getRows() as $id => $row) {
            $label = $row->getColumn('label');

            // In March 2024, Google PageSpeed replaced the FID metric with a new INP metric, but
            // their API still returns the FID, so we'll hide it for now until they stop responding with it.
            // Note: With #PG-3040 we tried removing this line, but this required too many changes in tests/Fixtures/log-webvitals.sql
            // Hence we decided to leave this code as it is for tests to pass without much effort
            if ($label == 'max-potential-fid') {
                $table->deleteRow($id);
                continue;
            }

            $row->setMetadata('audit_id', $label);
            $row->setColumn('label', $metrics->getAuditTitle($label));

            $row->setMetadata('audit_description', $metrics->getAuditDescription($label));
        }
    }
}
