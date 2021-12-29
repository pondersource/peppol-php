<?php

class Item {
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
        return $this->sellersItemIdentification;
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
}