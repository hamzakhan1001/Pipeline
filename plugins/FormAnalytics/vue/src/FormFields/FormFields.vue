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
  <div class="knownFormFields">
    <table v-content-table>
      <thead>
        <tr>
          <th>{{ translate('FormAnalytics_FieldName') }}</th>
          <th>{{ translate('FormAnalytics_FieldType') }}</th>
          <th>{{ translate('FormAnalytics_DisplayName') }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(field, index) in limitedFields" :key="index">
          <td>{{ field.name }}</td>
          <td>{{ field.type }}</td>
          <td :class="{fieldDisplayNameInput: canEditForm}">
            <div v-if="canEditForm">
              <Field
                uicontrol="text"
                v-model="names[field.name]"
                :maxlength="50"
                :full-width="true"
              />
            </div>
            <span
              v-else
              :title="translate('FormAnalytics_DisplayNameRequiresAdminAccess')"
            >
              {{ field.displayName || '-' }}
            </span>
          </td>
        </tr>
        <tr v-if="form.fields.length > 200">
          <td colspan="3">{{ translate('FormAnalytics_FormFieldEditLimited', 200) }}</td>
        </tr>
        <tr v-if="canEditForm">
          <td colspan="3">
            <SaveButton
              @confirm="renameFields(form.idsiteform)"
              :saving="isLoading"
            />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import {
  AjaxHelper,
  Matomo,
  ContentTable,
} from 'CoreHome';
import { Field, SaveButton } from 'CorePluginsAdmin';
import { Form } from '../types';

interface FormFieldsState {
  isLoading: boolean;
  names: Record<string, string>;
}

export default defineComponent({
  props: {
    form: {
      type: Object,
      required: true,
    },
    canEditForm: Boolean,
  },
  components: {
    Field,
    SaveButton,
  },
  directives: {
    ContentTable,
  },
  data(): FormFieldsState {
    return {
      isLoading: false,
      names: {},
    };
  },
  created() {
    // default field name to the field's displayName if one exists
    this.limitedFields.forEach((field) => {
      this.names[field.name] = field.displayName;
    });
  },
  methods: {
    renameFields(idForm: number) {
      this.isLoading = true;
      AjaxHelper.post(
        {
          module: 'API',
          method: 'FormAnalytics.updateFormFieldDisplayName',
        },
        {
          fields: Object.entries(this.names).map(([name, displayName]) => ({
            name,
            displayName,
          })),
          idForm,
        },
      ).then(() => {
        Matomo.helper.redirect();
      }).catch(() => {
        this.isLoading = false;
      });
    },
  },
  computed: {
    limitedFields() {
      return (this.form as Form).fields.slice(0, 200);
    },
  },
});
</script>
