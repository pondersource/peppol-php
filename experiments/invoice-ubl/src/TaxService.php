<?php

class TaxService {
    private $id;

    public function getServiceTax() {
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
}