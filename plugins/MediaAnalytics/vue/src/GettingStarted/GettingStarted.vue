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
    <p style="width: 600px;">
      <br />
      <strong>{{ translate('MediaAnalytics_NoMediaTrackedYet', `"${siteNameDecoded}"`) }}.</strong>
      <br /><br />
      {{ translate('MediaAnalytics_NoMediaTrackedYetDescription') }} <br />
      <a
        href="https://developer.matomo.org/guides/media-analytics/setup"
        rel="noreferrer noopener"
        target="_blank"
      >{{ translate('MediaAnalytics_NoMediaTrackedYetMoreInfo') }}</a>.
    </p>
    <p style="width: 600px;">
      {{ translate('MediaAnalytics_NoMediaTrackedYetWillDisappear') }}
    </p>

    <br v-if="!piwikJsWritable" />
    <div class="alert alert-warning" v-if="!piwikJsWritable">
      {{ translate('MediaAnalytics_PiwikJsNotWritable1') }}

      <br />
      <pre v-select-on-focus><code>chmod 0755 piwik.js</code></pre>

      {{ translate('MediaAnalytics_PiwikJsNotWritable2') }}

      <br />
      <pre v-select-on-focus><code>{{ trackerScriptCode }}</code></pre>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Matomo, SelectOnFocus } from 'CoreHome';

export default defineComponent({
  props: {
    siteName: {
      type: String,
      required: true,
    },
    piwikJsWritable: Boolean,
    piwikUrl: String,
  },
  directives: {
    SelectOnFocus,
  },
  computed: {
    trackerScriptCode() {
      const url = `${this.piwikUrl || ''}plugins/MediaAnalytics/tracker.js`;
      const scriptEndTag = '/script>'; // phpstorm has trouble with including this tag in a string
      return `<script type="text/javascript" src="${url}"><${scriptEndTag}`;
    },
    siteNameDecoded() {
      return Matomo.helper.htmlDecode(this.siteName);
    },
  },
});
</script>
