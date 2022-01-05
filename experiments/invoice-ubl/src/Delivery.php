<?php

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

use DateTime as DateTime;

class Delivery implements XmlSerializable {
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

    /**
     * Serialize Delivery
     */
    public function xmlSerialize(Writer $writer) {
        if($this->actualDeliveryDate !== null) {
            $writer->write([
                Schema::CBC . 'ActualDeliveryDate' => $this->actualDeliveryDate->format('Y-m-d')
            ]);
        }
        if($this->deliveryLocation !== null) {
            $writer->write([
                Schema::CAC . 'DeliveryLocation' => [ Schema::CAC . 'Address' => $this->deliveryLocation ]
            ]);
        }

        if($this->deliveryParty !== null) {
            $writer->write([
                Schema::CAC . 'DeliveryParty' => $this->deliveryParty
            ]);
        }
    }
}