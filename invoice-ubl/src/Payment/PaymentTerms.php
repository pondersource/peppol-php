<?php

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class PaymentTerms implements XmlSerializable {
    private $note;

    /**
     *  Payment terms
     */
    public function getNote(): ?string {
        return $this->note;
    }

    /**
     * set note
     */
    public function setNote(?string $note): PaymentTerms {
        $this->note = $note;
        return $this;
    }
    /**
     * Serialize Payment Terms
     */
    public function xmlSerialize(Writer $writer)
    {
        if ($this->note !== null) {
            $writer->write([ Schema::CBC . 'Note' => $this->note ]);
        }
    }
}