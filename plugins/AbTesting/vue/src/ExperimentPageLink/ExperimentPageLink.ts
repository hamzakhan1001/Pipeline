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

import { DirectiveBinding } from 'vue';
import { Matomo, MatomoUrl } from 'CoreHome';

const { $ } = window;

interface ExperimentPageLinkArgs {
  idExperiment: string|number;
}

// usage v-experiment-page-link="{ idExperiment: 5 }"
const ExperimentPageLink = {
  mounted(el: HTMLElement, binding: DirectiveBinding<ExperimentPageLinkArgs>): void {
    if (!Matomo.helper.isReportingPage()) {
      return;
    }

    let link = $(el);

    if (el.tagName.toLowerCase() !== 'a') {
      const headline = $(el).text();
      $(el).html('<a></a>');

      link = $(el).find('a');
      link.text(headline);
    }

    link
      .css('margin-right', '3.5px')
      .bind('click', (e) => {
        e.preventDefault();

        MatomoUrl.updateHash({
          ...MatomoUrl.hashParsed.value,
          category: 'AbTesting_Experiments',
          subcategory: binding.value.idExperiment,
        });
      });
  },
};

export default ExperimentPageLink;

// manually handle occurrence of piwik-experiment-page-link on datatable html attributes since
// dataTable.js is not managed by vue.
// eslint-disable-next-line @typescript-eslint/no-explicit-any
Matomo.on('Matomo.processDynamicHtml', ($element: JQuery) => {
  $element.find('[piwik-experiment-page-link]').each((i, e) => {
    if ($(e).attr('piwik-experiment-page-link-handled')) {
      return;
    }

    const idExperiment = $(e).attr('piwik-experiment-page-link');
    if (idExperiment) {
      ExperimentPageLink.mounted(e, {
        instance: null,
        value: {
          idExperiment,
        },
        oldValue: null,
        modifiers: {},
        dir: {},
      });
    }

    $(e).attr('piwik-experiment-page-link-handled', '1');
  });
});
