<?php

namespace OCA\PeppolNext\PonderSource\WSSec;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{XmlElement,XmlRoot,Type,XmlNamespace,SerializedName,XmlAttribute,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::XENC, prefix="xenc")
 * @XmlNamespace(uri=Namespaces::DS, prefix="ds")
 * @XmlRoot("xenc:CipherReference")
 */
class CipherReference {
    /**
     * @SerializedName("URI")
     * @XmlAttribute
     * @Type("string")
     */
    private $uri;

    /**
     * @SerializedName("Transforms")
     * @XmlList(inline=false, entry="Transform", namespace=Namespaces::DS)
     * @Type("array<OCA\PeppolNext\PonderSource\WSSec\Transform>")
     * @XmlElement(namespace=Namespaces::XENC)
     */
    private $transforms = [];

    public function __construct($uri, $transforms = []){
        $this->uri = $uri;
        $this->transforms = $transforms;
        return $this;
    }

    public function setUri($uri){
        $this->uri = $uri;
        return $this;
    }
    public function getUri(){
        return $this->uri;
    }
    public function setTransforms($transforms){
        $this->transforms = $transforms;
        return $this;
    }
    public function getTransforms(){
        return $this->transforms;
    }
    public function addTransform($transform){
        array_push($this->transforms, $transform);
        return $this;
    }
    public function removeTransform($transform){
        array_filter($this->transforms, function($t) { return $t != $transform; });
        return $this;
    }
}