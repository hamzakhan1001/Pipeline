<?php

namespace Piwik\Plugins\GhostTheme;

use Piwik\Plugin;

class GhostTheme extends Plugin
{
	public function registerEvents()
	{
		return [
			'Theme.configureThemeVariables' => 'configureThemeVariables',
			'SiteContentDetector.addDetector' => 'addCustomDetector',
		];
	}

	public function configureThemeVariables(Plugin\ThemeStyles $vars)
	{
		$vars->fontFamilyBase = '\'Inter var\', sans-serif';
		$primary = '#6439f5';
		$vars->colorBrand = $primary;
	}
}
