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
  <div>
    <div class="form-group row">
      <div class="col s12 m6">
        <div>
          <label for="variations">{{ translate('AbTesting_FieldSuccessMetricsLabel') }}</label>
          <div
            v-for="(metric, index) in (modelValue || [])"
            :class="`successMetric successMetric${index} multiple valign-wrapper`"
            :key="index"
          >
            <div class="innerFormField" name="metric">
              <Field
                uicontrol="select"
                name="metric"
                :model-value="metric.metric"
                @update:model-value="setValue(index, $event)"
                :full-width="true"
                :options="successMetricOptions"
              >
              </Field>
            </div>
            <span
              class="icon-plus valign"
              :title="translate('General_Add')"
              @click="$emit('update:modelValue', [...(this.modelValue || []), { metric: '' }])"
            />
            <span
              class="icon-minus valign"
              :title="translate('General_Remove')"
              v-show="index > 0"
              @click="removeSuccessMetric(index)"
            />
          </div>
        </div>
      </div>
      <div class="col s12 m6">
        <div class="form-help">
          <span class="inline-help">
            {{ translate('AbTesting_FieldSuccessMetricsHelp1') }}
            <br />
            {{ translate('AbTesting_FieldSuccessMetricsHelp2') }}
            <br />
            {{ translate('AbTesting_FieldSuccessMetricsHelp3') }}
            <br /><br />
            <a
              target="_blank"
              :href="goalManageUrl"
            >{{ translate('AbTesting_ClickToCreateNewGoal') }}</a>
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Field } from 'CorePluginsAdmin';

export default defineComponent({
  props: {
    modelValue: Array,
    experimentIdSite: {
      type: [Number, String],
      required: true,
    },
    successMetricOptions: {
      type: Object,
      required: true,
    },
  },
  components: {
    Field,
  },
  emits: ['update:modelValue'],
  computed: {
    goalManageUrl() {
      const idSite = this.experimentIdSite;
      return `?module=Goals&action=manage&idSite=${idSite}&period=day&date=yesterday`;
    },
  },
  methods: {
    setValue(index: number, newMetric: string) {
      const newValue = [...(this.modelValue || [])];
      newValue[index] = { metric: newMetric };
      this.$emit('update:modelValue', newValue);
    },
    removeSuccessMetric(index: number) {
      const newValue = [...(this.modelValue || [])];
      newValue.splice(index, 1);
      this.$emit('update:modelValue', newValue);
    },
  },
});
</script>
