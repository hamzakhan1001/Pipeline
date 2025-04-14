/**
 * Copyright (C) InnoCraft Ltd - All rights reserved.
 *
 * NOTICE:  All information contained herein is, and remains the property of InnoCraft Ltd.
 * The intellectual and technical concepts contained herein are protected by trade secret
 * or copyright law. Redistribution of this information or reproduction of this material is
 * strictly forbidden unless prior written permission is obtained from InnoCraft Ltd.
 *
 * You shall use this code only in accordance with the license agreement obtained from
 * InnoCraft Ltd.
 *
 * @link https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */

import {
  reactive,
  computed,
  readonly,
  DeepReadonly,
} from 'vue';
import { AjaxHelper, MatomoUrl } from 'CoreHome';
import CrashContext from './CrashContext';

const DEFAULT_LIMIT = 5;

interface CrashStoreState {
  limit: number;
  offset: number;
  crashContexts: CrashContext[];
  limitOptions: number[];
  period: string;
  date: string;
  idLogCrash?: number|null;
}

class CrashContextStore {
  private privateState = reactive<CrashStoreState>({
    limit: DEFAULT_LIMIT,
    offset: 0,
    crashContexts: [],
    limitOptions: [5, 10, 25, 50, 100, 250, 500],
    period: MatomoUrl.parsed.value.period as string,
    date: MatomoUrl.parsed.value.date as string,
    idLogCrash: null,
  });

  readonly requestParams = computed(() => readonly({
    method: 'CrashAnalytics.getCrashVisitContext',
    filter_limit: this.privateState.limit,
    filter_offset: this.privateState.offset,
    period: this.privateState.period,
    date: this.privateState.date,
    idSite: MatomoUrl.urlParsed.value.idSite,
    segment: MatomoUrl.parsed.value.segment,
  }));

  readonly limitOptions = computed(() => readonly(this.privateState.limitOptions));

  readonly crashContexts = computed(() => readonly(this.privateState.crashContexts));

  reset(period?: string, date?: string) {
    this.privateState.period = period || MatomoUrl.parsed.value.period as string;
    this.privateState.date = date || MatomoUrl.parsed.value.date as string;
    this.privateState.offset = 0;
    this.privateState.limit = DEFAULT_LIMIT;
    this.privateState.crashContexts = [];
  }

  fetch(
    idLogCrash?: number,
    paramsOverride: QueryParameters = {},
  ): Promise<DeepReadonly<CrashContext[]>> {
    if (idLogCrash) {
      this.privateState.idLogCrash = idLogCrash;
    }
    return AjaxHelper.fetch<CrashContext[]>(
      {
        ...this.requestParams.value,
        ...paramsOverride,
        idLogCrash: idLogCrash || this.privateState.idLogCrash,
      },
      {
        createErrorNotification: false,
      },
    ).then((contexts) => {
      this.privateState.crashContexts = contexts;

      return this.crashContexts.value;
    });
  }

  prevPage(): Promise<DeepReadonly<CrashContext[]>> {
    this.privateState.offset = Math.max(0, this.privateState.offset - this.privateState.limit);
    return this.fetch();
  }

  nextPage(): Promise<DeepReadonly<CrashContext[]>> {
    this.privateState.offset += this.privateState.limit;
    return this.fetch();
  }

  setLimit(limit: number): Promise<DeepReadonly<CrashContext[]>> {
    this.privateState.limit = limit;
    return this.fetch();
  }

  setPeriod(period: string, date: string): Promise<DeepReadonly<CrashContext[]>> {
    this.privateState.period = period;
    this.privateState.date = date;
    this.privateState.offset = 0;
    return this.fetch();
  }
}

export default new CrashContextStore();
