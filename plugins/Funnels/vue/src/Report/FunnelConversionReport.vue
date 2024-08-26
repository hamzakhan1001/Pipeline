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
  <div class="funnelReport">
    <ContentBlock>
      <div class="funnelReportHeader">
        <h2>
          <EnrichedHeadline feature-name="Funnels" :inline-help="getFunnelReportHelpText">
            {{ translate('Funnels_FunnelReport') }}
          </EnrichedHeadline>
        </h2>
        <div class="legend" v-if="getFunnelSteps.length">
          <div class="items" v-if="metadata.has_multiple_valid_segments"
               :style="metadata.has_period_comparison
               ? `grid-template-columns: repeat(${columnsPerRow}, auto);`
               : 'grid-template-columns: repeat(3, auto);'">
          <div class="item" v-for="(value, segmentKey) in metadata.segments" :key="segmentKey"
                 :title="parseLegendText(segmentKey).hover">
              <div class="colorBoxSplit"></div>
              <div class="text">
                <span class="title">
                  {{ parseLegendText(segmentKey).title }}
                </span>
                <span class="subtitle" v-if="metadata.has_period_comparison">
                  {{ parseLegendText(segmentKey).subtitle }}
                </span>
              </div>
            </div>
          </div>
          <div class="items" v-else>
            <div v-if="metadata.has_proceeded" class="item">
              <div class="colorBoxProceeded"></div>
              <div class="text">
                <span class="title">{{ translate('Funnels_Progressions') }}</span>
              </div>
            </div>
            <div v-if="metadata.has_entries" class="item">
              <div class="colorBoxEntries"></div>
              <div class="text">
                <span class="title">{{ translate('Funnels_Entries') }}</span>
              </div>
            </div>
            <div v-if="metadata.has_skipped" class="item">
              <div class="colorBoxSkipped"></div>
              <div class="text">
                <span class="title">{{ translate('Funnels_Skips') }}</span>
              </div>
            </div>
            <div v-if="metadata.has_exits" class="item">
              <div class="colorBoxExits"></div>
              <div class="text">
                <span class="title">{{ translate('Funnels_DropOff') }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <table id="funnelConversionTable" v-if="getFunnelSteps.length">
        <thead>
        <tr>
          <th v-for="(step, index) in metadata.steps" :key="step">
            <div class="stepTitle">{{ translate('Funnels_Step') }} {{ index + 1 }}</div>
            <div class="stepLabel">{{ step }}</div>
          </th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td v-for="(segments, stepIndex) in getFunnelSteps" :key="stepIndex">
            <div class="cellLabel">{{ translate('General_ColumnNbVisits') }}</div>
            <div class="metricCount">
              {{ formatAbbr(getFirstSegmentStep(stepIndex).step_nb_visits) }}
            </div>
            <div class="barsContainer">
              <div v-for="(segment, segmentKey) in segments" :key="segmentKey"
                   class="barStepContainer">
                <div class="barStep">
                  <div class="barProceeded"
                       :style="{ height: getBarHeight('proceeded', stepIndex, segment) }"
                       @mouseenter=
                       "handleTooltip($event, segmentKey, stepIndex, segment, 'proceeded', 'show')"
                       @mousemove=
                       "handleTooltip($event, segmentKey, stepIndex, segment, 'proceeded', 'move')"
                       @mouseleave=
                       "handleTooltip($event, segmentKey, stepIndex, segment, 'proceeded', 'hide')">
                  </div>
                  <div class="barEntries"
                       :style="getBarHeight('entries', stepIndex, segment) === '0%'
                        ? { display: 'none' }
                        : { height: getBarHeight('entries', stepIndex, segment) }"
                       @mouseenter=
                       "handleTooltip($event, segmentKey, stepIndex, segment, 'entries', 'show')"
                       @mousemove=
                       "handleTooltip($event, segmentKey, stepIndex, segment, 'entries', 'move')"
                       @mouseleave=
                       "handleTooltip($event, segmentKey, stepIndex, segment, 'entries', 'hide')">
                  </div>
                  <div class="barSkipped"
                       :style="getBarHeight('skipped', stepIndex, segment) === '0%'
                        ? { display: 'none' }
                        : { height: getBarHeight('skipped', stepIndex, segment) }"
                       @mouseenter=
                       "handleTooltip($event, segmentKey, stepIndex, segment, 'skipped', 'show')"
                       @mousemove=
                       "handleTooltip($event, segmentKey, stepIndex, segment, 'skipped', 'move')"
                       @mouseleave=
                       "handleTooltip($event, segmentKey, stepIndex, segment, 'skipped', 'hide')">
                  </div>
                  <div class="barExits"
                       :style="getBarHeight('exits', stepIndex, segment) === '0%'
                        ? { display: 'none' }
                        : { height: getBarHeight('exits', stepIndex, segment) }"
                       @mouseenter=
                       "handleTooltip($event, segmentKey, stepIndex, segment, 'exits', 'show')"
                       @mousemove=
                       "handleTooltip($event, segmentKey, stepIndex, segment, 'exits', 'move')"
                       @mouseleave=
                       "handleTooltip($event, segmentKey, stepIndex, segment, 'exits', 'hide')">
                  </div>
                </div>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td v-for="(segments, stepIndex) in getFunnelSteps" :key="stepIndex">
            <div class="cellLabel">
              {{ getBottomLabel(getFunnelSteps.length === stepIndex + 1) }}
            </div>
            <div :class="getMetricValueClasses(getFunnelSteps.length === stepIndex + 1)">
              <span class="metricCount">
                {{ formatAbbr(getBottomMetric(stepIndex, getFirstSegmentStep(stepIndex))) }}
              </span>
              <span class="metricRate">
                ({{ getBottomRate(stepIndex, getFirstSegmentStep(stepIndex)) }})
              </span>
            </div>
          </td>
        </tr>
        </tbody>
      </table>
      <p v-else>
        <strong>{{ translate('CoreHome_ThereIsNoDataForThisReport') }}</strong>
        <br />
        <span>
          {{ translate('Funnels_FunnelReportNotGeneratedYet') }}
        </span>
      </p>
    </ContentBlock>
    <Tooltip
        ref="tooltip"
        :title="tooltipTitle"
        :subtitle="tooltipSubtitle"
        :exits="tooltipExits"
        :skipped="tooltipSkipped"
        :entries="tooltipEntries"
        :proceeded="tooltipProceeded"
        :type="tooltipType"
    />
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, PropType } from 'vue';
import {
  ContentBlock,
  EnrichedHeadline,
  translate,
} from 'CoreHome';
import Tooltip from '../Tooltip/Tooltip.vue';
import { formatAbbr } from '../../../javascripts/numberFormatter';

interface FunnelStepSegment {
  label: string;
  step_nb_visits_actual: number;
  step_nb_entries: number;
  step_nb_exits: number;
  step_nb_skipped?: number;
  step_nb_visits: number;
  step_nb_proceeded: number;
  step_nb_previous_exits: number;
  step_nb_previous_proceeded: number;
  step_proceeded_rate: string;
  step_rate_exits: string;
  drop_off: number;
  drop_off_rate: string;
  not_dropped_rate: string;
  conversion_rate: string;
  not_converted_rate: string;
  bar_height_empty?: number;
  bar_height_exits?: number;
  bar_height_skipped?: number;
  bar_height_entries?: number;
  bar_height_proceeded?: number;
}

interface FunnelStep {
  [segmentKey: string]: FunnelStepSegment;
}

interface Metadata {
  segments: Record<string, string>;
  steps: string[];
  has_exits: boolean;
  has_skipped: boolean;
  has_entries: boolean;
  has_proceeded: boolean;
  has_multiple_valid_segments: boolean;
  has_period_comparison: boolean;
}

type FunnelBarType = 'empty' | 'exits' | 'skipped' | 'entries' | 'proceeded';

export default defineComponent({
  props: {
    metadata: {
      type: Object as PropType<Metadata>,
      required: true,
    },
    firstSegmentFlow: {
      type: Array as PropType<FunnelStepSegment[]>,
      required: true,
    },
    funnelFlow: {
      type: Array,
      required: true,
    },
    isClosedFunnel: {
      type: Boolean,
      default: false,
    },
  },
  components: {
    EnrichedHeadline,
    ContentBlock,
    Tooltip,
  },
  setup() {
    const tooltip = ref<InstanceType<typeof Tooltip> | null>(null);
    return { tooltip, formatAbbr };
  },
  mounted() {
    if (process.env.NODE_ENV === 'development') {
      console.log('metadata:', this.metadata);
      console.log('firstSegmentFlow:', this.firstSegmentFlow);
      console.log('funnelFlow:', this.funnelFlow);
    }
  },
  data() {
    return {
      tooltipTitle: '',
      tooltipSubtitle: '',
      tooltipExits: 0,
      tooltipSkipped: 0,
      tooltipEntries: 0,
      tooltipProceeded: 0,
      tooltipType: '',
    };
  },
  methods: {
    getFirstSegmentStep(stepIndex: number): FunnelStepSegment {
      return this.firstSegmentFlow[stepIndex] || {};
    },
    translateNumericPlaceholder(key: string, val: number) {
      return translate(key, val || 0);
    },
    getBarHeight(type: FunnelBarType, index: number, step: FunnelStepSegment): string {
      if (step === null) {
        return '0%';
      }
      const heights = {
        empty: step.bar_height_empty,
        exits: step.bar_height_exits,
        skipped: step.bar_height_skipped,
        // For the first step of a funnel, all visits are technically new entries, but for
        // visual consistency, we display them as "proceeded" instead of "entries" in the bar.
        entries: index === 0 ? 0 : step.bar_height_entries,
        proceeded: index === 0 ? step.bar_height_entries : step.bar_height_proceeded,
      };
      return `${heights[type] || 0}%`;
    },
    setTooltipData(segmentKey: string | number, index: number,
      step: FunnelStepSegment, type: FunnelBarType) {
      const { title, period } = this.parseSegmentKey(segmentKey);
      this.tooltipTitle = title;
      this.tooltipSubtitle = period;
      this.tooltipExits = step.step_nb_previous_exits || 0;
      this.tooltipSkipped = step.step_nb_skipped || 0;
      this.tooltipEntries = step.step_nb_entries || 0;
      this.tooltipProceeded = step.step_nb_previous_proceeded || 0;
      this.tooltipType = index === 0 && type === 'proceeded' ? 'entries' : type;
    },
    parseLegendText(segmentKey: string) {
      const { title, period } = this.parseSegmentKey(segmentKey);
      return {
        title,
        subtitle: period,
        hover: `${title} (${period})`,
      };
    },
    parseSegmentKey(segmentKey: string | number) {
      const stringKey = String(segmentKey);
      const parts = stringKey.split('~|~');
      const title = parts[0];
      const period = parts[1];
      return { title, period };
    },
    getBottomLabel(isLastStep: boolean) {
      if (isLastStep) {
        return translate('Funnels_FunnelConversion');
      }

      return translate('Funnels_Exits');
    },
    getBottomMetric(index: number, step: FunnelStepSegment) {
      if (this.getFunnelSteps.length === index + 1) {
        return step.step_nb_visits;
      }

      return step.step_nb_exits;
    },
    getBottomRate(index: number, step: FunnelStepSegment) {
      if (this.getFunnelSteps.length === index + 1) {
        return step.conversion_rate;
      }

      return step.step_rate_exits;
    },
    getMetricValueClasses(isLastStep: boolean) {
      let classes = 'metricValues';
      if (isLastStep) {
        classes += ' conversionMetrics';
      }

      return classes;
    },
    handleTooltip(event: MouseEvent, segmentKey: string | number,
      index: number, step: FunnelStepSegment,
      type: FunnelBarType, action: 'show' | 'hide' | 'move') {
      if (this.tooltip) {
        if (action === 'show') {
          this.setTooltipData(segmentKey, index, step, type);
          this.tooltip.show(event);
        } else if (action === 'move') {
          this.tooltip.show(event);
        } else {
          this.tooltip.hide();
        }
      }
    },
  },
  computed: {
    getFunnelSteps(): Array<FunnelStep> {
      return this.funnelFlow as Array<FunnelStep>;
    },
    getFunnelReportHelpText() {
      const helpText = translate('Funnels_FunnelReportHelp');
      let flowText = translate('Funnels_FunnelReportHelpOpenFunnel');
      let fullHelpText = `${helpText} ${flowText}`;

      if (this.isClosedFunnel) {
        flowText = translate('Funnels_FunnelReportHelpClosedFunnel');
        fullHelpText = `${helpText} ${flowText}`;
      }

      return fullHelpText;
    },
    columnsPerRow() {
      const totalItems = Object.keys(this.metadata.segments).length;
      return Math.ceil(totalItems / 2);
    },
  },
});
</script>
