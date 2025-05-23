<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1alpha/analytics_admin.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * Request message for GetRollupPropertySourceLink RPC.
 *
 * Generated from protobuf message <code>google.analytics.admin.v1alpha.GetRollupPropertySourceLinkRequest</code>
 */
class GetRollupPropertySourceLinkRequest extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * Required. The name of the roll-up property source link to lookup.
     * Format:
     * properties/{property_id}/rollupPropertySourceLinks/{rollup_property_source_link_id}
     * Example: properties/123/rollupPropertySourceLinks/456
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    private $name = '';
    /**
     * @param string $name Required. The name of the roll-up property source link to lookup.
     *                     Format:
     *                     properties/{property_id}/rollupPropertySourceLinks/{rollup_property_source_link_id}
     *                     Example: properties/123/rollupPropertySourceLinks/456
     *                     Please see {@see AnalyticsAdminServiceClient::rollupPropertySourceLinkName()} for help formatting this field.
     *
     * @return \Google\Analytics\Admin\V1alpha\GetRollupPropertySourceLinkRequest
     *
     * @experimental
     */
    public static function build(string $name) : self
    {
        return (new self())->setName($name);
    }
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Required. The name of the roll-up property source link to lookup.
     *           Format:
     *           properties/{property_id}/rollupPropertySourceLinks/{rollup_property_source_link_id}
     *           Example: properties/123/rollupPropertySourceLinks/456
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Admin\V1Alpha\AnalyticsAdmin::initOnce();
        parent::__construct($data);
    }
    /**
     * Required. The name of the roll-up property source link to lookup.
     * Format:
     * properties/{property_id}/rollupPropertySourceLinks/{rollup_property_source_link_id}
     * Example: properties/123/rollupPropertySourceLinks/456
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Required. The name of the roll-up property source link to lookup.
     * Format:
     * properties/{property_id}/rollupPropertySourceLinks/{rollup_property_source_link_id}
     * Example: properties/123/rollupPropertySourceLinks/456
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
