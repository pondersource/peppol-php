<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlValue,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class TaxRepresentativeParty 
{

    /**
     * @SerializedName("PartyName")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\PartyName")
     */
    private $partyName;

    /**
     * @SerializedName("PostalAddress")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\PostalAddress")
     */
    private $postalAddress;

    /**
     * @SerializedName("PartyTaxScheme")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\PartyTaxScheme")
     */
    private $partyTaxScheme;
    
    public function __construct($partyName = null, $postalAddress = null, $partyTaxScheme = null) {
        $this->partyName = $partyName;
        $this->postalAddress = $postalAddress;
        $this->partyTaxScheme = $partyTaxScheme;
        return $this;
    }

    public function setPartyName($partyName) {
        $this->partyName = $partyName;
        return $this;
    }

    public function getPartyName() {
        return $this->partyName;
    }

    public function setPostalAddress($postalAddress) {
        $this->postalAddress = $postalAddress;
        return $this;
    }

    public function getPostalAddress() {
        return $this->postalAddress;
    }

    public function setPartyTaxScheme($partyTaxScheme) {
        $this->partyTaxScheme = $partyTaxScheme;
        return $this;
    }

    public function getPartyTaxScheme() {
        return $this->partyTaxScheme;
    }

}