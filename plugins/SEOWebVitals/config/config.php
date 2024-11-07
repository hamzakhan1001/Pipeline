<?php

return [

    'SEOWebVitals_PageSpeed_ApiKey' => function (\Piwik\Container\Container $c) {
        $systemSettings = $c->get(\Piwik\Plugins\SEOWebVitals\SystemSettings::class);
        return $systemSettings->apiKey->getValue();
    },
    'diagnostics.optional' => \Piwik\DI::add(array(
        \Piwik\DI::get('Piwik\Plugins\SEOWebVitals\Diagnostic\BrowserArchiveCheck'),
    )),
    'Piwik\Plugins\SEOWebVitals\Dao\PageSpeedApi' => \Piwik\DI::autowire()
        ->constructorParameter('apiKey', \Piwik\DI::get('SEOWebVitals_PageSpeed_ApiKey')),
];
