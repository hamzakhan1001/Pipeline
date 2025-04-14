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
  <div class="mergeCrashes">
    <div class="intro">
      <h2>
        {{ translate('CrashAnalytics_Merging' )}} '{{ crash.message }}' @ {{ truncatedResourceUri }}
      </h2>
      <p>
        {{ translate('CrashAnalytics_MergeCrashesIntro1') }}
      </p>
    </div>
    <div class="notMergable" v-if="!isMergable && !isInline">
      <Notification
        type="transient"
        context="info"
        :noclear="true"
      >
        {{ translate('CrashAnalytics_CrashHasAlreadyBeenMerged') }}
      </Notification>
    </div>
    <div class="notMergable" v-if="isInline">
      <Notification
        type="transient"
        context="info"
        :noclear="true"
      >
        {{ translate('CrashAnalytics_InlineCrashesCannotBeMerged') }}
      </Notification>
    </div>
    <div class="crashSearch" :class="{ loading: isLoading }" v-if="isMergable && !isInline">
      <div class="searchHeader">
        <Field
          v-model="search"
          uicontrol="text"
          :placeholder="`${translate('CrashAnalytics_EnterSearchTerm')}...`"
        />
      </div>
      <table v-content-table>
        <thead>
          <tr>
            <th></th>
            <th>{{ translate('CrashAnalytics_CrashMessage') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="searchResults !== null && searchResults.length === 0">
            <td colspan="2">
              <em>{{ translate('CrashAnalytics_NoCrashesToMergeWith') }}</em>
            </td>
          </tr>
          <tr v-for="row in (searchResults || [])" :key="row.idlogcrash">
            <td>
              <label>
                <input
                  type="checkbox"
                  :checked="selectedCrashes[row.idlogcrash]"
                  @change="selectedCrashes[row.idlogcrash] = selectedCrashes[row.idlogcrash]
                    ? undefined : row.message"
                />
                <span/>
              </label>
            </td>
            <td>{{ row.message }}</td>
          </tr>
        </tbody>
      </table>
      <div class="pagination">
        <a href="" @click.prevent="prev()" :class="{ disabled: !hasPrev }" class="prev">
          {{ translate('General_Previous') }}
        </a>

        <span class="divider" :class="{ disabled: !hasPrev || !hasNext }">&mdash;</span>

        <a href="" @click.prevent="next()" :class="{ disabled: !hasNext }" class="next">
          {{ translate('General_Next') }}
        </a>
      </div>
    </div>
    <div class="footer">
      <a
        href=""
        class="modal-action modal-close btn mergeBtn"
        @click.prevent="merge()"
        style="margin-right:3.5px"
        :disabled="isLoading || toMergeCrashes.length < 1 ? 'disabled' : undefined"
      >{{ translate('CrashAnalytics_Merge') }}</a>
      <a
        href=""
        class="modal-action modal-close modal-no"
        @click.prevent="cancel()"
      >{{ translate('General_Cancel') }}</a>
    </div>

    <div
      class="ui-confirm confirmMergeCrashes"
      id="confirmMergeCrashes"
      ref="confirmMergeCrashes"
    >
      <h3>
        {{ translate('CrashAnalytics_AreYouSureYouWantToMerge', truncatedResourceUri) }}
      </h3>
      <ul class="browser-default">
        <li>{{ crash.message }}</li>
        <li v-for="(message, index) in toMergeCrashes" :key="index">{{ message }}</li>
      </ul>
      <Alert severity="info">
        <p>
          <span v-html="$sanitize(ifMergedTheseCrashesWillAppearAs)">
          </span>
          <span v-if="reArchiveLastN <= 0" style="margin-left:4px;">
            {{ translate('CrashAnalytics_ThisWillOnlyApplyToFutureReports') }}
          </span>
          <span v-if="reArchiveLastN > 0" style="margin-left:4px;">
            {{ translate('CrashAnalytics_ThisWillApplyToFutureReportsAndSomeInPast',
              reArchiveLastN) }}
          </span>
        </p>
      </Alert>

      <input
        role="no"
        type="button"
        :value="translate('General_No')"
      />
      <input
        role="yes"
        type="button"
        :value="translate('General_Yes')"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import {
  AjaxHelper,
  ContentTable,
  Matomo,
  NotificationsStore,
  translate,
  debounce,
  Notification,
  Alert,
} from 'CoreHome';
import { Field } from 'CorePluginsAdmin';
import Crash from '../Crash';

const NUMBER_OF_RESULTS_TO_SHOW = 10;

interface SearchResultRow {
  idlogcrash: number|string;
  message: string;
}

interface MergeCrashesState {
  isLoading: boolean;
  searchResults: SearchResultRow[]|null;
  search: string;
  offset: number;
  limit: number;
  selectedCrashes: Record<number|string, string>;
  hasNext: boolean;
  hasPrev: boolean;
}

export default defineComponent({
  props: {
    crash: {
      type: Object,
      required: true,
    },
  },
  directives: {
    ContentTable,
  },
  components: {
    Field,
    Notification,
    Alert,
  },
  data(): MergeCrashesState {
    return {
      isLoading: false,
      searchResults: null,
      search: '',
      offset: 0,
      limit: NUMBER_OF_RESULTS_TO_SHOW,
      selectedCrashes: {},
      hasNext: false,
      hasPrev: false,
    };
  },
  created() {
    this.onSearchChanged = debounce(this.onSearchChanged);

    this.fetch();
  },
  watch: {
    search() {
      this.onSearchChanged();
    },
  },
  methods: {
    onSearchChanged() {
      this.fetch();
    },
    fetch() {
      const crash = this.crash as Crash;

      this.isLoading = true;
      AjaxHelper.fetch<SearchResultRow[]>({
        method: 'CrashAnalytics.searchCrashMessagesForMerge',
        searchTerm: this.search,
        resourceUri: crash.resource_uri,
        limit: this.limit + 1,
        offset: this.offset,
        excludeIdLogCrashes: [crash.idlogcrash],
      }).then((results) => {
        this.hasNext = results.length > this.limit;
        this.hasPrev = this.offset > 0;
        this.searchResults = results.slice(0, this.limit);
      }).finally(() => {
        this.isLoading = false;
      });
    },
    prev() {
      if (this.offset <= 0) {
        return;
      }

      this.offset -= this.limit;
      this.fetch();
    },
    next() {
      if (!this.hasNext) {
        return;
      }

      this.offset += this.limit;
      this.fetch();
    },
    merge() {
      Matomo.helper.modalConfirm(this.$refs.confirmMergeCrashes as HTMLElement, {
        yes: () => {
          const idLogCrashes = Object.entries(this.selectedCrashes)
            .filter(([, message]) => !!message)
            .map(([idlogcrash]) => idlogcrash)
            .concat([this.crash.idlogcrash]);

          this.isLoading = true;
          AjaxHelper.fetch({
            method: 'CrashAnalytics.mergeCrashes',
            idLogCrashes,
          }).then(() => {
            window.Piwik_Popover.close();

            NotificationsStore.scrollToNotification(NotificationsStore.show({
              id: 'mergeSuccess',
              message: translate('CrashAnalytics_MergeSuccess'),
              context: 'success',
              type: 'toast',
            }));
          });
        },
      });
    },
    cancel() {
      window.Piwik_Popover.close();
    },
  },
  computed: {
    isInline() {
      const crash = this.crash as Crash;
      return crash.resource_uri === 'inline';
    },
    truncatedResourceUri() {
      const crash = this.crash as Crash;
      const resourceUri = crash.resource_uri || translate('General_Unknown');
      if (resourceUri.length > 100) {
        return `${resourceUri.substring(0, 100)}...`;
      }
      return resourceUri;
    },
    toMergeCrashes() {
      return Object.values(this.selectedCrashes).filter((m) => !!m).sort();
    },
    isMergable() {
      const crash = this.crash as Crash;
      return !crash.group_idlogcrash || crash.group_idlogcrash === crash.idlogcrash;
    },
    lowestIdlogcrashMessage() {
      const crash = this.crash as Crash;

      const selectedCrashes = Object.entries(this.selectedCrashes)
        .map(([idlogcrash, message]) => ({ idlogcrash: parseInt(idlogcrash, 10), message }));

      const allCrashesInMerge = [...selectedCrashes, crash];
      allCrashesInMerge.sort((lhs, rhs) => lhs.idlogcrash - rhs.idlogcrash);

      return `<em>"${allCrashesInMerge[0].message}"</em>`;
    },
    ifMergedTheseCrashesWillAppearAs() {
      return translate(
        'CrashAnalytics_IfMergedTheseCrashesWillAppearAs',
        this.lowestIdlogcrashMessage,
      );
    },
    reArchiveLastN() {
      // eslint-disable-next-line @typescript-eslint/no-explicit-any
      return (Matomo as any).CrashAnalytics.reArchiveReportsLastN as number;
    },
  },
});
</script>
