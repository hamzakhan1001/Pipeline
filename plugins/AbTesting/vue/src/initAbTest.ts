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

import { Matomo, MatomoUrl } from 'CoreHome';

let abTestControlInitialized = false;

const { $, initTopControls } = window;

export default function initAbTest(): void {
  const topControls = '.top_controls #abtestPeriod';
  const dateSelector = '#periodString';

  $(dateSelector).hide();
  $(topControls).remove();
  $('#abtestPeriod').insertAfter('#periodString');

  if (typeof initTopControls !== 'undefined' && initTopControls) {
    initTopControls();
  }

  if (!abTestControlInitialized) {
    abTestControlInitialized = true;
    Matomo.on('piwikPageChange', () => {
      const { href } = window.location;
      const subcategory = MatomoUrl.hashParsed.value.subcategory as string;

      const clickIsNotOnAbTest = !href
        || (href.indexOf('&category=AbTesting_Experiments&subcategory=') === -1)
        || (subcategory && !/^\d+$/.test(String(subcategory)));

      if (clickIsNotOnAbTest) {
        $(dateSelector).show();
        $(topControls).remove();

        if (typeof initTopControls !== 'undefined' && initTopControls) {
          initTopControls();
        }
      }
    });
  }
}

// for backwards compatibility
declare global {
  interface Window {
    initAbTest: typeof initAbTest;
  }
}

window.initAbTest = initAbTest;
