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
  <div v-content-intro>
    <h2>{{ translate('AbTesting_MenuTitleExperiment', experiment.name) }}</h2>

    <Summary
      :is-admin="isAdmin"
      :experiment="experiment"
      :start-date-site-timezone-pretty="startDateTimezone"
      :end-date-site-timezone-pretty="endDateTimezone"
    />

    <div class="ui-confirm" id="confirmArchiveExperiment">
      <h2>{{ translate('AbTesting_ArchiveReportConfirm') }}</h2>
      <input role="yes" type="button" :value="translate('General_Yes')"/>
      <input role="no" type="button" :value="translate('General_No')"/>
    </div>

    <div class="ui-confirm" id="confirmFinishExperiment">
      <h2>{{ translate('AbTesting_ConfirmFinishExperiment') }}</h2>
      <input role="yes" type="button" :value="translate('General_Yes')"/>
      <input role="no" type="button" :value="translate('General_No')"/>
    </div>

    <div id="abtestPeriod" class="piwikTopControl piwikSelector borderedControl periodSelector">
        <span id="date" class="title" :title="translate('AbTesting_ReportDateCannotBeChanged')">
            <span class="icon icon-calendar"></span>
            {{ readablePeriod }}
        </span>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { ContentIntro } from 'CoreHome';
import Summary from './Summary.vue';
import initAbTest from '../initAbTest';

export default defineComponent({
  props: {
    experiment: {
      type: Object,
      required: true,
    },
    isAdmin: Boolean,
    startDateTimezone: String,
    endDateTimezone: String,
    readablePeriod: {
      type: String,
      required: true,
    },
  },
  directives: {
    ContentIntro,
  },
  components: {
    Summary,
  },
  created() {
    initAbTest();
  },
});
</script>
