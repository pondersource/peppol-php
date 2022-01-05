<?php

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class Price implements XmlSerializable {
    private $priceAmount;
    private $baseQuantity;
    private $unitCode = UnitCode::UNIT;

    /**
     * The price of an item, exclusive of VAT, after subtracting item price discount. 
     *  Example value: 23.45
     */
    public function getPriceAmount(): ?float {
        return $this->priceAmount;
    }

    /**
     * Set price amount
     */
    public function setPriceAmount(?float $priceAmount): Price {
       $this->priceAmount = $priceAmount;
       return $this;
    }
    
    /**
     * The number of item units to which the price applies.
     * Example value: 1
     */
    public function getBaseQuantity(): ?float {
        return $this->baseQuantity;
    }

    /**
     * Set base quantity
     */
    public function setBaseQuantity(?float $baseQuantity): Price {
        $this->baseQuantity = $baseQuantity;
        return $this;
    }

    /**
     * get unit code
     */
    public function getUnitCode(): ?string {
        return $this->unitCode;
    }

    /**
     * set unit code
     */
    public function setUnitCode(?string $unitCode): Price {
        $this->unitCode = $unitCode;
        return $this;
    }

    /**
     * Serialize Price
     */
    public function xmlSerialize(Writer $writer) {
        $writer->write([
            [
                'name' => Schema::CBC . 'PriceAmount',
                'values' => number_format($this->priceAmount, 2, '.', ''),
                'attributes' => [
                    'currencyID' => GenerateInvoice::$currencyID
                ]
            ],
            [
                'name' => Schema::CBC . 'BaseQuantity',
                'values' => number_format($this->baseQuantity, 2, '.', ''),
                'attributes' => [
                    'unitCode' => $this->unitCode
                ]
            ],
        ]);
    }
}