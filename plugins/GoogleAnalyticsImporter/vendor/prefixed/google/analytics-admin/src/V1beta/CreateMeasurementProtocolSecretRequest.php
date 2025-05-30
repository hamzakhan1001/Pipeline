<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1beta/analytics_admin.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1beta;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * Request message for CreateMeasurementProtocolSecret RPC
 *
 * Generated from protobuf message <code>google.analytics.admin.v1beta.CreateMeasurementProtocolSecretRequest</code>
 */
class CreateMeasurementProtocolSecretRequest extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * Required. The parent resource where this secret will be created.
     * Format: properties/{property}/dataStreams/{dataStream}
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    private $parent = '';
    /**
     * Required. The measurement protocol secret to create.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1beta.MeasurementProtocolSecret measurement_protocol_secret = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    private $measurement_protocol_secret = null;
    /**
     * @param string                                                   $parent                    Required. The parent resource where this secret will be created.
     *                                                                                            Format: properties/{property}/dataStreams/{dataStream}
     *                                                                                            Please see {@see AnalyticsAdminServiceClient::dataStreamName()} for help formatting this field.
     * @param \Google\Analytics\Admin\V1beta\MeasurementProtocolSecret $measurementProtocolSecret Required. The measurement protocol secret to create.
     *
     * @return \Google\Analytics\Admin\V1beta\CreateMeasurementProtocolSecretRequest
     *
     * @experimental
     */
    public static function build(string $parent, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1beta\MeasurementProtocolSecret $measurementProtocolSecret) : self
    {
        return (new self())->setParent($parent)->setMeasurementProtocolSecret($measurementProtocolSecret);
    }
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $parent
     *           Required. The parent resource where this secret will be created.
     *           Format: properties/{property}/dataStreams/{dataStream}
     *     @type \Google\Analytics\Admin\V1beta\MeasurementProtocolSecret $measurement_protocol_secret
     *           Required. The measurement protocol secret to create.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Admin\V1Beta\AnalyticsAdmin::initOnce();
        parent::__construct($data);
    }
    /**
     * Required. The parent resource where this secret will be created.
     * Format: properties/{property}/dataStreams/{dataStream}
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }
    /**
     * Required. The parent resource where this secret will be created.
     * Format: properties/{property}/dataStreams/{dataStream}
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
     * Required. The measurement protocol secret to create.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1beta.MeasurementProtocolSecret measurement_protocol_secret = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Analytics\Admin\V1beta\MeasurementProtocolSecret|null
     */
    public function getMeasurementProtocolSecret()
    {
        return $this->measurement_protocol_secret;
    }
    public function hasMeasurementProtocolSecret()
    {
        return isset($this->measurement_protocol_secret);
    }
    public function clearMeasurementProtocolSecret()
    {
        unset($this->measurement_protocol_secret);
    }
    /**
     * Required. The measurement protocol secret to create.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1beta.MeasurementProtocolSecret measurement_protocol_secret = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Analytics\Admin\V1beta\MeasurementProtocolSecret $var
     * @return $this
     */
    public function setMeasurementProtocolSecret($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1beta\MeasurementProtocolSecret::class);
        $this->measurement_protocol_secret = $var;
        return $this;
    }
}
