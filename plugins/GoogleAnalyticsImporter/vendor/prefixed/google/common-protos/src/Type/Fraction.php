<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/type/fraction.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Type;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * Represents a fraction in terms of a numerator divided by a denominator.
 *
 * Generated from protobuf message <code>google.type.Fraction</code>
 */
class Fraction extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * The numerator in the fraction, e.g. 2 in 2/3.
     *
     * Generated from protobuf field <code>int64 numerator = 1;</code>
     */
    protected $numerator = 0;
    /**
     * The value by which the numerator is divided, e.g. 3 in 2/3. Must be
     * positive.
     *
     * Generated from protobuf field <code>int64 denominator = 2;</code>
     */
    protected $denominator = 0;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int|string $numerator
     *           The numerator in the fraction, e.g. 2 in 2/3.
     *     @type int|string $denominator
     *           The value by which the numerator is divided, e.g. 3 in 2/3. Must be
     *           positive.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Type\Fraction::initOnce();
        parent::__construct($data);
    }
    /**
     * The numerator in the fraction, e.g. 2 in 2/3.
     *
     * Generated from protobuf field <code>int64 numerator = 1;</code>
     * @return int|string
     */
    public function getNumerator()
    {
        return $this->numerator;
    }
    /**
     * The numerator in the fraction, e.g. 2 in 2/3.
     *
     * Generated from protobuf field <code>int64 numerator = 1;</code>
     * @param int|string $var
     * @return $this
     */
    public function setNumerator($var)
    {
        GPBUtil::checkInt64($var);
        $this->numerator = $var;
        return $this;
    }
    /**
     * The value by which the numerator is divided, e.g. 3 in 2/3. Must be
     * positive.
     *
     * Generated from protobuf field <code>int64 denominator = 2;</code>
     * @return int|string
     */
    public function getDenominator()
    {
        return $this->denominator;
    }
    /**
     * The value by which the numerator is divided, e.g. 3 in 2/3. Must be
     * positive.
     *
     * Generated from protobuf field <code>int64 denominator = 2;</code>
     * @param int|string $var
     * @return $this
     */
    public function setDenominator($var)
    {
        GPBUtil::checkInt64($var);
        $this->denominator = $var;
        return $this;
    }
}
