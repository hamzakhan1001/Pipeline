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
  <ContentBlock
    class="manageIgnoredCrashes"
    :content-title="translate('CrashAnalytics_IgnoredCrashesWidget')"
    :feature="translate('CrashAnalytics_IgnoredCrashesWidget')"
  >
    <p>{{ translate('CrashAnalytics_ManageIgnoreIntro1') }}</p>

    <p>{{ translate('CrashAnalytics_ManageIgnoreIntro2') }}</p>

    <table v-content-table>
      <thead>
        <tr>
          <th class="message">{{ translate('CrashAnalytics_Message') }}</th>
          <th class="type">{{ translate('CrashAnalytics_Type') }}</th>
          <th class="source">{{ translate('CrashAnalytics_Source') }}</th>
          <th class="ignoredSince">{{ translate('CrashAnalytics_IgnoredSince') }}</th>
          <th class="firstSeen">{{ translate('CrashAnalytics_FirstSeen') }}</th>
          <th class="action">{{ translate('General_Actions') }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-show="isLoading || isUpdating">
          <td colspan="7">
            <span class="loadingPiwik"><img src="plugins/Morpheus/images/loading-blue.gif" />
              {{ translate('General_LoadingData') }}</span>
          </td>
        </tr>
        <tr v-show="!isLoading && ignored.length === 0">
          <td colspan="7">
            <span>
              {{ translate('CrashAnalytics_NoCrashesIgnored') }}
            </span>
          </td>
        </tr>
        <tr
          :id="`crash${crash.idlogcrash}`"
          class="crashes"
          v-for="crash in ignored"
          :key="crash.idlogcrash"
        >
          <td class="message">{{ crash.message }}</td>
          <td class="type">{{ crash.crash_type }}</td>
          <td class="source">{{ crash.resource_uri }}</td>
          <td class="ignoredSince">{{ crash.date_ignored_error_pretty }}</td>
          <td class="firstSeen">{{ crash.date_first_seen_pretty }}</td>
          <td class="action">
            <a
              class="table-action icon-show unignoreCrash"
              :title="translate('CrashAnalytics_UnignoreThisCrash')"
              @click.prevent="unignore(crash)"
            />
          </td>
        </tr>
      </tbody>
    </table>

    <div
      class="ui-confirm confirmUnignoreIgnoreContainer"
      ref="confirmUnignoreIgnoreContainer"
    >
      <h2>{{ translate('CrashAnalytics_ConfirmUnignore', this.crashToUnignore?.message) }} </h2>
      <input
        role="yes"
        type="button"
        :value="translate('General_Yes')"
      />
      <input
        role="no"
        type="button"
        :value="translate('General_No')"
      />
    </div>
  </ContentBlock>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import {
  ContentBlock,
  ContentTable,
  AjaxHelper,
  Matomo,
  NotificationsStore,
  translate,
} from 'CoreHome';
import Crash from '../Crash';

interface ManageIgnoredCrashesState {
  ignored: Crash[];
  isLoading: boolean;
  isUpdating: boolean;
  crashToUnignore: Crash|null;
}

export default defineComponent({
  components: {
    ContentBlock,
  },
  directives: {
    ContentTable,
  },
  data(): ManageIgnoredCrashesState {
    return {
      ignored: [],
      isLoading: false,
      isUpdating: false,
      crashToUnignore: null,
    };
  },
  created() {
    this.fetch();
  },
  methods: {
    fetch() {
      this.isLoading = true;
      AjaxHelper.fetch<Crash[]>({
        method: 'CrashAnalytics.getIgnoredCrashes',
      }).then((crashes) => {
        this.ignored = crashes;
      }).finally(() => {
        this.isLoading = false;
      });
    },
    unignore(crash: Crash) {
      this.crashToUnignore = crash;

      Matomo.helper.modalConfirm(this.$refs.confirmUnignoreIgnoreContainer as HTMLElement, {
        yes: () => {
          this.isUpdating = true;
          AjaxHelper.fetch({
            method: 'CrashAnalytics.setIgnoreCrash',
            idSite: Matomo.idSite,
            idLogCrash: crash.idlogcrash,
            ignore: 0,
          }).then(() => {
            NotificationsStore.show({
              type: 'toast',
              message: translate('General_Done'),
              context: 'success',
            });

            Matomo.helper.lazyScrollTo(this.$refs.root as HTMLElement, 0);

            return this.fetch();
          }).finally(() => {
            this.isUpdating = false;
            this.crashToUnignore = null;
          });
        },
      });
    },
  },
});
</script>
