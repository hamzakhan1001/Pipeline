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

import { translate, createVueApp } from 'CoreHome';
import CrashDetails from './CrashDetails.vue';
import CrashStore from './CrashStore';

const { $ } = window;

const actionName = 'CrashDetails';

function getIdLogCrashFromRow(tr: HTMLElement|JQuery) {
  try {
    const rowMetadata = JSON.parse($(tr).attr('data-row-metadata')!);
    if (!rowMetadata.idlogcrash) {
      return 0;
    }
    return parseInt(rowMetadata.idlogcrash as string, 10);
  } catch (err) {
    return 0;
  }
}

// eslint-disable-next-line
const DataTable_RowAction = (window as any).DataTable_RowAction;

class CrashDetailsRowAction extends DataTable_RowAction {
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  constructor(dataTable: any) {
    super(dataTable);

    this.actionName = actionName;
    this.trEventName = 'piwikTriggerCrashDetailAction';
  }

  openPopover(apiAction: string, idLogCrash: string|number, extraParams: QueryParameters) {
    const urlParam = `${apiAction}:${encodeURIComponent(idLogCrash)}:${encodeURIComponent(JSON.stringify(extraParams))}`;
    broadcast.propagateNewPopoverParameter('RowAction', `${actionName}:${urlParam}`);
  }

  trigger(tr: HTMLElement|JQuery) {
    const idLogCrash = getIdLogCrashFromRow(tr);
    if (!idLogCrash) {
      return;
    }

    this.performAction(idLogCrash);
  }

  performAction(idLogCrash: string|number) {
    const apiAction = this.dataTable.param.action;

    this.openPopover(apiAction, idLogCrash, {
      period: this.dataTable.param.period,
      date: this.dataTable.param.date,
    });
  }

  doOpenPopover(urlParam: string) {
    const popover = window.Piwik_Popover.showLoading(translate('CrashAnalytics_CrashDetails'));

    const [, idLogCrashStr, extraParamsStr] = urlParam.split(':');

    const idLogCrash = parseInt(idLogCrashStr, 10);
    if (!idLogCrash) {
      return;
    }

    let extraRequestParams: QueryParameters = {};
    try {
      extraRequestParams = JSON.parse(decodeURIComponent(extraParamsStr));
    } catch (e) {
      // ignore
    }

    CrashStore.fetchCrash(idLogCrash, extraRequestParams)
      .then((crash) => {
        if (!crash) {
          window.Piwik_Popover.setTitle(translate('CrashAnalytics_FailedToLoadCrash'));
          window.Piwik_Popover.setContent(translate('CrashAnalytics_CrashDataMissing'));

          popover.dialog();
          return;
        }

        const props = { crash, extraRequestParams };

        const app = createVueApp({
          template: '<popover v-bind="bind"/>',
          data() {
            return {
              bind: props,
            };
          },
        });
        app.component('popover', CrashDetails);

        const mountPoint = document.createElement('div');
        app.mount(mountPoint);

        window.Piwik_Popover.setTitle(`"${crash.message}"`);
        window.Piwik_Popover.setContent(mountPoint);

        popover.dialog();
      });
  }
}

// eslint-disable-next-line @typescript-eslint/no-explicit-any
(window as any).DataTable_RowActions_Registry.register({
  name: actionName,

  dataTableIcon: 'icon-zoom-in',

  order: 51,

  dataTableIconTooltip: [
    translate('CrashAnalytics_SeeCrashDetails'),
    '',
  ],

  isAvailableOnReport(dataTableParams: QueryParameters) {
    return dataTableParams && dataTableParams.module === 'CrashAnalytics';
  },

  isAvailableOnRow(dataTableParams: QueryParameters, tr: HTMLElement|JQuery) {
    return getIdLogCrashFromRow(tr) > 0;
  },

  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  createInstance(dataTable: any) {
    if (dataTable !== null && typeof dataTable.crashDetailsInstance !== 'undefined') {
      return dataTable.crashDetailsInstance;
    }

    const instance = new CrashDetailsRowAction(dataTable);
    if (dataTable !== null) {
      dataTable.crashDetailsInstance = instance;
    }

    return instance;
  },
});
