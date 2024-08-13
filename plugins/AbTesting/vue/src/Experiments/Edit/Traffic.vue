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
    <div name="percentage_participants">
      <Field
        uicontrol="select"
        name="percentage_participants"
        :model-value="experiment?.percentage_participants"
        @update:model-value="$emit('updateProperty', {
          prop: 'percentage_participants',
          value: $event,
        })"
        :title="`${translate('AbTesting_FieldPercentageParticipantsLabel')}:`"
        :options="percentageParticipantsOptions"
        :inline-help="translate('AbTesting_FieldPercentageParticipantsHelp')"
      >
      </Field>
    </div>
    <br />
    <div class="form-group row">
      <h3 class="col s12">{{ translate('AbTesting_FieldPercentageVariationsLabel') }}:</h3>
    </div>
    <div
      class="alert alert-danger"
      v-show="!hasAllocated100PercentToVariations"
    >
      {{ translate('AbTesting_ErrorVariationAllocatedNot100Traffic') }}
    </div>
    <div
      class="alert alert-warning"
      v-show="shouldAllocateMoreTrafficToOriginalVariation && hasAllocated100PercentToVariations"
    >
      {{ translate('AbTesting_ErrorVariationAllocatedNotEnoughOriginal') }}
    </div>
    <div
      class="form-group row"
      style="margin-top: 0;"
    >
      <div
        class="col s12 m6"
        style="padding-left: 0;"
      >
        <div class="valign-wrapper">
          <div
            style="display: inline-block;width: calc(100% - 60px);"
            class="control_text percentage"
            name="percentage"
          >
            <Field
              uicontrol="text"
              name="percentage"
              :title="translate('AbTesting_NameOriginalVariation')"
              :disabled="true"
              :full-width="true"
              :placeholder="`${defaultVariationPercentage}`"
            >
            </Field>
          </div>
          <span>%</span>
        </div>
        <div
          :class="`valign-wrapper trafficVariation ${index}`"
          v-for="(exper, index) in (experiment?.variations || [])"
          :key="exper.idvariation"
        >
          <div
            style="display: inline-block;width: calc(100% - 60px);"
            class="percentage"
            name="percentage"
          >
            <Field
              uicontrol="text"
              name="percentage"
              :model-value="exper.percentage"
              @update:model-value="changePercent(index, $event)"
              :title="`${translate('AbTesting_Variation')} &quot;${exper.name}&quot;`"
              :maxlength="3"
              :full-width="true"
              :placeholder="`${defaultVariationPercentage}`"
            >
            </Field>
          </div>
          <span>%</span>
        </div>
      </div>
      <div class="col s12 m6">
        <div class="form-help">
          <span class="inline-help">
            {{ translate('AbTesting_FieldPercentageVariationsHelp') }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Field } from 'CorePluginsAdmin';
import { Experiment } from '../../types';

export default defineComponent({
  props: {
    experiment: Object,
    percentageParticipantsOptions: {
      type: Object,
      required: true,
    },
  },
  components: {
    Field,
  },
  emits: ['updateProperty'],
  methods: {
    changePercent(index: number, percent: string) {
      const exp = this.experiment as Experiment|undefined;
      const variations = (exp?.variations || []);

      const newVariations = [...variations];
      newVariations[index] = { ...newVariations[index], percentage: percent };

      this.$emit('updateProperty', {
        prop: 'variations',
        value: newVariations,
      });
    },
  },
  computed: {
    hasAllocated100PercentToVariations() {
      const experiment = this.experiment as Experiment;
      if (!experiment?.variations) {
        return false;
      }

      const percentage = (experiment?.variations || []).reduce((pv, cv) => {
        if (cv?.percentage) {
          return pv + parseInt(`${cv.percentage}`, 10);
        }
        return pv;
      }, 0);

      return percentage < 100;
    },
    numVariations() {
      const experiment = this.experiment as Experiment;
      return experiment.variations?.length || 0;
    },
    defaultVariationPercentage() {
      const experiment = this.experiment as Experiment;
      if (!experiment || !experiment.variations) {
        return 0;
      }

      let percentageUsed = 100;
      const numberOfOriginalVariations = 1;
      let numVariations = this.numVariations + numberOfOriginalVariations;

      experiment.variations.forEach((variation) => {
        if (variation && variation.percentage) {
          percentageUsed -= parseInt(`${variation.percentage}`, 10);
          numVariations -= 1;
        }
      });

      if (numVariations > 0) {
        let result = Math.round(percentageUsed / numVariations);

        if (result > 100) {
          result = 100;
        }

        if (result < 0) {
          result = 0;
        }

        return result;
      }

      return 0;
    },
    shouldAllocateMoreTrafficToOriginalVariation() {
      // eg 20% when there are 4 variations + 1 original by default
      const original = this.defaultVariationPercentage;

      const numVariations = this.numVariations + 1;

      // eg 20% when there are 4 variations + 1 original by default
      const defaultPercentageWhenNotCustomizedTraffic = Math.round(100 / numVariations);

      // eg 10%
      const halfNeededTraffic = Math.floor(defaultPercentageWhenNotCustomizedTraffic / 2);

      // has allocated eg less than 10% to original, we recommend to allocate more
      return halfNeededTraffic > original;
    },
  },
});
</script>
