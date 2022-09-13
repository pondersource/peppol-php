<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class AdditionalDocumentReference 
{
    
    /**
     * @SerializedName("ID")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\ID")
     */
    private $id;
    
    /**
     * @SerializedName("DocumentTypeCode")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $documentTypeCode = 130;
    
    /**
     * @SerializedName("DocumentDescription")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $documentDescription;

    /**
     * @SerializedName("Attachment")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\Attachment")
     */
    private $attachment;
    
    public function __construct($id = null, $documentDescription = null, $attachment = null) {
        $this->id = $id;
        $this->documentDescription = $documentDescription;
        $this->attachment = $attachment;
        return $this;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setDocumentTypeCode($documentTypeCode) {
        $this->documentTypeCode = $documentTypeCode;
        return $this;
    }

    public function getDocumentTypeCode() {
        return $this->documentTypeCode;
    }

    public function setDocumentDescription($documentDescription) {
        $this->documentDescription = $documentDescription;
        return $this;
    }

    public function getDocumentDescription() {
        return $this->documentDescription;
    }

    public function setAttachment($attachment) {
        $this->attachment = $attachment;
        return $this;
    }

    public function getAttachment() {
        return $this->attachment;
    }

}