<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

namespace Piwik\Plugins\FormAnalytics;

use Piwik\Plugins\FormAnalytics\Dao\SiteForm;
use Piwik\Plugins\FormAnalytics\Model\FormsModel;
use Piwik\Plugins\SitesManager\API as APISitesManager;
use Piwik\Updater;
use Piwik\Updates as PiwikUpdates;
use Piwik\Updater\Migration;
use Piwik\Updater\Migration\Factory as MigrationFactory;

/**
 * Update for version 4.2.1.
 */
class Updates_4_2_1 extends PiwikUpdates
{
    /**
     * @var MigrationFactory
     */
    private $migration;

    public function __construct(MigrationFactory $factory)
    {
        $this->migration = $factory;
    }

    /**
     * Return database migrations to be executed in this update.
     *
     * Database migrations should be defined here, instead of in `doUpdate()`, since this method is used
     * in the `core:update` command when displaying the queries an update will run. If you execute
     * migrations directly in `doUpdate()`, they won't be displayed to the user. Migrations will be executed in the
     * order as positioned in the returned array.
     *
     * @param Updater $updater
     * @return Migration\Db[]
     */
    public function getMigrations(Updater $updater)
    {
        // many different migrations are available to be used via $this->migration factory
        $migration1 = $this->migration->db->changeColumnType('log_visit', 'example', 'BOOLEAN NOT NULL');
        // you can also define custom SQL migrations. If you need to bind parameters, use `->boundSql()`
        $migration2 = $this->migration->db->sql($sqlQuery = 'SELECT 1');

        return array(
            // $migration1,
            // $migration2
        );
    }

    /**
     * Perform the incremental version update.
     *
     * This method should perform all updating logic. If you define queries in the `getMigrations()` method,
     * you must call {@link Updater::executeMigrations()} here.
     *
     * @param Updater $updater
     */
    public function doUpdate(Updater $updater)
    {
        $updater->executeMigrations(__FILE__, $this->getMigrations($updater));

        $allWebsites = APISitesManager::getInstance()->getAllSitesId();
        $formModel = new FormsModel(new SiteForm(), new SystemSettings());
        foreach ($allWebsites as $idSite) {
            $forms = $formModel->getFormsByStatuses($idSite, $formModel::STATUS_DELETED);
            if (!empty($forms)) {
                foreach ($forms as $form) {
                    $formModel->deactivateForm($form['idsite'], $form['idsiteform']);
                }
            }
        }
    }
}
