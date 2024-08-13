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
  <div class="manageSiteFunnels">
    <div class="addNewNoEdit" v-if="isAddNewView && !userCanEditFunnels">
      <ContentBlock :content-title="getEditFunnelHeader">
        <p>{{ translate('Funnels_AddNewUserUnableToEdit') }}</p>
      </ContentBlock>
    </div>
    <div class="listFunnels" v-show="showFunnelList && !isAddNewView">
      <ContentBlock :content-title="translate('Funnels_ManageFunnels')">
        <ActivityIndicator :loading="isLoading"/>

        <div class="contentHelp">
          {{ translate('Funnels_Introduction') }}
        </div>

        <table v-content-table>
          <thead>
          <tr>
            <th class="first">{{ translate('General_Id') }}</th>
            <th>{{ translate('Funnels_FunnelName') }}</th>
            <th>{{ translate('Goals_GoalConversion') }}</th>
            <th v-if="userCanEditFunnels">{{ translate('General_Actions') }}</th>
          </tr>
          </thead>
          <tbody>
          <tr v-if="!Object.keys(funnels || {}).length">
            <td colspan='4'>
              <br/>
              {{ translate('Funnels_ThereIsNoFunnelToManage', siteName) }}
              <br/><br/>
            </td>
          </tr>
          <tr v-for="funnel in funnels || []" :id="funnel.idfunnel" :key="funnel.idfunnel">
            <td class="first">{{ funnel.idfunnel }}</td>
            <td>{{ funnel.name }}</td>
            <td>
              <span v-if="(funnel.idgoal && Number(funnel.idgoal) !== 0) || funnel.isSalesFunnel"
                class="icon-ok system-success"
                :title="$sanitize(translate('Funnels_GoalCheckHover', funnel.name))"
              ></span>
              <span v-else>-</span>
            </td>

            <td v-if="userCanEditFunnels" style="padding-top:2px">
              <button
                v-if="userCanEditFunnels"
                @click="editFunnel(funnel.idfunnel)"
                class="table-action icon-edit"
                :title="translate('General_Edit')"
              ></button>
              <button
                v-if="userCanEditFunnels"
                @click="deleteFunnel(funnel.idfunnel)"
                class="table-action icon-delete"
                :title="translate('General_Delete')"
              ></button>
            </td>
          </tr>
          </tbody>
        </table>

        <div class="tableActionBar" v-if="userCanEditFunnels">
          <button id="addFunnel" @click="createFunnel()">
            <span class="icon-add"></span>
            {{ translate('Funnels_AddNewFunnel') }}
          </button>
        </div>
      </ContentBlock>
    </div>
    <div
      v-if="userCanEditFunnels"
      v-show="showEditFunnel || isAddNewView"
    >
      <ContentBlock :content-title="getEditFunnelHeader">
        <div v-form>
          <div>
            <Field
              uicontrol="text"
              name="funnelName"
              v-model="funnelName"
              :maxlength="50"
              :title="translate('Funnels_FunnelName')"
              :inline-help="translate('Funnels_FunnelNameHelp')"
            >
            </Field>
          </div>
          <ManageFunnel
            :is-non-goal-funnel="true"
            :show-goal="0"
            :is-hide-enable="true"
            :goals="goals"
          />
          <SaveButton
            :saving="isLoading"
            @confirm="save()"
            :value="getSubmitText"
            class="saveBtn"
          />
          <div
            class='entityCancel'
            @click="showListOfFunnels()"
            v-html="$sanitize(cancelText)"
            v-if="!isAddNewView"
          ></div>
        </div>
      </ContentBlock>
      <div class="ui-confirm" ref="confirm">
        <h2>{{ translate('Funnels_DeleteFunnelConfirm', `"${funnelToDelete?.name}"`) }}</h2>
        <input role="yes" type="button" :value="translate('General_Yes')"/>
        <input role="no" type="button" :value="translate('General_No')"/>
      </div>
      <div
        class="ui-confirm"
        ref="funnelIsLockedCannotBeSaved"
      >
        <h3>{{ translate('Funnels_FunnelIsLockedCannotBeSaved') }}</h3>
        <input
          role="yes"
          type="button"
          :value="translate('General_Ok')"
        />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {
  defineComponent, nextTick,
} from 'vue';
import {
  ActivityIndicator, AjaxHelper, AjaxOptions,
  ContentBlock,
  ContentTable,
  Matomo,
  MatomoUrl,
  ReportingMenuStore,
  translate,
} from 'CoreHome';
import {
  SaveButton,
  Form,
  Field,
} from 'CorePluginsAdmin';
import { Funnel } from '../types';
import { ManageFunnel } from '../index';

export default defineComponent({
  props: {
    userCanEditFunnels: Boolean,
    isAddNewView: {
      type: Boolean,
      default: false,
    },
    siteId: {
      type: Number,
      required: true,
    },
    siteName: {
      type: String,
      required: true,
    },
    funnels: {
      type: Object,
      required: true,
    },
    funnelId: {
      type: Number,
      required: false,
      default: 0,
    },
    goals: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      showEditFunnel: false,
      showFunnelList: true,
      isLoading: false,
      idFunnel: 0,
      funnelName: '',
      funnelToDelete: null,
    };
  },
  components: {
    Field,
    SaveButton,
    ContentBlock,
    ActivityIndicator,
    ManageFunnel,
  },
  directives: {
    ContentTable,
    Form,
  },
  methods: {
    scrollToTop() {
      setTimeout(() => {
        Matomo.helper.lazyScrollTo('.pageWrap', 200);
      });
    },
    editFunnel(idFunnel: number) {
      const funnelToEdit = this.funnels.find((funnel: Funnel) => Number(funnel.idfunnel)
        === Number(idFunnel));

      // If the funnel belongs to a goal, edit it using the goal edit form
      if (funnelToEdit.idgoal && funnelToEdit.idgoal !== '0') {
        MatomoUrl.updateHash({
          ...MatomoUrl.hashParsed.value,
          category: 'Goals_Goals',
          subcategory: 'Goals_ManageGoals',
          idGoal: funnelToEdit.idgoal,
          scrollToFunnel: 1,
        });
      }

      // If the funnel is a sales funnel, redirect to the Ecommerce section to edit
      if (funnelToEdit.isSalesFunnel) {
        MatomoUrl.updateHash({
          ...MatomoUrl.hashParsed.value,
          category: 'Goals_Ecommerce',
          subcategory: 'General_Overview',
          isFunnelEdit: true,
          scrollToFunnel: 1,
        });
      }

      Matomo.postEvent('Funnels.initFunnelForm', this.siteId, idFunnel);
      this.showFunnelList = false;
      this.showEditFunnel = true;
      this.idFunnel = idFunnel;
      this.funnelName = funnelToEdit.name;
    },
    deleteFunnel(idFunnel: number) {
      this.funnelToDelete = this.funnels.find((funnel: Funnel) => funnel.idfunnel === idFunnel);
      Matomo.helper.modalConfirm((this.$refs.confirm as HTMLElement), {
        yes: () => {
          this.isLoading = true;

          AjaxHelper.fetch({
            idSite: this.siteId,
            idFunnel,
            method: 'Funnels.deleteNonGoalFunnel',
          }).then(() => {
            window.location.reload();
          }).finally(() => {
            this.isLoading = false;
          });
        },
      });
    },
    createFunnel() {
      // Clear the funnel form and display it
      this.idFunnel = 0;
      this.funnelName = '';
      // Use this hook to reset the funnel fields
      Matomo.postEvent('Funnels.resetForm', {});
      this.showFunnelList = false;
      this.showEditFunnel = true;
    },
    showListOfFunnels() {
      this.showFunnelList = true;
      this.showEditFunnel = false;
      this.scrollToTop();
    },
    save() {
      const parameters: QueryParameters = {
        method: 'Funnels.saveNonGoalFunnel',
        idFunnel: this.idFunnel,
        funnelName: this.funnelName,
      };
      const options: AjaxOptions = {};

      // Use this hook to get the formatted funnel fields
      Matomo.postEvent('Funnels.beforeUpdateFunnel', { parameters, options });

      if (parameters && parameters.isLocked && this.$refs.funnelIsLockedCannotBeSaved) {
        Matomo.helper.modalConfirm(this.$refs.funnelIsLockedCannotBeSaved as HTMLElement, {});
        return;
      }

      if (parameters.cancelRequest) {
        return;
      }

      AjaxHelper.fetch(parameters, options).then(() => {
        const subcategory = MatomoUrl.parsed.value.subcategory as string;
        if (subcategory === 'Funnels_AddNewFunnel'
          && Matomo.helper.isReportingPage()
        ) {
          // When adding a funnel for the first time we need to load manage funnels page afterward
          ReportingMenuStore.reloadMenuItems().then(() => {
            MatomoUrl.updateHash({
              ...MatomoUrl.hashParsed.value,
              subcategory: 'Funnels_ManageFunnels',
            });

            this.isLoading = false;
          });
        } else {
          window.location.reload();
        }
      }).catch(() => {
        this.scrollToTop();
        this.isLoading = false;
      });
    },
  },
  computed: {
    getEditFunnelHeader() {
      if (this.idFunnel === 0) {
        return translate('Funnels_AddNewFunnel');
      }

      return translate('Funnels_UpdateFunnel');
    },
    getSubmitText() {
      if (this.idFunnel === 0) {
        return translate('Funnels_AddFunnel');
      }

      return translate('Funnels_UpdateFunnel');
    },
    cancelText() {
      return translate(
        'General_OrCancel',
        '<a class=\'entityCancelLink\'>',
        '</a>',
      );
    },
  },
  mounted() {
    if (this.funnelId > 0) {
      nextTick(() => {
        this.editFunnel(this.funnelId);
      });
    }
  },
});
</script>
