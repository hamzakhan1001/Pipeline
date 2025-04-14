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
  <div class="lastStackTrace">
    <p class="sectionTitle">
      <strong>{{ translate('CrashAnalytics_SourceAndStackTrace') }}</strong>:
      <CrashSourceLink
        :uri="crashContext.resourceUri"
        :line="crashContext.resourceLine"
        :column="crashContext.resourceColumn"
        :page-url="crashContext.pageUrl"
      />
    </p>
    <div v-if="crashContext.stackTrace">
      <pre><code>{{ crashContext.stackTrace }}</code></pre>
    </div>
    <div v-if="!crashContext.stackTrace" class="form-description">
      {{ translate('CrashAnalytics_NoStackTraceFound') }}
    </div>
  </div>

</template>

<script lang="ts">
import { defineComponent } from 'vue';
import CrashSourceLink from '../CrashSourceLink/CrashSourceLink.vue';

export default defineComponent({
  props: {
    crashContext: {
      type: Object,
      required: true,
    },
  },
  components: {
    CrashSourceLink,
  },
});
</script>
