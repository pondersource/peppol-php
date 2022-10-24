<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class StandardItemIdentification 
{
    
    /**
     * @SerializedName("ID")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\ID")
     */
    private $id;
    
    public function __construct($id = null) {
        $this->id = $id;
        return $this;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

}