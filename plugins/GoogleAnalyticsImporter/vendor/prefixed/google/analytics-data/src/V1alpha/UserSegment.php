<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/data/v1alpha/data.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * User segments are subsets of users who engaged with your site or app. For
 * example, users who have previously purchased; users who added items to their
 * shopping carts, but didn’t complete a purchase.
 *
 * Generated from protobuf message <code>google.analytics.data.v1alpha.UserSegment</code>
 */
class UserSegment extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * Defines which users are included in this segment. Optional.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.UserSegmentCriteria user_inclusion_criteria = 1;</code>
     */
    private $user_inclusion_criteria = null;
    /**
     * Defines which users are excluded in this segment. Optional.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.UserSegmentExclusion exclusion = 2;</code>
     */
    private $exclusion = null;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Analytics\Data\V1alpha\UserSegmentCriteria $user_inclusion_criteria
     *           Defines which users are included in this segment. Optional.
     *     @type \Google\Analytics\Data\V1alpha\UserSegmentExclusion $exclusion
     *           Defines which users are excluded in this segment. Optional.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Data\V1Alpha\Data::initOnce();
        parent::__construct($data);
    }
    /**
     * Defines which users are included in this segment. Optional.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.UserSegmentCriteria user_inclusion_criteria = 1;</code>
     * @return \Google\Analytics\Data\V1alpha\UserSegmentCriteria|null
     */
    public function getUserInclusionCriteria()
    {
        return $this->user_inclusion_criteria;
    }
    public function hasUserInclusionCriteria()
    {
        return isset($this->user_inclusion_criteria);
    }
    public function clearUserInclusionCriteria()
    {
        unset($this->user_inclusion_criteria);
    }
    /**
     * Defines which users are included in this segment. Optional.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.UserSegmentCriteria user_inclusion_criteria = 1;</code>
     * @param \Google\Analytics\Data\V1alpha\UserSegmentCriteria $var
     * @return $this
     */
    public function setUserInclusionCriteria($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha\UserSegmentCriteria::class);
        $this->user_inclusion_criteria = $var;
        return $this;
    }
    /**
     * Defines which users are excluded in this segment. Optional.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.UserSegmentExclusion exclusion = 2;</code>
     * @return \Google\Analytics\Data\V1alpha\UserSegmentExclusion|null
     */
    public function getExclusion()
    {
        return $this->exclusion;
    }
    public function hasExclusion()
    {
        return isset($this->exclusion);
    }
    public function clearExclusion()
    {
        unset($this->exclusion);
    }
    /**
     * Defines which users are excluded in this segment. Optional.
     *
     * Generated from protobuf field <code>.google.analytics.data.v1alpha.UserSegmentExclusion exclusion = 2;</code>
     * @param \Google\Analytics\Data\V1alpha\UserSegmentExclusion $var
     * @return $this
     */
    public function setExclusion($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha\UserSegmentExclusion::class);
        $this->exclusion = $var;
        return $this;
    }
}
