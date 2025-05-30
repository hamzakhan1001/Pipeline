<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/logging/type/http_request.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Cloud\Logging\Type;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * A common proto for logging HTTP requests. Only contains semantics
 * defined by the HTTP specification. Product-specific logging
 * information MUST be defined in a separate message.
 *
 * Generated from protobuf message <code>google.logging.type.HttpRequest</code>
 */
class HttpRequest extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * The request method. Examples: `"GET"`, `"HEAD"`, `"PUT"`, `"POST"`.
     *
     * Generated from protobuf field <code>string request_method = 1;</code>
     */
    protected $request_method = '';
    /**
     * The scheme (http, https), the host name, the path and the query
     * portion of the URL that was requested.
     * Example: `"http://example.com/some/info?color=red"`.
     *
     * Generated from protobuf field <code>string request_url = 2;</code>
     */
    protected $request_url = '';
    /**
     * The size of the HTTP request message in bytes, including the request
     * headers and the request body.
     *
     * Generated from protobuf field <code>int64 request_size = 3;</code>
     */
    protected $request_size = 0;
    /**
     * The response code indicating the status of response.
     * Examples: 200, 404.
     *
     * Generated from protobuf field <code>int32 status = 4;</code>
     */
    protected $status = 0;
    /**
     * The size of the HTTP response message sent back to the client, in bytes,
     * including the response headers and the response body.
     *
     * Generated from protobuf field <code>int64 response_size = 5;</code>
     */
    protected $response_size = 0;
    /**
     * The user agent sent by the client. Example:
     * `"Mozilla/4.0 (compatible; MSIE 6.0; Windows 98; Q312461; .NET
     * CLR 1.0.3705)"`.
     *
     * Generated from protobuf field <code>string user_agent = 6;</code>
     */
    protected $user_agent = '';
    /**
     * The IP address (IPv4 or IPv6) of the client that issued the HTTP
     * request. This field can include port information. Examples:
     * `"192.168.1.1"`, `"10.0.0.1:80"`, `"FE80::0202:B3FF:FE1E:8329"`.
     *
     * Generated from protobuf field <code>string remote_ip = 7;</code>
     */
    protected $remote_ip = '';
    /**
     * The IP address (IPv4 or IPv6) of the origin server that the request was
     * sent to. This field can include port information. Examples:
     * `"192.168.1.1"`, `"10.0.0.1:80"`, `"FE80::0202:B3FF:FE1E:8329"`.
     *
     * Generated from protobuf field <code>string server_ip = 13;</code>
     */
    protected $server_ip = '';
    /**
     * The referer URL of the request, as defined in
     * [HTTP/1.1 Header Field
     * Definitions](https://datatracker.ietf.org/doc/html/rfc2616#section-14.36).
     *
     * Generated from protobuf field <code>string referer = 8;</code>
     */
    protected $referer = '';
    /**
     * The request processing latency on the server, from the time the request was
     * received until the response was sent.
     *
     * Generated from protobuf field <code>.google.protobuf.Duration latency = 14;</code>
     */
    protected $latency = null;
    /**
     * Whether or not a cache lookup was attempted.
     *
     * Generated from protobuf field <code>bool cache_lookup = 11;</code>
     */
    protected $cache_lookup = \false;
    /**
     * Whether or not an entity was served from cache
     * (with or without validation).
     *
     * Generated from protobuf field <code>bool cache_hit = 9;</code>
     */
    protected $cache_hit = \false;
    /**
     * Whether or not the response was validated with the origin server before
     * being served from cache. This field is only meaningful if `cache_hit` is
     * True.
     *
     * Generated from protobuf field <code>bool cache_validated_with_origin_server = 10;</code>
     */
    protected $cache_validated_with_origin_server = \false;
    /**
     * The number of HTTP response bytes inserted into cache. Set only when a
     * cache fill was attempted.
     *
     * Generated from protobuf field <code>int64 cache_fill_bytes = 12;</code>
     */
    protected $cache_fill_bytes = 0;
    /**
     * Protocol used for the request. Examples: "HTTP/1.1", "HTTP/2", "websocket"
     *
     * Generated from protobuf field <code>string protocol = 15;</code>
     */
    protected $protocol = '';
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $request_method
     *           The request method. Examples: `"GET"`, `"HEAD"`, `"PUT"`, `"POST"`.
     *     @type string $request_url
     *           The scheme (http, https), the host name, the path and the query
     *           portion of the URL that was requested.
     *           Example: `"http://example.com/some/info?color=red"`.
     *     @type int|string $request_size
     *           The size of the HTTP request message in bytes, including the request
     *           headers and the request body.
     *     @type int $status
     *           The response code indicating the status of response.
     *           Examples: 200, 404.
     *     @type int|string $response_size
     *           The size of the HTTP response message sent back to the client, in bytes,
     *           including the response headers and the response body.
     *     @type string $user_agent
     *           The user agent sent by the client. Example:
     *           `"Mozilla/4.0 (compatible; MSIE 6.0; Windows 98; Q312461; .NET
     *           CLR 1.0.3705)"`.
     *     @type string $remote_ip
     *           The IP address (IPv4 or IPv6) of the client that issued the HTTP
     *           request. This field can include port information. Examples:
     *           `"192.168.1.1"`, `"10.0.0.1:80"`, `"FE80::0202:B3FF:FE1E:8329"`.
     *     @type string $server_ip
     *           The IP address (IPv4 or IPv6) of the origin server that the request was
     *           sent to. This field can include port information. Examples:
     *           `"192.168.1.1"`, `"10.0.0.1:80"`, `"FE80::0202:B3FF:FE1E:8329"`.
     *     @type string $referer
     *           The referer URL of the request, as defined in
     *           [HTTP/1.1 Header Field
     *           Definitions](https://datatracker.ietf.org/doc/html/rfc2616#section-14.36).
     *     @type \Google\Protobuf\Duration $latency
     *           The request processing latency on the server, from the time the request was
     *           received until the response was sent.
     *     @type bool $cache_lookup
     *           Whether or not a cache lookup was attempted.
     *     @type bool $cache_hit
     *           Whether or not an entity was served from cache
     *           (with or without validation).
     *     @type bool $cache_validated_with_origin_server
     *           Whether or not the response was validated with the origin server before
     *           being served from cache. This field is only meaningful if `cache_hit` is
     *           True.
     *     @type int|string $cache_fill_bytes
     *           The number of HTTP response bytes inserted into cache. Set only when a
     *           cache fill was attempted.
     *     @type string $protocol
     *           Protocol used for the request. Examples: "HTTP/1.1", "HTTP/2", "websocket"
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Logging\Type\HttpRequest::initOnce();
        parent::__construct($data);
    }
    /**
     * The request method. Examples: `"GET"`, `"HEAD"`, `"PUT"`, `"POST"`.
     *
     * Generated from protobuf field <code>string request_method = 1;</code>
     * @return string
     */
    public function getRequestMethod()
    {
        return $this->request_method;
    }
    /**
     * The request method. Examples: `"GET"`, `"HEAD"`, `"PUT"`, `"POST"`.
     *
     * Generated from protobuf field <code>string request_method = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setRequestMethod($var)
    {
        GPBUtil::checkString($var, True);
        $this->request_method = $var;
        return $this;
    }
    /**
     * The scheme (http, https), the host name, the path and the query
     * portion of the URL that was requested.
     * Example: `"http://example.com/some/info?color=red"`.
     *
     * Generated from protobuf field <code>string request_url = 2;</code>
     * @return string
     */
    public function getRequestUrl()
    {
        return $this->request_url;
    }
    /**
     * The scheme (http, https), the host name, the path and the query
     * portion of the URL that was requested.
     * Example: `"http://example.com/some/info?color=red"`.
     *
     * Generated from protobuf field <code>string request_url = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setRequestUrl($var)
    {
        GPBUtil::checkString($var, True);
        $this->request_url = $var;
        return $this;
    }
    /**
     * The size of the HTTP request message in bytes, including the request
     * headers and the request body.
     *
     * Generated from protobuf field <code>int64 request_size = 3;</code>
     * @return int|string
     */
    public function getRequestSize()
    {
        return $this->request_size;
    }
    /**
     * The size of the HTTP request message in bytes, including the request
     * headers and the request body.
     *
     * Generated from protobuf field <code>int64 request_size = 3;</code>
     * @param int|string $var
     * @return $this
     */
    public function setRequestSize($var)
    {
        GPBUtil::checkInt64($var);
        $this->request_size = $var;
        return $this;
    }
    /**
     * The response code indicating the status of response.
     * Examples: 200, 404.
     *
     * Generated from protobuf field <code>int32 status = 4;</code>
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }
    /**
     * The response code indicating the status of response.
     * Examples: 200, 404.
     *
     * Generated from protobuf field <code>int32 status = 4;</code>
     * @param int $var
     * @return $this
     */
    public function setStatus($var)
    {
        GPBUtil::checkInt32($var);
        $this->status = $var;
        return $this;
    }
    /**
     * The size of the HTTP response message sent back to the client, in bytes,
     * including the response headers and the response body.
     *
     * Generated from protobuf field <code>int64 response_size = 5;</code>
     * @return int|string
     */
    public function getResponseSize()
    {
        return $this->response_size;
    }
    /**
     * The size of the HTTP response message sent back to the client, in bytes,
     * including the response headers and the response body.
     *
     * Generated from protobuf field <code>int64 response_size = 5;</code>
     * @param int|string $var
     * @return $this
     */
    public function setResponseSize($var)
    {
        GPBUtil::checkInt64($var);
        $this->response_size = $var;
        return $this;
    }
    /**
     * The user agent sent by the client. Example:
     * `"Mozilla/4.0 (compatible; MSIE 6.0; Windows 98; Q312461; .NET
     * CLR 1.0.3705)"`.
     *
     * Generated from protobuf field <code>string user_agent = 6;</code>
     * @return string
     */
    public function getUserAgent()
    {
        return $this->user_agent;
    }
    /**
     * The user agent sent by the client. Example:
     * `"Mozilla/4.0 (compatible; MSIE 6.0; Windows 98; Q312461; .NET
     * CLR 1.0.3705)"`.
     *
     * Generated from protobuf field <code>string user_agent = 6;</code>
     * @param string $var
     * @return $this
     */
    public function setUserAgent($var)
    {
        GPBUtil::checkString($var, True);
        $this->user_agent = $var;
        return $this;
    }
    /**
     * The IP address (IPv4 or IPv6) of the client that issued the HTTP
     * request. This field can include port information. Examples:
     * `"192.168.1.1"`, `"10.0.0.1:80"`, `"FE80::0202:B3FF:FE1E:8329"`.
     *
     * Generated from protobuf field <code>string remote_ip = 7;</code>
     * @return string
     */
    public function getRemoteIp()
    {
        return $this->remote_ip;
    }
    /**
     * The IP address (IPv4 or IPv6) of the client that issued the HTTP
     * request. This field can include port information. Examples:
     * `"192.168.1.1"`, `"10.0.0.1:80"`, `"FE80::0202:B3FF:FE1E:8329"`.
     *
     * Generated from protobuf field <code>string remote_ip = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setRemoteIp($var)
    {
        GPBUtil::checkString($var, True);
        $this->remote_ip = $var;
        return $this;
    }
    /**
     * The IP address (IPv4 or IPv6) of the origin server that the request was
     * sent to. This field can include port information. Examples:
     * `"192.168.1.1"`, `"10.0.0.1:80"`, `"FE80::0202:B3FF:FE1E:8329"`.
     *
     * Generated from protobuf field <code>string server_ip = 13;</code>
     * @return string
     */
    public function getServerIp()
    {
        return $this->server_ip;
    }
    /**
     * The IP address (IPv4 or IPv6) of the origin server that the request was
     * sent to. This field can include port information. Examples:
     * `"192.168.1.1"`, `"10.0.0.1:80"`, `"FE80::0202:B3FF:FE1E:8329"`.
     *
     * Generated from protobuf field <code>string server_ip = 13;</code>
     * @param string $var
     * @return $this
     */
    public function setServerIp($var)
    {
        GPBUtil::checkString($var, True);
        $this->server_ip = $var;
        return $this;
    }
    /**
     * The referer URL of the request, as defined in
     * [HTTP/1.1 Header Field
     * Definitions](https://datatracker.ietf.org/doc/html/rfc2616#section-14.36).
     *
     * Generated from protobuf field <code>string referer = 8;</code>
     * @return string
     */
    public function getReferer()
    {
        return $this->referer;
    }
    /**
     * The referer URL of the request, as defined in
     * [HTTP/1.1 Header Field
     * Definitions](https://datatracker.ietf.org/doc/html/rfc2616#section-14.36).
     *
     * Generated from protobuf field <code>string referer = 8;</code>
     * @param string $var
     * @return $this
     */
    public function setReferer($var)
    {
        GPBUtil::checkString($var, True);
        $this->referer = $var;
        return $this;
    }
    /**
     * The request processing latency on the server, from the time the request was
     * received until the response was sent.
     *
     * Generated from protobuf field <code>.google.protobuf.Duration latency = 14;</code>
     * @return \Google\Protobuf\Duration|null
     */
    public function getLatency()
    {
        return $this->latency;
    }
    public function hasLatency()
    {
        return isset($this->latency);
    }
    public function clearLatency()
    {
        unset($this->latency);
    }
    /**
     * The request processing latency on the server, from the time the request was
     * received until the response was sent.
     *
     * Generated from protobuf field <code>.google.protobuf.Duration latency = 14;</code>
     * @param \Google\Protobuf\Duration $var
     * @return $this
     */
    public function setLatency($var)
    {
        GPBUtil::checkMessage($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Duration::class);
        $this->latency = $var;
        return $this;
    }
    /**
     * Whether or not a cache lookup was attempted.
     *
     * Generated from protobuf field <code>bool cache_lookup = 11;</code>
     * @return bool
     */
    public function getCacheLookup()
    {
        return $this->cache_lookup;
    }
    /**
     * Whether or not a cache lookup was attempted.
     *
     * Generated from protobuf field <code>bool cache_lookup = 11;</code>
     * @param bool $var
     * @return $this
     */
    public function setCacheLookup($var)
    {
        GPBUtil::checkBool($var);
        $this->cache_lookup = $var;
        return $this;
    }
    /**
     * Whether or not an entity was served from cache
     * (with or without validation).
     *
     * Generated from protobuf field <code>bool cache_hit = 9;</code>
     * @return bool
     */
    public function getCacheHit()
    {
        return $this->cache_hit;
    }
    /**
     * Whether or not an entity was served from cache
     * (with or without validation).
     *
     * Generated from protobuf field <code>bool cache_hit = 9;</code>
     * @param bool $var
     * @return $this
     */
    public function setCacheHit($var)
    {
        GPBUtil::checkBool($var);
        $this->cache_hit = $var;
        return $this;
    }
    /**
     * Whether or not the response was validated with the origin server before
     * being served from cache. This field is only meaningful if `cache_hit` is
     * True.
     *
     * Generated from protobuf field <code>bool cache_validated_with_origin_server = 10;</code>
     * @return bool
     */
    public function getCacheValidatedWithOriginServer()
    {
        return $this->cache_validated_with_origin_server;
    }
    /**
     * Whether or not the response was validated with the origin server before
     * being served from cache. This field is only meaningful if `cache_hit` is
     * True.
     *
     * Generated from protobuf field <code>bool cache_validated_with_origin_server = 10;</code>
     * @param bool $var
     * @return $this
     */
    public function setCacheValidatedWithOriginServer($var)
    {
        GPBUtil::checkBool($var);
        $this->cache_validated_with_origin_server = $var;
        return $this;
    }
    /**
     * The number of HTTP response bytes inserted into cache. Set only when a
     * cache fill was attempted.
     *
     * Generated from protobuf field <code>int64 cache_fill_bytes = 12;</code>
     * @return int|string
     */
    public function getCacheFillBytes()
    {
        return $this->cache_fill_bytes;
    }
    /**
     * The number of HTTP response bytes inserted into cache. Set only when a
     * cache fill was attempted.
     *
     * Generated from protobuf field <code>int64 cache_fill_bytes = 12;</code>
     * @param int|string $var
     * @return $this
     */
    public function setCacheFillBytes($var)
    {
        GPBUtil::checkInt64($var);
        $this->cache_fill_bytes = $var;
        return $this;
    }
    /**
     * Protocol used for the request. Examples: "HTTP/1.1", "HTTP/2", "websocket"
     *
     * Generated from protobuf field <code>string protocol = 15;</code>
     * @return string
     */
    public function getProtocol()
    {
        return $this->protocol;
    }
    /**
     * Protocol used for the request. Examples: "HTTP/1.1", "HTTP/2", "websocket"
     *
     * Generated from protobuf field <code>string protocol = 15;</code>
     * @param string $var
     * @return $this
     */
    public function setProtocol($var)
    {
        GPBUtil::checkString($var, True);
        $this->protocol = $var;
        return $this;
    }
}
