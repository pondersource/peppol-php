<?php


class LegalMonetaryTotal {
    private $lineExtensionAmount;
    private $taxExclusiveAmount;
    private $taxInclusiveAmount;
    private $allowanceTotalAmount = 0.0;
    private $chargeTotalAmount = 0.0;
    private $prepaidAmount;
    private $payableRoundingAmount;
    private $payableAmount;

    /**
     * Sum of Invoice line net amount
     */
    public function getLineExtensionAmount(): ?float {
        return $this->lineExtensionAmount;
    }

    /**
     * Set line extension Amount 
     */
    public function setLineExtensionAmount(?float $lineExtensionAmount): LegalMonetaryTotal {
        $this->lineExtensionAmount = $lineExtensionAmount;
        return $this;
    } 

    /**
     * Invoice total amount without VAT
     */
    public function getTaxExclusiveAmount(): ?float {
        return $this->taxExclusiveAmount;
    }

    /**
     * Set tax exclusive amount
     */
    public function setTaxExclusiveAmount(?float $taxExclusiveAmount): LegalMonetaryTotal {
        $this->taxExclusiveAmount = $taxExclusiveAmount;
        return $this;
    }

    /**
     * Invoice total amount with VAT
     */
    public function getTaxInclusiveAmount(): ?float {
        return $this->taxInclusiveAmount;
    }

    /**
     * Set tax inclusive amount
     */
    public function setTaxInclusiveAmount(?float $taxInclusiveAmount): LegalMonetaryTotal {
        $this->taxInclusiveAmount = $taxInclusiveAmount;
        return $this;
    }

    /**
     * Sum of allowances on document level
     */
    public function allowanceTotalAmount(): ?float {
        return $this->allowanceTotalAmount;
    }

    /**
     * set allowance total amount
     */
    public function setAllowanceTotalAmount(?float $allowanceTotalAmount): LegalMonetaryTotal {
        $this->allowanceTotalAmount = $allowanceTotalAmount;
        return $this;
    }
    
    /**
     * Amount due for payment
     */
    public function getPayableAmount(): ?float {
        return $this->payableAmount;
    }

    /**
     * Set payable amout
     */
    public function setPayableAmount(?float $payableAmount): LegalMonetaryTotal {
        $this->payableAmount = $payableAmount;
        return $this;
    }
}