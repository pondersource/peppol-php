<?php

namespace OCA\PeppolNext\PonderSource\SMP;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlValue,XmlElement};

/**
 * @XmlNamespace(uri=Namespaces::SMP, prefix="smp")
 */
class ServiceMetadataReference 
{
    /**
     * @XmlAttribute
     * @SerializedName("href")
     * @Type("string")
     */
    private $href;

    public function __construct($href = null){
        $this->href = $href;
        return $this;
    }
    
    public function setHref($href) {
        $this->href = $href;
        return $this;
    }

    public function getHref() {
        return $this->href;
    }

}