<?php

namespace OCA\PeppolNext\PonderSource\WSSec;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{XmlRoot,Type,XmlNamespace,XmlAttribute,SerializedName};

/**
 * @XmlNamespace(uri=Namespaces::EC,prefix="ec")
 * @XmlRoot("ec:InclusiveNamespaces")
 */
class InclusiveNamespaces{
    /**
     * @XmlAttribute
     * @SerializedName("PrefixList")
     * @Type("string")
     */
    private $prefixList;
    
    public function __construct($prefixList = "S12"){
        $this->prefixList = $prefixList;
        return $this;
    }

    public function setPrefixList($prefixList){
        $this->prefixList = $prefixList;
        return $this;
    }

    public function getPrefixList(){
        return $this->prefixList;
    }
}