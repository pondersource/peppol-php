<?php

namespace OCA\PeppolNext\Db;

use OCA\PeppolNext\AppInfo\Application;

use OCP\IDBConnection;
use OCP\AppFramework\Db\QBMapper;

/**
 * @extends QBMapper<AS4Direct>
 */
class AS4DirectMapper extends QBMapper {

    public const DB_NAME = Application::APP_ID.'_as4direct';

    public function __construct(IDBConnection $db) {
        parent::__construct($db, self::DB_NAME, AS4Direct::class);
    }

    public function find(string $userId) {
        $qb = $this->db->getQueryBuilder();

        $qb->select('*')
             ->from($this->getTableName())
             ->where($qb->expr()->eq('user_id', $qb->createNamedParameter($userId)));

        return $this->findEntity($qb);
    }

    // public function find(int $id, string $userId) {
    //     $qb = $this->db->getQueryBuilder();

    //     $qb->select('*')
    //          ->from($this->getTableName())
    //          ->where($qb->expr()->eq('id', $qb->createNamedParameter($id)))
    //          ->andWhere($qb->expr()->eq('user_id', $qb->createNamedParameter($userId)));

    //     return $this->findEntity($qb);
    // }

    // public function findAll(string $userId) {
    //     $qb = $this->db->getQueryBuilder();

    //     $qb->select('*')
    //        ->from($this->getTableName())
    //        ->where($qb->expr()->eq('user_id', $qb->createNamedParameter($userId)));

    //     return $this->findEntities($qb);
    // }

}