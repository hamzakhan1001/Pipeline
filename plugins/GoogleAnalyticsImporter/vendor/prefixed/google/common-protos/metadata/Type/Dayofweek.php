<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/type/dayofweek.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Type;

class Dayofweek
{
    public static $is_initialized = \false;
    public static function initOnce()
    {
        $pool = \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();
        if (static::$is_initialized == \true) {
            return;
        }
        $pool->internalAddGeneratedFile('
�
google/type/dayofweek.protogoogle.type*�
	DayOfWeek
DAY_OF_WEEK_UNSPECIFIED 

MONDAY
TUESDAY
	WEDNESDAY
THURSDAY

FRIDAY
SATURDAY

SUNDAYBi
com.google.typeBDayOfWeekProtoPZ>google.golang.org/genproto/googleapis/type/dayofweek;dayofweek�GTPbproto3', \true);
        static::$is_initialized = \true;
    }
}
