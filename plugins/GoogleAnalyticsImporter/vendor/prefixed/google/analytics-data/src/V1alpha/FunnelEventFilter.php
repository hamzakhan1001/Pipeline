<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/data/v1alpha/data.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * Creates a filter that matches events of a single event name. If a parameter
 * filter expression is specified, only the subset of events that match both the
 * single event name and the parameter filter expressions match this event
 * filter.
 *
 * Generated from protobuf message <code>google.analytics.data.v1alpha.FunnelEventFilter</code>
 */
class FunnelEventFilter extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * This filter matches events of this single event name. Event name is
     * required.
     *
     * Generated from protobuf field <code>optional string event_name = 1;</code>
     */
    private $event_name = null;
    /**
     * If specified, this filter matches events that match both the single event
     * name and the parameter filter expressions.
     * Inside the parameter filter expression, only parameter filters are
     * available.
     *
     * Generated from protobuf field <code>optional .google.analytics.data.v1alpha.FunnelParameterFilterExpression funnel_parameter_filter_expression = 2;</code>
     */
    private $funnel_parameter_filter_expression = null;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $event_name
     *           This filter matches events of this single event name. Event name is
     *           required.
     *     @type \Google\Analytics\Data\V1alpha\FunnelParameterFilterExpression $funnel_parameter_filter_expression
     *           If specified, this filter matches events that match both the single event
     *           name and the parameter filter expressions.
     *           Inside the parameter filter expression, only parameter filters are
     *           available.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Data\V1Alpha\Data::initOnce();
        parent::__construct($data);
    }
    /**
     * This filter matches events of this single event name. Event name is
     * required.
     *
     * Generated from protobuf field <code>optional string event_name = 1;</code>
     * @return string
     */
    public function getEventName()
    {
        return isset($this->event_name) ? $this->event_name : '';
    }
    public function hasEventName()
    {
        return isset($this->event_name);
    }
    public function clearEventName()
    {
        unset($this->event_name);
    }
    /**
     * This filter matches events of this single event name. Event name is
     * required.
     *
     * Generated from protobuf field <code>optional string event_name = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setEventName($var)
    {
        GPBUtil::checkString($var, True);
        $this->event_name = $var;
        return $this;
    }
    /**
     * If specified, this filter matches events that match both the single event
     * name and the parameter filter expressions.
     * Inside the parameter filter expression, only parameter filters are
     * available.
     *
     * Generated from protobuf field <code>optional .google.analytics.data.v1alpha.FunnelParameterFilterExpression funnel_parameter_filter_expression = 2;</code>
     * @return \Google\Analytics\Data\V1alpha\FunnelParameterFilterExpression|null
     */
    public function getFunnelParameterFilterExpression()
    {
        return $this->funnel_parameter_filter_expression;
    }
    public function hasFunnelParameterFilterExpression()
    {
        return isset($this->funnel_parameter_filter_expression);
    }
    public function clearFunnelParameterFilterExpression()
    {
        unset($this->funnel_parameter_filter_expression);
    }
    /**
     * If specified, this filter matches events that match both the single event
     * name and the parameter filter expressions.
     * Inside the parameter filter expression, only parameter filters are
     * available.
     *
     * Generated from protobuf field <code>optional .google.analytics.data.v1alpha.FunnelParameterFilterExpression funnel_parameter_filter_expression = 2;</code>
     * @param \Google\Analytics\Data\V1alpha\FunnelParameterFilterExpression $var
     * @return $this
     */
    public function setFunnelParameterFilterExpression($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha\FunnelParameterFilterExpression::class);
        $this->funnel_parameter_filter_expression = $var;
        return $this;
    }
}
