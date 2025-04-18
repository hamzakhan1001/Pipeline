<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1beta/access_report.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1beta;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * A list of filter expressions.
 *
 * Generated from protobuf message <code>google.analytics.admin.v1beta.AccessFilterExpressionList</code>
 */
class AccessFilterExpressionList extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * A list of filter expressions.
     *
     * Generated from protobuf field <code>repeated .google.analytics.admin.v1beta.AccessFilterExpression expressions = 1;</code>
     */
    private $expressions;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Analytics\Admin\V1beta\AccessFilterExpression>|\Google\Protobuf\Internal\RepeatedField $expressions
     *           A list of filter expressions.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Admin\V1Beta\AccessReport::initOnce();
        parent::__construct($data);
    }
    /**
     * A list of filter expressions.
     *
     * Generated from protobuf field <code>repeated .google.analytics.admin.v1beta.AccessFilterExpression expressions = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getExpressions()
    {
        return $this->expressions;
    }
    /**
     * A list of filter expressions.
     *
     * Generated from protobuf field <code>repeated .google.analytics.admin.v1beta.AccessFilterExpression expressions = 1;</code>
     * @param array<\Google\Analytics\Admin\V1beta\AccessFilterExpression>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setExpressions($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::MESSAGE, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1beta\AccessFilterExpression::class);
        $this->expressions = $arr;
        return $this;
    }
}
