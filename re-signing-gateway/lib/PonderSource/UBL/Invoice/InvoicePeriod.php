<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class InvoicePeriod 
{
    
    /**
     * @SerializedName("StartDate")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("DateTime<'Y-m-d'>")
     */
    private $startDate;
    
    /**
     * @SerializedName("EndDate")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("DateTime<'Y-m-d'>")
     */
    private $endDate;
    
    /**
     * @SerializedName("DescriptionCode")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $dateCode;
    
    public function __construct($startDate = null, $endDate = null, $descriptionCode = null) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->descriptionCode = $descriptionCode;
        return $this;
    }

    public function setStartDate($startDate) {
        $this->startDate = $startDate;
        return $this;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function setEndDate($endDate) {
        $this->endDate = $endDate;
        return $this;
    }

    public function getEndDate() {
        return $this->endDate;
    }

    public function setDescriptionCode($descriptionCode) {
        $this->dateCode = $descriptionCode;
        return $this;
    }

    public function getDescriptionCode() {
        return $this->dateCode;
    }

}