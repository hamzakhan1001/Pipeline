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
  <p class="experimentSummary">
    <strong>{{ translate('AbTesting_Hypothesis') }}:</strong> {{ experiment.hypothesis }}
    <br />
    <strong>{{ translate('General_Description') }}:</strong> {{ experiment.description }}
    <br />
    <strong>{{ translate('AbTesting_ExpectedImprovement') }}:</strong>
    {{ experiment.mde_relative }}%
    <br />
    <strong>{{ translate('AbTesting_ConfidenceThreshold') }}:</strong>
    {{ experiment.confidence_threshold }}%
    <br />
    <strong>{{ translate('AbTesting_Status') }}:</strong>

    <span v-if="experiment.status === 'running'" style="margin-left:3.5px">
      <span v-html="$sanitize(reportStatusRunning)" style="margin-right:3.5px" />
      <a
        v-if="isAdmin"
        class="finishExperiment"
        @click.prevent="finishExperiment()"
      >{{ translate('AbTesting_ActionFinishExperiment') }}</a>
      <br /><br />
      {{ translate('AbTesting_ReportWhenToDeclareWinner') }}
    </span>

    <span v-if="experiment.status === 'finished'">
      <span v-html="$sanitize(reportStatusFinished)"/>
      <a
        v-if="isAdmin"
        :title="translate('AbTesting_ArchiveReportInfo')"
        @click.prevent="archiveExperiment()"
        class="archiveExperiment"
      >
        {{ translate('AbTesting_ActionArchiveExperiment') }}
      </a>
    </span>
  </p>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import {
  NotificationsStore,
  translate,
  Matomo,
  MatomoUrl,
} from 'CoreHome';
import ExperimentsStore from '../Experiments/Experiments.store';

export default defineComponent({
  props: {
    experiment: {
      type: Object,
      required: true,
    },
    isAdmin: Boolean,
    startDateSiteTimezonePretty: String,
    endDateSiteTimezonePretty: String,
  },
  computed: {
    reportStatusRunning() {
      return translate(
        'AbTesting_ReportStatusRunning',
        `<span class="reportDuration">${this.experiment.duration}</span>`,
        this.startDateSiteTimezonePretty || '',
      );
    },
    reportStatusFinished() {
      return translate(
        'AbTesting_ReportStatusFinished',
        `<span class="reportDuration">${this.experiment.duration}</span>`,
        this.startDateSiteTimezonePretty || '',
        this.endDateSiteTimezonePretty || '',
      );
    },
  },
  methods: {
    finishExperiment() {
      Matomo.helper.modalConfirm('#confirmFinishExperiment', {
        yes: () => {
          ExperimentsStore.finishExperiment(this.experiment.idexperiment).then((response) => {
            if (response.type === 'error') {
              return;
            }

            Matomo.helper.redirect();
          });
        },
      });
    },
    archiveExperiment() {
      Matomo.helper.modalConfirm('#confirmArchiveExperiment', {
        yes: () => {
          ExperimentsStore.archiveExperiment(this.experiment.idexperiment).then((response) => {
            if (response.type === 'error') {
              return;
            }

            NotificationsStore.show({
              message: translate('AbTesting_ActionArchiveExperimentSuccess'),
              context: 'success',
              type: 'transient',
            });

            MatomoUrl.updateUrl(
              {
                ...MatomoUrl.urlParsed.value,
                popover: '',
                idExperiment: this.experiment.idexperiment,
                segment: '',
              },
              {
                ...MatomoUrl.hashParsed.value,
                category: 'General_Visitors',
                subcategory: 'General_Overview',
              },
            );
          });
        },
      });
    },
  },
});
</script>
