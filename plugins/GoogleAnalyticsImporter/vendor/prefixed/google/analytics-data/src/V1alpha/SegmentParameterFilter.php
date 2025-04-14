<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/data/v1alpha/data.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * An expression to filter parameter values in a segment.
 *
 * Generated from protobuf message <code>google.analytics.data.v1alpha.SegmentParameterFilter</code>
 */
class SegmentParameterFilter extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * Specifies the scope for the filter.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.SegmentParameterFilterScoping filter_scoping = 8;</code>
     */
    private $filter_scoping = null;
    protected $one_parameter;
    protected $one_filter;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $event_parameter_name
     *           This filter will be evaluated on the specified event parameter. Event
     *           parameters are logged as parameters of the event. Event parameters
     *           include fields like "firebase_screen" & "currency".
     *           Event parameters can only be used in segments & funnels and can only be
     *           used in a descendent filter from an EventFilter. In a descendent filter
     *           from an EventFilter either event or item parameters should be used.
     *     @type string $item_parameter_name
     *           This filter will be evaluated on the specified item parameter. Item
     *           parameters are logged as parameters in the item array. Item parameters
     *           include fields like "item_name" & "item_category".
     *           Item parameters can only be used in segments & funnels and can only be
     *           used in a descendent filter from an EventFilter. In a descendent filter
     *           from an EventFilter either event or item parameters should be used.
     *           Item parameters are only available in ecommerce events. To learn more
     *           about ecommerce events, see the [Measure ecommerce]
     *           (https://developers.google.com/analytics/devguides/collection/ga4/ecommerce)
     *           guide.
     *     @type \Google\Analytics\Data\V1alpha\StringFilter $string_filter
     *           Strings related filter.
     *     @type \Google\Analytics\Data\V1alpha\InListFilter $in_list_filter
     *           A filter for in list values.
     *     @type \Google\Analytics\Data\V1alpha\NumericFilter $numeric_filter
     *           A filter for numeric or date values.
     *     @type \Google\Analytics\Data\V1alpha\BetweenFilter $between_filter
     *           A filter for between two values.
     *     @type \Google\Analytics\Data\V1alpha\SegmentParameterFilterScoping $filter_scoping
     *           Specifies the scope for the filter.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Data\V1Alpha\Data::initOnce();
        parent::__construct($data);
    }
    /**
     * This filter will be evaluated on the specified event parameter. Event
     * parameters are logged as parameters of the event. Event parameters
     * include fields like "firebase_screen" & "currency".
     * Event parameters can only be used in segments & funnels and can only be
     * used in a descendent filter from an EventFilter. In a descendent filter
     * from an EventFilter either event or item parameters should be used.
     *
     * Generated from protobuf field <code>string event_parameter_name = 1;</code>
     * @return string
     */
    public function getEventParameterName()
    {
        return $this->readOneof(1);
    }
    public function hasEventParameterName()
    {
        return $this->hasOneof(1);
    }
    /**
     * This filter will be evaluated on the specified event parameter. Event
     * parameters are logged as parameters of the event. Event parameters
     * include fields like "firebase_screen" & "currency".
     * Event parameters can only be used in segments & funnels and can only be
     * used in a descendent filter from an EventFilter. In a descendent filter
     * from an EventFilter either event or item parameters should be used.
     *
     * Generated from protobuf field <code>string event_parameter_name = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setEventParameterName($var)
    {
        GPBUtil::checkString($var, True);
        $this->writeOneof(1, $var);
        return $this;
    }
    /**
     * This filter will be evaluated on the specified item parameter. Item
     * parameters are logged as parameters in the item array. Item parameters
     * include fields like "item_name" & "item_category".
     * Item parameters can only be used in segments & funnels and can only be
     * used in a descendent filter from an EventFilter. In a descendent filter
     * from an EventFilter either event or item parameters should be used.
     * Item parameters are only available in ecommerce events. To learn more
     * about ecommerce events, see the [Measure ecommerce]
     * (https://developers.google.com/analytics/devguides/collection/ga4/ecommerce)
     * guide.
     *
     * Generated from protobuf field <code>string item_parameter_name = 2;</code>
     * @return string
     */
    public function getItemParameterName()
    {
        return $this->readOneof(2);
    }
    public function hasItemParameterName()
    {
        return $this->hasOneof(2);
    }
    /**
     * This filter will be evaluated on the specified item parameter. Item
     * parameters are logged as parameters in the item array. Item parameters
     * include fields like "item_name" & "item_category".
     * Item parameters can only be used in segments & funnels and can only be
     * used in a descendent filter from an EventFilter. In a descendent filter
     * from an EventFilter either event or item parameters should be used.
     * Item parameters are only available in ecommerce events. To learn more
     * about ecommerce events, see the [Measure ecommerce]
     * (https://developers.google.com/analytics/devguides/collection/ga4/ecommerce)
     * guide.
     *
     * Generated from protobuf field <code>string item_parameter_name = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setItemParameterName($var)
    {
        GPBUtil::checkString($var, True);
        $this->writeOneof(2, $var);
        return $this;
    }
    /**
     * Strings related filter.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.StringFilter string_filter = 4;</code>
     * @return \Google\Analytics\Data\V1alpha\StringFilter|null
     */
    public function getStringFilter()
    {
        return $this->readOneof(4);
    }
    public function hasStringFilter()
    {
        return $this->hasOneof(4);
    }
    /**
     * Strings related filter.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.StringFilter string_filter = 4;</code>
     * @param \Google\Analytics\Data\V1alpha\StringFilter $var
     * @return $this
     */
    public function setStringFilter($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha\StringFilter::class);
        $this->writeOneof(4, $var);
        return $this;
    }
    /**
     * A filter for in list values.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.InListFilter in_list_filter = 5;</code>
     * @return \Google\Analytics\Data\V1alpha\InListFilter|null
     */
    public function getInListFilter()
    {
        return $this->readOneof(5);
    }
    public function hasInListFilter()
    {
        return $this->hasOneof(5);
    }
    /**
     * A filter for in list values.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.InListFilter in_list_filter = 5;</code>
     * @param \Google\Analytics\Data\V1alpha\InListFilter $var
     * @return $this
     */
    public function setInListFilter($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha\InListFilter::class);
        $this->writeOneof(5, $var);
        return $this;
    }
    /**
     * A filter for numeric or date values.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.NumericFilter numeric_filter = 6;</code>
     * @return \Google\Analytics\Data\V1alpha\NumericFilter|null
     */
    public function getNumericFilter()
    {
        return $this->readOneof(6);
    }
    public function hasNumericFilter()
    {
        return $this->hasOneof(6);
    }
    /**
     * A filter for numeric or date values.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.NumericFilter numeric_filter = 6;</code>
     * @param \Google\Analytics\Data\V1alpha\NumericFilter $var
     * @return $this
     */
    public function setNumericFilter($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha\NumericFilter::class);
        $this->writeOneof(6, $var);
        return $this;
    }
    /**
     * A filter for between two values.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.BetweenFilter between_filter = 7;</code>
     * @return \Google\Analytics\Data\V1alpha\BetweenFilter|null
     */
    public function getBetweenFilter()
    {
        return $this->readOneof(7);
    }
    public function hasBetweenFilter()
    {
        return $this->hasOneof(7);
    }
    /**
     * A filter for between two values.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.BetweenFilter between_filter = 7;</code>
     * @param \Google\Analytics\Data\V1alpha\BetweenFilter $var
     * @return $this
     */
    public function setBetweenFilter($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha\BetweenFilter::class);
        $this->writeOneof(7, $var);
        return $this;
    }
    /**
     * Specifies the scope for the filter.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.SegmentParameterFilterScoping filter_scoping = 8;</code>
     * @return \Google\Analytics\Data\V1alpha\SegmentParameterFilterScoping|null
     */
    public function getFilterScoping()
    {
        return $this->filter_scoping;
    }
    public function hasFilterScoping()
    {
        return isset($this->filter_scoping);
    }
    public function clearFilterScoping()
    {
        unset($this->filter_scoping);
    }
    /**
     * Specifies the scope for the filter.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.SegmentParameterFilterScoping filter_scoping = 8;</code>
     * @param \Google\Analytics\Data\V1alpha\SegmentParameterFilterScoping $var
     * @return $this
     */
    public function setFilterScoping($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha\SegmentParameterFilterScoping::class);
        $this->filter_scoping = $var;
        return $this;
    }
    /**
     * @return string
     */
    public function getOneParameter()
    {
        return $this->whichOneof("one_parameter");
    }
    /**
     * @return string
     */
    public function getOneFilter()
    {
        return $this->whichOneof("one_filter");
    }
}
