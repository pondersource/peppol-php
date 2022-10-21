<?php

namespace OCA\PeppolNext\PonderSource\SBD;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement};
use OCA\PeppolNext\PonderSource\SBD\Any;

/**
 * @XmlNamespace(uri=Namespaces::SBD)
 * @XmlNamespace(uri=Namespaces::XS, prefix="xs")
 * @XmlRoot("StandardBusinessDocument")
 */
class StandardBusinessDocument
{
    /**
     * @SerializedName("StandardBusinessDocumentHeader")
     * @XmlElement(namespace=Namespaces::SBD)
     * @Type("OCA\PeppolNext\PonderSource\SBD\StandardBusinessDocumentHeader")
     */
    private $header;

    /**
     * @SerializedName("Invoice")
     * @XmlElement(namespace=Namespaces::UBL)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\Invoice")
     */
    private $invoice;

    /**
     * SerializedName("Any")
     * XmlElement()
     * Type("OCA\PeppolNext\PonderSource\SBD\Any")
     */
    private $any;

    public function __construct($header = null, $invoice = null, $any = null){
        $this->header = $header;
        $this->invoice = $invoice;
        $this->any = $any;
        return $this;
    }

    public function setHeader($header){
        $this->header = $header;
        return $this;
    }

    public function getHeader(){
        return $this->header;
    }

    public function setInvoice($invoice){
        $this->invoice = $invoice;
        return $this;
    }

    public function getInvoice(){
        return $this->invoice;
    }

}