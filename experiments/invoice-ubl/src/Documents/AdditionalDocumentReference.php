<?php

class AdditionalDocumentReference {
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

}