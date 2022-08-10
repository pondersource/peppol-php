<?php

namespace OCA\PeppolNext\PonderSource\WSSec;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{XmlRoot,XmlElement,Type,XmlNamespace,SerializedName};
use JMS\Serializer\SerializerBuilder;

/**
 * @XmlNamespace(uri=Namespaces::DS, prefix="ds")
 * @XmlRoot("ds:Signature")
 */
class Signature {
    /**
     * @SerializedName("SignedInfo") 
     * @Type("OCA\PeppolNext\PonderSource\WSSec\SignedInfo")
     * @XmlElement(namespace=Namespaces::DS)
     */
    private $signedInfo;

    /**
     * @SerializedName("SignatureValue")
     * @XmlElement(cdata=false, namespace=Namespaces::DS)
     * @Type("string")
     */
    private $signatureValue;

    /**
     * @SerializedName("KeyInfo")
     * @Type("OCA\PeppolNext\PonderSource\WSSec\KeyInfo")
     * @XmlElement(namespace=Namespaces::DS)
     */
    private $keyInfo;

    public function __construct($signedInfo, $keyInfo){
        $this->signedInfo = $signedInfo;
        $this->keyInfo = $keyInfo;
        return $this;
    }

    public function setSignedInfo($signedInfo){
        $this->signedInfo = $signedInfo;
        return $this;
    }

    public function getSignedInfo(){
        return $this->signedInfo;
    }

    public function setKeyInfo($keyInfo){
        $this->keyInfo = $keyInfo;
        return $this;
    }

    public function getKeyInfo(){
        return $this->keyInfo;
    }

    public function sign($envelope, $pkey){
        $serializer = SerializerBuilder::create()->build();
        $xml = $serializer->serialize($envelope, 'xml');
        
        $dom = new \DOMDocument();
        $dom->loadXml($xml);
        $element = $dom->firstElementChild->firstElementChild->getElementsByTagName('Signature')[0]->firstElementChild;

        $xml = $this->signedInfo->getCanonicalizationMethod()->applyAlgorithm($element);
        $xml = str_replace("  ", '', str_replace("\n", '', $xml));
        $signature = $this->signedInfo->getSignatureMethod()->sign($pkey,$xml);
        $this->signatureValue = $signature;
        return $this;
    }

}