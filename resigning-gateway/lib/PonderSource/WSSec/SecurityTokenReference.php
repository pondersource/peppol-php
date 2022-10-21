<?php

namespace OCA\PeppolNext\PonderSource\WSSec;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{XmlRoot,Type,XmlElement,XmlNamespace,XmlAttribute,SerializedName};

/**
 * @XmlNamespace(uri=Namespaces::WSSE, prefix="wsse");
 * @XmlNamespace(uri=Namespaces::WSSE11, prefix="wsse11")
 * @XmlRoot("wsse:SecurityTokenReference")
 */
class SecurityTokenReference {
    /**
     * @XmlAttribute
     * @Type("string")
     * @SerializedName("Id")
     */
    private $id;

    /**
     * @XmlAttribute
     * @Type("string")
     * @SerializedName("TokenType")
     */
    private $tokenType;

    /**
     * @SerializedName("Reference")
     * @Type("OCA\PeppolNext\PonderSource\WSSec\WSSecReference")
     * @XmlElement(namespace=Namespaces::WSSE)
     */
    private $reference;

    public function __construct($reference,  $attributes = []){
        $this->reference = $reference;
        isset($attributes['Id']) && $this->id = $attributes['Id'];
        isset($attributes['TokenType']) && $this->tokenType = $attributes['TokenType'];
        return $this;
    }

    public function setId($id){
        $this->id = $id;
        return $this;
    }

    public function getId(){
        return $this->id;
    }

    public function setReference($reference){
        $this->reference = $reference;
        return $this;
    }

    public function getReference(){
        return $this->reference;
    }

    public function setTokenType($tokenType){
        $this->tokenType = $tokenType;
        return $this;
    }

    public function getTokenType(){
        return $this->tokenType;
    }

    public function setAttributes($attributes){
        $this->attributes = $attributes;
        return $this;
    }

    public function getAttributes(){
        return $this->attributes;
    }
}