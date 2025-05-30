<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/data/v1alpha/analytics_data_api.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * A request to retrieve configuration metadata about a specific recurring
 * audience list.
 *
 * Generated from protobuf message <code>google.analytics.data.v1alpha.GetRecurringAudienceListRequest</code>
 */
class GetRecurringAudienceListRequest extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * Required. The recurring audience list resource name.
     * Format:
     * `properties/{property}/recurringAudienceLists/{recurring_audience_list}`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    private $name = '';
    /**
     * @param string $name Required. The recurring audience list resource name.
     *                     Format:
     *                     `properties/{property}/recurringAudienceLists/{recurring_audience_list}`
     *                     Please see {@see AlphaAnalyticsDataClient::recurringAudienceListName()} for help formatting this field.
     *
     * @return \Google\Analytics\Data\V1alpha\GetRecurringAudienceListRequest
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
     *           Required. The recurring audience list resource name.
     *           Format:
     *           `properties/{property}/recurringAudienceLists/{recurring_audience_list}`
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Data\V1Alpha\AnalyticsDataApi::initOnce();
        parent::__construct($data);
    }
    /**
     * Required. The recurring audience list resource name.
     * Format:
     * `properties/{property}/recurringAudienceLists/{recurring_audience_list}`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Required. The recurring audience list resource name.
     * Format:
     * `properties/{property}/recurringAudienceLists/{recurring_audience_list}`
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
