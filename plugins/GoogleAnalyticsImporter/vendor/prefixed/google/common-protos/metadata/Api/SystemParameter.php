<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/api/system_parameter.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Api;

class SystemParameter
{
    public static $is_initialized = \false;
    public static function initOnce()
    {
        $pool = \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();
        if (static::$is_initialized == \true) {
            return;
        }
        $pool->internalAddGeneratedFile('
 
!google/api/system_parameter.proto
google.api"B
SystemParameters.
rules (2.google.api.SystemParameterRule"X
SystemParameterRule
selector (	/

parameters (2.google.api.SystemParameter"Q
SystemParameter
name (	
http_header (	
url_query_parameter (	Bv
com.google.apiBSystemParameterProtoPZEgoogle.golang.org/genproto/googleapis/api/serviceconfig;serviceconfig˘GAPIbproto3', \true);
        static::$is_initialized = \true;
    }
}
