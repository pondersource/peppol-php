<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class CommodityClassification 
{
    
    /**
     * @SerializedName("ItemClassificationCode")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\ItemClassificationCode")
     */
    private $itemClassificationCode;
    
    public function __construct($itemClassificationCode = null) {
        $this->itemClassificationCode = $itemClassificationCode;
        return $this;
    }

    public function setItemClassificationCode($itemClassificationCode) {
        $this->itemClassificationCode = $itemClassificationCode;
        return $this;
    }

    public function getItemClassificationCode() {
        return $this->itemClassificationCode;
    }

}