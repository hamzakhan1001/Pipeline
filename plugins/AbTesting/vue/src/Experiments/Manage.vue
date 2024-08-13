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
  <div class="manageExperiments">
    <div v-show="!editMode">
      <ListExperiments />
    </div>
    <div v-show="editMode">
      <EditExperiments
        :id-experiment="idExperiment"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, watch } from 'vue';
import { Matomo, MatomoUrl, NotificationsStore } from 'CoreHome';
import EditExperiments from './Edit.vue';
import ListExperiments from './List.vue';

interface ExperimentsManageState {
  editMode: boolean;
  idExperiment: number|null;
}

export default defineComponent({
  props: {
  },
  components: {
    EditExperiments,
    ListExperiments,
  },
  data(): ExperimentsManageState {
    return {
      editMode: false,
      idExperiment: null,
    };
  },
  created() {
    // doing this in a watch because we don't want to post an event in a computed property
    watch(() => MatomoUrl.hashParsed.value.idExperiment as string, (idExperiment) => {
      this.initState(idExperiment);
    });

    this.initState(MatomoUrl.hashParsed.value.idExperiment as string);
  },
  methods: {
    removeAnyExperimentNotification() {
      NotificationsStore.remove('experimentsmanagement');
    },
    initState(idExperiment?: string) {
      if (idExperiment) {
        if (idExperiment === '0') {
          const parameters = {
            isAllowed: true,
          };
          Matomo.postEvent('AbTesting.initAddExperiment', parameters);

          if (parameters && !parameters.isAllowed) {
            this.editMode = false;
            this.idExperiment = null;
            return;
          }
        }

        this.editMode = true;
        this.idExperiment = parseInt(idExperiment, 10);
      } else {
        this.editMode = false;
        this.idExperiment = null;
      }

      this.removeAnyExperimentNotification();
    },
  },
});
</script>
