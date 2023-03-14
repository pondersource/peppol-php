<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlValue,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class Quantity 
{
    
    /**
     * @SerializedName("unitCode")
     * @XmlAttribute
     * @Type("string")
     */
    private $unitCode;
    // Recommendation 20, including Recommendation 21 codes - prefixed with X (UN/ECE)
    // https://docs.peppol.eu/poacc/billing/3.0/codelist/UNECERec20/

    /**
     * @XmlValue(cdata=false)
     * @Type("float")
     */
    private $value;
    
    public function __construct($unitCode = null, $value = null) {
        $this->unitCode = $unitCode;
        $this->value = $value;
        return $this;
    }

    public function setUnitCode($unitCode) {
        $this->unitCode = $unitCode;
        return $this;
    }

    public function getUnitCode() {
        return $this->unitCode;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function getValue() {
        return $this->value;
    }

}