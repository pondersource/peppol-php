<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlValue,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class Party 
{

    /**
     * @SerializedName("EndpointID")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\EndpointID")
     */
    private $endpointID;

    /**
     * @XmlList(inline=true, entry="PartyIdentification", namespace=Namespaces::CAC)
     * @Type("array<OCA\PeppolNext\PonderSource\UBL\Invoice\PartyIdentification>")
     */
    private $partyIdentifications = []; // Can be multiple for AccountingSupplierParty but at most one for others

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
     * @XmlList(inline=true, entry="PartyTaxScheme", namespace=Namespaces::CAC)
     * @Type("array<OCA\PeppolNext\PonderSource\UBL\Invoice\PartyTaxScheme>")
     */
    private $partyTaxSchemes = []; // Can be at most 2 for AccountingSupplierParty but at most one for others

    /**
     * @SerializedName("PartyLegalEntity")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\PartyLegalEntity")
     */
    private $partyLegalEntity;

    /**
     * @SerializedName("Contact")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\Contact")
     */
    private $contact;
    
    public function __construct($endpointID = null, $partyIdentifications = [], $partyName = null, $postalAddress = null, $partyTaxSchemes = [], $partyLegalEntity = null, $contact = null) {
        $this->endpointID = $endpointID;
        $this->partyIdentifications = $partyIdentifications;
        $this->partyName = $partyName;
        $this->postalAddress = $postalAddress;
        $this->partyTaxSchemes = $partyTaxSchemes;
        $this->partyLegalEntity = $partyLegalEntity;
        $this->contact = $contact;
        return $this;
    }

    public function setEndpointID($endpointID) {
        $this->endpointID = $endpointID;
        return $this;
    }

    public function getEndpointID() {
        return $this->endpointID;
    }

    public function setPartyIdentifications($partyIdentifications) {
        $this->partyIdentifications = $partyIdentifications;
        return $this;
    }

    public function getPartyIdentifications() {
        return $this->partyIdentifications;
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

    public function setPartyTaxSchemes($partyTaxSchemes) {
        $this->partyTaxSchemes = $partyTaxSchemes;
        return $this;
    }

    public function getPartyTaxSchemes() {
        return $this->partyTaxSchemes;
    }

    public function setPartyLegalEntity($partyLegalEntity) {
        $this->partyLegalEntity = $partyLegalEntity;
        return $this;
    }

    public function getPartyLegalEntity() {
        return $this->partyLegalEntity;
    }

    public function setContact($contact) {
        $this->contact = $contact;
        return $this;
    }

    public function getContact() {
        return $this->contact;
    }

}