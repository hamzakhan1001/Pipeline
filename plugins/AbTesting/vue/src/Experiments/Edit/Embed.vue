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
    <div v-show="experiment.status === 'finished'">
      <div class="alert alert-info">
        {{ translate('AbTesting_ExperimentIsFinishedPleaseRemoveCode') }}
      </div>
    </div>
    <div
      v-show="experiment.status === 'running' || experiment.status === 'created'"
    >
      <div class="alert alert-info">{{ translate('AbTesting_WhereToInsertCodeWarning') }}</div>
      <p>{{ translate('AbTesting_ExperimentWillStartFromFirstTrackingRequest') }} </p>
      <div>
        <h2 class="secondary">{{ translate('AbTesting_RunExperimentWithJsClient') }}</h2>
        <div>
          <div
            class="alert alert-warning"
            v-show="jsIncludeTemplateCode"
          >
            {{ translate('AbTesting_CustomJsNotAllowedWarning') }}
            <br /><br />
            <div>
              <pre v-copy-to-clipboard="{}"><code>chmod 0755 matomo.js</code></pre>
            </div>
            {{ translate('AbTesting_IncludeAbTestingTrackerCode') }}
            <br /><br />
            <div>
              <pre v-copy-to-clipboard="{}"><code>{{ jsIncludeTemplateCode }}</code></pre>
            </div>
          </div>
          <p v-html="$sanitize(getRunExperimentsInJsTracker)"></p>
          <div>
            <pre v-copy-to-clipboard="{}"><code>{{ jsExperimentTemplateCode }}</code></pre>
          </div>
          <div class="alert alert-info">
            {{ translate('AbTesting_UpdateExperimentWarning') }}
            <br />
            <br />
            {{ translate('AbTesting_TestVariationViaUrl') }}
          </div>
        </div>
        <h2 class="secondary">{{ translate('AbTesting_RunExperimentWithJsTracker') }}</h2>
        <div>
          <p v-html="$sanitize(getRunningTestOnServer)"></p>
          <p>{{ translate('AbTesting_HowToRunTestOnServer') }}</p>
          <div>
            <pre v-copy-to-clipboard="{}"><code>var _paq = _paq || [];
_paq.push(['AbTesting::enter', {experiment: '{{ name }}', 'variation': 'myVariationName'}]);

// {{ translate('AbTesting_CodeCommentUseOriginal') }}
_paq.push(['AbTesting::enter', {experiment: '{{ name }}', 'variation': 'original'}]);

// {{ translate('AbTesting_CodeCommentUseExperimentId') }}
_paq.push(['AbTesting::enter', {experiment: '{{ idExperiment }}', 'variation': 'original'}]);
            </code></pre>
          </div>
        </div>
        <h2 class="secondary">{{ translate('AbTesting_RunExperimentWithOtherSDK') }}</h2>
        <div>
          <p v-html="$sanitize(getAppTrackingDescription)"></p>
          <p>{{ translate('AbTesting_HeadingAppTrackingExample') }}</p>
          <div>
            <pre v-copy-to-clipboard="{}">
<code>_paq.push(['trackEvent', 'abtesting', '{{ experiment.name }}', 'name of variation']);

// {{ translate('AbTesting_CodeCommentUseOriginal') }}
_paq.push(['trackEvent', 'abtesting', '{{ experiment.name }}', 'original']);</code></pre>
          </div>
          <p>{{ translate('AbTesting_HeadingPhpTracker') }}</p>
          <div>
            <pre v-copy-to-clipboard="{}">
<code>$tracker-&gt;doTrackEvent('abtesting', '{{ experiment.name }}', 'name of variation');

// {{ translate('AbTesting_CodeCommentUseOriginal') }}
$tracker-&gt;doTrackEvent('abtesting', '{{ experiment.name }}', 'original');</code></pre>
          </div>
          <div class="alert alert-info" v-html="$sanitize(getAppTrackingAlertText)">
          </div>
        </div>
        <h2 class="secondary">{{ translate('AbTesting_RunExperimentWithEmailCampaign') }}</h2>
        <div>
          <p v-html="$sanitize(getRunningInCampaignDescription)"></p>
          <div>
            <pre v-copy-to-clipboard="{}">
<code>&pk_abe={{ experiment.name }}&pk_abv=myVariationName

// {{ translate('AbTesting_CodeCommentUseOriginal') }}
&pk_abe={{ experiment.name }}&pk_abv=original

// {{ translate('AbTesting_CodeCommentUseExperimentIdUrl') }}
&pk_abe={{ experiment.idexperiment }}&pk_abv=myVariationName</code></pre>
          </div>
          <h2 class="secondary">{{ translate('AbTesting_NeedHelp') }}</h2>
          <p v-html="$sanitize(getNeedHelpDevZone)"></p>
          <p v-html="$sanitize(getNeedHelpGetInTouch)"></p>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import {
  CopyToClipboard,
  translate,
} from 'CoreHome';
import { Experiment } from '../../types';

export default defineComponent({
  props: {
    experiment: {
      type: Object,
      required: true,
    },
    jsIncludeTemplateCode: {
      type: String,
      required: true,
    },
    jsExperimentTemplateCode: {
      type: String,
      required: true,
    },
  },
  directives: {
    CopyToClipboard,
  },
  computed: {
    name() {
      return (this.experiment as Experiment).name;
    },
    idExperiment() {
      return (this.experiment as Experiment).idexperiment;
    },
    getRunExperimentsInJsTracker() {
      return translate('AbTesting_RunExperimentsInJsTracker',
        '<a target="blank" rel="noreferrer" href="https://developer.matomo.org/guides/ab-tests/browser">',
        '</a>');
    },
    getRunningTestOnServer() {
      return translate('AbTesting_RunningTestOnServer',
        '<a target="blank" rel="noreferrer" href="https://developer.matomo.org/guides/ab-tests/server">',
        '</a>');
    },
    getAppTrackingDescription() {
      return translate('AbTesting_AppTrackingDescription',
        '<a target="blank" rel="noreferrer" href="https://developer.matomo.org/guides/ab-tests/apps">',
        '</a>',
        '<a target="blank" rel="noreferrer" href="https://github.com/innocraft/php-experiments">',
        '</a>');
    },
    getAppTrackingAlertText() {
      return translate('AbTesting_AppTrackingAlertText',
        '<a target="blank" rel="noreferrer" href="https://developer.matomo.org/guides/tracking-api-clients">',
        '</a>',
        '<a target="blank" rel="noreferrer" href="https://matomo.org/integrate/">',
        '</a>',
        '<a target="blank" rel="noreferrer" href="https://developer.matomo.org/api-reference/tracking-api">',
        '</a>', '<code>', '</code>');
    },
    getRunningInCampaignDescription() {
      return translate('AbTesting_RunningInCampaignDescription',
        '<a target="blank" rel="noreferrer" href="https://developer.matomo.org/guides/ab-tests/campaign">',
        '</a>');
    },
    getNeedHelpDevZone() {
      return translate('AbTesting_NeedHelpDevZone',
        '<a target="blank" rel="noreferrer" href="https://developer.matomo.org/integration">',
        '</a>');
    },
    getNeedHelpGetInTouch() {
      return translate('AbTesting_NeedHelpGetInTouch',
        '<a target="blank" rel="noreferrer" href="https://matomo.org/contact/">',
        '</a>');
    },
  },
});
</script>
