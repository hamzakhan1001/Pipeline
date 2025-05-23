<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/api/quota.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Api;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * `QuotaLimit` defines a specific limit that applies over a specified duration
 * for a limit type. There can be at most one limit for a duration and limit
 * type combination defined within a `QuotaGroup`.
 *
 * Generated from protobuf message <code>google.api.QuotaLimit</code>
 */
class QuotaLimit extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * Name of the quota limit.
     * The name must be provided, and it must be unique within the service. The
     * name can only include alphanumeric characters as well as '-'.
     * The maximum length of the limit name is 64 characters.
     *
     * Generated from protobuf field <code>string name = 6;</code>
     */
    protected $name = '';
    /**
     * Optional. User-visible, extended description for this quota limit.
     * Should be used only when more context is needed to understand this limit
     * than provided by the limit's display name (see: `display_name`).
     *
     * Generated from protobuf field <code>string description = 2;</code>
     */
    protected $description = '';
    /**
     * Default number of tokens that can be consumed during the specified
     * duration. This is the number of tokens assigned when a client
     * application developer activates the service for his/her project.
     * Specifying a value of 0 will block all requests. This can be used if you
     * are provisioning quota to selected consumers and blocking others.
     * Similarly, a value of -1 will indicate an unlimited quota. No other
     * negative values are allowed.
     * Used by group-based quotas only.
     *
     * Generated from protobuf field <code>int64 default_limit = 3;</code>
     */
    protected $default_limit = 0;
    /**
     * Maximum number of tokens that can be consumed during the specified
     * duration. Client application developers can override the default limit up
     * to this maximum. If specified, this value cannot be set to a value less
     * than the default limit. If not specified, it is set to the default limit.
     * To allow clients to apply overrides with no upper bound, set this to -1,
     * indicating unlimited maximum quota.
     * Used by group-based quotas only.
     *
     * Generated from protobuf field <code>int64 max_limit = 4;</code>
     */
    protected $max_limit = 0;
    /**
     * Free tier value displayed in the Developers Console for this limit.
     * The free tier is the number of tokens that will be subtracted from the
     * billed amount when billing is enabled.
     * This field can only be set on a limit with duration "1d", in a billable
     * group; it is invalid on any other limit. If this field is not set, it
     * defaults to 0, indicating that there is no free tier for this service.
     * Used by group-based quotas only.
     *
     * Generated from protobuf field <code>int64 free_tier = 7;</code>
     */
    protected $free_tier = 0;
    /**
     * Duration of this limit in textual notation. Must be "100s" or "1d".
     * Used by group-based quotas only.
     *
     * Generated from protobuf field <code>string duration = 5;</code>
     */
    protected $duration = '';
    /**
     * The name of the metric this quota limit applies to. The quota limits with
     * the same metric will be checked together during runtime. The metric must be
     * defined within the service config.
     *
     * Generated from protobuf field <code>string metric = 8;</code>
     */
    protected $metric = '';
    /**
     * Specify the unit of the quota limit. It uses the same syntax as
     * [Metric.unit][]. The supported unit kinds are determined by the quota
     * backend system.
     * Here are some examples:
     * * "1/min/{project}" for quota per minute per project.
     * Note: the order of unit components is insignificant.
     * The "1" at the beginning is required to follow the metric unit syntax.
     *
     * Generated from protobuf field <code>string unit = 9;</code>
     */
    protected $unit = '';
    /**
     * Tiered limit values. You must specify this as a key:value pair, with an
     * integer value that is the maximum number of requests allowed for the
     * specified unit. Currently only STANDARD is supported.
     *
     * Generated from protobuf field <code>map<string, int64> values = 10;</code>
     */
    private $values;
    /**
     * User-visible display name for this limit.
     * Optional. If not set, the UI will provide a default display name based on
     * the quota configuration. This field can be used to override the default
     * display name generated from the configuration.
     *
     * Generated from protobuf field <code>string display_name = 12;</code>
     */
    protected $display_name = '';
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Name of the quota limit.
     *           The name must be provided, and it must be unique within the service. The
     *           name can only include alphanumeric characters as well as '-'.
     *           The maximum length of the limit name is 64 characters.
     *     @type string $description
     *           Optional. User-visible, extended description for this quota limit.
     *           Should be used only when more context is needed to understand this limit
     *           than provided by the limit's display name (see: `display_name`).
     *     @type int|string $default_limit
     *           Default number of tokens that can be consumed during the specified
     *           duration. This is the number of tokens assigned when a client
     *           application developer activates the service for his/her project.
     *           Specifying a value of 0 will block all requests. This can be used if you
     *           are provisioning quota to selected consumers and blocking others.
     *           Similarly, a value of -1 will indicate an unlimited quota. No other
     *           negative values are allowed.
     *           Used by group-based quotas only.
     *     @type int|string $max_limit
     *           Maximum number of tokens that can be consumed during the specified
     *           duration. Client application developers can override the default limit up
     *           to this maximum. If specified, this value cannot be set to a value less
     *           than the default limit. If not specified, it is set to the default limit.
     *           To allow clients to apply overrides with no upper bound, set this to -1,
     *           indicating unlimited maximum quota.
     *           Used by group-based quotas only.
     *     @type int|string $free_tier
     *           Free tier value displayed in the Developers Console for this limit.
     *           The free tier is the number of tokens that will be subtracted from the
     *           billed amount when billing is enabled.
     *           This field can only be set on a limit with duration "1d", in a billable
     *           group; it is invalid on any other limit. If this field is not set, it
     *           defaults to 0, indicating that there is no free tier for this service.
     *           Used by group-based quotas only.
     *     @type string $duration
     *           Duration of this limit in textual notation. Must be "100s" or "1d".
     *           Used by group-based quotas only.
     *     @type string $metric
     *           The name of the metric this quota limit applies to. The quota limits with
     *           the same metric will be checked together during runtime. The metric must be
     *           defined within the service config.
     *     @type string $unit
     *           Specify the unit of the quota limit. It uses the same syntax as
     *           [Metric.unit][]. The supported unit kinds are determined by the quota
     *           backend system.
     *           Here are some examples:
     *           * "1/min/{project}" for quota per minute per project.
     *           Note: the order of unit components is insignificant.
     *           The "1" at the beginning is required to follow the metric unit syntax.
     *     @type array|\Google\Protobuf\Internal\MapField $values
     *           Tiered limit values. You must specify this as a key:value pair, with an
     *           integer value that is the maximum number of requests allowed for the
     *           specified unit. Currently only STANDARD is supported.
     *     @type string $display_name
     *           User-visible display name for this limit.
     *           Optional. If not set, the UI will provide a default display name based on
     *           the quota configuration. This field can be used to override the default
     *           display name generated from the configuration.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Api\Quota::initOnce();
        parent::__construct($data);
    }
    /**
     * Name of the quota limit.
     * The name must be provided, and it must be unique within the service. The
     * name can only include alphanumeric characters as well as '-'.
     * The maximum length of the limit name is 64 characters.
     *
     * Generated from protobuf field <code>string name = 6;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Name of the quota limit.
     * The name must be provided, and it must be unique within the service. The
     * name can only include alphanumeric characters as well as '-'.
     * The maximum length of the limit name is 64 characters.
     *
     * Generated from protobuf field <code>string name = 6;</code>
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
     * Optional. User-visible, extended description for this quota limit.
     * Should be used only when more context is needed to understand this limit
     * than provided by the limit's display name (see: `display_name`).
     *
     * Generated from protobuf field <code>string description = 2;</code>
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Optional. User-visible, extended description for this quota limit.
     * Should be used only when more context is needed to understand this limit
     * than provided by the limit's display name (see: `display_name`).
     *
     * Generated from protobuf field <code>string description = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setDescription($var)
    {
        GPBUtil::checkString($var, True);
        $this->description = $var;
        return $this;
    }
    /**
     * Default number of tokens that can be consumed during the specified
     * duration. This is the number of tokens assigned when a client
     * application developer activates the service for his/her project.
     * Specifying a value of 0 will block all requests. This can be used if you
     * are provisioning quota to selected consumers and blocking others.
     * Similarly, a value of -1 will indicate an unlimited quota. No other
     * negative values are allowed.
     * Used by group-based quotas only.
     *
     * Generated from protobuf field <code>int64 default_limit = 3;</code>
     * @return int|string
     */
    public function getDefaultLimit()
    {
        return $this->default_limit;
    }
    /**
     * Default number of tokens that can be consumed during the specified
     * duration. This is the number of tokens assigned when a client
     * application developer activates the service for his/her project.
     * Specifying a value of 0 will block all requests. This can be used if you
     * are provisioning quota to selected consumers and blocking others.
     * Similarly, a value of -1 will indicate an unlimited quota. No other
     * negative values are allowed.
     * Used by group-based quotas only.
     *
     * Generated from protobuf field <code>int64 default_limit = 3;</code>
     * @param int|string $var
     * @return $this
     */
    public function setDefaultLimit($var)
    {
        GPBUtil::checkInt64($var);
        $this->default_limit = $var;
        return $this;
    }
    /**
     * Maximum number of tokens that can be consumed during the specified
     * duration. Client application developers can override the default limit up
     * to this maximum. If specified, this value cannot be set to a value less
     * than the default limit. If not specified, it is set to the default limit.
     * To allow clients to apply overrides with no upper bound, set this to -1,
     * indicating unlimited maximum quota.
     * Used by group-based quotas only.
     *
     * Generated from protobuf field <code>int64 max_limit = 4;</code>
     * @return int|string
     */
    public function getMaxLimit()
    {
        return $this->max_limit;
    }
    /**
     * Maximum number of tokens that can be consumed during the specified
     * duration. Client application developers can override the default limit up
     * to this maximum. If specified, this value cannot be set to a value less
     * than the default limit. If not specified, it is set to the default limit.
     * To allow clients to apply overrides with no upper bound, set this to -1,
     * indicating unlimited maximum quota.
     * Used by group-based quotas only.
     *
     * Generated from protobuf field <code>int64 max_limit = 4;</code>
     * @param int|string $var
     * @return $this
     */
    public function setMaxLimit($var)
    {
        GPBUtil::checkInt64($var);
        $this->max_limit = $var;
        return $this;
    }
    /**
     * Free tier value displayed in the Developers Console for this limit.
     * The free tier is the number of tokens that will be subtracted from the
     * billed amount when billing is enabled.
     * This field can only be set on a limit with duration "1d", in a billable
     * group; it is invalid on any other limit. If this field is not set, it
     * defaults to 0, indicating that there is no free tier for this service.
     * Used by group-based quotas only.
     *
     * Generated from protobuf field <code>int64 free_tier = 7;</code>
     * @return int|string
     */
    public function getFreeTier()
    {
        return $this->free_tier;
    }
    /**
     * Free tier value displayed in the Developers Console for this limit.
     * The free tier is the number of tokens that will be subtracted from the
     * billed amount when billing is enabled.
     * This field can only be set on a limit with duration "1d", in a billable
     * group; it is invalid on any other limit. If this field is not set, it
     * defaults to 0, indicating that there is no free tier for this service.
     * Used by group-based quotas only.
     *
     * Generated from protobuf field <code>int64 free_tier = 7;</code>
     * @param int|string $var
     * @return $this
     */
    public function setFreeTier($var)
    {
        GPBUtil::checkInt64($var);
        $this->free_tier = $var;
        return $this;
    }
    /**
     * Duration of this limit in textual notation. Must be "100s" or "1d".
     * Used by group-based quotas only.
     *
     * Generated from protobuf field <code>string duration = 5;</code>
     * @return string
     */
    public function getDuration()
    {
        return $this->duration;
    }
    /**
     * Duration of this limit in textual notation. Must be "100s" or "1d".
     * Used by group-based quotas only.
     *
     * Generated from protobuf field <code>string duration = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setDuration($var)
    {
        GPBUtil::checkString($var, True);
        $this->duration = $var;
        return $this;
    }
    /**
     * The name of the metric this quota limit applies to. The quota limits with
     * the same metric will be checked together during runtime. The metric must be
     * defined within the service config.
     *
     * Generated from protobuf field <code>string metric = 8;</code>
     * @return string
     */
    public function getMetric()
    {
        return $this->metric;
    }
    /**
     * The name of the metric this quota limit applies to. The quota limits with
     * the same metric will be checked together during runtime. The metric must be
     * defined within the service config.
     *
     * Generated from protobuf field <code>string metric = 8;</code>
     * @param string $var
     * @return $this
     */
    public function setMetric($var)
    {
        GPBUtil::checkString($var, True);
        $this->metric = $var;
        return $this;
    }
    /**
     * Specify the unit of the quota limit. It uses the same syntax as
     * [Metric.unit][]. The supported unit kinds are determined by the quota
     * backend system.
     * Here are some examples:
     * * "1/min/{project}" for quota per minute per project.
     * Note: the order of unit components is insignificant.
     * The "1" at the beginning is required to follow the metric unit syntax.
     *
     * Generated from protobuf field <code>string unit = 9;</code>
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }
    /**
     * Specify the unit of the quota limit. It uses the same syntax as
     * [Metric.unit][]. The supported unit kinds are determined by the quota
     * backend system.
     * Here are some examples:
     * * "1/min/{project}" for quota per minute per project.
     * Note: the order of unit components is insignificant.
     * The "1" at the beginning is required to follow the metric unit syntax.
     *
     * Generated from protobuf field <code>string unit = 9;</code>
     * @param string $var
     * @return $this
     */
    public function setUnit($var)
    {
        GPBUtil::checkString($var, True);
        $this->unit = $var;
        return $this;
    }
    /**
     * Tiered limit values. You must specify this as a key:value pair, with an
     * integer value that is the maximum number of requests allowed for the
     * specified unit. Currently only STANDARD is supported.
     *
     * Generated from protobuf field <code>map<string, int64> values = 10;</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getValues()
    {
        return $this->values;
    }
    /**
     * Tiered limit values. You must specify this as a key:value pair, with an
     * integer value that is the maximum number of requests allowed for the
     * specified unit. Currently only STANDARD is supported.
     *
     * Generated from protobuf field <code>map<string, int64> values = 10;</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setValues($var)
    {
        $arr = GPBUtil::checkMapField($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::STRING, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::INT64);
        $this->values = $arr;
        return $this;
    }
    /**
     * User-visible display name for this limit.
     * Optional. If not set, the UI will provide a default display name based on
     * the quota configuration. This field can be used to override the default
     * display name generated from the configuration.
     *
     * Generated from protobuf field <code>string display_name = 12;</code>
     * @return string
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }
    /**
     * User-visible display name for this limit.
     * Optional. If not set, the UI will provide a default display name based on
     * the quota configuration. This field can be used to override the default
     * display name generated from the configuration.
     *
     * Generated from protobuf field <code>string display_name = 12;</code>
     * @param string $var
     * @return $this
     */
    public function setDisplayName($var)
    {
        GPBUtil::checkString($var, True);
        $this->display_name = $var;
        return $this;
    }
}
