<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/data/v1alpha/data.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Data\V1alpha;

use UnexpectedValueException;
/**
 * Scoping specifies which events are considered when evaluating if a
 * session meets a criteria.
 *
 * Protobuf type <code>google.analytics.data.v1alpha.SessionCriteriaScoping</code>
 */
class SessionCriteriaScoping
{
    /**
     * Unspecified criteria scoping. Do not specify.
     *
     * Generated from protobuf enum <code>SESSION_CRITERIA_SCOPING_UNSPECIFIED = 0;</code>
     */
    const SESSION_CRITERIA_SCOPING_UNSPECIFIED = 0;
    /**
     * If the criteria is satisfied within one event, the session matches the
     * criteria.
     *
     * Generated from protobuf enum <code>SESSION_CRITERIA_WITHIN_SAME_EVENT = 1;</code>
     */
    const SESSION_CRITERIA_WITHIN_SAME_EVENT = 1;
    /**
     * If the criteria is satisfied within one session, the session matches
     * the criteria.
     *
     * Generated from protobuf enum <code>SESSION_CRITERIA_WITHIN_SAME_SESSION = 2;</code>
     */
    const SESSION_CRITERIA_WITHIN_SAME_SESSION = 2;
    private static $valueToName = [self::SESSION_CRITERIA_SCOPING_UNSPECIFIED => 'SESSION_CRITERIA_SCOPING_UNSPECIFIED', self::SESSION_CRITERIA_WITHIN_SAME_EVENT => 'SESSION_CRITERIA_WITHIN_SAME_EVENT', self::SESSION_CRITERIA_WITHIN_SAME_SESSION => 'SESSION_CRITERIA_WITHIN_SAME_SESSION'];
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
