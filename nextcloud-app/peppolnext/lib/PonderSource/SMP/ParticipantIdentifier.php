<?php

namespace OCA\PeppolNext\PonderSource\SMP;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlValue,XmlElement};

/**
 * @XmlNamespace(uri=Namespaces::ID, prefix="id")
 */
class ParticipantIdentifier 
{
    /**
     * @XmlAttribute
     * @SerializedName("scheme")
     * @Type("string")
     */
    private $scheme;

    /**
     * @SerializedName("ParticipantIdentifier");
     * @XmlValue(cdata=false);
     * @Type("string")
     */
    private $value;

    public function __construct($scheme = null, $value = null){
        $this->scheme = $scheme;
        $this->value = $value;
        return $this;
    }
    
    public function setScheme($scheme) {
        $this->scheme = $scheme;
        return $this;
    }

    public function getScheme() {
        return $this->scheme;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function getValue() {
        return $this->value;
    }

}