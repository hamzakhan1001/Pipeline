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

namespace Piwik\Plugins\Cohorts\Commands;

use Piwik\Common;
use Piwik\Date;
use Piwik\Development;
use Piwik\Http;
use Piwik\Period;
use Piwik\Plugin\ConsoleCommand;
use Piwik\Plugins\UsersManager\Model;
use Piwik\Plugins\VisitorGenerator\LogParser;
use Piwik\SettingsPiwik;
use Piwik\Tracker;

class GenerateTestData extends ConsoleCommand
{
    public const APACHE_LOG_FORMAT = '%s - - [%s] "GET %s HTTP/1.1" 200 %s "%s" "%s"';
    public const STANDARD_VISIT_LENGTH = 1800;

    /**
     * @var string
     */
    private $tokenAuth;

    protected function configure()
    {
        $this->setName('cohorts:generate-test-data');
        $this->setDescription('Generate test data w/ returning visitors.');
        $this->addRequiredValueOption('idsite', null, 'Site to track into.');
        $this->addRequiredValueOption('log-file', null, 'Log file to load visit templates from.');
        $this->addRequiredValueOption('visit-pool-max', null, 'Max number of visits templates to pull out of the log file.', 500);
        $this->addRequiredValueOption('date-range', null, 'Date range to generate visits for.', 'last30');
        $this->addRequiredValueOption('min-new-visits-per-day', null, 'Minimum number of visits to replay per day.', 10);
        $this->addRequiredValueOption('max-new-visits-per-day', null, 'Maximum number of visits to replay per day.', 50);
        $this->addRequiredValueOption('min-chance-returning-visit', null, 'Minimum chance an old visitor will return this day.', 0.1);
        $this->addRequiredValueOption('max-chance-returning-visit', null, 'Maximum chance an old visitor will return this day.', 0.6);
        $this->addRequiredValueOption('out-file', null, 'If supplied, outputs logs to a file instead of tracking them.');
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
        $idSite = $this->getIntegerValue('idsite');
        $logFile = $this->getLogFile();
        $visitPoolMax = $this->getIntegerValue('visit-pool-max');
        $dateRange = $this->getDateRange();
        $minNewVisitsPerDay = $this->getIntegerValue('min-new-visits-per-day');
        $maxNewVisitsPerDay = $this->getIntegerValue('max-new-visits-per-day');
        $minChanceReturningVisit = $this->getFloatValue('min-chance-returning-visit');
        $maxChanceReturningVisit = $this->getFloatValue('max-chance-returning-visit');

        $outFile = $this->getInput()->getOption('out-file');
        if (!empty($outFile)) {
            file_put_contents($outFile, '');
        }

        $visitPool = $this->pullVisitTemplates($logFile, $visitPoolMax);
        $firstVisitTimes = [];

        $this->getOutput()->writeln("<comment>Visit pool has " . count($visitPool) . " visits.</comment>");

        $visitors = [];

        $startDate = Date::factory($dateRange[0]);
        $endDate = Date::factory($dateRange[1]);
        for ($date = $startDate; $date->isEarlier($endDate); $date = $date->addDay(1)) {
            [$newVisits, $returningVisits] = $this->generateVisits(
                $idSite,
                $date,
                $visitPool,
                $visitors,
                $firstVisitTimes,
                $minNewVisitsPerDay,
                $maxNewVisitsPerDay,
                $minChanceReturningVisit,
                $maxChanceReturningVisit,
                $outFile
            );
            $this->getOutput()->writeln("Generated $newVisits new visits and $returningVisits returning visits for $date.");
        }

        return self::SUCCESS;
    }

    private function generateVisits(
        $idSite,
        Date $date,
        $visitPool,
        &$visitors,
        &$firstVisitTimes,
        $minNewVisitsPerDay,
        $maxNewVisitsPerDay,
        $minChanceReturningVisit,
        $maxChanceReturningVisit,
        $outFile
    ) {
        $visitsToReplay = [];

        $returningVisits = 0;

        $chanceOfReturning = ($maxChanceReturningVisit - $minChanceReturningVisit) * $this->rand() + $minChanceReturningVisit;
        foreach ($visitors as $visitorId) {
            if ($this->rand() > $chanceOfReturning) {
                continue;
            }

            $visit = $this->getRandomVisit($visitPool, $idSite, $visitorId, $date);
            $visitsToReplay = array_merge($visitsToReplay, $visit);

            ++$returningVisits;
        }

        $numNewVisits = random_int($minNewVisitsPerDay, $maxNewVisitsPerDay);
        for ($i = 0; $i < $numNewVisits; ++$i) {
            $visitorId = $this->generateRandomVisitorId();

            $visit = $this->getRandomVisit($visitPool, $idSite, $visitorId, $date);
            $visitsToReplay = array_merge($visitsToReplay, $visit);

            $visitors[] = $visitorId;

            $firstVisitTimes[$visitorId] = $visit[0]['time'];
        }

        usort($visitsToReplay, function ($lhs, $rhs) {
            return $lhs['time'] - $rhs['time'];
        });

        $this->replayVisits($visitsToReplay, $firstVisitTimes, $outFile);

        return [$numNewVisits, $returningVisits];
    }

    private function getRandomVisit($visitPool, $idSite, $visitorId, Date $date)
    {
        $key = array_rand($visitPool);
        $visit = $visitPool[$key];

        foreach ($visit as &$log) {
            $log['query']['idsite'] = $idSite;
            $log['query']['_id'] = $visitorId;
            $log['time'] = strtotime($date->toString() . ' ' . date('H:i:s', $log['time']));
        }

        return $visit;
    }

    private function replayVisits($logs, $firstVisitTimes, $outFile)
    {
        $requests = [];
        $lastVisitTimes = [];

        foreach ($logs as $log) {
            $visitorId = $log['query']['_id'];

            $log['query']['cdt'] = $log['time'];
            $log['query']['ua'] = $log['ua'];
            $log['query']['lang'] = 'en';

            $log['query']['_idts'] = $firstVisitTimes[$visitorId];

            if (!empty($lastVisitTimes[$visitorId])) {
                $log['query']['_viewts'] = $lastVisitTimes[$visitorId];
            } else {
                unset($log['query']['_viewts']);
            }

            if (!empty($log['visitstart'])) {
                $lastVisitTimes[$visitorId] = $log['time'];
            }

            $query = '?' . http_build_query($log['query']);
            $requests[] = $query;
        }

        if (empty($outFile)) {
            $payload = [
                'requests' => $requests,
                'token_auth' => $this->getTokenAuth(),
            ];

            Http::sendHttpRequestBy(
                Http::getTransportMethod(),
                SettingsPiwik::getPiwikUrl() . '/matomo.php',
                $timeout = 300,
                $userAgent = null,
                $path = null,
                $file = null,
                $follow = 0,
                $acceptLanguage = false,
                $acceptInvalidSslCertificate = true,
                $byteRange = false,
                $getExtendedInfo = false,
                $httpMethod = 'POST',
                $httpUsername = null,
                $httpPassword = null,
                $requestBody = json_encode($payload)
            );
        } else {
            try {
                $file = fopen($outFile, 'a');
                foreach ($logs as $log) {
                    fwrite($file, $this->transformLogToLine($log));
                }
            } finally {
                if (isset($file)) {
                    fclose($file);
                }
            }
        }
    }

    private function getLogFile()
    {
        $logFile = $this->getInput()->getOption('log-file');
        if (empty($logFile)) {
            throw new \Exception('--log-file is required.');
        }
        if (!is_file($logFile)) {
            throw new \Exception("'$logFile' does not exist.");
        }
        return $logFile;
    }

    private function getIntegerValue($optionName)
    {
        $value = $this->getInput()->getOption($optionName);
        if (!is_numeric($value)) {
            throw new \Exception("The --$optionName value ('$value') must be an integer.");
        }
        return (int) $value;
    }

    private function getDateRange()
    {
        $dateRange = $this->getInput()->getOption('date-range');
        $period = Period\Factory::build('day', $dateRange);
        return [$period->getDateStart(), $period->getDateEnd()];
    }

    private function pullVisitTemplates($logFile, $visitPoolMax)
    {
        $visitPool = [];
        $lastVisits = [];

        $iterator = new \SplFileObject($logFile);
        foreach ($iterator as $line) {
            if (count($visitPool) > $visitPoolMax) {
                return $visitPool;
            }

            $log = LogParser::parseLogLine($line);
            $log['query'] = $this->parseQuery($log['url']);
            $log['time'] = strtotime($log['time']);

            $visitorId = $this->getVisitorId($log['query']);
            if ($this->isFirstLogOfVisit($log, $lastVisits)) {
                if (isset($lastVisits[$visitorId])) {
                    $visit = $lastVisits[$visitorId];
                    $visit[0]['visitstart'] = true;
                    $visitPool[] = $visit;
                }
                $lastVisits[$visitorId] = [$log];
            } else {
                $lastVisits[$visitorId][] = $log;
            }
        }
        return $visitPool;
    }

    private function parseQuery($url)
    {
        $queryStr = parse_url($url, PHP_URL_QUERY);
        @parse_str($queryStr, $query);
        return $query;
    }

    public static function getVisitorId(array $logQuery)
    {
        if (!empty($logQuery['uid'])) {
            return $logQuery['uid'];
        }

        if (!empty($logQuery['cid'])) {
            return $logQuery['cid'];
        }

        if (!empty($logQuery['_id'])) {
            return $logQuery['_id'];
        }

        return null;
    }

    private function isFirstLogOfVisit($log, $lastVisits)
    {
        $visitorId = $this->getVisitorId($log['query']);
        if (empty($visitorId)) {
            $visitorId = $log['ip'];
        }

        $lastActionTime = isset($lastVisits[$visitorId]) ? end($lastVisits[$visitorId])['time'] : 0;

        // not a super accurate check, but doing a real one would be hard w/ just the log file.
        $actionTime = $log['time'];
        $isFirstVisit = $actionTime >= $lastActionTime + self::STANDARD_VISIT_LENGTH;
        return $isFirstVisit;
    }

    private function rand()
    {
        return mt_rand() / mt_getrandmax();
    }

    private function getTokenAuth()
    {
        if (empty($this->tokenAuth)) {
            $model = new Model();
            $superUsers = $model->getUsersHavingSuperUserAccess();
            $this->tokenAuth = reset($superUsers)['token_auth'];
        }
        return $this->tokenAuth;
    }

    private function generateRandomVisitorId()
    {
        $id = md5(Common::generateUniqId());
        $id = substr($id, 0, Tracker::LENGTH_HEX_ID_STRING);
        return $id;
    }

    private function getFloatValue($optionName)
    {
        $value = $this->getInput()->getOption($optionName);
        if (!is_numeric($value)) {
            throw new \Exception("The --$optionName value ('$value') must be a float.");
        }
        return (float) $value;
    }

    private function transformLogToLine($log)
    {
        if (empty($log)) {
            return '';
        }

        $url = '/piwik.php?' . http_build_query($log['query']);
        $time = date('d/M/Y:H:i:s +0000', $log['time']);

        $line = sprintf(self::APACHE_LOG_FORMAT, $log['ip'], $time, $url, '-', $log['referrer'], $log['ua']);
        return $line . "\n";
    }
}
