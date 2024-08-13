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

import { Matomo, translate } from 'CoreHome';

Matomo.on('Live.initializeVisitorActions', (elem: HTMLElement) => {
  const { $ } = window;

  function setLastActionClass($list: JQuery) {
    $list.children(':not(.actionsForPageExpander):not(.duplicate)').removeClass('last-action').last().addClass('last-action');
  }

  // event handler for content expander/collapser
  $(elem).on('click', '.collapsed-crashes', function onClickCollapsedCrashes(this: HTMLElement) {
    $(this).nextUntil(':not(.crash-action)').toggleClass('duplicate');
    setLastActionClass($(this).closest('ol.actionList'));
  });

  function makeCollapsedCrashes() {
    const $li = $('<li/>')
      .attr('class', 'crash-action collapsed-crashes')
      .attr('title', translate('CrashAnalytics_ClickToSeeAllCrashes'));

    const xCrashes = translate('CrashAnalytics_XCrashes', '<span class="crashes">0</span>');
    $('<div>')
      .html(`<img src="plugins/CrashAnalytics/images/crash.png" class="action-list-action-icon"/>${xCrashes}`)
      .appendTo($li);

    return $li;
  }

  function addCrashItem($collapsedCrashes: JQuery, $otherLi: JQuery) {
    if ($collapsedCrashes.find('.crashes').length) {
      const $crashes = $collapsedCrashes.find('.crashes');
      $crashes.text(parseInt($crashes.text(), 10) + 1);
    }

    $otherLi.addClass('duplicate').addClass('collapsed-crash-item').val('').attr('style', '');
  }

  // collapse adjacent crashes
  $('ol.visitorLog', elem).each((ignore, visitorLogElem) => {
    const $actions = $(visitorLogElem).find('li');
    $actions.each((index, actionElem) => {
      const $li = $(actionElem);
      if (!$li.is('.crash-action')) {
        return;
      }

      if (!$actions[index - 1]
        || !$($actions[index - 1]).is('.crash-action')
        || !$actions[index - 2]
        || !$($actions[index - 2]).is('.crash-action')
      ) {
        return;
      }

      let $collapsedCrashes: JQuery = $li;
      while ($collapsedCrashes.prev().is('.crash-action')) {
        $collapsedCrashes = $collapsedCrashes.prev();
      }

      if (!$collapsedCrashes.is('.collapsed-crashes')) {
        $collapsedCrashes = makeCollapsedCrashes();
        $collapsedCrashes.insertBefore($($actions[index - 2]));

        addCrashItem($collapsedCrashes, $($actions[index - 2]));
        addCrashItem($collapsedCrashes, $($actions[index - 1]));
      }

      addCrashItem($collapsedCrashes, $li);
    });
  });
});
