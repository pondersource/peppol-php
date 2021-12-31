<?php

use Datetime;

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
    public function setInvoiceTypeCode(?string $invoiceTypeCode): Invoice {
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
    public function setTaxPointDate(?Datetime $taxPointDate): Invoice {
        $this->taxPointDate = $taxPointDate;
        return $this;
    }
}
