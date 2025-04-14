<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1alpha/analytics_admin.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * Request message for GetIosAppDataStream RPC.
 *
 * Generated from protobuf message <code>google.analytics.admin.v1alpha.GetIosAppDataStreamRequest</code>
 */
class GetIosAppDataStreamRequest extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * Required. The name of the iOS app data stream to lookup.
     * Format: properties/{property_id}/iosAppDataStreams/{stream_id}
     * Example: "properties/123/iosAppDataStreams/456"
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    private $name = '';
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Required. The name of the iOS app data stream to lookup.
     *           Format: properties/{property_id}/iosAppDataStreams/{stream_id}
     *           Example: "properties/123/iosAppDataStreams/456"
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Admin\V1Alpha\AnalyticsAdmin::initOnce();
        parent::__construct($data);
    }
    /**
     * Required. The name of the iOS app data stream to lookup.
     * Format: properties/{property_id}/iosAppDataStreams/{stream_id}
     * Example: "properties/123/iosAppDataStreams/456"
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Required. The name of the iOS app data stream to lookup.
     * Format: properties/{property_id}/iosAppDataStreams/{stream_id}
     * Example: "properties/123/iosAppDataStreams/456"
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;
        return $this;
    }
}
