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

    var exports = require('piwik/UI'),
        DataTable = exports.DataTable,
        DataTablePrototype = DataTable.prototype;

    /**
     * UI control that handles extra functionality for Media datatables.
     *
     * @constructor
     */
    exports.FunnelEntryExitDataTable = function (element) {
        this.parentAttributeParent = '';
        this.parentId = '';

        DataTable.call(this, element);
    };

    $.extend(exports.FunnelEntryExitDataTable.prototype, DataTablePrototype, {
        postBindEventsAndApplyStyleHook: function (domElem) {
            $('tr.subDataTable:first', domElem).click();
        },
        notifyWidgetParametersChange: function (domWidget, parameters) {
            // Don't do anything since we don't want to save these parameters
        },
        handleSubDataTable: function (domElem) {
            var self = this;
            // When the TR has a subDataTable class it means that this row has a link to a subDataTable
            self.numberOfSubtables = $('tr.subDataTable', domElem)
                .click(
                    function () {
                      // get the idSubTable
                        var idSubTable = $(this).attr('id');
                        var divIdToReplaceWithSubTable = 'subDataTable_' + idSubTable;

                        // if the subDataTable is not already loaded
                        if (typeof self.loadedSubDataTable[divIdToReplaceWithSubTable] == "undefined") {
                            $metaData = $(this).data('row-metadata');
                            $tableDepth = $metaData.table_depth;

                            var numberOfColumns = $(this).closest('table').find('thead tr').first().children().length;

                            var $insertAfter = $(this).nextUntil(':not(.comparePeriod):not(.comparisonRow)').last();
                            if (!$insertAfter.length) {
                                $insertAfter = $(this);
                            }

                            // at the end of the query it will replace the ID matching the new HTML table #ID
                            // we need to create this ID first
                            var newRow = $insertAfter.after(
                                '<tr class="subDataTableContainer">' +
                                '<td colspan="' + numberOfColumns + '" class="cellSubDataTable">' +
                                '<div id="' + divIdToReplaceWithSubTable + '">' +
                                '<span class="loadingPiwik" style="display:inline"><img src="plugins/Morpheus/images/loading-blue.gif" />' + _pk_translate('General_Loading') + '</span>' +
                                '</div>' +
                                '</td>' +
                                '</tr>'
                            );

                            // piwikHelper.lazyScrollTo(newRow);

                            var savedActionVariable = self.param.action;

                            // reset all the filters from the Parent table
                            var filtersToRestore = self.resetAllFilters();
                            // do not ignore the exclude low population click
                            self.param.enable_filter_excludelowpop = filtersToRestore.enable_filter_excludelowpop;

                            self.param.action = self.props.subtable_controller_action;
                            self.param.tableDepth = $tableDepth;
                            delete self.param.comparisonIdSubtables;
                            delete self.param.idSubtable;
                            self.param.step = $metaData.step_position;
                            self.param.subStepType = $metaData.sub_step_type;

                            delete self.param.totalRows;

                            var extraParams = {};
                            extraParams.comparisonIdSubtables = self.getComparisonIdSubtables($(this));

                            self.reloadAjaxDataTable(false, function (response) {
                                self.dataTableLoaded(response, divIdToReplaceWithSubTable);
                            }, extraParams);

                            self.param.action = savedActionVariable;
                            delete self.param.idSubtable;
                            self.restoreAllFilters(filtersToRestore);

                            self.loadedSubDataTable[divIdToReplaceWithSubTable] = true;

                            // when "loading..." is displayed, hide actions
                            // repositioning after loading is not easily possible
                            $(this).find('div.dataTableRowActions').hide();
                        } else {
                            var $toToggle = $(this).nextUntil('.subDataTableContainer').last();
                            $toToggle = $toToggle.length ? $toToggle : $(this);
                            $toToggle.next().toggle();
                        }

                        $(this).toggleClass('expanded');
                        self.repositionRowActions($(this));
                    }
                ).length;
        }
    });

})(jQuery, require);
