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

namespace Piwik\Plugins\AdvertisingConversionExport\ClickIdProvider;

use Piwik\Singleton;

abstract class ClickIdProviderAbstract extends Singleton
{
    /**
     * internal provider id
     */
    const ID = '';

    /**
     * Url parameter indicating the providers click id
     */
    const CLICK_ID_REQUEST_PARAM = '';

    /**
     * Returns internal provider id
     *
     * @return string
     */
    public function getId(): string
    {
        return static::ID;
    }

    /**
     * Returns the display name of the provider
     *
     * @return string
     */
    abstract public function getName(): string;

    /**
     * Returns a logo to be displayed for the provider
     *
     * @return array
     */
    abstract public function getLogoUrl(): string;

    /**
     * Returns the export ID defined
     *
     * @return array
     */
    abstract public function getExportID(): string;
}
