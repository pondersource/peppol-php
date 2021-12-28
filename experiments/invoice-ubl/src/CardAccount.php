<?php

class CardAccount {
    private $primaryAccountNumberID;
    private $networkID;
    private $holderName;

    /**
     * Payment card primary account number
     * Example value: 1234
     */
    public function getPrimaryAccountNumberId(): ?string {
        return $this->primaryAccountNumberID;
    }

    /**
     * Set network ID
     */
    public function setPrimaryAccountNumberId(?string $primaryAccountNumberID): CardAccount {
        $this->primaryAccountNumberID = $primaryAccountNumberID;
        return $this;
    }

    /**
     * Syntax required element not related to a business term. 
     * Example value: NA 
     */
    public function getNetworkId(): ?string {
        return $this->networkID;
    }

    /**
     * Set network ID
     */
    public function setNetworkId(?string $networkID): CardAccount {
        $this->networkID = $networkID;
        return $this;
    }
}