<?php

/**
 * Skeleton Test class file for Application group
 *
 * @package PhpSecInfo
 * @author Anthon Pang
 */

use Piwik\Http;

/**
 * require the main PhpSecInfo class
 */
require_once(PHPSECINFO_BASE_DIR . '/Test/Test.php');


/**
 * This is a skeleton class for PhpSecInfo "Application" tests
 * @package PhpSecInfo
 */
class PhpSecInfo_Test_Application extends PhpSecInfo_Test
{
    /**
     * This value is used to group test results together.
     *
     * For example, all tests related to the mysql lib should be grouped under "mysql."
     *
     * @var string
     */
    public $test_group = 'Application';


    /**
     * "Application" tests should pretty much be always testable, so the default is just to return true
     *
     * @return boolean
     */
    public function isTestable()
    {
        return Http::getTransportMethod() !== null;
    }

    public function getMoreInfoURL()
    {
        $urls = array(
            'Piwik' => 'http://piwik.org/changelog',
            'Matomo' => 'http://piwik.org/changelog',
            'PHP'   => 'http://php.net/',
        );

        if ($tn = $this->getTestName()) {
            return $urls[$tn];
        } else {
            return false;
        }
    }
}
