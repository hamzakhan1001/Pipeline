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
    :content-title="translate('WooCommerceAnalytics_WoocommerceIntegration')"
    class="woocommerceAnalytics">
    <h3>{{ translate('Installation_Installation') }}</h3>
    <ul>
      <li>{{ translate('WooCommerceAnalytics_InstallDownload2', 'Matomo') }}</li>
      <li>{{ translate('WooCommerceAnalytics_InstallLoginWordPress') }}</li>
      <li>{{ translate('WooCommerceAnalytics_InstallWordPress') }}</li>
      <li>{{ translate('WooCommerceAnalytics_InstallActivatePlugin') }}</li>
      <li>{{ translate('WooCommerceAnalytics_InstallGoSettings2', 'Matomo') }}</li>
      <li>{{ translate('WooCommerceAnalytics_InstallConfigure') }}</li>
    </ul>
    <p>
      <br />
      <a download class="btn"
         :href="downloadLink">{{ translate('WooCommerceAnalytics_DownloadPlugin') }}</a>
    </p>

    <h3>{{ translate('WooCommerceAnalytics_UpdatingPlugin') }}</h3>
    <p>{{ translate('WooCommerceAnalytics_UpdatingPluginConfigured2', 'Matomo') }}<br /><br />
      {{ translate('WooCommerceAnalytics_UpdatingPluginPiwikServer') }}
    </p>

    <h3>{{ translate('General_Help') }}</h3>
    <ul>
      <li>
        <a target="_blank" rel="noreferrer"
           href="https://plugins.matomo.org/WooCommerceAnalytics#faq">FAQ</a>
      </li>
    </ul>
  </ContentBlock>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import {
  ContentBlock,
} from 'CoreHome';

export default defineComponent({
  props: {
    downloadLink: String,
  },
  components: {
    ContentBlock,
  },
});
</script>
