<?php

use InvalidArgumentException as InvalidArgumentException;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class TaxCategory implements XmlSerializable {
    private $id;
    private $idAttributes = [
        'schemeID' => TaxCategory::UNCL5305,
        'schemeName' => 'Duty or tax or fee category'
    ];
    private $percent;
    private $taxScheme;
    private $taxExemptionReason;
    private $taxExemptionReasonCode;

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
    public function setId(?string $id, $attributes = null): TaxCategory {
        $this->id = $id;
        if (isset($attributes)) {
            $this->idAttributes = $attributes;
        }
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
     * A textual statement of the reason why the amount is exempted from VAT or why no VAT is being charged
     */
    public function getTaxExemptionReason(): ?string
    {
        return $this->taxExemptionReason;
    }

    /**
     * Set exemption reason
     * Example value: Reason
     */
    public function setTaxExemptionReason(?string $taxExemptionReason): TaxCategory
    {
        $this->taxExemptionReason = $taxExemptionReason;
        return $this;
    }

    /**
     * A coded statement of the reason for why the amount is exempted from VAT
     */
    public function getTaxExemptionReasonCode(): ?string
    {
        return $this->taxExemptionReasonCode;
    }

    /**
     * Set tax exemption reason code
     */
    public function setTaxExemptionReasonCode(?string $taxExemptionReasonCode): TaxCategory
    {
        $this->taxExemptionReasonCode = $taxExemptionReasonCode;
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

    /**
     * Serialize Tax Category
     */
    public function xmlSerialize(Writer $writer)
    {
        $this->validate();

        $writer->write([
            [
                'name' => Schema::CBC . 'ID',
                'value' => $this->getId(),
                'attributes' => $this->idAttributes,
            ],
        ]);

        if ($this->name !== null) {
            $writer->write([
                Schema::CBC . 'Name' => $this->name,
            ]);
        }
        $writer->write([
            Schema::CBC . 'Percent' => number_format($this->percent, 2, '.', ''),
        ]);

        if ($this->taxExemptionReasonCode !== null) {
            $writer->write([
                Schema::CBC . 'TaxExemptionReasonCode' => $this->taxExemptionReasonCode,
            ]);
        }

        if ($this->taxExemptionReason !== null) {
            $writer->write([
                Schema::CBC . 'TaxExemptionReason' => $this->taxExemptionReason,
            ]);
        }

        if ($this->taxScheme !== null) {
            $writer->write([Schema::CAC . 'TaxScheme' => $this->taxScheme]);
        } else {
            $writer->write([
                Schema::CAC . 'TaxScheme' => null,
            ]);
        }
    }
}