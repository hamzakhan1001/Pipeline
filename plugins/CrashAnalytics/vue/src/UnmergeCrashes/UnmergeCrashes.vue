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
    :content-title="translate('CrashAnalytics_UnmergeCrashes')"
    :feature="translate('CrashAnalytics_UnmergeCrashes')"
    class="unmergeCrashes"
  >
    <p>{{ translate('CrashAnalytics_UnmergeCrashesIntro') }}</p>

    <table v-content-table :class="{ loading: isLoading }">
      <thead>
        <tr>
          <th>{{ translate('CrashAnalytics_Messages') }}</th>
          <th>{{ translate('CrashAnalytics_Type') }}</th>
          <th>{{ translate('CrashAnalytics_Source') }}</th>
          <th>{{ translate('General_Actions') }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="crashGroups !== null && crashGroups.length === 0">
          <td colspan="4">
            {{ translate('CrashAnalytics_NoCrashesMerged') }}
          </td>
        </tr>
        <Passthrough v-for="(group, key) in (crashGroups || [])" :key="key">
          <tr class="groupHeader">
            <td>
              <div class="firstGroupMessage">{{ group[0].message }}</div>
              <div class="groupDetails">
                <div class="leftBar"></div>
                <ul>
                  <li v-for="crash in group.slice(1)" :key="crash.idlogcrash">
                    <span class="dash"></span>
                    <span class="message">{{ crash.message }}</span>
                  </li>
                </ul>
              </div>
            </td>
            <td>{{ group[0].crash_type }}</td>
            <td>{{ group[0].resource_uri || translate('General_Unknown') }}</td>
            <td>
              <a
                class="table-action unmerge"
                :title="translate('CrashAnalytics_UnmergeThisCrash')"
                @click.prevent="unmerge(group)"
              >
                <img src="plugins/CrashAnalytics/images/merge_black.svg" />
              </a>
            </td>
          </tr>
        </Passthrough>
      </tbody>
    </table>

    <div
      class="ui-confirm confirmUnmergeCrashes"
      id="confirmUnmergeCrashes"
      ref="confirmUnmergeCrashes"
    >
      <h3>
        {{ translate('CrashAnalytics_AreYouSureYouWantToUnmerge') }}
      </h3>
      <ul class="browser-default">
        <li v-for="(crash, index) in groupToUnmerge || []" :key="index">{{ crash.message }}</li>
      </ul>

      <input
        role="no"
        type="button"
        :value="translate('General_No')"
      />
      <input
        role="yes"
        type="button"
        :value="translate('General_Yes')"
      />
    </div>
  </ContentBlock>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import {
  AjaxHelper,
  ContentBlock,
  ContentTable, Matomo, NotificationsStore, translate,
} from 'CoreHome';
import Crash from '../Crash';
import Passthrough from '../Passthrough/Passthrough.vue';

interface UnmergeCrashesState {
  isLoading: boolean;
  crashGroups: Crash[][]|null;
  groupToUnmerge: Crash[]|null;
}

export default defineComponent({
  components: {
    ContentBlock,
    Passthrough,
  },
  directives: {
    ContentTable,
  },
  data(): UnmergeCrashesState {
    return {
      isLoading: false,
      crashGroups: null,
      groupToUnmerge: null,
    };
  },
  created() {
    this.fetch();
  },
  methods: {
    fetch() {
      this.isLoading = true;
      AjaxHelper.fetch<Crash[][]>({
        method: 'CrashAnalytics.getCrashGroups',
      }).then((crashGroups) => {
        this.crashGroups = crashGroups;
      }).finally(() => {
        this.isLoading = false;
      });
    },
    unmerge(group: Crash[]) {
      this.groupToUnmerge = group;
      Matomo.helper.modalConfirm(this.$refs.confirmUnmergeCrashes as HTMLElement, {
        yes: () => {
          this.isLoading = true;
          AjaxHelper.fetch({
            method: 'CrashAnalytics.unmergeCrashGroup',
            idLogCrash: group[0].idlogcrash,
          }).then(() => {
            NotificationsStore.scrollToNotification(NotificationsStore.show({
              id: 'unmergeSuccess',
              message: translate('CrashAnalytics_UnmergeSuccess'),
              context: 'success',
              type: 'toast',
            }));

            this.fetch();
          });
        },
      });
    },
  },
});
</script>
