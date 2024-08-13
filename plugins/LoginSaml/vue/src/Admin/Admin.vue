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
    <div>
      <AjaxForm
        submit-api-method="LoginSaml.saveSamlConfig"
        :use-custom-data-binding="true"
        :send-json-payload="true"
        :form-data="actualSamlConfig"
      >
        <template #default="ajaxForm">
          <ContentBlock
            id="samlStatusSettings"
            :content-title="translate('LoginSaml_StatusSettings')"
          >
            <div
              class="pull-right"
              style="margin-top:-82px;"
            >
              <h3>
                <a
                  href="index.php?module=LoginSaml&action=metadata"
                  target="_blank"
                >{{ translate('LoginSaml_METADATALINK') }}</a>
              </h3>
            </div>
            <div>
              <Field
                uicontrol="checkbox"
                name="status"
                v-model="actualSamlConfig.status"
                :title="translate('LoginSaml_STATUS')"
                :inline-help="translate('LoginSaml_STATUSDescription')"
              >
              </Field>
            </div>
            <SaveButton
              :saving="ajaxForm.isSubmitting"
              @confirm="ajaxForm.submitForm()"
            />
          </ContentBlock>
          <ContentBlock
            id="samlIdPSettings"
            :content-title="translate('LoginSaml_IdPSettings')"
          >
            <div
              class="pull-right"
              style="margin-top:-85px;"
            >
              <h3>
                <a href="index.php?module=LoginSaml&action=importmetadata">
                  {{ translate('LoginSaml_IMPORTLINK') }}
                </a>
              </h3>
            </div>
            <div>
              <Field
                uicontrol="text"
                name="idp_entityid"
                v-model="actualSamlConfig.idp_entityid"
                :title="translate('LoginSaml_IdPEntityId')"
                :inline-help="translate('LoginSaml_IdPEntityIdDescription')"
              >
              </Field>
            </div>
            <div>
              <Field
                uicontrol="text"
                name="idp_sso"
                v-model="actualSamlConfig.idp_sso"
                :title="translate('LoginSaml_IdPSSOURL')"
                :inline-help="translate('LoginSaml_IdPSSOURLDescription')"
              >
              </Field>
            </div>
            <div>
              <Field
                uicontrol="text"
                name="idp_slo"
                v-model="actualSamlConfig.idp_slo"
                :title="translate('LoginSaml_IdPSLOURL')"
                :inline-help="translate('LoginSaml_IdPSLOURLDescription')"
              >
              </Field>
            </div>
            <div>
              <Field
                uicontrol="textarea"
                name="idp_x509cert"
                v-model="actualSamlConfig.idp_x509cert"
                :title="translate('LoginSaml_IdPx509CERT')"
                :inline-help="translate('LoginSaml_IdPx509CERTDescription')"
              >
              </Field>
            </div>
            <div>
              <Field
                uicontrol="textarea"
                name="idp_x509cert2"
                v-model="actualSamlConfig.idp_x509cert2"
                :title="translate('LoginSaml_IdPx509CERT2')"
                :inline-help="translate('LoginSaml_IdPx509CERTDescription2')"
              >
              </Field>
            </div>
            <div>
              <Field
                uicontrol="textarea"
                name="idp_x509cert3"
                v-model="actualSamlConfig.idp_x509cert3"
                :title="translate('LoginSaml_IdPx509CERT3')"
                :inline-help="translate('LoginSaml_IdPx509CERTDescription3')"
              >
              </Field>
            </div>
            <hr />
            <SaveButton
              :saving="ajaxForm.isSubmitting"
              @confirm="ajaxForm.submitForm()"
            />
          </ContentBlock>
          <ContentBlock
            id="samlOptionsSettings"
            :content-title="translate('LoginSaml_OptionsSettings')"
          >
            <div>
              <Field
                uicontrol="checkbox"
                name="options_autocreate"
                v-model="actualSamlConfig.options_autocreate"
                :title="translate('LoginSaml_OptionsAUTOCREATE')"
                :inline-help="translate('LoginSaml_OptionsAUTOCREATEDescription')"
              >
              </Field>
            </div>
            <div>
              <Field
                uicontrol="checkbox"
                name="enable_password_confirmation"
                v-model="actualSamlConfig.enable_password_confirmation"
                :title="translate('LoginSaml_OptionsPWCONFIRMATION')"
                :inline-help="translate('LoginSaml_OptionsPWCONFIRMATIONDescription')"
              >
              </Field>
            </div>
            <div>
              <Field
                uicontrol="checkbox"
                name="options_bypass_2fa"
                v-model="actualSamlConfig.options_bypass_2fa"
                :title="translate('LoginSaml_OptionsBYPASS2FA')"
                :inline-help="translate('LoginSaml_OptionsBYPASS2FADescription')"
              >
              </Field>
            </div>
            <div>
              <Field
                uicontrol="text"
                name="options_new_user_default_sites_view_access"
                v-model="actualSamlConfig.options_new_user_default_sites_view_access"
                :title="translate('LoginSaml_NewUserDefaultSitesViewAccess')"
                :inline-help="translate('LoginSaml_NewUserDefaultSitesViewAccessDescription')"
              >
              </Field>
            </div>
            <div>
              <Field
                uicontrol="select"
                name="options_identify_field"
                v-model="actualSamlConfig.options_identify_field"
                :title="translate('LoginSaml_OptionsIDENTIFYFIELD')"
                :options="identifyFieldOptions"
                :inline-help="translate('LoginSaml_OptionsIDENTIFYFIELDDescription')"
              >
              </Field>
            </div>
            <div>
              <Field
                uicontrol="checkbox"
                name="options_enable_slo"
                v-model="actualSamlConfig.options_enable_slo"
                :title="translate('LoginSaml_OptionsENABLESLO')"
                :inline-help="translate('LoginSaml_OptionsENABLESLODescription')"
              >
              </Field>
            </div>
            <div>
              <Field
                uicontrol="checkbox"
                name="options_forcesaml"
                v-model="actualSamlConfig.options_forcesaml"
                :title="translate('LoginSaml_OptionsFORCESAML')"
              >
                <template #inline-help>
                  {{ translate('LoginSaml_OptionsFORCESAMLescription', '?normal', 'index.php') }}
                  <br/><br/>
                  <span v-if="ifForceSamlNotSupported">
                    {{ translate('LoginSaml_OptionsForceSAMLVersionDesc', currentVersion,
                      '3.6.1') }}
                  </span>
                </template>
              </Field>
            </div>
            <div>
              <Field
                uicontrol="text"
                name="options_normalmode"
                v-model="actualSamlConfig.options_normalmode"
                :title="translate('LoginSaml_OptionsNORMALMODE')"
                :inline-help="translate('LoginSaml_OptionsNORMALMODEDescription')"
              >
              </Field>
            </div>
            <div>
              <Field
                uicontrol="checkbox"
                name="sync_saml_session_expiration"
                v-model="actualSamlConfig.sync_saml_session_expiration"
                :title="translate('LoginSaml_EnableSamlSessionExpirationSynchronization')"
                :inline-help="translate(
                  'LoginSaml_EnableSamlSessionExpirationSynchronizationDescription')"
              >
              </Field>
            </div>
            <hr />
            <SaveButton
              :saving="ajaxForm.isSubmitting"
              @confirm="ajaxForm.submitForm()"
            />
          </ContentBlock>
          <ContentBlock
            id="samlAttributeMappingSettings"
            :content-title="translate('LoginSaml_AttributeMappingSettings')"
          >
            <div>
              <Field
                uicontrol="text"
                name="attributemapping_username"
                v-model="actualSamlConfig.attributemapping_username"
                :title="translate('LoginSaml_AttributeMappingUSERNAME')"
                :inline-help="translate('LoginSaml_AttributeMappingUSERNAMEDescription')"
              >
              </Field>
            </div>
            <div>
              <Field
                uicontrol="text"
                name="attributemapping_email"
                v-model="actualSamlConfig.attributemapping_email"
                :title="translate('LoginSaml_AttributeMappingEMAIL')"
                :inline-help="translate('LoginSaml_AttributeMappingEMAILDescription')"
              >
              </Field>
            </div>
            <hr />
            <SaveButton
              :saving="ajaxForm.isSubmitting"
              @confirm="ajaxForm.submitForm()"
            />
          </ContentBlock>
          <ContentBlock
            id="samlAccessMappingSettings"
            :content-title="translate('LoginSaml_AccessSyncSettings')"
          >
            <p v-html="$sanitize(readMoreAboutAccessSyncText)"></p>
            <div>
              <Field
                uicontrol="checkbox"
                name="enable_synchronize_access_from_saml"
                v-model="actualSamlConfig.enable_synchronize_access_from_saml"
                :title="translate('LoginSaml_EnableSamlAccessSynchronization')"
                :inline-help="translate('LoginSaml_EnableSamlAccessSynchronizationDescription')"
              >
              </Field>
            </div>
            <div v-show="actualSamlConfig.enable_synchronize_access_from_saml">
              <div>
                <Notification context="info">
                  <strong>{{ translate('LoginSaml_ExpectedSamlAttributes') }}</strong><br />
                  <br />
                  {{ translate('LoginSaml_ExpectedSamlAttributesPrelude') }}:<br />
                  <br />
                  <ul>
                    <li>{{ sampleViewAttribute }}</li>
                    <li>{{ sampleWriteAttribute }}</li>
                    <li>{{ sampleAdminAttribute }}</li>
                    <li>{{ sampleSuperuserAttribute }}</li>
                  </ul>
                </Notification>
              </div>
              <div>
                <Field
                  uicontrol="text"
                  name="saml_view_access_field"
                  v-model="actualSamlConfig.saml_view_access_field"
                  :title="translate('LoginSaml_SamlViewAccessField')"
                  :inline-help="translate('LoginSaml_SamlViewAccessFieldDescription')"
                >
                </Field>
              </div>
              <div>
                <Field
                  uicontrol="text"
                  name="saml_write_access_field"
                  v-model="actualSamlConfig.saml_write_access_field"
                  :title="translate('LoginSaml_SamlWriteAccessField')"
                  :inline-help="translate('LoginSaml_SamlWriteAccessFieldDescription')"
                >
                </Field>
              </div>
              <div>
                <Field
                  uicontrol="text"
                  name="saml_admin_access_field"
                  v-model="actualSamlConfig.saml_admin_access_field"
                  :title="translate('LoginSaml_SamlAdminAccessField')"
                  :inline-help="translate('LoginSaml_SamlAdminAccessFieldDescription')"
                >
                </Field>
              </div>
              <div name="saml_superuser_access_field">
                <Field
                  uicontrol="text"
                  name="saml_superuser_access_field"
                  v-model="actualSamlConfig.saml_superuser_access_field"
                  :title="translate('LoginSaml_SamlSuperUserAccessField')"
                  :inline-help="translate('LoginSaml_SamlSuperUserAccessFieldDescription')"
                >
                </Field>
              </div>
              <div name="user_access_attribute_server_specification_delimiter">
                <Field
                  uicontrol="text"
                  name="user_access_attribute_server_specification_delimiter"
                  v-model="actualSamlConfig.user_access_attribute_server_specification_delimiter"
                  :title="translate('LoginSaml_SamlUserAccessAttributeServerSpecDelimiter')"
                  :inline-help="translate(
                    'LoginSaml_SamlUserAccessAttributeServerSpecDelimiterDescription')"
                >
                </Field>
              </div>
              <div name="user_access_attribute_server_separator">
                <Field
                  uicontrol="text"
                  name="user_access_attribute_server_separator"
                  v-model="actualSamlConfig.user_access_attribute_server_separator"
                  :title="translate('LoginSaml_SamlUserAccessAttributeServerSeparator')"
                  :inline-help="translate(
                    'LoginSaml_SamlUserAccessAttributeServerSeparatorDescription')"
                >
                </Field>
              </div>
              <div name="instance_name">
                <Field
                  uicontrol="text"
                  name="instance_name"
                  v-model="actualSamlConfig.instance_name"
                  :title="translate('LoginSaml_ThisPiwikInstanceName')"
                  :inline-help="translate('LoginSaml_ThisPiwikInstanceNameDescription')"
                >
                </Field>
              </div>
            </div>
            <hr />
            <SaveButton
              :saving="ajaxForm.isSubmitting"
              @confirm="ajaxForm.submitForm()"
            />
          </ContentBlock>
          <ContentBlock
            id="samlAdvancedSettings"
            :content-title="translate('LoginSaml_AdvancedSettings')"
          >
            <div name="advanced_strict">
              <Field
                uicontrol="checkbox"
                name="advanced_strict"
                v-model="actualSamlConfig.advanced_strict"
                :title="translate('LoginSaml_AdvancedSTRICT')"
                :inline-help="translate('LoginSaml_AdvancedSTRICTDescription')"
              >
              </Field>
            </div>
            <div name="advanced_debug">
              <Field
                uicontrol="checkbox"
                name="advanced_debug"
                v-model="actualSamlConfig.advanced_debug"
                :title="translate('LoginSaml_AdvancedDEBUG')"
                :inline-help="translate('LoginSaml_AdvancedDEBUGDescription')"
              >
              </Field>
            </div>
            <div name="advanced_spentityid">
              <Field
                uicontrol="text"
                name="advanced_spentityid"
                v-model="actualSamlConfig.advanced_spentityid"
                :title="translate('LoginSaml_AdvancedSPENTITYID')"
                :inline-help="translate('LoginSaml_AdvancedSPENTITYIDDescription')"
              >
              </Field>
            </div>
            <div name="advanced_nameidformat">
              <Field
                uicontrol="select"
                name="advanced_nameidformat"
                v-model="actualSamlConfig.advanced_nameidformat"
                :title="translate('LoginSaml_AdvancedNAMEIDFORMAT')"
                :options="nameidformatOptions"
                :inline-help="translate('LoginSaml_AdvancedNAMEIDFORMATDescription')"
              >
              </Field>
            </div>
            <div name="advanced_nameid_encrypted">
              <Field
                uicontrol="checkbox"
                name="advanced_nameid_encrypted"
                v-model="actualSamlConfig.advanced_nameid_encrypted"
                :title="translate('LoginSaml_AdvancedNAMEIDENCRYPTED')"
                :inline-help="translate('LoginSaml_AdvancedNAMEIDENCRYPTEDDescription')"
              >
              </Field>
            </div>
            <div name="advanced_authn_request_signed">
              <Field
                uicontrol="checkbox"
                name="advanced_authn_request_signed"
                v-model="actualSamlConfig.advanced_authn_request_signed"
                :title="translate('LoginSaml_AdvancedAUTHNREQUESTSIGNED')"
                :inline-help="translate('LoginSaml_AdvancedAUTHNREQUESTSIGNEDDescription')"
              >
              </Field>
            </div>
            <div name="advanced_logout_request_signed">
              <Field
                uicontrol="checkbox"
                name="advanced_logout_request_signed"
                v-model="actualSamlConfig.advanced_logout_request_signed"
                :title="translate('LoginSaml_AdvancedLOGOUTREQUESTSIGNED')"
                :inline-help="translate('LoginSaml_AdvancedLOGOUTREQUESTSIGNEDDescription')"
              >
              </Field>
            </div>
            <div name="advanced_logout_response_signed">
              <Field
                uicontrol="checkbox"
                name="advanced_logout_response_signed"
                v-model="actualSamlConfig.advanced_logout_response_signed"
                :title="translate('LoginSaml_AdvancedLOGOUTRESPONSESIGNED')"
                :inline-help="translate('LoginSaml_AdvancedLOGOUTRESPONSESIGNEDDescription')"
              >
              </Field>
            </div>
            <div name="advanced_metadata_signed">
              <Field
                uicontrol="checkbox"
                name="advanced_metadata_signed"
                v-model="actualSamlConfig.advanced_metadata_signed"
                :title="translate('LoginSaml_AdvancedMETADATASIGNED')"
                :inline-help="translate('LoginSaml_AdvancedMETADATASIGNEDDescription')"
              >
              </Field>
            </div>
            <div name="advanced_want_message_signed">
              <Field
                uicontrol="checkbox"
                name="advanced_want_message_signed"
                v-model="actualSamlConfig.advanced_want_message_signed"
                :title="translate('LoginSaml_AdvancedWANTMESSAGESIGNED')"
                :inline-help="translate('LoginSaml_AdvancedWANTMESSAGESIGNEDDescription')"
              >
              </Field>
            </div>
            <div name="advanced_requestedauthncontext">
              <Field
                uicontrol="multiselect"
                name="advanced_requestedauthncontext"
                v-model="actualSamlConfig.advanced_requestedauthncontext"
                :title="translate('LoginSaml_AdvancedREQUESTEDAUTHNCONTEXT')"
                :options="requestedauthncontextOptions"
                :inline-help="translate('LoginSaml_AdvancedREQUESTEDAUTHNCONTEXTDescription')"
              >
              </Field>
            </div>
            <div name="advanced_want_assertion_signed">
              <Field
                uicontrol="checkbox"
                name="advanced_want_assertion_signed"
                v-model="actualSamlConfig.advanced_want_assertion_signed"
                :title="translate('LoginSaml_AdvancedWANTASSERTIONSIGNED')"
                :inline-help="translate('LoginSaml_AdvancedWANTASSERTIONSIGNEDDescription')"
              >
              </Field>
            </div>
            <div name="advanced_want_assertion_encrypted">
              <Field
                uicontrol="checkbox"
                name="advanced_want_assertion_encrypted"
                v-model="actualSamlConfig.advanced_want_assertion_encrypted"
                :title="translate('LoginSaml_AdvancedWANTASSERTIONENCRYPTED')"
                :inline-help="translate('LoginSaml_AdvancedWANTASSERTIONENCRYPTEDDescription')"
              >
              </Field>
            </div>
            <div name="advanced_want_nameid_encrypted">
              <Field
                uicontrol="checkbox"
                name="advanced_want_nameid_encrypted"
                v-model="actualSamlConfig.advanced_want_nameid_encrypted"
                :title="translate('LoginSaml_AdvancedWANTNAMEIDENCRYPTED')"
                :inline-help="translate('LoginSaml_AdvancedWANTNAMEIDENCRYPTEDDescription')"
              >
              </Field>
            </div>
            <div name="advanced_retrieve_parameters_from_server">
              <Field
                uicontrol="checkbox"
                name="advanced_retrieve_parameters_from_server"
                v-model="actualSamlConfig.advanced_retrieve_parameters_from_server"
                :title="translate('LoginSaml_AdvancedRETRIEVEFROMSERVER')"
                :inline-help="translate('LoginSaml_AdvancedRETRIEVEFROMSERVERDescription')"
              >
              </Field>
            </div>
            <div name="advanced_set_proxy_vars">
              <Field
                uicontrol="checkbox"
                name="advanced_set_proxy_vars"
                v-model="actualSamlConfig.advanced_set_proxy_vars"
                :title="translate('LoginSaml_AdvancedSETPROXYVARS')"
                :inline-help="translate('LoginSaml_AdvancedSETPROXYVARSDescription')"
              >
              </Field>
            </div>
            <div name="advanced_sp_x509cert">
              <Field
                uicontrol="textarea"
                name="advanced_sp_x509cert"
                v-model="actualSamlConfig.advanced_sp_x509cert"
                :title="translate('LoginSaml_AdvancedSPx509CERT')"
                :inline-help="translate('LoginSaml_AdvancedSPx509CERTDescription')"
              >
              </Field>
            </div>
            <div name="advanced_sp_privatekey">
              <Field
                uicontrol="textarea"
                name="advanced_sp_privatekey"
                v-model="actualSamlConfig.advanced_sp_privatekey"
                :title="translate('LoginSaml_AdvancedSPPRIVATEKEY')"
                :inline-help="translate('LoginSaml_AdvancedSPPRIVATEKEYDescription')"
              >
              </Field>
            </div>
            <div name="advanced_signaturealgorithm">
              <Field
                uicontrol="select"
                name="advanced_signaturealgorithm"
                v-model="actualSamlConfig.advanced_signaturealgorithm"
                :title="translate('LoginSaml_AdvancedSIGNATUREALGORITHM')"
                :options="signaturealgorithmOptions"
                :inline-help="translate('LoginSaml_AdvancedSIGNATUREALGORITHMDescription')"
              >
              </Field>
            </div>
            <div name="advanced_digestalgorithm">
              <Field
                uicontrol="select"
                name="advanced_digestalgorithm"
                v-model="actualSamlConfig.advanced_digestalgorithm"
                :title="translate('LoginSaml_AdvancedDIGESTALGORITM')"
                :options="digestalgorithmOptions"
                :inline-help="translate('LoginSaml_AdvancedDIGESTALGORITMDescription')"
              >
              </Field>
            </div>
            <div name="advanced_use_friendlyname">
              <Field
                uicontrol="checkbox"
                name="advanced_use_friendlyname"
                v-model="actualSamlConfig.advanced_use_friendlyname"
                :title="translate('LoginSaml_AdvancedUSEFRIENDLYNAME')"
                :inline-help="friendlyNameDescriptionText"
              >
              </Field>
            </div>
            <hr />
            <SaveButton
              :saving="ajaxForm.isSubmitting"
              @confirm="ajaxForm.submitForm()"
            />
          </ContentBlock>
        </template>
      </AjaxForm>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import {
  translate,
  AjaxForm,
  ContentBlock,
  Notification,
} from 'CoreHome';
import { Field, SaveButton } from 'CorePluginsAdmin';

interface LoginSamlConfig {
  status: number;
  idp_entityid: string;
  idp_sso: string;
  idp_slo: string;
  idp_x509cert: string;
  idp_x509cert2: string;
  idp_x509cert3: string;
  options_autocreate: number;
  enable_password_confirmation: number;
  options_bypass_2fa: number;
  options_new_user_default_sites_view_access: string;
  options_identify_field: string;
  options_enable_slo: number;
  options_forcesaml: number;
  options_normalmode: string;
  attributemapping_username: string;
  attributemapping_email: string;
  enable_synchronize_access_from_saml: number;
  sync_saml_session_expiration: number;
  saml_view_access_field: string;
  saml_write_access_field: string;
  saml_admin_access_field: string;
  saml_superuser_access_field: string;
  user_access_attribute_server_specification_delimiter: string;
  user_access_attribute_server_separator: string;
  instance_name: null|string;
  advanced_strict: number;
  advanced_debug: number;
  advanced_spentityid: string;
  advanced_nameidformat: string;
  advanced_requestedauthncontext: number;
  advanced_nameid_encrypted: number;
  advanced_authn_request_signed: number;
  advanced_logout_request_signed: number;
  advanced_logout_response_signed: number;
  advanced_metadata_signed: number;
  advanced_want_message_signed: number;
  advanced_want_assertion_signed: number;
  advanced_want_assertion_encrypted: number;
  advanced_want_nameid_encrypted: number;
  advanced_retrieve_parameters_from_server: number;
  advanced_sp_x509cert: string;
  advanced_sp_privatekey: string;
  advanced_signaturealgorithm: string;
  advanced_digestalgorithm: string;
  advanced_set_proxy_vars: number;
  advanced_use_friendlyname: number;
}

interface AdminState {
  actualSamlConfig: LoginSamlConfig;
}

function getSampleAccessAttribute(
  config: LoginSamlConfig,
  accessField: string,
  firstValue?: string,
  secondValue?: string,
) {
  let result = `${accessField}: `;

  if (config.instance_name) {
    result += config.instance_name;
  } else {
    result += window.location.hostname;
  }

  if (firstValue) {
    result += `${config.user_access_attribute_server_separator}${firstValue || ''}`;
  }

  result += config.user_access_attribute_server_specification_delimiter;

  if (config.instance_name) {
    result += 'piwikB';
  } else {
    result += 'anotherhost.com';
  }

  if (secondValue) {
    result += `${config.user_access_attribute_server_separator}${secondValue || ''}`;
  }

  return result;
}

export default defineComponent({
  props: {
    samlConfig: {
      type: Object,
      required: true,
    },
    identifyFieldOptions: {
      type: Object,
      required: true,
    },
    ifForceSamlNotSupported: Boolean,
    currentVersion: {
      type: String,
      required: true,
    },
    nameidformatOptions: {
      type: Object,
      required: true,
    },
    requestedauthncontextOptions: {
      type: Object,
      required: true,
    },
    signaturealgorithmOptions: {
      type: Object,
      required: true,
    },
    digestalgorithmOptions: {
      type: Object,
      required: true,
    },
  },
  components: {
    AjaxForm,
    ContentBlock,
    Field,
    SaveButton,
    Notification,
  },
  data(): AdminState {
    return {
      actualSamlConfig: { ...(this.samlConfig as LoginSamlConfig) },
    };
  },
  computed: {
    sampleViewAttribute() {
      return getSampleAccessAttribute(
        this.actualSamlConfig,
        this.actualSamlConfig.saml_view_access_field,
        '1,2',
        '3,4',
      );
    },
    sampleWriteAttribute() {
      return getSampleAccessAttribute(
        this.actualSamlConfig,
        this.actualSamlConfig.saml_write_access_field,
        '1',
        '3',
      );
    },
    sampleAdminAttribute() {
      return getSampleAccessAttribute(
        this.actualSamlConfig,
        this.actualSamlConfig.saml_admin_access_field,
        'all',
        'all',
      );
    },
    sampleSuperuserAttribute() {
      return getSampleAccessAttribute(
        this.actualSamlConfig,
        this.actualSamlConfig.saml_superuser_access_field,
      );
    },
    readMoreAboutAccessSyncText() {
      const link = 'https://matomo.org/docs/login-saml/';
      return translate(
        'LoginSaml_ReadMoreAboutAccessSynchronization',
        `<a target="_blank" ref="noreferrer noopener" href="${link}">`,
        '</a>',
      );
    },
    friendlyNameDescriptionText() {
      const note = translate(
        'LoginSaml_AdvancedUSEFRIENDLYNAMEDescriptionNote',
        '<br><br><strong>',
        '</strong>',
      );
      return translate('LoginSaml_AdvancedUSEFRIENDLYNAMEDescription') + note;
    },
  },
});
</script>
