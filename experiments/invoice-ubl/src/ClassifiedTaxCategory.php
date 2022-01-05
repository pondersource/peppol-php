<?php


use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

use InvalidArgumentException as InvalidArgumentException;

class ClassifiedTaxCategory implements XmlSerializable {
    private $id;
    private $percent;
    private $taxScheme;
    private $schemeID;
    private $schemeName;

    /**
     * Invoiced item VAT category code
     */
    public function getId(): ?string {
        if (!empty($this->id)) {
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
     * Serialize Classified Tax Category
     */
    public function xmlSerialize(Writer $writer) {
        $this->validate();

        $schemeAttributes = [];
        if($this->schemeID !== null) {
            $schemeAttributes['schemeID'] = $this->schemeID;
        }
        if($this->schemeName !== null) {
            $schemeAttributes['schemeName'] = $this->schemeName;
        }

        $writer->write([
            [
                'name' => Schema::CBC . 'ID',
                'value' => $this->getId(),
                'attributes' => $schemeAttributes
            ],
            Schema::CBC . 'Percent' => number_format($this->percent, 2, '.', ''),
        ]);

        if ($this->taxScheme !== null) {
            $writer->write([Schema::CAC . 'TaxScheme' => $this->taxScheme]);
        } else {
            $writer->write([
                Schema::CAC . 'TaxScheme' => null,
            ]);
        }
    }
}
