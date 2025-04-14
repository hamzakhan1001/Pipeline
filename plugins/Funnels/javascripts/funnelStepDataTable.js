/**
 * Copyright (C) InnoCraft Ltd - All rights reserved.
 *
 * NOTICE:  All information contained herein is, and remains the property of InnoCraft Ltd.
 * The intellectual and technical concepts contained herein are protected by trade secret or copyright law.
 * Redistribution of this information or reproduction of this material is strictly forbidden
 * unless prior written permission is obtained from InnoCraft Ltd.
 *
 * You shall use this code only in accordance with the license agreement obtained from InnoCraft Ltd.
 *
 * @link https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */

(function ($, require) {

    const exports = require('piwik/UI'),
      DataTable = exports.DataTable,
      DataTablePrototype = DataTable.prototype;

    const entryExitTooltipTitle = _pk_translate('Funnels_EntriesAndExitsActionTooltipTitle');
    const entryExitTooltip = _pk_translate('Funnels_EntriesAndExitsActionTooltip');
    const visitLogTooltipTitle = _pk_translate('Live_RowActionTooltipTitle');
    const visitLogTooltip = _pk_translate('Funnels_SegmentVisitorsByThisFunnelStep');
    const evolutionTooltipTitle = _pk_translate('General_RowEvolutionRowActionTooltipTitle');
    const evolutionTooltip = _pk_translate('General_RowEvolutionRowActionTooltip');

    function getTooltipSetup(tooltipText, tooltipTitle = '')
    {
        return {
            track: true,
            items: 'a',
            content: '<h3>' + tooltipTitle + '</h3>' + tooltipText,
            tooltipClass: 'rowActionTooltip',
            // ensure the tooltips of parent elements are hidden when the action tooltip is shown
            // otherwise it can happen that tooltips for subtable rows are shown as well.
            open: function () {
                const tooltip = $(this).parents('.matomo-widget').tooltip('instance');
                if (tooltip) {
                    tooltip.disable();
                }
            },
            close: function () {
                const tooltip = $(this).parents('.matomo-widget').tooltip('instance');
                if (tooltip) {
                    tooltip.enable();
                }
            },
            show: false,
            hide: false
        };
    }

    function getMetricAsFloat(object)
    {
        if (!object.length) {
            return 0;
        }

        // We have to use the symbol group instead of comma for international number formats
        const partiallyConvertedString = object.text().replace(new RegExp('\\' + piwik.numbers.symbolGroup, 'g'), '');
        // Replace the decimal symbol so that parseFloat works correctly
        return parseFloat(partiallyConvertedString.replace(new RegExp('\\' + piwik.numbers.symbolDecimal, 'g'), '.'));
    }

    function addRateLabels(row)
    {
        const isComparison = row.hasClass('comparisonRow');
        const metadata = isComparison ? getMetadataFromParentRow(row) : getMetadataFromRow(row);

        // Set the exits rate as part of that column
        if (metadata.step_exited_rate && !isComparison) {
            const exitsRateSpan = $('<span />');
            exitsRateSpan.addClass('value rateSpan');
            exitsRateSpan.text('(' + metadata.step_exited_rate + ')');
            row.find('td:nth-last-child(2)').append(exitsRateSpan);
        }

        // Set the proceeds rate as part of that column
        if (metadata.step_proceeded_rate && !isComparison) {
            const proceedsRateSpan = $('<span />');
            proceedsRateSpan.addClass('value rateSpan');
            proceedsRateSpan.text('(' + metadata.step_proceeded_rate + ')');
            row.find('td:nth-last-child(3)').append(proceedsRateSpan);
        }

        // If it's not a compare, no need to continue
        if (!isComparison) {
            return;
        }

        // Set the exits and proceeds rates for comparisons
        const visits = getMetricAsFloat(row.find('td:nth-child(2)'));
        const exits = getMetricAsFloat(row.find('td:nth-last-child(2)'));
        if (visits > 0 && exits > 0) {
            const exitsRateSpan = $('<span />');
            exitsRateSpan.addClass('value rateSpan');
            // Calculate the rate and round to one decimal
            const rateFloat = ((exits / visits) * 100).toFixed(1);
            const percentString = NumberFormatter.formatPercent(rateFloat);
            exitsRateSpan.text('(' + percentString + ')');
            row.find('td:nth-last-child(2)').append(exitsRateSpan);
        }

        const proceeds = getMetricAsFloat(row.find('td:nth-last-child(3)'));
        if (visits > 0 && proceeds > 0) {
            const proceedsRateSpan = $('<span />');
            proceedsRateSpan.addClass('value rateSpan');
            // Calculate the rate and round to one decimal
            const rateFloat = ((proceeds / visits) * 100).toFixed(1);
            const percentString = NumberFormatter.formatPercent(rateFloat);
            proceedsRateSpan.text('(' + percentString + ')');
            row.find('td:nth-last-child(3)').append(proceedsRateSpan);
        }
    }

    function addRowActions(row)
    {
        const isComparison = row.hasClass('comparisonRow');
        const metadata = isComparison ? getMetadataFromParentRow(row) : getMetadataFromRow(row);
        const actionTd = row.find('td:last');
        // Clear the contents of the td
        actionTd.html('');
        actionTd.addClass('funnelStepActions');
        addRowAction(actionTd, 'icon-show', entryExitTooltip, entryExitTooltipTitle, handleEntryExitClick);
        // Only show the visitor profile icon if that feature is enabled
        if (metadata.isVisitorLogEnabled) {
            addRowAction(actionTd, 'icon-visitor-profile', visitLogTooltip, visitLogTooltipTitle, handleVisitorProfileClick);
        }
        addRowAction(actionTd, 'icon-evolution', evolutionTooltip, evolutionTooltipTitle, handleEvolutionClick);
    }

    function addRowAction(actionTd, iconClass, tooltipText, TooltipTitle, clickEventHandler)
    {
        var anchor = $('<a />');
        var span = $('<span />');
        span.addClass(iconClass + ' rowActionIcon');
        anchor.append(span);
        actionTd.append(anchor);
        anchor.tooltip(getTooltipSetup(tooltipText, TooltipTitle));
        anchor.on('click', clickEventHandler);
    }

    function openStepEntryExitsPopover(label, extraParams)
    {
        // open the popover
        const entryExitTitle = _pk_translate('Funnels_EntriesAndExits');
        const box = Piwik_Popover.showLoading(entryExitTitle);
        box.addClass('stepEntriesAndExitsPopover');

        // prepare loading the popover contents
        const requestParams = {
            disableLink: 1
        };

        const callback = function (html) {
            const stepText = _pk_translate('Funnels_Step');
            const title = `${entryExitTitle}: ${stepText} ${extraParams.stepPosition}`;
            Piwik_Popover.setTitle(title);
            Piwik_Popover.setContent(html);

            Piwik_Popover.onClose(function () {
                // Remove the class so that other modals aren't affected by the styling for this one
                box.removeClass('stepEntriesAndExitsPopover');
            });
        };

        requestParams.module = 'Funnels';
        requestParams.action = 'getFunnelStepEntriesExits';

        $.extend(requestParams, extraParams);

        const ajaxRequest = new ajaxHelper();
        ajaxRequest.addParams(requestParams, 'get');
        ajaxRequest.withTokenInUrl();
        ajaxRequest.setCallback(callback);
        ajaxRequest.setFormat('html');
        ajaxRequest.send();
    }

    function getMetadataFromParentRow(tr)
    {
        if (tr && $(tr).hasClass('comparisonRow')) {
            $row = $(tr);
            $dataLabel = $row.data('label');
            return JSON.parse($row.siblings(`tr[data-label="${$dataLabel}"]`).attr('data-row-metadata') || '{}');
        }
    }

    function getMetadataFromRow(tr)
    {
        if (tr) {
            return JSON.parse($(tr).attr('data-row-metadata') || '{}');
        }
    }

    function getParamsFromRowParentTable(tr)
    {
        if (tr) {
            return JSON.parse($(tr).closest('div.dataTable[data-table-type="FunnelStepDataTable"]').attr('data-params') || '{}');
        }
    }

    function getOverrideDataParamsFromRow(tr)
    {
        if (tr) {
            return JSON.parse($(tr).attr('data-param-override') || '{}');
        }
    }

    function handleEntryExitClick(event)
    {
        const tr = event.target.closest('tr');
        const label = $(tr).data('label');
        const isComparison = $(tr).hasClass('comparisonRow');
        const metadata = isComparison ? getMetadataFromParentRow(tr) : getMetadataFromRow(tr);
        const params = getParamsFromRowParentTable(tr);

        $extraParams = {};
        if (isComparison) {
            $extraParams = getOverrideDataParamsFromRow(tr);
        }

        $extraParams.stepPosition = metadata.step_position;
        $extraParams.idGoal = params.idGoal;
        $extraParams.idFunnel = params.idFunnel;
        openStepEntryExitsPopover(label, $extraParams);
    }

    function handleVisitorProfileClick(event)
    {
        const tr = event.target.closest('tr');
        const isComparison = $(tr).hasClass('comparisonRow');
        const metadata = isComparison ? getMetadataFromParentRow(tr) : getMetadataFromRow(tr);
        const params = getParamsFromRowParentTable(tr);

        $extraParams = {};
        if (isComparison) {
            $extraParams = getOverrideDataParamsFromRow(tr);
        }

        const segment = params.segment ? `;${params.segment}` : ($extraParams.segment ? `;${$extraParams.segment}` : '');

        // Remove the segment from the extra params so that it doesn't override the funnel portion of the segment
        if ($extraParams && $extraParams.segment) {
            delete $extraParams.segment;
        }

        window.SegmentedVisitorLog.show(
            'Funnel.getFunnelFlow',
            `funnels_name==${params.idFunnel};funnels_step_position==${metadata.step_position}${segment}`,
            $extraParams,
        );
    }

    function handleEvolutionClick(event)
    {
        const tr = event.target.closest('tr');
        var label = $(tr).data('label');
        if (label) {
            label = encodeURIComponent(label);
        }
        const isComparison = $(tr).hasClass('comparisonRow');
        const params = getParamsFromRowParentTable(tr);

        $extraParams = {};
        if (isComparison) {
            $extraParams = getOverrideDataParamsFromRow(tr);
        }
        // Make sure that the goal and funnel IDs are set for the API request
        $extraParams.idGoal = params.idGoal;
        $extraParams.idFunnel = params.idFunnel;

        DataTable_RowActions_RowEvolution.prototype.showRowEvolution('Funnels.getFunnelFlow', label, $extraParams);
    }

    /**
     * UI control that handles extra functionality for Media datatables.
     *
     * @constructor
     */
    exports.FunnelStepDataTable = function (element) {
        DataTable.call(this, element);
    };

    $.extend(exports.FunnelStepDataTable.prototype, DataTablePrototype, {
        createRowActions: function (availableActionsForReport, tr, actionInstances) {},
        applyCosmetics: function (domElem) {
            // Remove the columnSorted class, so that styling is applied to the header correctly
            domElem.find('th.columnSorted').removeClass('columnSorted');

            // Iterate over the rows
            domElem.find('tbody > tr:not(.comparePeriod)').each(function (index) {
                const row = $(this);

                // Set the tooltip for the row
                row.attr('title', JSON.parse(row.attr('data-row-metadata') || '{}').step_definition);

                // Add the rate labels for the row
                addRateLabels($(this));

                // Add the actions for the step
                addRowActions($(this));

                // If there isn't a prefix-numeral, add a prefix
                const labelTd = row.find('td.label.first');
                if (!labelTd.find('span.prefix-numeral').length) {
                    const span = $('<span />');
                    span.addClass('prefix-numeral');
                    span.text((index + 1) + '. ');
                    labelTd.prepend(span);
                }
            });
        },
    });
})(jQuery, require);
