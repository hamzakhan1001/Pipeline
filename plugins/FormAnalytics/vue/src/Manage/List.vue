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
      :content-title="translate('FormAnalytics_ManageForms')"
      :feature="translate('FormAnalytics_ManageForms')"
    >
      <p>
        {{ translate('FormAnalytics_ManageFormsIntroduction') }}
        <br /><br />
        {{ autoCreationMessage }}
      </p>
      <div>
        <div class="formStatusFilter" name="filterStatus" id="filterStatus">
          <Field
            uicontrol="select"
            name="filterStatus"
            :model-value="filterStatus"
            @update:model-value="setFilterStatus($event); onFilterStatusChange()"
            :title="translate('FormAnalytics_Filter')"
            :full-width="true"
            :options="statusOptions"
          >
          </Field>
        </div>
        <div class="formSearchFilter" name="formSearch" style="margin-left:3.5px">
          <Field
            uicontrol="text"
            name="formSearch"
            :title="translate('General_Search')"
            v-show="forms.length > 0"
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
            <th class="description">{{ translate('FormAnalytics_ConversionCriteria') }}</th>
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
          <tr v-show="!isLoading && forms.length === 0">
            <td colspan="7">
              {{ translate('FormAnalytics_NoFormsFound') }}
            </td>
          </tr>
          <tr
            :id="`form${form.idsiteform}`"
            class="forms"
            v-for="form in sortedForms"
            :key="form.idsiteform"
          >
            <td class="index">{{ form.idsiteform }}</td>
            <td class="name">{{ form.name }}</td>
            <td
              class="description"
              :title="form.description"
            >{{ truncateText(form.description.trim(), 60) }}</td>
            <td class="conversionRulesConfigured">
              <span
                :class="{ 'icon-ok': form.conversion_rules.length >= 1
                ||
                (form.conversion_rule_option && form.conversion_rule_option !== 'page_visit')
              }"
              />
            </td>
            <td class="action">
              <a
                class="table-action icon-edit"
                :title="translate('FormAnalytics_EditForm')"
                @click="editForm(form.idsiteform)"
              />
              <a
                target="_blank"
                class="table-action icon-show"
                :title="translate('FormAnalytics_ViewReportInfo')"
                v-show="form.status === 'running'"
                :href="getViewFormLink(form)"
              />
              <a
                class="table-action icon-archive"
                :title="translate('FormAnalytics_ArchiveReportInfo')"
                v-show="form.status === 'running'"
                @click="archiveForm(form)"
              />
              <a
                class="table-action icon-delete"
                :title="translate('FormAnalytics_DeleteFormInfo')"
                @click="deleteForm(form)"
              />
            </td>
          </tr>
        </tbody>
      </table>
      <div class="tableActionBar">
        <a
          class="createNewForm"
          @click="createForm()"
        >
          <span class="icon-add" /> {{ translate('FormAnalytics_CreateNewForm') }}
        </a>
      </div>
    </ContentBlock>
    <div
      class="ui-confirm"
      ref="confirmArchiveForm"
    >
      <h2>{{ translate('FormAnalytics_ArchiveReportConfirm') }}</h2>
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
      ref="confirmDeleteForm"
    >
      <h2>{{ translate('FormAnalytics_DeleteFormConfirm') }} </h2>
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
  AjaxHelper,
  ContentBlock,
  ContentTable,
  MatomoUrl,
} from 'CoreHome';
import { Field } from 'CorePluginsAdmin';
import FormAnalyticsStore from '../FormAnalytics.store';
import { Form, Status } from '../types';

interface Option {
  key: string;
  value: string;
}

interface FormsListState {
  autoCreationMessage: string;
  statuses: Status[];
  searchFilter: string;
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
  data(): FormsListState {
    return {
      autoCreationMessage: '',
      statuses: [],
      searchFilter: '',
    };
  },
  created() {
    AjaxHelper.fetch<{ message: string }>({
      method: 'FormAnalytics.getAutoCreationSettings',
    }).then((response) => {
      if (response?.message) {
        this.autoCreationMessage = response.message;
      }
    });

    FormAnalyticsStore.fetchAvailableStatuses().then((statuses) => {
      this.statuses = statuses;
    });

    this.onFilterStatusChange();
  },
  methods: {
    setFilterStatus(filterStatus: string) {
      FormAnalyticsStore.setFilterStatus(filterStatus);
    },
    createForm() {
      this.editForm(0);
    },
    editForm(idForm: number) {
      MatomoUrl.updateHash({
        ...MatomoUrl.hashParsed.value,
        idForm,
      });
    },
    deleteForm(form: Form) {
      Matomo.helper.modalConfirm(this.$refs.confirmDeleteForm as HTMLElement, {
        yes: () => {
          FormAnalyticsStore.deleteForm(form.idsiteform).then(() => {
            FormAnalyticsStore.reload();
            Matomo.postEvent('updateReportingMenu');
          });
        },
      });
    },
    archiveForm(form: Form) {
      Matomo.helper.modalConfirm(this.$refs.confirmArchiveForm as HTMLElement, {
        yes: () => {
          FormAnalyticsStore.archiveForm(form.idsiteform).then(() => {
            FormAnalyticsStore.reload();
            Matomo.postEvent('updateReportingMenu');
          });
        },
      });
    },
    onFilterStatusChange() {
      FormAnalyticsStore.fetchForms();
    },
    truncateText(text: string, length: number) {
      if (text.length > length) {
        return `${text.substr(0, length - 3)}...`;
      }
      return text;
    },
    getViewFormLink(form: Form) {
      return `?${MatomoUrl.stringify({
        module: 'CoreHome',
        action: 'index',
        idSite: form.idsite,
        period: 'day',
        date: 'yesterday',

      })}#?${MatomoUrl.stringify({
        category: 'FormAnalytics_Forms',
        idSite: form.idsite,
        period: 'day',
        date: 'yesterday',
        subcategory: form.idsiteform,
      })}`;
    },
  },
  computed: {
    filterStatus(): string {
      return FormAnalyticsStore.state.value.filterStatus;
    },
    statusOptions(): Option[] {
      return this.statuses
        .filter((s) => s.value !== 'deleted')
        .map((s) => ({
          key: s.value,
          value: s.name,
        }));
    },
    forms(): (typeof FormAnalyticsStore)['state']['value']['forms'] {
      return FormAnalyticsStore.state.value.forms;
    },
    isLoading(): (typeof FormAnalyticsStore)['state']['value']['isLoading'] {
      return FormAnalyticsStore.state.value.isLoading;
    },
    isUpdating(): (typeof FormAnalyticsStore)['state']['value']['isUpdating'] {
      return FormAnalyticsStore.state.value.isUpdating;
    },
    sortedForms(): DeepReadonly<Form[]> {
      const forms = [...this.forms].filter((h) => Object.keys(h).some((propName) => {
        const entity = h as unknown as Record<string, unknown>;
        return typeof entity[propName] === 'string'
          && (entity[propName] as string).toLowerCase().indexOf(
            this.searchFilter.toLowerCase(),
          ) !== -1;
      }));
      forms.sort((lhs, rhs) => {
        const lhsId = parseInt(`${lhs.idsiteform}`, 10);
        const rhsId = parseInt(`${rhs.idsiteform}`, 10);
        return lhsId - rhsId;
      });
      return forms;
    },
  },
});
</script>
