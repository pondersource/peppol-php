<?php

namespace OCA\PeppolNext\PonderSource\EBMS;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement};

/**
 * @XmlNamespace(uri=Namespaces::DS, prefix="ds")
 * @XmlNamespace(uri=Namespaces::EB, prefix="eb")
 * @XmlNamespace(uri=Namespaces::EBBP, prefix="ebbp")
 * @XmlNamespace(uri=Namespaces::WSU, prefix="wsu")
 * @XmlNamespace(uri=Namespaces::XLINK, prefix="xlink")
 * @XmlNamespace(uri=Namespaces::S11, prefix="S11")
 * @XmlNamespace(uri=Namespaces::S12, prefix="S12")
 * @XmlRoot("eb:Messaging")
 */
class Messaging 
{
    /**
     * @XmlAttribute(namespace=Namespaces::S12)
     * @SerializedName("mustUnderstand")
     * @Type("boolean")
     */
    private $s12MustUnderstand = true;

    /**
     * @XmlAttribute(namespace=Namespaces::WSU)
     * @SerializedName("Id")
     * @Type("string")
     */
    private $id;

    /**
     * @SerializedName("UserMessage")
     * @XmlElement(namespace=Namespaces::EB)
     * @Type("OCA\PeppolNext\PonderSource\EBMS\UserMessage")
     */
    private $userMessage;

    /**
     * @SerializedName("SignalMessage")
     * @XmlElement(namespace=Namespaces::EB)
     * @Type("OCA\PeppolNext\PonderSource\EBMS\SignalMessage")
     */
    private $signalMessage;

    public function __construct($userMessage = null, $signalMessage = null, $id = null){
        $this->userMessage = $userMessage;
        $this->signalMessage = $signalMessage;
        $this->id = $id;
        return $this;
    }

    public function setUserMessage($userMessage){
        $this->userMessage = $userMessage;
        return $this;
    }

    public function getUserMessage(){
        return $this->userMessage;
    }

    public function setSignalMessage($signalMessage) {
        $this->signalMessage = $signalMessage;
        return $this;
    }

    public function getSignalMessage() {
        return $this->signalMessage;
    }

    public function setId($id){
        $this->id = $id;
        return $this;
    }

    public function getId(){
        return $this->id;
    }
}