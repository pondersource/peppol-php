<?php

class Party {
    private $endpointID;
    private $partyIdentification;
    private $partyName;
    private $postalAddress;
    private $physicalLocation;
    private $contact;
    private $partyTaxScheme;
    private $legalEntity;

    /**
     * Seller electronic address
     * Example value: 7300010000001
     */
    public function getEndPointId(): ?string {
        return $this->endpointID;
    }

    /**
     * Set End Point ID
     */
    public function setEndPointId(?string $endpointID): Party {
        $this->endpointID = $endpointID;
        return $this;
    }

    /**
     * Seller identifier or bank assigned creditor identifier
     */
    public function setPartyIdentification(?string $partyIdentification): Party {
        $this->partyIdentification = $partyIdentification;
        return $this;
    }

    /**
     * get Identification Party
     */
    public function getPartyIdentification(): ?string {
        return $this->partyIdentification;
    }

    /**
     * Seller trading name
     */
    public function getPartyName(): ?string {
        return $this->partyName;
    }

    /**
     * Set party Name
     */
    public function setPartyName(?string $partyName): Party {
        $this->partyName = $partyName;
        return $this;
    }

    /**
     * return Postal Address
     */
    public function getPostalAddress(): ?PostalAddress {
        return $this->postalAddress;
    }

    /**
     * set postal address
     */
    public function setPostalAddress(?PostalAddress $postalAddress): Party {
        $this->postalAddress = $postalAddress;
        return $this;
    }

    /**
     * return Address location
     */
    public function getPhysicalLocation(): ?PostalAddress {
        return $this->physicalLocation;
    }

    /**
     * Set Physical Location
     */
    public function setPhysicalLocation(?PostalAddress $physicalLocation): Party {
        $this->physicalLocation = $physicalLocation;
        return $this;
    }

    /**
     * get Contact
     */
    public function getContact(): ?Contact {
        return $this->contact;
    }

    /**
     * Set Contact
     */
    public function setContact(?Contact $contact): Party {
        $this->contact = $contact;
        return $this;
    }

    /**
     * Get Legal Entity
     */
    public function getLegalEntity(): ?LegalEntity {
        return $this->legalEntity;
    }

    /**
     * Set Legal Entity
     */
    public function setLegalEntity(?LegalEntity $legalEntity): Party {
        $this->legalEntity = $legalEntity;
        return $this;
    }
}