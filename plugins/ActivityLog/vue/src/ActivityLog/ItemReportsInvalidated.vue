<!--
  Copyright (C) InnoCraft Ltd - All rights reserved.

  NOTICE:  All information contained herein is, and remains the property of InnoCraft Ltd.
  The intellectual and technical concepts contained herein are protected by trade secret
  or copyright law. Redistribution of this information or reproduction of this material is
  strictly forbidden unless prior written permission is obtained from InnoCraft Ltd.

  You shall use this code only in accordance with the license agreement obtained from
  InnoCraft Ltd.

  @link https://www.innocraft.com/
  @license For license details see https://www.innocraft.com/license
-->

<template>
  <span class="item-data-title icon-table"></span>
  <span class="item-name">{{ translate('ActivityLog_InvalidateReports') }}:</span><br />
  <span class="item-data-text">
    <span class="item-data-title" v-if="item.data.idSites">{{
        translate('ActivityLog_SiteIDs')
      }}:</span>
    <span class="item-data-text" v-if="item.data.idSites">{{ item.data.idSites }}</span>
    <br v-if="item.data.idSites" />
    <span class="item-data-title" v-if="item.data.dates">{{
        translate('ActivityLog_Dates')
      }}:</span>
    <span class="item-data-text" v-if="item.data.dates">{{ item.data.dates }}</span>
    <br v-if="item.data.dates" />
    <span class="item-data-title" v-if="showItemField(item.data.period)">
        {{ translate('General_Period') }}:
    </span>
    <span class="item-data-text" v-if="showItemField(item.data.period)">{{
        item.data.period
      }}</span>
    <br v-if="showItemField(item.data.period)" />
    <span class="item-data-title" v-if="showItemField(item.data.segment)">
        {{ translate('General_Segment') }}:
    </span>
    <span class="item-data-text" v-if="showItemField(item.data.segment)">{{
        item.data.segment
      }}</span>
    <br v-if="showItemField(item.data.segment)" />
    <span class="item-data-title" v-if="showItemField(item.data.cascadeDown)">
        {{ translate('ActivityLog_CascadeDown') }}:
    </span>
    <span class="item-data-text" v-if="showItemField(item.data.cascadeDown)">
        {{ item.data.cascadeDown }}
    </span>
    <br v-if="showItemField(item.data.cascadeDown)" />
    <span class="item-data-title"
          v-if="showItemField(item.data._forceInvalidateNonexistent)">
        {{ translate('ActivityLog_ForceInvalidate') }}:
    </span>
    <span class="item-data-text"
          v-if="showItemField(item.data._forceInvalidateNonexistent)">
        {{ item.data._forceInvalidateNonexistent }}
    </span>
    <br v-if="showItemField(item.data._forceInvalidateNonexistent)" />
    <span class="item-data-title"
          v-if="showItemField(item.data.plugin)">
        {{ translate('ActivityLog_Plugin') }}:
    </span>
    <span class="item-data-text"
          v-if="showItemField(item.data.plugin)">
        {{ item.data.plugin }}
    </span>
    <br v-if="showItemField(item.data.plugin)" />
    <span class="item-data-title"
          v-if="showItemField(item.data.ignoreLogDeletionLimit)">
        {{ translate('ActivityLog_IgnoreLogDeletionLimit') }}:
    </span>
    <span class="item-data-text"
          v-if="showItemField(item.data.ignoreLogDeletionLimit)">
        {{ item.data.ignoreLogDeletionLimit }}
    </span>
  </span>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  props: {
    item: {
      type: Object,
      required: true,
    },
  },
  methods: {
    showItemField(fieldValue?: string|boolean): boolean {
      return !!fieldValue || fieldValue === false;
    },
  },
});
</script>
