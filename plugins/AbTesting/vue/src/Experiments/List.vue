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
      :content-title="translate('AbTesting_ManageExperiments')"
      :feature="translate('AbTesting_ManageExperiments')"
    >
      <p>
        {{ translate('AbTesting_ManageExperimentsIntroduction') }}
      </p>
      <div>
        <div class="experimentStatusFilter" id="filterStatus" name="filterStatus">
          <Field
            uicontrol="select"
            name="filterStatus"
            :model-value="filterStatus"
            @update:model-value="setFilterStatus($event); onFilterStatusChange()"
            :title="translate('AbTesting_Filter')"
            :full-width="true"
            :options="statusOptions"
          >
          </Field>
        </div>
        <div
          style="margin-left:3.5px"
          class="experimentSearchFilter"
          name="experimentSearch"
        >
          <Field
            uicontrol="text"
            name="experimentSearch"
            :title="translate('General_Search')"
            v-show="experiments.length > 0"
            v-model="searchFilter"
            :full-width="true"
          >
          </Field>
        </div>
      </div>
      <table v-content-table>
        <thead>
          <tr>
            <th class="index">{{ translate('General_Id') }}</th>
            <th class="name">{{ translate('General_Name') }}</th>
            <th class="description">{{ translate('General_Description') }}</th>
            <th class="status">{{ translate('AbTesting_Status') }}</th>
            <th class="startDate">{{ translate('AbTesting_StartDate') }} (UTC)</th>
            <th class="endDate">{{ translate('AbTesting_FinishDate') }} (UTC)</th>
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
          <tr v-show="!isLoading && experiments.length === 0">
            <td colspan="7">
              <span v-show="filterStatus">
                {{ translate('AbTesting_NoExperimentsFound') }}
              </span>
              <span v-show="!filterStatus">
                {{ translate('AbTesting_NoActiveExperimentConfigured') }}
                <a @click="createExperiment()">
                  {{ translate('AbTesting_CreateNewExperimentNow') }}
                </a>
              </span>
            </td>
          </tr>
          <tr
            :id="`experiment${experiment.idexperiment}`"
            class="experiments"
            v-for="experiment in sortedExperiments"
            :key="experiment.idexperiment"
          >
            <td class="index">{{ experiment.idexperiment }}</td>
            <td class="name">{{ experiment.name }}</td>
            <td class="description">{{ truncateString(experiment.description.trim(), 60) }}</td>
            <td class="status">{{ readableExperimentStatus(experiment.status, statusOptions) }}</td>
            <td
              class="startDate"
              :title="dateInYourTimezoneText(experiment, experiment.start_date)"
            >{{ experiment.start_date }}</td>
            <td
              class="endDate"
              :title="dateInYourTimezoneText(experiment, experiment.end_date)"
            >{{ experiment.end_date }}</td>
            <td class="action">
              <a
                class="table-action icon-edit"
                :title="translate('AbTesting_EditThisExperiment')"
                @click="editExperiment(experiment.idexperiment)"
              />
              <a
                class="table-action icon-delete"
                :title="translate('AbTesting_DeleteExperimentInfo')"
                v-show="experiment.status === 'created'"
                @click="deleteExperiment(experiment)"
              />
              <a
                target="_blank"
                class="table-action icon-show"
                :title="translate('AbTesting_ViewReportInfo')"
                v-show="showViewReportInfo(experiment)"
                :href="getViewReportLink(experiment)"
              />
              <a
                class="table-action abtestingicon-box-add"
                :title="translate('AbTesting_ArchiveReportInfo')"
                v-show="experiment.status === 'finished'"
                @click="archiveExperiment(experiment)"
              />
            </td>
          </tr>
        </tbody>
      </table>
      <div class="tableActionBar">
        <a
          class="createNewExperiment"
          @click="createExperiment()"
        ><span class="icon-add" /> {{ translate('AbTesting_CreateNewExperiment') }}</a>
      </div>
    </ContentBlock>
    <div
      class="ui-confirm"
      ref="confirmArchiveExperiment"
    >
      <h2>{{ translate('AbTesting_ArchiveReportConfirm') }}</h2>
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
    <div
      class="ui-confirm"
      ref="confirmDeleteExperiment"
    >
      <h2>{{ translate('AbTesting_DeleteExperimentConfirm') }} </h2>
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
import { DeepReadonly, defineComponent } from 'vue';
import {
  Matomo,
  translate,
  ContentBlock,
  ContentTable,
  MatomoUrl,
} from 'CoreHome';
import { Field } from 'CorePluginsAdmin';
import ExperimentsStore from './Experiments.store';
import { Experiment } from '../types';
import toLocalTime from '../toLocalTime';

interface Option {
  key: string;
  value: string;
}

interface ExperimentsListState {
  searchFilter: string;
  statusOptions: Option[];
}

export default defineComponent({
  props: {
  },
  components: {
    ContentBlock,
    Field,
  },
  directives: {
    ContentTable,
  },
  data(): ExperimentsListState {
    return {
      searchFilter: '',
      statusOptions: [],
    };
  },
  created() {
    ExperimentsStore.fetchAvailableStatuses().then((statuses) => {
      this.statusOptions = [
        {
          key: '',
          value: translate('AbTesting_StatusActive'),
        },
        ...statuses.map((s) => ({
          key: s.value,
          value: s.name,
        })),
      ];
    });

    this.onFilterStatusChange();
  },
  methods: {
    createExperiment() {
      this.editExperiment(0);
    },
    editExperiment(idExperiment: string|number) {
      MatomoUrl.updateHash({
        ...MatomoUrl.hashParsed.value,
        idExperiment,
      });
    },
    deleteExperiment(experiment: Experiment) {
      Matomo.helper.modalConfirm(this.$refs.confirmDeleteExperiment as HTMLElement, {
        yes: () => {
          ExperimentsStore.deleteExperiment(experiment.idexperiment).then(() => {
            ExperimentsStore.reload();
          });
        },
      });
    },
    archiveExperiment(experiment: Experiment) {
      Matomo.helper.modalConfirm(this.$refs.confirmArchiveExperiment as HTMLElement, {
        yes: () => {
          ExperimentsStore.archiveExperiment(experiment.idexperiment).then(() => {
            ExperimentsStore.reload();
          });
        },
      });
    },
    onFilterStatusChange() {
      ExperimentsStore.fetchExperiments();
    },
    setFilterStatus(status: string) {
      ExperimentsStore.setFilterStatus(status);
    },
    truncateString(text: string, length: number) {
      if (text && text.length > length) {
        return `${text.substr(0, length - 3)}...`;
      }
      return text;
    },
    readableExperimentStatus(status: string, statusOptions?: Option[]) {
      if (!statusOptions) {
        return status;
      }

      return statusOptions.find((s) => status === s.key)?.value;
    },
    dateInYourTimezoneText(experiment: Experiment, date: string) {
      const equalsDate = translate('AbTesting_EqualsDateInYourTimezone');
      return toLocalTime(date, true)
        ? `${equalsDate}${toLocalTime(date, true)}`
        : '';
    },
    showViewReportInfo(experiment: Experiment) {
      return (experiment.status === 'running' || experiment.status === 'finished')
        && experiment.date_range_string;
    },
    getViewReportLink(experiment: Experiment) {
      return `?${MatomoUrl.stringify({
        module: 'CoreHome',
        action: 'index',
        idSite: experiment.idsite,
        period: 'range',
        date: experiment.date_range_string,
      })}#?${MatomoUrl.stringify({
        category: 'AbTesting_Experiments',
        idSite: experiment.idsite,
        period: 'range',
        date: experiment.date_range_string,
        subcategory: experiment.idexperiment,
      })}`;
    },
  },
  computed: {
    siteName(): string {
      return Matomo.siteName;
    },
    filterStatus(): (typeof ExperimentsStore)['state']['value']['filterStatus'] {
      return ExperimentsStore.state.value.filterStatus;
    },
    experiments(): (typeof ExperimentsStore)['state']['value']['experiments'] {
      return ExperimentsStore.state.value.experiments;
    },
    isLoading(): boolean {
      return ExperimentsStore.state.value.isLoading;
    },
    isUpdating(): boolean {
      return ExperimentsStore.state.value.isUpdating;
    },
    sortedExperiments(): DeepReadonly<Experiment[]> {
      const experiments = [...this.experiments].filter((h) => Object.keys(h).some((propName) => {
        const entity = h as unknown as Record<string, unknown>;
        return typeof entity[propName] === 'string'
          && (entity[propName] as string).indexOf(this.searchFilter) !== -1;
      }));
      experiments.sort((lhs, rhs) => {
        const lhsId = parseInt(`${lhs.idexperiment}`, 10);
        const rhsId = parseInt(`${rhs.idexperiment}`, 10);
        return lhsId - rhsId;
      });
      return experiments;
    },
  },
});
</script>
