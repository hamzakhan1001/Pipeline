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

namespace Piwik\Plugins\AdvertisingConversionExport;

use Piwik\Access;
use Piwik\Common;
use Piwik\Piwik;
use Piwik\Tracker;
use Piwik\Plugins\AdvertisingConversionExport\Export\Cache;
use Piwik\Plugins\AdvertisingConversionExport\Export\Configuration;

/**
 * @method static \Piwik\Plugins\AdvertisingConversionExport\API getInstance()
 */
class API extends \Piwik\Plugin\API
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Returns all configured conversion exports for the given idSite
     * if idSite is omitted, all conversion exports of sites, the current user has write access for, will be returned
     *
     * @param null|int $idSite id of the site conversion exports should be returned for
     * @return array
     * @throws \Exception
     */
    public function getConversionExports($idSite = null)
    {
        Piwik::checkUserHasSomeWriteAccess();

        if (!empty($idSite)) {
            Piwik:: checkUserHasWriteAccess($idSite);
            $idSites = [$idSite];
        } else {
            $idSites = Access::getInstance()->getSitesIdWithWriteAccess();
        }

        return $this->model->getEntries($idSites);
    }

    /**
     * Returns the (configuration) data of a specific conversion conversion export identified by its id
     *
     * @param int $idExport id of an export
     * @return array
     * @throws \Throwable
     */
    public function getConversionExport($idExport)
    {
        Piwik::checkUserHasSomeWriteAccess();

        $export = $this->model->getByIdExport($idExport);

        if (empty($export) || !Piwik::isUserHasWriteAccess($export['idsite'])) {
            throw new \Exception(Piwik::translate('AdvertisingConversionExport_UnableToLoadExport'));
        }

        return $export;
    }

    /**
     * Removes the conversion export with the given idExport
     *
     * @param $idExport
     * @param $idSite
     * @throws \Exception
     */
    public function deleteConversionExport($idExport, $idSite)
    {
        $this->checkPermissionByExportId($idExport);

        $this->removeCacheFile($idExport);
        $this->model->deleteEntry($idExport);
        Tracker\Cache::deleteCacheWebsiteAttributes($idSite);
    }

    /**
     * Creates a new conversion export
     *
     * @param int    $idSite      id of the website the export is for
     * @param string $name        name of the conversion export
     * @param string $type        type of the export (e.g. GoogleAds, YandexAds,...)
     * @param array  $parameters  configuration array of the export
     * @param string $description description of the export
     * @return int id of the newly added report
     * @throws \Exception
     */
    public function addConversionExport($idSite, $name, $type, $parameters, $description = '')
    {
        Piwik::checkUserHasWriteAccess($idSite);

        $this->sanitizeParameters($parameters);

        $response = $this->model->add($idSite, $name, $type, $description, $this->getRandomAccessToken(), $parameters);
        Tracker\Cache::deleteCacheWebsiteAttributes($idSite);

        return $response;
    }

    /**
     * Generates a new access token for the export identified by idExport
     *
     * Note: The old access token will stop working immediately
     *
     * @param int $idExport id of an export
     * @return string new access token
     * @throws \Throwable
     */
    public function regenerateAccessToken($idExport)
    {
        $this->checkPermissionByExportId($idExport);

        $accessToken = $this->getRandomAccessToken();

        $this->model->updateAccessToken($idExport, $accessToken);

        return $accessToken;
    }

    private function getRandomAccessToken()
    {
        $possibleChars = 'abcdefghijklmnoprstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789.-!%*$@';

        $accessToken = Common::getRandomString(50, $possibleChars);

        while ($this->model->getByAccessToken($accessToken)) {
            $accessToken = Common::getRandomString(50, $possibleChars);
        }

        return $accessToken;
    }

    /**
     * Updates an conversion export with new configration data
     *
     * @param int    $idExport    id of the export to change
     * @param int    $idSite      id of the website the export belongs to (needs to match)
     * @param string $name        new name of the export
     * @param string $type        new type of the export
     * @param array  $parameters  new configuration array
     * @param string $description new description of the export
     * @throws \Zend_Db_Adapter_Exception
     */
    public function updateConversionExport($idExport, $idSite, $name, $type, $parameters, $description = '')
    {
        Piwik::checkUserHasWriteAccess($idSite);

        $this->sanitizeParameters($parameters);

        $configuration = Configuration::build($idSite, $parameters, $idExport);

        try {
            $configuration->validate();

            $exportAdapter = AdvertisingConversionExport::getExportAdapterById($type);

            if (empty($exportAdapter)) {
                throw new \Exception('Invalid export type configured');
            }
        } catch (\Exception $e) {
            throw new \Exception(Piwik::translate('AdvertisingConversionExport_ExportSaveFailed') . ' ' . $e->getMessage());
        }

        $this->model->update($idExport, $idSite, $name, $type, $description, $parameters);
        $this->removeCacheFile($idExport);
        Tracker\Cache::deleteCacheWebsiteAttributes($idSite);
    }

    private function removeCacheFile($idExport)
    {
        $cache = new Cache($idExport);
        $cache->delete();
    }

    private function checkPermissionByExportId($idExport)
    {
        Piwik::checkUserHasSomeWriteAccess();

        $export = $this->model->getByIdExport($idExport);

        if (empty($export) || !Piwik::isUserHasWriteAccess($export['idsite'])) {
            throw new \Exception('Requested conversion export could not be found');
        }
    }

    private function sanitizeParameters(&$parameters)
    {
        if (!empty($parameters['goals'])) {
            foreach ($parameters['goals'] as &$parameter) {
                if (!empty($parameter['name'])) {
                    $parameter['name'] = substr($parameter['name'], 0, 50);
                }
            }
        }
    }
}
