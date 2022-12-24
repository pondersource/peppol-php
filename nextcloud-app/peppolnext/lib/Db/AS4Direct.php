<?php
namespace OCA\PeppolNext\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class AS4Direct extends Entity implements JsonSerializable {

    protected $userId;
    protected $scheme;
    protected $peppolId;
    protected $publicKey;

    public function __construct() {
        $this->addType('id','integer');
    }

    public function jsonSerialize() {
        return [
            'scheme' => $this->scheme,
            'id' => $this->peppolId,
            'public_key' => $this->publicKey
        ];
    }
    
}