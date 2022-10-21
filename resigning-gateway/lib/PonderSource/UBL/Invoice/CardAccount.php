<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class CardAccount 
{
    
    /**
     * @SerializedName("PrimaryAccountNumberID")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $primaryAccountNumberID;
    
    /**
     * @SerializedName("NetworkID")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $networkID;
    
    /**
     * @SerializedName("HolderName")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $holderName;
    
    public function __construct($primaryAccountNumberID = null, $networkID = null, $holderName = null) {
        $this->primaryAccountNumberID = $primaryAccountNumberID;
        $this->networkID = $networkID;
        $this->holderName = $holderName;
        return $this;
    }

    public function setPrimaryAccountNumberID($primaryAccountNumberID) {
        $this->primaryAccountNumberID = $primaryAccountNumberID;
        return $this;
    }

    public function getPrimaryAccountNumberID() {
        return $this->primaryAccountNumberID;
    }

    public function setNetworkID($networkID) {
        $this->networkID = $networkID;
        return $this;
    }

    public function getNetworkID() {
        return $this->networkID;
    }

    public function setHolderName($holderName) {
        $this->holderName = $holderName;
        return $this;
    }

    public function getHolderName() {
        return $this->holderName;
    }

}