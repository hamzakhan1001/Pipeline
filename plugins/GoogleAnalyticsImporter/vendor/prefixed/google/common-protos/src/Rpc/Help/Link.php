<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/rpc/error_details.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Rpc\Help;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * Describes a URL link.
 *
 * Generated from protobuf message <code>google.rpc.Help.Link</code>
 */
class Link extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * Describes what the link offers.
     *
     * Generated from protobuf field <code>string description = 1;</code>
     */
    protected $description = '';
    /**
     * The URL of the link.
     *
     * Generated from protobuf field <code>string url = 2;</code>
     */
    protected $url = '';
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $description
     *           Describes what the link offers.
     *     @type string $url
     *           The URL of the link.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Rpc\ErrorDetails::initOnce();
        parent::__construct($data);
    }
    /**
     * Describes what the link offers.
     *
     * Generated from protobuf field <code>string description = 1;</code>
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Describes what the link offers.
     *
     * Generated from protobuf field <code>string description = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setDescription($var)
    {
        GPBUtil::checkString($var, True);
        $this->description = $var;
        return $this;
    }
    /**
     * The URL of the link.
     *
     * Generated from protobuf field <code>string url = 2;</code>
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
    /**
     * The URL of the link.
     *
     * Generated from protobuf field <code>string url = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setUrl($var)
    {
        GPBUtil::checkString($var, True);
        $this->url = $var;
        return $this;
    }
}
