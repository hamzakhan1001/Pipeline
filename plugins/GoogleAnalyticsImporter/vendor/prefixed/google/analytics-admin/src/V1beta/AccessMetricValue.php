<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1beta/access_report.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1beta;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * The value of a metric.
 *
 * Generated from protobuf message <code>google.analytics.admin.v1beta.AccessMetricValue</code>
 */
class AccessMetricValue extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * The measurement value. For example, this value may be '13'.
     *
     * Generated from protobuf field <code>string value = 1;</code>
     */
    private $value = '';
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $value
     *           The measurement value. For example, this value may be '13'.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Admin\V1Beta\AccessReport::initOnce();
        parent::__construct($data);
    }
    /**
     * The measurement value. For example, this value may be '13'.
     *
     * Generated from protobuf field <code>string value = 1;</code>
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
    /**
     * The measurement value. For example, this value may be '13'.
     *
     * Generated from protobuf field <code>string value = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setValue($var)
    {
        GPBUtil::checkString($var, True);
        $this->value = $var;
        return $this;
    }
}
