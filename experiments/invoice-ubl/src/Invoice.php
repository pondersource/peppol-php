<?php

use DateTime as DateTime;
require 'InvoiceTypeCode.php';

class Invoice {
    private $UBLVersionID = '2.1';
    private $customazionID;
    private $profileID;
    private $id;
    private $issueDate;
    private $dueDate;
    private $currencyCode = 'EUR';
    private $invoiceTypeCode = InvoiceTypeCode::COMMERCICAL_INVOICE;
    private $copyIndicator;
    private $note;
    private $taxPointDate;
    private $paymentTerms;
    private $accountingSupplierParty;
    private $accountingCustomerParty;
    private $supplierAssignedAccountID;
    private $paymentMeans;
    private $taxTotal;
    private $legalMonetaryTotal;
    private $invoiceLines;
    private $allowanceCharges;
    private $additionalDocumentReferences;
    private $byerReference;
    private $accountingCostCode;
    private $invoicePeriod;
    private $delivery;
    private $orderReference;
    private $contractDocumentReference;
    
    /**
     * get UBL version ID
     */
    public function getUBLVersionID(): ?string
    {
        return $this->UBLVersionID;
    }

    /**
     * Set UBL version ID
     */
    public function setUBLVersionID(?string $UBLVersionID): Invoice
    {
        $this->UBLVersionID = $UBLVersionID;
        return $this;
    }

    /**
     * Specification identifier
     * Default value: urn:cen.eu:en16931:2017#compliant#urn:fdc:peppol.eu:2017:poacc:billing:3.0
     */
    public function getCustomazationID(): ?string {
        return $this->customazionID;
    }

    /**
     * Set ID
     */
    public function setCustomazationID(?string $customazionID): Invoice {
        $this->customazionID = $customazionID;
        return $this;
    }

    /**
     * Business process type
     *  Default value: urn:fdc:peppol.eu:2017:poacc:billing:01:1.0
     */
    public function getProfileID(): ?string {
        return $this->profileID;
    }

    /**
     * Set Profile ID
     */
    public function setProfileID(?string $profileID): Invoice {
        $this->profileID = $profileID;
        return $this;
    }

      /**
     * Invoice number
     * Example value: 33445566
     */
    public function getId(): ?string {
        return $this->id;
    }

    /**
     * Set ID
     */
    public function setID(?string $id): Invoice {
        $this->id = $id;
        return $this;
    }

    /**
     * Set issue Date
    */
    public function setIssueDate(?Datetime $issueDate): Invoice {
        $this->issueDate = $issueDate;
        return $this;
    }
    
    /**
     *  Invoice issue date
     * Example value: 2017-11-01
     */
    public function getIssueDate(): ?Datetime {
        return $this->issueDate;
    }

    /**
     * Set due date  
     */
    public function setDueDate(?Datetime $dueDate): Invoice
    {
        $this->dueDate = $dueDate;
        return $this;
    }

     /**
     * Payment due date
     * Example value: 2017-11-01 
     */
    public function getDueDate(): ?Datetime {
        return $this->dueDate;
    }

    /**
     * Set Currency
     */
    public function setCurrencyCode(?string $currencyCode = 'EUR')
    {
        $this->currencyCode = $currencyCode;
        return $this;
    }

     /**
     * Get Currency
     */
    public function getCurrencyCode(): ?string 
    {
       return $this->currencyCode;
    }

    /**
     * Invoice type code
     *  Example value: 380
     */
    public function getInvoiceTypeCode(): ?string {
        return $this->invoiceTypeCode;
    }

    /**
     * Set invoice type code
     */
    public function setInvoiceTypeCode(string $invoiceTypeCode): Invoice {
        $this->invoiceTypeCode = $invoiceTypeCode;
        return $this;
    }

    /**
     * get copy indicator
     */
    public function getCopyIndicatory(): bool {
        return $this->copyIndicator;
    }

    /**
     * set copy indicator
     */
    public function setCopyIndicator(bool $copyIndicator): Invoice {
        $this->copyIndicator = $copyIndicator;
        return $this;
    }

    /**
     *  Invoice note
     * Example value: Please note our new phone number 33 44 55 66
     */
    public function getNote(): ?string {
        return $this->note;
    }

    /**
     * set note
     */
    public function setNote(?string $note) {
        $this->note = $note;
        return $this;
    }

    /**
     * Value added tax point date
     *  Example value: 2017-11-01 
     */
    public function getTaxPointDate(): ?DateTime {
        return $this->taxPointDate;
    }

    /**
     * Set tax point date
     */
    public function setTaxPointDate(Datetime $taxPointDate): Invoice {
        $this->taxPointDate = $taxPointDate;
        return $this;
    }

    /**
     * get Payment Terms
     */
    public function getPaymentTerms(): ?PaymentTerms {
        return $this->paymentTerms;
    }

    /**
     * set payment terms
     */
    public function setPaymentTerms(PaymentTerms $paymentTerms): Invoice {
        $this->paymentTerms = $paymentTerms;
        return $this;
    }

    /**
     * Seller
     */
    public function getAccountingSupplierParty(): ?Party {
        return $this->accountingSupplierParty;
    }

    /**
     * Set accounting supplier
     */
    public function setAccountingSupplierParty(?Party $accountingSupplierParty): Invoice {
        $this->accountingSupplierParty = $accountingSupplierParty;
        return $this;
    }

    /**
     * Byer
     */
    public function getAccountingCustomerParty(): ?Party {
        return $this->accountingCustomerParty;
    }

    /**
     * Set accounting supplier
     */
    public function setAccountingCustomerParty(?Party $accountingCustomerParty): Invoice {
        $this->accountingCustomerParty = $accountingCustomerParty;
        return $this;
    }

    /**
     * get Supplier Assigned Account ID
     */
    public function getSupplierAssignedAccountID(): ?string
    {
        return $this->supplierAssignedAccountID;
    }

    /**
     * Set Supplier Assigned Account ID
     */
    public function setSupplierAssignedAccountID(string $supplierAssignedAccountID): Invoice
    {
        $this->supplierAssignedAccountID = $supplierAssignedAccountID;
        return $this;
    }

    /**
     * get payment means 
     */
    public function getPaymentMeans(): ?PaymentMeans {
        return $this->paymentMeans;
    }

    /**
     * set payment means
     */
    public function setPaymentMeans(PaymentMeans $paymentMeans): Invoice {
        $this->paymentMeans = $paymentMeans;
        return $this;
    }

    /**
     * get tax total
     */
    public function getTaxtTotal(): ?TaxtTotal {
        return $this->taxTotal;
    }

    /**
     * Set tax total
     */
    public function setTaxTotal(TaxTotal $taxTotal): Invoice {
        $this->taxTotal = $taxTotal;
        return $this;
    }

    /**
     * get legal Monetary Total
     */
    public function getLegalMonetaryTotal(): ?LegalMonetaryTotal {
        return $this->legalMonetaryTotal;
    }

    /**
     * set legal Monetary Total
     */
    public function setLegalMonetaryTotal(LegalMonetaryTotal $legalMonetaryTotal): Invoice {
        $this->legalMonetaryTotal = $legalMonetaryTotal;
        return $this;
    }

     /**
     * get invoice lines
     */
    public function getInvoiceLines(): InvoiceLine {
        return $this->invoiceLines;
    }

    /**
     * Set invoice lines
     */
    public function setInvoiceLines(InvoiceLine $invoiceLines): Invoice {
         $this->invoiceLines = $invoiceLines;
         return $this;
    }

    /**
     * get allowance chanrges
     */
    public function getAllowanceCharges(): ?array
    {
        return $this->allowanceCharges;
    }

    /**
     * set allowance charges
     */
    public function setAllowanceCharges(array $allowanceCharges): Invoice
    {
        $this->allowanceCharges = $allowanceCharges;
        return $this;
    }

    /**
     * get additional document reference
     */
    public function getAdditionalDocumentReference(): ?AdditionalDocumentReference
    {
        return $this->additionalDocumentReferences;
    }

    /**
     * set addional document reference
     */
    public function setAdditionalDocumentReference(AdditionalDocumentReference $additionalDocumentReference): Invoice
    {
        $this->additionalDocumentReference = $additionalDocumentReference;
        return $this;
    }

    /**
     * get byer reference
     */
    public function getByerReference(): ?string {
        return $this->byerReference;
    }

    /**
     * set byer reference
     */
    public function setByerReference(string $byerReference) {
        $this->byerReference = $byerReference;
        return $this;
    }

    /**
     * get accounting cost code
     */
    public function getAccountingCostCode(): ?string {
        return $this->accountingCostCode;
    }

    /**
     * set account cost code
     */
    public function setAccountingCostCode(string $accountingCostCode) {
        $this->accountingCostCode = $accountingCostCode;
        return $this;
    }

    /**
     * get invoice period
     */
    public function getInvoicePeriod(): InvoicePeriod {
        return $this->invoicePeriod;
    }

    /**
     * Set invoice period
     */
    public function setInvoicePeriod(InvoicePeriod $invoicePeriod): Invoice {
         $this->invoicePeriod = $invoicePeriod;
         return $this;
    }

    /**
     * get Delivery
     */
    public function getDelivery(): ?Delivery {
        return $this->delivery;
    }

    /**
     * set delivery
     */
    public function setDelivery(Delivery $delivery) {
        $this->delivery = $delivery;
        return $this;
    }

    /**
     * get order reference
     */
    public function getOrderReference(): ?OrderReference {
        return $this->orderReference;
    }

    /**
     * set order reference
     */
    public function setOrderReference(OrderReference $orderReference): Invoice {
        $this->orderReference = $orderReference;
        return $this;
    }

    /**
     * get contact document reference
     */
    public function getContactDocumentReference(): ?ContractDocumentReference {
        return $this->contractDocumentReference;
    }

    /**
     * set contact document reference
     */
    public function setContactDocumentReference(ContractDocumentReference $contractDocumentReference): Invoice {
        $this->contractDocumentReference = $contractDocumentReference;
        return $this;
    }
}
