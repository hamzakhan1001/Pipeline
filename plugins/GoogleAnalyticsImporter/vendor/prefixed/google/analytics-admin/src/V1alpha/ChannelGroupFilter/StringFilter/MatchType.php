<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1alpha/channel_group.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha\ChannelGroupFilter\StringFilter;

use UnexpectedValueException;
/**
 * How the filter will be used to determine a match.
 *
 * Protobuf type <code>google.analytics.admin.v1alpha.ChannelGroupFilter.StringFilter.MatchType</code>
 */
class MatchType
{
    /**
     * Default match type.
     *
     * Generated from protobuf enum <code>MATCH_TYPE_UNSPECIFIED = 0;</code>
     */
    const MATCH_TYPE_UNSPECIFIED = 0;
    /**
     * Exact match of the string value.
     *
     * Generated from protobuf enum <code>EXACT = 1;</code>
     */
    const EXACT = 1;
    /**
     * Begins with the string value.
     *
     * Generated from protobuf enum <code>BEGINS_WITH = 2;</code>
     */
    const BEGINS_WITH = 2;
    /**
     * Ends with the string value.
     *
     * Generated from protobuf enum <code>ENDS_WITH = 3;</code>
     */
    const ENDS_WITH = 3;
    /**
     * Contains the string value.
     *
     * Generated from protobuf enum <code>CONTAINS = 4;</code>
     */
    const CONTAINS = 4;
    /**
     * Full regular expression match with the string value.
     *
     * Generated from protobuf enum <code>FULL_REGEXP = 5;</code>
     */
    const FULL_REGEXP = 5;
    /**
     * Partial regular expression match with the string value.
     *
     * Generated from protobuf enum <code>PARTIAL_REGEXP = 6;</code>
     */
    const PARTIAL_REGEXP = 6;
    private static $valueToName = [self::MATCH_TYPE_UNSPECIFIED => 'MATCH_TYPE_UNSPECIFIED', self::EXACT => 'EXACT', self::BEGINS_WITH => 'BEGINS_WITH', self::ENDS_WITH => 'ENDS_WITH', self::CONTAINS => 'CONTAINS', self::FULL_REGEXP => 'FULL_REGEXP', self::PARTIAL_REGEXP => 'PARTIAL_REGEXP'];
    public static function name($value)
    {
        if (!isset(self::$valueToName[$value])) {
            throw new UnexpectedValueException(sprintf('Enum %s has no name defined for value %s', __CLASS__, $value));
        }
        return self::$valueToName[$value];
    }
    public static function value($name)
    {
        $const = __CLASS__ . '::' . strtoupper($name);
        if (!defined($const)) {
            throw new UnexpectedValueException(sprintf('Enum %s has no value defined for name %s', __CLASS__, $name));
        }
        return constant($const);
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
class_alias(MatchType::class, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha\ChannelGroupFilter_StringFilter_MatchType::class);
