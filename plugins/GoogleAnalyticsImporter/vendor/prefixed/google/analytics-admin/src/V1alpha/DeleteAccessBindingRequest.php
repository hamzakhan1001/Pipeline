<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1alpha/analytics_admin.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * Request message for DeleteAccessBinding RPC.
 *
 * Generated from protobuf message <code>google.analytics.admin.v1alpha.DeleteAccessBindingRequest</code>
 */
class DeleteAccessBindingRequest extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * Required. Formats:
     * - accounts/{account}/accessBindings/{accessBinding}
     * - properties/{property}/accessBindings/{accessBinding}
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    private $name = '';
    /**
     * @param string $name Required. Formats:
     *                     - accounts/{account}/accessBindings/{accessBinding}
     *                     - properties/{property}/accessBindings/{accessBinding}
     *                     Please see {@see AnalyticsAdminServiceClient::accessBindingName()} for help formatting this field.
     *
     * @return \Google\Analytics\Admin\V1alpha\DeleteAccessBindingRequest
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
     *           Required. Formats:
     *           - accounts/{account}/accessBindings/{accessBinding}
     *           - properties/{property}/accessBindings/{accessBinding}
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Admin\V1Alpha\AnalyticsAdmin::initOnce();
        parent::__construct($data);
    }
    /**
     * Required. Formats:
     * - accounts/{account}/accessBindings/{accessBinding}
     * - properties/{property}/accessBindings/{accessBinding}
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Required. Formats:
     * - accounts/{account}/accessBindings/{accessBinding}
     * - properties/{property}/accessBindings/{accessBinding}
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
