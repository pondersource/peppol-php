<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class InvoiceLine 
{
    
    /**
     * @SerializedName("ID")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $id;
    
    /**
     * @SerializedName("Note")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $note;
    
    /**
     * @SerializedName("InvoicedQuantity")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\Quantity")
     */
    private $invoicedQuantity;
    
    /**
     * @SerializedName("LineExtensionAmount")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\Amount")
     */
    private $lineExtensionAmount;
    
    /**
     * @SerializedName("AccountingCost")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $accountingCost; // Optional: A textual value that specifies where to book the relevant data into the Buyer's financial accounts.

    /**
     * @SerializedName("InvoicePeriod")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\InvoicePeriod")
     */
    private $invoicePeriod;

    /**
     * @SerializedName("OrderLineReference")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\OrderLineReference")
     */
    private $orderLineReference;

    /**
     * @SerializedName("DocumentReference")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\DocumentReference")
     */
    private $documentReference;

    /**
     * @XmlList(inline=true, entry="AllowanceCharge", namespace=Namespaces::CAC)
     * @Type("array<OCA\PeppolNext\PonderSource\UBL\Invoice\AllowanceCharge>")
     */
    private $allowanceCharges = [];

    /**
     * @SerializedName("Item")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\Item")
     */
    private $item;

    /**
     * @SerializedName("Price")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\Price")
     */
    private $price;
    
    public function __construct($id = null, $note = null, $invoicedQuantity = null, $lineExtensionAmount = null, $accountingCost = null, $invoicePeriod = null, $orderLineReference = null, $documentReference = null, $allowanceCharges = [], $item = null, $price = null) {
        $this->id = $id;
        $this->note = $note;
        $this->invoicedQuantity = $invoicedQuantity;
        $this->lineExtensionAmount = $lineExtensionAmount;
        $this->accountingCost = $accountingCost;
        $this->invoicePeriod = $invoicePeriod;
        $this->orderLineReference = $orderLineReference;
        $this->documentReference = $documentReference;
        $this->allowanceCharges = $allowanceCharges;
        $this->item = $item;
        $this->price = $price;
        return $this;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setNote($note) {
        $this->note = $note;
        return $this;
    }

    public function getNote() {
        return $this->note;
    }

    public function setInvoicedQuantity($invoicedQuantity) {
        $this->invoicedQuantity = $invoicedQuantity;
        return $this;
    }

    public function getInvoicedQuantity() {
        return $this->invoicedQuantity;
    }

    public function setLineExtensionAmount($lineExtensionAmount) {
        $this->lineExtensionAmount = $lineExtensionAmount;
        return $this;
    }

    public function getLineExtensionAmount() {
        return $this->lineExtensionAmount;
    }

    public function setAccountingCost($accountingCost) {
        $this->accountingCost = $accountingCost;
        return $this;
    }

    public function getAccountingCost() {
        return $this->accountingCost;
    }

    public function setInvoicePeriod($invoicePeriod) {
        $this->invoicePeriod = $invoicePeriod;
        return $this;
    }

    public function getInvoicePeriod() {
        return $this->invoicePeriod;
    }

    public function setOrderLineReference($orderLineReference) {
        $this->orderLineReference = $orderLineReference;
        return $this;
    }

    public function getOrderLineReference() {
        return $this->orderLineReference;
    }

    public function setDocumentReference($documentReference) {
        $this->documentReference = $documentReference;
        return $this;
    }

    public function getDocumentReference() {
        return $this->documentReference;
    }

    public function setAllowanceCharges($allowanceCharges) {
        $this->allowanceCharges = $allowanceCharges;
        return $this;
    }

    public function getAllowanceCharges() {
        return $this->allowanceCharges;
    }

    public function setItem($item) {
        $this->item = $item;
        return $this;
    }

    public function getItem() {
        return $this->item;
    }

    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }

    public function getPrice() {
        return $this->price;
    }

}