<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class TaxCategory 
{
    
    /**
     * @SerializedName("ID")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $id; // Duty or tax or fee category code (Subset of UNCL5305) // https://docs.peppol.eu/poacc/billing/3.0/codelist/UNCL5305/
    
    /**
     * @SerializedName("Percent")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("float")
     */
    private $percent;

    /**
     * @SerializedName("TaxExemptionReasonCode")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $taxExemptionReasonCode;

    /**
     * @SerializedName("TaxExemptionReason")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $taxExemptionReason;

    /**
     * @SerializedName("TaxScheme")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\TaxScheme")
     */
    private $taxScheme;
    
    public function __construct($id = null, $percent = null, $taxExemptionReasonCode = null, $taxExemptionReason = null, $taxScheme = null) {
        $this->id = $id;
        $this->percent = $percent;
        $this->taxExemptionReasonCode = $taxExemptionReasonCode;
        $this->taxExemptionReason = $taxExemptionReason;
        $this->taxScheme = $taxScheme;
        return $this;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setPercent($percent) {
        $this->percent = $percent;
        return $this;
    }

    public function getPercent() {
        return $this->percent;
    }

    public function setTaxExemptionReasonCode($taxExemptionReasonCode) {
        $this->taxExemptionReasonCode = $taxExemptionReasonCode;
        return $this;
    }

    public function getTaxExemptionReasonCode() {
        return $this->taxExemptionReasonCode;
    }

    public function setTaxExemptionReason($taxExemptionReason) {
        $this->taxExemptionReason = $taxExemptionReason;
        return $this;
    }

    public function getTaxExemptionReason() {
        return $this->taxExemptionReason;
    }

    public function setTaxScheme($taxScheme) {
        $this->taxScheme = $taxScheme;
        return $this;
    }

    public function getTaxScheme() {
        return $this->taxScheme;
    }

}