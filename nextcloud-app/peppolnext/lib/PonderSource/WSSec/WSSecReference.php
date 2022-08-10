<?php

namespace OCA\PeppolNext\PonderSource\WSSec;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{XmlRoot,Type,XmlNamespace,SerializedName,XmlAttribute};

/**
 * @XmlNamespace(uri=Namespaces::WSSE, prefix="wsse")
 * @XmlRoot("wsse:Reference")
 */
class WSSecReference {
    /**
     * @SerializedName("ValueType")
     * @XmlAttribute
     * @Type("string")
     */
    private $valueType;

    /**
     * @SerializedName("URI")
     * @XmlAttribute
     * @Type("string")
     */
    private $uri;

    public function __construct($uri, $valueType = null) {
        $this->uri = $uri;
        $this->valueType = $valueType;
        return $this;
    }

    public function setURI($uri){
        $this->uri = $uri;
        return $this;
    }

    public function getURI(){
        return $this->uri;
    }

    public function setValueType($valueType){
        $this->valueType = $valueType;
        return;
    }

    public function getValueType(){
        return $this->valueType;
    }
}