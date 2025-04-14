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
  <div>
    <ContentBlock
      :content-title="translate('AdvertisingConversionExport_ManageExports')"
      :feature="translate('AdvertisingConversionExport_ManageExports')"
    >
      <p>
        {{ translate('AdvertisingConversionExport_ManageExportsIntroduction') }}
      </p>
      <table v-content-table>
        <thead>
          <tr>
            <th class="index">{{ translate('General_Id') }}</th>
            <th class="name">{{ translate('General_Name') }}</th>
            <th class="type">{{ translate('AdvertisingConversionExport_ExportType') }}</th>
            <th
              class="description"
              v-if="atLeastOneExportWithDescription"
            >{{ translate('General_Description') }}</th>
            <th class="goals">
              {{ translate('AdvertisingConversionExport_IncludedConversions') }}
            </th>
            <th
              class="requested"
              :title="translate('AdvertisingConversionExport_LastRequestedInfo')"
            >{{ translate('AdvertisingConversionExport_LastRequested') }}</th>
            <th class="action">{{ translate('General_Actions') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-show="isLoading || isUpdating">
            <td colspan="6">
              <span class="loadingPiwik"><img src="plugins/Morpheus/images/loading-blue.gif" />
                {{ translate('General_LoadingData') }}</span>
            </td>
          </tr>
          <tr v-show="!isLoading && exports.length === 0">
            <td colspan="6">
              {{ translate('AdvertisingConversionExport_NoExportsFound') }}
            </td>
          </tr>
          <tr
            v-for="exp in sortedExports"
            :id="`export${exp.idexport}`"
            class="exports"
            :key="exp.idexport"
          >
            <td class="index">{{ exp.idexport }}</td>
            <td class="name">{{ exp.name }}</td>
            <td class="type">{{ exportTypes[exp.type].name }}</td>
            <td
              class="description"
              :title="exp.description"
              v-if="atLeastOneExportWithDescription && exp.description.trim().length > 63"
            >{{ exp.description.trim().substring(0, 60) }}...</td>
            <td
              class="description"
              :title="exp.description"
              v-if="atLeastOneExportWithDescription && exp.description.trim().length <= 63"
            >{{ exp.description.trim() }}</td>
            <td class="goals">
              <span
                v-for="goal in exp.parameters?.goals || []"
                :key="goal.idgoal"
              >
                {{ goals.find((g) => g.key === `${goal.idgoal}`)?.value
                  || translate('General_Unknown') }}
                <span v-html="$sanitize(getDisplayGoalName(goal))"/>
                <br />
              </span>
            </td>
            <td
              class="requested"
              v-if="exp.ts_requested"
            >{{ exp.ts_requested_pretty }}</td>
            <td
              class="requested"
              v-if="!exp.ts_requested"
            >{{ translate('General_Never') }}</td>
            <td class="action">
              <a
                class="table-action icon-download"
                :title="translate('AdvertisingConversionExport_DownloadExport')"
                @click="openExport(exp.idexport, exp.idsite)"
              />
              <a
                class="table-action icon-edit"
                :title="translate('AdvertisingConversionExport_EditExport')"
                @click="editExport(exp.idexport)"
              />
              <a
                class="table-action icon-delete"
                :title="translate('AdvertisingConversionExport_DeleteExport')"
                @click="deleteExport(exp)"
              />
            </td>
          </tr>
        </tbody>
      </table>
      <div
        class="tableActionBar"
        v-show="hasWriteAccess"
      >
        <a
          class="createNewExport"
          @click="createExport()"
        >
          <span class="icon-add" />
          {{ translate('AdvertisingConversionExport_CreateNewExport') }}
        </a>
      </div>
    </ContentBlock>
    <div
      class="ui-confirm"
      id="confirmDeleteExport"
      ref="confirmDeleteExport"
    >
      <h2>{{ translate('AdvertisingConversionExport_DeleteExportConfirm') }} </h2>
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
  Matomo,
  ContentBlock,
  ContentTable,
  MatomoUrl,
} from 'CoreHome';
import ConversionExportStore from '../ConversionExportStore.store';
import { ConversionExport } from '../types';

interface ConversionExportListState {
  exportLink: string;
}

export default defineComponent({
  props: {
    exportTypes: {
      type: Object,
      required: true,
    },
    alreadyCreatedExportTypes: {
      type: Object,
      required: true,
    },
    clickIdProviders: {
      type: Object,
      required: true,
    },
    hasWriteAccess: Boolean,
  },
  components: {
    ContentBlock,
  },
  directives: {
    ContentTable,
  },
  data(): ConversionExportListState {
    return {
      exportLink: '',
    };
  },
  created() {
    ConversionExportStore.fetchExports();
  },
  methods: {
    getDisplayGoalName(goal: { name: string }) {
      return goal.name ? `(&#x279C;&nbsp;${Matomo.helper.htmlEntities(goal.name)})` : '';
    },
    getDownloadLink(idExport: string, idSite: string) {
      const params = MatomoUrl.stringify({
        module: 'AdvertisingConversionExport',
        action: 'downloadConversionExport',
        idExport,
        idSite,
      });
      return `${window.location.origin}${window.location.pathname}?${params}`;
    },
    createExport() {
      this.editExport(0);
    },
    editExport(idExport: number) {
      MatomoUrl.updateHash({
        ...MatomoUrl.hashParsed.value,
        idExport,
      });
    },
    openExport(idExport: string, idSite: string) {
      window.open(this.getDownloadLink(idExport, idSite));
    },
    deleteExport(conversionExport: ConversionExport) {
      Matomo.helper.modalConfirm(this.$refs.confirmDeleteExport as HTMLElement, {
        yes: () => {
          ConversionExportStore.deleteExport(
            parseInt(conversionExport.idexport as string, 10),
          ).then(() => {
            ConversionExportStore.reload();
          });
        },
      });
    },
  },
  computed: {
    atLeastOneExportWithDescription() {
      return ConversionExportStore.exports.value.filter((e) => !!e.description).length;
    },
    isLoading() {
      return ConversionExportStore.state.value.isLoading;
    },
    isUpdating() {
      return ConversionExportStore.state.value.isUpdating;
    },
    exports() {
      return ConversionExportStore.exports.value;
    },
    sortedExports() {
      const result = [...this.exports];
      result.sort(
        (lhs, rhs) => parseInt(`${lhs.idexport}`, 10) - parseInt(`${rhs.idexport}`, 10),
      );
      return result;
    },
    goals() {
      return ConversionExportStore.goals.value || [];
    },
  },
});
</script>
