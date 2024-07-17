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
  <div
    class="paging"
    v-show="showPaging"
  >
    <a
      class="btn prev" :disabled="!hasPrev || undefined"
      @click="previousPage()"
      style="margin-right:3.5px"
    >
      <span style="cursor:pointer;">&#171; {{ translate('General_Previous') }}</span>
    </a>
    <span class="counter" v-show="hasPrev || hasNext">
        <span v-if="searchTerm">
            {{ translate('General_PaginationWithoutTotal', offsetStart, offsetEnd) }}
        </span>
        <span v-if="!searchTerm">
            {{ translate('General_Pagination', offsetStart, offsetEnd, totalNumberOfSites) }}
        </span>
    </span>
    <a
      class="btn next"
      :disabled="!hasNext || undefined"
      @click="nextPage()"
      style="margin-left:3.5px"
    >
      <span style="cursor:pointer;" class="pointer">{{ translate('General_Next') }} &#187;</span>
    </a>
  </div>

  <div class="loadingPiwik" v-show="busy">
    <img src="plugins/Morpheus/images/loading-blue.gif" :alt="translate('General_LoadingData')"/>
    {{ translate('General_LoadingData') }}
  </div>

  <a class="btn reload"  @click="applyFilter()">
    <span class="icon icon-reload"></span> {{ translate('General_Refresh') }}
  </a>

  <div class="user-filter" :style="{ visibility: hasSuperUserAccess ? 'visible' : 'hidden' }">
    <span style="margin-right:3.5px">{{ translate('ActivityLog_FilterByUser') }}:</span>

    <select @change="applyFilter($event.target.value)" class="browser-default">
      <option
        v-for="option in availableUsers"
        :key="option.key"
        :value="option.key"
        :selected="userLoginFilter === option.key"
        :disabled="option.disabled"
        :label="option.key"
      >
        {{ option.value }}
      </option>
    </select>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Matomo } from 'CoreHome';
import ActivityLogStore from './ActivityLog.store';

export default defineComponent({
  props: {},
  methods: {
    previousPage() {
      ActivityLogStore.previousPage();
    },
    nextPage() {
      ActivityLogStore.nextPage();
    },
    applyFilter(userLogin?: string) {
      ActivityLogStore.applyFilter(userLogin);
    },
  },
  computed: {
    hasSuperUserAccess(): boolean {
      return Matomo.hasSuperUserAccess;
    },
    hasPrev(): boolean {
      return ActivityLogStore.state.value.hasPrev;
    },
    hasNext(): boolean {
      return ActivityLogStore.state.value.hasNext;
    },
    showPaging(): boolean {
      return !ActivityLogStore.state.value.busy && (this.hasPrev || this.hasNext);
    },
    searchTerm(): string {
      return ActivityLogStore.state.value.searchTerm;
    },
    offsetStart(): number {
      return ActivityLogStore.state.value.offsetStart;
    },
    offsetEnd(): number {
      return ActivityLogStore.state.value.offsetEnd;
    },
    totalNumberOfSites(): number {
      return ActivityLogStore.state.value.totalNumberOfSites;
    },
    busy(): boolean {
      return ActivityLogStore.state.value.busy;
    },
    userLoginFilter(): string {
      return ActivityLogStore.state.value.filter.userLogin;
    },
    availableUsers(): (typeof ActivityLogStore)['state']['value']['availableUsers'] {
      return ActivityLogStore.state.value.availableUsers;
    },
  },
});
</script>
