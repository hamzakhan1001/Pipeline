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

namespace Piwik\Plugins\CrashAnalytics\Tracker;

/**
 * Normalizes messages of common errors that are displayed differently based on the
 * browser used.
 */
class BrowserInconsistencies
{
    /**
     * @var string[][]
     */
    private $errorMatchers;

    public function __construct(array $errorMatchers = null)
    {
        $this->errorMatchers = $errorMatchers ?: self::getDefaultErrorMatchers();
    }

    public function getNormalizedMessageIfCommon(string $message): ?string
    {
        $message = trim($message);
        $message = rtrim($message, '.');

        foreach ($this->errorMatchers as $matcherGroup) {
            $normalizedMessage = $this->checkMatcherGroup($message, $matcherGroup);
            if (!empty($normalizedMessage)) {
                return $normalizedMessage;
            }
        }

        return null;
    }

    private function checkMatcherGroup(string $message, array $matcherGroup): ?string
    {
        foreach ($matcherGroup['matchers'] as $regex) {
            $match = preg_filter($regex, $matcherGroup['replace'], $message);
            if (!empty($match)) {
                return $match;
            }
        }
        return null;
    }

    private static function getDefaultErrorMatchers(): array
    {
        return [
            // variable not defined
            [
                'matchers' => [
                    '/^can\'t find variable:\s+(.+)/i',
                    '/^([^\s\'"]+) is not defined$/i',
                    '/^\'([^\']+)\' is not defined$/i',
                ],
                'replace' => '$1 is not defined',
            ],

            // play() interrupted
            [
                'matchers' => [
                    '/^the play\(\) request was interrupted ([^.]+).*/i',
                ],
                'replace' => 'the play() request was interrupted $1',
            ],

            // ... is not a function
            [
                'matchers' => [
                    '/^(?:typeerror: )?([\S]+) is not a function$/i',
                    '/^(?:typeerror: )?([\S]+) is not a function\. \(in \'\\1\([^)]+\)\', \'\\1\' is undefined\)$/i',
                ],
                'replace' => '$1 is not a function',
            ],

            [
                'matchers' => [
                    '/^script error\.?$/i',
                ],
                'replace' => 'script error',
            ],

            // Object Not Found Matching Id...
            [
                'matchers' => [
                    '/object not found matching id:\s*(\d+)/i',
                ],
                'replace' => 'object not found matching id',
            ],

            // JSON parse unexpected EOF
            [
                'matchers' => [
                    '/^json parse error: unexpected eof$/i',
                    '/^json.parse: unexpected end of data at line \d+ column \d+ of the json data$/i',
                ],
                'replace' => 'json parse error: unexpected eof',
            ],

            // undefined is not an object
            [
                'matchers' => [
                    '/^(?:typeerror: )?undefined is not an object(.*)$/i',
                ],
                'replace' => 'undefined is not an object$1',
            ],
        ];
    }
}