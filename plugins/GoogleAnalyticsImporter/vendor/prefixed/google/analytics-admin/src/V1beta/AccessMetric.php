<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1beta/access_report.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1beta;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * The quantitative measurements of a report. For example, the metric
 * `accessCount` is the total number of data access records.
 *
 * Generated from protobuf message <code>google.analytics.admin.v1beta.AccessMetric</code>
 */
class AccessMetric extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * The API name of the metric. See [Data Access
     * Schema](https://developers.google.com/analytics/devguides/config/admin/v1/access-api-schema)
     * for the list of metrics supported in this API.
     * Metrics are referenced by name in `metricFilter` & `orderBys`.
     *
     * Generated from protobuf field <code>string metric_name = 1;</code>
     */
    private $metric_name = '';
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $metric_name
     *           The API name of the metric. See [Data Access
     *           Schema](https://developers.google.com/analytics/devguides/config/admin/v1/access-api-schema)
     *           for the list of metrics supported in this API.
     *           Metrics are referenced by name in `metricFilter` & `orderBys`.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Admin\V1Beta\AccessReport::initOnce();
        parent::__construct($data);
    }
    /**
     * The API name of the metric. See [Data Access
     * Schema](https://developers.google.com/analytics/devguides/config/admin/v1/access-api-schema)
     * for the list of metrics supported in this API.
     * Metrics are referenced by name in `metricFilter` & `orderBys`.
     *
     * Generated from protobuf field <code>string metric_name = 1;</code>
     * @return string
     */
    public function getMetricName()
    {
        return $this->metric_name;
    }
    /**
     * The API name of the metric. See [Data Access
     * Schema](https://developers.google.com/analytics/devguides/config/admin/v1/access-api-schema)
     * for the list of metrics supported in this API.
     * Metrics are referenced by name in `metricFilter` & `orderBys`.
     *
     * Generated from protobuf field <code>string metric_name = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setMetricName($var)
    {
        GPBUtil::checkString($var, True);
        $this->metric_name = $var;
        return $this;
    }
}
