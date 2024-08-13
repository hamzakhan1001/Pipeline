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
    <div class="form-group">
      <div name="name">
        <Field
          uicontrol="text"
          name="name"
          placeholder="eg 'BuyNowButtonColor'"
          :model-value="experiment?.name"
          @update:model-value="$emit('updateProperty', { prop: 'name', value: $event })"
          :title="translate('General_Name')"
          :maxlength="50"
          :inline-help="translate('AbTesting_FieldExperimentNameHelp', 50)"
        >
        </Field>
      </div>
    </div>
    <div class="form-group">
      <div name="hypothesis">
        <Field
          uicontrol="textarea"
          name="hypothesis"
          :model-value="experiment?.hypothesis"
          @update:model-value="$emit('updateProperty', { prop: 'hypothesis', value: $event })"
          :title="translate('AbTesting_Hypothesis')"
          :maxlength="1000"
          :rows="3"
          :placeholder="translate('AbTesting_FieldHypothesisPlaceholder')"
        >
          <template v-slot:inline-help>
            <div class="inline-help-node">
              <span v-html="$sanitize(fieldHypothesisHelp)"/>
            </div>
          </template>
        </Field>
      </div>
    </div>
    <div class="form-group">
      <div name="description">
        <Field
          uicontrol="textarea"
          name="description"
          :model-value="experiment?.description"
          @update:model-value="$emit('updateProperty', { prop: 'description', value: $event })"
          :title="translate('General_Description')"
          :maxlength="1000"
          :rows="3"
          :placeholder="translate('AbTesting_FieldDescriptionPlaceholder')"
          :inline-help="translate('AbTesting_FieldDescriptionHelp')"
        >
        </Field>
      </div>
    </div>
    <Variations
      :model-value="experiment?.variations"
      @update:model-value="$emit('updateProperty', { prop: 'variations', value: $event })"
    />
    <div
      class="form-group row initalPageUrl"
      v-show="create"
    >
      <div class="col s12 m6">
        <div name="newTargetType">
          <Field
            uicontrol="select"
            name="newTargetType"
            :title="translate('AbTesting_TargetPages')"
            :model-value="experiment?.included_targets?.[0]?.type"
            @update:model-value="$emit('updateProperty', {
              prop: 'included_targets',
              value: [
                { ...(experiment?.included_targets?.[0] || {}), type: $event },
                ...(experiment?.included_targets || []).slice(1),
              ],
            })"
            :full-width="true"
            :options="createExperimentTargetTypes"
          >
          </Field>
        </div>
        <div name="experimentUrl">
          <Field
            uicontrol="text"
            name="experimentUrl"
            :placeholder="experimentUrlPlaceholder"
            v-if="experiment?.included_targets?.[0]?.type === 'equals_simple'"
            :model-value="experiment?.included_targets[0]?.value"
            @update:model-value="$emit('updateProperty', {
              prop: 'included_targets',
              value: [
                { ...(experiment?.included_targets?.[0] || {}), value: $event },
                ...(experiment?.included_targets || []).slice(1),
              ],
            })"
            :full-width="true"
            :maxlength="1000"
          >
          </Field>
        </div>
      </div>
      <div class="col s12 m6">
        <div class="form-help">
          <span class="inline-help">
            {{ translate('AbTesting_NewExperimentTargetPageHelp') }}
          </span>
        </div>
      </div>
    </div>
    <SaveButton
      class="createButton"
      v-if="create"
      @confirm="$emit('save')"
      :disabled="isUpdating"
      :saving="isUpdating"
      :value="translate('AbTesting_CreateNewExperiment')"
    >
    </SaveButton>
    <div
      class="entityCancel"
      v-if="create"
    >
      <span
        v-html="$sanitize(
          translate(
            'General_OrCancel',
            '<a class=&quot;cancelLink&quot;>', '</a>'))"
        @click="onCancel($event)"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { translate } from 'CoreHome';
import { Field, SaveButton } from 'CorePluginsAdmin';
import Variations from './Variations.vue';
import ExperimentsStore from '../Experiments.store';

export default defineComponent({
  props: {
    experiment: {
      type: Object,
      required: true,
    },
    create: Boolean,
    createExperimentTargetTypes: Array,
  },
  components: {
    Field,
    SaveButton,
    Variations,
  },
  emits: ['updateProperty', 'save', 'cancel'],
  methods: {
    onCancel(event: Event) {
      if (!(event.target as HTMLElement).classList.contains('cancelLink')) {
        return;
      }

      this.$emit('cancel');
    },
  },
  computed: {
    fieldHypothesisHelp() {
      return translate(
        'AbTesting_FieldHypothesisHelp',
        '<strong>',
        '</strong>',
        '<strong>',
        '</strong>',
        '<strong>',
        '</strong>',
      );
    },
    experimentUrlPlaceholder() {
      return `eg 'http://www.example.com/${translate('AbTesting_FilesystemDirectory')}'`;
    },
    isUpdating() {
      return ExperimentsStore.state.value.isUpdating;
    },
  },
});
</script>
