/**
 * Copyright (C) InnoCraft Ltd - All rights reserved.
 *
 * NOTICE:  All information contained herein is, and remains the property of InnoCraft Ltd.
 * The intellectual and technical concepts contained herein are protected by trade secret
 * or copyright law. Redistribution of this information or reproduction of this material is
 * strictly forbidden unless prior written permission is obtained from InnoCraft Ltd.
 *
 * You shall use this code only in accordance with the license agreement obtained from
 * InnoCraft Ltd.
 *
 * @link https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */

import {
  reactive,
  computed,
  readonly,
  DeepReadonly,
} from 'vue';
import { AjaxHelper } from 'CoreHome';
import {
  Form,
  FormRule,
  PageRule,
  Rule,
  Status,
} from './types';

interface FormAnalyticsStoreState {
  forms: Form[];
  isLoading: boolean;
  isUpdating: boolean;
  filterStatus: string;
}

class FormAnalyticsStore {
  private privateState = reactive<FormAnalyticsStoreState>({
    forms: [],
    isLoading: false,
    isUpdating: false,
    filterStatus: 'running',
  });

  readonly state = computed(() => readonly(this.privateState));

  private fetchPromise: Record<string, Promise<Form[]>> = {};

  reload(): ReturnType<FormAnalyticsStore['fetchForms']> {
    this.privateState.forms = [];
    this.fetchPromise = {};
    return this.fetchForms();
  }

  filterRules(rules: Rule[]): Rule[] {
    return rules.filter((target) => !!target?.value);
  }

  getAvailableFormRules(): Promise<FormRule[]> {
    return AjaxHelper.fetch<FormRule[]>({
      method: 'FormAnalytics.getAvailableFormRules',
      filter_limit: '-1',
    });
  }

  getAvailablePageRules(): Promise<PageRule[]> {
    return AjaxHelper.fetch<PageRule[]>({
      method: 'FormAnalytics.getAvailablePageRules',
      filter_limit: '-1',
    });
  }

  getAvailableConversionRuleOptions(): Promise<PageRule[]> {
    return AjaxHelper.fetch<PageRule[]>({
      method: 'FormAnalytics.getAvailableConversionRuleOptions',
      filter_limit: '-1',
    });
  }

  fetchAvailableStatuses(): Promise<Status[]> {
    return AjaxHelper.fetch<Status[]>({
      method: 'FormAnalytics.getAvailableStatuses',
    });
  }

  fetchForms(): Promise<FormAnalyticsStore['state']['value']['forms']> {
    const key = `FormAnalytics.getFormsByStatuses${this.privateState.filterStatus}`;
    if (!this.fetchPromise[key]) {
      this.fetchPromise[key] = AjaxHelper.fetch<Form[]>({
        method: 'FormAnalytics.getFormsByStatuses',
        filter_limit: '-1',
        statuses: this.privateState.filterStatus,
      });
    }

    this.privateState.isLoading = true;
    this.privateState.forms = [];
    return this.fetchPromise[key].then((forms) => {
      this.privateState.forms = forms;
      this.privateState.isLoading = false;
      return this.state.value.forms;
    }).finally(() => {
      this.privateState.isLoading = false;
    });
  }

  findForm(idSiteForm: number): Promise<DeepReadonly<Form>> {
    // before going through an API request we first try to find it in loaded forms
    const found = this.state.value.forms.find((f) => f.idsiteform === idSiteForm);
    if (found) {
      return Promise.resolve(found);
    }

    // otherwise we fetch it via API
    this.privateState.isLoading = true;
    return AjaxHelper.fetch<Form>({
      idForm: idSiteForm,
      method: 'FormAnalytics.getForm',
    }).then((form) => readonly(form)).finally(() => {
      this.privateState.isLoading = false;
    });
  }

  deleteForm(idForm: number): Promise<{ type: string, message?: string }> {
    this.privateState.isUpdating = true;
    this.privateState.forms = [];
    return AjaxHelper.fetch(
      {
        idForm,
        method: 'FormAnalytics.deleteForm',
      },
      {
        withTokenInUrl: true,
      },
    ).then(() => ({
      type: 'success',
    })).catch((error) => ({
      type: 'error',
      message: error.message || error as string,
    })).finally(() => {
      this.privateState.isUpdating = false;
    });
  }

  archiveForm(idForm: number): Promise<{ type: string, message?: string }> {
    this.privateState.isUpdating = true;
    this.privateState.forms = [];
    return AjaxHelper.fetch(
      {
        idForm,
        method: 'FormAnalytics.archiveForm',
      },
      {
        withTokenInUrl: true,
      },
    ).then(() => ({
      type: 'success',
    })).catch((error) => ({
      type: 'error',
      message: error.message || error,
    })).finally(() => {
      this.privateState.isUpdating = false;
    });
  }

  createOrUpdateForm(
    form: Form,
    matchPageOnly: boolean,
    method: string,
  ): Promise<{ type: string, message?: string, response?: { value: number } }> {
    this.privateState.isUpdating = true;
    return AjaxHelper.post<{ value: number }>(
      {
        method,
        idForm: form.idsiteform,
        name: form.name.trim(),
        description: form.description.trim(),
        conversionRuleOption: form.conversion_rule_option,
      },
      {
        matchFormRules: this.filterRules(matchPageOnly ? [] : form.match_form_rules),
        matchPageRules: this.filterRules(form.match_page_rules),
        conversionRules: this.filterRules(form.conversion_rules),
      },
      { withTokenInUrl: true },
    ).then((response) => ({
      type: 'success',
      response,
    })).catch((error) => ({
      type: 'error',
      message: error.message || error,
    })).finally(() => {
      this.privateState.isUpdating = false;
    });
  }

  setFilterStatus(filterStatus: string) {
    this.privateState.filterStatus = filterStatus;
  }
}

export default new FormAnalyticsStore();
