<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class PaymentMeans 
{
    
    /**
     * @SerializedName("PaymentMeansCode")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\PaymentMeansCode")
     */
    private $paymentMeansCode; // https://docs.peppol.eu/poacc/billing/3.0/codelist/UNCL4461/
    
    /**
     * @SerializedName("PaymentID")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $paymentID;

    /**
     * @SerializedName("CardAccount")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\CardAccount")
     */
    private $cardAccount;

    /**
     * @SerializedName("PayeeFinancialAccount")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\PayeeFinancialAccount")
     */
    private $payeeFinancialAccount;

    /**
     * @SerializedName("PaymentMandate")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\PaymentMandate")
     */
    private $paymentMandate;
    
    public function __construct($paymentMeansCode = null, $paymentID = null, $cardAccount = null, $payeeFinancialAccount = null, $paymentMandate = null) {
        $this->paymentMeansCode = $paymentMeansCode;
        $this->paymentID = $paymentID;
        $this->cardAccount = $cardAccount;
        $this->payeeFinancialAccount = $payeeFinancialAccount;
        $this->paymentMandate = $paymentMandate;
        return $this;
    }

    public function setPaymentMeansCode($paymentMeansCode) {
        $this->paymentMeansCode = $paymentMeansCode;
        return $this;
    }

    public function getPaymentMeansCode() {
        return $this->paymentMeansCode;
    }

    public function setPaymentID($paymentID) {
        $this->paymentID = $paymentID;
        return $this;
    }

    public function getPaymentID() {
        return $this->paymentID;
    }

    public function setCardAccount($cardAccount) {
        $this->cardAccount = $cardAccount;
        return $this;
    }

    public function getCardAccount() {
        return $this->cardAccount;
    }

    public function setPayeeFinancialAccount($payeeFinancialAccount) {
        $this->payeeFinancialAccount = $payeeFinancialAccount;
        return $this;
    }

    public function getPayeeFinancialAccount() {
        return $this->payeeFinancialAccount;
    }

    public function setPaymentMandate($paymentMandate) {
        $this->paymentMandate = $paymentMandate;
        return $this;
    }

    public function getPaymentMandate() {
        return $this->paymentMandate;
    }

}