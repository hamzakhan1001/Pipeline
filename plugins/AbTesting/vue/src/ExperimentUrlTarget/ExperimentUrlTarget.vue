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
    class="form-group urltarget valign-wrapper"
    :class="{'disabled': disableIfNoValue && !modelValue.value}"
  >
    <div style="width:100%">
      <div name="targetAttribute">
        <Field
          uicontrol="select"
          name="targetAttribute"
          :model-value="modelValue.attribute"
          @update:model-value="$emit('update:modelValue', { ...modelValue, attribute: $event })"
          :title="translate('AbTesting_Rule')"
          :options="targetAttributes"
          :full-width="true"
        >
        </Field>
      </div>
      <div name="targetType">
        <Field
          uicontrol="select"
          name="targetType"
          :model-value="pattern_type"
          @update:model-value="onTypeChange($event);"
          :options="targetOptions[modelValue.attribute]"
          :full-width="true"
        >
        </Field>
      </div>
      <div name="targetValue">
        <Field
          uicontrol="text"
          name="targetValue"
          :placeholder="`eg. ${targetExamples[modelValue.attribute]}`"
          :model-value="modelValue.value"
          @update:model-value="$emit('update:modelValue', { ...modelValue, value: $event.trim() })"
          v-show="pattern_type !== 'any'"
          :full-width="true"
        >
        </Field>
      </div>
      <div name="targetValue2">
        <Field
          uicontrol="text"
          name="targetValue2"
          :model-value="modelValue.value2"
          @update:model-value="$emit('update:modelValue', { ...modelValue, value2: $event.trim() })"
          v-show="modelValue.attribute === 'urlparam' && pattern_type && pattern_type !== 'exists'
            && pattern_type !== 'not_exists'"
          :full-width="true"
          :placeholder="translate('AbTesting_UrlParameterValueToMatchPlaceholder')"
        >
        </Field>
      </div>
    </div>
    <span
      class="icon-plus valign"
      :title="translate('General_Add')"
      v-show="showAddUrl"
      @click="$emit('addUrl')"
    />
    <span
      class="icon-minus valign"
      :title="translate('General_Remove')"
      v-show="canBeRemoved"
      @click="$emit('removeUrl')"
    />
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { translate } from 'CoreHome';
import { Field } from 'CorePluginsAdmin';
import AvailableTargetAttributesStore from '../AvailableTargetAttributes.store';

interface Option {
  key: string;
  value: string;
}

export default defineComponent({
  props: {
    modelValue: {
      type: Object,
      required: true,
    },
    canBeRemoved: Boolean,
    disableIfNoValue: Boolean,
    allowAny: Boolean,
    showAddUrl: Boolean,
  },
  components: {
    Field,
  },
  created() {
    AvailableTargetAttributesStore.init();
  },
  emits: ['addUrl', 'removeUrl', 'update:modelValue'],
  watch: {
    modelValue(newValue) {
      if (!newValue.attribute) {
        return;
      }

      const types = this.targetOptions[newValue.attribute];
      const found = types.find((t) => t.key === this.pattern_type);

      if (!found && types[0]) {
        this.onTypeChange(types[0].key);
      }
    },
  },
  methods: {
    onTypeChange(newType: string) {
      let inverted = 0;

      let type = newType;
      if (newType.indexOf('not_') === 0) {
        type = newType.substring('not_'.length);
        inverted = 1;
      }

      this.$emit('update:modelValue', {
        ...this.modelValue,
        type,
        inverted,
      });
    },
  },
  computed: {
    pattern_type() {
      let result: string = this.modelValue.type;

      if (this.modelValue.inverted && this.modelValue.inverted !== '0') {
        result = `not_${this.modelValue.type}`;
      }

      return result;
    },
    targetAttributes() {
      return AvailableTargetAttributesStore.attributes.value.map((attr) => ({
        key: attr.value,
        value: attr.name,
      }));
    },
    targetOptions() {
      const result: Record<string, Option[]> = {};
      AvailableTargetAttributesStore.attributes.value.forEach((attr) => {
        result[attr.value] = [];

        if (this.allowAny && attr.value === 'url') {
          result[attr.value].push({
            value: translate('AbTesting_TargetTypeIsAny'),
            key: 'any',
          });
        }

        attr.types.forEach((type) => {
          result[attr.value].push({
            value: type.name,
            key: type.value,
          });

          result[attr.value].push({
            value: translate('AbTesting_TargetTypeIsNot', type.name),
            key: `not_${type.value}`,
          });
        });
      });
      return result;
    },
    targetExamples() {
      const result: Record<string, string> = {};
      AvailableTargetAttributesStore.attributes.value.forEach((attr) => {
        result[attr.value] = attr.example;
      });
      return result;
    },
  },
});
</script>
