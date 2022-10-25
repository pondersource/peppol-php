// SPDX-FileCopyrightText: 2022 Ponder Source
//
// SPDX-License-Identifier: MIT

<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use JMS\Serializer\Annotation\{Type, XmlAttributeMap, XmlValue, XmlAttribute, SerializedName};

class EndpointID {

    /**
     * @XmlValue(cdata=false)
     * @Type("string")
     */
    private $value;

    /**
     * @XmlAttribute
     * @SerializedName("schemeID")
     * @Type("string")
     */
    private $schemeID;

    function __construct($value, $schemeID){
        $this->value = $value;
        $this->schemeID = $schemeID;
    }
    
    function setValue($value){
        $this->value = $value;
        return $this;
    }

    function getValue(){
        return $this->value;
    }

    function setSchemeID($schemeID) {
        $this->schemeID = $schemeID;
        return $this;
    }
    
    function getSchemeID() {
        return $this->schemeID;
    }

}