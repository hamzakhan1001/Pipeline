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
 * @link    https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */

namespace Piwik\Plugins\SearchEngineKeywordsPerformance\Reports;

use Piwik\Piwik;
use Piwik\Plugin\ReportsProvider;
use Piwik\Plugin\ViewDataTable;
use Piwik\Plugins\SearchEngineKeywordsPerformance\Columns\Keyword;

class GetKeywordsImported extends \Piwik\Plugins\SearchEngineKeywordsPerformance\Reports\Base
{
    protected function init()
    {
        parent::init();
        $this->dimension = new Keyword();
        $this->name = Piwik::translate('SearchEngineKeywordsPerformance_KeywordsCombinedImported');
        $this->documentation = Piwik::translate('SearchEngineKeywordsPerformance_KeywordsCombinedImportedDocumentation');
        $this->subcategoryId = null;
        // hide report
    }
    public function isEnabled()
    {
        $reportsEnabled = 0;
        $reportsEnabled += (int) parent::isGoogleEnabledForType('image');
        $reportsEnabled += (int) parent::isGoogleEnabledForType('web');
        $reportsEnabled += (int) parent::isGoogleEnabledForType('video');
        $reportsEnabled += (int) parent::isGoogleEnabledForType('news');
        $reportsEnabled += (int) parent::isBingEnabled();
        return $reportsEnabled > 1;
    }
    public function getRelatedReports()
    {
        return [ReportsProvider::factory('SearchEngineKeywordsPerformance', 'getKeywords'), ReportsProvider::factory('Referrers', 'getKeywords')];
    }
    public function configureView(ViewDataTable $view)
    {
        parent::configureView($view);
        $this->formatCtrAndPositionColumns($view);
    }
    public function alwaysUseDefaultViewDataTable()
    {
        return \true;
    }
}
