<?php

namespace OCA\PeppolNext\PonderSource\SMP;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlList,XmlElement};

/**
 * @XmlNamespace(uri=Namespaces::SMP, prefix="smp")
 * @XmlNamespace(uri=Namespaces::ID, prefix="id")
 */
class ServiceInformation 
{

    /**
     * @SerializedName("ParticipantIdentifier")
     * @XmlElement(namespace=Namespaces::ID)
     * @Type("OCA\PeppolNext\PonderSource\SMP\ParticipantIdentifier")
     */
    private $participantIdentifier;

    /**
     * @SerializedName("DocumentIdentifier")
     * @XmlElement(namespace=Namespaces::ID)
     * @Type("OCA\PeppolNext\PonderSource\SMP\DocumentIdentifier")
     */
    private $documentIdentifier;

    /**
     * @SerializedName("ProcessList")
     * @XmlList(inline=false, entry="Process", namespace=Namespaces::SMP)
     * @Type("array<OCA\PeppolNext\PonderSource\SMP\Process>")
     * @XmlElement(namespace=Namespaces::SMP)
     */
    private $processList = [];

    public function __construct($participantIdentifier = null, $documentIdentifier = null, $processList = []){
        $this->participantIdentifier = $participantIdentifier;
        $this->documentIdentifier = $documentIdentifier;
        $this->processList = $processList;
        return $this;
    }
    
    public function setParticipantIdentifier($participantIdentifier) {
        $this->participantIdentifier = $participantIdentifier;
        return $this;
    }

    public function getParticipantIdentifier() {
        return $this->participantIdentifier;
    }

    public function setDocumentIdentifier($documentIdentifier) {
        $this->documentIdentifier = $documentIdentifier;
        return $this;
    }

    public function getDocumentIdentifier() {
        return $this->documentIdentifier;
    }

    public function addProcess($process) {
        array_push($this->processList, $process);
        return $this;
    }

    public function removeProcess($process) {
        array_filter($this->processList, function($t) { return $t != $process; });
        return $this;
    }

    public function getProcessList() {
        return $this->processList;
    }

}