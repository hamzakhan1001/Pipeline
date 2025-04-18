<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/data/v1alpha/data.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * Defines a cohort selection criteria. A cohort is a group of users who share
 * a common characteristic. For example, users with the same `firstSessionDate`
 * belong to the same cohort.
 *
 * Generated from protobuf message <code>google.analytics.data.v1alpha.Cohort</code>
 */
class Cohort extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * Assigns a name to this cohort. The dimension `cohort` is valued to this
     * name in a report response. If set, cannot begin with `cohort_` or
     * `RESERVED_`. If not set, cohorts are named by their zero based index
     * `cohort_0`, `cohort_1`, etc.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     */
    private $name = '';
    /**
     * Dimension used by the cohort. Required and only supports
     * `firstSessionDate`.
     *
     * Generated from protobuf field <code>string dimension = 2;</code>
     */
    private $dimension = '';
    /**
     * The cohort selects users whose first touch date is between start date and
     * end date defined in the `dateRange`. This `dateRange` does not specify the
     * full date range of event data that is present in a cohort report. In a
     * cohort report, this `dateRange` is extended by the granularity and offset
     * present in the `cohortsRange`; event data for the extended reporting date
     * range is present in a cohort report.
     * In a cohort request, this `dateRange` is required and the `dateRanges` in
     * the `RunReportRequest` or `RunPivotReportRequest` must be unspecified.
     * This `dateRange` should generally be aligned with the cohort's granularity.
     * If `CohortsRange` uses daily granularity, this `dateRange` can be a single
     * day. If `CohortsRange` uses weekly granularity, this `dateRange` can be
     * aligned to a week boundary, starting at Sunday and ending Saturday. If
     * `CohortsRange` uses monthly granularity, this `dateRange` can be aligned to
     * a month, starting at the first and ending on the last day of the month.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.DateRange date_range = 3;</code>
     */
    private $date_range = null;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Assigns a name to this cohort. The dimension `cohort` is valued to this
     *           name in a report response. If set, cannot begin with `cohort_` or
     *           `RESERVED_`. If not set, cohorts are named by their zero based index
     *           `cohort_0`, `cohort_1`, etc.
     *     @type string $dimension
     *           Dimension used by the cohort. Required and only supports
     *           `firstSessionDate`.
     *     @type \Google\Analytics\Data\V1alpha\DateRange $date_range
     *           The cohort selects users whose first touch date is between start date and
     *           end date defined in the `dateRange`. This `dateRange` does not specify the
     *           full date range of event data that is present in a cohort report. In a
     *           cohort report, this `dateRange` is extended by the granularity and offset
     *           present in the `cohortsRange`; event data for the extended reporting date
     *           range is present in a cohort report.
     *           In a cohort request, this `dateRange` is required and the `dateRanges` in
     *           the `RunReportRequest` or `RunPivotReportRequest` must be unspecified.
     *           This `dateRange` should generally be aligned with the cohort's granularity.
     *           If `CohortsRange` uses daily granularity, this `dateRange` can be a single
     *           day. If `CohortsRange` uses weekly granularity, this `dateRange` can be
     *           aligned to a week boundary, starting at Sunday and ending Saturday. If
     *           `CohortsRange` uses monthly granularity, this `dateRange` can be aligned to
     *           a month, starting at the first and ending on the last day of the month.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Data\V1Alpha\Data::initOnce();
        parent::__construct($data);
    }
    /**
     * Assigns a name to this cohort. The dimension `cohort` is valued to this
     * name in a report response. If set, cannot begin with `cohort_` or
     * `RESERVED_`. If not set, cohorts are named by their zero based index
     * `cohort_0`, `cohort_1`, etc.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Assigns a name to this cohort. The dimension `cohort` is valued to this
     * name in a report response. If set, cannot begin with `cohort_` or
     * `RESERVED_`. If not set, cohorts are named by their zero based index
     * `cohort_0`, `cohort_1`, etc.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;
        return $this;
    }
    /**
     * Dimension used by the cohort. Required and only supports
     * `firstSessionDate`.
     *
     * Generated from protobuf field <code>string dimension = 2;</code>
     * @return string
     */
    public function getDimension()
    {
        return $this->dimension;
    }
    /**
     * Dimension used by the cohort. Required and only supports
     * `firstSessionDate`.
     *
     * Generated from protobuf field <code>string dimension = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setDimension($var)
    {
        GPBUtil::checkString($var, True);
        $this->dimension = $var;
        return $this;
    }
    /**
     * The cohort selects users whose first touch date is between start date and
     * end date defined in the `dateRange`. This `dateRange` does not specify the
     * full date range of event data that is present in a cohort report. In a
     * cohort report, this `dateRange` is extended by the granularity and offset
     * present in the `cohortsRange`; event data for the extended reporting date
     * range is present in a cohort report.
     * In a cohort request, this `dateRange` is required and the `dateRanges` in
     * the `RunReportRequest` or `RunPivotReportRequest` must be unspecified.
     * This `dateRange` should generally be aligned with the cohort's granularity.
     * If `CohortsRange` uses daily granularity, this `dateRange` can be a single
     * day. If `CohortsRange` uses weekly granularity, this `dateRange` can be
     * aligned to a week boundary, starting at Sunday and ending Saturday. If
     * `CohortsRange` uses monthly granularity, this `dateRange` can be aligned to
     * a month, starting at the first and ending on the last day of the month.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.DateRange date_range = 3;</code>
     * @return \Google\Analytics\Data\V1alpha\DateRange|null
     */
    public function getDateRange()
    {
        return $this->date_range;
    }
    public function hasDateRange()
    {
        return isset($this->date_range);
    }
    public function clearDateRange()
    {
        unset($this->date_range);
    }
    /**
     * The cohort selects users whose first touch date is between start date and
     * end date defined in the `dateRange`. This `dateRange` does not specify the
     * full date range of event data that is present in a cohort report. In a
     * cohort report, this `dateRange` is extended by the granularity and offset
     * present in the `cohortsRange`; event data for the extended reporting date
     * range is present in a cohort report.
     * In a cohort request, this `dateRange` is required and the `dateRanges` in
     * the `RunReportRequest` or `RunPivotReportRequest` must be unspecified.
     * This `dateRange` should generally be aligned with the cohort's granularity.
     * If `CohortsRange` uses daily granularity, this `dateRange` can be a single
     * day. If `CohortsRange` uses weekly granularity, this `dateRange` can be
     * aligned to a week boundary, starting at Sunday and ending Saturday. If
     * `CohortsRange` uses monthly granularity, this `dateRange` can be aligned to
     * a month, starting at the first and ending on the last day of the month.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.DateRange date_range = 3;</code>
     * @param \Google\Analytics\Data\V1alpha\DateRange $var
     * @return $this
     */
    public function setDateRange($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha\DateRange::class);
        $this->date_range = $var;
        return $this;
    }
}
