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
  <div class="form-group row expVariationsEdit">
    <div class="col s12 m6">
      <div>
        <label for="variations">{{ translate('AbTesting_Variations') }}</label>
        <div class="variation original">
          <input
            type="text"
            class="name disabled"
            disabled
            :value="translate('AbTesting_NameOriginalVariation')"
          />
        </div>
        <div
          v-for="(exper, index) in (modelValue || [])"
          :key="exper.idvariation || this.tempIds.get(exper)"
          :class="`variation ${index} multiple`"
        >
          <input
            type="text"
            class="control_text name"
            maxlength="50"
            :value="exper.name"
            @keydown="onKeydownName($event, exper, index)"
            @change="onKeydownName($event, exper, index)"
            :title="exper.idvariation ? `Variation ID ${exper.idvariation}` : ''"
          />
          <span
            class="icon-plus"
            :title="translate('General_Add')"
            @click="addVariation()"
          />
          <span
            class="icon-minus"
            :title="translate('General_Remove')"
            v-show="modelValue?.length > 1"
            @click="removeVariation(index)"
          />
        </div>
      </div>
    </div>
    <div class="col s12 m6">
      <div class="form-help">
        <span class="inline-help">
          {{ translate('AbTesting_FieldVariationsHelp') }}
        </span>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { debounce } from 'CoreHome';
import { Variation } from '../../types';

function isVariationNameAlreadyUsed(variations: Variation[], newName: string) {
  return !!variations.find((v) => v.name === newName);
}

let tempIdCount = 0;

interface VariationsState {
  tempIds: Map<Variation, string>;
}

export default defineComponent({
  props: {
    modelValue: Array,
  },
  emits: ['update:modelValue'],
  data(): VariationsState {
    return {
      tempIds: new Map(),
    };
  },
  created() {
    // debounce because puppeteer types reeaally fast
    this.onKeydownName = debounce(this.onKeydownName.bind(this), 50);

    if (this.modelValue === null || this.modelValue === undefined) {
      this.$emit('update:modelValue', []);
    }
  },
  methods: {
    onKeydownName(event: Event, variation: Variation, index: number) {
      const newName = (event.target as HTMLInputElement).value;
      if (variation.name !== newName) {
        const newValue = [...(this.modelValue || [])];
        newValue[index] = { ...variation, name: newName };
        this.$emit('update:modelValue', newValue);
      }
    },
    addVariation() {
      let newName = `Variation${(this.modelValue || []).length + 1}`;
      while (
        isVariationNameAlreadyUsed((this.modelValue || []) as Variation[], newName)
        && newName.length < 110
      ) {
        newName += '_';
      }

      const newVariation: Variation = {
        name: newName,
        percentage: '',
      };

      // temporary idvariation to be used as vue :key
      tempIdCount += 1;
      this.tempIds.set(newVariation, `_${tempIdCount}`);

      this.$emit('update:modelValue', [
        ...(this.modelValue || []),
        newVariation,
      ]);
    },
    removeVariation(index: number) {
      const newValue = [...(this.modelValue || [])];
      newValue.splice(index, 1);
      this.$emit('update:modelValue', newValue);
    },
  },
});
</script>
