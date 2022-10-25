<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlValue,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class EmbeddedDocumentBinaryObject 
{
    
    /**
     * @SerializedName("mimeCode")
     * @XmlAttribute
     * @Type("string")
     */
    private $mimeCode;
    
    /**
     * @SerializedName("filename")
     * @XmlAttribute
     * @Type("string")
     */
    private $fileName;

    /**
     * @XmlValue(cdata=false)
     * @Type("string")
     */
    private $value;
    
    public function __construct($mimeCode = null, $fileName = null, $value = null) {
        $this->mimeCode = $mimeCode;
        $this->fileName = $fileName;
        $this->value = $value;
        return $this;
    }

    public function setMimeCode($mimeCode) {
        $this->mimeCode = $mimeCode;
        return $this;
    }

    public function getMimeCode() {
        return $this->mimeCode;
    }

    public function setFileName($fileName) {
        $this->fileName = $fileName;
        return $this;
    }

    public function getFileName() {
        return $this->fileName;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function getValue() {
        return $this->value;
    }

}