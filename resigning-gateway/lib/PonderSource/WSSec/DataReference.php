<?php

namespace OCA\PeppolNext\PonderSource\WSSec;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{XmlRoot,Type,XmlNamespace,XmlAttribute,SerializedName};

/**
 * @XmlNamespace(uri=Namespaces::XENC, prefix="xenc")
 * @XmlRoot("xenc:DataReference")
 */
class DataReference {
    /**
     * @XmlAttribute
     * @SerializedName("URI")
     * @Type("string")
     */
    private $uri;

    public function __construct($uri){
        $this->uri = $uri;
        return $this;
    }
}