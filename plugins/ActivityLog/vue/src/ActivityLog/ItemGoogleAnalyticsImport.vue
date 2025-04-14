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
  <span class="item-data-title icon-document"></span>
  <span class="item-name">{{ translate('ActivityLog_GoogleAnalyticsImport') }}:</span><br />
  <span class="item-data-text">
    <span class="item-data-title" v-if="item.data.gaImportType">{{
        translate('SitesManager_Type')
      }}:</span>
    <span class="item-data-text" v-if="item.data.gaImportType">{{ item.data.gaImportType }}</span>
    <br v-if="item.data.gaImportType" />
    <span class="item-data-title" v-if="item.data.gaProperty">{{
        translate('ActivityLog_Property')
      }}:</span>
    <span class="item-data-text" v-if="item.data.gaProperty">{{ item.data.gaProperty }}</span>
    <br v-if="item.data.gaProperty" />
    <span class="item-data-title" v-if="item.data.gaAccount">{{
        translate('ActivityLog_Account')
      }}:</span>
    <span class="item-data-text" v-if="item.data.gaAccount">{{ item.data.gaAccount }}</span>
    <br v-if="item.data.gaAccount" />
    <span class="item-data-title" v-if="item.data.streamIds">
        {{ translate('ActivityLog_StreamIds') }}:
    </span>
    <span class="item-data-text" v-if="item.data.streamIds">
      <ul class="browser-default">
        <li v-for="streamId in item.data.streamIds" :key="streamId">{{ streamId }}</li>
      </ul>
    </span>
    <span class="item-data-title" v-if="item.data.gaView">{{
      translate('General_View')
    }}:</span>
    <span class="item-data-text" v-if="item.data.gaView">{{ item.data.gaView }}</span>
    <br v-if="item.data.gaView" />
    <span class="item-data-title" v-if="item.data.idSite">{{
      translate('ActivityLog_SiteID')
    }}:</span>
    <span class="item-data-text" v-if="item.data.idSite">{{ item.data.idSite }}</span>
    <br v-if="item.data.idSite" />
    <span class="item-data-title" v-if="item.data.status">{{
      translate('CorePluginsAdmin_Status')
    }}:</span>
    <span class="item-data-text" v-if="item.data.status">{{ item.data.status }}</span>
    <br v-if="item.data.status" />
    <span class="item-data-title" v-if="item.data.importRangeStart">{{
      translate('ActivityLog_ImportStartDate')
    }}:</span>
    <span class="item-data-text" v-if="item.data.importRangeStart">
      {{ item.data.importRangeStart }}</span>
    <br v-if="item.data.importRangeStart" />
    <span class="item-data-title" v-if="item.data.importRangeEnd">{{
      translate('ActivityLog_ImportEndDate')
    }}:</span>
    <span class="item-data-text" v-if="item.data.importRangeEnd">
      {{ item.data.importRangeEnd }}</span>
    <br v-if="item.data.importRangeEnd" />
    <span class="item-data-title">{{
        translate('ActivityLog_LastDayImported')
      }}:</span>
    <span class="item-data-text" v-if="item.data.lastDateImported">
      {{ item.data.lastDateImported }}</span>
    <span class="item-data-title" v-if="!item.data.lastDateImported">{{
        translate('ActivityLog_None')
      }}</span>
    <br />
    <span class="item-data-title" v-if="item.data.lastDayArchived">{{
        translate('ActivityLog_LastDayArchived')
      }}:</span>
    <span class="item-data-text" v-if="item.data.lastDayArchived">
      {{ item.data.lastDayArchived }}</span>
    <br v-if="item.data.lastDayArchived" />
    <span class="item-data-title" v-if="item.data.reimportRanges.length">
        {{ translate('ActivityLog_ReImports') }}:
    </span>
    <span class="item-data-text" v-if="item.data.reimportRanges.length">
      <ul class="browser-default">
        <li v-for="range in item.data.reimportRanges" :key="range">{{ range }}</li>
      </ul>
    </span>
    <br v-if="item.data.reimportRanges.length" />
    <span class="item-data-title" v-if="item.data.extraCustomDimensions.length">
        {{ translate('ActivityLog_ExtraCustomDimensions') }}:
    </span>
    <span class="item-data-text" v-if="item.data.extraCustomDimensions.length">
      <ul class="browser-default">
        <li v-for="dimension in item.data.extraCustomDimensions" :key="dimension">
          <span class="item-data-title">
            {{ translate('ActivityLog_Dimension') }}:
          </span>
          <span class="item-data-text">
            {{ dimension.gaDimension }}
          </span>
          <span class="item-data-title">
            {{ translate('ActivityLog_Scope') }}:
          </span>
          <span class="item-data-text">
            {{ dimension.dimensionScope }}
          </span>
        </li>
      </ul>
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
