<?php

use Piwik\Plugins\AdvertisingConversionExport\AttributionModel\DataDriven;
use Piwik\Plugins\AdvertisingConversionExport\AttributionModel\LastClick;

return [
    'entities.idNames' => Piwik\DI::add(['idExport']),
    'attributionModels' => Piwik\DI::factory(function () {
        return [
            DataDriven::getInstance(),
            LastClick::getInstance(),
        ];
    }),
];
