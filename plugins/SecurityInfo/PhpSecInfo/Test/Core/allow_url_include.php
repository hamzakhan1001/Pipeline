<?php

/**
 * Test Class for allow_url_include
 *
 * @package PhpSecInfo
 * @author Ed Finkler <coj@funkatron.com>
 */

/**
 * require the PhpSecInfo_Test_Core class
 */
require_once(PHPSECINFO_BASE_DIR . '/Test/Test_Core.php');

/**
 * Test Class for allow_url_include
 *
 * @package PhpSecInfo
 *
 *
 */
class PhpSecInfo_Test_Core_Allow_Url_Include extends PhpSecInfo_Test_Core
{
    /**
     * This should be a <b>unique</b>, human-readable identifier for this test
     *
     * @var string
     */
    public $test_name = "allow_url_include";


    public $recommended_value = false;


    public function _retrieveCurrentValue()
    {
        $this->current_value = $this->getBooleanIniValue('allow_url_include');
    }


    /**
     * Checks to see if allow_url_fopen is enabled
     */
    public function _execTest()
    {
        if ($this->current_value == $this->recommended_value) {
            return PHPSECINFO_TEST_RESULT_OK;
        }

        return PHPSECINFO_TEST_RESULT_WARN;
    }


    /**
     * allow_url_include is only available since PHP 5.2
     *
     * @return boolean
     */
    public function isTestable()
    {
        return version_compare(PHP_VERSION, '5.2', '>=');
    }


    /**
     * Set the messages specific to this test
     */
    public function _setMessages()
    {
        parent::_setMessages();

        $this->setMessageForResult(PHPSECINFO_TEST_RESULT_NOTRUN, 'en', 'You are running a version of PHP older than 5.2, and allow_url_include is not available');
        $this->setMessageForResult(PHPSECINFO_TEST_RESULT_OK, 'en', 'allow_url_include is disabled, which is the recommended setting');
        $link = '<a href="http://php.net/manual/en/ref.curl.php" rel="noreferrer"  target="_blank">PHP cURL functions</a>';
        $this->setMessageForResult(
            PHPSECINFO_TEST_RESULT_WARN,
            'en',
            "allow_url_include is enabled.  This could be a serious security risk.  You should disable allow_url_include and consider using the $link instead."
        );
    }
}
