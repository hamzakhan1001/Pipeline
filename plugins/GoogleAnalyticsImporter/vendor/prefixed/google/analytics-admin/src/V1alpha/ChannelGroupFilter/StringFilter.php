<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1alpha/channel_group.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha\ChannelGroupFilter;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * Filter where the field value is a String. The match is case insensitive.
 *
 * Generated from protobuf message <code>google.analytics.admin.v1alpha.ChannelGroupFilter.StringFilter</code>
 */
class StringFilter extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * Required. The match type for the string filter.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1alpha.ChannelGroupFilter.StringFilter.MatchType match_type = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    private $match_type = 0;
    /**
     * Required. The string value to be matched against.
     *
     * Generated from protobuf field <code>string value = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    private $value = '';
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $match_type
     *           Required. The match type for the string filter.
     *     @type string $value
     *           Required. The string value to be matched against.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Admin\V1Alpha\ChannelGroup::initOnce();
        parent::__construct($data);
    }
    /**
     * Required. The match type for the string filter.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1alpha.ChannelGroupFilter.StringFilter.MatchType match_type = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return int
     */
    public function getMatchType()
    {
        return $this->match_type;
    }
    /**
     * Required. The match type for the string filter.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1alpha.ChannelGroupFilter.StringFilter.MatchType match_type = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param int $var
     * @return $this
     */
    public function setMatchType($var)
    {
        GPBUtil::checkEnum($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha\ChannelGroupFilter\StringFilter\MatchType::class);
        $this->match_type = $var;
        return $this;
    }
    /**
     * Required. The string value to be matched against.
     *
     * Generated from protobuf field <code>string value = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
    /**
     * Required. The string value to be matched against.
     *
     * Generated from protobuf field <code>string value = 2 [(.google.api.field_behavior) = REQUIRED];</code>
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
// Adding a class alias for backwards compatibility with the previous class name.
class_alias(StringFilter::class, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha\ChannelGroupFilter_StringFilter::class);
