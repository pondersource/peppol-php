<?php

class FinancialInstitutionBranch {
    private $id;

    /**
     * Payment service provider identifier
     *  Example value: 9999
     */
    public function getId(): ?string {
       return $this->id;
    }

    /**
     * Set provider identifier
     */
    public function setId(?string $id): FinancialInstitutionBranch {
        $this->id = $id;
        return $this;
    }
}