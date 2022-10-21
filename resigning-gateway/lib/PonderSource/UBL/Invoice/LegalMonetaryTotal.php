<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class LegalMonetaryTotal 
{
    
    /**
     * @SerializedName("LineExtensionAmount")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\Amount")
     */
    private $lineExtensionAmount;
    
    /**
     * @SerializedName("TaxExclusiveAmount")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\Amount")
     */
    private $taxExclusiveAmount;
    
    /**
     * @SerializedName("TaxInclusiveAmount")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\Amount")
     */
    private $taxInclusiveAmount;
    
    /**
     * @SerializedName("AllowanceTotalAmount")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\Amount")
     */
    private $allowanceTotalAmount;
    
    /**
     * @SerializedName("ChargeTotalAmount")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\Amount")
     */
    private $chargeTotalAmount;
    
    /**
     * @SerializedName("PrepaidAmount")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\Amount")
     */
    private $prepaidAmount;
    
    /**
     * @SerializedName("PayableRoundingAmount")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\Amount")
     */
    private $payableRoundingAmount;
    
    /**
     * @SerializedName("PayableAmount")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\Amount")
     */
    private $payableAmount;
    
    public function __construct($lineExtensionAmount = null, $taxExclusiveAmount = null, $taxInclusiveAmount = null, $allowanceTotalAmount = null, $chargeTotalAmount = null, $prepaidAmount = null, $payableRoundingAmount = null, $payableAmount = null) {
        $this->lineExtensionAmount = $lineExtensionAmount;
        $this->taxExclusiveAmount = $taxExclusiveAmount;
        $this->taxInclusiveAmount = $taxInclusiveAmount;
        $this->allowanceTotalAmount = $allowanceTotalAmount;
        $this->chargeTotalAmount = $chargeTotalAmount;
        $this->prepaidAmount = $prepaidAmount;
        $this->payableRoundingAmount = $payableRoundingAmount;
        $this->payableAmount = $payableAmount;
        return $this;
    }

    public function setLineExtensionAmount($lineExtensionAmount) {
        $this->lineExtensionAmount = $lineExtensionAmount;
        return $this;
    }

    public function getLineExtensionAmount() {
        return $this->lineExtensionAmount;
    }

    public function setTaxExclusiveAmount($taxExclusiveAmount) {
        $this->taxExclusiveAmount = $taxExclusiveAmount;
        return $this;
    }

    public function getTaxExclusiveAmount() {
        return $this->taxExclusiveAmount;
    }

    public function setTaxInclusiveAmount($taxInclusiveAmount) {
        $this->taxInclusiveAmount = $taxInclusiveAmount;
        return $this;
    }

    public function getTaxInclusiveAmount() {
        return $this->taxInclusiveAmount;
    }

    public function setAllowanceTotalAmount($allowanceTotalAmount) {
        $this->allowanceTotalAmount = $allowanceTotalAmount;
        return $this;
    }

    public function getAllowanceTotalAmount() {
        return $this->allowanceTotalAmount;
    }

    public function setChargeTotalAmount($chargeTotalAmount) {
        $this->chargeTotalAmount = $chargeTotalAmount;
        return $this;
    }

    public function getChargeTotalAmount() {
        return $this->chargeTotalAmount;
    }

    public function setPrepaidAmount($prepaidAmount) {
        $this->prepaidAmount = $prepaidAmount;
        return $this;
    }

    public function getPrepaidAmount() {
        return $this->prepaidAmount;
    }

    public function setPayableRoundingAmount($payableRoundingAmount) {
        $this->payableRoundingAmount = $payableRoundingAmount;
        return $this;
    }

    public function getPayableRoundingAmount() {
        return $this->payableRoundingAmount;
    }

    public function setPayableAmount($payableAmount) {
        $this->payableAmount = $payableAmount;
        return $this;
    }

    public function getPayableAmount() {
        return $this->payableAmount;
    }

}