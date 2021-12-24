<?php

class PostalAddress {
    private $streetName;
    private $additionalStreetName;
    private $cityName;
    private $postalZone;
    private $country;
    private $builderName;

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

}