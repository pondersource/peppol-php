<?php

namespace OCA\PeppolNext\PonderSource\SMP;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlList,XmlNamespace,SerializedName,XmlRoot,XmlElement};

/**
 * @XmlNamespace(uri=Namespaces::SMP, prefix="smp")
 * @XmlNamespace(uri=Namespaces::ID, prefix="id")
 * @XmlRoot("smp:ServiceGroup")
 */
class ServiceGroup
{

    /**
     * @SerializedName("ParticipantIdentifier")
     * @XmlElement(namespace=Namespaces::ID)
     * @Type("OCA\PeppolNext\PonderSource\SMP\ParticipantIdentifier")
     */
    private $participantIdentifier;

    /**
     * @SerializedName("ServiceMetadataReferenceCollection")
     * @XmlList(inline=false, entry="Endpoint", namespace=Namespaces::SMP)
     * @Type("array<OCA\PeppolNext\PonderSource\SMP\ServiceMetadataReference>")
     * @XmlElement(namespace=Namespaces::SMP)
     */
    private $serviceMetadataReferenceCollection = [];

    public function __construct($participantIdentifier = null, $serviceMetadataReferenceCollection = []){
        $this->participantIdentifier = $participantIdentifier;
        $this->serviceMetadataReferenceCollection = $serviceMetadataReferenceCollection;
        return $this;
    }
    
    public function setParticipantIdentifier($participantIdentifier) {
        $this->participantIdentifier = $participantIdentifier;
        return $this;
    }

    public function getParticipantIdentifier() {
        return $this->participantIdentifier;
    }

    public function addServiceMetadataReference($serviceMetadataReference) {
        array_push($this->serviceMetadataReferenceCollection, $serviceMetadataReference);
        return $this;
    }

    public function removeServiceMetadataReference($serviceMetadataReference) {
        array_filter($this->serviceMetadataReferenceCollection, function($t) { return $t != $serviceMetadataReference; });
        return $this;
    }

    public function getServiceMetadataReferenceCollection() {
        return $this->serviceMetadataReferenceCollection;
    }

}