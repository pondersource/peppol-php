<?php

namespace OCA\PeppolNext\PonderSource\EBMS;

use JMS\Serializer\Annotation\{Type, XmlAttributeMap, XmlValue, XmlAttribute, SerializedName};

class Property {
    /*
     * @XmlAttributeMap
     */
    //private $attributes;

    /**
     * @XmlValue(cdata=false)
     * @Type("string")
     */
    private $value;

    /**
     * @XmlAttribute
     * @SerializedName("name")
     * @Type("string")
     */
    private $name;

    /**
     * @XmlAttribute
     * @SerializedName("type")
     * @Type("string")
     */
    private $type;

    function __construct($value, $name=null, $type=null){ // $attributes=[]
        $this->value = $value;
        $this->name = $name;
        $this->type = $type;
        //$this->attributes = $attributes;
    }

    function setAttributes($attributes){
        $this->attributes = $attributes;
        return $this;
    }
    function getAttributes(){
        return $this->attributes;
    }
    function addAttribute($key, $value, $overwrite=false){
        if($overwrite){
            $this->attributes[$key] = $value;
        } else {
            if(!isset($this->attributes[$key])){
                $this->attributes[$key] = $value;
            } else {
                throw new Exception('Attribute is already set');
            }
        }
        return $this;
    }
    function removeAttribute($key) {
        unset($this->attributes[$key]);
        return $this;
    }
    function setValue($value){
        $this->value = $value;
        return $this;
    }
    function getValue(){
        return $this->value;
    }
    function setName($name) {
        $this->name = $name;
        return $this;
    }
    function getName() {
        return $this->name;
    }
    function setType($type) {
        $this->type = $type;
        return $this;
    }
    function getType() {
        return $this->type;
    }
}