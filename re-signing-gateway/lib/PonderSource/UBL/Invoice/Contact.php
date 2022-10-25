<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class Contact 
{
    
    /**
     * @SerializedName("Name")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $name;
    
    /**
     * @SerializedName("Telephone")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $telephone;
    
    /**
     * @SerializedName("ElectronicMail")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $electronicMail;
    
    public function __construct($name = null, $telephone = null, $electronicMail = null) {
        $this->name = $name;
        $this->telephone = $telephone;
        $this->electronicMail = $electronicMail;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setTelephone($telephone) {
        $this->telephone = $telephone;
        return $this;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function setElectronicMail($electronicMail) {
        $this->electronicMail = $electronicMail;
        return $this;
    }

    public function getElectronicMail() {
        return $this->electronicMail;
    }

}