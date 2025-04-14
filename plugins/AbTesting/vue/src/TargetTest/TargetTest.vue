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
  <div class="form-group targetTest">
    <label><strong>{{ translate('AbTesting_TargetPageTestTitle') }}:</strong>
      {{ translate('AbTesting_TargetPageTestLabel') }}</label>
    <input
      type="text"
      id="urltargettest"
      placeholder="http://www.example.com/"
      v-model="url"
      :class="{invalid: url && !matches && isValid}"
    />
    <div>
      <span
        class="testInfo"
        v-show="url && !isValid"
      >
        {{ translate('AbTesting_TargetPageTestErrorInvalidUrl') }}
      </span>
      <span
        class="testInfo matches"
        v-show="url && matches && isValid"
      >
        {{ translate('AbTesting_TargetPageTestUrlMatches') }}
      </span>
      <span
        class="testInfo notMatches"
        v-show="url && !matches && isValid"
      >
        {{ translate('AbTesting_TargetPageTestUrlNotMatches') }}
      </span>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import '../types';

interface TargetTestState {
  url: string;
  matches: boolean;
  isLoadingTestMatchPage: boolean;
}

function isValidUrl(url: string) {
  try {
    new URL(url); // eslint-disable-line no-new
    return true;
  } catch (e) {
    return false;
  }
}

function filterTargetsWithEmptyValue<T extends { value: unknown }>(targets?: T[]): T[] {
  return (targets || []).filter((t) => t && t.value);
}

export default defineComponent({
  props: {
    includedTargets: Array,
    excludedTargets: Array,
  },
  data(): TargetTestState {
    return {
      url: '',
      matches: false,
      isLoadingTestMatchPage: false,
    };
  },
  watch: {
    isValid(newVal) {
      if (!newVal) {
        this.matches = false;
      }
    },
    includedTargets() {
      this.runTest();
    },
    excludedTargets() {
      this.runTest();
    },
    url() {
      this.runTest();
    },
  },
  methods: {
    runTest() {
      if (!this.isValid) {
        return;
      }

      const locationBackup = window.piwikAbTestingTarget.location;

      window.piwikAbTestingTarget.location = new URL(this.targetUrl);

      const included = filterTargetsWithEmptyValue(this.includedTargets as { value: unknown }[]);
      const excluded = filterTargetsWithEmptyValue(this.excludedTargets as { value: unknown }[]);

      this.matches = window.piwikAbTestingTarget.matchesTargets(included, excluded);

      window.piwikAbTestingTarget.location = locationBackup;
    },
  },
  computed: {
    targetUrl() {
      return (this.url || '').trim();
    },
    isValid() {
      return this.targetUrl && isValidUrl(this.targetUrl);
    },
  },
});
</script>
