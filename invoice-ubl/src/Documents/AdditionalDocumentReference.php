<?php

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class AdditionalDocumentReference implements XmlSerializable {
    private $id;
    private $documentTypeCode;
    private $documentDescription;
    private $attachment;

    /**
     * Get document Id
     */
    public function getId(): ?string {
        return $this->getId;
    }

    /**
     * Set document Id
     */
    public function setId(?string $id): AdditionalDocumentReference {
        return $this->id;
    }

    /**
     * Get Document Type code
     */
    public function getDocumentTypeCode(): ?string {
        return $this->documentTypeCode;
    }

    /**
     * Set Document Type Code
     */
    public function setDocumentTypeCode(?string $documentTypeCode): AdditionalDocumentReference {
        $this->documentTypeCode = $documentTypeCode;
        return $this;
    }

    /**
     * Get document description
     */
    public function getDocumentDescription(): ?string {
        return $this->documentDescription;
    }

    /**
     * Set document Description
     */
    public function setDocumentDescription(?string $documentDescription): AdditionalDocumentReference {
        $this->documentDescription = $documentDescription;
        return $this;
    }

    /**
     * Get attachment
     */
    public function getAttachMent(): ?Attachment {
        return $this->attachment;
    }

    /**
     * Set attachment
     */
    public function setAttachMent(Attachment $attachment): AdditionalDocumentReference {
        $this->attachment = $attachment;
    }

    /**
     * Serialize Document Referece 
     */
    public function xmlSerialize(Writer $writer) {
        $writer->write([ Schema::CBC . 'ID' => $this->id ]);
        if($this->documentTypeCode !== null) {
            $writer->write([ Schema::CBC . 'DocumentTypeCode' => $this->documentTypeCode ]);
        }

        if($this->documentDescription !== null) {
            $writer->write([ Schema::CBC . 'DocumentDescription' => $this->documentDescription ]);
        }
        $writer->write([ Schema::CAC . 'Attachment' => $this->attachment ]);
    }

}