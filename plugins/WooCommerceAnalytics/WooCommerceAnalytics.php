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

namespace Piwik\Plugins\WooCommerceAnalytics;

class WooCommerceAnalytics extends \Piwik\Plugin
{
    public function registerEvents()
    {
        return array(
            'AssetManager.getStylesheetFiles' => 'getStylesheetFiles',
            'Translate.getClientSideTranslationKeys' => 'getClientSideTranslationKeys',
        );
    }

    public function getStylesheetFiles(&$stylesheets)
    {
        $stylesheets[] = "plugins/WooCommerceAnalytics/stylesheets/styles.less";
    }

    public function getClientSideTranslationKeys(&$result)
    {
        $result[] = 'Installation_Installation';
        $result[] = 'WooCommerceAnalytics_WoocommerceIntegration';
        $result[] = 'WooCommerceAnalytics_InstallDownload2';
        $result[] = 'WooCommerceAnalytics_InstallLoginWordPress';
        $result[] = 'WooCommerceAnalytics_InstallWordPress';
        $result[] = 'WooCommerceAnalytics_InstallActivatePlugin';
        $result[] = 'WooCommerceAnalytics_InstallGoSettings2';
        $result[] = 'WooCommerceAnalytics_InstallConfigure';
        $result[] = 'WooCommerceAnalytics_DownloadPlugin';
        $result[] = 'WooCommerceAnalytics_UpdatingPlugin';
        $result[] = 'WooCommerceAnalytics_UpdatingPluginConfigured2';
        $result[] = 'WooCommerceAnalytics_UpdatingPluginPiwikServer';
    }
}
