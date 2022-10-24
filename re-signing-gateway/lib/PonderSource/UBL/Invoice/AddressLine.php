<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class AddressLine 
{
    
    /**
     * @SerializedName("Line")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $line;
    
    public function __construct($line = null) {
        $this->line = $line;
        return $this;
    }

    public function setLine($line) {
        $this->line = $line;
        return $this;
    }

    public function getLine() {
        return $this->line;
    }

}