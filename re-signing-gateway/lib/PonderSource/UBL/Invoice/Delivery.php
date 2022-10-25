<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class Delivery 
{
    
    /**
     * @SerializedName("ActualDeliveryDate")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("DateTime<'Y-m-d'>")
     */
    private $actualDeliveryDate;

    /**
     * @SerializedName("DeliveryLocation")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\DeliveryLocation")
     */
    private $deliveryLocation;

    /**
     * @SerializedName("DeliveryParty")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\DeliveryParty")
     */
    private $deliveryParty;
    
    public function __construct($actualDeliveryDate = null, $deliveryLocation = null, $deliveryParty = null) {
        $this->actualDeliveryDate = $actualDeliveryDate;
        $this->deliveryLocation = $deliveryLocation;
        $this->deliveryParty = $deliveryParty;
        return $this;
    }

    public function setActualDeliveryDate($actualDeliveryDate) {
        $this->actualDeliveryDate = $actualDeliveryDate;
        return $this;
    }

    public function getActualDeliveryDate() {
        return $this->actualDeliveryDate;
    }

    public function setDeliveryLocation($deliveryLocation) {
        $this->deliveryLocation = $deliveryLocation;
        return $this;
    }

    public function getDeliveryLocation() {
        return $this->deliveryLocation;
    }

    public function setDeliveryParty($deliveryParty) {
        $this->deliveryParty = $deliveryParty;
        return $this;
    }

    public function getDeliveryParty() {
        return $this->deliveryParty;
    }

}