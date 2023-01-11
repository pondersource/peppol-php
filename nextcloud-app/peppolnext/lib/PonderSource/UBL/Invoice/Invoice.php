<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::UBL)
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 * @XmlRoot("Invoice")
 */
class Invoice // https://docs.peppol.eu/poacc/billing/3.0/syntax/ubl-invoice/
{

    /**
     * Minimum invoice requires:
     * cbc:ID - Invoice number
     * cbc:IssueDate - Invoice issue date
     * cbc:InvoiceTypeCode - Invoice type code
     * cbc:DocumentCurrencyCode - Invoice currency code
     * cac:AccountingSupplierParty - SELLER
     *     cac:Party - PARTY
     *         cbc:EndpointID - Seller electronic address
     *         cac:PostalAddress - SELLER POSTAL ADDRESS
     *         cac:PartyLegalEntity - PARTY LEGAL ENTITY
     *             cbc:RegistrationName - Seller name
     * cac:AccountingCustomerParty - BUYER
     *     cac:Party - PARTY
     *         cbc:EndpointID - Buyer electronic address
     *         cac:PostalAddress - BUYER POSTAL ADDRESS
     *         cac:PartyLegalEntity - PARTY LEGAL ENTITY
     *             cbc:RegistrationName - Buyer name
     * cac:TaxTotal - TAX TOTAL
     *     cbc:TaxAmount - Invoice total VAT amount, Invoice total VAT amount in accounting currency
     * cac:LegalMonetaryTotal - DOCUMENT TOTALS
     *     cbc:LineExtensionAmount - Sum of Invoice line net amount
     *     cbc:TaxExclusiveAmount - Invoice total amount without VAT
     *     cbc:TaxInclusiveAmount - Invoice total amount with VAT
     *     cbc:PayableAmount - Amount due for payment
     * cac:InvoiceLine - INVOICE LINE
     *     cbc:ID - Invoice line identifier
     *     cbc:InvoicedQuantity - Invoiced quantity
     *     cbc:LineExtensionAmount - Invoice line net amount
     *     cac:Item - ITEM INFORMATION
     *         cbc:Name - Item name
     *         cac:ClassifiedTaxCategory - LINE VAT INFORMATION
     *             cbc:ID - Invoiced item VAT category code
     *     cac:Price - PRICE DETAILS
     *         cbc:PriceAmount - Item net price
     * 
     * 
     * Summerized inputs from the minimum above:
     * Invoice number
     * Invoice type code
     * Invoice currency code
     * Supplier
     *     Seller electronic address
     *     SELLER POSTAL ADDRESS
     *     Seller name
     * Customer
     *     Buyer electronic address
     *     BUYER POSTAL ADDRESS
     *     Buyer name
     * VAT amount
     * Invoice lines
     *     Invoiced quantity
     *     Item name
     *     Invoiced item VAT category code
     *     Item net price
     */

    /**
     * @SerializedName("UBLVersionID")
     * @XmlElement(cdata=false, namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $UBLVersionID = '2.1';

    /**
     * @SerializedName("CustomizationID")
     * @XmlElement(cdata=false, namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $customizationID = 'urn:cen.eu:en16931:2017#compliant#urn:fdc:peppol.eu:2017:poacc:billing:3.0';

    /**
     * @SerializedName("ProfileID")
     * @XmlElement(cdata=false, namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $profileID = 'urn:fdc:peppol.eu:2017:poacc:billing:01:1.0';

    /**
     * @SerializedName("ID")
     * @XmlElement(cdata=false, namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $id;
    
    /**
     * @SerializedName("IssueDate")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("DateTime<'Y-m-d'>")
     */
    private $issueDate;
    
    /**
     * @SerializedName("DueDate")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("DateTime<'Y-m-d'>")
     */
    private $dueDate;
    
    /**
     * @SerializedName("InvoiceTypeCode")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $invoiceTypeCode;
    
    /**
     * @SerializedName("Note")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $note;
    
    /**
     * @SerializedName("TaxPointDate")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("DateTime<'Y-m-d'>")
     */
    private $taxPointDate;
    
    /**
     * @SerializedName("DocumentCurrencyCode")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $documentCurrencyCode;
    
    /**
     * @SerializedName("TaxCurrencyCode")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $taxCurrencyCode;
    
    /**
     * @SerializedName("AccountingCost")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $accountingCost;
    
    /**
     * @SerializedName("BuyerReference")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $buyerReference;

    /**
     * @SerializedName("InvoicePeriod")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\InvoicePeriod")
     */
    private $invoicePeriod;

    /**
     * @SerializedName("OrderReference")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\OrderReference")
     */
    private $orderReference;

    /**
     * @XmlList(inline=true, entry="BillingReference", namespace=Namespaces::CAC)
     * @Type("array<OCA\PeppolNext\PonderSource\UBL\Invoice\BillingReference>")
     */
    private $billingReferences = [];

    /**
     * @SerializedName("DespatchDocumentReference")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\DespatchDocumentReference")
     */
    private $despatchDocumentReference;

    /**
     * @SerializedName("ReceiptDocumentReference")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\ReceiptDocumentReference")
     */
    private $receiptDocumentReference;

    /**
     * @SerializedName("OriginatorDocumentReference")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\OriginatorDocumentReference")
     */
    private $originatorDocumentReference;

    /**
     * @SerializedName("ContractDocumentReference")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\ContractDocumentReference")
     */
    private $contractDocumentReference;

    /**
     * @XmlList(inline=true, entry="AdditionalDocumentReference", namespace=Namespaces::CAC)
     * @Type("array<OCA\PeppolNext\PonderSource\UBL\Invoice\AdditionalDocumentReference>")
     */
    private $additionalDocumentReferences = [];

    /**
     * @SerializedName("ProjectReference")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\ProjectReference")
     */
    private $projectReference;

    /**
     * @SerializedName("AccountingSupplierParty")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\AccountingSupplierParty")
     */
    private $accountingSupplierParty;

    /**
     * @SerializedName("AccountingCustomerParty")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\AccountingCustomerParty")
     */
    private $accountingCustomerParty;

    /**
     * @SerializedName("PayeeParty")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\PayeeParty")
     */
    private $payeeParty;

    /**
     * @SerializedName("TaxRepresentativeParty")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\TaxRepresentativeParty")
     */
    private $taxRepresentativeParty;

    /**
     * @SerializedName("Delivery")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\Delivery")
     */
    private $delivery;

    /**
     * @XmlList(inline=true, entry="PaymentMeans", namespace=Namespaces::CAC)
     * @Type("array<OCA\PeppolNext\PonderSource\UBL\Invoice\PaymentMeans>")
     */
    private $paymentMeans = [];

    /**
     * @SerializedName("PaymentTerms")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\PaymentTerms")
     */
    private $paymentTerms;

    /**
     * @XmlList(inline=true, entry="AllowanceCharge", namespace=Namespaces::CAC)
     * @Type("array<OCA\PeppolNext\PonderSource\UBL\Invoice\AllowanceCharge>")
     */
    private $allowanceCharges = [];

    /**
     * @SerializedName("TaxTotal")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\TaxTotal")
     */
    private $taxTotal;

    /**
     * @SerializedName("LegalMonetaryTotal")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\LegalMonetaryTotal")
     */
    private $legalMonetaryTotal;

    /**
     * @XmlList(inline=true, entry="InvoiceLine", namespace=Namespaces::CAC)
     * @Type("array<OCA\PeppolNext\PonderSource\UBL\Invoice\InvoiceLine>")
     */
    private $invoiceLines = [];

    public function __construct($id = null, $issueDate = null, $dueDate = null, $invoiceTypeCode = null,
            $note = null, $taxPointDate = null, $documentCurrencyCode = null, $taxCurrencyCode = null,
            $accountingCost = null, $buyerReference = null, $invoicePeriod = null,
            $orderReference = null, $billingReferences = [], $despatchDocumentReference = null,
            $receiptDocumentReference = null, $originatorDocumentReference = null,
            $contractDocumentReference = null, $additionalDocumentReferences = [],
            $projectReference = null, $accountingSupplierParty = null,
            $accountingCustomerParty = null, $payeeParty = null,
            $taxRepresentativeParty = null, $delivery = null, $paymentMeans = [], $paymentTerms = null,
            $allowanceCharges = [], $taxTotal = null, $legalMonetaryTotal = null, $invoiceLines = []) {
        $this->id = $id;
        $this->issueDate = $issueDate;
        $this->dueDate = $dueDate;
        $this->invoiceTypeCode = $invoiceTypeCode;
        $this->note = $note;
        $this->taxPointDate = $taxPointDate;
        $this->documentCurrencyCode = $documentCurrencyCode;
        $this->taxCurrencyCode = $taxCurrencyCode;
        $this->accountingCost = $accountingCost;
        $this->buyerReference = $buyerReference;
        $this->invoicePeriod = $invoicePeriod;
        $this->orderReference = $orderReference;
        $this->billingReferences = $billingReferences;
        $this->despatchDocumentReference = $despatchDocumentReference;
        $this->receiptDocumentReference = $receiptDocumentReference;
        $this->originatorDocumentReference = $originatorDocumentReference;
        $this->contractDocumentReference = $contractDocumentReference;
        $this->additionalDocumentReferences = $additionalDocumentReferences;
        $this->projectReference = $projectReference;
        $this->accountingSupplierParty = $accountingSupplierParty;
        $this->accountingCustomerParty = $accountingCustomerParty;
        $this->payeeParty = $payeeParty;
        $this->taxRepresentativeParty = $taxRepresentativeParty;
        $this->delivery = $delivery;
        $this->paymentMeans = $paymentMeans;
        $this->paymentTerms = $paymentTerms;
        $this->allowanceCharges = $allowanceCharges;
        $this->taxTotal = $taxTotal;
        $this->legalMonetaryTotal = $legalMonetaryTotal;
        $this->invoiceLines = $invoiceLines;
        return $this;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setIssueDate($issueDate) {
        $this->issueDate = $issueDate;
        return $this;
    }

    public function getIssueDate() {
        return $this->issueDate;
    }

    public function setDueDate($dueDate) {
        $this->dueDate = $dueDate;
        return $this;
    }

    public function getDueDate() {
        return $this->dueDate;
    }

    public function setInvoiceTypeCode($invoiceTypeCode) {
        $this->invoiceTypeCode = $invoiceTypeCode;
        return $this;
    }

    public function getInvoiceTypeCode() {
        return $this->invoiceTypeCode;
    }

    public function setNote($note) {
        $this->note = $note;
        return $this;
    }

    public function getNote() {
        return $this->note;
    }

    public function setTaxPointDate($taxPointDate) {
        $this->taxPointDate = $taxPointDate;
        return $this;
    }

    public function getTaxPointDate() {
        return $this->taxPointDate;
    }

    public function setDocumentCurrencyCode($documentCurrencyCode) {
        $this->documentCurrencyCode = $documentCurrencyCode;
        return $this;
    }

    public function getDocumentCurrencyCode() {
        return $this->documentCurrencyCode;
    }

    public function setTaxCurrencyCode($taxCurrencyCode) {
        $this->taxCurrencyCode = $taxCurrencyCode;
        return $this;
    }

    public function getTaxCurrencyCode() {
        return $this->taxCurrencyCode;
    }

    public function setAccountingCost($accountingCost) {
        $this->accountingCost = $accountingCost;
        return $this;
    }

    public function getAccountingCost() {
        return $this->accountingCost;
    }

    public function setBuyerReference($buyerReference) {
        $this->buyerReference = $buyerReference;
        return $this;
    }

    public function getBuyerReference() {
        return $this->buyerReference;
    }

    public function setInvoicePeriod($invoicePeriod) {
        $this->invoicePeriod = $invoicePeriod;
        return $this;
    }

    public function getInvoicePeriod() {
        return $this->invoicePeriod;
    }

    public function setOrderReference($orderReference) {
        $this->orderReference = $orderReference;
        return $this;
    }

    public function getOrderReference() {
        return $this->orderReference;
    }

    public function setBillingReferences($billingReferences) {
        $this->billingReferences = $billingReferences;
        return $this;
    }

    public function getBillingReferences() {
        return $this->billingReferences;
    }

    public function setDespatchDocumentReference($despatchDocumentReference) {
        $this->despatchDocumentReference = $despatchDocumentReference;
        return $this;
    }

    public function getDespatchDocumentReference() {
        return $this->despatchDocumentReference;
    }

    public function setReceiptDocumentReference($receiptDocumentReference) {
        $this->receiptDocumentReference = $receiptDocumentReference;
        return $this;
    }

    public function getReceiptDocumentReference() {
        return $this->receiptDocumentReference;
    }

    public function setOriginatorDocumentReference($originatorDocumentReference) {
        $this->originatorDocumentReference = $originatorDocumentReference;
        return $this;
    }

    public function getOriginatorDocumentReference() {
        return $this->originatorDocumentReference;
    }

    public function setContractDocumentReference($contractDocumentReference) {
        $this->contractDocumentReference = $contractDocumentReference;
        return $this;
    }

    public function getContractDocumentReference() {
        return $this->contractDocumentReference;
    }

    public function setAdditionalDocumentReferences($additionalDocumentReferences) {
        $this->additionalDocumentReferences = $additionalDocumentReferences;
        return $this;
    }

    public function getAdditionalDocumentReferences() {
        return $this->additionalDocumentReferences;
    }

    public function setProjectReference($projectReference) {
        $this->projectReference = $projectReference;
        return $this;
    }

    public function getProjectReference() {
        return $this->projectReference;
    }

    public function setAccountingSupplierParty($accountingSupplierParty) {
        $this->accountingSupplierParty = $accountingSupplierParty;
        return $this;
    }

    public function getAccountingSupplierParty() {
        return $this->accountingSupplierParty;
    }

    public function setAccountingCustomerParty($accountingCustomerParty) {
        $this->accountingCustomerParty = $accountingCustomerParty;
        return $this;
    }

    public function getAccountingCustomerParty() {
        return $this->accountingCustomerParty;
    }

    public function setPayeeParty($payeeParty) {
        $this->payeeParty = $payeeParty;
        return $this;
    }

    public function getPayeeParty() {
        return $this->payeeParty;
    }

    public function setTaxRepresentativeParty($taxRepresentativeParty) {
        $this->taxRepresentativeParty = $taxRepresentativeParty;
        return $this;
    }

    public function getTaxRepresentativeParty() {
        return $this->taxRepresentativeParty;
    }

    public function setDelivery($delivery) {
        $this->delivery = $delivery;
        return $this;
    }

    public function getDelivery() {
        return $this->delivery;
    }

    public function setPaymentMeans($paymentMeans) {
        $this->paymentMeans = $paymentMeans;
        return $this;
    }

    public function getPaymentMeans() {
        return $this->paymentMeans;
    }

    public function setPaymentTerms($paymentTerms) {
        $this->paymentTerms = $paymentTerms;
        return $this;
    }

    public function getPaymentTerms() {
        return $this->paymentTerms;
    }

    public function setAllowanceCharges($allowanceCharges) {
        $this->allowanceCharges = $allowanceCharges;
        return $this;
    }

    public function getAllowanceCharges() {
        return $this->allowanceCharges;
    }

    public function setTaxTotal($taxTotal) {
        $this->taxTotal = $taxTotal;
        return $this;
    }

    public function getTaxTotal() {
        return $this->taxTotal;
    }

    public function setLegalMonetaryTotal($legalMonetaryTotal) {
        $this->legalMonetaryTotal = $legalMonetaryTotal;
        return $this;
    }

    public function getLegalMonetaryTotal() {
        return $this->legalMonetaryTotal;
    }

    public function setInvoiceLines($invoiceLines) {
        $this->invoiceLines = $invoiceLines;
        return $this;
    }

    public function getInvoiceLines() {
        return $this->invoiceLines;
    }

}