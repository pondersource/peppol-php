<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class PostalAddress 
{
    
    /**
     * @SerializedName("StreetName")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $streetName;
    
    /**
     * @SerializedName("AdditionalStreetName")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $additionalStreetName;
    
    /**
     * @SerializedName("CityName")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $cityName;
    
    /**
     * @SerializedName("PostalZone")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $postalZone;
    
    /**
     * @SerializedName("CountrySubentity")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $countrySubentity;

    /**
     * @SerializedName("AddressLine")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\AddressLine")
     */
    private $addressLine;

    /**
     * @SerializedName("Country")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\Country")
     */
    private $country;
    
    public function __construct($streetName = null, $additionalStreetName = null, $cityName = null, $postalZone = null, $countrySubentity = null, $addressLine = null, $country = null) {
        $this->streetName = $streetName;
        $this->additionalStreetName = $additionalStreetName;
        $this->cityName = $cityName;
        $this->postalZone = $postalZone;
        $this->countrySubentity = $countrySubentity;
        $this->addressLine = $addressLine;
        $this->country = $country;
        return $this;
    }

    public function setStreetName($streetName) {
        $this->streetName = $streetName;
        return $this;
    }

    public function getStreetName() {
        return $this->streetName;
    }

    public function setAdditionalStreetName($additionalStreetName) {
        $this->additionalStreetName = $additionalStreetName;
        return $this;
    }

    public function getAdditionalStreetName() {
        return $this->additionalStreetName;
    }

    public function setCityName($cityName) {
        $this->cityName = $cityName;
        return $this;
    }

    public function getCityName() {
        return $this->cityName;
    }

    public function setPostalZone($postalZone) {
        $this->postalZone = $postalZone;
        return $this;
    }

    public function getPostalZone() {
        return $this->postalZone;
    }

    public function setCountrySubentity($countrySubentity) {
        $this->countrySubentity = $countrySubentity;
        return $this;
    }

    public function getCountrySubentity() {
        return $this->countrySubentity;
    }

    public function setAddressLine($addressLine) {
        $this->addressLine = $addressLine;
        return $this;
    }

    public function getAddressLine() {
        return $this->addressLine;
    }

    public function setCountry($country) {
        $this->country = $country;
        return $this;
    }

    public function getCountry() {
        return $this->country;
    }

}