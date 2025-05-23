<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1alpha/analytics_admin.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * Response message for CreateRollupProperty RPC.
 *
 * Generated from protobuf message <code>google.analytics.admin.v1alpha.CreateRollupPropertyResponse</code>
 */
class CreateRollupPropertyResponse extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * The created roll-up property.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1alpha.Property rollup_property = 1;</code>
     */
    private $rollup_property = null;
    /**
     * The created roll-up property source links.
     *
     * Generated from protobuf field <code>repeated .google.analytics.admin.v1alpha.RollupPropertySourceLink rollup_property_source_links = 2;</code>
     */
    private $rollup_property_source_links;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Analytics\Admin\V1alpha\Property $rollup_property
     *           The created roll-up property.
     *     @type array<\Google\Analytics\Admin\V1alpha\RollupPropertySourceLink>|\Google\Protobuf\Internal\RepeatedField $rollup_property_source_links
     *           The created roll-up property source links.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Admin\V1Alpha\AnalyticsAdmin::initOnce();
        parent::__construct($data);
    }
    /**
     * The created roll-up property.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1alpha.Property rollup_property = 1;</code>
     * @return \Google\Analytics\Admin\V1alpha\Property|null
     */
    public function getRollupProperty()
    {
        return $this->rollup_property;
    }
    public function hasRollupProperty()
    {
        return isset($this->rollup_property);
    }
    public function clearRollupProperty()
    {
        unset($this->rollup_property);
    }
    /**
     * The created roll-up property.
     *
     * Generated from protobuf field <code>.google.analytics.admin.v1alpha.Property rollup_property = 1;</code>
     * @param \Google\Analytics\Admin\V1alpha\Property $var
     * @return $this
     */
    public function setRollupProperty($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha\Property::class);
        $this->rollup_property = $var;
        return $this;
    }
    /**
     * The created roll-up property source links.
     *
     * Generated from protobuf field <code>repeated .google.analytics.admin.v1alpha.RollupPropertySourceLink rollup_property_source_links = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getRollupPropertySourceLinks()
    {
        return $this->rollup_property_source_links;
    }
    /**
     * The created roll-up property source links.
     *
     * Generated from protobuf field <code>repeated .google.analytics.admin.v1alpha.RollupPropertySourceLink rollup_property_source_links = 2;</code>
     * @param array<\Google\Analytics\Admin\V1alpha\RollupPropertySourceLink>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setRollupPropertySourceLinks($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::MESSAGE, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha\RollupPropertySourceLink::class);
        $this->rollup_property_source_links = $arr;
        return $this;
    }
}
