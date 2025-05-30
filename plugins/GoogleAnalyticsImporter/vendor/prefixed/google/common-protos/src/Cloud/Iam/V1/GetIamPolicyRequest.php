<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/iam/v1/iam_policy.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Cloud\Iam\V1;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * Request message for `GetIamPolicy` method.
 *
 * Generated from protobuf message <code>google.iam.v1.GetIamPolicyRequest</code>
 */
class GetIamPolicyRequest extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * REQUIRED: The resource for which the policy is being requested.
     * See the operation documentation for the appropriate value for this field.
     *
     * Generated from protobuf field <code>string resource = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $resource = '';
    /**
     * OPTIONAL: A `GetPolicyOptions` object for specifying options to
     * `GetIamPolicy`.
     *
     * Generated from protobuf field <code>.google.iam.v1.GetPolicyOptions options = 2;</code>
     */
    protected $options = null;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $resource
     *           REQUIRED: The resource for which the policy is being requested.
     *           See the operation documentation for the appropriate value for this field.
     *     @type \Google\Cloud\Iam\V1\GetPolicyOptions $options
     *           OPTIONAL: A `GetPolicyOptions` object for specifying options to
     *           `GetIamPolicy`.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Iam\V1\IamPolicy::initOnce();
        parent::__construct($data);
    }
    /**
     * REQUIRED: The resource for which the policy is being requested.
     * See the operation documentation for the appropriate value for this field.
     *
     * Generated from protobuf field <code>string resource = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }
    /**
     * REQUIRED: The resource for which the policy is being requested.
     * See the operation documentation for the appropriate value for this field.
     *
     * Generated from protobuf field <code>string resource = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setResource($var)
    {
        GPBUtil::checkString($var, True);
        $this->resource = $var;
        return $this;
    }
    /**
     * OPTIONAL: A `GetPolicyOptions` object for specifying options to
     * `GetIamPolicy`.
     *
     * Generated from protobuf field <code>.google.iam.v1.GetPolicyOptions options = 2;</code>
     * @return \Google\Cloud\Iam\V1\GetPolicyOptions|null
     */
    public function getOptions()
    {
        return $this->options;
    }
    public function hasOptions()
    {
        return isset($this->options);
    }
    public function clearOptions()
    {
        unset($this->options);
    }
    /**
     * OPTIONAL: A `GetPolicyOptions` object for specifying options to
     * `GetIamPolicy`.
     *
     * Generated from protobuf field <code>.google.iam.v1.GetPolicyOptions options = 2;</code>
     * @param \Google\Cloud\Iam\V1\GetPolicyOptions $var
     * @return $this
     */
    public function setOptions($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Cloud\Iam\V1\GetPolicyOptions::class);
        $this->options = $var;
        return $this;
    }
}
