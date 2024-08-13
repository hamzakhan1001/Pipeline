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
    id="MetadataXMLSection"
    :content-title="translate('LoginSaml_SPMetadata')"
  >
    <div class="pull-right" style="margin-top:-80px;">
      <h3>
        <a href="index.php?module=LoginSaml&action=admin">
          {{ translate('LoginSaml_GOBACKADMINLINK') }}
        </a>
      </h3>
    </div>
    <hr>

    <div v-if="metadataError">{{ metadataError }}</div>
    <div v-else>
      <p>
        <b>Entity ID:</b><br/>
        <input type="text" :value="spEntityid" disabled="disabled" style="color:black;"/>
      </p>
      <p>
        <b>Assertion Consumer Service URL endpoint:</b><br>
        <input type="text" :value="acs" disabled="disabled" style="color:black;"/>
      </p>
      <p v-if="sls">
        <b>Single Logout Service URL endpoint:</b><br>
        <input type="text" :value="sls" disabled="disabled" style="color:black;"/>
      </p>
      <p v-if="x509cert">
        <b>Public x509 certificate:</b><br>
        <textarea
          rows="4"
          cols="40"
          disabled="disabled"
          style="height: 18rem;"
          :value="x509cert"
        ></textarea>
      </p>
    </div>

    <hr/>
    <h3>XML</h3>
    <pre>{{ metadata }}</pre>
    <span>
      {{ translate('LoginSaml_METADATAURLLINK_Description') }}
      <a target="blank" :href="metadataUrl">{{metadataUrl}}</a>,<br>
      {{ translate('LoginSaml_METADATAURLLINK_Description2') }}
    </span>
  </ContentBlock>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { ContentBlock } from 'CoreHome';

export default defineComponent({
  props: {
    metadataError: String,
    spEntityid: String,
    acs: String,
    sls: String,
    x509cert: String,
    metadata: String,
    metadataUrl: String,
  },
  components: {
    ContentBlock,
  },
});
</script>
