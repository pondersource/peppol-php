<?php

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class OrderReference implements XmlSerializable {
    private $id;
    private $salesOrderId;

    /**
     * Purchase order reference
     * Example value: 98776
     */
    public function getId(): ?string {
        return $this->id;
    }

    /**
     * set order id
     */
    public function setId(?string $id): OrderReference {
        $this->id = $id;
        return $this;
    }

    /**
     *  Sales order reference
     *  Example value: 112233 
     */
    public function getSalesOrderId(): ?string {
        return $this->salesOrderId;
    }

    /**
     * Set sales order id
     */
    public function setSalesOrderId(?string $salesOrderId): OrderReference {
        $this->salesOrderId = $salesOrderId;
        return $this;
    }

    /**
     * Serialize OrderReference
     */
    public function xmlSerialize(Writer $writer) {
        if($this->id !== null) {
            $writer->write([
                Schema::CBC . 'ID' => $this->id
            ]);
        }

        if($this->salesOrderId !== null) {
            $writer->write([
                Schema::CBC . 'SalesOrderID' => $this->salesOrderId
            ]);
        }
    }
}