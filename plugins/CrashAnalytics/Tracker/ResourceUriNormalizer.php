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

use Piwik\Tracker\PageUrl;

class ResourceUriNormalizer
{
    const GROUPED_HASH_PLACEHOLDER = '[grouped-hash]';
    const HASH_FILE_REGEX = '%/[a-fA-F0-9]{20,}(\..*?)(?|$)%';

    /**
     * @var array|null
     */
    private $versioningUrlParameters;

    /**
     * @var bool
     */
    private $groupHashedSourceFiles;

    public function __construct(?array $versioningUrlParameters, bool $groupHashedSourceFiles)
    {
        $this->versioningUrlParameters = $versioningUrlParameters;
        $this->groupHashedSourceFiles = $groupHashedSourceFiles;
    }

    public function normalize(int $idSite, ?string $fullResourceUri): ?string
    {
        $normalizedUri = $this->removeVersioningParameters($idSite, $fullResourceUri);
        $normalizedUri = $this->replaceHashedFilename($normalizedUri);
        if ($normalizedUri) {
            $normalizedUri = rtrim($normalizedUri, '&?');
        }
        return $normalizedUri;
    }

    public function isLooksLikeHashedFile(?string $crashSource): bool
    {
        return !empty($crashSource) && preg_match(self::HASH_FILE_REGEX, $crashSource);
    }

    public function isLooksLikeGroupedHash(?string $crashSource): bool
    {
        return !empty($crashSource) && strpos($crashSource, self::GROUPED_HASH_PLACEHOLDER) > 0;
    }

    private function removeVersioningParameters(int $idSite, ?string $fullResourceUri): ?string
    {
        if (empty($fullResourceUri) || empty($this->versioningUrlParameters)) {
            return $fullResourceUri;
        }

        $normalizedUri = PageUrl::excludeQueryParametersFromUrl($fullResourceUri, $idSite, $this->versioningUrlParameters);
        return $normalizedUri;
    }

    private function replaceHashedFilename(?string $fullResourceUri): ?string
    {
        if (empty($fullResourceUri) || !$this->groupHashedSourceFiles) {
            return $fullResourceUri;
        }

        $normalizedUri = preg_replace(self::HASH_FILE_REGEX, '/' . self::GROUPED_HASH_PLACEHOLDER . '$1$2', $fullResourceUri);
        return $normalizedUri;
    }
}
