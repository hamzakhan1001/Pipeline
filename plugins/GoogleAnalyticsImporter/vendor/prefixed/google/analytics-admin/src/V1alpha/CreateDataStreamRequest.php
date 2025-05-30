<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1alpha/analytics_admin.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * Request message for CreateDataStream RPC.
 *
 * Generated from protobuf message <code>google.analytics.admin.v1alpha.CreateDataStreamRequest</code>
 */
class CreateDataStreamRequest extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * Required. Example format: properties/1234
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    private $parent = '';
    /**
     * Required. The DataStream to create.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1alpha.DataStream data_stream = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    private $data_stream = null;
    /**
     * @param string                                     $parent     Required. Example format: properties/1234
     *                                                               Please see {@see AnalyticsAdminServiceClient::propertyName()} for help formatting this field.
     * @param \Google\Analytics\Admin\V1alpha\DataStream $dataStream Required. The DataStream to create.
     *
     * @return \Google\Analytics\Admin\V1alpha\CreateDataStreamRequest
     *
     * @experimental
     */
    public static function build(string $parent, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha\DataStream $dataStream) : self
    {
        return (new self())->setParent($parent)->setDataStream($dataStream);
    }
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $parent
     *           Required. Example format: properties/1234
     *     @type \Google\Analytics\Admin\V1alpha\DataStream $data_stream
     *           Required. The DataStream to create.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Admin\V1Alpha\AnalyticsAdmin::initOnce();
        parent::__construct($data);
    }
    /**
     * Required. Example format: properties/1234
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }
    /**
     * Required. Example format: properties/1234
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
     * Required. The DataStream to create.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1alpha.DataStream data_stream = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Analytics\Admin\V1alpha\DataStream|null
     */
    public function getDataStream()
    {
        return $this->data_stream;
    }
    public function hasDataStream()
    {
        return isset($this->data_stream);
    }
    public function clearDataStream()
    {
        unset($this->data_stream);
    }
    /**
     * Required. The DataStream to create.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1alpha.DataStream data_stream = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Analytics\Admin\V1alpha\DataStream $var
     * @return $this
     */
    public function setDataStream($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha\DataStream::class);
        $this->data_stream = $var;
        return $this;
    }
}
