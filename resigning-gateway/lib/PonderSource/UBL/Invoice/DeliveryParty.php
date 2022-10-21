<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class DeliveryParty 
{

    /**
     * @SerializedName("PartyName")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\PartyName")
     */
    private $partyName;
    
    public function __construct($partyName = null) {
        $this->partyName = $partyName;
        return $this;
    }

    public function setPartyName($partyName) {
        $this->partyName = $partyName;
        return $this;
    }

    public function getPartyName() {
        return $this->partyName;
    }

}