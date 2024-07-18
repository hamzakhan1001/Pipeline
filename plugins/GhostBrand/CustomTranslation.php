<?php

namespace Piwik\Plugins\GhostBrand;

use Piwik\Translation\Loader\JsonFileLoader;

class CustomTranslation extends JsonFileLoader
{
	public function load($language, array $directories)
	{
		$translations = parent::load($language, $directories);

		// Custom translations to be added/overwritten
		$updated_translations = [
			'SitesManager_SiteWithoutDataInstallWithXRecommendation' => 'Install Ghost with %1$s (recommended for you)',
			'SitesManager_SiteWithoutDataGoogleTagManagerDescription' => 'You can use Ghost with Google Tag Manager. To setup Matomo Tracking in Google Tag Manager, follow the instructions from this %1$sguide%2$s.',
			'SitesManager_SetupMatomoTracker' => 'You can set up Ghost Metrics within a few minutes by following our step-by-step guide.',
			'SitesManager_SiteWithoutDataMatomoTagManager' => 'Ghost Tag Manager',
			'SitesManager_AliasUrlHelp' => 'It is recommended, but not required, to specify the various URLs, one per line, that your visitors use to access this website. Alias URLs for a website will not appear in the Referrers → Websites report. Note that it is not necessary to specify the URLs with and without \'www\' as Ghost automatically considers both.',
			'SitesManager_GlobalExcludedUserAgentHelp1' => 'Enter the list of user agents to exclude from being tracked by Ghost.',
			'SitesManager_GlobalListExcludedUserAgents_Desc' => 'If the visitor\'s user agent string contains any of the strings you specify, the visitor will be excluded from Ghost.',
			'SitesManager_ExtraInformationNeeded' => 'To setup Ghost Metrics on your system, you may need the following information:',
			'SitesManager_OtherWaysTabDescription' => 'Even if the solutions provided in the other tabs were not right for you, you can easily setup Ghost Metrics with one of the methods below. You may need the following information:',
		];

		// Merge custom translations with existing ones
		foreach ($updated_translations as $key => $text) {
			// Split the translation key to get the category and the specific key
			$split = explode('_', $key, 2);
			if (count($split) === 2) {
				list($category, $specificKey) = $split;
				// Update the translation in the corresponding category
				$translations[$category][$specificKey] = $text;
			}
		}

		return $translations;
	}
}
