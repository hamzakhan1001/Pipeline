<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/longrunning/operations.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\LongRunning;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * The request message for [Operations.DeleteOperation][google.longrunning.Operations.DeleteOperation].
 *
 * Generated from protobuf message <code>google.longrunning.DeleteOperationRequest</code>
 */
class DeleteOperationRequest extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * The name of the operation resource to be deleted.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     */
    private $name = '';
    /**
     * @param string $name The name of the operation resource to be deleted.
     *
     * @return \Google\LongRunning\DeleteOperationRequest
     *
     * @experimental
     */
    public static function build(string $name) : self
    {
        return (new self())->setName($name);
    }
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           The name of the operation resource to be deleted.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Longrunning\Operations::initOnce();
        parent::__construct($data);
    }
    /**
     * The name of the operation resource to be deleted.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * The name of the operation resource to be deleted.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;
        return $this;
    }
}
