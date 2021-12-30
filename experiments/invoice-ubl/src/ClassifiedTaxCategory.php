<?php

use InvalidArgumentException as InvalidArgumentException;

class ClassifiedTaxCategory {
    private $id;
    private $percent;
    private $taxScheme;

    /**
     * Invoiced item VAT category code
     */
    public function getId(): ?string {
       return $this->id;
    }

    /**
     * Set ID
     */
    public function setId(?string $id): ClassifiedTaxCategory {
        $this->id = $id;
        return $this;
    }

    /**
     * Invoiced item VAT rate
     */
    public function getPercent(): ?float {
        return $this->percent;
    }

    /**
     * Set percent
     */
    public function setPercent(?float $percent): ClassifiedTaxCategory {
        $this->percent = $percent;
        return $this;
    }

    /**
     * get taxt scheme
     */
    public function getTaxScheme(): ?TaxScheme {
        return $this->taxScheme;
    }

    /**
     * Set TAX SCHEME
     */
    public function setTaxScheme(?TaxScheme $taxScheme): ClassifiedTaxCategory {
        $this->taxScheme = $taxScheme;
        return $this;
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
