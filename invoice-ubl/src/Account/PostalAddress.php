<?php

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

require 'Schema.php';

class PostalAddress implements XmlSerializable {
    private $streetName;
    private $additionalStreetName;
    private $cityName;
    private $postalZone;
    private $country;
    private $buildingNumber;

     /**
     * get Building Name
     */
    public function getBuildingNumber(): ?string
    {
        return $this->buildingNumber;
    }

    /**
     * Set Building Name
     */
    public function setBuildingNumber(?string $buildingNumber): PostalAddress
    {
        $this->buildingNumber = $buildingNumber;
        return $this;
    }

    /**
     * Get street name
     */
    public function getStreetName(): ?string  {
        return $this->streetName;
    }

    /**
     * Set street Name
     */
    public function setStreetName(?string $streetName): PostalAddress {
        $this->streetName = $streetName; 
        return $this;
    }

    /**
     * Get Additional Street Name
     */
    public function getAdditonalStreetName(): ?string {
        return $this->additionalStreetName;
    }

    /**
     * Set addional street name
     */
    public function setAddionalStreetName(?string $additionalStreetName): PostalAddress {
        $this->additionalStreetName = $additionalStreetName;
        return $this;
    }

    /**
     * get city name
     */
    public function getCityName(): ?string {
        return $this->cityName;
    }

    /**
     * Set City Name
     */
    public function setCityName(?string $cityName): PostalAddress {
       $this->cityName = $cityName;
       return $this;
    }

    /**
     * Get postal zone
     */
    public function getPostalZone(): ?string {
        return $this->postalZone;
    }

    /**
     * Set postal zone
     */
    public function setPostalZone(?string $postalZone): PostalAddress {
        $this->postalZone = $postalZone;
        return $this;
    }

    /**
     * @return Country
     */
    public function getCountry(): ?Country {
      return $this->country;
    }

    /**
     * Set Country 
     */
    public function setCountry(Country $country): PostalAddress {
        $this->country = $country;
        return $this;
    }

    /**
     * Serialize XML for PostalAddress
     */
    public function xmlSerialize(Writer $writer)
    {
        if ($this->streetName !== null) {
            $writer->write([
                Schema::CBC . 'StreetName' => $this->streetName
            ]);
        }
        if ($this->additionalStreetName !== null) {
            $writer->write([
                Schema::CBC . 'AdditionalStreetName' => $this->additionalStreetName
            ]);
        }
        if ($this->buildingNumber !== null) {
            $writer->write([
                Schema::CBC . 'BuildingNumber' => $this->buildingNumber
            ]);
        }
        if ($this->cityName !== null) {
            $writer->write([
                Schema::CBC . 'CityName' => $this->cityName,
            ]);
        }
        if ($this->postalZone !== null) {
            $writer->write([
                Schema::CBC . 'PostalZone' => $this->postalZone,
            ]);
        }
        if ($this->country !== null) {
            $writer->write([
                Schema::CAC . 'Country' => $this->country,
            ]);
        }
    }
}
