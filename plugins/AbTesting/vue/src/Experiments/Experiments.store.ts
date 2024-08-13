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
import { Experiment } from '../types';

interface ExperimentStoreState {
  experiments: Experiment[];
  isLoading: boolean;
  isUpdating: boolean;
  filterStatus: string;
}

interface SuccessMetric {
  value: string;
  name: string;
}

interface ExperimentStatus {
  value: string;
  name: string;
}

class ExperimentsStore {
  private privateState = reactive<ExperimentStoreState>({
    experiments: [],
    isLoading: false,
    isUpdating: false,
    filterStatus: '',
  });

  readonly state = computed(() => readonly(this.privateState));

  private fetchPromise: Record<string, Promise<Experiment[]>> = {};

  reload(): ReturnType<ExperimentsStore['fetchExperiments']> {
    this.privateState.experiments = [];
    this.fetchPromise = {};
    return this.fetchExperiments();
  }

  fetchExperiments(): Promise<ExperimentsStore['state']['value']['experiments']> {
    const method = this.privateState.filterStatus
      ? 'AbTesting.getExperimentsByStatuses'
      : 'AbTesting.getActiveExperiments';

    const statuses = this.privateState.filterStatus || undefined;

    const key = `${method}${statuses || ''}`;

    if (!this.fetchPromise[key]) {
      this.fetchPromise[key] = AjaxHelper.fetch<Experiment[]>({
        method,
        filter_limit: '-1',
        statuses,
      });
    }

    this.privateState.isLoading = true;
    this.privateState.experiments = [];
    return this.fetchPromise[key].then((experiments) => {
      this.privateState.experiments = experiments;
      return this.state.value.experiments;
    }).finally(() => {
      this.privateState.isLoading = false;
    });
  }

  fetchAvailableSuccessMetrics(): Promise<SuccessMetric[]> {
    return AjaxHelper.fetch<SuccessMetric[]>({
      method: 'AbTesting.getAvailableSuccessMetrics',
      filter_limit: '-1',
    });
  }

  fetchAvailableStatuses(): Promise<ExperimentStatus[]> {
    return AjaxHelper.fetch({
      method: 'AbTesting.getAvailableStatuses',
      filter_limit: '-1',
    });
  }

  fetchJsExperimentTemplate(idExperiment: number|string): Promise<{ value: string }> {
    return AjaxHelper.fetch({
      method: 'AbTesting.getJsExperimentTemplate',
      idExperiment,
    });
  }

  fetchJsIncludeTemplate(): Promise<{ value: string }> {
    return AjaxHelper.fetch({
      method: 'AbTesting.getJsIncludeTemplate',
    });
  }

  findExperiment(idExperiment: string|number): Promise<DeepReadonly<Experiment>> {
    // before going through an API request we first try to find it in loaded experiments
    const found = this.state.value.experiments.find(
      (e) => `${e.idexperiment}` === `${idExperiment}`,
    );
    if (found) {
      return Promise.resolve(found);
    }

    // otherwise we fetch it via API
    this.privateState.isLoading = true;
    return AjaxHelper.fetch<Experiment>({
      idExperiment,
      method: 'AbTesting.getExperiment',
    }).finally(() => {
      this.privateState.isLoading = false;
    });
  }

  deleteExperiment(idExperiment: string|number): Promise<{ type: string, message?: string }> {
    this.privateState.isUpdating = true;
    this.privateState.experiments = [];
    return AjaxHelper.fetch(
      {
        idExperiment,
        method: 'AbTesting.deleteExperiment',
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

  archiveExperiment(idExperiment: string|number): Promise<{ type: string, message?: string }> {
    this.privateState.isUpdating = true;
    return AjaxHelper.fetch({
      idExperiment,
      method: 'AbTesting.archiveExperiment',
    }).then(() => ({
      type: 'success',
    })).catch((error) => ({
      type: 'error',
      message: error.message || error as string,
    })).finally(() => {
      this.privateState.isUpdating = false;
    });
  }

  createOrUpdateExperiment(
    experiment: Experiment,
    method: string,
  ): Promise<{ type: string, message?: string, response?: { value: string|number } }> {
    const variations = (experiment.variations || []).filter((v) => v?.name);
    if (experiment.original_redirect_url) {
      variations.push({
        name: 'original',
        redirect_url: experiment.original_redirect_url,
      });
    }

    this.privateState.isUpdating = true;
    return AjaxHelper.post<{ value: string|number }>(
      {
        method,
        name: experiment.name.trim(),
        description: experiment.description.trim(),
        hypothesis: experiment.hypothesis.trim(),
        idExperiment: experiment.idexperiment,
        confidenceThreshold: experiment.confidence_threshold,
        startDate: experiment.start_date,
        endDate: experiment.end_date,
        percentageParticipants: experiment.percentage_participants,
        mdeRelative: experiment.mde_relative,
        forwardUtmParams: experiment.forward_utm_params,
      },
      {
        successMetrics: (experiment.success_metrics || []).filter((m) => m?.metric),
        includedTargets: (experiment.included_targets || []).filter(
          (t) => t && (t.value || t.type === 'any'),
        ),
        excludedTargets: (experiment.excluded_targets || []).filter((t) => t?.value),
        variations,
      },
      {
        withTokenInUrl: true,
      },
    ).then((response) => ({
      type: 'success',
      response,
    })).catch((error) => ({
      type: 'error',
      message: error.message || error as string,
    })).finally(() => {
      this.privateState.isUpdating = false;
    });
  }

  finishExperiment(idExperiment: string|number): Promise<{ type: string, message?: string }> {
    this.privateState.isUpdating = true;
    return AjaxHelper.fetch(
      {
        idExperiment,
        method: 'AbTesting.finishExperiment',
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

  setFilterStatus(value: string) {
    this.privateState.filterStatus = value;
  }
}

export default new ExperimentsStore();
