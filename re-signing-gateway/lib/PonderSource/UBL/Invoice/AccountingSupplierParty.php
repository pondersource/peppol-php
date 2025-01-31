<?php

// SPDX-FileCopyrightText: 2022 Ponder Source
//
// SPDX-License-Identifier: MIT

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class AccountingSupplierParty 
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