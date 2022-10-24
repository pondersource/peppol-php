<?php

namespace OCA\PeppolNext\PonderSource\WSSec;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{XmlElement,XmlRoot,XmlNamespace,XmlAttribute,SerializedName,Type};

/**
 * @XmlNamespace(uri=Namespaces::XENC, prefix="xenc")
 * @XmlNamespace(uri=Namespaces::DS, prefix="ds")
 * @XmlRoot("xenc:EncryptedData")
 */
class EncryptedData {
    /**
     * @Type("string")
     * @XmlAttribute
     * @SerializedName("Id")
     */
    private $id;
    /**
     * @Type("string")
     * @XmlAttribute
     * @SerializedName("MimeType")
     */
    private $mimeType;
    /**
     * @Type("string")
     * @XmlAttribute
     * @SerializedName("Type")
     */
    private $type;
    /**
     * @Type("OCA\PeppolNext\PonderSource\WSSec\EncryptionMethod\AES128GCM")
     * @SerializedName("EncryptionMethod")
     * @XmlElement(namespace=Namespaces::XENC)
     */
    private $encryptionMethod;
    /**
     * @Type("OCA\PeppolNext\PonderSource\WSSec\KeyInfo")
     * @SerializedName("KeyInfo")
     * @XmlElement(namespace=Namespaces::DS)
     */
    private $keyInfo;
    /**
     * @Type("OCA\PeppolNext\PonderSource\WSSec\CipherData")
     * @SerializedName("CipherData")
     * @XmlElement(namespace=Namespaces::XENC)
     */
    private $cipherData;

    public function __construct($id=null, $mimeType=null, $dataType=null, $encryptionMethod=null, $keyInfo=null, $cipherData=null){
        $this->id = $id;
        $this->mimeType = $mimeType;
        $this->type = $dataType;
        $this->encryptionMethod = $encryptionMethod;
        $this->keyInfo = $keyInfo;
        $this->cipherData = $cipherData;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getMimeType() {
        return $this->mimeType;
    }

    public function setMimeType($mimeType) {
        $this->mimeType = $mimeType;
        return $this;
    }

    public function getDataType(){
        return $this->dataType;
    }

    public function setDataType($dataType){
        $this->dataType = $dataType;
        return $this;
    }

    public function getEncryptionMethod(){
        return $this->encryptionMethod;
    }

    public function setEncryptionMethod($encryptionMethod){
        $this->encryptionMethod = $encryptionMethod;
        return $this;
    }

    public function getKeyInfo(){
        return $this->keyInfo;
    }

    public function setKeyInfo($keyInfo){
        $this->keyInfo = $keyInfo;
        return $this;
    }

    public function getCipherData(){
        return $this->cipherData;
    }

    public function setCipherData($cipherData){
        $this->cipherData = $cipherData;
        return $this;
    }
}