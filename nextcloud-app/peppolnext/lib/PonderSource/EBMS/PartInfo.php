<?php

namespace OCA\PeppolNext\PonderSource\EBMS;

use OCA\PeppolNext\PonderSource\EBMS\Property;
use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlNamespace,XmlRoot,XmlList,XmlAttribute,XmlElement,SerializedName};

/**
 * @XmlNamespace(uri="http://docs.oasis-open.org/ebxml-msg/ebms/v3.0/core/ebms-header-3_0-200704.xsd", prefix="eb")
 */
class PartInfo {
    /**
     * @XmlList(entry="Property",namespace=Namespaces::EB)
     * @Type("array<OCA\PeppolNext\PonderSource\EBMS\Property>")
     * @XmlElement(namespace=Namespaces::EB)
     * @SerializedName("PartProperties")
     */
    private $partProperties = [];
    
    /**
     * @XmlAttribute
     * @SerializedName("href") 
     * @Type("string")
     */
    private $reference;

    public function __construct($reference = '', $partProperties = []){
        $this->reference = $reference;
        $this->partProperties = $partProperties;
    }

    function setReference($ref){
        $this->reference = $ref;
        return $this;
    }

    function getReference(){
        return $this->reference;
    }

    function addPartProperty($property){
        if(get_class($property) !== 'PonderSource\EBMS\Property'){
            throw new Exception('Failed to add property as it is not of class Property');
        }
        array_push($this->partProperties, $property);
        return $this;
    }

    function removePartProperty($property){
        array_filter($this->partProperties, function($p) { return $p != $property; }, ARRAY_FILTER_USE_KEY);
        return $this;
    }

    function getProperty($property_name) {
        foreach ($this->partProperties as $property) {
            if ($property_name == $property->getName()) {
                return $property->getValue();
            }
        }

        return false;
    }

}
