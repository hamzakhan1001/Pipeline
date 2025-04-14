<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/api/visibility.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Api;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * `Visibility` restricts service consumer's access to service elements,
 * such as whether an application can call a visibility-restricted method.
 * The restriction is expressed by applying visibility labels on service
 * elements. The visibility labels are elsewhere linked to service consumers.
 * A service can define multiple visibility labels, but a service consumer
 * should be granted at most one visibility label. Multiple visibility
 * labels for a single service consumer are not supported.
 * If an element and all its parents have no visibility label, its visibility
 * is unconditionally granted.
 * Example:
 *     visibility:
 *       rules:
 *       - selector: google.calendar.Calendar.EnhancedSearch
 *         restriction: PREVIEW
 *       - selector: google.calendar.Calendar.Delegate
 *         restriction: INTERNAL
 * Here, all methods are publicly visible except for the restricted methods
 * EnhancedSearch and Delegate.
 *
 * Generated from protobuf message <code>google.api.Visibility</code>
 */
class Visibility extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * A list of visibility rules that apply to individual API elements.
     * **NOTE:** All service configuration rules follow "last one wins" order.
     *
     * Generated from protobuf field <code>repeated .google.api.VisibilityRule rules = 1;</code>
     */
    private $rules;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Api\VisibilityRule>|\Google\Protobuf\Internal\RepeatedField $rules
     *           A list of visibility rules that apply to individual API elements.
     *           **NOTE:** All service configuration rules follow "last one wins" order.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Api\Visibility::initOnce();
        parent::__construct($data);
    }
    /**
     * A list of visibility rules that apply to individual API elements.
     * **NOTE:** All service configuration rules follow "last one wins" order.
     *
     * Generated from protobuf field <code>repeated .google.api.VisibilityRule rules = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getRules()
    {
        return $this->rules;
    }
    /**
     * A list of visibility rules that apply to individual API elements.
     * **NOTE:** All service configuration rules follow "last one wins" order.
     *
     * Generated from protobuf field <code>repeated .google.api.VisibilityRule rules = 1;</code>
     * @param array<\Google\Api\VisibilityRule>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setRules($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::MESSAGE, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Api\VisibilityRule::class);
        $this->rules = $arr;
        return $this;
    }
}
