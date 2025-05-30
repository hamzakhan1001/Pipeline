<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/api/config_change.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Api;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * Generated advice about this change, used for providing more
 * information about how a change will affect the existing service.
 *
 * Generated from protobuf message <code>google.api.Advice</code>
 */
class Advice extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * Useful description for why this advice was applied and what actions should
     * be taken to mitigate any implied risks.
     *
     * Generated from protobuf field <code>string description = 2;</code>
     */
    protected $description = '';
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $description
     *           Useful description for why this advice was applied and what actions should
     *           be taken to mitigate any implied risks.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Api\ConfigChange::initOnce();
        parent::__construct($data);
    }
    /**
     * Useful description for why this advice was applied and what actions should
     * be taken to mitigate any implied risks.
     *
     * Generated from protobuf field <code>string description = 2;</code>
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Useful description for why this advice was applied and what actions should
     * be taken to mitigate any implied risks.
     *
     * Generated from protobuf field <code>string description = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setDescription($var)
    {
        GPBUtil::checkString($var, True);
        $this->description = $var;
        return $this;
    }
}
