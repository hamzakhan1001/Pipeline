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
  <AjaxForm
    submit-api-method="LoginSaml.importIdPMetadata"
    :use-custom-data-binding="true"
    :send-json-payload="true"
    :form-data="importConfig"
  >
    <template #default="ajaxForm">
      <ContentBlock
        id="ImportMetadataSection"
        :content-title="translate('LoginSaml_ImportMetadataTitle')"
      >

        <div class="pull-right" style="margin-top:-80px;">
          <h3>
            <a href="index.php?module=LoginSaml&action=admin">
              {{ translate('LoginSaml_GOBACKADMINLINK') }}
            </a>
          </h3>
        </div>

        <p>{{ translate('LoginSaml_ImportMetadataText') }}</p>

        <Field
          uicontrol="text"
          name="idp_metadata_url"
          :title="translate('LoginSaml_ImportIdPURL')"
          v-model="importConfig.idp_metadata_url"
          :inline-help="translate('LoginSaml_ImportIdPURLDescription')"
        >
        </Field>

        <Field
          uicontrol="textarea"
          name="idp_metadata_xml"
          :title="translate('LoginSaml_ImportIdPXML')"
          v-model="importConfig.idp_metadata_xml"
          :inline-help="translate('LoginSaml_ImportIdPXMLDescription')"
        >
        </Field>

        <hr>

        <Field
          uicontrol="text"
          name="idp_entityid"
          :title="translate('LoginSaml_ImportIdPEntityId')"
          v-model="importConfig.idp_entityid"
          :inline-help="translate('LoginSaml_ImportIdPEntityIdDescription')"
        >
        </Field>

        <SaveButton
          :saving="ajaxForm.isSubmitting"
          @confirm="ajaxForm.submitForm()"
          value="Import"
        />
      </ContentBlock>
    </template>
  </AjaxForm>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import {
  AjaxForm,
  ContentBlock,
} from 'CoreHome';
import { Field, SaveButton } from 'CorePluginsAdmin';

interface ImportConfig {
  idp_metadata_url: string;
  idp_metadata_xml: string;
  idp_entityid: string;
}

interface ImportState {
  importConfig: ImportConfig;
}

export default defineComponent({
  props: {},
  components: {
    AjaxForm,
    ContentBlock,
    SaveButton,
    Field,
  },
  data(): ImportState {
    return {
      importConfig: {
        idp_metadata_url: '',
        idp_metadata_xml: '',
        idp_entityid: '',
      },
    };
  },
});
</script>
