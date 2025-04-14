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
  <span class="item-data-title icon-segment"></span>
  <span class="item-name">{{ item.data.name }}</span>
  <span class="item-data-title"></span>
  <span class="item-data-text">{{ trackingScopeText }}</span>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { translate } from 'CoreHome';

export default defineComponent({
  props: {
    item: {
      type: Object,
      required: true,
    },
  },
  computed: {
    trackingScopeText() {
      let { scope } = this.item.data;
      scope = `${scope.substr(0, 1).toUpperCase()}${scope.substr(1)}`;
      return translate(`General_TrackingScope${scope}`);
    },
  },
});
</script>
