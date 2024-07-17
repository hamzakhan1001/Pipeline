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
  <div class="manageForms">
    <div v-if="!editMode">
      <FormsList/>
    </div>
    <div v-if="editMode">
      <FormsEdit
        :id-form="idForm"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, watch } from 'vue';
import { Matomo, MatomoUrl, NotificationsStore } from 'CoreHome';
import FormsList from './List.vue';
import FormsEdit from './Edit.vue';

interface FormsManageState {
  editMode: boolean;
  idForm: number|null;
}

export default defineComponent({
  props: {
  },
  components: {
    FormsList,
    FormsEdit,
  },
  data(): FormsManageState {
    return {
      editMode: false,
      idForm: null,
    };
  },
  watch: {
    editMode() {
      // when changing edit modes, the tooltip can sometimes get stuck on the screen
      $('.ui-tooltip').remove();
    },
  },
  created() {
    // doing this in a watch because we don't want to post an event in a computed property
    watch(() => MatomoUrl.hashParsed.value.idForm as string, (idForm) => {
      this.initState(idForm);
    });

    this.initState(MatomoUrl.hashParsed.value.idForm as string);
  },
  methods: {
    removeAnyFormNotification() {
      NotificationsStore.remove('formsmanagement');
    },
    initState(idForm?: string) {
      if (idForm) {
        if (idForm === '0') {
          const parameters = {
            isAllowed: true,
          };
          Matomo.postEvent('FormAnalytics.initAddForm', parameters);

          if (parameters && !parameters.isAllowed) {
            this.editMode = false;
            this.idForm = null;
            return;
          }
        }

        this.editMode = true;
        this.idForm = parseInt(idForm, 10);
      } else {
        this.editMode = false;
        this.idForm = null;
      }

      this.removeAnyFormNotification();
    },
  },
});
</script>
