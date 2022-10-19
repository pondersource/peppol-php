<?php

namespace OCA\PeppolNext\PonderSource\SBD;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement};
use OCA\PeppolNext\PonderSource\SBD\Any;

/**
 */
class Sender 
{

    /**
     * @SerializedName("Identifier")
     * @XmlElement(namespace=Namespaces::SBD)
     * @Type("OCA\PeppolNext\PonderSource\SBD\Identifier")
     */
    private $identifier;

    public function __construct($identifier = null){
        $this->identifier = $identifier;
        return $this;
    }
    
    public function setIdentifier($identifier) {
        $this->identifier = $identifier;
        return $this;
    }

    public function getIdentifier() {
        return $this->identifier;
    }

}