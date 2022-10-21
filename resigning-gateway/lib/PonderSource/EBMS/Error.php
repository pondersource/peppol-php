<?php

namespace OCA\PeppolNext\PonderSource\EBMS;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type, XmlElement, SerializedName, Exclude, XmlAttribute};

class Error {

    /**
     * @XmlAttribute(namespace=Namespaces::EB)
     * @SerializedName("category")
     * @Type("string")
     */
    private $category;

    /**
     * @XmlAttribute(namespace=Namespaces::EB)
     * @SerializedName("errorCode")
     * @Type("string")
     */
    private $errorCode;

    /**
     * @XmlAttribute(namespace=Namespaces::EB)
     * @SerializedName("refToMessageInError")
     * @Type("string")
     */
    private $refToMessageInError;

    /**
     * @XmlAttribute(namespace=Namespaces::EB)
     * @SerializedName("severity")
     * @Type("string")
     */
    private $severity;

    /**
     * @XmlAttribute(namespace=Namespaces::EB)
     * @SerializedName("shortDescription")
     * @Type("string")
     */
    private $shortDescription;

    /**
     * @SerializedName("Description");
     * @XmlElement(cdata=false,namespace=Namespaces::EB);
     * @Type("string")
     */
    private $description;

    /**
     * @SerializedName("ErrorDetail");
     * @XmlElement(cdata=false,namespace=Namespaces::EB);
     * @Type("string")
     */
    private $errorDetail;

    public function __construct($category = null, $errorCode = null, $refToMessageInError = null,
    $severity = null, $shortDescription = null, $description = null, $errorDetail = null) {
        $this->category = $category;
        $this->errorCode = $errorCode;
        $this->refToMessageInError = $refToMessageInError;
        $this->severity = $severity;
        $this->shortDescription = $shortDescription;
        $this->description = $description;
        $this->errorDetail = $errorDetail;

        return $this;
    }

    public function setCategory($category) {
        $this->category = $category;
        return $this;
    }

    public function getCategory() {
        return $this->category;
    }

    public function setErrorCode($errorCode) {
        $this->errorCode = $errorCode;
    }

    public function getErrorCode() {
        return $this->errorCode;
    }

    public function setRefToMessageInError($refToMessageInError) {
        $this->refToMessageInError = $refToMessageInError;
        return $this;
    }

    public function getRefToMessageInError() {
        return $this->refToMessageInError;
    }

    public function setSeverity($severity) {
        $this->severity = $severity;
        return $this;
    }

    public function getSeverity() {
        return $this->severity;
    }

    public function setShortDescription($shortDescription) {
        $this->shortDescription = $shortDescription;
        return $this;
    }

    public function getShortDescription() {
        return $this->shortDescription;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setErrorDetail($errorDetail) {
        $this->errorDetail = $errorDetail;
        return $this;
    }

    public function getErrorDetail() {
        return $this->errorDetail;
    }

}