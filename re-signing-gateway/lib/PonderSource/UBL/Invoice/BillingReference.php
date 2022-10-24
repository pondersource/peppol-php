<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class BillingReference 
{

    /**
     * @SerializedName("InvoiceDocumentReference")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\InvoiceDocumentReference")
     */
    private $invoiceDocumentReference;
    
    public function __construct($invoiceDocumentReference = null) {
        $this->invoiceDocumentReference = $invoiceDocumentReference;
        return $this;
    }

    public function setInvoiceDocumentReference($invoiceDocumentReference) {
        $this->invoiceDocumentReference = $invoiceDocumentReference;
        return $this;
    }

    public function getInvoiceDocumentReference() {
        return $this->invoiceDocumentReference;
    }

}