<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/api/field_info.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Api;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * Rich semantic information of an API field beyond basic typing.
 *
 * Generated from protobuf message <code>google.api.FieldInfo</code>
 */
class FieldInfo extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * The standard format of a field value. This does not explicitly configure
     * any API consumer, just documents the API's format for the field it is
     * applied to.
     *
     * Generated from protobuf field <code>.google.api.FieldInfo.Format format = 1;</code>
     */
    protected $format = 0;
    /**
     * The type(s) that the annotated, generic field may represent.
     * Currently, this must only be used on fields of type `google.protobuf.Any`.
     * Supporting other generic types may be considered in the future.
     *
     * Generated from protobuf field <code>repeated .google.api.TypeReference referenced_types = 2;</code>
     */
    private $referenced_types;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $format
     *           The standard format of a field value. This does not explicitly configure
     *           any API consumer, just documents the API's format for the field it is
     *           applied to.
     *     @type array<\Google\Api\TypeReference>|\Google\Protobuf\Internal\RepeatedField $referenced_types
     *           The type(s) that the annotated, generic field may represent.
     *           Currently, this must only be used on fields of type `google.protobuf.Any`.
     *           Supporting other generic types may be considered in the future.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Api\FieldInfo::initOnce();
        parent::__construct($data);
    }
    /**
     * The standard format of a field value. This does not explicitly configure
     * any API consumer, just documents the API's format for the field it is
     * applied to.
     *
     * Generated from protobuf field <code>.google.api.FieldInfo.Format format = 1;</code>
     * @return int
     */
    public function getFormat()
    {
        return $this->format;
    }
    /**
     * The standard format of a field value. This does not explicitly configure
     * any API consumer, just documents the API's format for the field it is
     * applied to.
     *
     * Generated from protobuf field <code>.google.api.FieldInfo.Format format = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setFormat($var)
    {
        GPBUtil::checkEnum($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Api\FieldInfo\Format::class);
        $this->format = $var;
        return $this;
    }
    /**
     * The type(s) that the annotated, generic field may represent.
     * Currently, this must only be used on fields of type `google.protobuf.Any`.
     * Supporting other generic types may be considered in the future.
     *
     * Generated from protobuf field <code>repeated .google.api.TypeReference referenced_types = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getReferencedTypes()
    {
        return $this->referenced_types;
    }
    /**
     * The type(s) that the annotated, generic field may represent.
     * Currently, this must only be used on fields of type `google.protobuf.Any`.
     * Supporting other generic types may be considered in the future.
     *
     * Generated from protobuf field <code>repeated .google.api.TypeReference referenced_types = 2;</code>
     * @param array<\Google\Api\TypeReference>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setReferencedTypes($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::MESSAGE, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Api\TypeReference::class);
        $this->referenced_types = $arr;
        return $this;
    }
}
