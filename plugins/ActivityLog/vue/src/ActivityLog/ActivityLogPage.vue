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
       :content-title="translate('ActivityLog_ActivityLog')"
       feature="true"
  >
    <p v-if="isSuperUser">
      With the Activity Log, also known as audit log or audit trail, you keep an eye on everything
      that is happening on your Matomo. Below you see a record of all important activities
      performed by your Matomo users. It helps you for example to monitor data for any potential
      security breach and to identify problems, why something happened and when.
    </p>
    <p v-else>
      With the Activity Log, also known as audit log or audit trail, you keep an eye on all of
      your activities in Matomo.
    </p>

    <div class="ActivityLogContainer">
      <ActivityLog
        :show-paging-bottom="showPagingBottom"
      />
    </div>
  </ContentBlock>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { ContentBlock } from 'CoreHome';
import ActivityLog from './ActivityLog.vue';

export default defineComponent({
  props: {
    showPagingBottom: Boolean,
    isSuperUser: Boolean,
  },
  components: {
    ActivityLog,
    ContentBlock,
  },
});
</script>
