<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/api/distribution.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Api\Distribution\BucketOptions;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * Specifies a set of buckets with arbitrary widths.
 * There are `size(bounds) + 1` (= N) buckets. Bucket `i` has the following
 * boundaries:
 *    Upper bound (0 <= i < N-1):     bounds[i]
 *    Lower bound (1 <= i < N);       bounds[i - 1]
 * The `bounds` field must contain at least one element. If `bounds` has
 * only one element, then there are no finite buckets, and that single
 * element is the common boundary of the overflow and underflow buckets.
 *
 * Generated from protobuf message <code>google.api.Distribution.BucketOptions.Explicit</code>
 */
class Explicit extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * The values must be monotonically increasing.
     *
     * Generated from protobuf field <code>repeated double bounds = 1;</code>
     */
    private $bounds;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<float>|\Google\Protobuf\Internal\RepeatedField $bounds
     *           The values must be monotonically increasing.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Api\Distribution::initOnce();
        parent::__construct($data);
    }
    /**
     * The values must be monotonically increasing.
     *
     * Generated from protobuf field <code>repeated double bounds = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getBounds()
    {
        return $this->bounds;
    }
    /**
     * The values must be monotonically increasing.
     *
     * Generated from protobuf field <code>repeated double bounds = 1;</code>
     * @param array<float>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setBounds($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::DOUBLE);
        $this->bounds = $arr;
        return $this;
    }
}
