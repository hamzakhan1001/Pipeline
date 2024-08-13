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

/**
 */
class Updates_4_2_2 extends Updates
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
        $updateQueries = [];
        $configuration = StaticContainer::get('Piwik\Plugins\MultiChannelConversionAttribution\Configuration');
        $daysPriorConversions = $configuration->getDaysPriorToConversion();

        foreach ($daysPriorConversions as $daysPriorToConversion) {
            $archiveName = "MultiChannelConversionAttribution_channelTypes_%%_prior{$daysPriorToConversion}_chunk%%";
            $updateQueries[] = 'Update `%1$s` set `name`=REPLACE(`name`,' . "'_chunk'" . ',' . "'_referer_name_chunk'" . ') where name like ' . "'$archiveName'";
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
}