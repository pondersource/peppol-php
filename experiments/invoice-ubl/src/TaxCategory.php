<?php

class TaxCategory extends ServiceTax {
    private $id;
    private $idAttributes = [
        'schemeID' => TaxCategory::UNCL5305,
        'schemeName' => 'Duty or tax or fee category'
    ];
    private $percent;
    private $taxScheme;

    public const UNCL5305 = 'UNCL5305';

    /**
     * Document level allowance or charge VAT category code
     */
    public function getId(): ?string {
       return $this->id;
    }

    /**
     * Set Vat category code
     */
    public function setId(?string $id): TaxCategory {
        $this->id = $id;
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
    public function setPercent(?float $percent): TaxCategory {
        $this->percent = $percent;
        return $this;
    }
    
    /**
     * TAX SCHEME
     */
    public function setTaxScheme(?TaxScheme $taxScheme): TaxCategory {
         $this->taxScheme = $taxScheme;
         return $this;
    }

    /**
     * get tax scheme
     */
    public function getTaxScheme(): ?TaxScheme {
        return $this->taxScheme;
    }

    /**
     * Validation for missing taxcategory id and percent
     */
    public function validate()
    {
        if ($this->getId() === null) {
            throw new InvalidArgumentException('Missing taxcategory id');
        }

        if ($this->getPercent() === null) {
            throw new InvalidArgumentException('Missing taxcategory percent');
        }
    }
}