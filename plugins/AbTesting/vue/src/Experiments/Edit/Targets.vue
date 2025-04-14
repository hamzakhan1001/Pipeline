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
    <div class="row">
      <div class="col s12">
        <TargetTest
          :included-targets="experiment?.included_targets"
          :excluded-targets="experiment?.excluded_targets"
        />
      </div>
    </div>
    <div class="form-group row">
      <div class="col s12">
        <h3>{{ translate('AbTesting_FieldIncludedTargetsLabel') }}:</h3>
      </div>
      <div
        class="col s12 m6"
        style="padding-left: 0;"
      >
        <div
          v-for="(url, index) in experiment?.included_targets || []"
          :key="index"
          :class="`includedTargets ${index} multiple`"
        >
          <ExperimentUrlTarget
            :model-value="url"
            @update:model-value="setTarget('included_targets', index, $event)"
            @add-url="addTarget('included_targets')"
            @remove-url="removeTarget('included_targets', index)"
            :allow-any="true"
            :disable-if-no-value="index > 0"
            :can-be-removed="index > 0"
            :show-add-url="true"
          />
          <hr />
        </div>
      </div>
      <div class="col s12 m6">
        <div class="form-help">
          <span class="inline-help">
            {{ translate('AbTesting_FieldIncludedTargetsHelp2') }}
          </span>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <div class="col s12">
        <h3>{{ translate('AbTesting_FieldExcludedTargetsLabel') }}:</h3>
      </div>
      <div
        class="col s12 m6"
        style="padding-left: 0;"
      >
        <div
          :class="`excludedTargets ${index} multiple`"
          v-for="(url, index) in experiment?.excluded_targets"
          :key="index"
        >
          <ExperimentUrlTarget
            :disable-if-no-value="true"
            :allow-any="false"
            :model-value="url"
            @update:model-value="setTarget('excluded_targets', index, $event)"
            @add-url="addTarget('excluded_targets')"
            @remove-url="removeTarget('excluded_targets', index)"
            :can-be-removed="index > 0"
            :show-add-url="true"
          />
          <hr />
        </div>
      </div>
      <div class="col s12 m6">
        <div class="form-help">
          <span class="inline-help">
            {{ translate('AbTesting_FieldExcludedTargetsHelp') }}
          </span>
        </div>
      </div>
    </div>
    <div class="alert alert-info">
      <strong>{{ translate('AbTesting_TargetComparisons') }}</strong>
      <ul>
        <li><strong>{{ translate('AbTesting_TargetTypeEqualsSimple') }}</strong>
          {{ translate('AbTesting_TargetTypeEqualsSimpleInfo') }} </li>
        <li><strong>{{ translate('AbTesting_TargetTypeEqualsExactly') }}</strong>
          {{ translate('AbTesting_TargetTypeEqualsExactlyInfo') }} </li>
        <li><strong>{{ translate('AbTesting_TargetTypeRegExp') }}</strong>
          {{ translate('AbTesting_TargetTypeRegExpInfo') }} </li>
      </ul>
      <br />
      {{ translate('AbTesting_TargetComparisionsCaseInsensitive') }}<br />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import TargetTest from '../../TargetTest/TargetTest.vue';
import ExperimentUrlTarget from '../../ExperimentUrlTarget/ExperimentUrlTarget.vue';
import { Experiment, ExperimentTarget } from '../../types';

export default defineComponent({
  props: {
    experiment: Object,
  },
  components: {
    TargetTest,
    ExperimentUrlTarget,
  },
  emits: ['updateProperty'],
  methods: {
    addTarget(propName: keyof Experiment) {
      const experiment = this.experiment as Experiment;

      if (!(propName === 'excluded_targets' || propName === 'included_targets')) {
        return;
      }

      this.$emit('updateProperty', {
        prop: propName,
        value: [
          ...(experiment?.[propName] || []),
          {
            attribute: 'url',
            type: 'equals_simple',
            value: '',
            inverted: 0,
          },
        ],
      });
    },
    setTarget(propName: keyof Experiment, index: number, newValue: ExperimentTarget) {
      const experiment = this.experiment as Experiment;

      if (!(propName === 'excluded_targets' || propName === 'included_targets')) {
        return;
      }

      const newTargets = [...(experiment?.[propName] || [])];
      newTargets[index] = newValue;

      this.$emit('updateProperty', {
        prop: propName,
        value: newTargets,
      });
    },
    removeTarget(propName: keyof Experiment, index: number) {
      const experiment = this.experiment as Experiment;

      if (!(propName === 'excluded_targets' || propName === 'included_targets')) {
        return;
      }

      const newTargets = [...(experiment?.[propName] || [])];
      newTargets.splice(index, 1);

      this.$emit('updateProperty', {
        prop: propName,
        value: newTargets,
      });
    },
  },
});
</script>
