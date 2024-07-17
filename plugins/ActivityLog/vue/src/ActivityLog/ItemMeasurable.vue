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
  <span class="item-name">
    <span class="item-icon icon-open-source"></span> {{ item.data.name }}
  </span>
  <span class="item-data-title">{{ translate('SitesManager_Type') }}:</span>
  <span class="item-data-text">{{ item.data.type }}</span>
  <span class="item-data-title">{{ translate('ActivityLog_SiteID') }}:</span>
  <span class="item-data-text">{{ item.data.id }}</span>
  <span v-if="item.data.urls.length > 0 && item.data.urls.join('') !== ''">
    <span class="item-data-title">{{ translate('SitesManager_Urls') }}:</span>
    <span class="item-data-text">{{ item.data.urls.join(', ') }}</span>
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
});
</script>
