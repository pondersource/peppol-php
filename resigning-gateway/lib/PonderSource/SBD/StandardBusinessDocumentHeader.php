<?php

namespace OCA\PeppolNext\PonderSource\SBD;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};
use OCA\PeppolNext\PonderSource\SBD\Any;

/**
 * @XmlRoot("StandardBusinessDocumentHeader")
 */
class StandardBusinessDocumentHeader 
{

    /**
     * @SerializedName("HeaderVersion")
     * @XmlElement(cdata=false, namespace=Namespaces::SBD)
     * @Type("string")
     */
    private $headerVersion;

    /**
     * @SerializedName("Sender")
     * @XmlElement(namespace=Namespaces::SBD)
     * @Type("OCA\PeppolNext\PonderSource\SBD\Sender")
     */
    private $sender;

    /**
     * @SerializedName("Receiver")
     * @XmlElement(namespace=Namespaces::SBD)
     * @Type("OCA\PeppolNext\PonderSource\SBD\Receiver")
     */
    private $receiver;

    /**
     * @SerializedName("DocumentIdentification")
     * @XmlElement(namespace=Namespaces::SBD)
     * @Type("OCA\PeppolNext\PonderSource\SBD\DocumentIdentification")
     */
    private $documentIdentification;

    /**
     * @SerializedName("BusinessScope")
     * @XmlList(inline=false, entry="Scope", namespace=Namespaces::SBD)
     * @Type("array<OCA\PeppolNext\PonderSource\SBD\Scope>")
     */
    private $businessScope = [];

    public function __construct($headerVersion = null, $sender = null, $receiver = null, $documentIdentification = null, $businessScope = []){
        $this->headerVersion = $headerVersion;
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->documentIdentification = $documentIdentification;
        $this->businessScope = $businessScope;
        return $this;
    }
    
    public function setHeaderVersion($headerVersion) {
        $this->headerVersion = $headerVersion;
        return $this;
    }

    public function getHeaderVersion() {
        return $this->headerVersion;
    }

    public function setSender($sender) {
        $this->sender = $sender;
        return $this;
    }

    public function getSender() {
        return $this->sender;
    }

    public function setReceiver($receiver) {
        $this->receiver = $receiver;
        return $this;
    }

    public function getReceiver() {
        return $this->receiver;
    }

    public function setDocumentIdentification($documentIdentification) {
        $this->documentIdentification = $documentIdentification;
        return $this;
    }

    public function getDocumentIdentification() {
        return $this->documentIdentification;
    }

    public function addScope($scope) {
        array_push($this->businessScope, $scope);
        return $this;
    }

    public function removeScope($scope) {
        array_filter($this->businessScope, function($t) { return $t != $scope; });
        return $this;
    }

    public function getBusinessScope() {
        return $this->businessScope;
    }

}