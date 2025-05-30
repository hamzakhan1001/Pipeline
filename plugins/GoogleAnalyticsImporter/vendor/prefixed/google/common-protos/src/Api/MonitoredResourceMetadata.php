<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/api/monitored_resource.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Api;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * Auxiliary metadata for a [MonitoredResource][google.api.MonitoredResource]
 * object. [MonitoredResource][google.api.MonitoredResource] objects contain the
 * minimum set of information to uniquely identify a monitored resource
 * instance. There is some other useful auxiliary metadata. Monitoring and
 * Logging use an ingestion pipeline to extract metadata for cloud resources of
 * all types, and store the metadata in this message.
 *
 * Generated from protobuf message <code>google.api.MonitoredResourceMetadata</code>
 */
class MonitoredResourceMetadata extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * Output only. Values for predefined system metadata labels.
     * System labels are a kind of metadata extracted by Google, including
     * "machine_image", "vpc", "subnet_id",
     * "security_group", "name", etc.
     * System label values can be only strings, Boolean values, or a list of
     * strings. For example:
     *     { "name": "my-test-instance",
     *       "security_group": ["a", "b", "c"],
     *       "spot_instance": false }
     *
     * Generated from protobuf field <code>.google.protobuf.Struct system_labels = 1;</code>
     */
    protected $system_labels = null;
    /**
     * Output only. A map of user-defined metadata labels.
     *
     * Generated from protobuf field <code>map<string, string> user_labels = 2;</code>
     */
    private $user_labels;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Protobuf\Struct $system_labels
     *           Output only. Values for predefined system metadata labels.
     *           System labels are a kind of metadata extracted by Google, including
     *           "machine_image", "vpc", "subnet_id",
     *           "security_group", "name", etc.
     *           System label values can be only strings, Boolean values, or a list of
     *           strings. For example:
     *               { "name": "my-test-instance",
     *                 "security_group": ["a", "b", "c"],
     *                 "spot_instance": false }
     *     @type array|\Google\Protobuf\Internal\MapField $user_labels
     *           Output only. A map of user-defined metadata labels.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Api\MonitoredResource::initOnce();
        parent::__construct($data);
    }
    /**
     * Output only. Values for predefined system metadata labels.
     * System labels are a kind of metadata extracted by Google, including
     * "machine_image", "vpc", "subnet_id",
     * "security_group", "name", etc.
     * System label values can be only strings, Boolean values, or a list of
     * strings. For example:
     *     { "name": "my-test-instance",
     *       "security_group": ["a", "b", "c"],
     *       "spot_instance": false }
     *
     * Generated from protobuf field <code>.google.protobuf.Struct system_labels = 1;</code>
     * @return \Google\Protobuf\Struct|null
     */
    public function getSystemLabels()
    {
        return $this->system_labels;
    }
    public function hasSystemLabels()
    {
        return isset($this->system_labels);
    }
    public function clearSystemLabels()
    {
        unset($this->system_labels);
    }
    /**
     * Output only. Values for predefined system metadata labels.
     * System labels are a kind of metadata extracted by Google, including
     * "machine_image", "vpc", "subnet_id",
     * "security_group", "name", etc.
     * System label values can be only strings, Boolean values, or a list of
     * strings. For example:
     *     { "name": "my-test-instance",
     *       "security_group": ["a", "b", "c"],
     *       "spot_instance": false }
     *
     * Generated from protobuf field <code>.google.protobuf.Struct system_labels = 1;</code>
     * @param \Google\Protobuf\Struct $var
     * @return $this
     */
    public function setSystemLabels($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Struct::class);
        $this->system_labels = $var;
        return $this;
    }
    /**
     * Output only. A map of user-defined metadata labels.
     *
     * Generated from protobuf field <code>map<string, string> user_labels = 2;</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getUserLabels()
    {
        return $this->user_labels;
    }
    /**
     * Output only. A map of user-defined metadata labels.
     *
     * Generated from protobuf field <code>map<string, string> user_labels = 2;</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setUserLabels($var)
    {
        $arr = GPBUtil::checkMapField($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::STRING, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::STRING);
        $this->user_labels = $arr;
        return $this;
    }
}
