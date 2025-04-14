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
  <div
    class="simplePeriodSelector periodSelector piwikSelector borderedControl"
    v-expand-on-click="{ expander: 'title' }"
    ref="root"
  >
    <a
      ref="title"
      id="date"
      class="title"
      tabindex="-1"
      :title="translate('General_ChooseDate', currentlyViewingText)"
    >
      <span class="icon icon-calendar" />
      {{ currentlyViewingText }}
    </a>
    <div class="dropdown">
      <div style="display:flex">
        <div
          class="period-date"
          v-if="selectedPeriod !== 'range'"
        >
          <PeriodDatePicker
            id="datepicker"
            :period="selectedPeriod"
            :date="this.modelValue?.period === selectedPeriod ? dateValue : null"
            @select="setPiwikPeriodAndDate(selectedPeriod, $event.date)"
          >
          </PeriodDatePicker>
        </div>
        <div class="period-type">
          <h6>{{ translate('General_Period') }}</h6>
          <div id="otherPeriods">
            <p
              v-for="period in periods"
              :key="period"
            >
              <label
                :class="{ 'selected-period-label': period === selectedPeriod }"
                @dblclick="changeViewedPeriod(period)"
                :title="period === this.modelValue?.period
                      ? ''
                      : translate('General_DoubleClickToChangePeriod')"
              >
                <input
                  type="radio"
                  name="period"
                  :id="`period_id_${ period }`"
                  v-model="selectedPeriod"
                  :checked="selectedPeriod === period"
                  @change="selectedPeriod = period"
                  @dblclick="changeViewedPeriod(period)"
                />
                <span>{{ getPeriodDisplayText(period) }}</span>
              </label>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import {
  PeriodDatePicker,
  parseDate,
  Periods,
  format,
  ExpandOnClick,
  translate,
} from 'CoreHome';

interface SimplePeriodSelectorState {
  selectedPeriod: string;
}

export default defineComponent({
  props: {
    modelValue: Object,
  },
  components: {
    PeriodDatePicker,
  },
  directives: {
    ExpandOnClick,
  },
  emits: ['update:modelValue'],
  data(): SimplePeriodSelectorState {
    return {
      selectedPeriod: this.modelValue?.period as string,
    };
  },
  computed: {
    periods() {
      return ['day', 'week', 'month', 'year'];
    },
    dateValue() {
      if (!this.modelValue) {
        return null;
      }

      return parseDate(this.modelValue.date);
    },
    currentlyViewingText() {
      if (!this.modelValue?.period || !this.dateValue) {
        return translate('General_Error');
      }

      const date = format(this.dateValue);

      try {
        return Periods.parse(this.modelValue.period, date).getPrettyString();
      } catch (e) {
        return translate('General_Error');
      }
    },
  },
  methods: {
    getPeriodDisplayText(periodLabel: string) {
      return Periods.get(periodLabel).getDisplayText();
    },
    changeViewedPeriod(period: string) {
      this.$emit('update:modelValue', { ...this.modelValue, period });
      this.closePeriodSelector();
    },
    setPiwikPeriodAndDate(period: string, date: Date) {
      this.$emit('update:modelValue', { period, date: format(date) });
      this.closePeriodSelector();
    },
    closePeriodSelector() {
      (this.$refs.root as HTMLElement).classList.remove('expanded');
    },
  },
});
</script>
