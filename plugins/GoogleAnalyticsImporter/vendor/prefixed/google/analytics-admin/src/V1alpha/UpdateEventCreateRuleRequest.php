<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1alpha/analytics_admin.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * Request message for UpdateEventCreateRule RPC.
 *
 * Generated from protobuf message <code>google.analytics.admin.v1alpha.UpdateEventCreateRuleRequest</code>
 */
class UpdateEventCreateRuleRequest extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * Required. The EventCreateRule to update.
     * The resource's `name` field is used to identify the EventCreateRule to be
     * updated.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1alpha.EventCreateRule event_create_rule = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    private $event_create_rule = null;
    /**
     * Required. The list of fields to be updated. Field names must be in snake
     * case (e.g., "field_to_update"). Omitted fields will not be updated. To
     * replace the entire entity, use one path with the string "*" to match all
     * fields.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    private $update_mask = null;
    /**
     * @param \Google\Analytics\Admin\V1alpha\EventCreateRule $eventCreateRule Required. The EventCreateRule to update.
     *                                                                         The resource's `name` field is used to identify the EventCreateRule to be
     *                                                                         updated.
     * @param \Google\Protobuf\FieldMask                      $updateMask      Required. The list of fields to be updated. Field names must be in snake
     *                                                                         case (e.g., "field_to_update"). Omitted fields will not be updated. To
     *                                                                         replace the entire entity, use one path with the string "*" to match all
     *                                                                         fields.
     *
     * @return \Google\Analytics\Admin\V1alpha\UpdateEventCreateRuleRequest
     *
     * @experimental
     */
    public static function build(\Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha\EventCreateRule $eventCreateRule, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\FieldMask $updateMask) : self
    {
        return (new self())->setEventCreateRule($eventCreateRule)->setUpdateMask($updateMask);
    }
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Analytics\Admin\V1alpha\EventCreateRule $event_create_rule
     *           Required. The EventCreateRule to update.
     *           The resource's `name` field is used to identify the EventCreateRule to be
     *           updated.
     *     @type \Google\Protobuf\FieldMask $update_mask
     *           Required. The list of fields to be updated. Field names must be in snake
     *           case (e.g., "field_to_update"). Omitted fields will not be updated. To
     *           replace the entire entity, use one path with the string "*" to match all
     *           fields.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Admin\V1Alpha\AnalyticsAdmin::initOnce();
        parent::__construct($data);
    }
    /**
     * Required. The EventCreateRule to update.
     * The resource's `name` field is used to identify the EventCreateRule to be
     * updated.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1alpha.EventCreateRule event_create_rule = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Analytics\Admin\V1alpha\EventCreateRule|null
     */
    public function getEventCreateRule()
    {
        return $this->event_create_rule;
    }
    public function hasEventCreateRule()
    {
        return isset($this->event_create_rule);
    }
    public function clearEventCreateRule()
    {
        unset($this->event_create_rule);
    }
    /**
     * Required. The EventCreateRule to update.
     * The resource's `name` field is used to identify the EventCreateRule to be
     * updated.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1alpha.EventCreateRule event_create_rule = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Analytics\Admin\V1alpha\EventCreateRule $var
     * @return $this
     */
    public function setEventCreateRule($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha\EventCreateRule::class);
        $this->event_create_rule = $var;
        return $this;
    }
    /**
     * Required. The list of fields to be updated. Field names must be in snake
     * case (e.g., "field_to_update"). Omitted fields will not be updated. To
     * replace the entire entity, use one path with the string "*" to match all
     * fields.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Protobuf\FieldMask|null
     */
    public function getUpdateMask()
    {
        return $this->update_mask;
    }
    public function hasUpdateMask()
    {
        return isset($this->update_mask);
    }
    public function clearUpdateMask()
    {
        unset($this->update_mask);
    }
    /**
     * Required. The list of fields to be updated. Field names must be in snake
     * case (e.g., "field_to_update"). Omitted fields will not be updated. To
     * replace the entire entity, use one path with the string "*" to match all
     * fields.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Protobuf\FieldMask $var
     * @return $this
     */
    public function setUpdateMask($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\FieldMask::class);
        $this->update_mask = $var;
        return $this;
    }
}
