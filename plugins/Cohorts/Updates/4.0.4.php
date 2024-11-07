<?php

namespace Piwik\Plugins\Cohorts;

use Piwik\Archive\ArchiveInvalidator;
use Piwik\Date;
use Piwik\Db;
use Piwik\Common;
use Piwik\Updater;
use Piwik\Updater\Migration\Factory as MigrationFactory;
use Piwik\Updates as PiwikUpdates;

/**
 * Update for version 4.0.4
 */
class Updates_4_0_4 extends PiwikUpdates
{
    /**
     * @var MigrationFactory
     */
    private $migration;

    /**
     * @var ArchiveInvalidator
     */
    private $invalidator;

    public function __construct(MigrationFactory $factory, ArchiveInvalidator $invalidator)
    {
        $this->migration = $factory;
        $this->invalidator = $invalidator;
    }

    public function doUpdate(Updater $updater)
    {
        if (\Piwik\Plugin\Manager::getInstance()->isPluginActivated('UserId')) {
            $dateTime = Date::now()->subYear(1);
            $dateString = date('Y-m', strtotime('-1 month'));
            list($year,$month) = explode('-', $dateString);
            $tableName = Common::prefixTable("archive_numeric_{$year}_{$month}");
            try {
                $results = Db::fetchAll("select distinct idsite from $tableName where idarchive > 0 and `name` = 'nb_users' and `value` > 0");
            } catch (\Exception $e) {
                // table might not exist if archiving hasn't run in a while or if manually deleted or if only just installed
                $results = [];
            }
            $idSitesToReArchive = array_column($results, 'idsite');

            if (!empty($idSitesToReArchive)) {
                $this->invalidator->scheduleReArchiving($idSitesToReArchive, 'Cohorts', $report = null, $dateTime);
            }
        }
    }
}
