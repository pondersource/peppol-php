<?php

namespace OCA\PeppolNext\PonderSource\SMP;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlList,XmlElement};

/**
 * @XmlNamespace(uri=Namespaces::SMP, prefix="smp")
 * @XmlNamespace(uri=Namespaces::ID, prefix="id")
 */
class Process
{

    /**
     * @SerializedName("ProcessIdentifier")
     * @XmlElement(namespace=Namespaces::ID)
     * @Type("OCA\PeppolNext\PonderSource\SMP\ProcessIdentifier")
     */
    private $processIdentifier;

    /**
     * @SerializedName("ServiceEndpointList")
     * @XmlList(inline=false, entry="Endpoint", namespace=Namespaces::SMP)
     * @Type("array<OCA\PeppolNext\PonderSource\SMP\Endpoint>")
     * @XmlElement(namespace=Namespaces::SMP)
     */
    private $endpointList = [];

    public function __construct($processIdentifier = null, $endpointList = []){
        $this->processIdentifier = $processIdentifier;
        $this->endpointList = $endpointList;
        return $this;
    }
    
    public function setProcessIdentifier($processIdentifier) {
        $this->processIdentifier = $processIdentifier;
        return $this;
    }

    public function getProcessIdentifier() {
        return $this->processIdentifier;
    }

    public function addEndpoint($endpoint) {
        array_push($this->endpointList, $endpoint);
        return $this;
    }

    public function removeEndpoint($endpoint) {
        array_filter($this->endpointList, function($t) { return $t != $endpoint; });
        return $this;
    }

    public function getEndpointList() {
        return $this->endpointList;
    }

}