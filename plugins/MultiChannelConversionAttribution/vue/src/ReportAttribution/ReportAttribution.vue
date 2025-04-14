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
  <div class="MultiChannelConversionAttributionWidget">
    <div>
      <h2 v-if="!isWidgetized">
        <EnrichedHeadline :inline-help="reportHelp">
          {{ translate('MultiChannelConversionAttribution_MultiChannelConversionAttribution') }}
        </EnrichedHeadline>
      </h2>
      <div class="alert alert-info" v-if="goals.length === 0">
        {{ translate(noGoalEnabledMessageKey) }}
      </div>
      <div class="row goalAndDaysPrior" v-if="goals.length">
        <div class="col s12 m3">
          <div name="idgoal">
            <Field
              uicontrol="select"
              name="idgoal"
              :disabled="goals.length <= 1"
              :model-value="idGoal"
              @update:model-value="idGoal = $event; onReportChange()"
              :full-width="true"
              :title="translate('General_Goal')"
              :options="goals"
            >
            </Field>
          </div>
        </div>
        <div class="col s12 m6">
          <div name="campaignDimensionCombination">
            <Field
              uicontrol="select"
              name="campaignDimensionCombination"
              :model-value="campaignDimensionCombination"
              @update:model-value="campaignDimensionCombination = $event; onReportChange()"
              :full-width="true"
              :title=
                "translate('MultiChannelConversionAttribution_CampaignDimensionCombinationTitleNew')
                +$sanitize(getEditURL)"
              :options="campaignDimensionCombinationOptions"
            >
            </Field>
          </div>
        </div>
      </div>
      <div class="row modelSelection" v-if="goals.length">
        <div class="col s12 m3">
          <div name="model1">
            <Field
              uicontrol="select"
              name="model1"
              :model-value="model1"
              @update:model-value="model1 = $event; onReportChange(); modelChanged();"
              :full-width="true"
              :title="translate('MultiChannelConversionAttribution_AttributionModelX', 1)"
              :options="attributionModels"
            >
            </Field>
          </div>
        </div>
        <div class="col s12 m3">
          <div name="model2">
            <Field
              uicontrol="select"
              name="model2"
              :model-value="model2"
              @update:model-value="model2 = $event; onReportChange(); modelChanged();"
              :full-width="true"
              :title="translate('MultiChannelConversionAttribution_AttributionModelX', 2)"
              :options="attributionModelsCancelable"
            >
            </Field>
          </div>
        </div>
        <div class="col s12 m3">
          <div name="model3">
            <Field
              uicontrol="select"
              name="model3"
              :model-value="model3"
              @update:model-value="model3 = $event; onReportChange(); modelChanged();"
              :full-width="true"
              :title="translate('MultiChannelConversionAttribution_AttributionModelX', 3)"
              :options="attributionModelsCancelable"
            >
            </Field>
          </div>
        </div>
      </div>
    </div>
    <div class="attributionReport" ref="attributionReport"></div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { EnrichedHeadline, MatomoUrl, translate } from 'CoreHome';
import { Field } from 'CorePluginsAdmin';

interface ReportAttributionState {
  idGoal?: string|number;
  campaignDimensionCombination: string;
  model1: string;
  model2: string;
  model3: string;
}

const { $ } = window;

export default defineComponent({
  props: {
    isWidgetized: Boolean,
    settingsUrl: String,
    reportHtml: {
      type: String,
      required: true,
    },
    reportHelp: {
      type: String,
      required: true,
    },
    noGoalEnabledMessageKey: {
      type: String,
      required: true,
    },
    goals: {
      type: Array,
      required: true,
    },
    campaignDimensionCombinationOptions: {
      type: Array,
      required: true,
    },
    attributionModels: {
      type: Array,
      required: true,
    },
    attributionModelsCancelable: {
      type: Array,
      required: true,
    },
    firstGoal: [String, Number],
    defaultCampaignDimensionCombination: {
      type: String,
      required: true,
    },
    selectedModels: {
      type: Array,
      required: true,
    },
  },
  components: {
    EnrichedHeadline,
    Field,
  },
  data(): ReportAttributionState {
    return {
      idGoal: this.firstGoal,
      campaignDimensionCombination: this.defaultCampaignDimensionCombination,
      model1: (this.selectedModels as string[])[0],
      model2: (this.selectedModels as string[])[1],
      model3: (this.selectedModels as string[])[2],
    };
  },
  mounted() {
    $(this.$refs.attributionReport as HTMLElement).html(this.reportHtml);
    const dataTableEl = $(this.$refs.attributionReport as HTMLElement)
      .find('.dataTable:first');
    if (dataTableEl.length) {
      const reportId = dataTableEl.data('report');
      window.require('piwik/UI/DataTable').initNewDataTables(reportId);
      const dataTable = dataTableEl.data('uiControlObject');
      dataTable.dataTableLoaded(this.reportHtml, dataTable.workingDivId);
      this.modelChanged();
      this.updateHash();
    }
  },
  methods: {
    onReportChange() {
      const dataTable = $(this.$refs.attributionReport as HTMLElement)
        .find('.dataTable:first')
        .data('uiControlObject');

      if (dataTable?.param) {
        this.updateHash();
        dataTable.param.idGoal = this.idGoal;
        dataTable.param.idCampaignDimensionCombination = this.campaignDimensionCombination;
        dataTable.param.attributionModels = `${this.model1},${this.model2},${this.model3}`;
        dataTable.reloadAjaxDataTable();
      }
    },
    modelChanged() {
      const element = document.getElementById('inconsistentDataAlert');
      if (!element) {
        return;
      }
      if (this.model1 === 'lastNonDirect' || this.model2 === 'lastNonDirect' || this.model3 === 'lastNonDirect') {
        element!.classList.remove('hide');
      } else {
        element!.classList.add('hide');
      }
    },
    updateHash() {
      // Update the hash to remember the selection on refresh
      const newParams = { ...MatomoUrl.hashParsed.value };
      delete newParams.idGoal;
      delete newParams.idCampaignDimensionCombination;
      delete newParams.attributionModel1;
      delete newParams.attributionModel2;
      delete newParams.attributionModel3;

      newParams.idGoal = this.idGoal!;
      newParams.idCampaignDimensionCombination = this.campaignDimensionCombination!;
      newParams.attributionModel1 = this.model1!;
      newParams.attributionModel2 = this.model2!;
      newParams.attributionModel3 = this.model3!;
      MatomoUrl.updateHash(newParams);
    },
  },
  computed: {
    getEditURL() {
      if (this.settingsUrl) {
        return translate(
          'MultiChannelConversionAttribution_CampaignCombinationEdit',
          `<a href="${this.settingsUrl}" rel="noreferrer noopener" target="_blank" id="multi-channel-conversion-attribution-settings-edit-link">`,
          '</a>',
        );
      }
      return '';
    },
  },
});
</script>
