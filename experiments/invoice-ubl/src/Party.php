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
}