<?php


use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class Item implements XmlSerializable {
    private $name;
    private $description;
    private $buyersItemIdentification;
    private $sellersItemIdentification;
    private $classifiedTaxCategory;

    /**
     *  Item name
     */
    public function getItem(): ?string {
        return $this->name;
    }

    /**
     * Set item name
     */
    public function setName(?string $name): Item {
        $this->name = $name;
        return $this;
    }

    /**
     *  Item description
     */
    public function getDescription(): ?string {
        return $this->description;
    }
    
    /**
     * Set description
     */
    public function setDescription(?string $description): Item {
        $this->description = $description;
        return $this;
    }

    /**
     * get byer item identification
     */
    public function getBuyersItemIdentification(): ?string {
        return $this->buyersItemIdentification;
    }

     /**
     * set byer item identification
     */
    public function setBuyersItemIdentification(?string $buyersItemIdentification): Item {
        return $this->buyersItemIdentification;
    }

     /**
     * get sellers item identification
     */
    public function getSellersItemIdentification(): ?string {
        return $this->sellersItemIdentification;
    }

     /**
     * set sellers item identification
     */
    public function setSellersItemIdentification(?string $sellersItemIdentification): Item {
        $this->sellersItemIdentification = $sellersItemIdentification;
        return $this;
    }

    /**
     * Classified Tax Category get 
     */
    public function getClassifiedTaxCategory(): ?ClassifiedTaxCategory {
        return $this->classifiedTaxCategory;
    }

    /**
     * Set classified tax category
     */
    public function setClassifiedTaxCategory(?ClassifiedTaxCategory $classifiedTaxCategory): Item {
        $this->classifiedTaxCategory = $classifiedTaxCategory;
        return $this;
    }

    /**
     * Item Serialization
     */
    public function xmlSerialize(Writer $writer) {
        $writer->write([
            Schema::CBC . 'Description' => $this->description,
            Schema::CBC . 'Name' => $this->name
        ]);

        if(!empty($this->getBuyersItemIdentification)) {
            $writer->write([
                Schema::CAC . 'BuyersItemIdentification' => [
                    Schema::CBC . 'ID' => $this->buyersItemIdentification
                ]
           ]);
        }

        if(!empty($this->getSellersItemIdentification())) {
            $writer->write([
                Schema::CAC . 'SellersItemIdentification' => [
                    Schema::CBC . 'ID' => $this->sellersItemIdentification
                ]
           ]);
        }
        if(!empty($this->getClassifiedTaxCategory())) {
            $writer->write([
                Schema::CAC . 'ClassifiedTaxCategory' => $this->getClassifiedTaxCategory()
           ]);
        }
    }
}