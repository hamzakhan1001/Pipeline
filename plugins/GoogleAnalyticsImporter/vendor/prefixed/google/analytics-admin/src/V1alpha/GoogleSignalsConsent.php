<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1alpha/resources.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha;

use UnexpectedValueException;
/**
 * Consent field of the Google Signals settings.
 *
 * Protobuf type <code>google.analytics.admin.v1alpha.GoogleSignalsConsent</code>
 */
class GoogleSignalsConsent
{
    /**
     * Google Signals consent value defaults to
     * GOOGLE_SIGNALS_CONSENT_UNSPECIFIED.  This will be treated as
     * GOOGLE_SIGNALS_CONSENT_NOT_CONSENTED.
     *
     * Generated from protobuf enum <code>GOOGLE_SIGNALS_CONSENT_UNSPECIFIED = 0;</code>
     */
    const GOOGLE_SIGNALS_CONSENT_UNSPECIFIED = 0;
    /**
     * Terms of service have been accepted
     *
     * Generated from protobuf enum <code>GOOGLE_SIGNALS_CONSENT_CONSENTED = 2;</code>
     */
    const GOOGLE_SIGNALS_CONSENT_CONSENTED = 2;
    /**
     * Terms of service have not been accepted
     *
     * Generated from protobuf enum <code>GOOGLE_SIGNALS_CONSENT_NOT_CONSENTED = 1;</code>
     */
    const GOOGLE_SIGNALS_CONSENT_NOT_CONSENTED = 1;
    private static $valueToName = [self::GOOGLE_SIGNALS_CONSENT_UNSPECIFIED => 'GOOGLE_SIGNALS_CONSENT_UNSPECIFIED', self::GOOGLE_SIGNALS_CONSENT_CONSENTED => 'GOOGLE_SIGNALS_CONSENT_CONSENTED', self::GOOGLE_SIGNALS_CONSENT_NOT_CONSENTED => 'GOOGLE_SIGNALS_CONSENT_NOT_CONSENTED'];
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
