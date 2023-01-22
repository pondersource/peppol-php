<?php
namespace OCA\PeppolNext\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Message extends Entity implements JsonSerializable {

    public const TYPE_UNKNOWN = 0;
    public const TYPE_INVOICE = 1;

    public const CATEGORY_INBOX = 0;
    public const CATEGORY_OUTBOX = 1;
    public const CATEGORY_CONNECTION_REQUEST = 2;

    protected $userId;
    protected $contactId;
    protected $contactName;
    protected $title;
    protected $messageType;
    protected $category;
    protected $createdAt;

    public function __construct() {
        $this->addType('id','integer');
    }

    public function jsonSerialize() {
        return [
            'contactName' => $this->contactName,
            'title' => $this->title
        ];
    }
    
}