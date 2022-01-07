<?php

use InvalidArgumentException as InvalidArgumentException;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class TaxSubTotal implements XmlSerializable {
    private $taxableAmount;
    private $taxAmount;
    private $taxCategory;
    private $percent;
    
    /**
     * VAT category taxable amount
     * Example value: 1945.00
     */
    public function getTaxAbleAmount(): ?float {
        return $this->taxableAmount;
    }

    /**
     * Set taxable amout
     */
    public function setTaxAbleAmount(?float $taxableAmount): TaxSubTotal {
        $this->taxableAmount = $taxableAmount;
        return $this;
    }

    /**
     * VAT category tax amount
     * Example value: 486.25
     */
    public function getTaxAmount(): ?float {
        return $this->taxAmount;
    }

    /**
     * Set tax amount
     */
    public function setTaxAmount(?float $taxAmount): TaxSubTotal {
        $this->taxAmount = $taxAmount;
        return $this;
    }

    /**
     *  VAT CATEGORY
     */
    public function getTaxCategory(): ?TaxCategory {
        return $this->taxCategory;
    }

    /**
     * Set vat category
     */
    public function setTaxCategory(?TaxCategory $taxCategory): TaxSubTotal {
        $this->taxCategory = $taxCategory;
        return $this;
    }

    /**
     *  Document level allowance or charge VAT rate
     */
    public function getPercent(): ?float {
        return $this->percent;
    }

    /**
     * Set Percent
     */
    public function setPercent(?float $percent): TaxSubTotal {
        $this->percent = $percent;
        return $this;
    }

    /**
     * Validation tax amount, taxable amount and taxcategory
     */
    public function validate() {
        if($this->taxableAmount === null) {
           throw new InvalidArgumentException('Missing taxable amount');
        }
        if($this->taxAmount === null) {
            throw new InvalidArgumentException('Missing tax amount');
        }
        if($this->taxCategory === null) {
            throw new InvalidArgumentException('Missing tax category');
        }
    }

    /**
     * Serialize TaxSubtotal
     */
    public function xmlSerialize(Writer $writer) {
        $this->validate();

        $writer->write([
            [
                'name' => Schema::CBC . 'TaxableAmount',
                'value' => number_format($this->taxableAmount, 2, '.', ''),
                'attributes' => [
                    'currencyID' => GenerateInvoice::$currencyID
                ]
            ],
            [
                'name' => Schema::CBC . 'TaxAmount',
                'value' => number_format($this->taxAmount, 2, '.', ''),
                'attributes' => [
                    'currencyID' => GenerateInvoice::$currencyID
                ]
            ]
        ]);

        if($this->percent !== null) {
            $writer->write([
                Schema::CBC . 'Percent' => $this->percent
            ]);
        }

        $writer->write([
            Schema::CAC . 'TaxCategory' => $this->taxCategory
        ]);
    }
}