<?php

namespace OCA\PeppolNext\PonderSource\SBD;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement};
use OCA\PeppolNext\PonderSource\SBD\Any;

/**
 */
class Scope 
{

    /**
     * @SerializedName("Type")
     * @XmlElement(namespace=Namespaces::SBD)
     * @Type("string")
     */
    private $type;

    /**
     * @SerializedName("InstanceIdentifier")
     * @XmlElement(namespace=Namespaces::SBD)
     * @Type("string")
     */
    private $instanceIdentifier;

    /**
     * @SerializedName("Identifier")
     * @XmlElement(namespace=Namespaces::SBD)
     * @Type("string")
     */
    private $identifier;

    public function __construct($type = null, $instanceIdentifier = null, $identifier = null){
        $this->type = $type;
        $this->instanceIdentifier = $instanceIdentifier;
        $this->identifier = $identifier;
        return $this;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function getType() {
        return $this->type;
    }

    public function setInstanceIdentifier($instanceIdentifier) {
        $this->instanceIdentifier = $instanceIdentifier;
        return $this;
    }

    public function getInstanceIdentifier() {
        return $this->instanceIdentifier;
    }

    public function setIdentifier($identifier) {
        $this->identifier = $identifier;
        return $this;
    }

    public function getIdentifier() {
        return $this->identifier;
    }

}