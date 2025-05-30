<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1alpha/analytics_admin.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * Response for looking up GA4 property connected to a UA property.
 *
 * Generated from protobuf message <code>google.analytics.admin.v1alpha.FetchConnectedGa4PropertyResponse</code>
 */
class FetchConnectedGa4PropertyResponse extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * The GA4 property connected to the UA property. An empty string is returned
     * when there is no connected GA4 property.
     * Format: properties/{property_id}
     * Example: properties/1234
     *
     * Generated from protobuf field <code>string property = 1 [(.google.api.resource_reference) = {</code>
     */
    private $property = '';
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $property
     *           The GA4 property connected to the UA property. An empty string is returned
     *           when there is no connected GA4 property.
     *           Format: properties/{property_id}
     *           Example: properties/1234
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Admin\V1Alpha\AnalyticsAdmin::initOnce();
        parent::__construct($data);
    }
    /**
     * The GA4 property connected to the UA property. An empty string is returned
     * when there is no connected GA4 property.
     * Format: properties/{property_id}
     * Example: properties/1234
     *
     * Generated from protobuf field <code>string property = 1 [(.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getProperty()
    {
        return $this->property;
    }
    /**
     * The GA4 property connected to the UA property. An empty string is returned
     * when there is no connected GA4 property.
     * Format: properties/{property_id}
     * Example: properties/1234
     *
     * Generated from protobuf field <code>string property = 1 [(.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setProperty($var)
    {
        GPBUtil::checkString($var, True);
        $this->property = $var;
        return $this;
    }
}
