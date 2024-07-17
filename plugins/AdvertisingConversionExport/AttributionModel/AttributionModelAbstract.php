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

namespace Piwik\Plugins\AdvertisingConversionExport\AttributionModel;

use Piwik\Singleton;

abstract class AttributionModelAbstract extends Singleton
{
    /**
     * internal model id
     */
    const ID = '';

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
     * Returns the name of the attribution model, to be used in the CSV export
     *
     * @return string
     */
    abstract public function getExportName(): string;

    /**
     * Returns the translated name of the attribution model
     *
     * @return string
     */
    abstract public function getTranslatedName(): string;

}
