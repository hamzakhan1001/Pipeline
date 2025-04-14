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
  <ContentBlock class="funnelsReport">
    <h2>
      <EnrichedHeadline
        feature-name="Funnels"
        :inline-help="translate('Funnels_GoalFunnelReportHelp')"
      >
        {{ translate('Funnels_GoalFunnelReport') }}
      </EnrichedHeadline>
    </h2>

    <table class="reportFlow" v-if="funnelFlow.length">
      <thead>
      <tr>
        <th class="funnelEntries"> </th>
        <th class="separator"></th>
        <th class="funnelFlow"> </th>
        <th class="separator"></th>
        <th class="funnelExits"> </th>
      </tr>
      </thead>
      <tbody>
      <FunnelFlowRow
        v-for="(row, index) in funnelFlow"
        :key="index"
        :row="row"
        :is-last-row="index === funnelFlow.length - 1"
        :id-site="idSite"
        :funnel="funnel"
        :is-visitor-log-enabled="isVisitorLogEnabled"
        :segment="segment"
      />
      </tbody>
    </table>
    <p v-else>
      <strong>{{ translate('CoreHome_ThereIsNoDataForThisReport') }}</strong>
      <br />
      <span v-if="hasBeenPurged">
        {{ translate('CoreHome_DataForThisReportHasBeenPurged', deleteReportsOlderThan) }}
      </span>
      <span v-else>
        {{ translate('Funnels_FunnelReportNotGeneratedYet') }}
      </span>
    </p>
  </ContentBlock>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import {
  ContentBlock,
  EnrichedHeadline,
} from 'CoreHome';
import FunnelFlowRow from './FunnelFlowRow.vue';

export default defineComponent({
  props: {
    funnel: {
      type: Object,
      required: true,
    },
    funnelFlow: {
      type: Array,
      required: true,
    },
    hasBeenPurged: Boolean,
    deleteReportsOlderThan: [Number, String],
    segment: String,
    idSite: {
      type: [Number, String],
      required: true,
    },
    isVisitorLogEnabled: Boolean,
  },
  components: {
    ContentBlock,
    EnrichedHeadline,
    FunnelFlowRow,
  },
});
</script>
