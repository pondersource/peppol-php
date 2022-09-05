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
     * @XmlElement()
     * @Type("OCA\PeppolNext\PonderSource\SBD\StandardBusinessDocumentHeader")
     */
    private $header;

    /**
     * @SerializedName("Any")
     * @XmlElement()
     * @Type("OCA\PeppolNext\PonderSource\SBD\Any")
     */
    private $any;

    public function __construct($header = null){
        $this->header = $header;
        $this->any = new Any();
        return $this;
    }

    public function setHeader($header){
        $this->header = $header;
        return $this;
    }

    public function getHeader(){
        return $this->header;
    }
}