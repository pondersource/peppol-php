<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class Item 
{
    
    /**
     * @SerializedName("Description")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $description;

    /**
     * @SerializedName("Name")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $name;

    /**
     * @SerializedName("BuyersItemIdentification")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\BuyersItemIdentification")
     */
    private $buyersItemIdentification;

    /**
     * @SerializedName("SellersItemIdentification")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\SellersItemIdentification")
     */
    private $sellersItemIdentification;

    /**
     * @SerializedName("StandardItemIdentification")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\StandardItemIdentification")
     */
    private $standardItemIdentification;

    /**
     * @SerializedName("OriginCountry")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\OriginCountry")
     */
    private $originCountry;

    /**
     * @XmlList(inline=true, entry="CommodityClassification", namespace=Namespaces::CAC)
     * @Type("array<OCA\PeppolNext\PonderSource\UBL\Invoice\CommodityClassification>")
     */
    private $commodityClassifications;

    /**
     * @SerializedName("ClassifiedTaxCategory")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\ClassifiedTaxCategory")
     */
    private $classifiedTaxCategory;

    /**
     * @XmlList(inline=true, entry="AdditionalItemProperty", namespace=Namespaces::CAC)
     * @Type("array<OCA\PeppolNext\PonderSource\UBL\Invoice\AdditionalItemProperty>")
     */
    private $additionalItemProperties = [];
    
    public function __construct($description = null, $name = null, $buyersItemIdentification = null, $sellersItemIdentification = null, $standardItemIdentification = null, $originCountry = null, $commodityClassifications = [], $classifiedTaxCategory = null, $additionalItemProperties = []) {
        $this->description = $description;
        $this->name = $name;
        $this->buyersItemIdentification = $buyersItemIdentification;
        $this->sellersItemIdentification = $sellersItemIdentification;
        $this->standardItemIdentification = $standardItemIdentification;
        $this->originCountry = $originCountry;
        $this->commodityClassifications = $commodityClassifications;
        $this->classifiedTaxCategory = $classifiedTaxCategory;
        $this->additionalItemProperties = $additionalItemProperties;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setBuyersItemIdentification($buyersItemIdentification) {
        $this->buyersItemIdentification = $buyersItemIdentification;
        return $this;
    }

    public function getBuyersItemIdentification() {
        return $this->buyersItemIdentification;
    }

    public function setSellersItemIdentification($sellersItemIdentification) {
        $this->sellersItemIdentification = $sellersItemIdentification;
        return $this;
    }

    public function getSellersItemIdentification() {
        return $this->sellersItemIdentification;
    }

    public function setStandardItemIdentification($standardItemIdentification) {
        $this->standardItemIdentification = $standardItemIdentification;
        return $this;
    }

    public function getStandardItemIdentification() {
        return $this->standardItemIdentification;
    }

    public function setOriginCountry($originCountry) {
        $this->originCountry = $originCountry;
        return $this;
    }

    public function getOriginCountry() {
        return $this->originCountry;
    }

    public function setCommodityClassifications($commodityClassifications) {
        $this->commodityClassifications = $commodityClassifications;
        return $this;
    }

    public function getCommodityClassifications() {
        return $this->commodityClassifications;
    }

    public function setClassifiedTaxCategory($classifiedTaxCategory) {
        $this->classifiedTaxCategory = $classifiedTaxCategory;
        return $this;
    }

    public function getClassifiedTaxCategory() {
        return $this->classifiedTaxCategory;
    }

    public function setAdditionalItemProperties($additionalItemProperties) {
        $this->additionalItemProperties = $additionalItemProperties;
        return $this;
    }

    public function getAdditionalItemProperties() {
        return $this->additionalItemProperties;
    }

    public function addAdditionalItemProperty($additionalItemProperty) {
        $this->additionalItemProperties[] = $additionalItemProperty;
        return $this;
    }

}