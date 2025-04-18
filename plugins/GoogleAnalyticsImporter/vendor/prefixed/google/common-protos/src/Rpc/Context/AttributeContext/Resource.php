<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/rpc/context/attribute_context.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Rpc\Context\AttributeContext;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * This message defines core attributes for a resource. A resource is an
 * addressable (named) entity provided by the destination service. For
 * example, a file stored on a network storage service.
 *
 * Generated from protobuf message <code>google.rpc.context.AttributeContext.Resource</code>
 */
class Resource extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * The name of the service that this resource belongs to, such as
     * `pubsub.googleapis.com`. The service may be different from the DNS
     * hostname that actually serves the request.
     *
     * Generated from protobuf field <code>string service = 1;</code>
     */
    protected $service = '';
    /**
     * The stable identifier (name) of a resource on the `service`. A resource
     * can be logically identified as "//{resource.service}/{resource.name}".
     * The differences between a resource name and a URI are:
     * *   Resource name is a logical identifier, independent of network
     *     protocol and API version. For example,
     *     `//pubsub.googleapis.com/projects/123/topics/news-feed`.
     * *   URI often includes protocol and version information, so it can
     *     be used directly by applications. For example,
     *     `https://pubsub.googleapis.com/v1/projects/123/topics/news-feed`.
     * See https://cloud.google.com/apis/design/resource_names for details.
     *
     * Generated from protobuf field <code>string name = 2;</code>
     */
    protected $name = '';
    /**
     * The type of the resource. The syntax is platform-specific because
     * different platforms define their resources differently.
     * For Google APIs, the type format must be "{service}/{kind}", such as
     * "pubsub.googleapis.com/Topic".
     *
     * Generated from protobuf field <code>string type = 3;</code>
     */
    protected $type = '';
    /**
     * The labels or tags on the resource, such as AWS resource tags and
     * Kubernetes resource labels.
     *
     * Generated from protobuf field <code>map<string, string> labels = 4;</code>
     */
    private $labels;
    /**
     * The unique identifier of the resource. UID is unique in the time
     * and space for this resource within the scope of the service. It is
     * typically generated by the server on successful creation of a resource
     * and must not be changed. UID is used to uniquely identify resources
     * with resource name reuses. This should be a UUID4.
     *
     * Generated from protobuf field <code>string uid = 5;</code>
     */
    protected $uid = '';
    /**
     * Annotations is an unstructured key-value map stored with a resource that
     * may be set by external tools to store and retrieve arbitrary metadata.
     * They are not queryable and should be preserved when modifying objects.
     * More info: https://kubernetes.io/docs/user-guide/annotations
     *
     * Generated from protobuf field <code>map<string, string> annotations = 6;</code>
     */
    private $annotations;
    /**
     * Mutable. The display name set by clients. Must be <= 63 characters.
     *
     * Generated from protobuf field <code>string display_name = 7;</code>
     */
    protected $display_name = '';
    /**
     * Output only. The timestamp when the resource was created. This may
     * be either the time creation was initiated or when it was completed.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 8;</code>
     */
    protected $create_time = null;
    /**
     * Output only. The timestamp when the resource was last updated. Any
     * change to the resource made by users must refresh this value.
     * Changes to a resource made by the service should refresh this value.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 9;</code>
     */
    protected $update_time = null;
    /**
     * Output only. The timestamp when the resource was deleted.
     * If the resource is not deleted, this must be empty.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp delete_time = 10;</code>
     */
    protected $delete_time = null;
    /**
     * Output only. An opaque value that uniquely identifies a version or
     * generation of a resource. It can be used to confirm that the client
     * and server agree on the ordering of a resource being written.
     *
     * Generated from protobuf field <code>string etag = 11;</code>
     */
    protected $etag = '';
    /**
     * Immutable. The location of the resource. The location encoding is
     * specific to the service provider, and new encoding may be introduced
     * as the service evolves.
     * For Google Cloud products, the encoding is what is used by Google Cloud
     * APIs, such as `us-east1`, `aws-us-east-1`, and `azure-eastus2`. The
     * semantics of `location` is identical to the
     * `cloud.googleapis.com/location` label used by some Google Cloud APIs.
     *
     * Generated from protobuf field <code>string location = 12;</code>
     */
    protected $location = '';
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $service
     *           The name of the service that this resource belongs to, such as
     *           `pubsub.googleapis.com`. The service may be different from the DNS
     *           hostname that actually serves the request.
     *     @type string $name
     *           The stable identifier (name) of a resource on the `service`. A resource
     *           can be logically identified as "//{resource.service}/{resource.name}".
     *           The differences between a resource name and a URI are:
     *           *   Resource name is a logical identifier, independent of network
     *               protocol and API version. For example,
     *               `//pubsub.googleapis.com/projects/123/topics/news-feed`.
     *           *   URI often includes protocol and version information, so it can
     *               be used directly by applications. For example,
     *               `https://pubsub.googleapis.com/v1/projects/123/topics/news-feed`.
     *           See https://cloud.google.com/apis/design/resource_names for details.
     *     @type string $type
     *           The type of the resource. The syntax is platform-specific because
     *           different platforms define their resources differently.
     *           For Google APIs, the type format must be "{service}/{kind}", such as
     *           "pubsub.googleapis.com/Topic".
     *     @type array|\Google\Protobuf\Internal\MapField $labels
     *           The labels or tags on the resource, such as AWS resource tags and
     *           Kubernetes resource labels.
     *     @type string $uid
     *           The unique identifier of the resource. UID is unique in the time
     *           and space for this resource within the scope of the service. It is
     *           typically generated by the server on successful creation of a resource
     *           and must not be changed. UID is used to uniquely identify resources
     *           with resource name reuses. This should be a UUID4.
     *     @type array|\Google\Protobuf\Internal\MapField $annotations
     *           Annotations is an unstructured key-value map stored with a resource that
     *           may be set by external tools to store and retrieve arbitrary metadata.
     *           They are not queryable and should be preserved when modifying objects.
     *           More info: https://kubernetes.io/docs/user-guide/annotations
     *     @type string $display_name
     *           Mutable. The display name set by clients. Must be <= 63 characters.
     *     @type \Google\Protobuf\Timestamp $create_time
     *           Output only. The timestamp when the resource was created. This may
     *           be either the time creation was initiated or when it was completed.
     *     @type \Google\Protobuf\Timestamp $update_time
     *           Output only. The timestamp when the resource was last updated. Any
     *           change to the resource made by users must refresh this value.
     *           Changes to a resource made by the service should refresh this value.
     *     @type \Google\Protobuf\Timestamp $delete_time
     *           Output only. The timestamp when the resource was deleted.
     *           If the resource is not deleted, this must be empty.
     *     @type string $etag
     *           Output only. An opaque value that uniquely identifies a version or
     *           generation of a resource. It can be used to confirm that the client
     *           and server agree on the ordering of a resource being written.
     *     @type string $location
     *           Immutable. The location of the resource. The location encoding is
     *           specific to the service provider, and new encoding may be introduced
     *           as the service evolves.
     *           For Google Cloud products, the encoding is what is used by Google Cloud
     *           APIs, such as `us-east1`, `aws-us-east-1`, and `azure-eastus2`. The
     *           semantics of `location` is identical to the
     *           `cloud.googleapis.com/location` label used by some Google Cloud APIs.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Rpc\Context\AttributeContext::initOnce();
        parent::__construct($data);
    }
    /**
     * The name of the service that this resource belongs to, such as
     * `pubsub.googleapis.com`. The service may be different from the DNS
     * hostname that actually serves the request.
     *
     * Generated from protobuf field <code>string service = 1;</code>
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }
    /**
     * The name of the service that this resource belongs to, such as
     * `pubsub.googleapis.com`. The service may be different from the DNS
     * hostname that actually serves the request.
     *
     * Generated from protobuf field <code>string service = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setService($var)
    {
        GPBUtil::checkString($var, True);
        $this->service = $var;
        return $this;
    }
    /**
     * The stable identifier (name) of a resource on the `service`. A resource
     * can be logically identified as "//{resource.service}/{resource.name}".
     * The differences between a resource name and a URI are:
     * *   Resource name is a logical identifier, independent of network
     *     protocol and API version. For example,
     *     `//pubsub.googleapis.com/projects/123/topics/news-feed`.
     * *   URI often includes protocol and version information, so it can
     *     be used directly by applications. For example,
     *     `https://pubsub.googleapis.com/v1/projects/123/topics/news-feed`.
     * See https://cloud.google.com/apis/design/resource_names for details.
     *
     * Generated from protobuf field <code>string name = 2;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * The stable identifier (name) of a resource on the `service`. A resource
     * can be logically identified as "//{resource.service}/{resource.name}".
     * The differences between a resource name and a URI are:
     * *   Resource name is a logical identifier, independent of network
     *     protocol and API version. For example,
     *     `//pubsub.googleapis.com/projects/123/topics/news-feed`.
     * *   URI often includes protocol and version information, so it can
     *     be used directly by applications. For example,
     *     `https://pubsub.googleapis.com/v1/projects/123/topics/news-feed`.
     * See https://cloud.google.com/apis/design/resource_names for details.
     *
     * Generated from protobuf field <code>string name = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;
        return $this;
    }
    /**
     * The type of the resource. The syntax is platform-specific because
     * different platforms define their resources differently.
     * For Google APIs, the type format must be "{service}/{kind}", such as
     * "pubsub.googleapis.com/Topic".
     *
     * Generated from protobuf field <code>string type = 3;</code>
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * The type of the resource. The syntax is platform-specific because
     * different platforms define their resources differently.
     * For Google APIs, the type format must be "{service}/{kind}", such as
     * "pubsub.googleapis.com/Topic".
     *
     * Generated from protobuf field <code>string type = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setType($var)
    {
        GPBUtil::checkString($var, True);
        $this->type = $var;
        return $this;
    }
    /**
     * The labels or tags on the resource, such as AWS resource tags and
     * Kubernetes resource labels.
     *
     * Generated from protobuf field <code>map<string, string> labels = 4;</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getLabels()
    {
        return $this->labels;
    }
    /**
     * The labels or tags on the resource, such as AWS resource tags and
     * Kubernetes resource labels.
     *
     * Generated from protobuf field <code>map<string, string> labels = 4;</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setLabels($var)
    {
        $arr = GPBUtil::checkMapField($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::STRING, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::STRING);
        $this->labels = $arr;
        return $this;
    }
    /**
     * The unique identifier of the resource. UID is unique in the time
     * and space for this resource within the scope of the service. It is
     * typically generated by the server on successful creation of a resource
     * and must not be changed. UID is used to uniquely identify resources
     * with resource name reuses. This should be a UUID4.
     *
     * Generated from protobuf field <code>string uid = 5;</code>
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }
    /**
     * The unique identifier of the resource. UID is unique in the time
     * and space for this resource within the scope of the service. It is
     * typically generated by the server on successful creation of a resource
     * and must not be changed. UID is used to uniquely identify resources
     * with resource name reuses. This should be a UUID4.
     *
     * Generated from protobuf field <code>string uid = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setUid($var)
    {
        GPBUtil::checkString($var, True);
        $this->uid = $var;
        return $this;
    }
    /**
     * Annotations is an unstructured key-value map stored with a resource that
     * may be set by external tools to store and retrieve arbitrary metadata.
     * They are not queryable and should be preserved when modifying objects.
     * More info: https://kubernetes.io/docs/user-guide/annotations
     *
     * Generated from protobuf field <code>map<string, string> annotations = 6;</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getAnnotations()
    {
        return $this->annotations;
    }
    /**
     * Annotations is an unstructured key-value map stored with a resource that
     * may be set by external tools to store and retrieve arbitrary metadata.
     * They are not queryable and should be preserved when modifying objects.
     * More info: https://kubernetes.io/docs/user-guide/annotations
     *
     * Generated from protobuf field <code>map<string, string> annotations = 6;</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setAnnotations($var)
    {
        $arr = GPBUtil::checkMapField($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::STRING, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::STRING);
        $this->annotations = $arr;
        return $this;
    }
    /**
     * Mutable. The display name set by clients. Must be <= 63 characters.
     *
     * Generated from protobuf field <code>string display_name = 7;</code>
     * @return string
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }
    /**
     * Mutable. The display name set by clients. Must be <= 63 characters.
     *
     * Generated from protobuf field <code>string display_name = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setDisplayName($var)
    {
        GPBUtil::checkString($var, True);
        $this->display_name = $var;
        return $this;
    }
    /**
     * Output only. The timestamp when the resource was created. This may
     * be either the time creation was initiated or when it was completed.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 8;</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }
    public function hasCreateTime()
    {
        return isset($this->create_time);
    }
    public function clearCreateTime()
    {
        unset($this->create_time);
    }
    /**
     * Output only. The timestamp when the resource was created. This may
     * be either the time creation was initiated or when it was completed.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 8;</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setCreateTime($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Timestamp::class);
        $this->create_time = $var;
        return $this;
    }
    /**
     * Output only. The timestamp when the resource was last updated. Any
     * change to the resource made by users must refresh this value.
     * Changes to a resource made by the service should refresh this value.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 9;</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getUpdateTime()
    {
        return $this->update_time;
    }
    public function hasUpdateTime()
    {
        return isset($this->update_time);
    }
    public function clearUpdateTime()
    {
        unset($this->update_time);
    }
    /**
     * Output only. The timestamp when the resource was last updated. Any
     * change to the resource made by users must refresh this value.
     * Changes to a resource made by the service should refresh this value.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 9;</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setUpdateTime($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Timestamp::class);
        $this->update_time = $var;
        return $this;
    }
    /**
     * Output only. The timestamp when the resource was deleted.
     * If the resource is not deleted, this must be empty.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp delete_time = 10;</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getDeleteTime()
    {
        return $this->delete_time;
    }
    public function hasDeleteTime()
    {
        return isset($this->delete_time);
    }
    public function clearDeleteTime()
    {
        unset($this->delete_time);
    }
    /**
     * Output only. The timestamp when the resource was deleted.
     * If the resource is not deleted, this must be empty.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp delete_time = 10;</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setDeleteTime($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Timestamp::class);
        $this->delete_time = $var;
        return $this;
    }
    /**
     * Output only. An opaque value that uniquely identifies a version or
     * generation of a resource. It can be used to confirm that the client
     * and server agree on the ordering of a resource being written.
     *
     * Generated from protobuf field <code>string etag = 11;</code>
     * @return string
     */
    public function getEtag()
    {
        return $this->etag;
    }
    /**
     * Output only. An opaque value that uniquely identifies a version or
     * generation of a resource. It can be used to confirm that the client
     * and server agree on the ordering of a resource being written.
     *
     * Generated from protobuf field <code>string etag = 11;</code>
     * @param string $var
     * @return $this
     */
    public function setEtag($var)
    {
        GPBUtil::checkString($var, True);
        $this->etag = $var;
        return $this;
    }
    /**
     * Immutable. The location of the resource. The location encoding is
     * specific to the service provider, and new encoding may be introduced
     * as the service evolves.
     * For Google Cloud products, the encoding is what is used by Google Cloud
     * APIs, such as `us-east1`, `aws-us-east-1`, and `azure-eastus2`. The
     * semantics of `location` is identical to the
     * `cloud.googleapis.com/location` label used by some Google Cloud APIs.
     *
     * Generated from protobuf field <code>string location = 12;</code>
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }
    /**
     * Immutable. The location of the resource. The location encoding is
     * specific to the service provider, and new encoding may be introduced
     * as the service evolves.
     * For Google Cloud products, the encoding is what is used by Google Cloud
     * APIs, such as `us-east1`, `aws-us-east-1`, and `azure-eastus2`. The
     * semantics of `location` is identical to the
     * `cloud.googleapis.com/location` label used by some Google Cloud APIs.
     *
     * Generated from protobuf field <code>string location = 12;</code>
     * @param string $var
     * @return $this
     */
    public function setLocation($var)
    {
        GPBUtil::checkString($var, True);
        $this->location = $var;
        return $this;
    }
}
