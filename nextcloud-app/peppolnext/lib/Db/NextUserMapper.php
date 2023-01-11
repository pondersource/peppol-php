<?php

namespace OCA\PeppolNext\Db;

use OCA\PeppolNext\AppInfo\Application;

use OCP\IDBConnection;
use OCP\AppFramework\Db\QBMapper;

/**
 * @extends QBMapper<NextUser>
 */
class NextUserMapper extends QBMapper {

    public const DB_NAME = 'pn_user';

    public function __construct(IDBConnection $db) {
        parent::__construct($db, self::DB_NAME, NextUser::class);
    }

    public function get(string $userId) {
        $qb = $this->db->getQueryBuilder();

        $qb->select('*')
             ->from($this->getTableName())
             ->where($qb->expr()->eq('user_id', $qb->createNamedParameter($category)));

        return $this->findEntity($qb);
    }

}