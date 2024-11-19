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
    class="editReport"
    :content-title="contentTitle"
  >
    <p v-show="isLoading">
      <span class="loadingPiwik"><img src="plugins/Morpheus/images/loading-blue.gif" />
        {{ translate('General_LoadingData') }}</span>
    </p>
    <p v-show="isUpdating">
      <span class="loadingPiwik"><img src="plugins/Morpheus/images/loading-blue.gif" />
        {{ translate('CustomReports_UpdatingData') }}</span>
    </p>
    <div
      class="alert alert-danger"
      v-show="!canEdit"
    >
      {{ translate('CustomReports_ReportEditNotAllowedAllWebsites') }}
    </div>
    <form @submit="edit ? updateReport() : createReport()">
      <div>
        <div name="name">
          <Field
            uicontrol="text"
            name="name"
            :model-value="report.name"
            @update:model-value="report.name = $event; setValueHasChanged()"
            :title="translate('General_Name')"
            :maxlength="50"
            :disabled="!canEdit"
            :placeholder="translate('CustomReports_FieldNamePlaceholder')"
            :inline-help="translate('CustomReports_ReportNameHelp')"
          >
          </Field>
        </div>
        <div name="description">
          <Field
            uicontrol="textarea"
            name="description"
            :model-value="report.description"
            @update:model-value="report.description = $event; setValueHasChanged()"
            :title="`${translate('General_Description')} (optional)`"
            :maxlength="1000"
            :disabled="!canEdit"
            :rows="3"
            :placeholder="translate('CustomReports_FieldDescriptionPlaceholder')"
            :inline-help="translate('CustomReports_ReportDescriptionHelp')"
          >
          </Field>
        </div>
        <div class="form-group row">
          <h3 class="col s12">{{ translate('CustomReports_ApplyTo') }}</h3>
          <div class="col s12 m6">
            <div>
              <label
                for="all_websites"
                class="siteSelectorLabel"
              >{{ translate('General_Website') }}</label>
              <div class="sites_autocomplete">
                <SiteSelector
                  id="all_websites"
                  :model-value="report.site"
                  @update:model-value="report.site = $event; setWebsiteChanged()"
                  :show-all-sites-item="isSuperUser"
                  :switch-site-on-select="false"
                  :show-selected-site="true"
                />
              </div>
            </div>
          </div>
          <div class="col s12 m6">
            <div class="form-help">
              <span class="inline-help">
                {{ translate('CustomReports_ReportAllWebsitesHelp') }}
              </span>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <h3 class="col s12">{{ translate('CustomReports_ReportContent') }}</h3>
        </div>
        <div
          class="unlockAlert alert alert-info"
          v-show="isLocked"
        >
          <span v-if="browserArchivingDisabled && reArchiveLastN">
            {{ translate('CustomReports_WarningRequiresUnlockBrowserArchivingDisabled',
              reArchiveLastN) }}
          </span>
          <span v-if="!browserArchivingDisabled || !reArchiveLastN">
            {{ translate('CustomReports_WarningRequiresUnlock') }}
          </span>
          <br />
          <br />
          <input
            type="button"
            class="btn unlockReport"
            @click="unlockReport()"
            :value="translate('CustomReports_Unlock')"
          />
        </div>
        <div
          class="alertUnlocked alert alert-warning"
          v-show="isUnlocked"
        >
          <span v-if="browserArchivingDisabled && reArchiveLastN">
            {{ translate(
              'CustomReports_WarningOnUpdateReportMightGetLostBrowserArchivingDisabled',
              reArchiveLastN,
            ) }}
          </span>
          <span v-if="!browserArchivingDisabled || !reArchiveLastN">
            {{ translate('CustomReports_WarningOnUpdateReportMightGetLost') }}
          </span>
        </div>
        <div name="reportType">
          <Field
            uicontrol="radio"
            name="reportType"
            :model-value="report.report_type"
            @update:model-value="setReportTypeHasChanged($event)"
            :title="translate('CustomReports_ReportType')"
            :disabled="!canEdit"
            :options="reportTypes"
          >
          </Field>
        </div>
        <div
          class="form-group row"
          v-show="report.report_type !== 'evolution'"
        >
          <div class="col s12 m6 dimensionsGroup">
            <label>{{ translate('CustomReports_Dimensions') }}</label><br />
            <div>
              <div
                :class="`selectedDimension selectedDimension${dimIndex}`"
                v-for="(dimension, dimIndex) in report.dimensions"
                :key="dimIndex"
              >
                <div class="groupValueSelect" name="dimensions">
                  <Field
                    uicontrol="expandable-select"
                    name="dimensions"
                    :model-value="dimension"
                    @update:model-value="changeDimension($event, dimIndex)"
                    :title="dimensionsReadable[dimension] || dimension"
                    :full-width="true"
                    :options="dimensions"
                  >
                  </Field>
                </div>
                <span
                  class="icon-minus"
                  :title="translate('CustomReports_RemoveDimension')"
                  @click="removeDimension(dimIndex)"
                />
              </div>
              <div
                class="groupValueSelect addDimension"
                name="dimensions"
                v-show="report.dimensions.length <= 2"
              >
                <Field
                  uicontrol="expandable-select"
                  name="dimensions"
                  :model-value="''"
                  @update:model-value="addDimension($event);"
                  :title="translate('CustomReports_AddDimension')"
                  :full-width="true"
                  :options="dimensions"
                >
                </Field>
              </div>
            </div>
          </div>
          <div class="col s12 m6">
            <div class="form-help">
              <span class="inline-help">{{ translate('CustomReports_ReportDimensionsHelp') }}</span>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <div class="col s12 m6 metricsGroup">
            <label>{{ translate('General_Metrics') }}</label><br />
            <div>
              <div
                :class="`selectedMetric selectedMetric${metricIndex}`"
                v-for="(metric, metricIndex) in report.metrics"
                :key="metricIndex"
              >
                <div class="groupValueSelect" name="metrics">
                  <Field
                    uicontrol="expandable-select"
                    name="metrics"
                    :model-value="metric"
                    @update:model-value="changeMetric($event, metricIndex)"
                    :title="metricsReadable[metric] || metric"
                    :full-width="true"
                    :options="metrics"
                  >
                  </Field>
                </div>
                <span
                  class="icon-minus"
                  :title="translate('CustomReports_RemoveMetric')"
                  @click="removeMetric(metricIndex)"
                />
              </div>
              <div class="groupValueSelect addMetric" name="metrics">
                <Field
                  uicontrol="expandable-select"
                  name="metrics"
                  :model-value="''"
                  @update:model-value="addMetric($event);"
                  :title="translate('CustomReports_AddMetric')"
                  :full-width="true"
                  :options="metrics"
                >
                </Field>
              </div>
            </div>
          </div>
          <div class="col s12 m6">
            <div class="form-help">
              <span class="inline-help">{{ translate('CustomReports_ReportMetricsHelp') }}</span>
            </div>
          </div>
        </div>
        <div
          v-show="dependencyAdded"
          class="alert alert-warning"
          v-html="getProductRevenueDependencyMessage">
        </div>
        <div class="form-group row segmentFilterGroup">
          <div class="col s12">
            <div>
              <label style="margin: 8px 0;display: inline-block;">
                {{ translate('CustomReports_Filter') }}
              </label>
              <p>{{ translate('CustomReports_ReportSegmentHelp') }}</p>
              <div>
                <SegmentGenerator
                  :model-value="report.segment_filter"
                  @update:model-value="setSegmentFilterHasChanged($event)"
                  :idsite="report.site.id"
                />
              </div>
            </div>
          </div>
        </div>
        <div
          class="form-group row"
          v-show="report.report_type === 'table'"
        >
          <div class="col s12">
            <br /><br />
            <SaveButton
              class="showPreviewButton"
              :disabled="!report.metrics?.length || !report.dimensions?.length"
              @confirm="showPreview()"
              :value="translate('CustomReports_PreviewReport')"
            >
            </SaveButton>
          </div>
        </div>
        <div name="reportCategories">
          <Field
            uicontrol="select"
            name="reportCategories"
            :model-value="report.category.id"
            @update:model-value="report.category.id = $event; setValueHasChanged()"
            :title="translate('CustomReports_ReportCategory')"
            :disabled="!canEdit"
            :options="categories"
            :introduction="translate('CustomReports_ReportPage')"
            :inline-help="translate('CustomReports_ReportCategoryHelp')"
          >
          </Field>
        </div>
        <div name="reportSubcategories">
          <Field
            uicontrol="select"
            name="reportSubcategories"
            :model-value="report.subcategory?.id"
            @update:model-value="setSubcategory($event); setValueHasChanged()"
            :title="translate('CustomReports_ReportSubcategory')"
            :disabled="!canEdit"
            :options="subcategories[report.category.id]"
            :inline-help="translate('CustomReports_ReportSubcategoryHelp')"
          >
          </Field>
        </div>
        <div
          class="alert alert-warning"
          v-show="isUnlocked"
        >
          <span
            v-if="browserArchivingDisabled && reArchiveLastN">
            {{ translate(
              'CustomReports_WarningOnUpdateReportMightGetLostBrowserArchivingDisabled',
              reArchiveLastN,
            ) }}
          </span>
          <span v-if="!browserArchivingDisabled || !reArchiveLastN">
            {{ translate('CustomReports_WarningOnUpdateReportMightGetLost') }}
          </span>
        </div>
        <div
          class="alert alert-danger"
          v-show="!canEdit"
        >
          {{ translate('CustomReports_ReportEditNotAllowedAllWebsites') }}
        </div>
        <div class="form-group row" v-if="childReports.length">
          <h3 class="col s12"
              v-text="translate('CustomReports_OrderSubCategoryReports')"></h3>
          <div class="col s12 m6">
            <ul id="childReports" class="col s12 m6">
              <li v-for="childReport in childReports"
                  :key="childReport.idcustomreport"
                  :data-id="childReport.idcustomreport"
              >
                <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{ childReport.name }}
              </li>
            </ul>
          </div>
          <div class="col s12 m6">
            <div class="form-help">
              <div
                class="form-description"
                v-text="translate('CustomReports_OrderSubCategoryReportsDescription')">
              </div>
            </div>
          </div>
        </div>
        <SaveButton
          class="createButton"
          v-show="canEdit"
          @confirm="edit ? updateReport() : createReport()"
          :disabled="isUpdating || !isDirty"
          :saving="isUpdating"
          :value="saveButtonText"
        >
        </SaveButton>
        <div class="entityCancel">
          <a @click="cancel()">{{ translate('General_Cancel') }}</a>
        </div>
      </div>
    </form>
    <div
      class="ui-confirm"
      id="confirmUnlockReport"
      ref="confirmUnlockReport"
    >
      <h2 v-if="browserArchivingDisabled && reArchiveLastN">
        {{ translate('CustomReports_ConfirmUnlockReportBrowserArchivingDisabled', reArchiveLastN) }}
      </h2>
      <h2 v-if="!browserArchivingDisabled || !reArchiveLastN">
        {{ translate('CustomReports_ConfirmUnlockReport') }}</h2>
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
    <div
      class="ui-confirm"
      id="infoReportIsLocked"
      ref="infoReportIsLocked"
    >
      <h2 v-if="browserArchivingDisabled && reArchiveLastN">
        {{ translate('CustomReports_InfoReportIsLockedBrowserArchivingDisabled', reArchiveLastN) }}
      </h2>
      <h2 v-if="!browserArchivingDisabled || !reArchiveLastN">
        {{ translate('CustomReports_InfoReportIsLocked') }}
      </h2>
      <input
        role="unlock"
        type="button"
        :value="translate('CustomReports_Unlock')"
      />
      <input
        role="ok"
        type="button"
        :value="translate('General_Cancel')"
      />
    </div>
  </ContentBlock>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import {
  Matomo,
  translate,
  ContentBlock,
  SiteSelector,
  NotificationsStore,
  NotificationType,
  clone,
  MatomoUrl, externalLink,
} from 'CoreHome';
import { Field, SaveButton } from 'CorePluginsAdmin';
import { SegmentGenerator } from 'SegmentEditor';
import CustomReportsStore from '../CustomReports.store';
import { CustomReport, ChildReport } from '../types';

interface ReportEditState {
  isDirty: boolean;
  report: CustomReport;
  isLocked: boolean;
  isUnlocked: boolean;
  canEdit: boolean;
  dependencyAdded: boolean;
  childReports: ChildReport[];
  childReportIds: Array<string|number>;
}

const notificationId = 'reportsmanagement';
const productMetricNotificationId = 'reportsmanagementProductMetric';

function arrayFilterAndRemoveDuplicates<T>(values: T[]) {
  return [...new Set(values)].filter((v) => !!v);
}

function makeDefaultReport() {
  return {
    dimensions: [],
    site: {
      id: Matomo.idSite,
      name: Matomo.currentSiteName,
    },
    category: {},
  } as unknown as CustomReport;
}

export default defineComponent({
  props: {
    idCustomReport: Number,
    browserArchivingDisabled: Boolean,
    reArchiveLastN: Number,
  },
  components: {
    ContentBlock,
    Field,
    SiteSelector,
    SegmentGenerator,
    SaveButton,
  },
  data(): ReportEditState {
    return {
      isDirty: false,
      report: makeDefaultReport(),
      isLocked: false,
      isUnlocked: false,
      canEdit: true,
      dependencyAdded: false,
      childReports: [],
      childReportIds: [],
    };
  },
  created() {
    CustomReportsStore.getAvailableReportTypes();

    this.init();
  },
  watch: {
    idCustomReport(newValue) {
      if (newValue === null) {
        return;
      }

      this.init();
    },
  },
  methods: {
    initReportOptions() {
      const idsite = parseInt(`${this.report.site.id}`, 10) || 'all';

      CustomReportsStore.getAvailableDimensions(idsite);
      CustomReportsStore.getAvailableMetrics(idsite);
      CustomReportsStore.getAvailableCategories(idsite);
    },
    doUnlock() {
      this.isLocked = false;
      this.isUnlocked = true;
    },
    confirmReportIsLocked(callback: () => void) {
      Matomo.helper.modalConfirm(this.$refs.infoReportIsLocked as HTMLElement, {
        unlock: () => {
          this.doUnlock();

          if (callback) {
            callback();
          }
        },
      });
    },
    removeAnyReportNotification() {
      NotificationsStore.remove(notificationId);
      NotificationsStore.remove(productMetricNotificationId);
      NotificationsStore.remove('ajaxHelper');
    },
    showNotification(message: string, context: NotificationType['context']) {
      const instanceId = NotificationsStore.show({
        message,
        context,
        id: notificationId,
        type: 'transient',
        prepend: true,
      });
      setTimeout(() => {
        NotificationsStore.scrollToNotification(instanceId);
      }, 100);
    },
    showProductMetricNotification(message: string, shouldScrollToNotification: boolean) {
      const instanceId = NotificationsStore.show({
        message,
        context: 'warning',
        id: productMetricNotificationId,
        type: 'transient',
      });

      if (!shouldScrollToNotification) {
        return;
      }

      setTimeout(() => {
        NotificationsStore.scrollToNotification(instanceId);
      }, 100);
    },
    showErrorFieldNotProvidedNotification(title: string) {
      const message = translate('CustomReports_ErrorXNotProvided', [title]);
      this.showNotification(message, 'error');
    },
    init() {
      const { idCustomReport } = this;

      this.canEdit = true;
      this.report = makeDefaultReport();
      Matomo.helper.lazyScrollToContent();

      if (this.edit && idCustomReport) {
        CustomReportsStore.findReport(idCustomReport, true).then((report) => {
          if (!report) {
            return;
          }

          this.report = clone(report) as CustomReport;
          this.isLocked = true;
          this.isUnlocked = false;
          this.canEdit = true;
          this.childReports = this.report.child_reports ?? [];
          if (this.childReports.length) {
            Object.values((this.childReports) as ChildReport[]).forEach((value) => {
              this.childReportIds.push(value.idcustomreport);
            });
          }
          $(document).ready(() => {
            $('#childReports').sortable({
              connectWith: '#childReports',
              update: () => {
                this.isDirty = true;
                const childReportsListItems = $('#childReports li');
                this.childReportIds = [];
                childReportsListItems.each((idx, li) => {
                  if (li.dataset.id) {
                    this.childReportIds.push(li.dataset.id);
                  }
                });
              },
            });
          });

          let idSite = this.report.idsite;
          if (idSite === 0 || idSite === '0' || idSite === 'all') {
            // we need to make sure to send 'all' and not '0' as otherwise piwikApi would
            // consider 0 as no value set and replace it with the current idsite. Also the
            // site selector expects us to set 'all' instead of 0
            idSite = 'all';

            if (!this.isSuperUser) {
              // a lock does not make sense because report cannot be changed anyway. we do not want
              // to show a warning related to this in such a case
              this.canEdit = false;
              this.isLocked = false;
            }
          }

          this.report.site = {
            id: idSite,
            name: this.report.site.name,
          };
          this.isDirty = false;
          this.initReportOptions();
        });
        return;
      }

      if (this.create) {
        this.report = {
          idsite: Matomo.idSite,
          site: {
            id: Matomo.idSite,
            name: Matomo.currentSiteName || Matomo.siteName,
          },
          name: '',
          description: '',
          dimensions: [],
          metrics: ['nb_visits'],
          report_type: 'table',
          category: {
            id: 'CustomReports_CustomReports',
          },
          subcategory: null,
          segment_filter: '',
          child_reports: [],
        } as unknown as CustomReport;
        this.isLocked = false;
        this.canEdit = true;
        this.isDirty = false;
        this.initReportOptions();
      }
    },
    cancel() {
      const newParams = { ...MatomoUrl.hashParsed.value };
      delete newParams.idCustomReport;

      MatomoUrl.updateHash(newParams);
    },
    unlockReport() {
      if (!this.report) {
        return;
      }

      if (this.isLocked) {
        Matomo.helper.modalConfirm(this.$refs.confirmUnlockReport as HTMLElement, {
          yes: () => {
            this.doUnlock();
          },
        });
      }
    },
    createReport() {
      const method = 'CustomReports.addCustomReport';
      this.removeAnyReportNotification();

      if (!this.checkRequiredFieldsAreSet()) {
        return;
      }

      CustomReportsStore.createOrUpdateReport(
        this.report,
        method,
        this.childReportIds,
      ).then((response) => {
        if (!response || response.type === 'error' || !response.response) {
          return;
        }

        this.isDirty = false;

        const idCustomReport = response.response.value;

        if (this.report.site) {
          const idSite = this.report.site.id;
          if (idSite && idSite !== 'all' && `${idSite}` !== `${Matomo.idSite}`) {
            // when creating a report for a different site...
            // we need to reload this page for a different idsite, otherwise the report won't
            // be found
            MatomoUrl.updateUrl(
              {
                ...MatomoUrl.urlParsed.value,
                idSite,
              },
              {
                ...MatomoUrl.hashParsed.value,
                idCustomReport,
              },
            );
            return;
          }
        }

        CustomReportsStore.reload().then(() => {
          if (Matomo.helper.isReportingPage()) {
            Matomo.postEvent('updateReportingMenu');
          }

          MatomoUrl.updateHash({
            ...MatomoUrl.hashParsed.value,
            idCustomReport,
          });

          setTimeout(() => {
            this.showNotification(
              translate('CustomReports_ReportCreated'),
              response.type as NotificationType['context'],
            );
          }, 200);
        });
      });
    },
    showPreview() {
      if (!this.isProductRevenueDependencyMet(true)) {
        return;
      }

      const idSite = this.report.site?.id && this.report.site.id !== 'all'
        ? this.report.site.id
        : Matomo.idSite;

      const hasDimensions = this.report.dimensions?.length
        && this.report.report_type
        && this.report.report_type !== 'evolution';
      const dimensions = hasDimensions ? this.report.dimensions.join(',') : undefined;

      const hasMetrics = !!this.report.metrics?.length;
      const metrics = hasMetrics ? this.report.metrics.join(',') : undefined;

      const url = MatomoUrl.stringify({
        module: 'CustomReports',
        action: 'previewReport',
        period: 'day',
        date: 'today',
        idSite,
        report_type: this.report.report_type,
        dimensions,
        metrics,
        segment: this.report.segment_filter || undefined,
      });

      const title = translate('CustomReports_Preview');
      window.Piwik_Popover.createPopupAndLoadUrl(url, title, 'customReportPreview');
    },
    setValueHasChanged() {
      this.isDirty = true;
    },
    addDimension(dimension: string) {
      if (!this.report || !dimension) {
        return;
      }

      if (this.isLocked) {
        this.confirmReportIsLocked(() => {
          this.addDimension(dimension);
        });
        return;
      }

      if (!this.report.dimensions) {
        this.report.dimensions = [];
      }

      this.report.dimensions = [
        ...this.report.dimensions,
        dimension,
      ];
      this.setValueHasChanged();
    },
    changeDimension(dimension: string, index: number) {
      if (!this.report || !dimension) {
        return;
      }

      if (this.isLocked) {
        this.confirmReportIsLocked(() => {
          this.changeDimension(dimension, index);
        });
        return;
      }

      if (!this.report.dimensions?.[index]) {
        return;
      }

      this.report.dimensions = [...this.report.dimensions];
      this.report.dimensions[index] = dimension;
      this.setValueHasChanged();
    },
    changeMetric(metric: string, index: number) {
      this.dependencyAdded = false;

      if (!this.report || !metric) {
        return;
      }

      if (this.isLocked) {
        this.confirmReportIsLocked(() => {
          this.changeMetric(metric, index);
        });
        return;
      }

      if (!this.report.metrics?.[index]) {
        return;
      }

      this.report.metrics = [...this.report.metrics];
      this.report.metrics[index] = metric;
      this.setValueHasChanged();
      this.addMetricIfMissingDependency(metric);
    },
    setWebsiteChanged() {
      this.setValueHasChanged();
      this.initReportOptions();
    },
    removeDimension(index: number) {
      if (this.isLocked) {
        this.confirmReportIsLocked(() => {
          this.removeDimension(index);
        });
        return;
      }

      if (index > -1) {
        this.report.dimensions = [...this.report.dimensions];
        this.report.dimensions.splice(index, 1);
        this.setValueHasChanged();
      }
    },
    addMetric(metric: string) {
      this.dependencyAdded = false;

      if (!this.report || !metric) {
        return;
      }

      if (!this.report.metrics) {
        this.report.metrics = [];
      }

      if (this.isLocked) {
        this.confirmReportIsLocked(() => {
          this.addMetric(metric);
        });
        return;
      }

      this.report.metrics = [
        ...this.report.metrics,
        metric,
      ];
      this.setValueHasChanged();
      this.addMetricIfMissingDependency(metric);
    },
    addMetricIfMissingDependency(metric: string) {
      // If the metric isn't Product Revenue or the dependency is already met, return
      if (!['sum_product_revenue', 'avg_product_revenue'].includes(metric)
        || this.doesReportIncludeProductQuantityMetric()) {
        return;
      }

      const dependency = metric === 'avg_product_revenue' ? 'avg_ecommerce_productquantity'
        : 'sum_ecommerce_productquantity';

      this.addMetric(dependency);
      this.dependencyAdded = true;
    },
    removeMetric(index: number) {
      this.dependencyAdded = false;

      if (this.isLocked) {
        this.confirmReportIsLocked(() => {
          this.removeMetric(index);
        });
        return;
      }

      if (index > -1) {
        this.report.metrics = [...this.report.metrics];
        this.report.metrics.splice(index, 1);
        this.setValueHasChanged();
      }
    },
    setReportTypeHasChanged(newReportType: string) {
      if (this.report && this.isLocked) {
        if (newReportType !== this.report.report_type) {
          this.confirmReportIsLocked(() => {
            this.report.report_type = newReportType;
            this.setValueHasChanged();
          });
        }
      } else {
        this.report.report_type = newReportType;
        this.setValueHasChanged();
      }
    },
    setSegmentFilterHasChanged(newSegmentFilter: string) {
      if (this.report && this.isLocked) {
        if (newSegmentFilter !== this.report.segment_filter) {
          this.confirmReportIsLocked(() => {
            this.report.segment_filter = newSegmentFilter;
            this.setValueHasChanged();
          });
        }
      } else {
        this.report.segment_filter = newSegmentFilter;
        this.setValueHasChanged();
      }
    },
    updateReport() {
      this.removeAnyReportNotification();

      if (!this.checkRequiredFieldsAreSet()) {
        return;
      }

      const method = 'CustomReports.updateCustomReport';
      CustomReportsStore.createOrUpdateReport(
        this.report,
        method,
        this.childReportIds,
      ).then((response) => {
        if (!response || response.type === 'error') {
          return;
        }

        const idSite = this.report.site.id;
        this.isDirty = false;
        this.canEdit = true;

        if (idSite && idSite !== 'all' && `${idSite}` !== `${Matomo.idSite}`) {
          // when moving a report from one site to another...
          // we need to reload this page for a different idsite, otherwise the report won't be found
          MatomoUrl.updateUrl({
            ...MatomoUrl.urlParsed.value,
            idSite,
          }, {
            ...MatomoUrl.hashParsed.value,
          });
          return;
        }

        CustomReportsStore.reload().then(() => {
          this.init();
        });

        this.showNotification(
          translate('CustomReports_ReportUpdated'),
          response.type as NotificationType['context'],
        );
      });
    },
    checkRequiredFieldsAreSet() {
      if (!this.report.name) {
        const title = translate('General_Name');
        this.showErrorFieldNotProvidedNotification(title);
        return false;
      }

      if (this.report.report_type !== 'evolution') {
        if (!this.report.dimensions?.length
          || !arrayFilterAndRemoveDuplicates(this.report.dimensions).length
        ) {
          const title = translate('CustomReports_ErrorMissingDimension');
          this.showNotification(title, 'error');
          return false;
        }
      }

      if (!this.report.metrics?.length
        || !arrayFilterAndRemoveDuplicates(this.report.metrics).length
      ) {
        const title = translate('CustomReports_ErrorMissingMetric');
        this.showNotification(title, 'error');
        return false;
      }

      // Don't fail validation since we automatically add the dependency
      this.isProductRevenueDependencyMet(false);

      return true;
    },
    setSubcategory(subcategoryId: string) {
      this.report.subcategory = this.report.subcategory || { id: '' };
      this.report.subcategory.id = subcategoryId;
    },
    isProductRevenueDependencyMet(shouldScrollToNotification: boolean): boolean {
      const linkString = externalLink('https://matomo.org/faq/custom-reports/why-is-there-an-error-when-i-try-to-run-a-custom-report-with-the-product-revenue-metric/');
      const notificationText = translate('CustomReports_WarningProductRevenueMetricDependency', linkString, '</a>');

      if (this.report.metrics.includes('sum_product_revenue')
        && !this.doesReportIncludeProductQuantityMetric()) {
        this.addMetric('sum_ecommerce_productquantity');
        this.showProductMetricNotification(notificationText, shouldScrollToNotification);
        return false;
      }

      if (this.report.metrics.includes('avg_product_revenue')
        && !this.doesReportIncludeProductQuantityMetric()) {
        this.addMetric('avg_ecommerce_productquantity');
        this.showProductMetricNotification(notificationText, shouldScrollToNotification);
        return false;
      }

      return true;
    },
    doesReportIncludeProductQuantityMetric(): boolean {
      return this.report.metrics.includes('sum_ecommerce_productquantity')
        || this.report.metrics.includes('avg_ecommerce_productquantity');
    },
  },
  computed: {
    isSuperUser() {
      return !!Matomo.hasSuperUserAccess;
    },
    allMetrics() {
      return CustomReportsStore.state.value.allMetrics;
    },
    metrics() {
      // if any of the page generation times in the report is used than allow all of them
      // otherwise don't show any of thme.
      const pageGenerationMetrics = [
        'pageviews_with_generation_time',
        'avg_page_generation_time',
        'max_actions_pagegenerationtime',
        'sum_actions_pagegenerationtime',
      ];

      const hasPageGenerationMetric = (this.report?.metrics || []).some(
        (m) => pageGenerationMetrics.indexOf(m) >= 0,
      );

      const shouldRemoveGenerationTime = !hasPageGenerationMetric;

      return this.allMetrics.filter((m) => {
        if (!m) {
          return false;
        }

        if (shouldRemoveGenerationTime && pageGenerationMetrics.indexOf(m.key) >= 0) {
          return false;
        }

        return true;
      });
    },
    allDimensions() {
      return CustomReportsStore.state.value.allDimensions;
    },
    reportTypes() {
      return CustomReportsStore.state.value.reportTypesReadable;
    },
    create() {
      return !this.idCustomReport;
    },
    edit() {
      return !this.create;
    },
    editTitle() {
      return this.create ? 'CustomReports_CreateNewReport' : 'CustomReports_EditReport';
    },
    contentTitle() {
      return translate(this.editTitle, this.report.name ? `"${this.report.name}"` : '');
    },
    categories() {
      return CustomReportsStore.state.value.categories;
    },
    subcategories() {
      return CustomReportsStore.state.value.subcategories;
    },
    dimensions() {
      const result = [...this.allDimensions];

      if (!this.report?.dimensions) {
        return result;
      }

      const hasPageGenerationDimension = this.report.dimensions.indexOf(
        'Actions.PageGenerationTime',
      ) !== -1;

      // we do not allow to select eg grouping by "Page URL, Clicked URL" as it wouldn't show any
      // data
      const usedSqlSegments = this.report.dimensions.map(
        (dimensionId) => result.find((dim) => dim.key === dimensionId)?.sqlSegment,
      ).filter((sqlSegment) => !!sqlSegment);

      // make sure these dimensions cannot be selected a second time
      for (let j = 0; j < result.length; j += 1) {
        const dim = result[j];

        if (!hasPageGenerationDimension && dim.key === 'Actions.PageGenerationTime') {
          // we only show this metric if it was used before already in the report
          result.splice(j, 1);
          j -= 1;
          break;
        }

        if (dim.sqlSegment
          && usedSqlSegments.indexOf(dim.sqlSegment) > -1
          && this.report.dimensions.indexOf(dim.key) === -1
        ) {
          // we want to make sure to not show incompatible dimensions but we still want to show an
          // already selected dimension again so users can eg easily swap dimensions etc.
          result.splice(j, 1);
          j -= 1;
        }
      }

      return result;
    },
    isLoading() {
      return CustomReportsStore.state.value.isLoading;
    },
    isUpdating() {
      return CustomReportsStore.state.value.isUpdating;
    },
    dimensionsReadable() {
      return CustomReportsStore.state.value.dimensionsReadable;
    },
    metricsReadable() {
      return CustomReportsStore.state.value.metricsReadable;
    },
    saveButtonText() {
      return this.edit
        ? translate('CoreUpdater_UpdateTitle')
        : translate('CustomReports_CreateNewReport');
    },
    getProductRevenueDependencyMessage() {
      const linkString = externalLink('https://matomo.org/faq/custom-reports/why-is-there-an-error-when-i-try-to-run-a-custom-report-with-the-product-revenue-metric/');
      return translate('CustomReports_WarningProductRevenueMetricDependency', linkString, '</a>');
    },
  },
});
</script>
