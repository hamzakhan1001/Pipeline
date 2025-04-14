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
  <div class="manageConversionExport">
    <div v-if="!editMode">
      <ConversionExportList
        :export-types="exportTypes"
        :already-created-export-types="alreadyCreatedExportTypes"
        :click-id-providers="clickIdProviders"
        :attribution-models="attributionModels"
        :has-write-access="hasWriteAccess"
      />
    </div>
    <div v-if="editMode">
      <ConversionExportEdit
        :id-export="idExport"
        :export-types="exportTypes"
        :already-created-export-types="alreadyCreatedExportTypes"
        :click-id-providers="clickIdProviders"
        :attribution-models="attributionModels"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, watch } from 'vue';
import {
  Matomo,
  NotificationsStore,
  MatomoUrl,
} from 'CoreHome';
import ConversionExportList from './List.vue';
import ConversionExportEdit from './Edit.vue';

interface ConversionExportManageState {
  editMode: boolean;
  idExport: null|number;
}

export default defineComponent({
  props: {
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
    hasWriteAccess: Boolean,
  },
  components: {
    ConversionExportEdit,
    ConversionExportList,
  },
  data(): ConversionExportManageState {
    return {
      editMode: false,
      idExport: null,
    };
  },
  created() {
    // doing this in a watch because we don't want to post an event in a computed property
    watch(() => MatomoUrl.hashParsed.value.idExport as string, (idExport) => {
      this.initState(idExport);
    });

    this.initState(MatomoUrl.hashParsed.value.idExport as string);
  },
  methods: {
    removeAnyNotification() {
      NotificationsStore.remove('conversionexportmanagement');
    },
    initState(idExport?: string) {
      if (idExport) {
        if (idExport === '0') {
          const parameters = {
            isAllowed: true,
          };
          Matomo.postEvent('AdvertisingConversionExport.initAddExport', parameters);

          if (parameters && !parameters.isAllowed) {
            this.editMode = false;
            this.idExport = null;
            return;
          }
        }

        this.editMode = true;
        this.idExport = parseInt(idExport, 10);
      } else {
        this.editMode = false;
        this.idExport = null;
      }

      this.removeAnyNotification();
    },
  },
});
</script>
