<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/data/v1alpha/data.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * Next actions state the value for a dimension after the user has achieved
 * a step but before the same user has achieved the next step. For example if
 * the `nextActionDimension` is `eventName`, then `nextActionDimension` in the
 * `i`th funnel step row will return first event after the event that qualified
 * the user into the `i`th funnel step but before the user achieved the `i+1`th
 * funnel step.
 *
 * Generated from protobuf message <code>google.analytics.data.v1alpha.FunnelNextAction</code>
 */
class FunnelNextAction extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * The dimension column added to the funnel visualization sub report response.
     * The next action dimension returns the next dimension value of this
     * dimension after the user has attained the `i`th funnel step.
     * `nextActionDimension` currently only supports `eventName` and most Page /
     * Screen dimensions like `pageTitle` and `pagePath`. `nextActionDimension`
     * cannot be a dimension expression.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.Dimension next_action_dimension = 1;</code>
     */
    private $next_action_dimension = null;
    /**
     * The maximum number of distinct values of the breakdown dimension to return
     * in the response. A `limit` of `5` is used if limit is not specified. Limit
     * must exceed zero and cannot exceed 5.
     *
     * Generated from protobuf field <code>optional int64 limit = 2;</code>
     */
    private $limit = null;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Analytics\Data\V1alpha\Dimension $next_action_dimension
     *           The dimension column added to the funnel visualization sub report response.
     *           The next action dimension returns the next dimension value of this
     *           dimension after the user has attained the `i`th funnel step.
     *           `nextActionDimension` currently only supports `eventName` and most Page /
     *           Screen dimensions like `pageTitle` and `pagePath`. `nextActionDimension`
     *           cannot be a dimension expression.
     *     @type int|string $limit
     *           The maximum number of distinct values of the breakdown dimension to return
     *           in the response. A `limit` of `5` is used if limit is not specified. Limit
     *           must exceed zero and cannot exceed 5.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Data\V1Alpha\Data::initOnce();
        parent::__construct($data);
    }
    /**
     * The dimension column added to the funnel visualization sub report response.
     * The next action dimension returns the next dimension value of this
     * dimension after the user has attained the `i`th funnel step.
     * `nextActionDimension` currently only supports `eventName` and most Page /
     * Screen dimensions like `pageTitle` and `pagePath`. `nextActionDimension`
     * cannot be a dimension expression.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.Dimension next_action_dimension = 1;</code>
     * @return \Google\Analytics\Data\V1alpha\Dimension|null
     */
    public function getNextActionDimension()
    {
        return $this->next_action_dimension;
    }
    public function hasNextActionDimension()
    {
        return isset($this->next_action_dimension);
    }
    public function clearNextActionDimension()
    {
        unset($this->next_action_dimension);
    }
    /**
     * The dimension column added to the funnel visualization sub report response.
     * The next action dimension returns the next dimension value of this
     * dimension after the user has attained the `i`th funnel step.
     * `nextActionDimension` currently only supports `eventName` and most Page /
     * Screen dimensions like `pageTitle` and `pagePath`. `nextActionDimension`
     * cannot be a dimension expression.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.Dimension next_action_dimension = 1;</code>
     * @param \Google\Analytics\Data\V1alpha\Dimension $var
     * @return $this
     */
    public function setNextActionDimension($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha\Dimension::class);
        $this->next_action_dimension = $var;
        return $this;
    }
    /**
     * The maximum number of distinct values of the breakdown dimension to return
     * in the response. A `limit` of `5` is used if limit is not specified. Limit
     * must exceed zero and cannot exceed 5.
     *
     * Generated from protobuf field <code>optional int64 limit = 2;</code>
     * @return int|string
     */
    public function getLimit()
    {
        return isset($this->limit) ? $this->limit : 0;
    }
    public function hasLimit()
    {
        return isset($this->limit);
    }
    public function clearLimit()
    {
        unset($this->limit);
    }
    /**
     * The maximum number of distinct values of the breakdown dimension to return
     * in the response. A `limit` of `5` is used if limit is not specified. Limit
     * must exceed zero and cannot exceed 5.
     *
     * Generated from protobuf field <code>optional int64 limit = 2;</code>
     * @param int|string $var
     * @return $this
     */
    public function setLimit($var)
    {
        GPBUtil::checkInt64($var);
        $this->limit = $var;
        return $this;
    }
}
