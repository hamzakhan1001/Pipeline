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
  <div class="crashLog" ref="root" data-report>
    <SimplePeriodSelector
      v-if="!isVisitorLogDisabled"
      :model-value="{ period: requestParams.period, date: requestParams.date }"
      @update:model-value="changePeriod($event)"
    />
    <Notification
      v-if="isVisitorLogDisabled"
      type="transient"
      context="info"
      :noclear="true"
    >
      <span v-html="$sanitize(visitorLogDisabledMessage)"></span>
    </Notification>
    <div>
      <div class="crashes" v-if="!isLoading">
        <CrashContextCard
          v-for="context in crashContexts"
          :key="context.crashEventId"
          :crash-context="context"
          :period="requestParams.period"
          :date="requestParams.date"
        />

        <div v-if="!crashContexts.length && requestParams.filter_offset === 0">
          {{ translate('CrashAnalytics_NoVisitsFoundForThisCrash') }}
        </div>
      </div>
      <div class="dataTableFeatures" v-if="!isVisitorLogDisabled">
        <div class="dataTableFooterNavigation">
          <div class="row dataTablePaginationControl">
            <span
              class="dataTablePrevious"
              @click="prevPage()"
              :style="{visibility: requestParams.filter_offset > 0 ? 'visible' : 'hidden'}"
            >‹ Previous</span>
            &nbsp;&nbsp;
            <span
              class="dataTableNext"
              :style="{
                visibility: this.crashContexts.length >= requestParams.filter_limit
                  ? 'visible' : 'hidden',
              }"
              @click="nextPage()"
            >Next ›</span>
          </div>
          <div class="row">
            <div class="col s9 m9 dataTableControls">
              <a
                class="dataTableAction activateExportSelection"
                v-report-export="reportExportBinding"
                :title="translate('General_ExportThisReport')"
                href=""
                style="margin-right:3.5px"
                @click.prevent
              ><span class="icon-export"></span></a>
            </div>
            <div class="col s3 m3 limitSelection">
              <div class="input-field">
                <select
                  :value="requestParams.filter_limit"
                  @change="limitChange($event.target.value)"
                >
                  <option
                    v-for="value in limitOptions"
                    :key="value"
                    :selected="requestParams.filter_limit === value ? 'selected' : undefined"
                  >
                    {{ value }}
                  </option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
      <ActivityIndicator v-if="isLoading" :loading="isLoading" />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, nextTick } from 'vue';
import {
  ActivityIndicator,
  ReportExport,
  translate,
  Notification, Matomo,
} from 'CoreHome';
import Crash from '../Crash';
import CrashContextCard from './CrashContextCard.vue';
import SimplePeriodSelector from './SimplePeriodSelector.vue';
import CrashContextStore from './CrashContextStore';

interface CrashLogState {
  isLoading: boolean;
  reportExportBinding: unknown;
}

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
    SimplePeriodSelector,
    ActivityIndicator,
    CrashContextCard,
    Notification,
  },
  directives: {
    ReportExport,
  },
  emits: ['contextDisabled'],
  data(): CrashLogState {
    return {
      isLoading: true,
      reportExportBinding: { ...this.reportExportParams },
    };
  },
  created() {
    CrashContextStore.reset(this.extraRequestParams.period, this.extraRequestParams.date);
    this.fetch();
  },
  mounted() {
    nextTick(() => {
      $(this.$refs.root as HTMLElement).find('.limitSelection select').formSelect();

      // added to get ReportExport to work w/ this component
      $(this.$refs.root as HTMLElement).data('uiControlObject', {
        param: this.requestParams,
      });
    });
  },
  watch: {
    requestParams() {
      $(this.$refs.root as HTMLElement).data('uiControlObject', {
        param: this.requestParams,
      });
    },
    reportExportParams() {
      // doing an in-place assign so we can change the value of the report export binding
      // after its been mounted. this way, changes to period/date are reflected in the URL.
      Object.assign(this.reportExportBinding, this.reportExportParams);
    },
  },
  methods: {
    fetch() {
      const crash = this.crash as Crash;

      this.isLoading = true;
      return CrashContextStore.fetch(crash.idlogcrash, this.extraRequestParams).then(() => {
        this.$emit('contextDisabled', false);
      }).catch((e) => {
        this.$emit('contextDisabled', true);
        if (e.message !== 'Crash context display is currently disabled.') {
          throw e;
        }
      }).finally(() => {
        this.isLoading = false;
      });
    },
    prevPage() {
      CrashContextStore.prevPage();
    },
    nextPage() {
      CrashContextStore.nextPage();
    },
    limitChange(limit: number) {
      CrashContextStore.setLimit(limit);
    },
    changePeriod({ period, date }: { period: string, date: string }) {
      CrashContextStore.setPeriod(period, date);
    },
  },
  computed: {
    crashContexts() {
      return CrashContextStore.crashContexts.value;
    },
    limitOptions() {
      return CrashContextStore.limitOptions.value;
    },
    reportTitle() {
      return `${translate('CrashAnalytics_CrashContext')}: ${this.crash.message}`;
    },
    requestParams() {
      const crash = this.crash as Crash;
      return {
        idLogCrash: crash.idlogcrash,
        ...CrashContextStore.requestParams.value,
      };
    },
    requestParamsJson() {
      return JSON.stringify(this.requestParams);
    },
    reportFormats(): Record<string, string> {
      const formats: Record<string, string> = {
        CSV: 'CSV',
        TSV: 'TSV (Excel)',
        XML: 'XML',
        JSON: 'Json',
        HTML: 'HTML',
      };
      formats.RSS = 'RSS';
      return formats;
    },
    reportExportParams() {
      const limitOptions = CrashContextStore.limitOptions.value;
      return {
        reportTitle: this.reportTitle,
        requestParams: this.requestParamsJson,
        apiMethod: 'CrashAnalytics.getCrashVisitContext',
        reportFormats: this.reportFormats,
        maxFilterLimit: limitOptions[limitOptions.length - 1],
      };
    },
    isVisitorLogDisabled() {
      // eslint-disable-next-line @typescript-eslint/no-explicit-any
      if ((Matomo as any).visitorLogEnabled === false) {
        return true;
      }

      if (!this.crashContexts.length) {
        return false;
      }

      return typeof this.crashContexts[0].actionsBeforeCrash === 'undefined';
    },
    visitorLogDisabledMessage() {
      const url = 'https://matomo.org/faq/how-to/how-do-i-disable-the-visits-log-or-the-visitor-profile-feature/';
      return translate(
        'CrashAnalytics_CrashDetailsVisitorLogDisabledMessage',
        `<a rel="noreferrer noopener" target="_blank" href="${url}">`,
        '</a>',
      );
    },
  },
});
</script>
