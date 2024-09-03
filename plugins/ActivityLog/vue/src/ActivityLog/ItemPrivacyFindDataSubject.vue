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
  <span class="item-name">{{ translate('PrivacyManager_FindMatchingDataSubjects') }}:</span><br />
  <span class="item-data-text">
    <span class="item-data-title" v-if="item.data.idSite">{{
        translate('ActivityLog_SiteID')
      }}:</span>
    <span class="item-data-text" v-if="item.data.idSite">{{ item.data.idSite }}</span>
    <br v-if="item.data.idSite" />
    <span class="item-data-title" v-if="item.data.segment">{{
        translate('General_Segment')
      }}:</span>
    <span class="item-data-text" v-if="item.data.segment">{{ item.data.segment }}</span>
    <br v-if="item.data.segment" />
    <span class="item-data-title" v-if="item.data.count">{{
        translate('ActivityLog_TotalRecordsFound')
      }}:</span>
    <span class="item-data-text" v-if="item.data.count">{{ item.data.count }}</span>
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
