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

namespace Piwik\Plugins\CustomReports\Commands;

use Piwik\Development;
use Piwik\Plugin\ConsoleCommand;
use Piwik\Plugins\CustomReports\API;
use Piwik\Plugins\CustomReports\ReportType\Table;
use InvalidArgumentException;

class GenerateReports extends ConsoleCommand
{
    protected function configure()
    {
        $this->setName('customreports:generate-reports');
        $this->setDescription('GenerateReports');
        $this->addRequiredValueOption('idsite', null, 'The id of the site you want to add custom reports to', '1');
    }

    public function isEnabled()
    {
        return Development::isEnabled();
    }

    /**
     * @return int
     */
    protected function doExecute(): int
    {
        $input = $this->getInput();
        $idsite = $input->getOption('idsite');

        if (empty($idsite) || !is_numeric($idsite)) {
            throw new InvalidArgumentException('The idSite must be set and numeric');
        }

        $idsite = (int) $idsite;

        if (!$this->confirmChange($idsite)) {
            $this->getOutput()->writeln('Not created any report');
            return self::FAILURE;
        }

        $usedNames = [];
        $dimensions = API::getInstance()->getAvailableDimensions(1);
        foreach ($dimensions as $dimension) {
            foreach ($dimension['dimensions'] as $dim) {
                $name = $dim['name'];
                if (in_array($name, $usedNames)) {
                    $name = $dimension['category'] . ' ' . $name;
                }
                $usedNames[] = $name;

                API::getInstance()->addCustomReport(1, $name, Table::ID, ['nb_uniq_visitors'], false, [$dim['uniqueId']]);
            }
        }

        $metrics = API::getInstance()->getAvailableMetrics(1);
        $allMetr = array();
        foreach ($metrics as $metric) {
            foreach ($metric['metrics'] as $met) {
                $allMetr[] = $met['uniqueId'];
            }
        }

        API::getInstance()->addCustomReport(1, 'visit all metrics', Table::ID, $allMetr, false, ["DevicesDetection.BrowserName"]);
        API::getInstance()->addCustomReport(1, 'action all metrics', Table::ID, $allMetr, false, ["Actions.PageUrl"]);
        API::getInstance()->addCustomReport(1, 'media all metrics', Table::ID, $allMetr, false, ["MediaAnalytics.MediaLength"]);
        API::getInstance()->addCustomReport(1, 'conversion all metrics', Table::ID, $allMetr, false, ["Goals.Revenue"]);

        return self::SUCCESS;
    }

    private function confirmChange($idsite): bool
    {
        return $this->askForConfirmation(
            '<question>Are you sure you want to generate lots of custom reports for idSite ' . $idsite . '? (y/N)</question>',
            false
        );
    }
}
