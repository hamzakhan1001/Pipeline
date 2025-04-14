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

namespace Piwik\Plugins\AdvertisingConversionExport;

use Piwik\Date;
use Piwik\Plugins\AdvertisingConversionExport\Export\Adapter\AdapterAbstract;
use Piwik\Plugins\AdvertisingConversionExport\Export\Cache;
use Piwik\Plugins\AdvertisingConversionExport\Export\Configuration;
use Piwik\Log\LoggerInterface;

class Tasks extends \Piwik\Plugin\Tasks
{
    /**
     * @var Model
     */
    private $model;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Constructor.
     */
    public function __construct(Model $model, LoggerInterface $logger)
    {
        $this->model = $model;
        $this->logger = $logger;
    }

    public function schedule()
    {
        $this->hourly('prepareExportsIfNeeded');
    }

    protected function getCurrentTimestamp()
    {
        return Date::now()->getTimestampUTC();
    }

    // we run this task every hour to ensure all exports are already cached when they are requested.
    // If a request has already been requested before for the current day, and it's still in cache, nothing will be done
    public function prepareExportsIfNeeded()
    {
        $exports = $this->model->getEntries('all');

        foreach ($exports as $export) {
            $exportAdapter = AdvertisingConversionExport::getExportAdapterById($export['type']);

            if (empty($exportAdapter) || !is_array($export['parameters'])) {
                $this->logger->info(sprintf('Unable to prepare conversion export "%1$s" (ID: %2$s): Invalid configuration', $export['name'], $export['idexport']));
                continue; // invalid export type configured
            }

            try {
                $configuration = Configuration::build($export['idsite'], $export['parameters'], $export['idexport']);
                $configuration->validate();
            } catch (\Exception $e) {
                $this->logger->info(sprintf('Unable to prepare conversion export "%1$s" (ID: %2$s): Invalid configuration {exception}', $export['name'], $export['idexport']), [$e]);
                continue; // invalid configuration
            }

            /** @var AdapterAbstract $exportAdapter */
            $exportAdapter = new $exportAdapter($configuration);

            $cache = new Cache($export['idexport']);

            if (!$cache->contains()) {
                try {
                    $content = $exportAdapter->generate();
                } catch (\Exception $e) {
                    $this->logger->info(sprintf('Unable to prepare conversion export "%1$s" (ID: %2$s): {exception}', $export['name'], $export['idexport']), [$e]);
                    continue;
                }
                $cache->save($content);
            }
        }
    }
}
