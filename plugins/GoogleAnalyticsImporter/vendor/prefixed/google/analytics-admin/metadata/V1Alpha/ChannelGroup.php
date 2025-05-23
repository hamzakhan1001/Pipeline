<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1alpha/channel_group.proto
namespace Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Analytics\Admin\V1Alpha;

class ChannelGroup
{
    public static $is_initialized = \false;
    public static function initOnce()
    {
        $pool = \Matomo\Dependencies\GoogleAnalyticsImporter\Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();
        if (static::$is_initialized == \true) {
            return;
        }
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Api\FieldBehavior::initOnce();
        \Matomo\Dependencies\GoogleAnalyticsImporter\GPBMetadata\Google\Api\Resource::initOnce();
        $pool->internalAddGeneratedFile('
�
2google/analytics/admin/v1alpha/channel_group.protogoogle.analytics.admin.v1alphagoogle/api/resource.proto"�
ChannelGroupFilterX
string_filter (2?.google.analytics.admin.v1alpha.ChannelGroupFilter.StringFilterH Y
in_list_filter (2?.google.analytics.admin.v1alpha.ChannelGroupFilter.InListFilterH 

field_name (	B�A�A�
StringFilterb

match_type (2I.google.analytics.admin.v1alpha.ChannelGroupFilter.StringFilter.MatchTypeB�A
value (	B�A"�
	MatchType
MATCH_TYPE_UNSPECIFIED 	
EXACT
BEGINS_WITH
	ENDS_WITH
CONTAINS
FULL_REGEXP
PARTIAL_REGEXP#
InListFilter
values (	B�AB
value_filter"�
ChannelGroupFilterExpressionU
	and_group (2@.google.analytics.admin.v1alpha.ChannelGroupFilterExpressionListH T
or_group (2@.google.analytics.admin.v1alpha.ChannelGroupFilterExpressionListH V
not_expression (2<.google.analytics.admin.v1alpha.ChannelGroupFilterExpressionH D
filter (22.google.analytics.admin.v1alpha.ChannelGroupFilterH B
expr"|
 ChannelGroupFilterExpressionListX
filter_expressions (2<.google.analytics.admin.v1alpha.ChannelGroupFilterExpression"�
GroupingRule
display_name (	B�AU

expression (2<.google.analytics.admin.v1alpha.ChannelGroupFilterExpressionB�A"�
ChannelGroup
name (	B�A
display_name (	B�A
description (	H
grouping_rule (2,.google.analytics.admin.v1alpha.GroupingRuleB�A
system_defined (B�A:d�Aa
*analyticsadmin.googleapis.com/ChannelGroup3properties/{property}/channelGroups/{channel_group}By
"com.google.analytics.admin.v1alphaBChannelGroupProtoPZ>cloud.google.com/go/analytics/admin/apiv1alpha/adminpb;adminpbbproto3', \true);
        static::$is_initialized = \true;
    }
}
