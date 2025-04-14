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
  <div ref="root">
    <div class="form-group">
      {{ translate('AbTesting_FormScheduleIntroduction') }}
    </div>
    <div class="form-group row scheduleExperiment">
      <div class="col s12 m6">
        <div class="row">
          <div class="col s12">
            <label
              for="start_date_date"
              class="active"
            >{{ translate('AbTesting_FieldScheduleExperimentStartLabel') }}:</label>
          </div>
          <div class="col s12 m6 input-field">
            <input
              type="text"
              name="start_date_date"
              class="experimentStartDateInput"
              :value="startDateDate"
              @change="onKeydown('startDateDate', $event)"
              @keydown="onKeydown('startDateDate', $event)"
              :disabled="experiment?.status !== 'created'"
            />
          </div>
          <div class="col s12 m6 input-field">
            <input
              type="text"
              class="experimentStartTimeInput"
              :value="startDateTime"
              @change="onKeydown('startDateTime', $event)"
              @keydown="onKeydown('startDateTime', $event)"
              :disabled="experiment?.status !== 'created' || !startDateDate"
            />
          </div>
          <div class="col s12">
            <p v-show="toLocalTime(experiment?.start_date, true)">
              {{ translate('AbTesting_EqualsDateInYourTimezone') }}
              <br />
              {{ toLocalTime(experiment?.start_date, true) }}
            </p>
          </div>
        </div>
      </div>
      <div class="col s12 m6 ">
        <div class="form-help">
          <span class="inline-help">
            <span>
              <span v-html="$sanitize(experimentStartHelp)"/>
              <br />
              {{ translate('AbTesting_CurrentTimeInUTC') }}
              <strong
                class="currentDate"
                v-show="utcTime"
              >{{ utcTime }}</strong>.
            </span>
          </span>
        </div>
      </div>
    </div>
    <div class="form-group row scheduleExperiment">
      <div class="col s12 m6">
        <div class="row">
          <div class="col s12">
            <label
              for="start_date_date"
              class="active"
            >{{ translate('AbTesting_FieldScheduleExperimentFinishLabel') }}:</label>
          </div>
          <div class="col s12 m6 input-field">
            <input
              type="text"
              class="experimentEndDateInput"
              :value="endDateDate"
              @change="onKeydown('endDateDate', $event)"
              @keydown="onKeydown('endDateDate', $event)"
            />
          </div>
          <div class="col s12 m6 input-field">
            <input
              type="text"
              class="experimentEndTimeInput"
              :value="endDateTime"
              @change="onKeydown('endDateTime', $event)"
              @keydown="onKeydown('endDateTime', $event)"
              :disabled="!endDateDate"
            />
          </div>
          <div class="col s12">
            <p v-show="toLocalTime(experiment?.end_date, true)">
              {{ translate('AbTesting_EqualsDateInYourTimezone') }}
              <br />
              {{ toLocalTime(experiment?.end_date, true) }}
            </p>
          </div>
        </div>
      </div>
      <div class="col s12 m6">
        <div class="form-help">
          <span class="inline-help">
            <span>
              <span v-html="$sanitize(experimentFinishHelp)"/>
              <br />
              {{ translate('AbTesting_CurrentTimeInUTC') }}
              <strong
                class="currentDate"
                v-show="utcTime"
              >{{ utcTime }}</strong>.
            </span>
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
/* eslint-disable @typescript-eslint/ban-ts-comment */

import { defineComponent, watch } from 'vue';
import { translate, Matomo } from 'CoreHome';
import toLocalTime from '../../toLocalTime';
import { Experiment } from '../../types';
import ChangeEvent = JQuery.ChangeEvent;

interface ScheduleState {
  startDateDate: string|null;
  startDateTime: string|null;
  endDateDate: string|null;
  endDateTime: string|null;
}

const { $ } = window;

export default defineComponent({
  props: {
    experiment: Object,
    utcTime: [Date, String],
  },
  emits: ['updateProperty'],
  data(): ScheduleState {
    return {
      startDateDate: null,
      startDateTime: null,
      endDateDate: null,
      endDateTime: null,
    };
  },
  created() {
    this.setDateState();

    watch(() => this.experiment?.start_date, () => {
      this.setDateState();
    });

    watch(() => this.experiment?.end_date, () => {
      this.setDateState();
    });

    // add watches after initial setDateState() above
    watch(() => this.startDateDate, () => {
      this.onStartDateChange();
    });
    watch(() => this.startDateTime, () => {
      this.onStartDateChange();
    });

    watch(() => this.endDateDate, () => {
      this.onEndDateChange();
    });
    watch(() => this.endDateTime, () => {
      this.onEndDateChange();
    });
  },
  mounted() {
    const options1 = Matomo.getBaseDatePickerOptions(null);
    delete options1.maxDate;
    options1.minDate = new Date();

    const options2 = Matomo.getBaseDatePickerOptions(null);
    delete options2.maxDate;

    setTimeout(() => {
      $('.experimentStartDateInput', this.$refs.root as HTMLElement).datepicker(options1);
      $('.experimentEndDateInput', this.$refs.root as HTMLElement).datepicker(options2);

      // @ts-ignore
      $('.experimentStartTimeInput', this.$refs.root as HTMLElement)
        .timepicker({
          timeFormat: 'H:i:s',
        })
        // timepicker triggers a jquery event, not a addEventListener event, so vue doesn't catch
        // it
        .on('change', (event) => {
          this.onKeydown('startDateTime', event);
        });

      // @ts-ignore
      $('.experimentEndTimeInput', this.$refs.root as HTMLElement)
        .timepicker({
          timeFormat: 'H:i:s',
        })
        // timepicker triggers a jquery event, not a addEventListener event, so vue doesn't catch
        // it
        .on('change', (event) => {
          this.onKeydown('endDateTime', event);
        });
    });
  },
  methods: {
    toLocalTime,
    setDateState() {
      const experiment = this.experiment as Experiment;
      if (experiment?.start_date) {
        [this.startDateDate, this.startDateTime] = experiment.start_date.split(' ');

        $('.experimentStartDateInput', this.$refs.root as HTMLElement).datepicker(
          'setDate',
          this.startDateDate,
        );
      }
      if (experiment?.end_date) {
        [this.endDateDate, this.endDateTime] = experiment.end_date.split(' ');

        $('.experimentEndDateInput', this.$refs.root as HTMLElement).datepicker(
          'setDate',
          this.endDateDate,
        );
      }
    },
    onStartDateChange() {
      const experiment = this.experiment as Experiment;

      let startDate: string|null = null;
      if (this.startDateDate) {
        const startDateTime = this.startDateTime || '00:00:00';
        startDate = `${this.startDateDate} ${startDateTime}`;
      }

      if (experiment.start_date !== startDate) {
        this.$emit('updateProperty', { prop: 'start_date', value: startDate });
      }
    },
    onEndDateChange() {
      const experiment = this.experiment as Experiment;

      let endDate: string|null = null;
      if (this.endDateDate) {
        const endDateTime = this.endDateTime || '23:59:59';
        endDate = `${this.endDateDate} ${endDateTime}`;
      }

      if (experiment.end_date !== endDate) {
        this.$emit('updateProperty', { prop: 'end_date', value: endDate });
      }
    },
    onKeydown(propName: keyof ScheduleState, event: Event|ChangeEvent) {
      setTimeout(() => {
        this[propName] = (event.target as HTMLInputElement).value;
      });
    },
  },
  computed: {
    experimentStartHelp() {
      return translate('AbTesting_FieldScheduleExperimentStartHelp', '<strong>', '</strong>');
    },
    experimentFinishHelp() {
      return translate('AbTesting_FieldScheduleExperimentFinishHelp', '<strong>', '</strong>');
    },
  },
});
</script>
