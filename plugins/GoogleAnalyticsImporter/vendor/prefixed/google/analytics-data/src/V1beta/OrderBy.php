<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/data/v1beta/data.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1beta;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * Order bys define how rows will be sorted in the response. For example,
 * ordering rows by descending event count is one ordering, and ordering rows by
 * the event name string is a different ordering.
 *
 * Generated from protobuf message <code>google.analytics.data.v1beta.OrderBy</code>
 */
class OrderBy extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * If true, sorts by descending order.
     *
     * Generated from protobuf field <code>bool desc = 4;</code>
     */
    private $desc = \false;
    protected $one_order_by;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Analytics\Data\V1beta\OrderBy\MetricOrderBy $metric
     *           Sorts results by a metric's values.
     *     @type \Google\Analytics\Data\V1beta\OrderBy\DimensionOrderBy $dimension
     *           Sorts results by a dimension's values.
     *     @type \Google\Analytics\Data\V1beta\OrderBy\PivotOrderBy $pivot
     *           Sorts results by a metric's values within a pivot column group.
     *     @type bool $desc
     *           If true, sorts by descending order.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Data\V1Beta\Data::initOnce();
        parent::__construct($data);
    }
    /**
     * Sorts results by a metric's values.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1beta.OrderBy.MetricOrderBy metric = 1;</code>
     * @return \Google\Analytics\Data\V1beta\OrderBy\MetricOrderBy|null
     */
    public function getMetric()
    {
        return $this->readOneof(1);
    }
    public function hasMetric()
    {
        return $this->hasOneof(1);
    }
    /**
     * Sorts results by a metric's values.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1beta.OrderBy.MetricOrderBy metric = 1;</code>
     * @param \Google\Analytics\Data\V1beta\OrderBy\MetricOrderBy $var
     * @return $this
     */
    public function setMetric($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1beta\OrderBy\MetricOrderBy::class);
        $this->writeOneof(1, $var);
        return $this;
    }
    /**
     * Sorts results by a dimension's values.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1beta.OrderBy.DimensionOrderBy dimension = 2;</code>
     * @return \Google\Analytics\Data\V1beta\OrderBy\DimensionOrderBy|null
     */
    public function getDimension()
    {
        return $this->readOneof(2);
    }
    public function hasDimension()
    {
        return $this->hasOneof(2);
    }
    /**
     * Sorts results by a dimension's values.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1beta.OrderBy.DimensionOrderBy dimension = 2;</code>
     * @param \Google\Analytics\Data\V1beta\OrderBy\DimensionOrderBy $var
     * @return $this
     */
    public function setDimension($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1beta\OrderBy\DimensionOrderBy::class);
        $this->writeOneof(2, $var);
        return $this;
    }
    /**
     * Sorts results by a metric's values within a pivot column group.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1beta.OrderBy.PivotOrderBy pivot = 3;</code>
     * @return \Google\Analytics\Data\V1beta\OrderBy\PivotOrderBy|null
     */
    public function getPivot()
    {
        return $this->readOneof(3);
    }
    public function hasPivot()
    {
        return $this->hasOneof(3);
    }
    /**
     * Sorts results by a metric's values within a pivot column group.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1beta.OrderBy.PivotOrderBy pivot = 3;</code>
     * @param \Google\Analytics\Data\V1beta\OrderBy\PivotOrderBy $var
     * @return $this
     */
    public function setPivot($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1beta\OrderBy\PivotOrderBy::class);
        $this->writeOneof(3, $var);
        return $this;
    }
    /**
     * If true, sorts by descending order.
     *
     * Generated from protobuf field <code>bool desc = 4;</code>
     * @return bool
     */
    public function getDesc()
    {
        return $this->desc;
    }
    /**
     * If true, sorts by descending order.
     *
     * Generated from protobuf field <code>bool desc = 4;</code>
     * @param bool $var
     * @return $this
     */
    public function setDesc($var)
    {
        GPBUtil::checkBool($var);
        $this->desc = $var;
        return $this;
    }
    /**
     * @return string
     */
    public function getOneOrderBy()
    {
        return $this->whichOneof("one_order_by");
    }
}
