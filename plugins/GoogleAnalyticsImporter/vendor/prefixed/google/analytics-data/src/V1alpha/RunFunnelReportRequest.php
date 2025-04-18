<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/data/v1alpha/analytics_data_api.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * The request for a funnel report.
 *
 * Generated from protobuf message <code>google.analytics.data.v1alpha.RunFunnelReportRequest</code>
 */
class RunFunnelReportRequest extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * Optional. A Google Analytics GA4 property identifier whose events are
     * tracked. Specified in the URL path and not the body. To learn more, see
     * [where to find your Property
     * ID](https://developers.google.com/analytics/devguides/reporting/data/v1/property-id).
     * Within a batch request, this property should either be unspecified or
     * consistent with the batch-level property.
     * Example: properties/1234
     *
     * Generated from protobuf field <code>string property = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $property = '';
    /**
     * Optional. Date ranges of data to read. If multiple date ranges are
     * requested, each response row will contain a zero based date range index. If
     * two date ranges overlap, the event data for the overlapping days is
     * included in the response rows for both date ranges.
     *
     * Generated from protobuf field <code>repeated .google.analytics.data.v1alpha.DateRange date_ranges = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $date_ranges;
    /**
     * Optional. The configuration of this request's funnel. This funnel
     * configuration is required.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.Funnel funnel = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $funnel = null;
    /**
     * Optional. If specified, this breakdown adds a dimension to the funnel table
     * sub report response. This breakdown dimension expands each funnel step to
     * the unique values of the breakdown dimension. For example, a breakdown by
     * the `deviceCategory` dimension will create rows for `mobile`, `tablet`,
     * `desktop`, and the total.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.FunnelBreakdown funnel_breakdown = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $funnel_breakdown = null;
    /**
     * Optional. If specified, next action adds a dimension to the funnel
     * visualization sub report response. This next action dimension expands each
     * funnel step to the unique values of the next action. For example a next
     * action of the `eventName` dimension will create rows for several events
     * (for example `session_start` & `click`) and the total.
     * Next action only supports `eventName` and most Page / Screen dimensions
     * like `pageTitle` and `pagePath`.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.FunnelNextAction funnel_next_action = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $funnel_next_action = null;
    /**
     * Optional. The funnel visualization type controls the dimensions present in
     * the funnel visualization sub report response. If not specified,
     * `STANDARD_FUNNEL` is used.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.RunFunnelReportRequest.FunnelVisualizationType funnel_visualization_type = 6 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $funnel_visualization_type = 0;
    /**
     * Optional. The configurations of segments. Segments are subsets of a
     * property's data. In a funnel report with segments, the funnel is evaluated
     * in each segment.
     * Each segment specified in this request
     * produces a separate row in the response; in the response, each segment
     * identified by its name.
     * The segments parameter is optional. Requests are limited to 4 segments.
     *
     * Generated from protobuf field <code>repeated .google.analytics.data.v1alpha.Segment segments = 7 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $segments;
    /**
     * Optional. The number of rows to return. If unspecified, 10,000 rows are
     * returned. The API returns a maximum of 250,000 rows per request, no matter
     * how many you ask for. `limit` must be positive.
     * The API can also return fewer rows than the requested `limit`, if there
     * aren't as many dimension values as the `limit`.
     *
     * Generated from protobuf field <code>int64 limit = 9 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $limit = 0;
    /**
     * Optional. Dimension filters allow you to ask for only specific dimension
     * values in the report. To learn more, see [Creating a Report: Dimension
     * Filters](https://developers.google.com/analytics/devguides/reporting/data/v1/basics#dimension_filters)
     * for examples. Metrics cannot be used in this filter.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.FilterExpression dimension_filter = 10 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $dimension_filter = null;
    /**
     * Optional. Toggles whether to return the current state of this Analytics
     * Property's quota. Quota is returned in [PropertyQuota](#PropertyQuota).
     *
     * Generated from protobuf field <code>bool return_property_quota = 12 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $return_property_quota = \false;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $property
     *           Optional. A Google Analytics GA4 property identifier whose events are
     *           tracked. Specified in the URL path and not the body. To learn more, see
     *           [where to find your Property
     *           ID](https://developers.google.com/analytics/devguides/reporting/data/v1/property-id).
     *           Within a batch request, this property should either be unspecified or
     *           consistent with the batch-level property.
     *           Example: properties/1234
     *     @type array<\Google\Analytics\Data\V1alpha\DateRange>|\Google\Protobuf\Internal\RepeatedField $date_ranges
     *           Optional. Date ranges of data to read. If multiple date ranges are
     *           requested, each response row will contain a zero based date range index. If
     *           two date ranges overlap, the event data for the overlapping days is
     *           included in the response rows for both date ranges.
     *     @type \Google\Analytics\Data\V1alpha\Funnel $funnel
     *           Optional. The configuration of this request's funnel. This funnel
     *           configuration is required.
     *     @type \Google\Analytics\Data\V1alpha\FunnelBreakdown $funnel_breakdown
     *           Optional. If specified, this breakdown adds a dimension to the funnel table
     *           sub report response. This breakdown dimension expands each funnel step to
     *           the unique values of the breakdown dimension. For example, a breakdown by
     *           the `deviceCategory` dimension will create rows for `mobile`, `tablet`,
     *           `desktop`, and the total.
     *     @type \Google\Analytics\Data\V1alpha\FunnelNextAction $funnel_next_action
     *           Optional. If specified, next action adds a dimension to the funnel
     *           visualization sub report response. This next action dimension expands each
     *           funnel step to the unique values of the next action. For example a next
     *           action of the `eventName` dimension will create rows for several events
     *           (for example `session_start` & `click`) and the total.
     *           Next action only supports `eventName` and most Page / Screen dimensions
     *           like `pageTitle` and `pagePath`.
     *     @type int $funnel_visualization_type
     *           Optional. The funnel visualization type controls the dimensions present in
     *           the funnel visualization sub report response. If not specified,
     *           `STANDARD_FUNNEL` is used.
     *     @type array<\Google\Analytics\Data\V1alpha\Segment>|\Google\Protobuf\Internal\RepeatedField $segments
     *           Optional. The configurations of segments. Segments are subsets of a
     *           property's data. In a funnel report with segments, the funnel is evaluated
     *           in each segment.
     *           Each segment specified in this request
     *           produces a separate row in the response; in the response, each segment
     *           identified by its name.
     *           The segments parameter is optional. Requests are limited to 4 segments.
     *     @type int|string $limit
     *           Optional. The number of rows to return. If unspecified, 10,000 rows are
     *           returned. The API returns a maximum of 250,000 rows per request, no matter
     *           how many you ask for. `limit` must be positive.
     *           The API can also return fewer rows than the requested `limit`, if there
     *           aren't as many dimension values as the `limit`.
     *     @type \Google\Analytics\Data\V1alpha\FilterExpression $dimension_filter
     *           Optional. Dimension filters allow you to ask for only specific dimension
     *           values in the report. To learn more, see [Creating a Report: Dimension
     *           Filters](https://developers.google.com/analytics/devguides/reporting/data/v1/basics#dimension_filters)
     *           for examples. Metrics cannot be used in this filter.
     *     @type bool $return_property_quota
     *           Optional. Toggles whether to return the current state of this Analytics
     *           Property's quota. Quota is returned in [PropertyQuota](#PropertyQuota).
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Data\V1Alpha\AnalyticsDataApi::initOnce();
        parent::__construct($data);
    }
    /**
     * Optional. A Google Analytics GA4 property identifier whose events are
     * tracked. Specified in the URL path and not the body. To learn more, see
     * [where to find your Property
     * ID](https://developers.google.com/analytics/devguides/reporting/data/v1/property-id).
     * Within a batch request, this property should either be unspecified or
     * consistent with the batch-level property.
     * Example: properties/1234
     *
     * Generated from protobuf field <code>string property = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getProperty()
    {
        return $this->property;
    }
    /**
     * Optional. A Google Analytics GA4 property identifier whose events are
     * tracked. Specified in the URL path and not the body. To learn more, see
     * [where to find your Property
     * ID](https://developers.google.com/analytics/devguides/reporting/data/v1/property-id).
     * Within a batch request, this property should either be unspecified or
     * consistent with the batch-level property.
     * Example: properties/1234
     *
     * Generated from protobuf field <code>string property = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setProperty($var)
    {
        GPBUtil::checkString($var, True);
        $this->property = $var;
        return $this;
    }
    /**
     * Optional. Date ranges of data to read. If multiple date ranges are
     * requested, each response row will contain a zero based date range index. If
     * two date ranges overlap, the event data for the overlapping days is
     * included in the response rows for both date ranges.
     *
     * Generated from protobuf field <code>repeated .google.analytics.data.v1alpha.DateRange date_ranges = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getDateRanges()
    {
        return $this->date_ranges;
    }
    /**
     * Optional. Date ranges of data to read. If multiple date ranges are
     * requested, each response row will contain a zero based date range index. If
     * two date ranges overlap, the event data for the overlapping days is
     * included in the response rows for both date ranges.
     *
     * Generated from protobuf field <code>repeated .google.analytics.data.v1alpha.DateRange date_ranges = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param array<\Google\Analytics\Data\V1alpha\DateRange>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setDateRanges($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::MESSAGE, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha\DateRange::class);
        $this->date_ranges = $arr;
        return $this;
    }
    /**
     * Optional. The configuration of this request's funnel. This funnel
     * configuration is required.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.Funnel funnel = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Analytics\Data\V1alpha\Funnel|null
     */
    public function getFunnel()
    {
        return $this->funnel;
    }
    public function hasFunnel()
    {
        return isset($this->funnel);
    }
    public function clearFunnel()
    {
        unset($this->funnel);
    }
    /**
     * Optional. The configuration of this request's funnel. This funnel
     * configuration is required.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.Funnel funnel = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Analytics\Data\V1alpha\Funnel $var
     * @return $this
     */
    public function setFunnel($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha\Funnel::class);
        $this->funnel = $var;
        return $this;
    }
    /**
     * Optional. If specified, this breakdown adds a dimension to the funnel table
     * sub report response. This breakdown dimension expands each funnel step to
     * the unique values of the breakdown dimension. For example, a breakdown by
     * the `deviceCategory` dimension will create rows for `mobile`, `tablet`,
     * `desktop`, and the total.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.FunnelBreakdown funnel_breakdown = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Analytics\Data\V1alpha\FunnelBreakdown|null
     */
    public function getFunnelBreakdown()
    {
        return $this->funnel_breakdown;
    }
    public function hasFunnelBreakdown()
    {
        return isset($this->funnel_breakdown);
    }
    public function clearFunnelBreakdown()
    {
        unset($this->funnel_breakdown);
    }
    /**
     * Optional. If specified, this breakdown adds a dimension to the funnel table
     * sub report response. This breakdown dimension expands each funnel step to
     * the unique values of the breakdown dimension. For example, a breakdown by
     * the `deviceCategory` dimension will create rows for `mobile`, `tablet`,
     * `desktop`, and the total.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.FunnelBreakdown funnel_breakdown = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Analytics\Data\V1alpha\FunnelBreakdown $var
     * @return $this
     */
    public function setFunnelBreakdown($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha\FunnelBreakdown::class);
        $this->funnel_breakdown = $var;
        return $this;
    }
    /**
     * Optional. If specified, next action adds a dimension to the funnel
     * visualization sub report response. This next action dimension expands each
     * funnel step to the unique values of the next action. For example a next
     * action of the `eventName` dimension will create rows for several events
     * (for example `session_start` & `click`) and the total.
     * Next action only supports `eventName` and most Page / Screen dimensions
     * like `pageTitle` and `pagePath`.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.FunnelNextAction funnel_next_action = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Analytics\Data\V1alpha\FunnelNextAction|null
     */
    public function getFunnelNextAction()
    {
        return $this->funnel_next_action;
    }
    public function hasFunnelNextAction()
    {
        return isset($this->funnel_next_action);
    }
    public function clearFunnelNextAction()
    {
        unset($this->funnel_next_action);
    }
    /**
     * Optional. If specified, next action adds a dimension to the funnel
     * visualization sub report response. This next action dimension expands each
     * funnel step to the unique values of the next action. For example a next
     * action of the `eventName` dimension will create rows for several events
     * (for example `session_start` & `click`) and the total.
     * Next action only supports `eventName` and most Page / Screen dimensions
     * like `pageTitle` and `pagePath`.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.FunnelNextAction funnel_next_action = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Analytics\Data\V1alpha\FunnelNextAction $var
     * @return $this
     */
    public function setFunnelNextAction($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha\FunnelNextAction::class);
        $this->funnel_next_action = $var;
        return $this;
    }
    /**
     * Optional. The funnel visualization type controls the dimensions present in
     * the funnel visualization sub report response. If not specified,
     * `STANDARD_FUNNEL` is used.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.RunFunnelReportRequest.FunnelVisualizationType funnel_visualization_type = 6 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return int
     */
    public function getFunnelVisualizationType()
    {
        return $this->funnel_visualization_type;
    }
    /**
     * Optional. The funnel visualization type controls the dimensions present in
     * the funnel visualization sub report response. If not specified,
     * `STANDARD_FUNNEL` is used.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.RunFunnelReportRequest.FunnelVisualizationType funnel_visualization_type = 6 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param int $var
     * @return $this
     */
    public function setFunnelVisualizationType($var)
    {
        GPBUtil::checkEnum($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha\RunFunnelReportRequest\FunnelVisualizationType::class);
        $this->funnel_visualization_type = $var;
        return $this;
    }
    /**
     * Optional. The configurations of segments. Segments are subsets of a
     * property's data. In a funnel report with segments, the funnel is evaluated
     * in each segment.
     * Each segment specified in this request
     * produces a separate row in the response; in the response, each segment
     * identified by its name.
     * The segments parameter is optional. Requests are limited to 4 segments.
     *
     * Generated from protobuf field <code>repeated .google.analytics.data.v1alpha.Segment segments = 7 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getSegments()
    {
        return $this->segments;
    }
    /**
     * Optional. The configurations of segments. Segments are subsets of a
     * property's data. In a funnel report with segments, the funnel is evaluated
     * in each segment.
     * Each segment specified in this request
     * produces a separate row in the response; in the response, each segment
     * identified by its name.
     * The segments parameter is optional. Requests are limited to 4 segments.
     *
     * Generated from protobuf field <code>repeated .google.analytics.data.v1alpha.Segment segments = 7 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param array<\Google\Analytics\Data\V1alpha\Segment>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setSegments($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::MESSAGE, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha\Segment::class);
        $this->segments = $arr;
        return $this;
    }
    /**
     * Optional. The number of rows to return. If unspecified, 10,000 rows are
     * returned. The API returns a maximum of 250,000 rows per request, no matter
     * how many you ask for. `limit` must be positive.
     * The API can also return fewer rows than the requested `limit`, if there
     * aren't as many dimension values as the `limit`.
     *
     * Generated from protobuf field <code>int64 limit = 9 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return int|string
     */
    public function getLimit()
    {
        return $this->limit;
    }
    /**
     * Optional. The number of rows to return. If unspecified, 10,000 rows are
     * returned. The API returns a maximum of 250,000 rows per request, no matter
     * how many you ask for. `limit` must be positive.
     * The API can also return fewer rows than the requested `limit`, if there
     * aren't as many dimension values as the `limit`.
     *
     * Generated from protobuf field <code>int64 limit = 9 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param int|string $var
     * @return $this
     */
    public function setLimit($var)
    {
        GPBUtil::checkInt64($var);
        $this->limit = $var;
        return $this;
    }
    /**
     * Optional. Dimension filters allow you to ask for only specific dimension
     * values in the report. To learn more, see [Creating a Report: Dimension
     * Filters](https://developers.google.com/analytics/devguides/reporting/data/v1/basics#dimension_filters)
     * for examples. Metrics cannot be used in this filter.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.FilterExpression dimension_filter = 10 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Analytics\Data\V1alpha\FilterExpression|null
     */
    public function getDimensionFilter()
    {
        return $this->dimension_filter;
    }
    public function hasDimensionFilter()
    {
        return isset($this->dimension_filter);
    }
    public function clearDimensionFilter()
    {
        unset($this->dimension_filter);
    }
    /**
     * Optional. Dimension filters allow you to ask for only specific dimension
     * values in the report. To learn more, see [Creating a Report: Dimension
     * Filters](https://developers.google.com/analytics/devguides/reporting/data/v1/basics#dimension_filters)
     * for examples. Metrics cannot be used in this filter.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.FilterExpression dimension_filter = 10 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Analytics\Data\V1alpha\FilterExpression $var
     * @return $this
     */
    public function setDimensionFilter($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha\FilterExpression::class);
        $this->dimension_filter = $var;
        return $this;
    }
    /**
     * Optional. Toggles whether to return the current state of this Analytics
     * Property's quota. Quota is returned in [PropertyQuota](#PropertyQuota).
     *
     * Generated from protobuf field <code>bool return_property_quota = 12 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getReturnPropertyQuota()
    {
        return $this->return_property_quota;
    }
    /**
     * Optional. Toggles whether to return the current state of this Analytics
     * Property's quota. Quota is returned in [PropertyQuota](#PropertyQuota).
     *
     * Generated from protobuf field <code>bool return_property_quota = 12 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setReturnPropertyQuota($var)
    {
        GPBUtil::checkBool($var);
        $this->return_property_quota = $var;
        return $this;
    }
}
