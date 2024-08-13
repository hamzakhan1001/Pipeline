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

namespace Piwik\Plugins\SEOWebVitals\Diagnostic;

use Piwik\ArchiveProcessor\Rules;
use Piwik\Plugins\Diagnostics\Diagnostic\Diagnostic;
use Piwik\Plugins\Diagnostics\Diagnostic\DiagnosticResult;
use Piwik\SettingsPiwik;
use Piwik\Translation\Translator;
use Piwik\Url;

class BrowserArchiveCheck implements Diagnostic
{
    /**
     * @var Translator
     */
    private $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function execute()
    {
        $result = [];

        if (Rules::isBrowserTriggerEnabled()) {
            $label = $this->translator->translate('SEOWebVitals_DiagnosticReportPerformance');
            $comment = $this->translator->translate('SEOWebVitals_DiagnosticReportPerformanceComment', ['', ' ' . Url::addCampaignParametersToMatomoLink('https://matomo.org/faq/on-premise/how-to-set-up-auto-archiving-of-your-reports/') . ' ']);
            $result[] = DiagnosticResult::singleResult($label, DiagnosticResult::STATUS_WARNING, $comment);
        }
        if (!SettingsPiwik::isInternetEnabled()) {
            $label = $this->translator->translate('SEOWebVitals_SEOWebVitals');
            $comment = $this->translator->translate('SEOWebVitals_DiagnosticInternetDisabledComment');
            $result[] = DiagnosticResult::singleResult($label, DiagnosticResult::STATUS_WARNING, $comment);
        }

        return $result;
    }

}
