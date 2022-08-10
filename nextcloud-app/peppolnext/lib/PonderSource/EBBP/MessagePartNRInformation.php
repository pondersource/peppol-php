<?php

namespace OCA\PeppolNext\PonderSource\EBBP;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{XmlRoot,XmlElement,XmlNamespace,Type,SerializedName,XmlList};
use OCA\PeppolNext\PonderSource\WSSec\CanonicalizationMethod\C14NExclusive;

/**
 * @XmlNamespace(uri=Namespaces::EBBP, prefix="ebbp")
 * @XmlRoot("ebbp:MessagePartNRInformation")
 */
class MessagePartNRInformation {

    /**
     * @XmlList(inline=true, entry="Reference", namespace=Namespaces::DS)
     * @Type("array<OCA\PeppolNext\PonderSource\WSSec\DSigReference>")
     */
    private $references = [];

    public function __construct(){
        return $this;
    }

    public function addReference($reference){
        array_push($this->references, $reference);
        return $this;
    }

    public function removeReference($reference){
        array_filter($this->references, function($r) use($reference) { return $r != $reference; });
    }

    public function getReferences(){
        return $this->references;
    }
    
}