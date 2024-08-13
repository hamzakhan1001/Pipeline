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
  <span class="item-name">{{ translate('ActivityLog_GoogleClientConfig') }}:</span><br />
  <span class="item-data-text">
    <span class="item-data-title" v-if="item.data.clientId">{{
        translate('ActivityLog_ClientId')
      }}:</span>
    <span class="item-data-text" v-if="item.data.clientId">{{ item.data.clientId }}</span>
    <br v-if="item.data.clientId" />
    <span class="item-data-title" v-if="item.data.projectId">{{
        translate('ActivityLog_ProjectId')
      }}:</span>
    <span class="item-data-text" v-if="item.data.projectId">{{ item.data.projectId }}</span>
    <br v-if="item.data.projectId" />
    <span class="item-data-title" v-if="item.data.redirectUris">
        {{ translate('ActivityLog_RedirectUris') }}:
    </span>
    <span class="item-data-text" v-if="item.data.redirectUris">
      <ul class="browser-default">
        <li v-for="uri in item.data.redirectUris" :key="uri">{{ uri }}</li>
      </ul>
    </span>
    <span class="item-data-title" v-if="item.data.javascriptOrigins">
        {{ translate('ActivityLog_JavascriptOrigins') }}:
    </span>
    <span class="item-data-text" v-if="item.data.javascriptOrigins">
      <ul class="browser-default">
        <li v-for="origin in item.data.javascriptOrigins" :key="origin">{{ origin }}</li>
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
