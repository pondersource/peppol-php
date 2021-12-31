<?php

class PaymentTerms {
    private $note;

    /**
     *  Payment terms
     */
    public function getNote(): ?string {
        return $this->note;
    }

    /**
     * set note
     */
    public function setNote(?string $note): PaymentTerms {
        $this->note = $note;
        return $this;
    }
}