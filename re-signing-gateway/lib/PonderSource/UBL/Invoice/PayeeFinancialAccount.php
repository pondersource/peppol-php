<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class PayeeFinancialAccount 
{
    
    /**
     * @SerializedName("ID")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $id;
    
    /**
     * @SerializedName("Name")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $name;

    /**
     * @SerializedName("FinancialInstitutionBranch")
     * @XmlElement(cdata=false,namespace=Namespaces::CAC)
     * @Type("OCA\PeppolNext\PonderSource\UBL\Invoice\FinancialInstitutionBranch")
     */
    private $financialInstitutionBranch;
    
    public function __construct($id = null, $name = null, $financialInstitutionBranch = null) {
        $this->id = $id;
        $this->name = $name;
        $this->financialInstitutionBranch = $financialInstitutionBranch;
        return $this;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setFinancialInstitutionBranch($financialInstitutionBranch) {
        $this->financialInstitutionBranch = $financialInstitutionBranch;
        return $this;
    }

    public function getFinancialInstitutionBranch() {
        return $this->financialInstitutionBranch;
    }

}