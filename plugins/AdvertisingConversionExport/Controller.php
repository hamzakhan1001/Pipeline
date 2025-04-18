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
use Piwik\Plugins\AdvertisingConversionExport\Export\Adapter\AdapterAbstract;
use Piwik\Plugins\AdvertisingConversionExport\Export\Cache;
use Piwik\Plugins\AdvertisingConversionExport\Export\Configuration;
use Piwik\Request;
use Piwik\View;

class Controller extends \Piwik\Plugin\ControllerAdmin
{
    public function index()
    {
        $idSite = Common::getRequestVar('idSite');

        if (strtolower($idSite) === 'all') {
            // prevent fatal error... redirect to a specific site as it is not possible to manage for all sites
            Piwik::checkUserHasSomeViewAccess();
            $this->redirectToIndex('AdvertisingConversionExport', 'index');
            exit;
        }

        // only checking for view access, so when choosing a site with too low privileges in site selector doesn't result in an error page
        Piwik::checkUserHasViewAccess($idSite);
        $model = new Model();

        $view = new View('@AdvertisingConversionExport/index');
        $this->setGeneralVariablesView($view);
        $view->exportTypes    = $this->getExportTypes();
        $view->clickIdProviders = $this->getClickIdProviders();
        $view->alreadyCreatedExportTypes = $model->getAllConfiguredExportTypes($idSite);
        $view->attributionModels = AdvertisingConversionExport::getAttributionModelsArray();
        $view->hasWriteAccess = Piwik::isUserHasWriteAccess($idSite);
        return $view->render();
    }

    public function manageExports()
    {
        $idSite = Common::getRequestVar('idSite');

        // only checking for view access, so when choosing a site with too low privileges in site selector doesn't result in an error page
        Piwik::checkUserHasViewAccess($idSite);
        $model = new Model();

        $view = new View('@AdvertisingConversionExport/manageExports');
        $this->setGeneralVariablesView($view);
        $view->exportTypes    = $this->getExportTypes();
        $view->clickIdProviders = $this->getClickIdProviders();
        $view->alreadyCreatedExportTypes = $model->getAllConfiguredExportTypes($idSite);
        $view->attributionModels = AdvertisingConversionExport::getAttributionModelsArray();
        $view->hasWriteAccess = Piwik::isUserHasWriteAccess($idSite);
        return $view->render();
    }

    private function getExportTypes()
    {
        $exportTypes = [];

        foreach (AdvertisingConversionExport::getAvailableExportTypes() as $exportType) {
            $exportTypes[$exportType::getId()] = [
                'id'          => $exportType::getId(),
                'name'        => $exportType::getName(),
                'description' => $exportType::getDescription(),
            ];
        }

        return $exportTypes;
    }

    private function getClickIdProviders()
    {
        $clickIdProviders = array();

        foreach (AdvertisingConversionExport::getAvailableClickIdProviders() as $clickIdProvider) {
            if ($clickIdProvider->getExportID()) {
                $clickIdProviders[$clickIdProvider->getExportID()] = [
                    'clickId' => $clickIdProvider::CLICK_ID_REQUEST_PARAM,
                    'name' => str_replace(' Ads', '', $clickIdProvider->getName())
                ];
            }
        }

        return $clickIdProviders;
    }

    /**
     * Generates / Sends the conversion export that belongs to the given idExport
     *
     * @throws \Throwable
     */
    public function downloadConversionExport()
    {
        $idSite = \Piwik\Request::fromRequest()->getIntegerParameter('idSite');
        // Need to skip the access code check for tests, as it will echo the output and cannot write tests for downloadConversionExport() due to that
        if (!defined('PIWIK_TEST_MODE') || !PIWIK_TEST_MODE) {
            Piwik::checkUserHasViewAccess($idSite);
        }
        $model = new Model();
        $idExport = \Piwik\Request::fromRequest()->getIntegerParameter('idExport');

        $export = $model->getByIdExport($idExport);
        if ($export['idsite'] != $idSite) {
            throw new \Exception('Requested conversion export could not be found for this site');
        }
        $this->generateExport($export, $model);
    }

    /**
     * Generates / Sends the conversion export that belongs to the given access token
     *
     * @throws \Throwable
     */
    public function generateConversionExport()
    {
        $model = new Model();
        $request = Request::fromRequest();

        $accessToken = $request->getStringParameter('accessToken', null);
        $requestType = $request->getStringParameter('requestType', '');

        // Here is no permission check on purpose to avoid the requirement of using a token_auth
        $export = $model->getByAccessToken($accessToken);
        $isHTTPRequest = ($requestType === 'https');

        $this->generateExport($export, $model, $isHTTPRequest);
    }
    private function generateExport($export, $model, $isHTTPRequest = false)
    {
        if (empty($export)) {
            throw new \Exception('Requested conversion export could not be found');
        }

        $model->updateRequestTime($export['idexport']);
        $exportAdapter = AdvertisingConversionExport::getExportAdapterById($export['type']);

        if (empty($exportAdapter)) {
            throw new \Exception('Invalid export type configured');
        }

        Access::doAsSuperUser(function () use ($export, $exportAdapter, $isHTTPRequest) {
            $configuration = Configuration::build($export['idsite'], $export['parameters'], $export['idexport']);
            /** @var AdapterAbstract $exportAdapter */
            $exportAdapter = new $exportAdapter($configuration);

            $cache = new Cache($export['idexport'] . ($isHTTPRequest ? '_https' : ''));

            if (!$cache->contains()) {
                $content = $exportAdapter->generate($isHTTPRequest);
                $cache->save($content);
            }

            $exportAdapter->sendHttpHeaders();
            echo $cache->fetch();
            exit;
        });
    }
}
