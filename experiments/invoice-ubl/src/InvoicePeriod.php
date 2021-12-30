<?php

use DateTime;

class InvoicePeriod {
    private $startDate;
    private $endDate;

    /**
     *  Invoice line period start date
     */
    public function getStartDate(): ?Datetime {
       return $this->startDate;
    }

    /**
     * Set start Date
     */
    public function setStartDate(?Datetime $startDate): InvoicePeriod {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     *  Invoice line period end date
     */
    public function getEndDate(): ?Datetime {
        return $this->endDate;
     }
 
     /**
      * Set start Date
      */
     public function setEndDate(?Datetime $endDate): InvoicePeriod {
         $this->endDate = $endDate;
         return $this;
     }
}