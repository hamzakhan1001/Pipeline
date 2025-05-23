<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/iam/v1/iam_policy.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Cloud\Iam\V1;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * Request message for `TestIamPermissions` method.
 *
 * Generated from protobuf message <code>google.iam.v1.TestIamPermissionsRequest</code>
 */
class TestIamPermissionsRequest extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * REQUIRED: The resource for which the policy detail is being requested.
     * See the operation documentation for the appropriate value for this field.
     *
     * Generated from protobuf field <code>string resource = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $resource = '';
    /**
     * The set of permissions to check for the `resource`. Permissions with
     * wildcards (such as '*' or 'storage.*') are not allowed. For more
     * information see
     * [IAM Overview](https://cloud.google.com/iam/docs/overview#permissions).
     *
     * Generated from protobuf field <code>repeated string permissions = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    private $permissions;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $resource
     *           REQUIRED: The resource for which the policy detail is being requested.
     *           See the operation documentation for the appropriate value for this field.
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $permissions
     *           The set of permissions to check for the `resource`. Permissions with
     *           wildcards (such as '*' or 'storage.*') are not allowed. For more
     *           information see
     *           [IAM Overview](https://cloud.google.com/iam/docs/overview#permissions).
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Iam\V1\IamPolicy::initOnce();
        parent::__construct($data);
    }
    /**
     * REQUIRED: The resource for which the policy detail is being requested.
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
     * REQUIRED: The resource for which the policy detail is being requested.
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
     * The set of permissions to check for the `resource`. Permissions with
     * wildcards (such as '*' or 'storage.*') are not allowed. For more
     * information see
     * [IAM Overview](https://cloud.google.com/iam/docs/overview#permissions).
     *
     * Generated from protobuf field <code>repeated string permissions = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getPermissions()
    {
        return $this->permissions;
    }
    /**
     * The set of permissions to check for the `resource`. Permissions with
     * wildcards (such as '*' or 'storage.*') are not allowed. For more
     * information see
     * [IAM Overview](https://cloud.google.com/iam/docs/overview#permissions).
     *
     * Generated from protobuf field <code>repeated string permissions = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setPermissions($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::STRING);
        $this->permissions = $arr;
        return $this;
    }
}
