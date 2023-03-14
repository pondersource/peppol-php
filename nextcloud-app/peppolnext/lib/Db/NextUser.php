<?php
namespace OCA\PeppolNext\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class NextUser extends Entity implements JsonSerializable {

    public $userId;
    protected $address;

    public function __construct() {
        $this->addType('id','integer');
    }

    public function jsonSerialize() {
        return [
            'user_id' => $this->userId,
            'address' => $this->address
        ];
    }
    
}