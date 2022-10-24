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
        $element = $dom->getElementsByTagName('Header')[0]->getElementsByTagName('Security')[0]->getElementsByTagName('Signature')[0]->getElementsByTagName('SignedInfo')[0];

        $xml = $this->signedInfo->getCanonicalizationMethod()->applyAlgorithm($element);
        $xml = str_replace("  ", '', str_replace("\n", '', $xml));
        $signature = $this->signedInfo->getSignatureMethod()->sign($pkey,$xml);
        $this->signatureValue = $signature;
        return $this;
    }

    public function verify($envelope, $payload, $public_key) {
        $serializer = SerializerBuilder::create()->build();
        $xml = $serializer->serialize($envelope, 'xml');

        $dom = new \DOMDocument();
        $dom->loadXml($xml);
        $element = $dom->getElementsByTagName('Header')[0]->getElementsByTagName('Security')[0]->getElementsByTagName('Signature')[0]->getElementsByTagName('SignedInfo')[0];

        $xml = $this->signedInfo->getCanonicalizationMethod()->applyAlgorithm($element);
        $xml = str_replace("  ", '', str_replace("\n", '', $xml));

        if ($this->signedInfo->getSignatureMethod()->verify($public_key, $xml, $this->signatureValue) !== true) {
            error_log('signature check failed');
            return false;
        }
        error_log('signature check success');

        foreach ($this->signedInfo->getReferences() as $reference) {
            $uri = $reference->getUri();
            error_log("reference uri " . var_export($uri, true));
            $id = ($uri[0] == '#') ? substr($uri, 1) : $uri;

            $content = false;

            if ($id === $envelope->getHeader()->getMessaging()->getId()) {
                $content = Signature::serializeAndRemoveSpaces($envelope->getHeader()->getMessaging());
                error_log('messaging reference ' . var_export($content, true));
            }
            else if ($id === $envelope->getBody()->getId()) {
                $content = Signature::serializeAndRemoveSpaces($envelope->getBody());
                error_log('body reference ' . var_export($content, true));
            }
            else if ($id === $envelope->getHeader()->getMessaging()->getUserMessage()->getPayloadInfo()->getPartInfo()->getReference()) {
                $content = $payload;
                error_log('payload reference ' . var_export($content, true));
            }
            else {
                error_log('reference '.$id.' not found');
                return false;
            }

            if ($content === false) {
                error_log('unrecognised reference id! ' . var_export($id, true));
                return false;
            }

            if ($reference->verify($content) === false) {
                error_log('cannot verify reference content! ' . var_export($content, true));
                if ($id === $envelope->getHeader()->getMessaging()->getId() || $id === $envelope->getHeader()->getMessaging()->getUserMessage()->getPayloadInfo()->getPartInfo()->getReference()) {
                    error_log('FIXME https://github.com/pondersource/peppol-php/issues/148');
                } else {
                    return false;
                }

            }
        }
        
        return true;
    }

    private static function serializeAndRemoveSpaces($obj) {
        $xml = (SerializerBuilder::create()->build())->serialize($obj, 'xml');
        $xml = str_replace("  ", '', str_replace("\n", '', $xml));
        return $xml;
    }

}