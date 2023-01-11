<?php
namespace OCA\PeppolNext\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class NextUser extends Entity implements JsonSerializable {

    protected $userId;
    protected $address;

    public function __construct() {
        $this->addType('id','integer');
    }

    public function jsonSerialize() {
        return [
            'userId' => $this->userId,
            'address' => $this->address
        ];
    }
    
}