<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlValue,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class CompanyID 
{
    
    /**
     * @SerializedName("schemeID")
     * @XmlAttribute
     * @Type("string")
     */
    private $schemeID; // Optional // ISO 6523 ICD list: https://docs.peppol.eu/poacc/billing/3.0/codelist/ICD/

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