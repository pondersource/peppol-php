<?php

namespace OCA\PeppolNext\PonderSource\EBMS;

use JMS\Serializer\Annotation\{Type, XmlValue, XmlAttribute, serializedName};

class Service {
    /**
     * @SerializedName("Service");
     * @XmlValue(cdata=false);
     * @Type("string")
     */
    private $value;

    /**
     * @XmlAttribute
     * @Type("string")
     */
    private $type;

    public function __construct($value, $serviceType){
        $this->value = $value;
        $this->type = $serviceType;
        return $this;
    }

    public function getValue(){
        return $this->value;
    }

    public function setValue($value){
        $this->value = $value;
        return $this;
    }

    public function getServiceType(){
        return $this->serviceType;
    }
    
    public function setServiceType($serviceType){
        $this->type = $serviceType;
        return $this;
    }
}