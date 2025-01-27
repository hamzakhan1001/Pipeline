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
    const exports = require('piwik/UI');
    const JqplotGraphDataTable = exports.JqplotGraphDataTable;
    const JqplotGraphDataTablePrototype = JqplotGraphDataTable.prototype;

    exports.CohortsEvolutionGraphDataTable = function (element) {
        JqplotGraphDataTable.call(this, element);
    };

    /**
     * All the functions overridden below were copied from plugins/CoreVisualizations/javascripts/jqplotEvolutionGraph.js.
     * The main change is updating the viewDataTable value so that the colours get set correctly.
     */
    $.extend(exports.CohortsEvolutionGraphDataTable.prototype, JqplotGraphDataTablePrototype, {
        _setJqplotParameters: function (params) {
            // Save the current viewDataTable value and override it with a generic one
            const viewDataTable = $('div.dataTableVizCohortsLineChart').data('uiControlObject').param['viewDataTable'];
            $('div.dataTableVizCohortsLineChart').data('uiControlObject').param['viewDataTable'] = 'graphEvolution';

            JqplotGraphDataTablePrototype._setJqplotParameters.call(this, params);

            // Revert back to the specific viewDataTable value now that the colours are set
            $('div.dataTableVizCohortsLineChart').data('uiControlObject').param['viewDataTable'] = viewDataTable;

            const defaultParams = {
                axes: {
                    xaxis: {
                        pad: 1.0,
                        renderer: $.jqplot.CategoryAxisRenderer,
                        tickOptions: {
                            showGridline: false
                        }
                    }
                },
                piwikTicks: {
                    showTicks: true,
                    showGrid: true,
                    showHighlight: true,
                    tickColor: this.tickColor
                }
            };

            if (this.props.show_line_graph) {
                defaultParams.seriesDefaults = {
                    lineWidth: 1,
                    markerOptions: {
                        style: "filledCircle",
                        size: 6,
                        shadow: false
                    }
                };
            } else {
                defaultParams.seriesDefaults = {
                    renderer: $.jqplot.BarRenderer,
                    rendererOptions: {
                        shadowOffset: 1,
                        shadowDepth: 2,
                        shadowAlpha: .2,
                        fillToZero: true,
                        barMargin: this.data[0].length > 10 ? 2 : 10
                    }
                };
            }

            const overrideParams = {
                legend: {
                    show: false
                },
                canvasLegend: {
                    show: true
                }
            };

            this.jqplotParams = $.extend(true, {}, defaultParams, this.jqplotParams, overrideParams);
        },

        _bindEvents: function () {
            JqplotGraphDataTablePrototype._bindEvents.call(this);

            const self = this;

            $('#' + this.targetDivId)
                .on('jqplotMouseLeave', function (e, s, i, d) {
                    $(this).css('cursor', 'default');
                    JqplotGraphDataTablePrototype._destroyDataPointTooltip.call(this, $(this));
                })
                .on('jqplotClick', function (e, s, i, d) {
                    if (!self.jqplotParams.axes.xaxis.onclick ||
                        !self._plot.plugins.piwikTicks ||
                        typeof self._plot.plugins.piwikTicks.currentXTick !== 'number'
                    ) {
                        return;
                    }

                    const tick = self._plot.plugins.piwikTicks.currentXTick;

                    if (typeof self.jqplotParams.axes.xaxis.onclick[tick] !== 'string') {
                        return;
                    }

                    const url = self.jqplotParams.axes.xaxis.onclick[tick];

                    broadcast.propagateNewPage(url);
                })
                .on('jqplotPiwikTickOver', function (e, tick) {
                    const dataByAxis = {};

                    for (let d = 0; d < self.data.length; ++d) {
                        const valueUnformatted = self.data[d][tick];

                        if (typeof valueUnformatted === 'undefined' || valueUnformatted === null) {
                            continue;
                        }

                        const axis = self.jqplotParams.series[d]._xaxis || 'xaxis';

                        if (!dataByAxis[axis]) {
                            dataByAxis[axis] = [];
                        }

                        const value = self.formatY(valueUnformatted, d);
                        const series = self.jqplotParams.series[d].label;
                        const seriesColor = self.jqplotParams.seriesColors[d];

                        dataByAxis[axis].push(
                            `<span class="tooltip-series-color" style="background-color: ${seriesColor}"></span>` +
                            `<strong>${value}</strong> ${piwikHelper.htmlEntities(series)}`
                        );
                    }

                    let xAxisCount = 0;

                    Object.keys(self.jqplotParams.axes).forEach(function (axis) {
                        if (!axis.startsWith('x')) {
                            return;
                        }

                        ++xAxisCount;
                    });

                    let content = '';

                    for (let i = 0; i < xAxisCount; ++i) {
                        const axisName = i === 0 ? 'xaxis' : `x${i + 1}axis`;

                        if (!dataByAxis[axisName] || !dataByAxis[axisName].length) {
                            continue;
                        }

                        let label;

                        if (typeof self.jqplotParams.axes[axisName].labels !== 'undefined') {
                            label = self.jqplotParams.axes[axisName].labels[tick];
                        } else {
                            label = self.jqplotParams.axes[axisName].ticks[tick];
                        }

                        if (typeof label === 'undefined') {
                            // sanity check
                            continue;
                        }

                        content += `
                                        <h3 class="evolution-tooltip-header">${piwikHelper.htmlEntities(label)}</h3>
                                        ${dataByAxis[axisName].join('<br />')}
                                    `;
                    }

                    switch (self.jqplotParams.dataStates[tick]) {
                        case 'incomplete':
                            content += `<br />(${self._lang.incompletePeriod})`;
                            break;

                        case 'invalidated':
                            content += `<br />(${self._lang.invalidatedPeriod})`;
                            break;
                    }

                    $(this).tooltip({
                        track:   true,
                        items:   'div',
                        content: content,
                        show:    false,
                        hide:    false
                    }).trigger('mouseover');

                    if (typeof self.jqplotParams.axes.xaxis.onclick !== 'undefined' &&
                        typeof self.jqplotParams.axes.xaxis.onclick[tick] === 'string'
                    ) {
                        $(this).css('cursor', 'pointer');
                    }
                });

            this.setYTicks();
        },

        _destroyDataPointTooltip: function () {
            // do nothing, tooltips are destroyed in the jqplotMouseLeave event
        },

        render: function () {
            JqplotGraphDataTablePrototype.render.call(this);

            if (!initializeSparklines) {
                return;
            }

            initializeSparklines();
        }
    });
})(jQuery, require);
