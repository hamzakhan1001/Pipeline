<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/data/v1alpha/data.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * Funnel sub reports contain the dimension and metric data values. For example,
 * 12 users reached the second step of the funnel.
 *
 * Generated from protobuf message <code>google.analytics.data.v1alpha.FunnelSubReport</code>
 */
class FunnelSubReport extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * Describes dimension columns. Funnel reports always include the funnel step
     * dimension in sub report responses. Additional dimensions like breakdowns,
     * dates, and next actions may be present in the response if requested.
     *
     * Generated from protobuf field <code>repeated .google.analytics.data.v1alpha.DimensionHeader dimension_headers = 1;</code>
     */
    private $dimension_headers;
    /**
     * Describes metric columns. Funnel reports always include active users in sub
     * report responses. The funnel table includes additional metrics like
     * completion rate, abandonments, and abandonments rate.
     *
     * Generated from protobuf field <code>repeated .google.analytics.data.v1alpha.MetricHeader metric_headers = 2;</code>
     */
    private $metric_headers;
    /**
     * Rows of dimension value combinations and metric values in the report.
     *
     * Generated from protobuf field <code>repeated .google.analytics.data.v1alpha.Row rows = 3;</code>
     */
    private $rows;
    /**
     * Metadata for the funnel report.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.FunnelResponseMetadata metadata = 4;</code>
     */
    private $metadata = null;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Analytics\Data\V1alpha\DimensionHeader>|\Google\Protobuf\Internal\RepeatedField $dimension_headers
     *           Describes dimension columns. Funnel reports always include the funnel step
     *           dimension in sub report responses. Additional dimensions like breakdowns,
     *           dates, and next actions may be present in the response if requested.
     *     @type array<\Google\Analytics\Data\V1alpha\MetricHeader>|\Google\Protobuf\Internal\RepeatedField $metric_headers
     *           Describes metric columns. Funnel reports always include active users in sub
     *           report responses. The funnel table includes additional metrics like
     *           completion rate, abandonments, and abandonments rate.
     *     @type array<\Google\Analytics\Data\V1alpha\Row>|\Google\Protobuf\Internal\RepeatedField $rows
     *           Rows of dimension value combinations and metric values in the report.
     *     @type \Google\Analytics\Data\V1alpha\FunnelResponseMetadata $metadata
     *           Metadata for the funnel report.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Data\V1Alpha\Data::initOnce();
        parent::__construct($data);
    }
    /**
     * Describes dimension columns. Funnel reports always include the funnel step
     * dimension in sub report responses. Additional dimensions like breakdowns,
     * dates, and next actions may be present in the response if requested.
     *
     * Generated from protobuf field <code>repeated .google.analytics.data.v1alpha.DimensionHeader dimension_headers = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getDimensionHeaders()
    {
        return $this->dimension_headers;
    }
    /**
     * Describes dimension columns. Funnel reports always include the funnel step
     * dimension in sub report responses. Additional dimensions like breakdowns,
     * dates, and next actions may be present in the response if requested.
     *
     * Generated from protobuf field <code>repeated .google.analytics.data.v1alpha.DimensionHeader dimension_headers = 1;</code>
     * @param array<\Google\Analytics\Data\V1alpha\DimensionHeader>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setDimensionHeaders($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::MESSAGE, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha\DimensionHeader::class);
        $this->dimension_headers = $arr;
        return $this;
    }
    /**
     * Describes metric columns. Funnel reports always include active users in sub
     * report responses. The funnel table includes additional metrics like
     * completion rate, abandonments, and abandonments rate.
     *
     * Generated from protobuf field <code>repeated .google.analytics.data.v1alpha.MetricHeader metric_headers = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getMetricHeaders()
    {
        return $this->metric_headers;
    }
    /**
     * Describes metric columns. Funnel reports always include active users in sub
     * report responses. The funnel table includes additional metrics like
     * completion rate, abandonments, and abandonments rate.
     *
     * Generated from protobuf field <code>repeated .google.analytics.data.v1alpha.MetricHeader metric_headers = 2;</code>
     * @param array<\Google\Analytics\Data\V1alpha\MetricHeader>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setMetricHeaders($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::MESSAGE, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha\MetricHeader::class);
        $this->metric_headers = $arr;
        return $this;
    }
    /**
     * Rows of dimension value combinations and metric values in the report.
     *
     * Generated from protobuf field <code>repeated .google.analytics.data.v1alpha.Row rows = 3;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getRows()
    {
        return $this->rows;
    }
    /**
     * Rows of dimension value combinations and metric values in the report.
     *
     * Generated from protobuf field <code>repeated .google.analytics.data.v1alpha.Row rows = 3;</code>
     * @param array<\Google\Analytics\Data\V1alpha\Row>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setRows($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::MESSAGE, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha\Row::class);
        $this->rows = $arr;
        return $this;
    }
    /**
     * Metadata for the funnel report.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.FunnelResponseMetadata metadata = 4;</code>
     * @return \Google\Analytics\Data\V1alpha\FunnelResponseMetadata|null
     */
    public function getMetadata()
    {
        return $this->metadata;
    }
    public function hasMetadata()
    {
        return isset($this->metadata);
    }
    public function clearMetadata()
    {
        unset($this->metadata);
    }
    /**
     * Metadata for the funnel report.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.FunnelResponseMetadata metadata = 4;</code>
     * @param \Google\Analytics\Data\V1alpha\FunnelResponseMetadata $var
     * @return $this
     */
    public function setMetadata($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha\FunnelResponseMetadata::class);
        $this->metadata = $var;
        return $this;
    }
}
