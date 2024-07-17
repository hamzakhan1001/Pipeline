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
    class="editConversionExport"
    :content-title="contentTitle"
  >
    <p v-show="isLoading">
      <span class="loadingPiwik"><img src="plugins/Morpheus/images/loading-blue.gif" />
        {{ translate('General_LoadingData') }}</span>
    </p>
    <p v-show="isUpdating">
      <span class="loadingPiwik"><img src="plugins/Morpheus/images/loading-blue.gif" />
        {{ translate('AdvertisingConversionExport_UpdatingData') }}</span>
    </p>
    <form @submit="edit ? updateExport() : createExport()">
      <div>
        <div name="name">
          <Field
            uicontrol="text"
            name="name"
            :model-value="conversionExport.name"
            @update:model-value="conversionExport.name = $event; setValueHasChanged()"
            :title="translate('General_Name')"
            :maxlength="50"
            :tabindex="21"
            :placeholder="translate('AdvertisingConversionExport_FieldNamePlaceholder')"
            :inline-help="translate('AdvertisingConversionExport_ExportNameHelp')"
          >
          </Field>
        </div>
        <div name="type">
          <Field
            uicontrol="radio"
            name="type"
            :model-value="conversionExport.type"
            @update:model-value="conversionExport.type = $event; setValueHasChanged(); showNote();"
            :title="translate('AdvertisingConversionExport_ExportType')"
            :tabindex="22"
            :options="exportTypeOptions"
            :inline-help="conversionExportHelp"
          >
          </Field>
        </div>
        <div name="description">
          <Field
            uicontrol="textarea"
            name="description"
            :model-value="conversionExport.description"
            @update:model-value="conversionExport.description = $event; setValueHasChanged()"
            :title="`${translate('General_Description')} ${translate('Goals_Optional')}`"
            :maxlength="1000"
            :rows="3"
            :tabindex="26"
            :placeholder="translate('AdvertisingConversionExport_ExportDescriptionPlaceHolder')"
            :inline-help="translate('AdvertisingConversionExport_ExportDescriptionHelp')"
          >
          </Field>
        </div>
        <div class="row accesstokenhead">
          <label class="col s12">
            {{ translate('AdvertisingConversionExport_AccessToken') }} <a
              v-show="conversionExport.idexport"
              @click="regenerateAccessToken()"
            >({{ translate('AdvertisingConversionExport_Regenerate') }})</a>
          </label>
        </div>
        <div name="access_token">
          <Field
            uicontrol="text"
            name="access_token"
            title
            v-model="conversionExport.access_token"
            :maxlength="100"
            :disabled="true"
            :placeholder="translate('AdvertisingConversionExport_FieldAccessTokenPlaceholder')"
            :inline-help="accessTokenInlineHelp"
          >
          </Field>
        </div>
        <div
          class="form-group row"
          style="margin-bottom: 0;"
        >
          <div class="col s12">
            <h3>{{ translate('AdvertisingConversionExport_AttributionSettings') }}</h3>
          </div>
        </div>
        <div name="directAttribution">
          <Field
            uicontrol="checkbox"
            name="directAttribution"
            :model-value="conversionExport.parameters.onlyDirectAttribution"
            @update:model-value="conversionExport.parameters.onlyDirectAttribution = $event;
              setValueHasChanged()"
            :title="translate('AdvertisingConversionExport_DirectAttributionOnly')"
            :tabindex="23"
            :inline-help="directAttributionHelp"
          >
          </Field>
        </div>
        <div name="daysToLookBack">
          <Field
            uicontrol="number"
            name="daysToLookBack"
            :model-value="conversionExport.parameters.daysToLookBack"
            @update:model-value="conversionExport.parameters.daysToLookBack = $event;
              setValueHasChanged()"
            :title="translate('AdvertisingConversionExport_DaysToLookBack')"
            v-show="!conversionExport.parameters.onlyDirectAttribution
              || conversionExport.parameters.onlyDirectAttribution === '0'"
            :min="1"
            :max="365"
            :default-value="30"
            :tabindex="24"
            :inline-help="translate('AdvertisingConversionExport_DaysToLookBackDescription')"
          >
          </Field>
        </div>
        <div name="clickIdAttribution">
          <Field
            uicontrol="radio"
            name="clickIdAttribution"
            :model-value="conversionExport.parameters.clickIdAttribution"
            @update:model-value="conversionExport.parameters.clickIdAttribution = $event;
              setValueHasChanged()"
            :title="translate('AdvertisingConversionExport_ClickIdAttribution')"
            v-show="!conversionExport.parameters.onlyDirectAttribution
              || conversionExport.parameters.onlyDirectAttribution === '0'"
            :tabindex="25"
            :options="clickIdAttributionOptions"
            :inline-help="translate('AdvertisingConversionExport_ClickIdAttributionDescription')"
          >
          </Field>
        </div>
        <div name="externalAttributedConversion">
          <Field
              uicontrol="checkbox"
              name="externalAttributedConversion"
              :model-value="conversionExport.parameters.externalAttributedConversion"
              @update:model-value="
                conversionExport.parameters.externalAttributedConversion = $event;
                setValueHasChanged()"
              title="External attributed conversion"
              v-show="conversionExport.type === 'GoogleAds'"
              :tabindex="26"
              :inline-help="translate(
               'AdvertisingConversionExport_ExternalAttributedConversionHelp')"
          >
          </Field>
        </div>
        <div name="attributionModel">
          <Field
              uicontrol="select"
              name="attributionModel"
              :model-value="conversionExport.parameters.attributionModel"
              @update:model-value="conversionExport.parameters.attributionModel = $event;
                setValueHasChanged()"
              title="Attribution Model"
              v-show="conversionExport.type === 'GoogleAds'
                && conversionExport.parameters.externalAttributedConversion
                && conversionExport.parameters.externalAttributedConversion !== '0'"
              :options="attributionModelOptions"
              :tabindex="27"
              :inline-help="translate('AdvertisingConversionExport_AttributionModelHelp')"
          >
          </Field>
        </div>
        <div name="attributedCredit">
          <Field
              uicontrol="number"
              name="attributedCredit"
              :model-value="conversionExport.parameters.attributedCredit"
              @update:model-value="conversionExport.parameters.attributedCredit = $event;
                setValueHasChanged()"
              title="Attributed Credit"
              v-show="conversionExport.type === 'GoogleAds'
                && conversionExport.parameters.externalAttributedConversion
                && conversionExport.parameters.externalAttributedConversion !== '0'"
              :tabindex="28"
              :min="0"
              :max="1"
              :inline-help="translate('AdvertisingConversionExport_AttributedCreditHelp')"
          >
          </Field>
        </div>
        <div
          class="form-group row"
          style="margin-bottom: 0;"
        >
          <div class="col s12">
            <h3>{{ translate('AdvertisingConversionExport_VisitorsToExport') }}</h3>
          </div>
        </div>
        <div
          class="form-group row"
          style="margin-bottom: 0;"
        >
          <div class="col s12">
            <p>
              <span
                v-html="$sanitize(translate('AdvertisingConversionExport_VisitorsToExportHelp'))"
              />
            </p>
          </div>
        </div>
        <div name="daysToExport">
          <Field
            uicontrol="number"
            name="daysToExport"
            :model-value="conversionExport.parameters.daysToExport"
            @update:model-value="conversionExport.parameters.daysToExport = $event;
              setValueHasChanged()"
            :title="translate('AdvertisingConversionExport_DaysToExport')"
            :min="1"
            :max="100"
            :default-value="7"
            :tabindex="35"
            :inline-help="translate('AdvertisingConversionExport_DaysToExportHelp')"
          >
          </Field>
        </div>
        <div
          class="form-group row"
          style="margin-bottom: 0;"
        >
          <div class="col s12">
            <label
              v-html="$sanitize(translate('AdvertisingConversionExport_AdditionalSegment'))"
            />
            <div>
              <SegmentGenerator
                tabindex="36"
                :model-value="conversionExport.parameters.segment"
                @update:model-value="conversionExport.parameters.segment = $event;
                  setValueHasChanged()"
                :visit-segments-only="true"
              />
            </div>
          </div>
        </div>
        <div
          class="form-group row"
          style="margin-bottom: 0;"
        >
          <div class="col s12">
            <h3>{{ translate('AdvertisingConversionExport_ConversionsToExport') }}</h3>
          </div>
        </div>
        <div
          class="form-group row"
          style="margin-bottom: 0;"
        >
          <div class="col s12">
            <p>
              <span
                v-html="$sanitize(translate('AdvertisingConversionExport_ConversionsToExportHelp'))"
              />
            </p>
          </div>
        </div>
        <p v-show="isLoadingGoals">
          <span class="loadingPiwik"><img src="plugins/Morpheus/images/loading-blue.gif" />
            {{ translate('General_LoadingData') }}</span>
        </p>
        <Alert v-if="!goals.length && !isLoadingGoals" severity="warning">
          {{ translate('AdvertisingConversionExport_NoGoalsConfigured') }}
        </Alert>
        <div v-if="goals.length && !isLoadingGoals">
          <div
            v-for="(goal, index) in conversionExport.parameters.goals"
            :class="`exportGoals ${index} valign-wrapper`"
            :key="index"
          >
            <div class="form-group row">
              <div class="col s12 m4">
                <div :name="`exportGoalId${index}`">
                  <Field
                    uicontrol="select"
                    :model-value="goal.idgoal"
                    @update:model-value="goal.idgoal = $event; setValueHasChanged()"
                    :title="translate('General_Goal')"
                    :name="`exportGoalId${index}`"
                    :full-width="true"
                    :options="goals"
                    :tabindex="37 + index * 4"
                  >
                  </Field>
                </div>
              </div>
              <div class="col s12 m4">
                <div :name="`exportGoalName${index}`">
                  <Field
                    uicontrol="text"
                    :model-value="goal.name"
                    @update:model-value="goal.name = $event; setValueHasChanged()"
                    :title="translate('AdvertisingConversionExport_GoalAlias')"
                    :name="`exportGoalName${index}`"
                    :full-width="true"
                    :maxlength="50"
                    :tabindex="38 + index * 4"
                  >
                  </Field>
                </div>
              </div>
              <div class="col s12 m4">
                <div class="row" style="margin-bottom:0">
                  <div
                    :name="`exportGoalRevenue${index}`"
                    :class="`col s12 ${ goal.revenue === 'custom' ? 'm6' : 'm12' }`"
                  >
                    <Field
                      uicontrol="select"
                      :model-value="goal.revenue"
                      @update:model-value="goal.revenue = $event; setValueHasChanged()"
                      :title="translate('General_ColumnRevenue')"
                      :name="`exportGoalRevenue${index}`"
                      :class="{custom: goal.revenue === 'custom'}"
                      :full-width="true"
                      :options="revenueOptions"
                      :tabindex="39 + index * 4"
                    >
                    </Field>
                  </div>
                  <div :name="`exportGoalRevenueCustom${index}`" class="col s12 m6">
                    <Field
                      uicontrol="number"
                      :model-value="goal.revenueValue"
                      @update:model-value="goal.revenueValue = $event; setValueHasChanged()"
                      :title="translate('General_Value')"
                      :name="`exportGoalRevenueCustom${index}`"
                      :full-width="true"
                      v-if="goal.revenue === 'custom'"
                      :tabindex="40 + index * 4"
                    >
                    </Field>
                  </div>
                </div>
              </div>
            </div>
            <div>
              <span
                class="icon-plus"
                :title="translate('General_Add')"
                v-show="conversionExport.parameters?.goals.length < goals.length"
                @click="addExportGoal()"
              />
              <span
                class="icon-minus"
                :title="translate('General_Remove')"
                v-show="conversionExport.parameters?.goals.length > 1"
                @click="removeExportGoal(index)"
              />
            </div>
          </div>
        </div>
        <Alert v-if="showNoteMessage" severity="info">
          <strong>
            {{ translate('AdvertisingConversionExport_ExportNote') }}:
          </strong> {{ noteMessage }}
        </Alert>
        <SaveButton
          class="createButton"
          tabindex="100"
          @confirm="edit ? updateExport() : createExport()"
          :disabled="isUpdating || !isDirty || !goals.length"
          :saving="isUpdating"
          :value="createButtonText"
        >
        </SaveButton>
        <div class="entityCancel">
          <a @click="cancel()">{{ translate('General_Cancel') }}</a>
        </div>
      </div>
    </form>
    <div
      class="ui-confirm"
      id="confirmRegenerateAccessToken"
      ref="confirmRegenerateAccessToken"
    >
      <h2>{{ translate('AdvertisingConversionExport_RegenerateAccessTokenConfirm') }} </h2>
      <input
        role="yes"
        type="button"
        :value="translate('General_Yes')"
      />
      <input
        role="no"
        type="button"
        :value="translate('General_No')"
      />
    </div>
  </ContentBlock>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import {
  translate,
  Matomo,
  ContentBlock,
  Alert,
  NotificationsStore,
  NotificationType,
  clone,
  MatomoUrl,
} from 'CoreHome';
import { Field, SaveButton } from 'CorePluginsAdmin';
import { SegmentGenerator } from 'SegmentEditor';
import { ConversionExport } from '../types';
import ConversionExportStore from '../ConversionExportStore.store';

const DEFAULT_EXTERNAL_ATTRIBUTED_CONVERSION = 0;
const DEFAULT_ATTRIBUTION_MODEL = 'dataDriven';
const DEFAULT_ATTRIBUTED_CREDIT = 1;

interface ConversionExportEditState {
  isDirty: boolean;
  conversionExport: ConversionExport;
  showNoteMessage: boolean;
  noteMessage: string;
}

interface ExportType {
  id: string;
  name: string;
  description: string;
}

interface AttributionModel {
  id: string;
  exportName: string;
  translatedName: string;
}

const notificationId = 'conversionexportmanagement';

const REVENUE_OPTIONS = {
  goal: translate('AdvertisingConversionExport_UseGoalRevenue'),
  custom: translate('AdvertisingConversionExport_UseCustomRevenue'),
  null: translate('AdvertisingConversionExport_UseEmptyRevenue'),
};

const CLICK_ID_ATTRIBUTION_OPTIONS = {
  first: translate('AdvertisingConversionExport_FirstClickId'),
  last: translate('AdvertisingConversionExport_LastClickId'),
  all: translate('AdvertisingConversionExport_AllClickIds'),
};

export default defineComponent({
  props: {
    idExport: Number,
    exportTypes: {
      type: Object,
      required: true,
    },
    alreadyCreatedExportTypes: {
      type: Object,
      required: true,
    },
    clickIdProviders: {
      type: Object,
      required: true,
    },
    attributionModels: {
      type: Object,
      required: true,
    },
  },
  components: {
    ContentBlock,
    Field,
    SegmentGenerator,
    Alert,
    SaveButton,
  },
  data(): ConversionExportEditState {
    return {
      isDirty: false,
      conversionExport: {} as unknown as ConversionExport,
      showNoteMessage: false,
      noteMessage: 'test',
    };
  },
  created() {
    ConversionExportStore.fetchExports();

    this.init();
  },
  watch: {
    idExport(newValue) {
      if (newValue === null) {
        return;
      }

      this.init();
    },
  },
  methods: {
    removeAnyNotification() {
      NotificationsStore.remove(notificationId);
      NotificationsStore.remove('ajaxHelper');
    },
    showNotification(message: string, context: NotificationType['context']) {
      this.removeAnyNotification();

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
      const message = translate('AdvertisingConversionExport_ErrorXNotProvided', [title]);
      this.showNotification(message, 'error');
    },
    init() {
      const { idExport } = this;

      this.conversionExport = { parameters: {} } as unknown as ConversionExport;
      Matomo.helper.lazyScrollToContent();

      if (this.edit && idExport) {
        ConversionExportStore.findExport(idExport).then((conversionExport) => {
          if (`${conversionExport?.idsite}` !== `${Matomo.idSite}`) {
            setTimeout(() => {
              this.showNotification(translate('AdvertisingConversionExport_UnableToLoadExport'), 'error');
            }, 200);
            this.cancel();
            return;
          }

          this.conversionExport = clone(conversionExport) as ConversionExport;

          if (this.conversionExport.parameters) {
            const params = this.conversionExport.parameters;
            params.externalAttributedConversion = params.externalAttributedConversion
                ?? DEFAULT_EXTERNAL_ATTRIBUTED_CONVERSION;
            params.attributionModel = params.attributionModel
                ?? DEFAULT_ATTRIBUTION_MODEL;
            params.attributedCredit = params.attributedCredit
                ?? DEFAULT_ATTRIBUTED_CREDIT;
          }

          ConversionExportStore.fetchGoals().then(() => {
            this.isDirty = false;
            this.addInitialExportGoal();
          });
        });
        return;
      }

      if (this.create) {
        this.conversionExport = {
          idsite: Matomo.idSite,
          name: '',
          type: Object.keys(this.exportTypeOptions)[0],
          description: '',
          access_token: '',
          parameters: {
            goals: [],
            daysToExport: 7,
            segment: '',
            onlyDirectAttribution: 1,
            daysToLookBack: 30,
            clickIdAttribution: 'last',
            externalAttributedConversion: DEFAULT_EXTERNAL_ATTRIBUTED_CONVERSION,
            attributionModel: DEFAULT_ATTRIBUTION_MODEL,
            attributedCredit: DEFAULT_ATTRIBUTED_CREDIT,
          },
        } as unknown as ConversionExport;
        this.isDirty = false;

        ConversionExportStore.fetchGoals().then(() => {
          this.addInitialExportGoal();
        });

        this.showNote();
      }
    },
    cancel() {
      const newParams = { ...MatomoUrl.hashParsed.value };
      delete newParams.idExport;

      MatomoUrl.updateHash(newParams);
    },
    addInitialExportGoal() {
      if (!this.conversionExport) {
        return;
      }

      if (this.conversionExport.parameters?.goals?.length) {
        return;
      }

      this.addExportGoal();
    },
    addExportGoal() {
      if (!this.conversionExport) {
        return;
      }

      if (!this.conversionExport.parameters) {
        this.conversionExport.parameters = {};
      }

      if (!this.conversionExport.parameters.goals?.length) {
        this.conversionExport.parameters.goals = [];
      }

      this.conversionExport.parameters.goals = [
        ...this.conversionExport.parameters.goals,
        {
          idgoal: '',
          name: '',
          revenue: 'goal',
        },
      ];
      this.isDirty = true;
    },
    removeExportGoal(index: number) {
      if (this.conversionExport?.parameters?.goals?.length && index > -1) {
        this.conversionExport.parameters.goals.splice(index, 1);
        this.isDirty = true;
      }
    },
    regenerateAccessToken() {
      const { idExport } = this;
      if (!idExport) {
        return;
      }

      Matomo.helper.modalConfirm(this.$refs.confirmRegenerateAccessToken as HTMLElement, {
        yes: () => {
          ConversionExportStore.regenerateAccessToken(idExport).then((token) => {
            this.conversionExport.access_token = token.value;
          });
        },
      });
    },
    createExport() {
      const method = 'AdvertisingConversionExport.addConversionExport';
      this.removeAnyNotification();

      if (!this.checkRequiredFieldsAreSet()) {
        return;
      }

      ConversionExportStore.createOrUpdateExport(this.conversionExport, method).then((response) => {
        this.isDirty = false;
        const idExport = response.response!.value;
        ConversionExportStore.reload().then(() => {
          if (Matomo.helper.isReportingPage()) {
            Matomo.postEvent('updateReportingMenu');
          }

          MatomoUrl.updateHash({
            ...MatomoUrl.hashParsed.value,
            idExport,
          });

          setTimeout(() => {
            this.showNotification(
              translate('AdvertisingConversionExport_ExportCreated'),
              response.type as NotificationType['context'],
            );
          }, 200);
        });
      });
    },
    setValueHasChanged() {
      this.isDirty = true;

      if (this.conversionExport?.parameters?.goals?.length) {
        const configuredGoals: (string|number|null)[] = [];
        this.conversionExport.parameters.goals.forEach((goal) => {
          if (configuredGoals.indexOf(goal.idgoal) >= 0) {
            goal.idgoal = null;
          }

          if (goal.idgoal || goal.idgoal === 0) {
            configuredGoals.push(goal.idgoal);
          }
        });
      }
    },
    showNote() {
      this.showNoteMessage = false;
      this.noteMessage = '';
      if (
        this.conversionExport?.type
        && !this.alreadyCreatedExportTypes?.[this.conversionExport.type] // should be undefined
        && this.clickIdProviders?.[this.conversionExport.type] // should be defined
      ) {
        this.showNoteMessage = true;
        this.noteMessage = translate('AdvertisingConversionExport_ExportNoteMessage',
          this.clickIdProviders[this.conversionExport.type].clickId,
          this.clickIdProviders[this.conversionExport.type].name);
      }
    },
    updateExport() {
      this.removeAnyNotification();

      if (!this.checkRequiredFieldsAreSet()) {
        return;
      }

      const method = 'AdvertisingConversionExport.updateConversionExport';

      ConversionExportStore.createOrUpdateExport(this.conversionExport, method).then((response) => {
        if (response.type === 'error') {
          return;
        }

        this.isDirty = false;

        this.conversionExport = { parameters: {} } as unknown as ConversionExport;
        ConversionExportStore.reload().then(() => {
          this.init();
        });

        this.showNotification(
          translate('AdvertisingConversionExport_ExportUpdated'),
          response.type as NotificationType['context'],
        );
      });
    },
    checkRequiredFieldsAreSet() {
      if (!this.conversionExport.name) {
        const title = translate('General_Name');
        this.showErrorFieldNotProvidedNotification(title);
        return false;
      }

      if (!this.conversionExport.parameters?.goals?.length) {
        const title = translate('AdvertisingConversionExport_PleaseConfigureGoals');
        this.showNotification(title, 'error');
        return false;
      }

      const hasValidGoal = this.conversionExport.parameters.goals.some(
        (g) => g.idgoal !== '' && g.idgoal! >= 0,
      );

      if (!hasValidGoal) {
        const title = translate('AdvertisingConversionExport_PleaseConfigureGoals');
        this.showNotification(title, 'error');
        return false;
      }

      if (!this.conversionExport.parameters.daysToExport
          || this.conversionExport.parameters.daysToExport === 'NaN'
          || this.conversionExport.parameters.daysToExport < 1) {
        const title = translate('AdvertisingConversionExport_PleaseConfigureDaysToExport');
        this.showNotification(title, 'error');
        return false;
      }

      return true;
    },
  },
  computed: {
    revenueOptions() {
      return REVENUE_OPTIONS;
    },
    clickIdAttributionOptions() {
      return CLICK_ID_ATTRIBUTION_OPTIONS;
    },
    exportTypeOptions() {
      const result: Record<string, string> = {};
      Object.values(this.exportTypes as Record<string|number, ExportType>).forEach((e) => {
        result[e.id] = e.name;
      });
      return result;
    },
    exportTypeDescription() {
      return Object.values(this.exportTypes as Record<string|number, ExportType>).map(
        (e) => `<br/><br/><strong>${e.name}</strong><br />${e.description}`,
      ).join('');
    },
    attributionModelOptions() {
      const result: Record<string, string> = {};
      Object.values(this.attributionModels as Record<string|number,
        AttributionModel>).forEach((e) => {
        result[e.id] = e.translatedName;
      });
      return result;
    },
    create() {
      return !this.idExport;
    },
    edit() {
      return !this.create;
    },
    editTitle() {
      return this.create
        ? 'AdvertisingConversionExport_CreateNewExport'
        : 'AdvertisingConversionExport_EditExport';
    },
    contentTitle() {
      return translate(
        this.editTitle,
        this.conversionExport.name ? `"${this.conversionExport.name}"` : '',
      );
    },
    isLoading() {
      return ConversionExportStore.state.value.isLoading;
    },
    isUpdating() {
      return ConversionExportStore.state.value.isUpdating;
    },
    isLoadingGoals() {
      return ConversionExportStore.state.value.isLoadingGoals;
    },
    goals() {
      return ConversionExportStore.goals.value;
    },
    conversionExportHelp() {
      const help = translate('AdvertisingConversionExport_ExportTypeHelp');
      return `${help}${this.exportTypeDescription}`;
    },
    accessTokenInlineHelp() {
      const help = translate('AdvertisingConversionExport_AccessTokenHelp');
      const doNotShare = translate('AdvertisingConversionExport_DoNotShare');
      return `${help}<br />${doNotShare}`;
    },
    directAttributionHelp() {
      const desc = translate('AdvertisingConversionExport_DirectAttributionOnlyDescription');
      const onlyNote = translate('AdvertisingConversionExport_DirectAttributionOnlyNote');
      return `${desc}<br /><br />${onlyNote}`;
    },
    createButtonText() {
      return this.edit
        ? translate('CoreUpdater_UpdateTitle')
        : translate('AdvertisingConversionExport_CreateNewExport');
    },
  },
});
</script>
