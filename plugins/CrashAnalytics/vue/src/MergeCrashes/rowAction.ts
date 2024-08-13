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

import { translate, createVueApp, Matomo } from 'CoreHome';
import CrashStore from '../CrashDetails/CrashStore';
import MergeCrashes from './MergeCrashes';

const { $ } = window;

const actionName = 'MergeCrashes';

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

class MergeCrashesRowAction extends DataTable_RowAction {
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  constructor(dataTable: any) {
    super(dataTable);

    this.actionName = actionName;
    this.trEventName = 'piwikTriggerMergeCrashesAction';
  }

  openPopover(apiAction: string, idLogCrash: string|number) {
    const urlParam = `${apiAction}:${encodeURIComponent(idLogCrash)}`;
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

    this.openPopover(apiAction, idLogCrash);
  }

  doOpenPopover(urlParam: string) {
    const popover = window.Piwik_Popover.showLoading(translate('CrashAnalytics_MergeCrashes')); // TODO translate

    const [, idLogCrashStr] = urlParam.split(':');

    const idLogCrash = parseInt(idLogCrashStr, 10);
    if (!idLogCrash) {
      return;
    }

    CrashStore.fetchCrash(idLogCrash, {})
      .then((crash) => {
        if (!crash) {
          window.Piwik_Popover.setTitle(translate('CrashAnalytics_FailedToLoadCrash'));
          window.Piwik_Popover.setContent(translate('CrashAnalytics_CrashDataMissing'));

          popover.dialog();
          return;
        }

        const props = { crash };

        const app = createVueApp({
          template: '<popover v-bind="bind"/>',
          data() {
            return {
              bind: props,
            };
          },
        });
        app.component('popover', MergeCrashes);

        const mountPoint = document.createElement('div');
        app.mount(mountPoint);

        window.Piwik_Popover.setTitle(translate('CrashAnalytics_MergeCrashes'));
        window.Piwik_Popover.setContent(mountPoint);

        popover.dialog();
      });
  }
}

// eslint-disable-next-line @typescript-eslint/no-explicit-any
(window as any).DataTable_RowActions_Registry.register({
  name: actionName,

  dataTableIcon: 'plugins/CrashAnalytics/images/merge.svg',

  order: 52,

  dataTableIconTooltip: [
    translate('CrashAnalytics_MergeCrashes'),
    '',
  ],

  isAvailableOnReport(dataTableParams: QueryParameters) {
    return dataTableParams && dataTableParams.module === 'CrashAnalytics';
  },

  isAvailableOnRow(dataTableParams: QueryParameters, tr: HTMLElement|JQuery) {
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    return (Matomo as any).CrashAnalytics.hasWriteAccess
      && getIdLogCrashFromRow(tr) > 0;
  },

  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  createInstance(dataTable: any) {
    if (dataTable !== null && typeof dataTable.mergeCrashesInstance !== 'undefined') {
      return dataTable.mergeCrashesInstance;
    }

    const instance = new MergeCrashesRowAction(dataTable);
    if (dataTable !== null) {
      dataTable.mergeCrashesInstance = instance;
    }

    return instance;
  },
});
