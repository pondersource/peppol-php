<?php

namespace OCA\PeppolNext\PonderSource\EBMS;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type, XmlElement, SerializedName, Exclude};

class MessageInfo {
    /**
     * @SerializedName("Timestamp");
     * @XmlElement(cdata=false,namespace=Namespaces::EB);
     * @Type("DateTime<'Y-m-d\TH:i:s.vP'>")
     */
    private $timestamp;

    /**
     * @SerializedName("MessageId");
     * @XmlElement(cdata=false,namespace=Namespaces::EB);
     * @Type("string")
     */
    private $messageId;

    /**
     * @SerializedName("RefToMessageId");
     * @XmlElement(cdata=false,namespace=Namespaces::EB);
     * @Type("string")
     */
    private $refToMessageId;

    public function __construct($timestamp = null, $messageId = null, $refToMessageId = null){
        $this->timestamp = $timestamp;
        $this->messageId = $messageId;
        $this->refToMessageId = $refToMessageId;
        return $this;
    }

    public function getTimestamp(){
        return $this->timestamp;
    }

    public function setTimestamp($timestamp){
        $this->timestamp = $timestamp;
        return $this;
    }

    public function getMessageId(){
        return $this->messageId;
    }

    public function setMessageId($messageId){
        $this->messageId = $messageId;
        return $this;
    }

    public function getRefToMessageId() {
        return $this->refToMessageId;
    }

    public function setRefToMessageId($refToMessageId) {
        $this->refToMessageId = $refToMessageId;
        return $this;
    }
}