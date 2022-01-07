<?php

use InvalidArgumentException as InvalidArgumentException;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;


class TaxTotal implements XmlSerializable {
    private $taxAmount;
    private $taxSubTotals = [];

    /**
     * Invoice total VAT amount, Invoice total VAT amount in accounting currency
     */
    public function getTaxAmount(): ?float {
        return $this->taxAmount;
    }

    /**
     * Set tax amount
     */
    public function setTaxAmount(?float $taxAmount): TaxTotal {
        $this->taxAmount = $taxAmount;
        return $this;
    }

    /**
     *  VAT BREAKDOWN
     */
    public function getTaxSubtotal(): array  {
        return $this->taxSubTotals;
    }

    /**
     * Set tax subtotal
     */
    public function setTaxSubtotal(TaxSubTotal $taxSubTotals): TaxTotal {
        $this->taxSubTotals[] = $taxSubTotals;
        return $this;
    }

    /**
     * validation for tax amount
     */
    public function validate() {
        if($this->taxAmount === null) {
            throw new InvalidArgumentException('Missing taxtotal tax amount');
        }
    }

    /**
     * Serialize TaxtTotal
     */
    public function xmlSerialize(Writer $writer): void {
        $writer->write([
            'name' => Schema::CBC . 'TaxAmount',
            'value' => number_format($this->taxAmount, 2, '.',''),
            'attributes' => [
                'currencyID' => GenerateInvoice::$currencyID
            ]
        ]);

        foreach($this->taxSubTotals as $taxSubTotal) {
            $writer->write([ Schema::CAC . 'TaxSubtotal' => $taxSubTotal]);
        }
    }
}