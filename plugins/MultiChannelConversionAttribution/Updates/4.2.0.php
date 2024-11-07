<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\MultiChannelConversionAttribution;

use Piwik\Container\StaticContainer;
use Piwik\DataAccess\ArchiveTableCreator;
use Piwik\Updater;
use Piwik\Updater\Migration\Factory as MigrationFactory;
use Piwik\Updates;
use Piwik\Plugins\SitesManager\API as APISitesManager;

/**
 */
class Updates_4_2_0 extends Updates
{
    public static $archiveBlobTables;

    /**
     * @var MigrationFactory
     */
    private $migration;

    public function __construct(MigrationFactory $factory)
    {
        $this->migration = $factory;
    }

    public function getMigrations(Updater $updater)
    {
        $migrations = [];

        $allWebsites = APISitesManager::getInstance()->getAllSitesId();
        $attributions = StaticContainer::get('Piwik\Plugins\MultiChannelConversionAttribution\Model\GoalAttributionModel');
        $configuration = StaticContainer::get('Piwik\Plugins\MultiChannelConversionAttribution\Configuration');

        $updateQueries = [];
        $daysPriorConversions = $configuration->getDaysPriorToConversion();

        foreach ($allWebsites as $idSite) {
            $idGoals = $attributions->getSiteAttributionGoalIds($idSite);
            foreach ($idGoals as $idGoal) {
                foreach ($daysPriorConversions as $daysPriorToConversion) {
                    $oldArchiveName = self::completeChannelAttributionRecordNameOld($idGoal, $daysPriorToConversion);
                    $newArchiveName = self::completeChannelAttributionRecordNameNew($idGoal, ['period' => $daysPriorToConversion, 'topLevel' => 'referer_name']);
                    $updateQueries[] = 'Update `%1$s` set name=' . "'$newArchiveName'" . ' where name=' . "'$oldArchiveName'";
                }
            }
        }

        $archiveBlobTables = self::getAllArchiveBlobTables();

        foreach ($archiveBlobTables as $table) {
            foreach ($updateQueries as $updateQuery) {
                $migrations[] = $this->migration->db->sql(sprintf($updateQuery, $table));
            }
        }

        return $migrations;
    }

    public function doUpdate(Updater $updater)
    {
        $updater->executeMigrations(__FILE__, $this->getMigrations($updater));
    }

    /**
     * Returns all available archive blob tables
     *
     * @return array
     */
    public static function getAllArchiveBlobTables()
    {
        if (empty(self::$archiveBlobTables)) {
            $archiveTables = ArchiveTableCreator::getTablesArchivesInstalled();

            self::$archiveBlobTables = array_filter($archiveTables, function ($name) {
                return ArchiveTableCreator::getTypeFromTableName($name) == ArchiveTableCreator::BLOB_TABLE;
            });

            // sort tables so we have them in order of their date
            rsort(self::$archiveBlobTables);
        }

        return (array)self::$archiveBlobTables;
    }


    public static function completeChannelAttributionRecordNameOld($idGoal, $daysPriorToConversion)
    {
        return Archiver::RECORD_CHANNEL_TYPES . '_' . (int) $idGoal . '_prior' . (int) $daysPriorToConversion;
    }

    public static function completeChannelAttributionRecordNameNew($idGoal, $rowOption)
    {
        return Archiver::RECORD_CHANNEL_TYPES . '_' . (int) $idGoal . '_prior' . (int) $rowOption['period'] . '_' . $rowOption['topLevel'] . (!empty($rowOption['subLevel']) ? '_' . $rowOption['subLevel'] : '');
    }
}
