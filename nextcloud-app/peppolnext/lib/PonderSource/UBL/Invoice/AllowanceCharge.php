<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class AllowanceCharge 
{
    
    /**
     * @SerializedName("ChargeIndicator")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("boolean")
     */
    private $chargeIndicator;
    
    /**
     * @SerializedName("AllowanceChargeReasonCode")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $allowanceChargeReasonCode;
    // Allowance: https://docs.peppol.eu/poacc/billing/3.0/codelist/UNCL5189/
    // Charge: https://docs.peppol.eu/poacc/billing/3.0/codelist/UNCL7161/
    
    /**
     * @SerializedName("AllowanceChargeReason")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $allowanceChargeReason;
    
    /**
     * @SerializedName("MultiplierFactorNumeric")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("float")
     */
    private $multiplierFactorNumeric;
    
    /**
     * @SerializedName("Amount")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\Amount")
     */
    private $amount;
    
    /**
     * @SerializedName("BaseAmount")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\Amount")
     */
    private $baseAmount;

    /**
     * @SerializedName("TaxCategory")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\TaxCategory")
     */
    private $taxCategory; // Not included for invoice line
    
    public function __construct($chargeIndicator = null, $allowanceChargeReasonCode = null, $allowanceChargeReason = null, $multiplierFactorNumeric = null, $amount = null, $baseAmount = null, $taxCategory = null) {
        $this->chargeIndicator = $chargeIndicator;
        $this->allowanceChargeReasonCode = $allowanceChargeReasonCode;
        $this->allowanceChargeReason = $allowanceChargeReason;
        $this->multiplierFactorNumeric = $multiplierFactorNumeric;
        $this->amount = $amount;
        $this->baseAmount = $baseAmount;
        $this->taxCategory = $taxCategory;
        return $this;
    }

    public function setChargeIndicator($chargeIndicator) {
        $this->chargeIndicator = $chargeIndicator;
        return $this;
    }

    public function getChargeIndicator() {
        return $this->chargeIndicator;
    }

    public function setAllowanceChargeReasonCode($allowanceChargeReasonCode) {
        $this->allowanceChargeReasonCode = $allowanceChargeReasonCode;
        return $this;
    }

    public function getAllowanceChargeReasonCode() {
        return $this->allowanceChargeReasonCode;
    }

    public function setAllowanceChargeReason($allowanceChargeReason) {
        $this->allowanceChargeReason = $allowanceChargeReason;
        return $this;
    }

    public function getAllowanceChargeReason() {
        return $this->allowanceChargeReason;
    }

    public function setMultiplierFactorNumeric($multiplierFactorNumeric) {
        $this->multiplierFactorNumeric = $multiplierFactorNumeric;
        return $this;
    }

    public function getMultiplierFactorNumeric() {
        return $this->multiplierFactorNumeric;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
        return $this;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function setBaseAmount($baseAmount) {
        $this->baseAmount = $baseAmount;
        return $this;
    }

    public function getBaseAmount() {
        return $this->baseAmount;
    }

    public function setTaxCategory($taxCategory) {
        $this->taxCategory = $taxCategory;
        return $this;
    }

    public function getTaxCategory() {
        return $this->taxCategory;
    }

}