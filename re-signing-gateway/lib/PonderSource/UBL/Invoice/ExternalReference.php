<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class ExternalReference 
{
    
    /**
     * @SerializedName("URI")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $uri;
    
    public function __construct($uri = null) {
        $this->uri = $uri;
        return $this;
    }

    public function setUri($uri) {
        $this->uri = $uri;
        return $this;
    }

    public function getUri() {
        return $this->uri;
    }

}