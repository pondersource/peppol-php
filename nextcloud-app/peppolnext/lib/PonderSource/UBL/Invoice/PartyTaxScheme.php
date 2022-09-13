<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class PartyTaxScheme 
{
    
    /**
     * @SerializedName("CompanyID")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $companyID;

    /**
     * @SerializedName("TaxScheme")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\TaxScheme")
     */
    private $taxScheme;
    
    public function __construct($companyID = null, $taxScheme = null) {
        $this->companyID = $companyID;
        $this->taxScheme = $taxScheme;
        return $this;
    }

    public function setCompanyID($companyID) {
        $this->companyID = $companyID;
        return $this;
    }

    public function getCompanyID() {
        return $this->companyID;
    }

    public function setTaxScheme($taxScheme) {
        $this->taxScheme = $taxScheme;
        return $this;
    }

    public function getTaxScheme() {
        return $this->taxScheme;
    }

}