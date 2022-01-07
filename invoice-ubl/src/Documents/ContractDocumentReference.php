<?php

class ContractDocumentReference {
    private $id;

    /**
     * Get The identification of a contract.
     * Example value: 123Contractref
     */
    public function getId(): ?string {
        return $this->id;
    }

    /**
     * Set id
     */
    public function setId(?string $id): ContractDocumentReference {
        $this->id = $id;
        return $this;
    }
}