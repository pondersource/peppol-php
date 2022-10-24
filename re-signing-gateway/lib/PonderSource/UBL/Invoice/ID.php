<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlValue,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class ID 
{
    
    /**
     * @SerializedName("schemeID")
     * @XmlAttribute
     * @Type("string")
     */
    private $schemeID;
    // AdditionalDocumentReference: Invoiced object identifier scheme // https://docs.peppol.eu/poacc/billing/3.0/codelist/UNCL1153/
    // AccountingSupplierParty: ISO 6523 ICD list, SEPA indicator // https://docs.peppol.eu/poacc/billing/3.0/codelist/ICD/ // https://docs.peppol.eu/poacc/billing/3.0/codelist/SEPA/
    // AccountingCustomerParty: ISO 6523 ICD list // https://docs.peppol.eu/poacc/billing/3.0/codelist/ICD/
    // PayeeParty: ISO 6523 ICD list, SEPA indicator
    // Delivery/DeliveryLocation: ISO 6523 ICD list
    // InvoiceLine/DocumentReference: Invoiced object identifier scheme (UNCL 1153) // https://docs.peppol.eu/poacc/billing/3.0/codelist/UNCL1153/
    // InvoiceLine/Item/StandardItemIdentification: ISO 6523 ICD list
    // Party/PartyLegalEntity/CompanyID: ISO 6523 ICD list

    /**
     * @XmlValue(cdata=false)
     * @Type("string")
     */
    private $value;
    
    public function __construct($schemeID = null, $value = null) {
        $this->schemeID = $schemeID;
        $this->value = $value;
        return $this;
    }

    public function setSchemeID($schemeID) {
        $this->schemeID = $schemeID;
        return $this;
    }

    public function getSchemeID() {
        return $this->schemeID;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function getValue() {
        return $this->value;
    }

}