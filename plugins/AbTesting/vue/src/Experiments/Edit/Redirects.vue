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
    <div class="form-group row">
      <div
        class="col s12 m6"
        style="padding-left: 0;"
      >
        <div
          :class="`redirectsAllocation ${index}`"
          v-for="(exper, index) in modelValue"
          :key="exper.idvariation"
        >
          <div class="redirects" name="redirects">
            <Field
              uicontrol="text"
              name="redirects"
              placeholder="eg http://www.example.com"
              :model-value="exper.redirect_url"
              @update:model-value="setRedirectUrl(index, $event)"
              :title="`${translate('AbTesting_Variation')} &quot;${htmlEntities(exper.name)}&quot;`"
              :maxlength="1000"
              :full-width="true"
            >
            </Field>
          </div>
        </div>
      </div>
      <div class="col s12 m6">
        <div class="form-help">
          <span class="inline-help">
            {{ translate('AbTesting_FieldRedirectHelp1') }}
            <br />
            <br />
            {{ translate('AbTesting_FieldRedirectHelp2') }}
            <br /><br />
            <span v-html="$sanitize(formHelp)"/>
          </span>
        </div>
      </div>
    </div>
    <div>
      <Field
        uicontrol="checkbox"
        name="forwardUtmParams"
        :model-value="forwardUtmParams"
        :title="translate('AbTesting_ForwardUtmParams')"
        @update:model-value="setForwardUtmParams($event)"
        :inline-help="getForwardUtmParamsHelpText"
      >
      </Field>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { translate, Matomo } from 'CoreHome';
import { Field } from 'CorePluginsAdmin';
import { Variation } from '../../types';

export default defineComponent({
  props: {
    modelValue: Array,
    forwardUtmParams: {
      type: Boolean,
      required: false,
      default: false,
    },
  },
  components: {
    Field,
  },
  emits: ['update:modelValue', 'update:forwardUtmParams'],
  computed: {
    formHelp() {
      const link = 'https://github.com/innocraft/php-experiments';
      return translate(
        'AbTesting_FieldRedirectHelp3',
        `<a target="blank" rel="noreferrer" href="${link}">`,
        '</a>',
      );
    },
    getForwardUtmParamsHelpText() {
      const helpText1 = translate('AbTesting_ForwardUtmParamsHelpText');
      const link = 'https://developer.matomo.org/guides/ab-tests/browser#can-i-use-redirects-in-ab-tests-to-test-entirely-different-pages-or-layouts';
      const helpText2 = translate('AbTesting_ForwardUtmParamsHelpTextNote',
        '<strong>',
        '</strong>',
        '<a href="javascript:void(0);" id="viewEmbedCodeTabLink">',
        '</a>',
        `<a target="blank" rel="noreferrer" href="${link}">`,
        '</a>');
      return `${helpText1}</br></br>${helpText2}`;
    },
  },
  methods: {
    setRedirectUrl(index: number, newRedirectUrl: string) {
      const variations = (this.modelValue || []) as Variation[];

      const newValue = [...variations];
      newValue[index] = { ...variations[index], redirect_url: newRedirectUrl };
      this.$emit('update:modelValue', newValue);
    },
    setForwardUtmParams(forwardUtmParams: boolean) {
      this.$emit('update:forwardUtmParams', forwardUtmParams);
    },
    htmlEntities(v: string) {
      return Matomo.helper.htmlEntities(v);
    },
    clickEmbedTab() {
      const element = window.document.querySelectorAll('li.menuEmbed a');
      const htmlElement = element[0] as HTMLElement;
      htmlElement.click();
    },
  },
  mounted() {
    const clickEmbedTabFunction = this.clickEmbedTab;
    const htmlElement = window.document.getElementById('viewEmbedCodeTabLink');

    if (!htmlElement) {
      return;
    }

    htmlElement.addEventListener('click', () => {
      clickEmbedTabFunction();
    });
  },
});
</script>
