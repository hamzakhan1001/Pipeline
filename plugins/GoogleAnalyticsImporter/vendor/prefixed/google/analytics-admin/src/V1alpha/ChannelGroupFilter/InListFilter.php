<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1alpha/channel_group.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha\ChannelGroupFilter;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * A filter for a string dimension that matches a particular list of options.
 * The match is case insensitive.
 *
 * Generated from protobuf message <code>google.analytics.admin.v1alpha.ChannelGroupFilter.InListFilter</code>
 */
class InListFilter extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * Required. The list of possible string values to match against. Must be
     * non-empty.
     *
     * Generated from protobuf field <code>repeated string values = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    private $values;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $values
     *           Required. The list of possible string values to match against. Must be
     *           non-empty.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Admin\V1Alpha\ChannelGroup::initOnce();
        parent::__construct($data);
    }
    /**
     * Required. The list of possible string values to match against. Must be
     * non-empty.
     *
     * Generated from protobuf field <code>repeated string values = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getValues()
    {
        return $this->values;
    }
    /**
     * Required. The list of possible string values to match against. Must be
     * non-empty.
     *
     * Generated from protobuf field <code>repeated string values = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setValues($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::STRING);
        $this->values = $arr;
        return $this;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
class_alias(InListFilter::class, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha\ChannelGroupFilter_InListFilter::class);
