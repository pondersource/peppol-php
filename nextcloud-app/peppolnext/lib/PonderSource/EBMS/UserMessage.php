<?php

namespace OCA\PeppolNext\PonderSource\EBMS;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type, SerializedName, XmlList, XmlElement};

class UserMessage {
    /**
     * @SerializedName("MessageInfo");
     * @XmlElement(namespace=Namespaces::EB)
     * @Type("OCA\PeppolNext\PonderSource\EBMS\MessageInfo")
     */
    private $messageInfo;

    /**
     * @SerializedName("PartyInfo")
     * @XmlElement(namespace=Namespaces::EB)
     * @Type("OCA\PeppolNext\PonderSource\EBMS\PartyInfo")
     */
    private $partyInfo;

    /**
     * @SerializedName("CollaborationInfo")
     * @XmlElement(namespace=Namespaces::EB)
     * @Type("OCA\PeppolNext\PonderSource\EBMS\CollaborationInfo")
     */
    private $collaborationInfo;

    /**
     * @SerializedName("MessageProperties")
     * @XmlList(entry="Property", namespace=Namespaces::EB)
     * @XmlElement(namespace=Namespaces::EB)
     * @Type("array<OCA\PeppolNext\PonderSource\EBMS\Property>")
     */
    private $messageProperties;

    /**
     * @SerializedName("PayloadInfo")
     * @XmlElement(namespace=Namespaces::EB)
     * @Type("OCA\PeppolNext\PonderSource\EBMS\PayloadInfo")
     */
    private $payloadInfo;

    public function __construct(
            $messageInfo = null, 
            $partyInfo = null, 
            $collaborationInfo = null, 
            $messageProperties = null, 
            $payloadInfo = null)
    {
        $this->messageInfo = $messageInfo;
        $this->partyInfo = $partyInfo;
        $this->collaborationInfo = $collaborationInfo;
        $this->messageProperties = $messageProperties;
        $this->payloadInfo = $payloadInfo;
        return $this;
    }

    public function getMessageInfo(){
        return $this->messageInfo;
    }
    public function setMessageInfo($messageInfo){
        $this->messageInfo = $messageInfo;
        return $this;
    }
    public function getPartyInfo(){
        return $this->partyInfo;
    }
    public function setPartyInfo($partyInfo){
        $this->partyInfo = $partyInfo;
        return $this;
    }
    public function getCollaborationInfo(){
        return $this->collaborationInfo;
    }
    public function setCollaborationInfo($collaborationInfo){
        $this->collaborationInfo = $collaborationInfo;
        return $this;
    }
    public function getMessageProperties(){
        return $this->messageProperties;
    }
    public function setMessageProperties($messageProperties){
        $this->messageProperties = $messageProperties;
        return $this;
    }
    public function getPeppolSenderAndReceiver(){
        $sender = null;
        $receiver = null;

        foreach ($this->messageProperties as $property) {
            if ($property->getName() === 'originalSender') {
                $sender = $property;
            }
            else if ($property->getName() === 'finalRecipient') {
                $receiver = $property;
            }
        }

        return [$sender, $receiver];
    }
    public function getPayloadInfo(){
        return $this->payloadInfo;
    }
    public function setPayloadInfo($payloadInfo){
        $this->payloadInfo = $payloadInfo;
        return $this;
    }
    public function addMessageProperty($property){
        if(get_class($property) !== 'PonderSource\EBMS\Property'){
            throw new Exception('Failed to add Message Property as it is not of type Property');
        }    
        array_push($this->messageProperties, $property);
        return $this;
    }
    public function removeMessageProperty($property){
        array_filter($this->messageProperties, function($p) { return $p != $property; }, ARRAY_FILTER_USE_KEY);
        return $this;
    }
}