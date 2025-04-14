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
  <div class="manageMultiAttribution">
    <div name="isEnabled">
      <Field
        uicontrol="checkbox"
        name="isEnabled"
        :title="translate('MultiChannelConversionAttribution_Enabled')"
        v-model="isEnabled"
        :introduction="translate(
          'MultiChannelConversionAttribution_MultiChannelConversionAttribution')"
        :inline-help="translate('MultiChannelConversionAttribution_Introduction')"
      >
      </Field>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Matomo, AjaxHelper, AjaxOptions } from 'CoreHome';
import { ManageGoalsStore } from 'Goals';
import { Field } from 'CorePluginsAdmin';

interface ManageMultiattributionState {
  isLoading: boolean;
  isEnabled: boolean|null;
}

export default defineComponent({
  props: {
  },
  components: {
    Field,
  },
  data(): ManageMultiattributionState {
    return {
      isLoading: false,
      isEnabled: null,
    };
  },
  created() {
    const idGoal = ManageGoalsStore.idGoal.value;
    if (typeof idGoal === 'number') {
      this.initGoalForm('Goals.updateGoal', idGoal);
    }

    this.isLoading = false;

    this.reset();

    Matomo.on('Goals.cancelForm', () => this.resetForm());

    Matomo.on('Goals.beforeInitGoalForm', this.initGoalForm.bind(this));

    Matomo.on('Goals.beforeAddGoal', this.onSetAttribution.bind(this));
    Matomo.on('Goals.beforeUpdateGoal', this.onSetAttribution.bind(this));
  },
  methods: {
    reset() {
      this.isEnabled = true;
    },
    resetForm() {
      this.reset();
      this.isLoading = false;
    },
    getGoalAttribution: AjaxHelper.oneAtATime<{ isEnabled: string|number|boolean }>(
      'MultiChannelConversionAttribution.getGoalAttribution',
    ),
    initGoalForm(goalMethodAPI: string, goalId: string|number) {
      this.resetForm();

      if (!goalId || goalMethodAPI === 'Goals.addGoal') {
        return;
      }

      this.isLoading = true;
      this.getGoalAttribution({ idGoal: goalId }).then((response) => {
        this.isEnabled = !!response.isEnabled && response.isEnabled !== '0';
      }).finally(() => {
        this.isLoading = false;
      });
    },
    onSetAttribution({ options }: { options: AjaxOptions }) {
      if (this.isEnabled === null) {
        return; // not loaded yet
      }

      options.postParams = {
        ...options.postParams,
        multiAttributionEnabled: this.isEnabled ? 1 : 0,
      };
    },
  },
});
</script>
