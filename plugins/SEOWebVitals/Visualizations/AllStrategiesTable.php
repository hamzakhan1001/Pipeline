<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

namespace Piwik\Plugins\SEOWebVitals\Visualizations;

use Piwik\Common;
use Piwik\DataTable\Row;
use Piwik\Piwik;
use Piwik\Plugin\ViewDataTable;
use Piwik\Plugins\CoreVisualizations\Visualizations\HtmlTable;
use Piwik\Plugins\SEOWebVitals\Dao\PageSpeedApi;
use Piwik\Plugins\SEOWebVitals\Dao\PageSpeedReport;
use Piwik\Plugins\SEOWebVitals\Metrics;

/**
 * DataTable Visualization that derives from HtmlTable and sets show_extra_columns to true.
 */
class AllStrategiesTable extends HtmlTable
{
    public const ID = 'tableWebVitalsAllStrategies';
    public const FOOTER_ICON       = 'icon-table';
    public const FOOTER_ICON_TITLE = 'SEOWebVitals_AllStrategies';

    private $colorRed = '#d4291f';
    private $colorOrange = '#ff9600';
    private $colorGreen = '#43a047';

    public function beforeRender()
    {
        parent::beforeRender();
        $this->config->datatable_css_class = 'dataTableVizHtmlTable';
    }

    public function getCellHtmlAttributes(Row $row, $column)
    {
        $auditId = $row->getMetadata('audit_id');
        if (
            $auditId && in_array($auditId, [
                    'first-contentful-paint', 'first-meaningful-paint', 'total-blocking-time',
                    'largest-contentful-paint', 'cumulative-layout-shift'
                ])
        ) {
            return ['style' => 'font-weight:bold'];
        } elseif ($auditId) {
            return; // performance improvement as not needed to check any other columns
        }

        $metricMobileScore = Metrics::appendStrategy(Metrics::METRIC_PERFORMANCE_SCORE, PageSpeedApi::STRATEGY_MOBILE);
        $metricDesktopScore = Metrics::appendStrategy(Metrics::METRIC_PERFORMANCE_SCORE, PageSpeedApi::STRATEGY_DESKTOP);

        if ($row->getColumn($metricDesktopScore) === '' && $row->getColumn($metricMobileScore) === '') {
            if ($column !== 'label') {
                $row->setColumn($column, '');
            }
            $errorMessage = Piwik::translate('SEOWebVitals_ErrorNotEnoughData');
            if ($row->getColumn(PageSpeedReport::ERROR_SITE_NOT_ACCESSIBLE)) {
                $errorMessage = Piwik::translate('SEOWebVitals_ErrorNotAccessible');
            } elseif ($row->getColumn(PageSpeedReport::ERROR_SSL_REQUIRED)) {
                $errorMessage = Piwik::translate('SEOWebVitals_ErrorInvalidSSL');
            } elseif ($row->getColumn(PageSpeedReport::ERROR_ACCESS_DENIED)) {
                $errorMessage = Piwik::translate(
                    'SEOWebVitals_ErrorAccessDenied',
                    array(
                        '<a href="https://console.developers.google.com/apis/api/pagespeedonline.googleapis.com/overview?" target="_blank" rel="noreferrer noopener">Google Console</a>'
                    )
                );
            }
            return ['title' => $errorMessage];
        }

        if (in_array($column, [$metricDesktopScore, $metricMobileScore])) {
            $val = $row->getColumn($column);

            if ($val && $val > 49 && $val < 90) {
                $color = $this->colorOrange;
                $title = Piwik::translate('SEOWebVitals_PerformanceCategoryAverage');
            } elseif ($val && $val >= 90) {
                $color = $this->colorGreen;
                $title = Piwik::translate('SEOWebVitals_PerformanceCategoryFast');
            } elseif (($val && $val >= 0 ) || $val === 0 || $val === '0') {
                $color = $this->colorRed;
                $title = Piwik::translate('SEOWebVitals_PerformanceCategorySlow');
            } else {
                return;
            }

            return [
                'style' => 'color: ' . $color,
                'title' => Piwik::translate('SEOWebVitals_ScoreIsConsidered', $title)
            ];
        }
        foreach (PageSpeedApi::getAllStrategies() as $strategy) {
            foreach (Metrics::TOP_LEVEL_NUMERIC_CATEGORY_MAPPING as $numericValue => $category) {
                $columnToCheck = Metrics::appendStrategy($numericValue, $strategy);

                if ($columnToCheck === $column) {
                    $color = $this->convertCategoryToColor($row, $category, $strategy);
                    $title = $this->convertCategoryToTitle($row, $category, $strategy);
                    if ($color) {
                        return [
                            'style' => 'color: ' . $color,
                            'title' => Piwik::translate('SEOWebVitals_ScoreIsConsidered', $title)
                        ];
                    }
                }
            }
        }
    }

    private function convertCategoryToColor(Row $row, $category, $strategy)
    {
        $column = Metrics::appendStrategy($category, $strategy);
        $val = $row->getColumn($column);
        if ($val) {
            $val = Common::mb_strtoupper($val);
        }
        if ($val == PageSpeedReport::CATEGORY_FAST) {
            return $this->colorGreen;
        }
        if ($val == PageSpeedReport::CATEGORY_AVERAGE) {
            return $this->colorOrange;
        }
        if ($val == PageSpeedReport::CATEGORY_SLOW) {
            return $this->colorRed;
        }
    }

    private function convertCategoryToTitle(Row $row, $category, $strategy)
    {
        $column = Metrics::appendStrategy($category, $strategy);
        $val = $row->getColumn($column);
        return PageSpeedReport::translateCategory($val);
    }

    public static function canDisplayViewDataTable(ViewDataTable $view)
    {
        return $view->requestConfig->getApiModuleToRequest() === 'SEOWebVitals';
    }
}
