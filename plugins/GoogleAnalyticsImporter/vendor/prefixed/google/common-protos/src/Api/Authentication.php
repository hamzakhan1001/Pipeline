<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/api/auth.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Api;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * `Authentication` defines the authentication configuration for API methods
 * provided by an API service.
 * Example:
 *     name: calendar.googleapis.com
 *     authentication:
 *       providers:
 *       - id: google_calendar_auth
 *         jwks_uri: https://www.googleapis.com/oauth2/v1/certs
 *         issuer: https://securetoken.google.com
 *       rules:
 *       - selector: "*"
 *         requirements:
 *           provider_id: google_calendar_auth
 *       - selector: google.calendar.Delegate
 *         oauth:
 *           canonical_scopes: https://www.googleapis.com/auth/calendar.read
 *
 * Generated from protobuf message <code>google.api.Authentication</code>
 */
class Authentication extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * A list of authentication rules that apply to individual API methods.
     * **NOTE:** All service configuration rules follow "last one wins" order.
     *
     * Generated from protobuf field <code>repeated .google.api.AuthenticationRule rules = 3;</code>
     */
    private $rules;
    /**
     * Defines a set of authentication providers that a service supports.
     *
     * Generated from protobuf field <code>repeated .google.api.AuthProvider providers = 4;</code>
     */
    private $providers;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Api\AuthenticationRule>|\Google\Protobuf\Internal\RepeatedField $rules
     *           A list of authentication rules that apply to individual API methods.
     *           **NOTE:** All service configuration rules follow "last one wins" order.
     *     @type array<\Google\Api\AuthProvider>|\Google\Protobuf\Internal\RepeatedField $providers
     *           Defines a set of authentication providers that a service supports.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Api\Auth::initOnce();
        parent::__construct($data);
    }
    /**
     * A list of authentication rules that apply to individual API methods.
     * **NOTE:** All service configuration rules follow "last one wins" order.
     *
     * Generated from protobuf field <code>repeated .google.api.AuthenticationRule rules = 3;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getRules()
    {
        return $this->rules;
    }
    /**
     * A list of authentication rules that apply to individual API methods.
     * **NOTE:** All service configuration rules follow "last one wins" order.
     *
     * Generated from protobuf field <code>repeated .google.api.AuthenticationRule rules = 3;</code>
     * @param array<\Google\Api\AuthenticationRule>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setRules($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::MESSAGE, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Api\AuthenticationRule::class);
        $this->rules = $arr;
        return $this;
    }
    /**
     * Defines a set of authentication providers that a service supports.
     *
     * Generated from protobuf field <code>repeated .google.api.AuthProvider providers = 4;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getProviders()
    {
        return $this->providers;
    }
    /**
     * Defines a set of authentication providers that a service supports.
     *
     * Generated from protobuf field <code>repeated .google.api.AuthProvider providers = 4;</code>
     * @param array<\Google\Api\AuthProvider>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setProviders($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::MESSAGE, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Api\AuthProvider::class);
        $this->providers = $arr;
        return $this;
    }
}
