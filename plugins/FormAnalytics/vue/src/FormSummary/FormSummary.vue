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
  <div v-content-intro>
    <h2>{{ translate('FormAnalytics_FormX', `"${form.name}"`) }}</h2>

    <div class="formSummary">
      <p>
        <span v-if="form.description">
          <strong>{{ translate('General_Description') }}:</strong> {{ form.description }}
          <br />
        </span>

        <strong>{{ translate('FormAnalytics_DataIsCollectedWhen') }}:</strong>
        {{ this.matchRulesList(form.match_form_rules) }}
        <br v-if="form.match_form_rules?.length" />

        <span v-if="form.match_form_rules?.length && form.match_page_rules?.length">
          {{ translate('FormAnalytics_AndWhen') }}
        </span>

        {{ this.matchRulesList(form.match_page_rules) }}
        <br v-if="form.match_page_rules?.length" />

        <strong>{{ translate('FormAnalytics_FormIsConvertedWhen') }}: </strong>
        <span v-if="form.conversion_rule_option === 'form_submit'">
          {{ translate('FormAnalytics_TheFormIsSubmitted') }}
        </span>
        <span v-else-if="form.conversion_rule_option === 'manually'">
          {{ translate('FormAnalytics_FormSetupConversionRulesConditionJsOrTagManager') }}
        </span>
        <span v-else>
          {{ this.matchRulesList(form.conversion_rules) }}
        </span>
        <br
          v-if="form.conversion_rules?.length
           || form.conversion_rule_option === 'form_submit'
            || form.conversion_rule_option === 'manually'"/>
        <span v-else>
          <span class="icon-warning" style="margin-right:3.5px"></span>
          <span v-html="noConversionRulesWarningText"></span>
          <br />
        </span>
      </p>
      <p>
        <a :href="this.formEditLink" v-if="canEditForm">
          <span class="icon-edit"></span>
          {{ translate('FormAnalytics_EditForm') }}
        </a>

        <a href
           :style="`margin-left: ${canEditForm ? '8.5' : '0'}px;`"
           @click.prevent="toggleKnownFormFields()"
           class="toggleKnownFormFields"
           v-if="form.fields?.length"
        >
          <span
            :class="`${canEditForm ? 'icon-edit' : 'icon-show'}`"
          ></span>
          {{ canEditForm
            ? translate('FormAnalytics_EditFormFields')
            : translate('FormAnalytics_ViewFormFields')}}
        </a>

        <br />

        <span v-if="isVisitorLogEnabled">
          <a
            href
            class="segmentVisitorsByStarters"
            @click.prevent="showSegmentedVisitorLog('form_num_starts>0')"
          >
            <span class="icon-visitor-profile"></span>
            {{ translate('FormAnalytics_ShowVisitorLogStarters') }}
          </a>

          <a
            href
            style="margin-left: 8.5px;"
            class="segmentVisitorsBySubmitters"
            @click.prevent="showSegmentedVisitorLog('form_num_submissions>0')"
          >
            <span class="icon-visitor-profile"></span>
            {{ translate('FormAnalytics_ShowVisitorLogSubmitters') }}
          </a>

          <a
            href
            style="margin-left: 8.5px;"
            class="segmentVisitorsByConverters"
            @click.prevent="showSegmentedVisitorLog('form_converted==1')"
          >
            <span class="icon-visitor-profile"></span>
            {{ translate('FormAnalytics_ShowVisitorLogConverters') }}
          </a>
          <br />
        </span>
      </p>
      <a name="editformfields"></a>
      <FormFields
        v-show="isKnownFieldsVisible"
        :form="form"
        :can-edit-form="canEditForm"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { ContentIntro, MatomoUrl, translate } from 'CoreHome';
import FormFields from '../FormFields/FormFields.vue';
import { Rule } from '../types';

interface FormSummaryState {
  isKnownFieldsVisible: boolean;
}

// eslint-disable-next-line @typescript-eslint/no-explicit-any
const { SegmentedVisitorLog } = window as any;

export default defineComponent({
  props: {
    form: {
      type: Object,
      required: true,
    },
    canEditForm: Boolean,
    isVisitorLogEnabled: Boolean,
    attributeTranslations: {
      type: Object,
      required: true,
    },
    patternTranslations: {
      type: Object,
      required: true,
    },
    segment: String,
  },
  directives: {
    ContentIntro,
  },
  components: {
    FormFields,
  },
  data(): FormSummaryState {
    return {
      isKnownFieldsVisible: false,
    };
  },
  methods: {
    matchRule(rule: Rule) {
      const attrText = this.attributeTranslations[rule.attribute] || rule.attribute;
      const patternText = this.patternTranslations[rule.pattern] || rule.pattern;

      return `${attrText}\n${patternText}\n${rule.value}`;
    },
    matchRulesList(rules?: Rule[]) {
      if (!rules?.length) {
        return '';
      }

      const parts = rules.map((r) => this.matchRule(r));
      return parts.join(` ${translate('General_Or')} `);
    },
    toggleKnownFormFields() {
      this.isKnownFieldsVisible = !this.isKnownFieldsVisible;
      console.log(this.isKnownFieldsVisible);
    },
    showSegmentedVisitorLog(condition: string) {
      const segment = this.segment ? `;${this.segment}` : '';
      SegmentedVisitorLog.show(
        'FormAnalytics.get',
        `form_name==${this.form.idsiteform};${condition}${segment}`,
        {},
      );
    },
  },
  computed: {
    formEditLink() {
      return `?${MatomoUrl.stringify({
        ...MatomoUrl.urlParsed.value,
        module: 'CoreHome',
        action: 'index',
      })}#?idForm=${this.form.idsiteform}&category=FormAnalytics_Forms&subcategory=FormAnalytics_ManageForms`;
    },
    noConversionRulesWarningText() {
      if (this.canEditForm) {
        return translate(
          'FormAnalytics_NoConversionRulesDefinesAdmin',
          `<a href="${this.formEditLink}">`,
          '</a>',
        );
      }

      return translate('FormAnalytics_NoConversionRulesDefinesView');
    },
  },
});
</script>
