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
  <span class="item-data-title icon-admin-settings"></span>
  <span class="item-name">{{ translate('ActivityLog_Access') }}:</span>
  <span class="item-data-text">
    <span v-if="item.data.access === 'view'">{{ translate('UsersManager_PrivView') }}</span>
    <span v-if="item.data.access === 'admin'">{{ translate('UsersManager_PrivAdmin') }}</span>
    <span v-if="item.data.access !== 'admin' && item.data.access !== 'view'">
      {{ translate('UsersManager_PrivNone') }}
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
});
</script>
