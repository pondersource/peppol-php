<?php

use InvalidArgumentException as InvalidArgumentException;

class PartyTaxScheme {
    private $companyId;
    private $taxScheme;

    /**
     * Seller VAT identifier, Seller tax registration identifier
     * Example value: NO999888777
     */
    public function getCompanyId(): ?string {
        return $this->companyId;
    }

    /**
     * Set Company ID
     */
    public function setCompanyId(?string $companyId): PartyTaxScheme {
        $this->companyId = $companyId;
        return $this;
    }

    /**
     * get Tax Scheme
     */
    public function getTaxScheme(): ?TaxScheme {
       return $this->taxScheme;
    }

    /**
     * Set Tax Scheme
     */
    public function setTaxScheme(TaxScheme $taxScheme): PartyTaxScheme {
        $this->taxScheme = $taxScheme;
        return $this;
    }

    /**
     * Validation for taxScheme is not empty
     */
    public function validate() {
        if($this->taxScheme !== null) {
            throw new InvalidArgumentException('Missing TaxScheme');
        }
    }
}