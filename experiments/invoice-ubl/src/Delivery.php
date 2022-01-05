<?php

class Delivery {
    private $actualDeliveryDate;
    private $deliveryLocation;
    private $deliveryParty;

    /**
     * get actual delivery party
     */
    public function getActualDeliveryDate() {
        return $this->actualDeliveryDate;
    }

    /**
     * Set actual delivery date
     */
    public function setActualDeliveryDate($actualDeliveryDate): Delivery
    {
        $this->actualDeliveryDate = $actualDeliveryDate;
        return $this;
    }

    /**
     * get Delivery Location
     */
    public function getDeliveryLocation() {
        return $this->deliveryLocation;
    }

    /**
     * Set delivery location
     */
    public function setDeliveryLocation($deliveryLocation): Delivery {
        $this->deliveryLocation = $deliveryLocation;
        return $this;
    }

    /**
     * get Delivery Party
     */
    public function getDeliveryParty() {
        return $this->deliveryParty;
    }

    /**
     * set delivery party
     */
    public function setDeliveryParty($deliveryParty): Delivery {
        $this->deliveryParty = $deliveryParty;
        return $this;
    } 
}