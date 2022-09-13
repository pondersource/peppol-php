<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlValue,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class Amount 
{
    
    /**
     * @SerializedName("currencyID")
     * @XmlAttribute
     * @Type("string")
     */
    private $currencyID; // CurrencyCode constants

    /**
     * @XmlValue(cdata=false)
     * @Type("float<2>")
     */
    private $value;
    
    public function __construct($currencyID = null, $value = null) {
        $this->currencyID = $currencyID;
        $this->value = $value;
        return $this;
    }

    public function setCurrencyID($currencyID) {
        $this->currencyID = $currencyID;
        return $this;
    }

    public function getCurrencyID() {
        return $this->currencyID;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function getValue() {
        return $this->value;
    }

}