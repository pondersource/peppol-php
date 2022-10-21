<?php

namespace OCA\PeppolNext\PonderSource\SMP;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement};

/**
 * @XmlNamespace(uri=Namespaces::SMP, prefix="smp")
 * @XmlNamespace(uri=Namespaces::WSA, prefix="wsa")
 */
class Endpoint 
{
    /**
     * @XmlAttribute
     * @SerializedName("transportProfile")
     * @Type("string")
     */
    private $transportProfile;

    /**
     * @SerializedName("EndpointReference")
     * @XmlElement(namespace=Namespaces::WSA)
     * @Type("OCA\PeppolNext\PonderSource\SMP\EndpointReference")
     */
    private $endpointReference;

    /**
     * @SerializedName("RequireBusinessLevelSignature")
     * @XmlElement(cdata=false, namespace=Namespaces::SMP)
     * @Type("string")
     */
    private $requireBusinessLevelSignature;

    /**
     * @SerializedName("Certificate")
     * @XmlElement(cdata=false, namespace=Namespaces::SMP)
     * @Type("string")
     */
    private $certificate;

    /**
     * @SerializedName("ServiceDescription")
     * @XmlElement(cdata=false, namespace=Namespaces::SMP)
     * @Type("string")
     */
    private $serviceDescription;

    /**
     * @SerializedName("TechnicalContactUrl")
     * @XmlElement(cdata=false, namespace=Namespaces::SMP)
     * @Type("string")
     */
    private $technicalContactUrl;

    public function __construct($transportProfile = null, $endpointReference = null, $requireBusinessLevelSignature = null,
            $certificate = null, $serviceDescription = null, $technicalContactUrl = null) {
        $this->transportProfile = $transportProfile;
        $this->endpointReference = $endpointReference;
        $this->requireBusinessLevelSignature = $requireBusinessLevelSignature;
        $this->certificate = $certificate;
        $this->serviceDescription = $serviceDescription;
        $this->technicalContactUrl = $technicalContactUrl;
        return $this;
    }

    public function setTransportProfile($transportProfile) {
        $this->transportProfile = $transportProfile;
        return $this;
    }

    public function getTransportProfile() {
        return $this->transportProfile;
    }

    public function setEndpointReference($endpointReference) {
        $this->endpointReference = $endpointReference;
        return $this;
    }

    public function getEndpointReference() {
        return $this->endpointReference;
    }

    public function setRequireBusinessLevelSignature($requireBusinessLevelSignature) {
        $this->requireBusinessLevelSignature = $requireBusinessLevelSignature;
        return $this;
    }

    public function getRequireBusinessLevelSignature() {
        return $this->requireBusinessLevelSignature;
    }

    public function setCertificate($certificate) {
        $this->certificate = $certificate;
        return $this;
    }

    public function getCertificate() {
        return $this->certificate;
    }

    public function setServiceDescription($serviceDescription) {
        $this->serviceDescription = $serviceDescription;
        return $this;
    }

    public function getServiceDescription() {
        return $this->serviceDescription;
    }

    public function setTechnicalContactUrl($technicalContactUrl) {
        $this->technicalContactUrl = $technicalContactUrl;
        return $this;
    }

    public function getTechnicalContactUrl() {
        return $this->technicalContactUrl;
    }

}