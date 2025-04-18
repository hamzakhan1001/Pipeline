<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1alpha/subproperty_event_filter.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * A list of Subproperty event filter expressions.
 *
 * Generated from protobuf message <code>google.analytics.admin.v1alpha.SubpropertyEventFilterExpressionList</code>
 */
class SubpropertyEventFilterExpressionList extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * Required. Unordered list. A list of Subproperty event filter expressions
     *
     * Generated from protobuf field <code>repeated .google.analytics.admin.v1alpha.SubpropertyEventFilterExpression filter_expressions = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.field_behavior) = UNORDERED_LIST];</code>
     */
    private $filter_expressions;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Analytics\Admin\V1alpha\SubpropertyEventFilterExpression>|\Google\Protobuf\Internal\RepeatedField $filter_expressions
     *           Required. Unordered list. A list of Subproperty event filter expressions
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Admin\V1Alpha\SubpropertyEventFilter::initOnce();
        parent::__construct($data);
    }
    /**
     * Required. Unordered list. A list of Subproperty event filter expressions
     *
     * Generated from protobuf field <code>repeated .google.analytics.admin.v1alpha.SubpropertyEventFilterExpression filter_expressions = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.field_behavior) = UNORDERED_LIST];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getFilterExpressions()
    {
        return $this->filter_expressions;
    }
    /**
     * Required. Unordered list. A list of Subproperty event filter expressions
     *
     * Generated from protobuf field <code>repeated .google.analytics.admin.v1alpha.SubpropertyEventFilterExpression filter_expressions = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.field_behavior) = UNORDERED_LIST];</code>
     * @param array<\Google\Analytics\Admin\V1alpha\SubpropertyEventFilterExpression>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setFilterExpressions($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::MESSAGE, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha\SubpropertyEventFilterExpression::class);
        $this->filter_expressions = $arr;
        return $this;
    }
}
