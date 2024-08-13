<template>
  <tr
    :class="`step${ row.step_position }`"
  >
    <td colspan="5" class="stepLabel">
      <h3 class="stepName" :title="row.step_definition">
        {{ row.label }}
      </h3>
      <h3
        class="stepMetric"
        :title="row.step_nb_visits !== row.step_nb_visits_actual
              ? translate('Funnels_HitsWereBackfilled', row.step_nb_visits_actual)
              : translate('Funnels_HitsWereNotBackfilled')"
      >
        <!--
          this icon is only there to make sure the label for hits is still centered. it
          will never be visible. prevents jumping of icon when hovering title
        -->
        <span class="icon-visitor-profile" style="visibility: hidden;"></span>
        <span
          class="icon-evolution"
          style="visibility: hidden;"
          v-if="!isLastRow"
        ></span>

        <span v-if="row.step_nb_visits === 1">
          {{ isLastRow ? translate('Funnels_NbConversion', 1) : translate('General_OneVisit') }}
        </span>
        <span v-else>
          {{ isLastRow
            ? translate('Goals_Conversions', row.step_nb_visits)
            : translate('General_NVisits', row.step_nb_visits) }}
        </span>

        <a
          href
          v-if="isVisitorLogEnabled"
          :title="translate('Funnels_SegmentVisitorsByThisFunnelStep')"
          class="segmentVisitors"
          @click.prevent="openSegmentedVisitorLog(row.step_position)"
        >
          <span class="icon-visitor-profile segmentVisitorsByFunnelStep"></span>
        </a>

        <a href
           :title="translate('General_RowEvolutionRowActionTooltipTitle')"
           v-if="!isLastRow"
           class="rowEvolutionByFunnelStep"
           @click.prevent="openRowEvolution(row.label)"
        >
          <span class="icon-evolution"></span>
        </a>
      </h3>
    </td>
  </tr>
  <tr :class="`step${row.step_position}`">
    <td class="funnelEntries">
      <h4>
        {{ row.step_nb_entries === 1
          ? translate('Funnels_NbEntry', 1)
          : translate('Funnels_NbEntries', row.step_nb_entries) }}
      </h4>
      <br />

      <WidgetLoader
        class="actionReportContainer"
        v-if="row.step_nb_entries"
        :widget-params="{
          module: 'Funnels',
          action: 'getFunnelEntries',
          viewDataTable: 'table',
          idSite,
          widget: 1,
          disableLink: 1,
          showtitle: 0,
          idFunnel: funnel.idfunnel,
          step: row.step_position,
        }"
      />
    </td>
    <td class="separator"><h4 class="entryArrow">&rarr;</h4></td>
    <td class="funnelFlow">
      <div v-if="isLastRow">
        <div
          :title="translate('Funnels_XVisitorsConvertedFunnel', funnel.conversionRate)"
          class="progressOuter"
        >
          <div
            class="progressInner"
            :style="{ width: funnel.conversionRate }"
            v-if="funnel.conversionRate"
          >
          </div>
        </div>
        <br />
        <span class="proceededArrow">&darr;</span>
        <br />
        <span
          class="proceededRate"
          v-html="$sanitize(
            translate('Goals_ConversionRate', `${funnel.conversionRate}<br />`)
          )"
        ></span>
        <br />
        {{ translate(
          'Funnels_XoutOfYVisitsconverted',
          funnel.numConversions,
          funnel.numEntries,
        ) }}
        </div>
      <div v-else>
        <div
          :title="`${row.step_proceeded_rate} proceeded to the next step`"
          class="progressOuter"
        >
          <div
            v-if="row.step_proceeded_rate"
            class="progressInner"
            :style="{width: row.step_proceeded_rate}"
          ></div>
        </div>
        <br />
        <span class="proceededArrow">&darr;</span>
        <br />
        <div>
          {{ translate('Funnels_NbProceeded', row.step_nb_proceeded) }}
          <br />
          <span class="proceededRate">{{ row.step_proceeded_rate }}</span>
        </div>
      </div>
    </td>
    <td class="separator">
      <h4 class="exitArrow" v-if="!isLastRow">&rarr;</h4>
    </td>
    <td class="funnelExits">
      <div v-if="!isLastRow">
        <h4>
          {{ row.step_nb_exits === 1 || row.step_nb_exits === '1'
            ? translate('Funnels_NbExit', 1)
            : translate('Funnels_NbExits', row.step_nb_exits,
          ) }}
        </h4>
        <br />

        <WidgetLoader
          v-if="row.step_nb_exits"
          class="actionReportContainer"
          :widget-params="{
            module: 'Funnels',
            action: 'getFunnelExits',
            viewDataTable: 'table',
            idSite,
            widget: 1,
            showtitle: 0,
            disableLink: 1,
            idFunnel: funnel.idfunnel,
            step: row.step_position,
          }"
        />
      </div>
    </td>
  </tr>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import {
  WidgetLoader,
} from 'CoreHome';
import { Funnel } from '../types';

// eslint-disable-next-line @typescript-eslint/no-explicit-any
const { DataTable_RowActions_RowEvolution, SegmentedVisitorLog } = window as any;

export default defineComponent({
  props: {
    row: {
      type: Object,
      required: true,
    },
    funnel: {
      type: Object,
      required: true,
    },
    isLastRow: Boolean,
    isVisitorLogEnabled: Boolean,
    idSite: {
      type: [Number, String],
      required: true,
    },
    segment: String,
  },
  components: {
    WidgetLoader,
  },
  methods: {
    openSegmentedVisitorLog(step: number) {
      const segment = this.segment ? `;${this.segment}` : '';
      SegmentedVisitorLog.show(
        'Funnel.getFunnelFlow',
        `funnels_name==${(this.funnel as Funnel).idfunnel};funnels_step_position==${step}${segment}`,
        {},
      );
    },
    openRowEvolution(label: string) {
      (new DataTable_RowActions_RowEvolution()).showRowEvolution(
        'Funnels.getFunnelFlow',
        label,
        {
          idGoal: (this.funnel as Funnel).idgoal,
          idFunnel: (this.funnel as Funnel).idfunnel,
        },
      );
    },
  },
});

</script>
