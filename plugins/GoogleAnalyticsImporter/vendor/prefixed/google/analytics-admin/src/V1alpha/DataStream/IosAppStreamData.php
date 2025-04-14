<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1alpha/resources.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha\DataStream;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * Data specific to iOS app streams.
 *
 * Generated from protobuf message <code>google.analytics.admin.v1alpha.DataStream.IosAppStreamData</code>
 */
class IosAppStreamData extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * Output only. ID of the corresponding iOS app in Firebase, if any.
     * This ID can change if the iOS app is deleted and recreated.
     *
     * Generated from protobuf field <code>string firebase_app_id = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    private $firebase_app_id = '';
    /**
     * Required. Immutable. The Apple App Store Bundle ID for the app
     * Example: "com.example.myiosapp"
     *
     * Generated from protobuf field <code>string bundle_id = 2 [(.google.api.field_behavior) = IMMUTABLE, (.google.api.field_behavior) = REQUIRED];</code>
     */
    private $bundle_id = '';
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $firebase_app_id
     *           Output only. ID of the corresponding iOS app in Firebase, if any.
     *           This ID can change if the iOS app is deleted and recreated.
     *     @type string $bundle_id
     *           Required. Immutable. The Apple App Store Bundle ID for the app
     *           Example: "com.example.myiosapp"
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Admin\V1Alpha\Resources::initOnce();
        parent::__construct($data);
    }
    /**
     * Output only. ID of the corresponding iOS app in Firebase, if any.
     * This ID can change if the iOS app is deleted and recreated.
     *
     * Generated from protobuf field <code>string firebase_app_id = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return string
     */
    public function getFirebaseAppId()
    {
        return $this->firebase_app_id;
    }
    /**
     * Output only. ID of the corresponding iOS app in Firebase, if any.
     * This ID can change if the iOS app is deleted and recreated.
     *
     * Generated from protobuf field <code>string firebase_app_id = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param string $var
     * @return $this
     */
    public function setFirebaseAppId($var)
    {
        GPBUtil::checkString($var, True);
        $this->firebase_app_id = $var;
        return $this;
    }
    /**
     * Required. Immutable. The Apple App Store Bundle ID for the app
     * Example: "com.example.myiosapp"
     *
     * Generated from protobuf field <code>string bundle_id = 2 [(.google.api.field_behavior) = IMMUTABLE, (.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getBundleId()
    {
        return $this->bundle_id;
    }
    /**
     * Required. Immutable. The Apple App Store Bundle ID for the app
     * Example: "com.example.myiosapp"
     *
     * Generated from protobuf field <code>string bundle_id = 2 [(.google.api.field_behavior) = IMMUTABLE, (.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setBundleId($var)
    {
        GPBUtil::checkString($var, True);
        $this->bundle_id = $var;
        return $this;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
class_alias(IosAppStreamData::class, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Analytics\Admin\V1alpha\DataStream_IosAppStreamData::class);
