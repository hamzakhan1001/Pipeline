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
  <ContentBlock :content-title="$sanitize(funnel.name)">
    <div class="funnelsReport">
      <div class="funnelSummary">
        <span v-if="isVisitorLogEnabled">
          <a
            class="funnelOverviewLink"
            @click.prevent="openSegmentedVisitorLog()"
          >
            <span class="icon-visitor-profile funnelOverviewLink"></span>
            {{ translate('Funnels_ShowFunnelVisitsLog') }}
          </a>
        </span>
        <span v-if="funnel.idgoal > 0">
          <a
            class="funnelOverviewLink"
            @click.prevent="openGoalReport()"
          >
            <span class="icon-reporting-goal funnelOverviewLink"></span>
            {{ translate('Funnels_ShowGoalReport') }}
          </a>
        </span>
        <span v-if="userCanEditFunnels">
          <a
            @click.prevent="editFunnel()"
            class="funnelOverviewLink"
          >
          <span class="icon-edit funnelOverviewLink"></span>
          {{ translate('Funnels_EditFunnel') }}
        </a>
        </span>
      </div>
    </div>
  </ContentBlock>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import {
  ContentBlock,
  ContentTable,
  MatomoUrl,
} from 'CoreHome';

// eslint-disable-next-line @typescript-eslint/no-explicit-any
const { SegmentedVisitorLog } = window as any;

export default defineComponent({
  props: {
    funnel: {
      type: Object,
      required: true,
    },
    goalsSummary: Object,
    isVisitorLogEnabled: Boolean,
    segment: String,
    patternTranslations: {
      type: Object,
      required: true,
    },
    funnelFlow: {
      type: Object,
      required: true,
    },
    isNonGoalFunnel: {
      type: Boolean,
      required: false,
      default: false,
    },
    userCanEditFunnels: {
      type: Boolean,
      required: false,
      default: false,
    },
  },
  components: {
    ContentBlock,
  },
  directives: {
    ContentTable,
  },
  methods: {
    openSegmentedVisitorLog() {
      SegmentedVisitorLog.show(
        'Funnel.getFunnelFlow',
        `funnels_name==${this.funnel.idfunnel}${this.segment ? `;${this.segment}` : ''}`,
        {},
      );
    },
    openGoalReport() {
      MatomoUrl.updateHash({
        ...MatomoUrl.hashParsed.value,
        category: 'Goals_Goals',
        subcategory: this.funnel.idgoal,
      });
    },
    editFunnel() {
      const funnelToEdit = this.funnel;

      // If the funnel belongs to a goal, edit it using the goal edit form
      if (funnelToEdit.idgoal && funnelToEdit.idgoal !== '0') {
        MatomoUrl.updateHash({
          ...MatomoUrl.hashParsed.value,
          category: 'Goals_Goals',
          subcategory: 'Goals_ManageGoals',
          idGoal: funnelToEdit.idgoal,
          scrollToFunnel: 1,
        });
        return;
      }

      // If the funnel is a sales funnel, redirect to the Ecommerce section to edit
      if (funnelToEdit.isSalesFunnel) {
        MatomoUrl.updateHash({
          ...MatomoUrl.hashParsed.value,
          category: 'Goals_Ecommerce',
          subcategory: 'General_Overview',
          isFunnelEdit: true,
          scrollToFunnel: 1,
        });
        return;
      }

      MatomoUrl.updateHash({
        ...MatomoUrl.hashParsed.value,
        category: 'Funnels_Funnels',
        subcategory: 'Funnels_ManageFunnels',
        idFunnel: funnelToEdit.idfunnel,
      });
    },
  },
});
</script>
