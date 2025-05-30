<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/iam/v1/policy.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Cloud\Iam\V1;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * One delta entry for Binding. Each individual change (only one member in each
 * entry) to a binding will be a separate entry.
 *
 * Generated from protobuf message <code>google.iam.v1.BindingDelta</code>
 */
class BindingDelta extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * The action that was performed on a Binding.
     * Required
     *
     * Generated from protobuf field <code>.google.iam.v1.BindingDelta.Action action = 1;</code>
     */
    protected $action = 0;
    /**
     * Role that is assigned to `members`.
     * For example, `roles/viewer`, `roles/editor`, or `roles/owner`.
     * Required
     *
     * Generated from protobuf field <code>string role = 2;</code>
     */
    protected $role = '';
    /**
     * A single identity requesting access for a Google Cloud resource.
     * Follows the same format of Binding.members.
     * Required
     *
     * Generated from protobuf field <code>string member = 3;</code>
     */
    protected $member = '';
    /**
     * The condition that is associated with this binding.
     *
     * Generated from protobuf field <code>.google.type.Expr condition = 4;</code>
     */
    protected $condition = null;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $action
     *           The action that was performed on a Binding.
     *           Required
     *     @type string $role
     *           Role that is assigned to `members`.
     *           For example, `roles/viewer`, `roles/editor`, or `roles/owner`.
     *           Required
     *     @type string $member
     *           A single identity requesting access for a Google Cloud resource.
     *           Follows the same format of Binding.members.
     *           Required
     *     @type \Google\Type\Expr $condition
     *           The condition that is associated with this binding.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Iam\V1\Policy::initOnce();
        parent::__construct($data);
    }
    /**
     * The action that was performed on a Binding.
     * Required
     *
     * Generated from protobuf field <code>.google.iam.v1.BindingDelta.Action action = 1;</code>
     * @return int
     */
    public function getAction()
    {
        return $this->action;
    }
    /**
     * The action that was performed on a Binding.
     * Required
     *
     * Generated from protobuf field <code>.google.iam.v1.BindingDelta.Action action = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setAction($var)
    {
        GPBUtil::checkEnum($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Cloud\Iam\V1\BindingDelta\Action::class);
        $this->action = $var;
        return $this;
    }
    /**
     * Role that is assigned to `members`.
     * For example, `roles/viewer`, `roles/editor`, or `roles/owner`.
     * Required
     *
     * Generated from protobuf field <code>string role = 2;</code>
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }
    /**
     * Role that is assigned to `members`.
     * For example, `roles/viewer`, `roles/editor`, or `roles/owner`.
     * Required
     *
     * Generated from protobuf field <code>string role = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setRole($var)
    {
        GPBUtil::checkString($var, True);
        $this->role = $var;
        return $this;
    }
    /**
     * A single identity requesting access for a Google Cloud resource.
     * Follows the same format of Binding.members.
     * Required
     *
     * Generated from protobuf field <code>string member = 3;</code>
     * @return string
     */
    public function getMember()
    {
        return $this->member;
    }
    /**
     * A single identity requesting access for a Google Cloud resource.
     * Follows the same format of Binding.members.
     * Required
     *
     * Generated from protobuf field <code>string member = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setMember($var)
    {
        GPBUtil::checkString($var, True);
        $this->member = $var;
        return $this;
    }
    /**
     * The condition that is associated with this binding.
     *
     * Generated from protobuf field <code>.google.type.Expr condition = 4;</code>
     * @return \Google\Type\Expr|null
     */
    public function getCondition()
    {
        return $this->condition;
    }
    public function hasCondition()
    {
        return isset($this->condition);
    }
    public function clearCondition()
    {
        unset($this->condition);
    }
    /**
     * The condition that is associated with this binding.
     *
     * Generated from protobuf field <code>.google.type.Expr condition = 4;</code>
     * @param \Google\Type\Expr $var
     * @return $this
     */
    public function setCondition($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Type\Expr::class);
        $this->condition = $var;
        return $this;
    }
}
