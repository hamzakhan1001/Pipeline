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
  <div class="cohortControls">
    <Field
      uicontrol="select"
      name="metric"
      :title="translate('General_Metric')"
      :options="metrics"
      v-model="metric"
      @change="updateSelection"
      :full-width="true"
    />
    <Field
      uicontrol="select"
      name="limit"
      :title="translate('Cohorts_Cohorts')"
      :options="limits"
      v-model="limit"
      @change="updateSelection"
    />
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import {
  AjaxHelper,
  MatomoUrl,
} from 'CoreHome';
import { Field } from 'CorePluginsAdmin';

export default defineComponent({
  props: {
    metrics: {
      type: Object,
      required: true,
    },
    limits: {
      type: Object,
      required: true,
    },
    selectedMetric: {
      type: String,
      required: true,
    },
    selectedLimit: {
      type: Number,
      required: false,
      default: 10,
    },
  },
  data() {
    return {
      metric: this.selectedMetric,
      limit: this.selectedLimit,
    };
  },
  components: {
    Field,
  },
  methods: {
    updateSelection() {
      MatomoUrl.updateHash({
        ...MatomoUrl.hashParsed.value,
        metric: this.metric,
        filter_limit: this.limit,
      });

      this.saveParameters();

      window.location.reload();
    },
    saveParameters() {
      AjaxHelper.post(
        {
          module: 'CoreHome',
          action: 'saveViewDataTableParameters',
          report_id: 'Cohorts.getCohortsTable',
          segment: '',
        },
        {
          parameters: JSON.stringify({
            metric: this.metric,
            filter_limit: this.limit,
          }),
        },
        {
          withTokenInUrl: true,
          format: 'html',
        },
      ).catch(() => {
        // ignore
      });
    },
  },
});
</script>
