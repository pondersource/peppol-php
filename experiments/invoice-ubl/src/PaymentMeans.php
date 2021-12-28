<?php

class PaymentMeans {
    private $paymentMeansCode = 1;
    private $paymentMeansCodeAttributes = [
        'listID' => 'UN/ECE 4461',
        'listName' => 'Payment Means',
        'listURI' => 'http://docs.oasis-open.org/ubl/os-UBL-2.0-update/cl/gc/default/PaymentMeansCode-2.0.gc'
    ];
    private $paymentId;
    private $cardAccountHolder;
    private $payeeFinancialAccount;
    private $paymentMandate;

    /**
     * Payment means type code
     * Example value: 30
     */
    public function getPaymentMeansCode(): ?int {
        return $this->paymentMeansCode;
    }

    /**
     * Set Payment means code
     */
    public function setPaymentMeansCode(?int $paymentMeansCode, $attributes = null): PaymentMeans {
        $this->paymentMeansCode = $paymentMeansCode;
        if($this->attributes !== null) {
            $this->paymentMeansCodeAttributes = $attributes;
        }
        return $this;
    }
    /**
     * This information element helps the Seller to assign an incoming payment to the relevant payment process. 
     * Example value: 432948234234234
     */
    public function getPaymentId(): ?string {
        return $this->paymentId;
    }

    /**
     * Set payment id
     */
    public function setPaymentId(?string $paymentId): PaymentMeans {
        $this->paymentId = $paymentId;
        return $this;
    }

    /**
     * PAYMENT CARD INFORMATION
     */
    public function getCardAccountHolder(): ?CardAccount {
       return $this->cardAccountHolder;
    }

    /**
     * Set payment card account info
     */
    public function setCardAccountHolder(?CardAccount $cardAccountHolder): PaymentMeans {
        $this->cardAccountHolder = $cardAccountHolder;
        return $this;
    }

    /**
     * CREDIT TRANSFER
     */
    public function getPayeeFinancialAccount(): ?PayeeFinancialAccount
    {
        return $this->payeeFinancialAccount;
    }

    /**
     * Set payee Financial Account
     */
    public function setPayeeFinancialAccount(?PayeeFinancialAccount $payeeFinancialAccount): PaymentMeans
    {
        $this->payeeFinancialAccount = $payeeFinancialAccount;
        return $this;
    }

    /**
     * DIRECT DEBIT
     */
    public function getPaymentMandate(): ?PaymentMandate {
        return $this->paymentMandate;
    }

    /**
     * Set direct debit
     */
    public function setPaymentMandate(?PaymentMandate $paymentMandate): PaymentMeans {
        $this->paymentMandate = $paymentMandate;
        return $this;
    }
}