<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class PartyLegalEntity 
{
    
    /**
     * @SerializedName("RegistrationName")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $registrationName;

    /**
     * @SerializedName("CompanyID")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\ID")
     */
    private $companyID;
    
    /**
     * @SerializedName("CompanyLegalForm")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $companyLegalForm;
    
    public function __construct($registrationName = null, $companyID = null, $companyLegalForm = null) {
        $this->registrationName = $registrationName;
        $this->companyID = $companyID;
        $this->companyLegalForm = $companyLegalForm;
        return $this;
    }

    public function setRegistrationName($registrationName) {
        $this->registrationName = $registrationName;
        return $this;
    }

    public function getRegistrationName() {
        return $this->registrationName;
    }

    public function setCompanyID($companyID) {
        $this->companyID = $companyID;
        return $this;
    }

    public function getCompanyID() {
        return $this->companyID;
    }

    public function setCompanyLegalForm($companyLegalForm) {
        $this->companyLegalForm = $companyLegalForm;
        return $this;
    }

    public function getCompanyLegalForm() {
        return $this->companyLegalForm;
    }

}