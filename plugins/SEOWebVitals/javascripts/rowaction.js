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

/**
 * This file registers the Overlay row action on the report.
 */

(function () {
    var actionName = 'pageSpeedLink';

    function DataTable_RowActions_OpenPageSpeed(dataTable) {
        this.dataTable = dataTable;
        this.actionName = actionName;
        this.trEventName = 'matomoTriggerOpenPageSpeedAction';
    }

    DataTable_RowActions_OpenPageSpeed.prototype = new DataTable_RowAction();

    DataTable_RowActions_OpenPageSpeed.prototype.performAction = function (label, tr, e) {
        var url = tr.data('url-label');
        var pageSpeedUrl = 'https://developers.google.com/speed/pagespeed/insights/?url=';
        window.open(pageSpeedUrl + encodeURIComponent(url), '_blank');
    };

    DataTable_RowActions_OpenPageSpeed.prototype.doOpenPopover = function (parameter) {
    };

    DataTable_RowActions_Registry.register({
        name: actionName,

        dataTableIcon: 'icon-show',

        order: 30,

        dataTableIconTooltip: [
            _pk_translate('SEOWebVitals_RowActionTooltipTitle'),
            _pk_translate('SEOWebVitals_RowActionTooltipDefault')
        ],

        isAvailableOnReport: function (dataTableParams) {
            return dataTableParams && dataTableParams.module && dataTableParams.module === 'SEOWebVitals' && !dataTableParams.idSubtable;
        },

        isAvailableOnRow: function (dataTableParams, tr) {
            return true;
        },

        createInstance: function (dataTable, param) {
            var instance = new DataTable_RowActions_OpenPageSpeed(dataTable);

            return instance;
        }

    });
})();
