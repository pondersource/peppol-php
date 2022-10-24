<?php

namespace OCA\PeppolNext\PonderSource\EBMS;

use JMS\Serializer\Annotation\{Type, XmlValue, SerializedName, XmlAttribute};

class PartyId {
    /**
     * @SerializedName("PartyId");
     * @XmlValue(cdata=false);
     * @Type("string")
     */
    private $value;

    /**
     * @XmlAttribute
     * @Type("string")
     */
    private $type = '';

    public function __construct($value, $type=''){
        $this->value = $value;
        $this->type = $type;
        return $this;
    }

    public function getValue(){
        return $this->value;
    }
    
    public function setValue($value){
        $this->value = $value;
        return $this;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }
}