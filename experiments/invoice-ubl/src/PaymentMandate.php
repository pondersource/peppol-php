<?php

class PaymentMandate {
    private $id;
    private $payerFinancialAccount;

    /**
     * Mandate reference identifier
     * example value 1234
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

    /**
     * PAYER FINANCIAL ACCOUNT
     */
    public function getPayerFinancialAccount(): ?PayerFinancialAccount {
        return $this->payerFinancialAccount;
    }

    /**
     * Set payer financial account
     */
    public function setPayerFinancialAccount(?PayerFinancialAccount $payerFinancialAccount): PaymentMandate {
        $this->payerFinancialAccount = $payerFinancialAccount;
        return $this;
    } 
}