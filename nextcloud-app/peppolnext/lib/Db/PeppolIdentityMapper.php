<?php

namespace OCA\PeppolNext\Db;

use OCA\PeppolNext\AppInfo\Application;

use OCP\IDBConnection;
use OCP\AppFramework\Db\QBMapper;

/**
 * @extends QBMapper<PeppolIdentity>
 */
class PeppolIdendityMapper extends QBMapper {

    public const DB_NAME = Application::APP_ID.'_peppolidentity';

    public function __construct(IDBConnection $db) {
        parent::__construct($db, self::DB_NAME, PeppolIdentity::class);
    }

    public function findUserIdentities(string $userId) {
        $qb = $this->db->getQueryBuilder();

        $qb->select('*')
             ->from($this->getTableName())
             ->where($qb->expr()->eq('user_id', $qb->createNamedParameter($userId)));

        return $this->findEntities($qb);
    }

    public function findUserIdentity(string $userId, string $serviceName) {
        $qb = $this->db->getQueryBuilder();

        $qb->select('*')
             ->from($this->getTableName())
             ->where($qb->expr()->eq('user_id', $qb->createNamedParameter($userId)))
             ->andWhere($qb->expr()->eq('service_name', $qb->createNamedParameter($serviceName)));

        return $this->findEntity($qb);
    }

}