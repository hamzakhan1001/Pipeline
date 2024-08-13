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

import { AjaxHelper, Matomo, MatomoUrl } from 'CoreHome';
import { Experiment } from './types';

function isGettingStartedPage() {
  const url = window.location.href;
  return url.indexOf('category=AbTesting_Experiments&subcategory=AbTesting_GettingStarted') !== -1;
}

function checkForExperiment() {
  if (!isGettingStartedPage()) {
    return;
  }

  AjaxHelper.fetch<Experiment[]>({
    method: 'AbTesting.getActiveExperiments',
  }).then((experiments) => {
    if (!isGettingStartedPage()) {
      return;
    }

    if (experiments?.length && experiments?.[0]?.idexperiment) {
      MatomoUrl.updateUrl(
        {
          ...MatomoUrl.urlParsed.value,
          idSite: Matomo.idSite,
        },
        {
          ...MatomoUrl.hashParsed.value,
          category: 'AbTesting_Experiments',
          subcategory: experiments[0].idexperiment,
        },
      );
    }
  }).catch(() => {
    // we ignore errors
  });
}

export default function checkForActiveExperiments(): void {
  const msInSecond = 1000;
  setTimeout(checkForExperiment, msInSecond);
  setTimeout(checkForExperiment, 10 * msInSecond);
  setTimeout(checkForExperiment, 60 * msInSecond);
  setTimeout(checkForExperiment, 300 * msInSecond);
  setTimeout(checkForExperiment, 600 * msInSecond);
  setTimeout(checkForExperiment, 3000 * msInSecond);
  setTimeout(checkForExperiment, 6000 * msInSecond);
}
