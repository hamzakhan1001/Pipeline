<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1alpha/resources.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * A resource message representing a user's permissions on an Account or
 * Property resource.
 *
 * Generated from protobuf message <code>google.analytics.admin.v1alpha.UserLink</code>
 */
class UserLink extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * Output only. Example format: properties/1234/userLinks/5678
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    private $name = '';
    /**
     * Immutable. Email address of the user to link
     *
     * Generated from protobuf field <code>string email_address = 2 [(.google.api.field_behavior) = IMMUTABLE];</code>
     */
    private $email_address = '';
    /**
     * Roles directly assigned to this user for this account or property.
     * Valid values:
     * predefinedRoles/viewer
     * predefinedRoles/analyst
     * predefinedRoles/editor
     * predefinedRoles/admin
     * predefinedRoles/no-cost-data
     * predefinedRoles/no-revenue-data
     * Excludes roles that are inherited from a higher-level entity, group,
     * or organization admin role.
     * A UserLink that is updated to have an empty list of direct_roles will be
     * deleted.
     *
     * Generated from protobuf field <code>repeated string direct_roles = 3;</code>
     */
    private $direct_roles;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Output only. Example format: properties/1234/userLinks/5678
     *     @type string $email_address
     *           Immutable. Email address of the user to link
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $direct_roles
     *           Roles directly assigned to this user for this account or property.
     *           Valid values:
     *           predefinedRoles/viewer
     *           predefinedRoles/analyst
     *           predefinedRoles/editor
     *           predefinedRoles/admin
     *           predefinedRoles/no-cost-data
     *           predefinedRoles/no-revenue-data
     *           Excludes roles that are inherited from a higher-level entity, group,
     *           or organization admin role.
     *           A UserLink that is updated to have an empty list of direct_roles will be
     *           deleted.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Admin\V1Alpha\Resources::initOnce();
        parent::__construct($data);
    }
    /**
     * Output only. Example format: properties/1234/userLinks/5678
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Output only. Example format: properties/1234/userLinks/5678
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;
        return $this;
    }
    /**
     * Immutable. Email address of the user to link
     *
     * Generated from protobuf field <code>string email_address = 2 [(.google.api.field_behavior) = IMMUTABLE];</code>
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->email_address;
    }
    /**
     * Immutable. Email address of the user to link
     *
     * Generated from protobuf field <code>string email_address = 2 [(.google.api.field_behavior) = IMMUTABLE];</code>
     * @param string $var
     * @return $this
     */
    public function setEmailAddress($var)
    {
        GPBUtil::checkString($var, True);
        $this->email_address = $var;
        return $this;
    }
    /**
     * Roles directly assigned to this user for this account or property.
     * Valid values:
     * predefinedRoles/viewer
     * predefinedRoles/analyst
     * predefinedRoles/editor
     * predefinedRoles/admin
     * predefinedRoles/no-cost-data
     * predefinedRoles/no-revenue-data
     * Excludes roles that are inherited from a higher-level entity, group,
     * or organization admin role.
     * A UserLink that is updated to have an empty list of direct_roles will be
     * deleted.
     *
     * Generated from protobuf field <code>repeated string direct_roles = 3;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getDirectRoles()
    {
        return $this->direct_roles;
    }
    /**
     * Roles directly assigned to this user for this account or property.
     * Valid values:
     * predefinedRoles/viewer
     * predefinedRoles/analyst
     * predefinedRoles/editor
     * predefinedRoles/admin
     * predefinedRoles/no-cost-data
     * predefinedRoles/no-revenue-data
     * Excludes roles that are inherited from a higher-level entity, group,
     * or organization admin role.
     * A UserLink that is updated to have an empty list of direct_roles will be
     * deleted.
     *
     * Generated from protobuf field <code>repeated string direct_roles = 3;</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setDirectRoles($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::STRING);
        $this->direct_roles = $arr;
        return $this;
    }
}
