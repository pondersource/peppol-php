<?php

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class InvoiceLine implements XmlSerializable {
    private $id;
    private $note;
    private $invoiceQuantity;
    private $unitCode = UnitCode::UNIT;
    private $lineExtensionAmount;
    private $accountingCost;
    private $accountingCostCode;
    private $invoicePeriod;
    private $item;
    private $price;
    private $taxTotal;

    /**
     * A unique identifier for the individual line within the Invoice.
     *  Example value: 12 
     */
    public function getId(): ?string {
        return $this->id;
    }

    /**
     * Set unique identifier
     */
    public function setId(?string $id): InvoiceLine {
        $this->id = $id;
        return $this;
    }

    /**
     * A textual note that gives unstructured information that is relevant to the Invoice line. 
     * Example value: New article number 12345
     */
    public function getNote(): ?string {
        return $this->note;
    }

    /**
     * Set note
     */
    public function setNote(?string $note): InvoiceLine {
         $this->note = $note;
         return $this;
    }

    /**
     * The quantity of items (goods or services) that is charged in the Invoice line.
     *  Example value: 100 
     */
    public function getInvoiceQuantity(): ?float {
        return $this->invoiceQuantity;
    }

    /**
     * Set invoice quantity
     */
    public function setInvoiceQuantity(?float $invoiceQuantity): InvoiceLine {
        $this->invoiceQuantity = $invoiceQuantity;
        return $this;
    }

    /**
     * The total amount of the Invoice line. 
     * The amount is “net” without VAT, i.e. inclusive of line level allowances and charges as well as other relevant taxes.
     * Example value: 2145.00 
     */
    public function getLinesExtensionAmount(): ?float {
        return $this->lineExtensionAmount;
    }


    /**
     * Set lines extension amount
     */
    public function setLinesExtensionAmount(?float $lineExtensionAmount): InvoiceLine {
        $this->lineExtensionAmount = $lineExtensionAmount;
        return $this;
    }

    /**
     * get tax total
     */
    public function getTaxTotal(): ?TaxTotal
    {
        return $this->taxTotal;
    }

    /**
     * set tax total
     */
    public function setTaxTotal(?TaxTotal $taxTotal): InvoiceLine
    {
        $this->taxTotal = $taxTotal;
        return $this;
    }

    /**
     * get unit code
     */
    public function getUnitCode(): ?string {
        return $this->unitCode;
    }

    /**
     * set unit code
     */
    public function setUnitCode(?string $unitCode): InvoiceLine {
        $this->unitCode = $unitCode;
        return $this;
    }

      /**
     * get item
     */
    public function getItem(): ?Item
    {
        return $this->item;
    }

    /**
     * set tax total
     */
    public function setItem(?Item $item): InvoiceLine
    {
        $this->item = $item;
        return $this;
    }


    /**
     * get price
     */
    public function getPrice(): ?Price
    {
        return $this->price;
    }

    /**
     * set tax total
     */
    public function setPrice(?Price $price): InvoiceLine
    {
        $this->price = $price;
        return $this;
    }


    /**
     * get invoice period
     */
    public function getInvoicePeriod(): ?InvoicePeriod
    {
        return $this->invoicePeriod;
    }

    /**
     * set invoice period
     */
    public function setInvoicePeriod(?InvoicePeriod $invoicePeriod): InvoiceLine
    {
        $this->invoicePeriod = $invoicePeriod;
        return $this;
    }

    /**
     *  Invoice line Buyer accounting reference
     */
    public function getAccountingCost(): ?string {
        return $this->accountingCost;
    }

    /**
     * Set Buyer accounting 
     */
    public function setAccountingCost(?string $accountingCost): InvoiceLine {
        $this->accountingCost = $accountingCost;
        return $this;
    }

     /**
     *  Invoice line Buyer accounting reference code
     */
    public function getAccountingCostCode(): ?string {
        return $this->accountingCostCode;
    }

    /**
     * Set Buyer accounting cost
     */
    public function setAccountingCostCode(?string $accountingCostCode): InvoiceLine {
        $this->accountingCostCode = $accountingCostCode;
        return $this;
    }

    /**
     * Invoice Line serialize
     */
    public function xmlSerialize(Writer $writer) {
        $writer->write([
             Schema::CBC . 'ID' => $this->id 
        ]);

        if(!empty($this->getNote())) {
            $writer->write([
                Schema::CBC . 'Note' => $this->note 
           ]);
        }

        $writer->write([
            [
                'name' => Schema::CBC . 'InvoiceQuantity',
                'value' => $this->invoiceQuantity,
                'attributes' => [
                    'unitCode' => $this->unitCode
                ]
            ],
            [
                'name' => Schema::CBC . 'LineExtensionAmount',
                'value' => $this->lineExtensionAmount,
                'attributes' => [
                    'currencyID' => GenerateInvoice::$currencyID
                ]
            ]
        ]);

        if ($this->accountingCostCode !== null) {
            $writer->write([
                Schema::CBC . 'AccountingCostCode' => $this->accountingCostCode
            ]);
        }
        if ($this->accountingCost !== null) {
            $writer->write([
                Schema::CBC . 'AccountingCost' => $this->accountingCost
            ]);
        }

        if($this->invoicePeriod !== null) {
            $writer->write([
                Schema::CAC . 'InvoicePeriod' => $this->invoicePeriod
            ]);
        }

        if($this->taxTotal !== null) {
            $writer->write([
                Schema::CAC . 'TaxTotal' => $this->taxTotal
            ]);
        }

        $writer->write([
            Schema::CAC . 'Item' => $this->item
        ]);

        if($this->price !== null) {
            $writer->write([
                Schema::CAC . 'Price' => $this->price
            ]);
        } else {
            $writer->write([
                Schema::CAC . 'TaxScheme' => null,
            ]);
        }
    }
}