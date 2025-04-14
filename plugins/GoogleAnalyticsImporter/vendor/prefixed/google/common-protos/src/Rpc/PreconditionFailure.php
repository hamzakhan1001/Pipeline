<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/rpc/error_details.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\Google\Rpc;

use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\RepeatedField;
use Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBUtil;
/**
 * Describes what preconditions have failed.
 * For example, if an RPC failed because it required the Terms of Service to be
 * acknowledged, it could list the terms of service violation in the
 * PreconditionFailure message.
 *
 * Generated from protobuf message <code>google.rpc.PreconditionFailure</code>
 */
class PreconditionFailure extends \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\Message
{
    /**
     * Describes all precondition violations.
     *
     * Generated from protobuf field <code>repeated .google.rpc.PreconditionFailure.Violation violations = 1;</code>
     */
    private $violations;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Rpc\PreconditionFailure\Violation>|\Google\Protobuf\Internal\RepeatedField $violations
     *           Describes all precondition violations.
     * }
     */
    public function __construct($data = NULL)
    {
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Rpc\ErrorDetails::initOnce();
        parent::__construct($data);
    }
    /**
     * Describes all precondition violations.
     *
     * Generated from protobuf field <code>repeated .google.rpc.PreconditionFailure.Violation violations = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getViolations()
    {
        return $this->violations;
    }
    /**
     * Describes all precondition violations.
     *
     * Generated from protobuf field <code>repeated .google.rpc.PreconditionFailure.Violation violations = 1;</code>
     * @param array<\Google\Rpc\PreconditionFailure\Violation>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setViolations($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\GPBType::MESSAGE, \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Rpc\PreconditionFailure\Violation::class);
        $this->violations = $arr;
        return $this;
    }
}
