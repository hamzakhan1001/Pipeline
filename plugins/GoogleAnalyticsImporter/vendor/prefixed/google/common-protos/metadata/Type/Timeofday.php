<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/type/timeofday.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Type;

class Timeofday
{
    public static $is_initialized = \false;
    public static function initOnce()
    {
        $pool = \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();
        if (static::$is_initialized == \true) {
            return;
        }
        $pool->internalAddGeneratedFile('
�
google/type/timeofday.protogoogle.type"K
	TimeOfDay
hours (
minutes (
seconds (
nanos (Bl
com.google.typeBTimeOfDayProtoPZ>google.golang.org/genproto/googleapis/type/timeofday;timeofday��GTPbproto3', \true);
        static::$is_initialized = \true;
    }
}
