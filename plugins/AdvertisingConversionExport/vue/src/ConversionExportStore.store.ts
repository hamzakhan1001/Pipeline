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
import {
  AjaxHelper,
  Matomo,
  Site,
  translate,
} from 'CoreHome';
import { ConversionExport } from './types';

interface Goal {
  idgoal: string|number;
  name: string;
  allow_multiple: string|number|boolean;
  case_sensitive: string|number|boolean;
  deleted: string|number|boolean;
  description: string;
  event_value_as_revenue: string|number|boolean;
  idsite: string|number;
  match_attribute: string;
  pattern: string;
  pattern_type: string;
  revenue: string|number;
  revenue_pretty?: string;
}

interface Option {
  key: string;
  value: string;
}

interface SiteWithEcommerce extends Site {
  ecommerce: string|number;
}

interface ConversionExportStoreState {
  exports: ConversionExport[];
  sites: SiteWithEcommerce[];
  goals: Option[];
  isLoading: boolean;
  isLoadingGoals: boolean;
  isUpdating: boolean;
}

class ConversionExportStore {
  private privateState = reactive<ConversionExportStoreState>({
    exports: [],
    sites: [],
    goals: [],
    isLoading: false,
    isLoadingGoals: false,
    isUpdating: false,
  });

  readonly state = computed(() => readonly(this.privateState));

  readonly exports = computed(() => this.state.value.exports);

  readonly isEcommerceSite = computed(() => {
    const loadedSite = this.state.value.sites.find(
      (s) => parseInt(s.idsite as string, 10) === parseInt(Matomo.idSite as string, 10),
    );
    const isEcommerce = loadedSite?.ecommerce;
    return isEcommerce === 1 || isEcommerce === '1';
  });

  readonly goals = computed(() => {
    const result: Option[] = [];
    if (this.isEcommerceSite.value) {
      result.push({
        key: '0',
        value: translate('General_EcommerceOrders'),
      });
    }
    return readonly([...result, ...this.state.value.goals]);
  });

  private fetchPromise: Promise<ConversionExport[]>|null = null;

  private fetchSitePromise: Promise<SiteWithEcommerce[]>|null = null;

  reload(): Promise<ConversionExportStore['exports']['value']> {
    this.privateState.exports = [];
    this.fetchPromise = null;
    return this.fetchExports();
  }

  fetchExports(): Promise<ConversionExportStore['exports']['value']> {
    if (!this.fetchPromise) {
      this.fetchPromise = AjaxHelper.fetch({
        method: 'AdvertisingConversionExport.getConversionExports',
        idSite: Matomo.idSite,
        filter_limit: '-1',
      });
    }

    this.privateState.isLoading = true;
    this.privateState.exports = [];

    return Promise.all([
      this.fetchPromise,
      this.fetchSites(),
      this.fetchGoals(),
    ]).then(([exports]) => {
      this.privateState.exports = exports as ConversionExport[];
      return this.exports.value;
    }).finally(() => {
      this.privateState.isLoading = false;
    });
  }

  fetchGoals(): Promise<ConversionExportStore['goals']['value']> {
    if (this.state.value.goals.length) {
      return Promise.resolve(this.state.value.goals);
    }

    this.privateState.isLoadingGoals = true;
    return AjaxHelper.fetch<Record<string|number, Goal>>({
      module: 'API',
      method: 'Goals.getGoals',
      idSite: Matomo.idSite,
      filter_limit: '-1',
    }).then((goals) => {
      this.privateState.goals = Object.values(goals).map((g) => ({
        key: `${g.idgoal}`,
        value: g.name,
      }));
      return this.goals.value;
    }).finally(() => {
      this.privateState.isLoadingGoals = false;
    });
  }

  fetchSites(): Promise<ConversionExportStore['state']['value']['sites']> {
    if (this.state.value.sites.length) {
      return Promise.resolve(this.state.value.sites);
    }

    if (!this.fetchSitePromise) {
      this.fetchSitePromise = AjaxHelper.fetch<SiteWithEcommerce[]>({
        module: 'API',
        method: 'SitesManager.getSitesWithAtLeastViewAccess',
        filter_limit: '-1',
      });
    }

    return this.fetchSitePromise.then((sites) => {
      this.privateState.sites = sites || [];
      return this.state.value.sites;
    });
  }

  findExport(idExport: number): Promise<DeepReadonly<ConversionExport>> {
    // before going through an API request we first try to find it in loaded forms
    const found = this.state.value.exports.find((exp) => parseInt(`${exp.idexport}`, 10) === idExport);
    if (found) {
      return Promise.resolve(found);
    }

    // otherwise we fetch it via API
    this.privateState.isLoading = true;
    return Promise.all([
      AjaxHelper.fetch<ConversionExport>({
        idExport,
        method: 'AdvertisingConversionExport.getConversionExport',
      }),
      this.fetchSites(),
    ]).then(
      ([exp]) => readonly(exp as ConversionExport),
    ).finally(() => {
      this.privateState.isLoading = false;
    });
  }

  deleteExport(idExport: number): Promise<{ type: string, message?: string }> {
    this.privateState.isUpdating = true;
    this.privateState.exports = [];
    return AjaxHelper.fetch(
      {
        idExport,
        method: 'AdvertisingConversionExport.deleteConversionExport',
      },
      {
        withTokenInUrl: true,
      },
    ).then(
      () => ({ type: 'success' }),
    ).catch((error) => ({
      type: 'error',
      message: error.message || error as string,
    })).finally(() => {
      this.privateState.isUpdating = false;
    });
  }

  regenerateAccessToken(idExport: number): Promise<{ value: string }> {
    this.privateState.isUpdating = true;
    this.privateState.exports = [];

    return AjaxHelper.fetch(
      {
        idExport,
        method: 'AdvertisingConversionExport.regenerateAccessToken',
      },
      {
        withTokenInUrl: true,
      },
    ).finally(() => {
      this.privateState.isUpdating = false;
    });
  }

  createOrUpdateExport(
    conversionExport: ConversionExport,
    method: string,
  ): Promise<{ type: string, message?: string, response?: { value: string|number } }> {
    this.privateState.isUpdating = true;
    const onlyDirectAttribution = [true, 'true', 1, '1']
      .includes(conversionExport.parameters?.onlyDirectAttribution ?? false) ? 1 : 0;
    const externalAttributedConversion = [true, 'true', 1, '1']
      .includes(conversionExport.parameters?.externalAttributedConversion ?? false) ? 1 : 0;
    return AjaxHelper.post(
      {},
      {
        idExport: conversionExport.idexport,
        name: conversionExport.name.trim(),
        type: conversionExport.type,
        description: conversionExport.description.trim(),
        method,
        parameters: {
          ...(conversionExport.parameters || {}),
          onlyDirectAttribution,
          externalAttributedConversion,

          // remove goal configs where no goal was chosen
          goals: (conversionExport.parameters?.goals || [])
            .filter((g) => g.idgoal !== '' && g.idgoal! >= 0),
        },
      },
      {
        withTokenInUrl: true,
      },
    ).then((response) => ({
      type: 'success',
      response,
    })).catch((e) => ({
      type: 'error',
      message: e.message || e,
    })).finally(() => {
      this.privateState.isUpdating = false;
    });
  }
}

export default new ConversionExportStore();
