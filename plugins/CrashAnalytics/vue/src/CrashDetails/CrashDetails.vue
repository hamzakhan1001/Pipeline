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
  <div class="crashDetails" ref="root">
    <NotificationGroup group="CrashAnalytics_CrashDetails"/>

    <h2>{{ translate('CrashAnalytics_Summary') }}</h2>

    <div class="summary" ref="summary">
      <div>
        <span class="label">{{ translate('CrashAnalytics_Message') }}:</span>
        <pre><code>{{ crash.message }}</code></pre>
      </div>
      <div>
        <span class="label">{{ translate('CrashAnalytics_Type') }}:</span>
        <span>{{ crash.crash_type }}</span>
      </div>
      <div>
        <span class="label">{{ translate('CrashAnalytics_Category') }}:</span>
        <span>{{ crash.category || '-' }}</span>
      </div>
      <div>
        <span class="label">{{ translate('CrashAnalytics_Source') }}:</span>
        <CrashSourceLink
          :uri="crash.resource_uri"
          :line="crash.resource_line"
          :column="crash.resource_column"
          :page-url="crash.crash_page_url"
          :do-not-link-inline="true"
        />
      </div>
      <div>
        <span class="label">{{ translate('CrashAnalytics_RecentPageUrl' ) }}:</span>
        <span v-if="crash.crash_page_url && !/^https?:/.test(crash.crash_page_url)">
          {{ crash.crash_page_url }}
        </span>
        <span v-if="!crash.crash_page_url">
          {{ translate('CrashAnalytics_NotFound') }}
        </span>
        <a
          class="recentPageUrlLink"
          v-if="crash.crash_page_url && /^https?:/.test(crash.crash_page_url)"
          :href="crash.crash_page_url"
          target="_blank"
          rel="noreferrer noopener"
        >
          {{ crash.crash_page_url }}
        </a>
      </div>
      <div>
        <span class="label">{{ translate('CrashAnalytics_RecentStackTrace') }}:</span>
        <pre><code>{{ crashStackTrace }}</code></pre>
      </div>
      <div class="crashFirstSeen">
        <span class="label">{{ translate('CrashAnalytics_FirstSeen') }}:</span>
        <span>{{ crash.datetime_first_seen_pretty }}</span>
      </div>
      <div class="crashLastSeen">
        <span class="label">{{ translate('CrashAnalytics_LastSeen') }}:</span>
        <span>{{ crash.datetime_last_seen_pretty }}</span>
      </div>
      <div v-if="crash.datetime_last_reappeared">
        <span class="label">{{ translate('CrashAnalytics_LastReappeared') }}:</span>
        <span>{{ crash.datetime_last_reappeared_pretty }}</span>
      </div>

      <div class="actions">
        <button class="btn-flat btn-large copyCrashInfo" @click="copyCrashInfo()">
          <span class="icon-document"/>
          {{ translate('CrashAnalytics_CopyCrashInformation') }}
        </button>
        <button class="btn-flat btn-large" @click="$refs.emailError.click()">
          <span class="icon-email"/>
          {{ translate('CrashAnalytics_EmailCrashInformation') }}
        </button>
        <span
          :title="crash.datetime_ignored_error
            ? translate('CrashAnalytics_ThisCrashIgnoredOn', crash.datetime_ignored_error_pretty)
            : undefined"
        >
          <button
            class="btn-flat btn-large ignoreCrash"
            :class="{disabled: crash.datetime_ignored_error || ignored || isIgnoring}"
            @click="ignoreCrash()"
          >
            <span class="icon-hide"/>
            {{ translate('CrashAnalytics_IgnoreThisCrash') }}
            <ActivityIndicator :loading="isIgnoring"/>
          </button>
        </span>
      </div>

      <!-- kind of ugly but, the textarea cannot have display:none or visibility:hidden in order
           to be focused -->
      <textarea
        ref="copyText"
        :value="errorSummaryText"
        style="position: absolute;left: -1000px;height: 0;padding: 0;width: 0;line-height: 0;"
      ></textarea>

      <a
        rel="noreferrer noopener"
        target="_blank"
        :href="emailErrorLink"
        ref="emailError"
        style="display:none;"
      ></a>
    </div>

    <h2>{{ translate('CrashAnalytics_Context') }}</h2>

    <CrashLog
      :crash="crash"
      :extra-request-params="extraRequestParams"
      v-show="isContextDisabled !== null && !isContextDisabled"
      @context-disabled="isContextDisabled = $event"
    />

    <Notification
      v-if="isContextDisabled !== null && isContextDisabled"
      context="info"
    >
      <span v-html="$sanitize(crashContextDisabledMessage1)" />
      <br/><br/>
      <span v-html="$sanitize(crashContextDisabledMessage2)" />
    </Notification>

    <div
      class="ui-confirm confirmSetIgnoreContainer"
      ref="confirmSetIgnoreContainer"
    >
      <h2>{{ translate('CrashAnalytics_ConfirmIgnore') }} </h2>
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
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import {
  AjaxHelper,
  translate,
  ActivityIndicator,
  NotificationsStore,
  NotificationGroup,
  Matomo,
  Notification,
} from 'CoreHome';
import CrashLog from '../CrashLog/CrashLog.vue';
import CrashSourceLink from '../CrashSourceLink/CrashSourceLink.vue';
import CrashStore from '../CrashLog/CrashContextStore';
import Crash from '../Crash';
import CrashContext from '../CrashLog/CrashContext';

interface CrashDetailsState {
  isContextDisabled: null|boolean;
  isIgnoring: boolean;
  ignored: boolean;
}

const visitInfoToDisplay = [
  { label: translate('CrashAnalytics_Browser'), prop: 'browser' },
  { label: translate('CrashAnalytics_OperatingSystem'), prop: 'operatingSystem' },
  { label: translate('DevicesDetection_DeviceType'), prop: 'deviceType' },
  { label: translate('CrashAnalytics_Device'), prop: 'deviceModel' },
  { label: translate('Resolution_ColumnResolution'), prop: 'resolution' },
  { label: translate('CrashAnalytics_BrowserLanguage'), prop: 'languageCode' },
  { label: translate('CrashAnalytics_BrowserPlugins'), prop: 'plugins' },
  { label: translate('UsersManager_User'), prop: 'userId' },
  { label: 'IP', prop: 'visitIp' },
] as { label: string, prop: keyof CrashContext['visit'] }[];

const { $ } = window;

export default defineComponent({
  props: {
    crash: {
      type: Object,
      required: true,
    },
    extraRequestParams: {
      type: Object,
      default: () => ({}),
    },
  },
  components: {
    NotificationGroup,
    ActivityIndicator,
    CrashLog,
    CrashSourceLink,
    Notification,
  },
  data(): CrashDetailsState {
    return {
      isContextDisabled: null,
      ignored: false,
      isIgnoring: false,
    };
  },
  computed: {
    errorSummaryText() {
      const crash = this.crash as Crash;

      const lineAndColumn = [];
      if (typeof crash.resource_line !== 'undefined') {
        lineAndColumn.push('', crash.resource_line);
        if (typeof crash.resource_column !== 'undefined') {
          lineAndColumn.push(crash.resource_column);
        }
      }

      return `${translate('CrashAnalytics_CrashSummary')}
${translate('CrashAnalytics_Message')}: ${crash.message}
${translate('CrashAnalytics_Type')}: ${crash.crash_type}
${translate('CrashAnalytics_Category')}: ${crash.category || '-'}
${translate('CrashAnalytics_Source')}: ${crash.resource_uri}${lineAndColumn.join(':')}
${translate('CrashAnalytics_RecentStackTrace')}:
${crash.stack_trace || '-'}
${translate('CrashAnalytics_FirstSeen')}: ${crash.datetime_first_seen_pretty}
${translate('CrashAnalytics_LastSeen')}: ${crash.datetime_last_seen_pretty}
${translate('CrashAnalytics_LastReappeared')}: ${crash.datetime_last_reappeared_pretty}
${this.crashContextText}`;
    },
    crashContextText() {
      if (!CrashStore.crashContexts.value.length) {
        return '';
      }

      const crashContexts = CrashStore.crashContexts.value.map((context) => {
        const lines = [];

        if (context.visit) {
          const occurrenceText = translate('CrashAnalytics_DateCrashOccurrence');
          lines.push(`${occurrenceText}: ${context.visit.serverDatePretty} ${context.visit.serverTimePretty}`);

          visitInfoToDisplay.forEach(({ label, prop }) => {
            if (context.visit?.[prop]) {
              lines.push(`${label}: ${context.visit[prop]}`);
            }
          });

          if (context.visit.country) {
            const locationParts = [context.visit.country];
            if (context.visit.region) {
              locationParts.push(context.visit.region);
            }
            if (context.visit.city) {
              locationParts.push(context.visit.city);
            }
            const locationText = locationParts.join(', ');
            lines.push(`${translate('CrashAnalytics_Location')}: ${locationText}`);
          }
        }

        if (context.actionsBeforeCrash?.length) {
          lines.push(translate('CrashAnalytics_LastActionsBeforeTheCrash'));
          context.actionsBeforeCrash.forEach((action) => {
            lines.push(`* (${action.type}) ${action.title}`);
            if (action.subtitle) {
              lines.push(`  ${action.subtitle}`);
            }
          });
        }

        return lines.join('\n');
      });
      return `--------

${translate('CrashAnalytics_ContextInformation')}:

${crashContexts.join('\n\n')}`;
    },
    emailErrorLink() {
      const crash = this.crash as Crash;
      const subject = `${translate('CrashAnalytics_CrashInformation')}: ${crash.message}`;
      const body = this.errorSummaryText;
      return `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
    },
    crashStackTrace() {
      return this.crash.stack_trace || translate('CrashAnalytics_NoStackTraceFound');
    },
    crashContextDisabledMessage1() {
      return translate('CrashAnalytics_CrashContextDisabledMessage1', '<a href="TODO" target="_blank" rel="noreferrer noopener">', '</a>');
    },
    crashContextDisabledMessage2() {
      return translate('CrashAnalytics_CrashContextDisabledMessage2', '<em>', '</em>');
    },
  },
  methods: {
    copyCrashInfo() {
      const element = this.$refs.copyText as HTMLTextAreaElement;
      element.focus();
      element.select();
      document.execCommand('copy');

      $(this.$refs.summary as HTMLElement).effect('highlight');
    },
    ignoreCrash() {
      Matomo.helper.modalConfirm(this.$refs.confirmSetIgnoreContainer as HTMLElement, {
        yes: () => {
          this.isIgnoring = true;
          AjaxHelper.post({
            method: 'CrashAnalytics.setIgnoreCrash',
            idSite: this.crash.idsite,
            idLogCrash: this.crash.idlogcrash,
          }).then(() => {
            this.ignored = true;

            NotificationsStore.show({
              type: 'toast',
              message: translate('General_Done'),
              context: 'success',
              group: 'CrashAnalytics_CrashDetails',
              placeat: '-',
            });

            Matomo.helper.lazyScrollTo(this.$refs.root as HTMLElement, 0);
          }).finally(() => {
            this.isIgnoring = false;
          });
        },
      });
    },
  },
});
</script>
