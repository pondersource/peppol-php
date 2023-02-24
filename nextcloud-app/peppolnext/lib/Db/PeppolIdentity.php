<?php
namespace OCA\PeppolNext\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class PeppolIdentity extends Entity implements JsonSerializable {

    protected $userId;
    protected $scheme;
    protected $peppolId;
    protected $certificate;
    protected $serviceName;
    protected $data;

    public function __construct() {
        $this->addType('id','integer');
    }

    public function jsonSerialize() {
        return [
            'scheme' => $this->scheme,
            'id' => $this->peppolId,
            'certificate' => $this->certificate
        ];
    }
    
}