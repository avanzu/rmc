<?php
/**
 * StatsRepository.php
 * rmc
 * Date: 30.09.17
 */

namespace Repository;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class StatsRepository
{
    /**
     * @var Connection
     */
    protected $db;

    /**
     * StatsRepository constructor.
     *
     * @param Connection $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * @return array
     */
    public function loadRecords()
    {
        $statement = $this->createQueryBuilder()->select(implode(',', array_keys($this->getColumns())))->execute();

        return $statement->fetchAll();
    }

    /**
     * @return QueryBuilder
     */
    protected function createQueryBuilder()
    {
        return $this->db->createQueryBuilder()->from('profile');
    }

    /**
     * @return \Doctrine\DBAL\Schema\Column[]
     */
    public function getColumns()
    {
        /**
         * Format
         *
         *  key   : column name in db table
         *  value : label name to be used for display purposes
         */

        return [
            // 'id'                   => 'id',
            // 'unique_id'            => 'unique_id',
            'name'                 => 'name',
            // 'guid'                 => 'guid',
            // 'vac'                  => 'vac',
            // 'vac_updated'          => 'vac_updated',
            // 'market'               => 'market',
            'clan'                 => 'clan',
            'ranger'               => 'ranger',
            'outlaw'               => 'outlaw',
            'hunter'               => 'hunter',
            'nomad'                => 'nomad',
            'survivalist'          => 'survivalist',
            'engineer'             => 'engineer',
            'undead'               => 'undead',
            'survival_attempts'    => 'survival_attempts',
            'total_survival_time'  => 'total_survival_time',
            'total_survivor_kills' => 'total_survivor_kills',
            'total_zombie_kills'   => 'total_zombie_kills',
            'total_headshots'      => 'total_headshots',
        ];
    }
}