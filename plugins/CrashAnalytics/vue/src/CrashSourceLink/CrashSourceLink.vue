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
  <a
    class="crashSourceLink"
    v-if="isNetworkSource && uri"
    :href="crashSourceUrl"
    target="_blank"
    rel="noreferrer noopener"
  >{{ uriDisplay }}</a>
  <span v-if="!isNetworkSource && uri" :title="noLinkTooltip">{{ uriDisplay }}</span>
  <span v-if="uri" :title="lineColumnTooltip">:{{ line }}:{{ column }}</span>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { translate } from 'CoreHome';

function isUrl(uri?: string) {
  if (!uri || !/^https?/.test(uri)) {
    return false;
  }

  try {
    new URL(uri); // eslint-disable-line no-new
    return true;
  } catch (e) {
    return false;
  }
}

export default defineComponent({
  props: {
    uri: String,
    line: Number,
    column: Number,
    pageUrl: String,
    doNotLinkInline: Boolean,
  },
  computed: {
    isGroupedHashFilename() {
      return /\/\[grouped-hash]\./.test(this.uriDisplay!);
    },
    isNetworkSource() {
      return isUrl(this.uriDisplay) && !this.isGroupedHashFilename;
    },
    uriDisplay() {
      if (this.uri === 'inline') {
        return this.doNotLinkInline ? translate('CrashAnalytics_Inline') : this.pageUrl;
      }
      return this.uri;
    },
    crashSourceUrl() {
      if (!this.uri) {
        return null;
      }

      if (this.uri === 'inline') {
        return `view-source:${this.pageUrl}`;
      }

      if (isUrl(this.uri)) {
        return this.uri;
      }

      return null;
    },
    lineColumnTooltip() {
      return translate('CrashAnalytics_LineColumn', this.line!, this.column!);
    },
    noLinkTooltip() {
      if (!this.isGroupedHashFilename) {
        return undefined;
      }

      return translate('CrashAnalytics_GroupedHashTooltipInDetails');
    },
  },
});
</script>
