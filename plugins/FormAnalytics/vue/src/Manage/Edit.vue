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
  <ContentBlock
    class="editForm"
    :content-title="contentTitle"
  >
    <p v-show="isLoading">
      <span class="loadingPiwik"><img src="plugins/Morpheus/images/loading-blue.gif" />
        {{ translate('General_LoadingData') }}</span>
    </p>
    <p v-show="isUpdating">
      <span class="loadingPiwik"><img src="plugins/Morpheus/images/loading-blue.gif" />
        {{ translate('FormAnalytics_UpdatingData') }}</span>
    </p>
    <form @submit="edit ? updateForm() : createForm()">
      <div>
        <div name="name">
          <Field
            uicontrol="text"
            name="name"
            :model-value="form.name"
            @update:model-value="form.name = $event; setValueHasChanged()"
            :title="translate('General_Name')"
            :maxlength="50"
            :placeholder="translate('FormAnalytics_FieldNamePlaceholder')"
            :inline-help="translate('FormAnalytics_FormNameHelp')"
          >
          </Field>
        </div>
        <div name="description">
          <Field
            uicontrol="textarea"
            name="description"
            :model-value="form.description"
            @update:model-value="form.description = $event; setValueHasChanged()"
            :title="`${translate('General_Description')} (optional)`"
            :maxlength="1000"
            :rows="3"
            :placeholder="translate('FormAnalytics_FieldDescriptionPlaceholder')"
            :inline-help="translate('FormAnalytics_FormDescriptionHelp')"
          >
          </Field>
        </div>
        <div
          class="form-group row"
          style="margin-bottom: 0;"
        >
          <div class="col s12">
            <h3>1) {{ translate('FormAnalytics_FormSetupFormRules') }}</h3>
          </div>
        </div>
        <div
          class="form-group row"
          style="margin-bottom: 0;"
          v-show="!matchPageOnly"
        >
          <div class="col s12">
            <p>
              <span v-html="$sanitize(formSetupRulesHelp)"/>
              <span
                style="margin-left:3.5px"
                class="icon-help"
                :title="translate('FormAnalytics_ComparisonsCaseInsensitive')"
              />
            </p>
          </div>
        </div>
        <div
          :class="`matchFormRules ${index} valign-wrapper`"
          v-show="!matchPageOnly"
          v-for="(matchFormRule, index) in form.match_form_rules"
          :key="index"
        >
          <div class="form-group row">
            <div class="col s12 m4 matchAttribute">
              <div name="matchAttribute">
                <Field
                  uicontrol="select"
                  name="matchAttribute"
                  :model-value="matchFormRule.attribute"
                  @update:model-value="matchFormRule.attribute = $event; setValueHasChanged();
                  matchFormRuleChanged();"
                  :full-width="true"
                  :options="formRulesAttributes"
                >
                </Field>
              </div>
            </div>
            <div class="col s12 m4 matchPattern">
              <div name="matchType">
                <Field
                  uicontrol="select"
                  name="matchType"
                  :model-value="matchFormRule.pattern"
                  @update:model-value="matchFormRule.pattern = $event; setValueHasChanged();
                  matchFormRuleChanged();"
                  :full-width="true"
                  :options="formRulesPatterns[matchFormRule.attribute]"
                >
                </Field>
              </div>
            </div>
            <div class="col s12 m4">
              <div name="matchValue">
                <Field
                  uicontrol="text"
                  name="matchValue"
                  :placeholder="`eg '${formRulesExamples[matchFormRule.attribute]}'`"
                  :model-value="matchFormRule.value"
                  @update:model-value="matchFormRule.value = $event; setValueHasChanged();
                  matchFormRuleChanged();"
                  :full-width="true"
                  :maxlength="1000"
                >
                </Field>
              </div>
            </div>
          </div>
          <div>
            <span
              class="icon-plus"
              :title="translate('General_Add')"
              @click="addMatchFormRule()"
            />
            <span
              class="icon-minus"
              :title="translate('General_Remove')"
              v-show="form.match_form_rules.length > 1"
              @click="removeMatchFormRule(index)"
            />
          </div>
        </div>
        <div>
          <div name="matchPageOnly">
            <Field
              uicontrol="checkbox"
              name="matchPageOnly"
              :model-value="matchPageOnly"
              @update:model-value="matchPageOnly = $event; setValueHasChanged()"
              :title="translate('FormAnalytics_SettingAllowCreationByPageOnly')"
              :inline-help="translate('FormAnalytics_SettingAllowCreationByPageOnlyDescription')"
            >
            </Field>
          </div>
        </div>
        <div
          class="form-group row"
          style="margin-bottom: 0;"
        >
          <div class="col s12">
            <h3>2) {{ translate('FormAnalytics_FormSetupPageRules') }}:</h3>
          </div>
        </div>
        <div
          class="form-group row"
          style="margin-bottom: 0;"
        >
          <div class="col s12">
            <p>{{ translate('FormAnalytics_FormSetupPageRulesHelp') }}
              <span
                class="icon-help"
                :title="setupPageRulesHelpTooltip"
              />
            </p>
          </div>
        </div>
        <div
          :class="`matchPageRules ${index} valign-wrapper`"
          v-for="(matchPageUrl, index) in form.match_page_rules"
          :key="index"
        >
          <div class="form-group row">
            <div class="col s12 m4 matchAttribute">
              <div name="matchAttribute">
                <Field
                  uicontrol="select"
                  name="matchAttribute"
                  :model-value="matchPageUrl.attribute"
                  @update:model-value="matchPageUrl.attribute = $event; setValueHasChanged()"
                  :full-width="true"
                  :options="pageRulesAttributes"
                >
                </Field>
              </div>
            </div>
            <div class="col s12 m4 matchPattern">
              <div name="matchType">
                <Field
                  uicontrol="select"
                  name="matchType"
                  :model-value="matchPageUrl.pattern"
                  @update:model-value="matchPageUrl.pattern = $event; setValueHasChanged()"
                  :full-width="true"
                  :options="pageRulesPatterns[matchPageUrl.attribute]"
                >
                </Field>
              </div>
            </div>
            <div class="col s12 m4">
              <div name="matchValue">
                <Field
                  uicontrol="text"
                  name="matchValue"
                  :placeholder="`eg '${pageRulesExamples[matchPageUrl.attribute]}'`"
                  :model-value="matchPageUrl.value"
                  @update:model-value="matchPageUrl.value = $event; setValueHasChanged()"
                  :full-width="true"
                  :maxlength="1000"
                >
                </Field>
              </div>
            </div>
          </div>
          <div>
            <span
              class="icon-plus"
              :title="translate('General_Add')"
              @click="addMatchPageRule()"
            />
            <span
              class="icon-minus"
              :title="translate('General_Remove')"
              v-show="form.match_page_rules.length > 1"
              @click="removeMatchPageRule(index)"
            />
          </div>
        </div>
        <div
          class="form-group row"
          style="margin-bottom: 0;"
        >
          <div class="col s12">
            <h3>3) {{ translate('FormAnalytics_FormSetupConversionRulesTitle') }}:</h3>
          </div>
        </div>
        <div>
          <div name="conversionRuleOption">
            <Field
              uicontrol="radio"
              name="conversionRuleOption"
              :model-value="conversionRuleOption"
              @update:model-value="conversionRuleOption = $event; setValueHasChanged();
              conversionRuleOptionChanged();"
              :title="translate('FormAnalytics_FormSetupTitle')"
              :inline-help="$sanitize(getInlineHelpByConversionOption)"
              :options="conversionRuleOptions"
            >
            </Field>
          </div>
        </div>
        <div
          v-if="conversionRuleOption === 'manually'"
          class="form-group row"
        >
          <div id="javascript-tracking" class="col s6">
            <p
              v-html="$sanitize(translate(
                'FormAnalytics_FormSetupConversionRulesManualConversionJsOrTagManagerDescription'
                ))"
            ></p>
            <pre v-select-on-focus="{}" class="codeblock"
                 v-html="$sanitize(jsCode)"
            ></pre>
            <p
              v-html="$sanitize(getJsOrTagManagerHelpCode)"
            ></p>
          </div>
        </div>
        <div
          class="form-group row"
          style="margin-bottom: 0;"
        >
          <div
            class="col s12"
            v-show="conversionRuleOption === 'page_visit'"
          >
            <p>{{ translate('FormAnalytics_FormSetupPageRulesHelpNew') }}
              <span
                class="icon-help"
                :title="setupPageRulesHelpTooltip"
              />
            </p>
          </div>
        </div>
        <div
          :class="`conversionRules ${index} valign-wrapper`"
          v-for="(conversionRule, index) in form.conversion_rules"
          v-show="conversionRuleOption === 'page_visit'"
          :key="index"
        >
          <div class="form-group row">
            <div class="col s12 m4 matchAttribute">
              <div name="matchAttribute">
                <Field
                  uicontrol="select"
                  name="matchAttribute"
                  :model-value="conversionRule.attribute"
                  @update:model-value="conversionRule.attribute = $event; setValueHasChanged()"
                  :full-width="true"
                  :options="pageRulesAttributes"
                >
                </Field>
              </div>
            </div>
            <div class="col s12 m4 matchPattern">
              <div name="matchType">
                <Field
                  uicontrol="select"
                  name="matchType"
                  :model-value="conversionRule.pattern"
                  @update:model-value="conversionRule.pattern = $event; setValueHasChanged()"
                  :full-width="true"
                  :options="pageRulesPatterns[conversionRule.attribute]"
                >
                </Field>
              </div>
            </div>
            <div class="col s12 m4">
              <div name="matchValue">
                <Field
                  uicontrol="text"
                  name="matchValue"
                  :placeholder="`eg '${pageRulesExamples[conversionRule.attribute]}'`"
                  :model-value="conversionRule.value"
                  @update:model-value="conversionRule.value = $event; setValueHasChanged()"
                  :full-width="true"
                  :maxlength="1000"
                >
                </Field>
              </div>
            </div>
          </div>
          <div>
            <span
              class="icon-plus"
              :title="translate('General_Add')"
              @click="addConversionRule()"
            />
            <span
              class="icon-minus"
              :title="translate('General_Remove')"
              v-show="form.conversion_rules.length > 1"
              @click="removeConversionRule(index)"
            />
          </div>
        </div>
        <SaveButton
          class="createButton"
          @confirm="edit ? updateForm() : createForm()"
          :disabled="isUpdating || !isDirty"
          :saving="isUpdating"
          :value="createButtonText"
        >
        </SaveButton>
        <div class="entityCancel">
          <a @click="cancel()">{{ translate('General_Cancel') }}</a>
        </div>
      </div>
    </form>
  </ContentBlock>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import {
  translate,
  Matomo,
  ContentBlock,
  NotificationsStore,
  NotificationType,
  clone,
  MatomoUrl,
  SelectOnFocus,
} from 'CoreHome';
import { Field, SaveButton } from 'CorePluginsAdmin';
import FormAnalyticsStore from '../FormAnalytics.store';
import { AvailableRule, ConversionRuleOption, Form } from '../types';

interface Option {
  key: string;
  value: string;
}

interface FormEditState {
  isDirty: boolean;
  formRules: AvailableRule[];
  pageRules: AvailableRule[];
  matchPageOnly: boolean;
  conversionRuleOptions: ConversionRuleOption[];
  conversionRuleOption: string;
  form: Form;
  jsCode: string;
  learMoreAppended: boolean;
}

const notificationId = 'formsmanagement';

export default defineComponent({
  props: {
    idForm: Number,
  },
  components: {
    ContentBlock,
    Field,
    SaveButton,
  },
  directives: {
    SelectOnFocus,
  },
  data(): FormEditState {
    return {
      isDirty: false,
      formRules: [],
      pageRules: [],
      matchPageOnly: false,
      conversionRuleOptions: [],
      conversionRuleOption: '',
      form: {} as unknown as Form,
      jsCode: "_paq.push(['FormAnalytics::trackFormConversion', '{formName}', '{formId}']);",
      learMoreAppended: false,
    };
  },
  created() {
    FormAnalyticsStore.getAvailableFormRules().then((rules) => {
      this.formRules = rules;
    });

    FormAnalyticsStore.getAvailablePageRules().then((rules) => {
      this.pageRules = rules;
    });

    FormAnalyticsStore.getAvailableConversionRuleOptions().then((rules) => {
      this.conversionRuleOptions = rules;
    });

    this.init();
  },
  watch: {
    idForm(newValue) {
      if (newValue === null) {
        return;
      }

      this.init();
    },
  },
  methods: {
    removeAnyFormNotification() {
      NotificationsStore.remove(notificationId);
      NotificationsStore.remove('ajaxHelper');
    },
    showNotification(message: string, context: NotificationType['context']) {
      const instanceId = NotificationsStore.show({
        message,
        context,
        id: notificationId,
        type: 'transient',
      });

      setTimeout(() => {
        NotificationsStore.scrollToNotification(instanceId);
      }, 100);
    },
    showErrorFieldNotProvidedNotification(title: string) {
      const message = translate('FormAnalytics_ErrorXNotProvided', [title]);
      this.showNotification(message, 'error');
    },
    init() {
      const idSiteForm = this.idForm;

      this.form = {} as unknown as Form;
      Matomo.helper.lazyScrollToContent();
      setTimeout(() => {
        if (!this.learMoreAppended) {
          this.learMoreAppended = true;
          const link = 'https://matomo.org/faq/form-analytics/faq_23774/';
          const helpTextFaqLink = translate(
            'FormAnalytics_FormSetupConversionRulesFaqHelpLink',
            ` <a target="blank" rel="noreferrer" href="${link}">`,
            '</a>',
          );
          $('.fieldRadioTitle').append(helpTextFaqLink);
        }
      }, 200);

      if (this.edit && idSiteForm) {
        FormAnalyticsStore.findForm(idSiteForm).then((form) => {
          if (!form) {
            return;
          }

          this.form = clone(form) as Form;

          this.matchPageOnly = !this.form.match_form_rules?.length;

          this.conversionRuleOption = this.form.conversion_rule_option;

          this.addInitialMatchFormRule();
          this.addInitialMatchPageRule();
          this.addInitialConversionRule();
          this.isDirty = false;
        });
      } else if (this.create) {
        this.form = {
          idSite: Matomo.idSite,
          name: '',
          description: '',
          status: 'running',
        } as unknown as Form;

        this.matchPageOnly = false;
        this.conversionRuleOption = 'page_visit';

        this.addInitialMatchFormRule();
        this.addInitialMatchPageRule();
        this.addInitialConversionRule();

        this.isDirty = false;
      }
    },
    addInitialMatchFormRule() {
      if (this.form?.match_form_rules?.length) {
        this.matchFormRuleChanged();
        return;
      }

      this.addMatchFormRule();
    },
    addMatchFormRule() {
      if (!this.form) {
        return;
      }

      this.form.match_form_rules = [
        ...(this.form.match_form_rules || []),
        {
          attribute: 'form_name',
          pattern: 'equals',
          value: '',
        },
      ];

      this.isDirty = true;
    },
    addInitialMatchPageRule() {
      if (this.form?.match_page_rules?.length) {
        return;
      }

      this.addMatchPageRule();
    },
    addMatchPageRule() {
      if (!this.form) {
        return;
      }

      this.form.match_page_rules = [
        ...(this.form.match_page_rules || []),
        {
          attribute: 'page_url',
          pattern: 'equals',
          value: '',
        },
      ];

      this.isDirty = true;
    },
    addInitialConversionRule() {
      if (this.form?.conversion_rules?.length) {
        return;
      }

      this.addConversionRule();
    },
    addConversionRule() {
      if (!this.form) {
        return;
      }

      this.form.conversion_rules = [
        ...(this.form.conversion_rules || []),
        {
          attribute: 'page_url',
          pattern: 'equals',
          value: '',
        },
      ];

      this.isDirty = true;
    },
    removeConversionRule(index: number) {
      if (this.form && index > -1) {
        this.form.conversion_rules = [...this.form.conversion_rules];
        this.form.conversion_rules.splice(index, 1);
        this.isDirty = true;
      }
    },
    removeMatchFormRule(index: number) {
      if (this.form && index > -1) {
        this.form.match_form_rules = [...this.form.match_form_rules];
        this.form.match_form_rules.splice(index, 1);
        this.isDirty = true;
      }
    },
    removeMatchPageRule(index: number) {
      if (this.form && index > -1) {
        this.form.match_page_rules = [...this.form.match_page_rules];
        this.form.match_page_rules.splice(index, 1);
        this.isDirty = true;
      }
    },
    cancel() {
      const newParams = { ...MatomoUrl.hashParsed.value };
      delete newParams.idForm;

      MatomoUrl.updateHash(newParams);
    },
    createForm() {
      const method = 'FormAnalytics.addForm';
      this.removeAnyFormNotification();

      if (!this.checkRequiredFieldsAreSet()) {
        return;
      }

      this.form.conversion_rule_option = this.conversionRuleOption;
      FormAnalyticsStore.createOrUpdateForm(
        this.form,
        this.matchPageOnly,
        method,
      ).then((response) => {
        if (!response || response.type === 'error' || !response.response) {
          return;
        }

        this.isDirty = false;

        const idForm = response.response.value;
        FormAnalyticsStore.reload().then(() => {
          if (Matomo.helper.isReportingPage()) {
            Matomo.postEvent('updateReportingMenu');
          }

          MatomoUrl.updateHash({
            ...MatomoUrl.hashParsed.value,
            idForm,
          });

          setTimeout(() => {
            this.showNotification(
              translate('FormAnalytics_FormCreated'),
              response.type as NotificationType['context'],
            );
          }, 200);
        });
      });
    },
    setValueHasChanged() {
      this.isDirty = true;
    },
    conversionRuleOptionChanged() {
      if (this.conversionRuleOption !== 'page_visit') {
        this.form.conversion_rules = [{
          attribute: 'page_url',
          pattern: 'equals',
          value: '',
        }];
      }
    },
    matchFormRuleChanged() {
      if (this.form.match_form_rules.length) {
        let formName = '';
        let formId = '';
        for (let i = 0; i < this.form.match_form_rules.length; i += 1) {
          const formRules = this.form.match_form_rules[i];
          if (formRules.attribute === 'form_name' && (formRules.pattern === 'equals_exactly' || formRules.pattern === 'equals') && formRules.value) {
            formName = this.htmlEntities(formRules.value);
          } else if (formRules.attribute === 'form_id' && (formRules.pattern === 'equals_exactly' || formRules.pattern === 'equals') && formRules.value) {
            formId = this.htmlEntities(formRules.value);
          }
        }

        if (formName && formId) {
          this.jsCode = `_paq.push(['FormAnalytics::trackFormConversion', '${formName}', '${formId}']);`;
        } else if (formName && !formId) {
          this.jsCode = `_paq.push(['FormAnalytics::trackFormConversion', '${formName}']);`;
        } else if (!formName && formId) {
          this.jsCode = `_paq.push(['FormAnalytics::trackFormConversion', '{formName}', '${formId}']);`;
        } else {
          this.jsCode = "_paq.push(['FormAnalytics::trackFormConversion', '{formName}', '{formId}']);";
        }
      }
    },
    updateForm() {
      this.removeAnyFormNotification();

      if (!this.checkRequiredFieldsAreSet()) {
        return;
      }

      const method = 'FormAnalytics.updateForm';

      this.form.conversion_rule_option = this.conversionRuleOption;
      FormAnalyticsStore.createOrUpdateForm(
        this.form,
        this.matchPageOnly,
        method,
      ).then((response) => {
        if (response.type === 'error') {
          return;
        }

        this.isDirty = false;

        this.form = {} as unknown as Form;
        FormAnalyticsStore.reload().then(() => {
          this.init();
        });

        this.showNotification(
          translate('FormAnalytics_FormUpdated'),
          response.type as NotificationType['context'],
        );
      });
    },
    checkRequiredFieldsAreSet() {
      if (!this.form.name) {
        const title = translate('General_Name');
        this.showErrorFieldNotProvidedNotification(title);
        return false;
      }

      if (this.conversionRuleOption === 'page_visit'
        && !this.matchPageOnly
        && (!FormAnalyticsStore.filterRules(this.form?.match_form_rules || []).length)
      ) {
        const title = translate('FormAnalytics_ErrorFormRuleRequired');
        this.showNotification(title, 'error');
        return false;
      }

      return true;
    },
    htmlEntities(v: string) {
      return Matomo.helper.htmlEntities(v);
    },
  },
  computed: {
    formRulesAttributes() {
      return this.formRules.map((r) => ({
        key: r.key,
        value: r.name,
      }));
    },
    formRulesPatterns() {
      const patterns: Record<string, Option[]> = {};
      this.formRules.forEach((r) => {
        patterns[r.key] = r.patterns.map((p) => ({
          key: p.key,
          value: p.name,
        }));
      });
      return patterns;
    },
    formRulesExamples() {
      const examples: Record<string, string> = {};
      this.formRules.forEach((r) => {
        examples[r.key] = r.example;
      });
      return examples;
    },
    pageRulesAttributes() {
      return this.pageRules.map((r) => ({
        key: r.key,
        value: r.name,
      }));
    },
    pageRulesPatterns() {
      const patterns: Record<string, Option[]> = {};
      this.pageRules.forEach((r) => {
        patterns[r.key] = r.patterns.map((p) => ({
          key: p.key,
          value: p.name,
        }));
      });
      return patterns;
    },
    pageRulesExamples() {
      const examples: Record<string, string> = {};
      this.pageRules.forEach((r) => {
        examples[r.key] = r.example;
      });
      return examples;
    },
    create() {
      return !this.idForm;
    },
    edit() {
      return !this.create;
    },
    editTitle() {
      return this.create ? 'FormAnalytics_CreateNewForm' : 'FormAnalytics_EditForm';
    },
    contentTitle() {
      return translate(this.editTitle, this.form.name ? `"${this.form.name}"` : '');
    },
    isLoading() {
      return FormAnalyticsStore.state.value.isLoading;
    },
    isUpdating() {
      return FormAnalyticsStore.state.value.isUpdating;
    },
    formSetupRulesHelp() {
      const link = 'https://matomo.org/faq/form-analytics/faq_23727/';
      return translate(
        'FormAnalytics_FormSetupFormRulesHelp',
        `<a target="blank" rel="noreferrer" href="${link}">`,
        '</a>',
      );
    },
    setupConversionHelpRules2() {
      const link = 'https://developer.matomo.org/guides/form-analytics/reference';
      return translate(
        'FormAnalytics_FormSetupConversionRulesHelp2',
        `<a target="blank" rel="noreferrer" href="${link}">`,
        '</a>',
      );
    },
    setupConversionsHelpTooltip() {
      const part1 = translate('FormAnalytics_ComparisonsCaseInsensitive');
      const part2 = translate('FormAnalytics_ComparisonsIgnoredValues');
      return `${part1} ${part2}`;
    },
    createButtonText() {
      return this.edit
        ? translate('CoreUpdater_UpdateTitle')
        : translate('FormAnalytics_CreateNewForm');
    },
    setupPageRulesHelpTooltip() {
      const part1 = translate('FormAnalytics_ComparisonsCaseInsensitive');
      const part2 = translate('FormAnalytics_ComparisonsIgnoredValues');
      return `${part1} ${part2}`;
    },
    getInlineHelpByConversionOption() {
      const helpTextFormSubmit = translate(
        'FormAnalytics_FormSetupConversionRulesFormSubmitHelp',
        '<b>',
        '</b><br>',
      );

      const helpTextPageVisit = translate(
        'FormAnalytics_FormSetupConversionRulesPageVisitHelp',
        '<br><br><b>',
        '</b><br>',
      );

      const helpTextJsOrTagManager = translate(
        'FormAnalytics_FormSetupConversionRulesJsOrTagManagerHelp',
        '<br><br><b>',
        '</b><br>',
      );

      return `${helpTextFormSubmit}${helpTextPageVisit}${helpTextJsOrTagManager}`;
    },
    getJsCode() {
      return "_paq.push(['FormAnalytics::trackFormConversion', '{formName}', '{formId}']);";
    },
    getJsOrTagManagerHelpCode() {
      const link = 'https://developer.matomo.org/guides/form-analytics/reference#trackformconversionnodeorformname-formid';
      return translate(
        'FormAnalytics_FormSetupJsOrTagManagerHelp',
        `<a target="blank" rel="noreferrer" href="${link}">`,
        '</a>',
      );
    },
  },
});
</script>
