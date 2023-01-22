<?php

namespace OCA\PeppolNext\Db;

use OCA\PeppolNext\AppInfo\Application;

use OCP\IDBConnection;
use OCP\AppFramework\Db\QBMapper;

/**
 * @extends QBMapper<Message>
 */
class MessageMapper extends QBMapper {

    public const DB_NAME = 'pn_message';

    public function __construct(IDBConnection $db) {
        parent::__construct($db, self::DB_NAME, Message::class);
    }

    public function getAll(int $category, int $start, int $count) {
        $qb = $this->db->getQueryBuilder();

        $qb->select('*')
             ->from($this->getTableName())
             ->where($qb->expr()->eq('category', $qb->createNamedParameter($category)))
             ->orderBy('createdAt', 'DESC')
             ->setFirstResult($start)
             ->setMaxResults($count);

        return $this->findEntities($qb);
    }

    public function getCount(int $category) {
        $table_name = $this->getTableName();
        $qb = $this->db->getQueryBuilder();
	    $qb->select($qb->createFunction("COUNT(*)"))
	       ->from($table_name)
           ->where($qb->expr()->eq('category', $qb->createNamedParameter($category)));
	    return array_values($this->findOneQuery($qb))[0];
    }

}