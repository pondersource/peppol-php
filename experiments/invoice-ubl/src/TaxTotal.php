<?php

use InvalidArgumentException as InvalidArgumentException;

class TaxTotal {
    private $taxAmount;
    private $taxSubtotals = [];

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
        return $this->taxSubtotals;
    }

    /**
     * Set tax subtotal
     */
    public function setTaxSubtotal(TaxSubTotal $taxSubTotal): TaxTotal {
        $this->taxSubTotals[] = $taxSubTotal;
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
}