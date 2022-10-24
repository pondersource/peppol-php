<?php

namespace OCA\PeppolNext\PonderSource\UBL\Invoice;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement,XmlList};

/**
 * @XmlNamespace(uri=Namespaces::CBC, prefix="cbc")
 * @XmlNamespace(uri=Namespaces::CAC, prefix="cac")
 */
class InvoiceDocumentReference 
{
    
    /**
     * @SerializedName("ID")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("string")
     */
    private $id;
    
    /**
     * @SerializedName("IssueDate")
     * @XmlElement(cdata=false,namespace=Namespaces::CBC)
     * @Type("DateTime<'Y-m-d'>")
     */
    private $issueDate;
    
    public function __construct($id = null, $issueDate = null) {
        $this->id = $id;
        $this->issueDate = $issueDate;
        return $this;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setIssueDate($issueDate) {
        $this->issueDate = $issueDate;
        return $this;
    }

    public function getIssueDate() {
        return $this->issueDate;
    }

}