<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class AccountingCustomerParty 
{

    /**
     * @SerializedName("Party")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\Party")
     */
    private $party;
    
    public function __construct($party = null) {
        $this->party = $party;
        return $this;
    }

    public function setParty($party) {
        $this->party = $party;
        return $this;
    }

    public function getParty() {
        return $this->party;
    }

}