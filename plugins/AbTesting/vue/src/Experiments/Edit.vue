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
    class="editExperiment"
    :content-title="contentTitle"
  >
    <p v-show="create">{{ translate('AbTesting_FormCreateExperimentIntro') }}</p>
    <p v-show="isLoading">
      <span class="loadingPiwik"><img src="plugins/Morpheus/images/loading-blue.gif" />
        {{ translate('General_LoadingData') }}</span>
    </p>
    <p v-show="isUpdating">
      <span class="loadingPiwik"><img src="plugins/Morpheus/images/loading-blue.gif" />
        {{ translate('AbTesting_UpdatingData') }}</span>
    </p>
    <div
      class="alert alert-warning"
      v-show="edit && experiment.status === 'running'"
    >
      {{ translate('AbTesting_ExperimentRunningInfo1') }}
      {{ experiment.start_date }} (UTC)<span
        v-show="experiment.end_date"
      >{{ ` ${translate('AbTesting_ExperimentRunningInfo2')}` }}
      {{ experiment.end_date }} (UTC)</span>.
      {{ translate('AbTesting_ExperimentRunningInfo3') }}
    </div>
    <div
      class="alert alert-warning"
      v-show="edit && experiment.status === 'finished'"
    >
      {{ translate('AbTesting_ExperimentFinishedInfo1') }}
      <br />
      {{ translate('AbTesting_ExperimentFinishedInfo2') }}
    </div>
    <div
      class="alert alert-warning"
      v-show="edit && experiment.status === 'archived'"
    >
      {{ translate('AbTesting_ErrorExperimentCannotBeUpdatedBecauseArchived') }}
    </div>
    <div v-show="edit && experiment.status && !confirmedEdit">
      {{ translate('AbTesting_RelatedActions') }}:
      <ul class="optionsUnconfirmedEditExperiment">
        <li class="actionViewReport">
          <a
            target="_blank"
            :href="viewReportLink"
          ><span class="icon-show" /> {{ translate('AbTesting_ActionViewReport') }}</a>
        </li>
        <li class="actionFinishExperiment">
          <a
            v-show="experiment.status === 'running'"
            @click.prevent="finishExperiment()"
          >
            <span class="abtestingicon-stop" /> {{ translate('AbTesting_ActionFinishExperiment') }}
          </a>
        </li>
        <li class="actionEditAnyway">
          <a
            @click.prevent="confirmedEdit = true"
          >
            <span class="icon-edit" /> {{ translate('AbTesting_ActionEditExperimentAnyway') }}
          </a>
        </li>
        <li class="actionCancel">
          <span
            v-html="$sanitize(
              translate(
                'General_OrCancel',
                '<a class=&quot;cancelLink&quot;>', '</a>'))"
            @click="onCancel($event)"
          />
        </li>
      </ul>
    </div>
    <div
      class="alert alert-warning"
      v-show="confirmedEdit && experiment.status === 'created' && experiment.start_date"
    >
      {{ translate('AbTesting_ExperimentCreatedInfo1') }} {{ experiment.start_date }}<span
        v-if="experiment.end_date"
      >{{ ` ${translate('AbTesting_ExperimentCreatedInfo2')}` }} {{ experiment.end_date }}</span>.
      {{ translate('AbTesting_ExperimentCreatedInfo3') }}
    </div>
    <form @submit.prevent="confirmedEdit ? updateExperiment() : createExperiment()">
      <div
        class="row"
        v-show="(!isLoading) && confirmedEdit || create"
      >
        <div
          class="col m2 entityList"
          v-show="confirmedEdit"
        >
          <ul class="listCircle">
            <li
              class="menuDefinition"
              :class="{active: action === 'basic'}"
            >
              <a
                href
                @click.prevent="action = 'basic'"
              >{{ translate('AbTesting_Definition') }}</a>
            </li>
            <li
              class="menuSuccessMetric"
              :class="{active: action === 'metrics'}"
            >
              <a
                href
                @click.prevent="action = 'metrics'"
              >{{ translate('AbTesting_SuccessMetrics') }}</a>
            </li>
            <li
              class="menuSuccessConditions"
              :class="{active: action === 'conditions'}"
            >
              <a
                href
                @click.prevent="action = 'conditions'"
              >{{ translate('AbTesting_SuccessConditions') }}</a>
            </li>
            <li
              class="menuTargets"
              :class="{active: action === 'targets'}"
            >
              <a
                href
                @click.prevent="action = 'targets'"
              >{{ translate('AbTesting_TargetPages') }}</a>
            </li>
            <li
              class="menuTraffic"
              :class="{'disabled': !experiment.variations?.[0]?.name, active: action === 'traffic'}"
            >
              <a
                href
                @click.prevent="experiment.variations?.[0]?.name ? action = 'traffic' : ''"
              >{{ translate('AbTesting_TrafficAllocation') }}</a>
            </li>
            <li
              class="menuRedirects"
              :class="{active: action === 'redirects'}"
            >
              <a
                href
                @click.prevent="action = 'redirects'"
              >{{ translate('AbTesting_Redirects') }}</a>
            </li>
            <li
              class="menuSchedule"
              :class="{active: action === 'schedule'}"
            >
              <a
                href
                @click.prevent="action = 'schedule'"
              >{{ translate('AbTesting_Schedule') }}</a>
            </li>
            <li
              class="menuEmbed"
              :class="{active: action === 'embed'}"
            >
              <a
                href
                v-show="experiment.status !== 'archived'"
                @click.prevent="showEmbedAction()"
              >{{ translate('AbTesting_EmbedCode') }}</a>
            </li>
          </ul>
          <br />
          <br />
          <br />
          <br />
          <div v-show="experiment.status !== 'archived'">
            <input
              class="btn update"
              type="submit"
              :disabled="isUpdating || !isDirty"
              :value="translate('CoreUpdater_UpdateTitle')"
            />
            <div class="entityCancel">
              <span
                v-html="$sanitize(
                  translate(
                    'General_OrCancel',
                    '<a class=&quot;cancelLink&quot;>', '</a>'))"
                @click="onCancel($event)"
              />
            </div>
          </div>
          <div v-show="experiment.status === 'archived'">
            <div class="entityCancel">
              <a
                class="btn"
                @click="cancel()"
              >{{ translate('AbTesting_NavigationBack') }}</a>
            </div>
          </div>
        </div>
        <div
          :class="{
            'col m10 editExperimentArea': confirmedEdit,
            'col m12 createExperimentArea': create,
          }"
        >
          <div
            class="row"
            v-show="!isLoading"
          >
            <div class="col-md-12">
              <Basic
                v-if="action === 'basic'"
                :experiment="experiment"
                @update-property="experiment[$event.prop] = $event.value; setValueHasChanged()"
                :create="create"
                :create-experiment-target-types="createExperimentTargetTypes"
                @cancel="cancel()"
                @save="confirmedEdit ? updateExperiment() : createExperiment()"
              />
              <Metrics
                v-if="action === 'metrics'"
                :model-value="experiment.success_metrics"
                @update:model-value="experiment = {
                  ...experiment,
                  success_metrics: $event,
                }; setValueHasChanged()"
                :experiment-id-site="experiment.idsite"
                :success-metric-options="successMetricOptions"
              />
              <Conditions
                v-if="action === 'conditions'"
                :experiment="experiment"
                @update-property="experiment[$event.prop] = $event.value; setValueHasChanged()"
                :confidence-threshold-options="confidenceThresholdOptions"
                :mde-relative-options="mdeRelativeOptions"
              />
              <Traffic
                v-if="action === 'traffic'"
                :experiment="experiment"
                @update-property="experiment[$event.prop] = $event.value; setValueHasChanged()"
                :percentage-participants-options="percentageParticipantsOptions"
              />
              <Targets
                v-show="action === 'targets'"
                :experiment="experiment"
                @update-property="experiment[$event.prop] = $event.value; setValueHasChanged()"
              />
              <Redirects
                v-if="action === 'redirects'"
                :model-value="experiment.variations"
                :forward-utm-params="experiment?.forward_utm_params === 1"
                @update:model-value="experiment.variations = $event; setValueHasChanged()"
                @update:forward-utm-params="setForwardUtmParams"
              />
              <Schedule
                v-if="action === 'schedule'"
                :experiment="experiment"
                @update-property="experiment[$event.prop] = $event.value; setValueHasChanged()"
                :utc-time="utcTime"
              />
              <Embed
                v-if="action === 'embed'"
                :experiment="experiment"
                :js-experiment-template-code="jsTemplateCode"
                :js-include-template-code="jsIncludeTemplateCode"
              />
            </div>
          </div>
        </div>
      </div>
    </form>
    <div
      class="ui-confirm"
      ref="confirmUpdateStartExperiment"
    >
      <h2>{{ translate('AbTesting_ConfirmUpdateStartsExperiment') }}</h2>
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
      ref="confirmFinishExperiment"
    >
      <h2>{{ translate('AbTesting_ConfirmFinishExperiment') }}</h2>
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
      ref="updateExperimentNeededToEmbed"
    >
      <h2>{{ translate('AbTesting_ExperimentRequiresUpdateBeforeViewEmbedCode') }}</h2>
      <input
        role="ok"
        type="button"
        :value="translate('General_Ok')"
      />
    </div>
  </ContentBlock>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import {
  translate,
  Matomo,
  ContentBlock,
  NotificationsStore,
  NotificationType,
  clone,
  MatomoUrl,
} from 'CoreHome';
import Basic from './Edit/Basic.vue';
import Metrics from './Edit/Metrics.vue';
import Conditions from './Edit/Conditions.vue';
import Traffic from './Edit/Traffic.vue';
import Targets from './Edit/Targets.vue';
import Redirects from './Edit/Redirects.vue';
import Schedule from './Edit/Schedule.vue';
import Embed from './Edit/Embed.vue';
import ExperimentsStore from './Experiments.store';
import { Experiment } from '../types';
import toLocalTime from '../toLocalTime';

interface Option {
  key: string;
  value: string;
}

interface ExperimentEditState {
  isDirty: boolean;
  jsTemplateCode: string;
  jsIncludeTemplateCode: string;
  successMetricOptions: Option[];
  confirmedEdit: boolean;
  action: string;
  experiment: Experiment;
  utcTime?: string;
}

const notificationId = 'experimentsmanagement';

export default defineComponent({
  props: {
    idExperiment: [Number, String],
  },
  components: {
    ContentBlock,
    Basic,
    Metrics,
    Conditions,
    Traffic,
    Targets,
    Redirects,
    Schedule,
    Embed,
  },
  data(): ExperimentEditState {
    return {
      isDirty: false,
      jsTemplateCode: '',
      jsIncludeTemplateCode: '',
      successMetricOptions: [],
      confirmedEdit: false,
      action: '',
      experiment: {} as unknown as Experiment,
      utcTime: undefined,
    };
  },
  created() {
    ExperimentsStore.fetchJsIncludeTemplate().then((response) => {
      this.jsIncludeTemplateCode = response.value;
    });

    this.setUtcTime();

    ExperimentsStore.fetchAvailableSuccessMetrics().then((metrics) => {
      this.successMetricOptions = (metrics || []).map((m) => ({
        key: m.value,
        value: m.name,
      }));
    });

    this.init();
  },
  watch: {
    idExperiment(newValue) {
      if (newValue === null) {
        return;
      }

      this.init();
    },
  },
  methods: {
    setUtcTime() {
      this.utcTime = this.getUtcTime();
      setTimeout(() => this.setUtcTime(), 10000);
    },
    getUtcTime() {
      const date = new Date();
      if (date.toUTCString) {
        return date.toUTCString();
      }
      return undefined;
    },
    removeAnyExperimentNotification() {
      NotificationsStore.remove('experimentsmanagement');
      NotificationsStore.remove('ajaxHelper');
    },
    showNotification(message: string, context: NotificationType['context']) {
      const instanceId = NotificationsStore.show({
        message,
        context,
        id: notificationId,
        type: 'transient',
      });
      setTimeout(() => {
        NotificationsStore.scrollToNotification(instanceId);
      }, 100);
    },
    showErrorFieldNotProvidedNotification(title: string) {
      const message = translate('AbTesting_ErrorXNotProvided', [title]);
      this.showNotification(message, 'error');
    },
    hasSuccessMetric(successMetric: string) {
      return (this.successMetricOptions || []).some((m) => m.key === successMetric);
    },
    init() {
      this.confirmedEdit = false;
      this.action = 'basic';
      this.experiment = {} as unknown as Experiment;
      this.jsTemplateCode = '';

      if (this.edit && this.idExperiment) {
        ExperimentsStore.findExperiment(this.idExperiment!).then((experiment) => {
          if (!experiment) {
            return;
          }

          this.experiment = clone(experiment) as Experiment;
          this.confirmedEdit = this.experiment.status !== 'running'
            && this.experiment.status !== 'finished';

          if (!this.experiment.variations?.length) {
            this.experiment.variations = [{ name: 'Variation1', percentage: '' }];
          }

          this.addDefaultTargetIfNeeded();
          this.addDefaultSuccessMetricIfNeeded();

          ExperimentsStore.fetchJsExperimentTemplate(this.idExperiment!).then((response) => {
            this.jsTemplateCode = response.value;
          });

          this.isDirty = false;
        });

        return;
      }

      if (this.create) {
        this.experiment = {
          idSite: Matomo.idSite,
          name: '',
          description: '',
          hypothesis: '',
          variations: [{ name: 'Variation1', percentage: '' }],
          confidence_threshold: '95.0',
        } as unknown as Experiment;

        this.addDefaultTargetIfNeeded();

        this.isDirty = false;
      }
    },
    addDefaultTargetIfNeeded() {
      if (this.experiment && !this.experiment.included_targets?.length) {
        this.experiment.included_targets = [{
          attribute: 'url',
          type: 'any',
          value: '',
          inverted: 0,
        }];
      }

      if (this.experiment && !this.experiment.excluded_targets?.length) {
        this.experiment.excluded_targets = [{
          attribute: 'url',
          type: 'equals_exactly',
          value: '',
          inverted: 0,
        }];
      }
    },
    addDefaultSuccessMetricIfNeeded() {
      if (this.experiment && !this.experiment.success_metrics?.length) {
        this.experiment.success_metrics = [];

        let defaultMetric = 'nb_conversions';
        if (!this.hasSuccessMetric(defaultMetric)) {
          defaultMetric = 'nb_pageviews';
        }

        this.experiment.success_metrics.push({
          metric: defaultMetric,
        });

        if (this.hasSuccessMetric('nb_orders')) {
          this.experiment.success_metrics.push({
            metric: 'nb_orders',
          });
        }

        if (this.hasSuccessMetric('nb_orders_revenue')) {
          this.experiment.success_metrics.push({
            metric: 'nb_orders_revenue',
          });
        }
      }
    },
    finishExperiment() {
      Matomo.helper.modalConfirm(this.$refs.confirmFinishExperiment as HTMLElement, {
        yes: () => {
          ExperimentsStore.finishExperiment(this.idExperiment!).then((response) => {
            if (response.type === 'error') {
              return;
            }

            ExperimentsStore.reload().then(() => {
              this.init();
            });

            this.showNotification(
              translate('AbTesting_ExperimentFinished'),
              response.type as NotificationType['context'],
            );
          });
        },
      });
    },
    cancel() {
      const newParams = { ...MatomoUrl.hashParsed.value };
      delete newParams.idExperiment;

      MatomoUrl.updateHash(newParams);
    },
    createExperiment() {
      const method = 'AbTesting.addExperiment';
      this.removeAnyExperimentNotification();

      if (!this.checkRequiredFieldsAreSet()) {
        return;
      }

      if (this.experiment.included_targets[0]?.type === 'equals_simple') {
        if (!this.experiment.included_targets[0].value) {
          this.showNotification(translate('AbTesting_ErrorCreateNoUrlDefined'), 'error');
          return;
        }

        this.experiment.included_targets = [{
          attribute: 'url',
          inverted: '0',
          type: 'equals_simple',
          value: this.experiment.included_targets[0].value,
        }];
      } else {
        this.experiment.included_targets = [{
          attribute: 'url',
          inverted: '0',
          type: 'any',
          value: '',
        }];
      }

      this.addDefaultSuccessMetricIfNeeded();

      ExperimentsStore.createOrUpdateExperiment(this.experiment, method).then((response) => {
        if (response.type === 'error') {
          return;
        }

        this.isDirty = false;

        const idExperiment = response.response!.value;
        ExperimentsStore.reload().then(() => {
          if (Matomo.helper.isReportingPage()) {
            Matomo.postEvent('updateReportingMenu');
          }

          MatomoUrl.updateHash({
            ...MatomoUrl.hashParsed.value,
            idExperiment,
          });

          setTimeout(() => {
            this.showNotification(
              translate('AbTesting_ExperimentCreated'),
              response.type as NotificationType['context'],
            );
          }, 200);
        });
      });
    },
    showEmbedAction() {
      if (!this.isDirty) {
        this.action = 'embed';
        return;
      }

      Matomo.helper.modalConfirm(this.$refs.updateExperimentNeededToEmbed as HTMLElement, {
        yes: () => null,
      });
    },
    updateExperiment() {
      this.removeAnyExperimentNotification();

      if (!this.checkRequiredFieldsAreSet()) {
        return;
      }

      const method = 'AbTesting.updateExperiment';

      let willUpdateStartExperiment = false;
      if (this.experiment.start_date) {
        const startDate = toLocalTime(this.experiment.start_date, false);

        const now = new Date();
        if (startDate && startDate <= now && this.experiment.status === 'created') {
          willUpdateStartExperiment = true;
        }
      }

      const doUpdateExperiment = () => {
        ExperimentsStore.createOrUpdateExperiment(this.experiment, method).then((response) => {
          if (response.type === 'error') {
            return;
          }

          this.isDirty = false;
          ExperimentsStore.reload().then(() => {
            this.init();
          });

          this.showNotification(
            translate('AbTesting_ExperimentUpdated'),
            response.type as NotificationType['context'],
          );
        });
      };

      if (willUpdateStartExperiment) {
        Matomo.helper.modalConfirm(this.$refs.confirmUpdateStartExperiment as HTMLElement, {
          yes: doUpdateExperiment,
        });
      } else {
        doUpdateExperiment();
      }
    },
    checkRequiredFieldsAreSet() {
      if (!this.experiment.name) {
        const title = translate('AbTesting_ExperimentName');
        this.showErrorFieldNotProvidedNotification(title);
        return false;
      }

      if (!this.experiment.hypothesis) {
        const title = translate('AbTesting_Hypothesis');
        this.showErrorFieldNotProvidedNotification(title);
        return false;
      }

      if (!this.experiment.description) {
        const title = translate('General_Description');
        this.showErrorFieldNotProvidedNotification(title);
        return false;
      }

      return true;
    },
    onCancel(event: Event) {
      if (!(event.target as HTMLElement).classList.contains('cancelLink')) {
        return;
      }

      this.cancel();
    },
    setValueHasChanged() {
      this.isDirty = true;
    },
    setForwardUtmParams(forwardUtmParams: boolean) {
      this.experiment.forward_utm_params = forwardUtmParams;
      this.setValueHasChanged();
    },
  },
  computed: {
    percentageParticipantsOptions() {
      const values = [
        1, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70, 75, 80, 85, 90, 95, 100,
      ];

      return values.map((v) => ({
        key: `${v}`,
        value: `${v}%`,
      }));
    },
    mdeRelativeOptions() {
      const values = [
        1, 2, 3, 4, 5, 8, 10, 15, 20, 25, 30, 40, 50, 60, 70, 75, 80, 90, 100, 125, 150, 200, 300,
      ];

      return values.map((v) => ({
        key: `${v}`,
        value: `${v}%`,
      }));
    },
    trafficAllocationOptions() {
      const result: Option[] = [];
      for (let i = 0; i < 101; i += 1) {
        result.push({
          key: `${i}`,
          value: `${i}%`,
        });
      }
      return result;
    },
    confidenceThresholdOptions() {
      const values = ['90.0', '95.0', '98.0', '99.0', '99.5'];
      return values.map((v) => ({
        key: v,
        value: `${v}%`,
      }));
    },
    createExperimentTargetTypes() {
      return [
        {
          key: 'any',
          value: translate('AbTesting_ActivateExperimentOnAllPages'),
        },
        {
          key: 'equals_simple',
          value: translate('AbTesting_ActiveExperimentOnSomePages'),
        },
      ];
    },
    create() {
      return !this.idExperiment || this.idExperiment === '0';
    },
    edit() {
      return !this.create;
    },
    editTitle() {
      return this.create ? 'AbTesting_CreateNewExperiment' : 'AbTesting_EditExperiment';
    },
    contentTitle() {
      return translate(this.editTitle, this.experiment.name ? `"${this.experiment.name}"` : '');
    },
    isLoading() {
      return ExperimentsStore.state.value.isLoading;
    },
    isUpdating() {
      return ExperimentsStore.state.value.isUpdating;
    },
    viewReportLink() {
      return `?${MatomoUrl.stringify({
        module: 'CoreHome',
        action: 'index',
        idSite: this.experiment.idsite,
        period: 'range',
        date: this.experiment.date_range_string,
      })}#?${MatomoUrl.stringify({
        category: 'AbTesting_Experiments',
        idSite: this.experiment.idsite,
        period: 'range',
        date: this.experiment.date_range_string,
        subcategory: this.experiment.idexperiment,
      })}`;
    },
  },
});
</script>
