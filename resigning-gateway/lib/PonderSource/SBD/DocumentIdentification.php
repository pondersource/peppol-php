<?php

namespace OCA\PeppolNext\PonderSource\SBD;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement};
use OCA\PeppolNext\PonderSource\SBD\Any;

/**
 */
class DocumentIdentification 
{

    /**
     * @SerializedName("Standard")
     * @XmlElement(namespace=Namespaces::SBD)
     * @Type("string")
     */
    private $standard;

    /**
     * @SerializedName("TypeVersion")
     * @XmlElement(namespace=Namespaces::SBD)
     * @Type("string")
     */
    private $typeVersion;

    /**
     * @SerializedName("InstanceIdentifier")
     * @XmlElement(namespace=Namespaces::SBD)
     * @Type("string")
     */
    private $instanceIdentifier;

    /**
     * @SerializedName("Type")
     * @XmlElement(namespace=Namespaces::SBD)
     * @Type("string")
     */
    private $type; 

    /**
     * @SerializedName("CreationDateAndTime")
     * @XmlElement(cdata=false, namespace=Namespaces::SBD)
     * @Type("DateTime<'Y-m-d\TH:i:s.vP'>")
     */
    private $creationDateAndTime;

    public function __construct($standard = null, $typeVersion = null, $instanceIdentifier = null, $type = null, $creationDateAndTime = null){
        $this->standard = $standard;
        $this->typeVersion = $typeVersion;
        $this->instanceIdentifier = $instanceIdentifier;
        $this->type = $type;
        $this->creationDateAndTime = $creationDateAndTime;
        return $this;
    }
    
    public function setStandard($standard) {
        $this->standard = $standard;
        return $this;
    }

    public function getStandard() {
        return $this->standard;
    }

    public function setTypeVersion($typeVersion) {
        $this->typeVersion = $typeVersion;
        return $this;
    }

    public function getTypeVersion() {
        return $this->typeVersion;
    }

    public function setInstanceIdentifier($instanceIdentifier) {
        $this->instanceIdentifier = $instanceIdentifier;
        return $this;
    }

    public function getInstanceIdentifier() {
        return $this->instanceIdentifier;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function getType() {
        return $this->type;
    }

    public function setCreationDateAndTime($creationDateAndTime) {
        $this->creationDateAndTime = $creationDateAndTime;
        return $this;
    }

    public function getCreationDateAndTime() {
        return $this->creationDateAndTime;
    }

}