<?php

namespace OCA\PeppolNext\PonderSource\Envelope;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement};

/**
 * @XmlNamespace(uri=Namespaces::S12, prefix="S12")
 * @XmlRoot("S12:Envelope")
 */
class Envelope 
{

    /**
     * @SerializedName("Header")
     * @XmlElement(namespace=Namespaces::S12)
     * @Type("OCA\PeppolNext\PonderSource\Envelope\Header")
     */
    private $header;

    /**
     * @SerializedName("Body")
     * @XmlElement(namespace=Namespaces::S12)
     * @Type("OCA\PeppolNext\PonderSource\Envelope\Body")
     */
    private $body;

    public function __construct($header = null, $body = null){
        $this->header = $header;
        $this->body = $body;
        return $this;
    }

    public function setHeader($header){
        $this->header = $header;
        return $this;
    }

    public function getHeader(){
        return $this->header;
    }

    public function setBody($body){
        $this->body = $body;
        return $this;
    }

    public function getBody(){
        return $this->body;
    }

}