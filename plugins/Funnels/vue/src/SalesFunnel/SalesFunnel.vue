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
    <SaveButton
      class="toggleEditSalesFunnel"
      :value="translate('Funnels_EditSalesFunnel')"
      :disabled="showEditForm"
      @confirm="showEditForm = !showEditForm"
      :saving="isLoading"
    >
    </SaveButton>
    <a
      class="btn"
      @click.prevent="openFunnelReport(idFunnel)"
      v-if="idFunnel"
      style="margin-left:3.5px"
    >
      <span class="icon-show" /> {{ translate('Funnels_ViewSalesFunnelReport') }}
    </a>
    <div v-show="showEditForm">
      <br /><br />
      <ManageFunnel
        :show-goal="0"
        :is-sales-funnel="true"
        :is-non-goal-funnel="true"
        :goals="goals"
      />
      <SaveButton
        class="saveSalesFunnel"
        @confirm="save()"
        :saving="isLoading"
      >
      </SaveButton>
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
import { defineComponent } from 'vue';
import {
  Matomo,
  AjaxHelper,
  MatomoUrl,
  AjaxOptions,
} from 'CoreHome';
import { SaveButton } from 'CorePluginsAdmin';
import ManageFunnel from '../ManageFunnel/ManageFunnel.vue';

interface SalesFunnelState {
  isLoading: boolean;
  showEditForm: boolean;
}

export default defineComponent({
  props: {
    idFunnel: {
      type: [String, Number],
      required: false,
      default: 0,
    },
    isFunnelEdit: {
      type: Boolean,
      required: false,
      default: false,
    },
    goals: {
      type: Array,
      required: true,
    },
  },
  components: {
    SaveButton,
    ManageFunnel,
  },
  data(): SalesFunnelState {
    return {
      isLoading: false,
      showEditForm: false,
    };
  },
  methods: {
    openFunnelReport(reportId: string|number) {
      MatomoUrl.updateHash({
        ...MatomoUrl.hashParsed.value,
        category: 'Funnels_Funnels',
        subcategory: reportId,
      });
    },
    save() {
      const parameters: QueryParameters = {
        method: 'Funnels.setGoalFunnel',
        idGoal: '0',
      };
      const options: AjaxOptions = {};

      Matomo.postEvent('Funnels.beforeUpdateSalesFunnel', { parameters, options });

      if (parameters && parameters.isLocked && this.$refs.funnelIsLockedCannotBeSaved) {
        Matomo.helper.modalConfirm(this.$refs.funnelIsLockedCannotBeSaved as HTMLElement, {});
        return;
      }

      if (parameters.cancelRequest) {
        return;
      }

      this.isLoading = true;
      AjaxHelper.fetch(parameters, options).then(() => {
        window.location.reload();
      }).catch(() => {
        this.isLoading = false;
      });
    },
  },
  mounted() {
    if (this.isFunnelEdit) {
      this.showEditForm = true;
    }
  },
});
</script>
