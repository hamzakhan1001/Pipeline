<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/rpc/context/attribute_context.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Rpc\Context;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * This message defines the standard attribute vocabulary for Google APIs.
 * An attribute is a piece of metadata that describes an activity on a network
 * service. For example, the size of an HTTP request, or the status code of
 * an HTTP response.
 * Each attribute has a type and a name, which is logically defined as
 * a proto message field in `AttributeContext`. The field type becomes the
 * attribute type, and the field path becomes the attribute name. For example,
 * the attribute `source.ip` maps to field `AttributeContext.source.ip`.
 * This message definition is guaranteed not to have any wire breaking change.
 * So you can use it directly for passing attributes across different systems.
 * NOTE: Different system may generate different subset of attributes. Please
 * verify the system specification before relying on an attribute generated
 * a system.
 *
 * Generated from protobuf message <code>google.rpc.context.AttributeContext</code>
 */
class AttributeContext extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * The origin of a network activity. In a multi hop network activity,
     * the origin represents the sender of the first hop. For the first hop,
     * the `source` and the `origin` must have the same content.
     *
     * Generated from protobuf field <code>.google.rpc.context.AttributeContext.Peer origin = 7;</code>
     */
    protected $origin = null;
    /**
     * The source of a network activity, such as starting a TCP connection.
     * In a multi hop network activity, the source represents the sender of the
     * last hop.
     *
     * Generated from protobuf field <code>.google.rpc.context.AttributeContext.Peer source = 1;</code>
     */
    protected $source = null;
    /**
     * The destination of a network activity, such as accepting a TCP connection.
     * In a multi hop network activity, the destination represents the receiver of
     * the last hop.
     *
     * Generated from protobuf field <code>.google.rpc.context.AttributeContext.Peer destination = 2;</code>
     */
    protected $destination = null;
    /**
     * Represents a network request, such as an HTTP request.
     *
     * Generated from protobuf field <code>.google.rpc.context.AttributeContext.Request request = 3;</code>
     */
    protected $request = null;
    /**
     * Represents a network response, such as an HTTP response.
     *
     * Generated from protobuf field <code>.google.rpc.context.AttributeContext.Response response = 4;</code>
     */
    protected $response = null;
    /**
     * Represents a target resource that is involved with a network activity.
     * If multiple resources are involved with an activity, this must be the
     * primary one.
     *
     * Generated from protobuf field <code>.google.rpc.context.AttributeContext.Resource resource = 5;</code>
     */
    protected $resource = null;
    /**
     * Represents an API operation that is involved to a network activity.
     *
     * Generated from protobuf field <code>.google.rpc.context.AttributeContext.Api api = 6;</code>
     */
    protected $api = null;
    /**
     * Supports extensions for advanced use cases, such as logs and metrics.
     *
     * Generated from protobuf field <code>repeated .google.protobuf.Any extensions = 8;</code>
     */
    private $extensions;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Rpc\Context\AttributeContext\Peer $origin
     *           The origin of a network activity. In a multi hop network activity,
     *           the origin represents the sender of the first hop. For the first hop,
     *           the `source` and the `origin` must have the same content.
     *     @type \Google\Rpc\Context\AttributeContext\Peer $source
     *           The source of a network activity, such as starting a TCP connection.
     *           In a multi hop network activity, the source represents the sender of the
     *           last hop.
     *     @type \Google\Rpc\Context\AttributeContext\Peer $destination
     *           The destination of a network activity, such as accepting a TCP connection.
     *           In a multi hop network activity, the destination represents the receiver of
     *           the last hop.
     *     @type \Google\Rpc\Context\AttributeContext\Request $request
     *           Represents a network request, such as an HTTP request.
     *     @type \Google\Rpc\Context\AttributeContext\Response $response
     *           Represents a network response, such as an HTTP response.
     *     @type \Google\Rpc\Context\AttributeContext\Resource $resource
     *           Represents a target resource that is involved with a network activity.
     *           If multiple resources are involved with an activity, this must be the
     *           primary one.
     *     @type \Google\Rpc\Context\AttributeContext\Api $api
     *           Represents an API operation that is involved to a network activity.
     *     @type array<\Google\Protobuf\Any>|\Google\Protobuf\Internal\RepeatedField $extensions
     *           Supports extensions for advanced use cases, such as logs and metrics.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Rpc\Context\AttributeContext::initOnce();
        parent::__construct($data);
    }
    /**
     * The origin of a network activity. In a multi hop network activity,
     * the origin represents the sender of the first hop. For the first hop,
     * the `source` and the `origin` must have the same content.
     *
     * Generated from protobuf field <code>.google.rpc.context.AttributeContext.Peer origin = 7;</code>
     * @return \Google\Rpc\Context\AttributeContext\Peer|null
     */
    public function getOrigin()
    {
        return $this->origin;
    }
    public function hasOrigin()
    {
        return isset($this->origin);
    }
    public function clearOrigin()
    {
        unset($this->origin);
    }
    /**
     * The origin of a network activity. In a multi hop network activity,
     * the origin represents the sender of the first hop. For the first hop,
     * the `source` and the `origin` must have the same content.
     *
     * Generated from protobuf field <code>.google.rpc.context.AttributeContext.Peer origin = 7;</code>
     * @param \Google\Rpc\Context\AttributeContext\Peer $var
     * @return $this
     */
    public function setOrigin($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Rpc\Context\AttributeContext\Peer::class);
        $this->origin = $var;
        return $this;
    }
    /**
     * The source of a network activity, such as starting a TCP connection.
     * In a multi hop network activity, the source represents the sender of the
     * last hop.
     *
     * Generated from protobuf field <code>.google.rpc.context.AttributeContext.Peer source = 1;</code>
     * @return \Google\Rpc\Context\AttributeContext\Peer|null
     */
    public function getSource()
    {
        return $this->source;
    }
    public function hasSource()
    {
        return isset($this->source);
    }
    public function clearSource()
    {
        unset($this->source);
    }
    /**
     * The source of a network activity, such as starting a TCP connection.
     * In a multi hop network activity, the source represents the sender of the
     * last hop.
     *
     * Generated from protobuf field <code>.google.rpc.context.AttributeContext.Peer source = 1;</code>
     * @param \Google\Rpc\Context\AttributeContext\Peer $var
     * @return $this
     */
    public function setSource($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Rpc\Context\AttributeContext\Peer::class);
        $this->source = $var;
        return $this;
    }
    /**
     * The destination of a network activity, such as accepting a TCP connection.
     * In a multi hop network activity, the destination represents the receiver of
     * the last hop.
     *
     * Generated from protobuf field <code>.google.rpc.context.AttributeContext.Peer destination = 2;</code>
     * @return \Google\Rpc\Context\AttributeContext\Peer|null
     */
    public function getDestination()
    {
        return $this->destination;
    }
    public function hasDestination()
    {
        return isset($this->destination);
    }
    public function clearDestination()
    {
        unset($this->destination);
    }
    /**
     * The destination of a network activity, such as accepting a TCP connection.
     * In a multi hop network activity, the destination represents the receiver of
     * the last hop.
     *
     * Generated from protobuf field <code>.google.rpc.context.AttributeContext.Peer destination = 2;</code>
     * @param \Google\Rpc\Context\AttributeContext\Peer $var
     * @return $this
     */
    public function setDestination($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Rpc\Context\AttributeContext\Peer::class);
        $this->destination = $var;
        return $this;
    }
    /**
     * Represents a network request, such as an HTTP request.
     *
     * Generated from protobuf field <code>.google.rpc.context.AttributeContext.Request request = 3;</code>
     * @return \Google\Rpc\Context\AttributeContext\Request|null
     */
    public function getRequest()
    {
        return $this->request;
    }
    public function hasRequest()
    {
        return isset($this->request);
    }
    public function clearRequest()
    {
        unset($this->request);
    }
    /**
     * Represents a network request, such as an HTTP request.
     *
     * Generated from protobuf field <code>.google.rpc.context.AttributeContext.Request request = 3;</code>
     * @param \Google\Rpc\Context\AttributeContext\Request $var
     * @return $this
     */
    public function setRequest($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Rpc\Context\AttributeContext\Request::class);
        $this->request = $var;
        return $this;
    }
    /**
     * Represents a network response, such as an HTTP response.
     *
     * Generated from protobuf field <code>.google.rpc.context.AttributeContext.Response response = 4;</code>
     * @return \Google\Rpc\Context\AttributeContext\Response|null
     */
    public function getResponse()
    {
        return $this->response;
    }
    public function hasResponse()
    {
        return isset($this->response);
    }
    public function clearResponse()
    {
        unset($this->response);
    }
    /**
     * Represents a network response, such as an HTTP response.
     *
     * Generated from protobuf field <code>.google.rpc.context.AttributeContext.Response response = 4;</code>
     * @param \Google\Rpc\Context\AttributeContext\Response $var
     * @return $this
     */
    public function setResponse($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Rpc\Context\AttributeContext\Response::class);
        $this->response = $var;
        return $this;
    }
    /**
     * Represents a target resource that is involved with a network activity.
     * If multiple resources are involved with an activity, this must be the
     * primary one.
     *
     * Generated from protobuf field <code>.google.rpc.context.AttributeContext.Resource resource = 5;</code>
     * @return \Google\Rpc\Context\AttributeContext\Resource|null
     */
    public function getResource()
    {
        return $this->resource;
    }
    public function hasResource()
    {
        return isset($this->resource);
    }
    public function clearResource()
    {
        unset($this->resource);
    }
    /**
     * Represents a target resource that is involved with a network activity.
     * If multiple resources are involved with an activity, this must be the
     * primary one.
     *
     * Generated from protobuf field <code>.google.rpc.context.AttributeContext.Resource resource = 5;</code>
     * @param \Google\Rpc\Context\AttributeContext\Resource $var
     * @return $this
     */
    public function setResource($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Rpc\Context\AttributeContext\Resource::class);
        $this->resource = $var;
        return $this;
    }
    /**
     * Represents an API operation that is involved to a network activity.
     *
     * Generated from protobuf field <code>.google.rpc.context.AttributeContext.Api api = 6;</code>
     * @return \Google\Rpc\Context\AttributeContext\Api|null
     */
    public function getApi()
    {
        return $this->api;
    }
    public function hasApi()
    {
        return isset($this->api);
    }
    public function clearApi()
    {
        unset($this->api);
    }
    /**
     * Represents an API operation that is involved to a network activity.
     *
     * Generated from protobuf field <code>.google.rpc.context.AttributeContext.Api api = 6;</code>
     * @param \Google\Rpc\Context\AttributeContext\Api $var
     * @return $this
     */
    public function setApi($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Rpc\Context\AttributeContext\Api::class);
        $this->api = $var;
        return $this;
    }
    /**
     * Supports extensions for advanced use cases, such as logs and metrics.
     *
     * Generated from protobuf field <code>repeated .google.protobuf.Any extensions = 8;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getExtensions()
    {
        return $this->extensions;
    }
    /**
     * Supports extensions for advanced use cases, such as logs and metrics.
     *
     * Generated from protobuf field <code>repeated .google.protobuf.Any extensions = 8;</code>
     * @param array<\Google\Protobuf\Any>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setExtensions($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::MESSAGE, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Any::class);
        $this->extensions = $arr;
        return $this;
    }
}
