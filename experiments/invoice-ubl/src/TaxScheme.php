<?php

class TaxScheme {
    private $id;
    /**
     * For Seller Vat Identifier get
     * Example value: VAT
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     *Set ID 
     */
    public function setId(?string $id): TaxScheme {
        $this->id = $id;
        return $this;
    }
}