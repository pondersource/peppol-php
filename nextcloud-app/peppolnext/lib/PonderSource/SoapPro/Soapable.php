<?php

namespace OCA\PeppolNext\PonderSource\SoapPro;

class Soapable
{

    private $name;
    private $ns_url;
    private $ns_alias;

    private $properties;
    private $raw_properties;

    private $value;
    private $elements = [];

    public function __construct($name, $ns_alias = null, $ns_url = null, $properties = [], $raw_properties = [], $value = null){
        $this->name = $name;
        $this->ns_alias = $ns_alias;
        $this->ns_url = $ns_url;
        $this->properties = $properties;
        $this->raw_properties = $raw_properties;
        $this->value = $value;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setProperty($name, $value){
        $this->properties[$name] = $value;
        return $this;
    }

    public function getProperty($name, $value){
        return $this->properties[$name];
    }

    public function setRawProperty($name, $value){
        $this->raw_properties[$name] = $value;
        return $this;
    }

    public function getRawProperty($name, $value){
        return $this->raw_properties[$name];
    }
    
    public function getValue() {
        return $this->value;
    }
    
    public function addElement($element) {
        $this->elements[] = $element;
        return $this;
    }
    
    public function getElements() {
        return $this->elements;
    }

    public function getElementsWithName($name) {
        $result = [];

        foreach ($this->elements as $element) {
            if ($element->getName() == $name) {
                $result[] = $element;
            }
        }

        return $result;
    }

    public function serialize($ns_list) {
        $serialized = '<';
        
        if (isset($this->ns_alias)) {
            $serialized .= $this->ns_alias . ':' . $this->name;
            
            if (in_array($this->ns_alias, $ns_list) == false && isset($this->ns_url)) {
                $serialized .= ' xmlns:' . $this->ns_alias . '="' . $this->ns_url . '"';
                
                $ns_list[] = $this->ns_alias;
            }

            foreach ($this->properties as $key => $value) {
                $serialized .= ' ' . $this->ns_alias . ':' . $key . '="' . $value . '"';
            }
        }
        else {
            $serialized .= $this->name;

            foreach ($this->properties as $key => $value) {
                $serialized .= ' ' . $key . '="' . $value . '"';
            }
        }
        
        foreach ($this->raw_properties as $key => $value) {
            $serialized .= ' ' . $key . '="' . $value . '"';
        }

        $serialized .= '>';

        if (isset($this->value)) {
            $serialized .= $this->value;
        }

        foreach ($this->elements as $element) {
            $serialized .= $element->serialize($ns_list);
        }

        if (isset($this->ns_alias) && isset($this->ns_url)) {
            $serialized .= '</' . $this->ns_alias . ':' . $this->name . '>';
        }
        else {
            $serialized .= '</' . $this->name . '>';
        }

        return $serialized;
    }

}