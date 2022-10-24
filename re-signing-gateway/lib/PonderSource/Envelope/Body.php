<?php

namespace OCA\PeppolNext\PonderSource\Envelope;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement};

/**
 * @XmlNamespace(uri=Namespaces::WSU, prefix="wsu")
 * @XmlNamespace(uri=Namespaces::S12, prefix="S12")
 * @XmlRoot("S12:Body")
 */
class Body 
{

    /**
     * @XmlAttribute(namespace=Namespaces::WSU)
     * @SerializedName("Id")
     * @Type("string")
     */
    private $id;

    public function __construct($id = null){
        $this->id = $id;
        return $this;
    }

    public function setId($id){
        $this->id = $id;
        return $this;
    }

    public function getId(){
        return $this->id;
    }
}