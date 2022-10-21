<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class PaymentTerms 
{
    
    /**
     * @SerializedName("Note")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $note;
    
    public function __construct($note = null) {
        $this->note = $note;
        return $this;
    }

    public function setNote($note) {
        $this->note = $note;
        return $this;
    }

    public function getNote() {
        return $this->note;
    }

}