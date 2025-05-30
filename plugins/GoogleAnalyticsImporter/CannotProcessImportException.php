<?php

/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\GoogleAnalyticsImporter;

class CannotProcessImportException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
