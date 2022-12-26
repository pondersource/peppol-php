<?php

namespace OCA\PeppolNext\Db;

use OCA\PeppolNext\AppInfo\Application;

use OCP\IDBConnection;
use OCP\AppFramework\Db\QBMapper;

/**
 * @extends QBMapper<PeppolIdentity>
 */
class PeppolIdentityMapper extends QBMapper {

    public const DB_NAME = 'pn_peppolidentity';

    public function __construct(IDBConnection $db) {
        parent::__construct($db, self::DB_NAME, PeppolIdentity::class);
    }

    public function findUserIdentity(string $userId, string $serviceName) {
        $qb = $this->db->getQueryBuilder();

        $qb->select('*')
             ->from($this->getTableName())
             ->where($qb->expr()->eq('user_id', $qb->createNamedParameter($userId)))
             ->andWhere($qb->expr()->eq('service_name', $qb->createNamedParameter($serviceName)));

        return $this->findEntity($qb);
    }

    public function findPeppolIdentity(string $peppolId) {
        $qb = $this->db->getQueryBuilder();

        $qb->select('*')
             ->from($this->getTableName())
             ->where($qb->expr()->eq('peppol_id', $qb->createNamedParameter($peppolId)));

        return $this->findEntity($qb);
    }

}