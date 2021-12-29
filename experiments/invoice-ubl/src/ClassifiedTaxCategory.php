<?php

class ClassifiedTaxCategory {
    private $id;
    private $percent;
    private $taxScheme;

    /**
     * Invoiced item VAT category code
     */
    public function getId(): ?string {
        if(!empty($this->id)) {
           return $this->id;
        }

        if ($this->getPercent() !== null) {
            if ($this->getPercent() >= 21) {
                return VatCategoryCode::STANDART_RATE;
            } elseif ($this->getPercent() <= 21 && $this->getPercent() >= 6) {
                return VatCategoryCode::VAT_REVERSE_CHANGE;
            } else {
                return VatCategoryCode::ZERO_RATE_GOODS;
            }
        }

        return null;
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
}