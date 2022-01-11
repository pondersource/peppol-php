<?php

class AllowanceCharge {
    private $chargeIndicator;
    private $allowanceChargeReasonCode;
    private $allowanceChargeReason;
    private $multiplierFactorNumeric;
    private $baseAmount;
    private $amount;
    private $taxCategory;


    /**
     * Use “true” when informing about Charges and “false” when informing about Allowances. 
     */
    public function isChargeIndicator(): ?bool {
        return $this->$chargeIndicator;
    }

    /**
     * set charge indicator
     */
    public function setChargeIndicator(bool $chargeIndicator): AllowanceCharge {
        $this->chargeIndicator = $chargeIndicator;
        return $this;
    }

    /**
     * Document level allowance or charge reason code
     */
    public function getAllowanceChargeReasonCode(): ?int {
        return $this->allowanceChargeReasonCode;
    }

    /**
     * set document level reason code
     */
    public function setAllowanceReasonCode(int $allowanceChargeReasonCode): AllowanceCharge {
        $this->allowanceChargeReasonCode = $allowanceChargeReasonCode;
        return $this;
    }

    /**
     *  Document level allowance or charge reason
     */
    public function getAllowanceChargeReason(): ?string {
        return $this->allowanceChargeReason;
    }

    /**
     * set document level reason code
     */
    public function setAllowanceReason(string $allowanceChargeReasonCode): AllowanceCharge {
        $this->allowanceChargeReason = $allowanceChargeReason;
        return $this;
    }

      /**
     * @return int
     */
    public function getMultiplierFactorNumeric(): ?int
    {
        return $this->multiplierFactorNumeric;
    }

    /**
     * @param int $multiplierFactorNumeric
     * @return AllowanceCharge
     */
    public function setMultiplierFactorNumeric(?int $multiplierFactorNumeric): AllowanceCharge
    {
        $this->multiplierFactorNumeric = $multiplierFactorNumeric;
        return $this;
    }

    /**
     * get base amount
     */
    public function getBaseAmount(): ?float {
        return $this->baseAmount;
    }

    /**
     * set base amount
     */
    public function setBaseAmount(float $baseAmount): AllowanceCharge {
        $this->baseAmount = $baseAmount;
        return $this;
    }

     /**
     * get amount
     */
    public function getAmount(): ?float {
        return $this->amount;
    }

    /**
     * set base amount
     */
    public function setAmount(float $amount): AllowanceCharge {
        $this->amount = $amount;
        return $this;
    }

    /**
     * return Tax Category
     */
    public function getTaxCategory(): ?TaxCategory {
        return $this->taxCategory;
    }

    /**
     * Set tax category
     */
    public function setTaxCategory(TaxtCategory $taxCategory): AllowanceCharge {
        $this->taxCategory = $taxCategory;
        return $this;
    }
}