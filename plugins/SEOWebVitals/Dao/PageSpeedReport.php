<?php
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

namespace Piwik\Plugins\SEOWebVitals\Dao;

use Piwik\Common;
use Piwik\Piwik;

class PageSpeedReport
{

    const ERROR_SITE_NOT_ACCESSIBLE = 'site_not_accessible';
    const ERROR_SSL_REQUIRED = 'ssl_required';
    const ERROR_ACCESS_DENIED = 'access_denied';

    const CATEGORY_FAST = 3;
    const CATEGORY_AVERAGE = 2;
    const CATEGORY_SLOW = 1;
    const CATEGORY_NONE = 0;

    private $report = [];

    private $auditMetrics = [];

    public function __construct($report)
    {
        $this->report = $report;
        if (!empty($this->report['lighthouseResult']['audits'])) {
            foreach ($this->report['lighthouseResult']['audits'] as $audit) {
                if (!empty($audit['title']) && isset($audit['description'])) {
                    $id = $audit['id'];
                    $this->auditMetrics[$id] = ['title' => $audit['title'], 'description' => $audit['description']];
                }
            }
        }
    }

    /**
     * Will only work when report was fetched not when it comes from a cached result.
     * Returns the title and description for each audit metric.
     * @return array
     */
    public function getAuditMetrics()
    {
        return $this->auditMetrics;
    }

    public function removeUnneededFields()
    {
        //  We don't want to store the entire response in the DB, only the needed fields for less storage
        unset($this->report['originLoadingExperience']);
        unset($this->report['lighthouseResult']['categories']['auditRefs']);
        unset($this->report['lighthouseResult']['categories']['title']);
        unset($this->report['lighthouseResult']['categoryGroups']);
        unset($this->report['lighthouseResult']['configSettings']);
        unset($this->report['lighthouseResult']['environment']);
        unset($this->report['lighthouseResult']['i18n']);
        unset($this->report['lighthouseResult']['stackPacks']);
        foreach ($this->report['lighthouseResult']['audits'] as $i => &$audit) {
            unset($audit['details']);
            unset($audit['items']);
            unset($audit['title']);
            unset($audit['description']);
        }
        return $this->report;
    }

    public function hasAudits()
    {
        return !empty($this->report['lighthouseResult']['audits']);
    }

    public function getCumulativeLayoutShiftCategory()
    {
        return $this->getCategory('CUMULATIVE_LAYOUT_SHIFT_SCORE');
    }

    public function getFirstInputDelayCategory()
    {
        return $this->getCategory('FIRST_INPUT_DELAY_MS');
    }

    public function getLargestContentfulPaintCategory()
    {
        return $this->getCategory('LARGEST_CONTENTFUL_PAINT_MS');
    }

    public function getFirstContentfulPaintCategory()
    {
        return $this->getCategory('FIRST_CONTENTFUL_PAINT_MS');
    }

    public function getInteractionToNextPaintCategory()
    {
        return $this->getCategory('INTERACTION_TO_NEXT_PAINT');
    }

    public function getCumulativeLayoutShiftValue()
    {
        $val = $this->getPercentile('CUMULATIVE_LAYOUT_SHIFT_SCORE');
        if (empty($val)) {
            return 0;
        }
        return $val / 100;
    }

    public function getInteractionToNextPaintValue()
    {
        return $this->getPercentile('INTERACTION_TO_NEXT_PAINT');
    }

    public function getFirstInputDelayValue()
    {
        return $this->getPercentile('FIRST_INPUT_DELAY_MS');
    }

    public function getLargestContentfulPaintValue()
    {
        return $this->getPercentile('LARGEST_CONTENTFUL_PAINT_MS');
    }

    public function getFirstContentfulPaintValue()
    {
        return $this->getPercentile('FIRST_CONTENTFUL_PAINT_MS');
    }

    public function getPerformanceScore()
    {
        if (isset($this->report['lighthouseResult']['categories']['performance']['score'])) {
            $score = $this->report['lighthouseResult']['categories']['performance']['score'];
            if ($score || $score === 0 || $score === '0') {
                return round($score * 100, 2);
            }
        }
        return '';
    }

    public static function translateCategory($value)
    {
        $value = (int) $value;
        $key = '';
        if ($value >= self::CATEGORY_FAST && $value < self::CATEGORY_FAST + 1) {
            $key = 'Fast';
        } elseif ($value >= self::CATEGORY_AVERAGE && $value < self::CATEGORY_FAST) {
            $key = 'Average';
        } elseif ($value >= self::CATEGORY_SLOW && $value < self::CATEGORY_AVERAGE) {
            $key = 'Slow';
        }
        if ($key) {
            $translationKey = 'SEOWebVitals_PerformanceCategory' . $key;

            $translation = Piwik::translate($translationKey);
            if ($translation !== $translationKey) {
                return $translation;
            }
        }
        return $key;
    }

    private function getCategory($metric)
    {
        if (isset($this->report['loadingExperience']['metrics'][$metric]['category'])) {
            $category = $this->report['loadingExperience']['metrics'][$metric]['category'];
            if ($category === 'FAST') {
                return self::CATEGORY_FAST;
            } elseif ($category === 'AVERAGE') {
                return self::CATEGORY_AVERAGE;
            } elseif ($category === 'SLOW') {
                return self::CATEGORY_SLOW;
            } elseif ($category === 'NONE') {
                return self::CATEGORY_NONE;
            }
        }
    }

    private function getPercentile($metric)
    {
        if (isset($this->report['loadingExperience']['metrics'][$metric]['percentile'])) {
            return $this->report['loadingExperience']['metrics'][$metric]['percentile'];
        }
    }

    public function getAudits()
    {
        return $this->report['lighthouseResult']['audits'];
    }

    public function toArray()
    {
        return $this->report;
    }

    public function hasLoadingExperience()
    {
        return !empty($this->report['loadingExperience']['metrics']);
    }

}
