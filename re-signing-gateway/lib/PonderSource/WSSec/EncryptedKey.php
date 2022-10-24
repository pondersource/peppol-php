<?php

namespace OCA\PeppolNext\PonderSource\WSSec;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlRoot,XmlNamespace,XmlAttribute,SerializedName,XmlList,XmlElement};

/**
 * @XmlNamespace(uri=Namespaces::XENC, prefix="xenc")
 * @XmlNamespace(uri=Namespaces::DS, prefix="ds")
 * @XmlRoot("xenc:EncryptedKey")
 */
class EncryptedKey {
    /**
     * @XmlAttribute
     * @SerializedName("Id")
     * @Type("string")
     */
    private $id;

    /**
     * @SerializedName("EncryptionMethod") 
     * @Type("OCA\PeppolNext\PonderSource\WSSec\EncryptionMethod\RsaOeap")
     * @XmlElement(namespace=Namespaces::XENC)
     */
    private $encryptionMethod;

    /**
     * @SerializedName("KeyInfo")
     * @Type("OCA\PeppolNext\PonderSource\WSSec\KeyInfo")
     * @XmlElement(namespace=Namespaces::DS)
     */
    private $keyInfo;

    /**
     * @SerializedName("CipherData")
     * @Type("OCA\PeppolNext\PonderSource\WSSec\CipherData")
     * @XmlElement(namespace=Namespaces::XENC)
     */
    private $cipherData;

    /**
     * @XmlList(entry="DataReference", namespace=Namespaces::XENC)
     * @SerializedName("ReferenceList")
     * @Type("array<OCA\PeppolNext\PonderSource\WSSec\DataReference>")
     * @XmlElement(namespace=Namespaces::XENC)
     */
    private $referenceList = [];

    public function __construct(){
        return $this;
    }

    public function setId($id){
        $this->id = $id;
        return $this;
    }
    public function getId(){
        return $this->id;
    }
    public function setEncryptionMethod($encryptionMethod){
        $this->encryptionMethod = $encryptionMethod;
        return $this;
    }
    public function getEncryptionMethod(){
        return $this->encryptionMethod;
    }
    public function setKeyInfo($keyInfo){
        $this->keyInfo = $keyInfo;
        return $this;
    }
    public function getKeyInfo(){
        return $this->keyInfo;
    }
    public function setCipherData($cipherData){
        $this->cipherData = $cipherData;
        return $this;
    }
    public function getCipherData(){
        return $this->cipherData;
    }
    public function setReferenceList($referenceList){
        $this->referenceList = $referenceList;
        return $this;
    }
    public function getReferenceList(){
        return $this->referenceList;
    }
    public function addReference($reference){
        array_push($this->referenceList, $reference);
        return $this;
    }
    public function removeReference($reference){
        array_filter($this->referenceList, function($r) { return $r != $reference; });
        return $this;
    }

}