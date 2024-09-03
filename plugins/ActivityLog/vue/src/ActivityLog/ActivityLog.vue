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
  <div class="ActivityLog">
    <div class="paging-wrapper">
      <Paging />
    </div>
    <div class="activity-list">
      <div
        class="activity row"
        :class="{loading: busy}"
        v-for="activity in activities"
        :key="activity.id"
      >
        <div
          class="col m6"
          @mouseleave="showTimezone[activity.id] = false"
        >
          <img
            width="40"
            class="activity-avatar"
            :src="activity.avatar"
            v-if="activity.avatar"
            @click="applyFilter(activity.user_login)"
          />
          <img
            class="activity-country"
            :src="activity.country_flag"
            v-if="activity.ip || activity.country"
            :title="getActivityCountryTooltip(activity)"
          />
          <div
            class="activity-time"
            @mouseover="showTimezone[activity.id] = true"
            v-show="!showTimezone[activity.id] || !activity.time_relative_pretty"
            @mouseleave="showTimezone[activity.id] = false"
            :data-timestamp="activity.datetime"
          >
            {{ activity.datetime_pretty }} <span>(UTC)</span>
          </div>
          <div
            class="activity-time"
            @mouseover="showTimezone[activity.id] = true"
            v-show="showTimezone[activity.id] && activity.time_relative_pretty"
            @mouseleave="showTimezone[activity.id] = false"
            :data-timestamp="activity.datetime"
          >
            {{ activity.time_relative_pretty }}
          </div>
          <div class="activity-action">
            <span
              class="activity-action-login"
              @click="applyFilter(activity.user_login)"
            >
              <span v-if="activity.user_login === 'Console Command'">
                <strong>{{ translate('ActivityLog_ConsoleCommand') }}</strong>
              </span>
              <span v-if="activity.user_login === 'Matomo System'">
                <strong>{{ translate('ActivityLog_System') }}</strong>
              </span>
              <span v-if="activity.user_login !== 'Console Command'
                && activity.user_login !== 'Matomo System'">
                <strong>{{ activity.user_login }}</strong>
                <span v-if="!availableUsers.find((u) => u.key === activity.user_login)">
                  ({{ translate('CorePluginsAdmin_Inactive') }})
                </span>
              </span>
            </span>
            {{ activity.description }}
          </div>
        </div>
        <div
          class="activity-items col m6"
          @mouseleave="showTimezone[activity.id] = false"
        >
          <div
            class="activity-item"
            v-for="(item, index) in activity.parameters?.items || []"
            :key="index"
          >
            <component :is="itemToComponent[item.type]" :item="item"/>
          </div>
        </div>
      </div>
      <div
        class="no-entries activity"
        v-show="!activities.length && !busy"
      >
        {{ translate('ActivityLog_NoActivities') }}
      </div>
    </div>
    <div
      class="paging-wrapper"
      v-if="showPagingBottom"
    >
      <Paging />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { translate, Matomo } from 'CoreHome';
import ItemAccess from './ItemAccess.vue';
import ItemAnnotation from './ItemAnnotation.vue';
import ItemCapability from './ItemCapability.vue';
import ItemCustomAlert from './ItemCustomAlert.vue';
import ItemCustomDimension from './ItemCustomDimension.vue';
import ItemGoal from './ItemGoal.vue';
import ItemMeasurable from './ItemMeasurable.vue';
import ItemPlugin from './ItemPlugin.vue';
import ItemScheduledReport from './ItemScheduledReport.vue';
import ItemSearchEngine from './ItemSearchEngine.vue';
import ItemSegment from './ItemSegment.vue';
import ItemSetting from './ItemSetting.vue';
import ItemSocial from './ItemSocial.vue';
import ItemUser from './ItemUser.vue';
import ItemReportsInvalidated from './ItemReportsInvalidated.vue';
import ItemGoogleClientConfig from './ItemGoogleClientConfig.vue';
import ItemGoogleAnalyticsImport from './ItemGoogleAnalyticsImport.vue';
import ItemPrivacyFindDataSubject from './ItemPrivacyFindDataSubject.vue';
import ActivityLogStore from './ActivityLog.store';
import Paging from './Paging.vue';
import { Entry } from '../types';

const ITEM_TYPE_TO_COMPONENT: Record<string, ReturnType<typeof defineComponent>> = {
  access: ItemAccess,
  annotation: ItemAnnotation,
  capability: ItemCapability,
  customalert: ItemCustomAlert,
  customdimension: ItemCustomDimension,
  goal: ItemGoal,
  measurable: ItemMeasurable,
  plugin: ItemPlugin,
  scheduledreport: ItemScheduledReport,
  searchengine: ItemSearchEngine,
  segment: ItemSegment,
  setting: ItemSetting,
  social: ItemSocial,
  user: ItemUser,
  reportsinvalidated: ItemReportsInvalidated,
  googleclientconfig: ItemGoogleClientConfig,
  privacyFindDataSubject: ItemPrivacyFindDataSubject,
  googleanalyticsimport: ItemGoogleAnalyticsImport,
};

interface ActivityLogState {
  showTimezone: Record<string|number, boolean>;
}

export default defineComponent({
  props: {
    showPagingBottom: Boolean,
  },
  components: {
    Paging,
  },
  data(): ActivityLogState {
    return {
      showTimezone: {},
    };
  },
  created() {
    ActivityLogStore.init();
    ActivityLogStore.fetchActivityLog();
  },
  methods: {
    applyFilter(userLogin?: string) {
      ActivityLogStore.applyFilter(userLogin);
    },
    getActivityCountryTooltip(activity: Entry) {
      return activity.ip
        ? translate('ActivityLog_UserCountryWithIP', activity.country_name, activity.ip)
        : translate('ActivityLog_UserCountry', activity.country_name);
    },
  },
  computed: {
    hasSuperUserAccess() {
      return Matomo.hasSuperUserAccess;
    },
    busy(): boolean {
      return ActivityLogStore.state.value.busy;
    },
    activities(): (typeof ActivityLogStore['state']['value']['activities']) {
      return ActivityLogStore.state.value.activities;
    },
    userLoginFilter(): string {
      return ActivityLogStore.state.value.filter.userLogin;
    },
    availableUsers(): (typeof ActivityLogStore)['state']['value']['availableUsers'] {
      return ActivityLogStore.state.value.availableUsers;
    },
    itemToComponent() {
      return ITEM_TYPE_TO_COMPONENT;
    },
  },
});
</script>
