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
		$vars->colorBrand = '#6439f5';
		$vars->colorBrandContrast = '#fff';
		$vars->colorText = '#212121';
		$vars->colorTextLight = '#444';
		$vars->colorTextLighter = '#666666';
		$vars->colorTextContrast = '#37474f';
		$vars->colorLink = '#1976D2';
		$vars->colorBaseSeries = '#ee3024';
		$vars->colorHeadlineAlternative = '#4E4E4E';
		$vars->colorHeaderBackground = '#ffffff';
		$vars->colorHeaderText = '#5f6368';
		$vars->colorMenuContrastText = '#202124';
		$vars->colorMenuContrastTextSelected = '#1a73e8';
		$vars->colorMenuContrastTextActive = '#3450A3';
		//$vars->colorMenuContrastBackground = '';
		$vars->colorWidgetExportedBackgroundBase = '#eff0f1';
		$vars->colorWidgetTitleText = '#333';
		//vars->colorWidgetTitleBackground = '';
		$vars->colorBackgroundBase = '#f8f9fa';
		$vars->colorBackgroundTinyContrast = '#f2f2f2';
		$vars->colorBackgroundLowContrast = '#d9d9d9';
		$vars->colorBackgroundContrast = '#fff';
		$vars->colorBackgroundHighContrast = '#202020';
		$vars->colorBorder = '#cccccc';
		$vars->colorCode = '#f3f3f3';
		$vars->colorCodeBackground = '#4d4d4d';
		//$vars->colorWidgetBackground = '#ffffff';
		//$vars->colorWidgetBorder = '';
	}
}
