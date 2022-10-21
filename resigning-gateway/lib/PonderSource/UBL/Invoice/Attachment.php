<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class Attachment 
{

    /**
     * @SerializedName("ExternalReference")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\EmbeddedDocumentBinaryObject")
     */
    private $embeddedDocumentBinaryObject;

    /**
     * @SerializedName("ExternalReference")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\ExternalReference")
     */
    private $externalReference;
    
    public function __construct($embeddedDocumentBinaryObject = null, $externalReference = null) {
        $this->embeddedDocumentBinaryObject = $embeddedDocumentBinaryObject;
        $this->externalReference = $externalReference;
        return $this;
    }

    public function setEmbeddedDocumentBinaryObject($embeddedDocumentBinaryObject) {
        $this->embeddedDocumentBinaryObject = $embeddedDocumentBinaryObject;
        return $this;
    }

    public function getEmbeddedDocumentBinaryObject() {
        return $this->embeddedDocumentBinaryObject;
    }

    public function setExternalReference($externalReference) {
        $this->externalReference = $externalReference;
        return $this;
    }

    public function getExternalReference() {
        return $this->externalReference;
    }

}