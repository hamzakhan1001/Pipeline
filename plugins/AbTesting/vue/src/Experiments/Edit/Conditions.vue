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
    <div name="mde_relative">
      <Field
        uicontrol="select"
        name="mde_relative"
        :model-value="experiment?.mde_relative"
        @update:model-value="$emit('updateProperty', { prop: 'mde_relative', value: $event })"
        :title="translate('AbTesting_MinimumDetectableEffectMDE')"
        :options="mdeRelativeOptions"
      >
        <template #inline-help>
          <div class="inline-help-node">
            {{ translate('AbTesting_FieldMinimumDetectableEffectHelp1') }}
            <br /><br />
            {{ translate('AbTesting_FieldMinimumDetectableEffectHelp2') }}
          </div>
        </template>
      </Field>
    </div>
    <div name="confidence_threshold">
      <Field
        uicontrol="select"
        name="confidence_threshold"
        :model-value="experiment?.confidence_threshold"
        @update:model-value="$emit('updateProperty', {
          prop: 'confidence_threshold',
          value: $event,
        })"
        :title="translate('AbTesting_ConfidenceThreshold')"
        :options="confidenceThresholdOptions"
        :inline-help="translate('AbTesting_FieldConfidenceThresholdHelp')"
      >
      </Field>
    </div>
    <div class="alert alert-info">
      {{ translate('AbTesting_FieldSuccessConditionsHelp') }}
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Field } from 'CorePluginsAdmin';

export default defineComponent({
  props: {
    experiment: Object,
    mdeRelativeOptions: {
      type: Object,
      required: true,
    },
    confidenceThresholdOptions: {
      type: Object,
      required: true,
    },
  },
  emits: ['updateProperty'],
  components: {
    Field,
  },
});
</script>
