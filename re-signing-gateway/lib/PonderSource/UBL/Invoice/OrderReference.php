<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class OrderReference 
{
    
    /**
     * @SerializedName("ID")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $id;
    
    /**
     * @SerializedName("SalesOrderID")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $salesOrderID;
    
    public function __construct($id = null, $salesOrderID = null) {
        $this->id = $id;
        $this->salesOrderID = $salesOrderID;
        return $this;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setSalesOrderID($salesOrderID) {
        $this->salesOrderID = $salesOrderID;
        return $this;
    }

    public function getSalesOrderID() {
        return $this->salesOrderID;
    }

}