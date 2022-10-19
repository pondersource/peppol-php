<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlValue,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class ItemClassificationCode 
{
    
    /**
     * @SerializedName("listID")
     * @XmlAttribute
     * @Type("string")
     */
    private $listID;
    // Item type identification code (UNCL7143)
    // https://docs.peppol.eu/poacc/billing/3.0/codelist/UNCL7143/
    
    /**
     * @SerializedName("listVersionID")
     * @XmlAttribute
     * @Type("string")
     */
    private $listVersionID; // Optional: The identification scheme version identifier of the Item classification identifier

    /**
     * @XmlValue(cdata=false)
     * @Type("string")
     */
    private $value;
    
    public function __construct($listId = null, $listVersionID = null, $value = null) {
        $this->listId = $listId;
        $this->listVersionID = $listVersionID;
        $this->value = $value;
        return $this;
    }

    public function setListId($listId) {
        $this->listId = $listId;
        return $this;
    }

    public function getListId() {
        return $this->listId;
    }

    public function setListVersionID($listVersionID) {
        $this->listVersionID = $listVersionID;
        return $this;
    }

    public function getListVersionID() {
        return $this->listVersionID;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function getValue() {
        return $this->value;
    }

}