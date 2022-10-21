<?php

namespace OCA\PeppolNext\PonderSource\SBD;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlValue,XmlElement};

class Identifier 
{
    /**
     * @XmlAttribute
     * @SerializedName("Authority")
     * @Type("string")
     */
    private $authority;

    /**
     * @SerializedName("Identifier");
     * @XmlValue(cdata=false);
     * @Type("string")
     */
    private $value;

    public function __construct($authority = null, $value = null){
        $this->authority = $authority;
        $this->value = $value;
        return $this;
    }
    
    public function setAuthority($authority) {
        $this->authority = $authority;
        return $this;
    }

    public function getAuthority() {
        return $this->authority;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function getValue() {
        return $this->value;
    }

}