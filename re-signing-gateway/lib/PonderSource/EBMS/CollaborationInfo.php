<?php

namespace OCA\PeppolNext\PonderSource\EBMS;

use OCA\PeppolNext\PonderSource\EBMS\Service;
use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,SerializedName,XmlElement};

class CollaborationInfo {
    /**
     * @SerializedName("AgreementRef"); 
     * @XmlElement(cdata=false,namespace=Namespaces::EB);
     * @Type("string")
     */
    private $agreementRef;

    /**
     * @SerializedName("Service");
     * @XmlElement(cdata=false,namespace=Namespaces::EB);
     * @Type("OCA\PeppolNext\PonderSource\EBMS\Service")
     */
    private $service;

    /**
     * @SerializedName("Action");
     * @XmlElement(cdata=false,namespace=Namespaces::EB);
     * @Type("string")
     */
    private $action;

    /**
     * @SerializedName("ConversationId");
     * @XmlElement(cdata=false,namespace=Namespaces::EB);
     * @Type("string")
     */
    private $conversationId;

    public function __construct($agreementRef, $service, $action, $conversationId){
        $this->agreementRef = $agreementRef;
        $this->service = $service;
        $this->action = $action;
        $this->conversationId = $conversationId;
        return $this;
    }

    public function getAgreementRef(){
        return $this->agreementRef;
    }

    public function setAgreementRef($agreementRef){
        $this->agreementRef = $agreementRef;
        return $this;
    }

    public function getService(){
        return $this->service;
    }
    
    public function setService($service){
        $this->service = $service;
        return $this;
    }
    
    public function getAction(){
        return $this->action;
    }
    public function setAction($action){
        $this->action = $action;
        return $this;
    }
    public function getConversationId() {
        return $this->conversationId;
    } 
    public function setConversationId($conversationId){
        $this->conversationId = $conversationId;
        return $this;
    }
}