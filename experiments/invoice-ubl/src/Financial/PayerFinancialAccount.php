<?php

class PayerFinancialAccount {
    private $id;

    /**
     * Debited account identifier
     * example value 12345676543
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * Set ID
     */
    public function setId(?int $id): PaymentMandate {
        $this->id = $id;
        return $this;
    }
}