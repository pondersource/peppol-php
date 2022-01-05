<?php

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class Country implements XmlSerializable {
    private $identificationCode;

    /**
     * Get Country Code
     */
    public function getIdentificationCode(): ?string {
        return $this->identificationCode;
    }

    /**
     * Set Country Code
     */
    public function setIdentificationCode(?string $identificationCode): Country {
        $this->identificationCode = $identificationCode;
        return $this;
    }

    /**
     * XML Serialize for Country
     */
    public function xmlSerialize(Writer $writer) {
        $writer->write([
            Schema::CBC . 'IdentificationCode' => $this->identificationCode
        ]);
    }
}