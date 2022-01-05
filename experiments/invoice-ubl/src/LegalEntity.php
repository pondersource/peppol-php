<?php

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class LegalEntity implements XmlSerializable {
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
       $this->registrationName = $registrationName;
       return $this;
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

    /**
     * Serialize Legal Entity
     */
    public function xmlSerialize(Writer $writer) {
        $writer->write([
            Schema::CBC . 'RegistrationName' => $this->registrationName
        ]);

        if($this->companyId !== null) {
            $writer->write([
                'name' => Schema::CBC . 'CompanyID',
                'value' => $this->companyId,
                'attributes' => $this->companyIdAttributes
            ]);
        }
    }
}