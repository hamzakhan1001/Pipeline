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
  <div class="crashContextCard card" ref="root">
    <div class="card-content">
      <div class="row">
        <div class="col m6 s12 visitInfo">
          <p class="sectionTitle"><strong>{{ crashContext.serverTimePretty }}</strong></p>
          <div>
            <img v-if="crashContext.visit?.browserIcon" :src="crashContext.visit?.browserIcon"/>
            {{ translate('DevicesDetection_ColumnBrowser') }}: {{ crashContext.visit?.browser }}
          </div>
          <div>
            <img
              v-if="crashContext.visit?.operatingSystemIcon"
              :src="crashContext.visit?.operatingSystemIcon"
            />
            {{ translate('DevicesDetection_ColumnOperatingSystem') }}:
            {{ crashContext.visit?.operatingSystem }}
          </div>
          <div>
            <img
              v-if="crashContext.visit?.deviceTypeIcon"
              :src="crashContext.visit?.deviceTypeIcon"
            />
            {{ translate('DevicesDetection_DeviceType') }}: {{ crashContext.visit?.deviceType }}
          </div>
          <div v-if="crashContext.visit?.deviceModel">
            {{ translate('DevicesDetection_Device') }}: {{ crashContext.visit?.deviceModel }}
          </div>
          <div v-if="crashContext.visit?.resolution">
            {{ translate('Resolution_ColumnResolution') }}: {{ crashContext.visit?.resolution }}
          </div>
          <div v-if="crashContext.visit?.languageCode">
            {{ translate('CrashAnalytics_BrowserLanguage') }}: {{
              crashContext.visit?.languageCode }}
          </div>
          <div v-if="crashContext.visit?.pluginsIcons">
            {{ translate('CrashAnalytics_BrowserPlugins') }}:
            <img
              class="browserPluginIcon"
              v-for="icon in crashContext.visit?.pluginsIcons || []"
              :key="icon.pluginName"
              :src="icon.pluginIcon"
              :alt="icon.pluginName"
              :title="icon.pluginName"
            />
          </div>
          <div v-if="crashContext.visit?.userId">
            {{ translate('UsersManager_User') }}: {{ crashContext.visit?.userId }}
          </div>
          <div v-if="crashContext.visit?.visitIp">
            IP: {{ crashContext.visit?.visitIp }}
          </div>
          <div v-if="crashContext.visit?.country">
            <img v-if="crashContext.visit?.countryFlag" :src="crashContext.visit?.countryFlag"/>
            {{ crashLocation }}
          </div>
          <div class="currency" v-if="crashContext.visit?.siteCurrency">
            {{ translate('SitesManager_Currency') }}: {{ crashContext.visit?.siteCurrency }}
          </div>
        </div>
        <div class="col m6 s12 lastActions" v-if="!isVisitorLogDisabled">
          <p class="sectionTitle">
            <strong>{{ translate('CrashAnalytics_LastNActionsBeforeCrash', 5) }}</strong>
          </p>
          <ActivityIndicator v-if="isLoadingActions" :loading="isLoadingActions"/>
          <ol
            class="visitorLog actionList"
            v-show="!isLoadingActions"
          ></ol>
          <a
            v-if="crashContext.visit?.sessionReplayUrl"
            :href="crashContext.visit?.sessionReplayUrl"
            class="sessionReplayLink"
            target="_blank"
          >
            <span class="icon-play"></span>
            {{ translate('CrashAnalytics_ReplayThisSession') }}
          </a>
        </div>
        <SourceAndStackTrace
          class="col s12 m6"
          :crash-context="crashContext"
          v-if="isVisitorLogDisabled"
        />
      </div>
      <div class="row">
        <SourceAndStackTrace
          class="col s12"
          :crash-context="crashContext"
          v-if="!isVisitorLogDisabled"
        />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, nextTick } from 'vue';
import { ActivityIndicator, AjaxHelper } from 'CoreHome';
import CrashContext from './CrashContext';
import SourceAndStackTrace from './SourceAndStackTrace.vue';

interface CrashContextCardState {
  isLoadingActions: boolean;
  recentActionsHtml: string;
}

const { $ } = window;

export default defineComponent({
  props: {
    crashContext: {
      type: Object,
      required: true,
    },
    period: {
      type: String,
      required: true,
    },
    date: {
      type: String,
      required: true,
    },
  },
  components: {
    ActivityIndicator,
    SourceAndStackTrace,
  },
  data(): CrashContextCardState {
    return {
      isLoadingActions: true,
      recentActionsHtml: '',
    };
  },
  created() {
    this.fetchActionsDisplay();
  },
  watch: {
    recentActionsHtml() {
      nextTick(() => {
        const root = $(this.$refs.root as HTMLElement);

        root.find('ol.visitorLog').html(window.vueSanitize(this.recentActionsHtml));
        // eslint-disable-next-line @typescript-eslint/no-explicit-any
        (window as any).initializeVisitorActions(root);
      });
    },
  },
  computed: {
    crashLocation() {
      const crashContext = this.crashContext as CrashContext;

      const parts: string[] = [];
      if (crashContext.visit?.country) {
        parts.push(crashContext.visit?.country);
      }
      if (crashContext.visit?.region) {
        parts.push(crashContext.visit?.region);
      }
      if (crashContext.visit?.city) {
        parts.push(crashContext.visit?.city);
      }
      return parts.join(', ');
    },
    isVisitorLogDisabled() {
      return typeof this.crashContext.actionsBeforeCrash === 'undefined';
    },
  },
  methods: {
    fetchActionsDisplay() {
      const crashContext = this.crashContext as CrashContext;
      AjaxHelper.fetch<string>(
        {
          module: 'CrashAnalytics',
          action: 'getCrashRecentActions',
          format: 'html',
          idVisit: crashContext.idVisit,
          idLogCrashEvent: crashContext.crashEventId,
          period: this.period,
          date: this.date,
        },
        {
          format: 'html',
        },
      ).then((content) => {
        this.recentActionsHtml = content;
      }).finally(() => {
        this.isLoadingActions = false;
      });
    },
  },
});
</script>
