<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1alpha/analytics_admin.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * Request message for CreateChannelGroup RPC.
 *
 * Generated from protobuf message <code>google.analytics.admin.v1alpha.CreateChannelGroupRequest</code>
 */
class CreateChannelGroupRequest extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * Required. The property for which to create a ChannelGroup.
     * Example format: properties/1234
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    private $parent = '';
    /**
     * Required. The ChannelGroup to create.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1alpha.ChannelGroup channel_group = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    private $channel_group = null;
    /**
     * @param string                                       $parent       Required. The property for which to create a ChannelGroup.
     *                                                                   Example format: properties/1234
     *                                                                   Please see {@see AnalyticsAdminServiceClient::propertyName()} for help formatting this field.
     * @param \Google\Analytics\Admin\V1alpha\ChannelGroup $channelGroup Required. The ChannelGroup to create.
     *
     * @return \Google\Analytics\Admin\V1alpha\CreateChannelGroupRequest
     *
     * @experimental
     */
    public static function build(string $parent, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha\ChannelGroup $channelGroup) : self
    {
        return (new self())->setParent($parent)->setChannelGroup($channelGroup);
    }
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $parent
     *           Required. The property for which to create a ChannelGroup.
     *           Example format: properties/1234
     *     @type \Google\Analytics\Admin\V1alpha\ChannelGroup $channel_group
     *           Required. The ChannelGroup to create.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Admin\V1Alpha\AnalyticsAdmin::initOnce();
        parent::__construct($data);
    }
    /**
     * Required. The property for which to create a ChannelGroup.
     * Example format: properties/1234
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }
    /**
     * Required. The property for which to create a ChannelGroup.
     * Example format: properties/1234
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setParent($var)
    {
        GPBUtil::checkString($var, True);
        $this->parent = $var;
        return $this;
    }
    /**
     * Required. The ChannelGroup to create.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1alpha.ChannelGroup channel_group = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Analytics\Admin\V1alpha\ChannelGroup|null
     */
    public function getChannelGroup()
    {
        return $this->channel_group;
    }
    public function hasChannelGroup()
    {
        return isset($this->channel_group);
    }
    public function clearChannelGroup()
    {
        unset($this->channel_group);
    }
    /**
     * Required. The ChannelGroup to create.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1alpha.ChannelGroup channel_group = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Analytics\Admin\V1alpha\ChannelGroup $var
     * @return $this
     */
    public function setChannelGroup($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha\ChannelGroup::class);
        $this->channel_group = $var;
        return $this;
    }
}
