<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlValue,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class PaymentMeansCode 
{
    
    /**
     * @SerializedName("name")
     * @XmlAttribute
     * @Type("string")
     */
    private $name; // Optional // anything

    /**
     * @XmlValue(cdata=false)
     * @Type("string")
     */
    private $value;
    
    public function __construct($name = null, $value = null) {
        $this->name = $name;
        $this->value = $value;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function getValue() {
        return $this->value;
    }

}