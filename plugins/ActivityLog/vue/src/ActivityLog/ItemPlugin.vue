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
  <span class="item-data-title icon-admin-development"></span>
  <span class="item-name">{{ translate('General_Plugin') }} {{ item.data.name }}:</span>
  <span class="item-data-text">
    <span v-if="item.data.active === true">{{ translate('CorePluginsAdmin_Active') }}</span>
    <span v-if="item.data.active === false">{{ translate('CorePluginsAdmin_Inactive') }}</span>
    <span v-if="item.data.installed === true">{{ translate('General_Installed') }}</span>
    <span v-if="item.data.installed === false">{{ translate('General_NotInstalled') }}</span>
    <span v-if="item.data.version">
      {{ translate('CorePluginsAdmin_Version') }} {{ item.data.version }}
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
