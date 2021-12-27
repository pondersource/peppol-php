<?php

class LegalEntity {
    private $registrationName;
    private $companyId;
    private $companyIdAttributes;
    private $companyLegalForm;

    /**
     * Seller name
     */
    public function getRegistrationNumber(): ?string {
       return $this->registrationName;
    }

    /**
     * Set seller name;
     */
    public function setRegistrationNumber(?string $registrationName): LegalEntity {
       return $this->registrationName;
    }

    /**
     * Seller legal registration identifier
     */
    public function getCompanyId(): ?string {
        return $this->companyId;
    }

    /**
     * set Company ID
     */
    public function setCompanyId(?string $companyId, $attributes = null): LegalEntity {
        $this->companyId = $companyId;
        if(isset($attributes)) {
          $this->$companyIdAttributes = $attributes;
        }
        return $this;
    }

    /**
     * Company form legal
     */
    public function getCompanyLegalForm(): ?string {
        return $this->companyLegalForm;
    }

    /**
     * Set company form legal
     */
    public function setCompanyLegal(?string $companyLegalForm): LegalEntity {
        $this->companyLegalForm = $companyLegalForm;
        return $this;
    }
}