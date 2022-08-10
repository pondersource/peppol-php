<?php

namespace OCA\PeppolNext\PonderSource\WSSec;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{XmlNamespace, Accessor, Type, XmlRoot, XmlAttribute, SerializedName, XmlValue, Exclude};
use phpseclib3\Crypt\RSA;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\File\X509;
/**
 * @XmlNamespace(uri=Namespaces::WSSE, prefix="wsse")
 * @XmlRoot("wsse:BinarySecurityToken")
 */
class BinarySecurityToken {
    /**
     * @XmlAttribute
     * @SerializedName("EncodingType")
     * @Type("string")
     */
    private $encodingType = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary';

    /**
     * @XmlAttribute
     * @SerializedName("ValueType")
     * @Type("string")
     */
    private $valueType = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#X509v3';

    /**
     * @XmlAttribute(namespace=Namespaces::WSU)
     * @SerializedName("Id")
     * @Type("string")
     */
    private $id;
    
    /**
     * @Exclude
     */
    private $x509Certificate;
    
    /**
     * @XmlValue(cdata=false)
     * @Accessor(getter="getEncryptionToken", setter="setEncryptionToken")
     * @Type("string")
     */
    private $encryptionToken;

    public function __construct($id = '', $cert = null){
        $this->id = $id;
        $this->setCertificate($cert);
        return $this;
    }

    public function setEncoding($encoding){
        $this->encodingType = $encoding;
        return $this;
    }
    public function getEncoding(){
        return $this->encodingType;
    }
    public function setValueType($valueType){
        $this->valueType = $valueType;
        return $this;
    }
    public function getValueType(){
        return $this->valueType;
    }
    public function setId($id){
        $this->id = $id;
        return $this;
    }
    public function getId(){
        return $this->id;
    }
    public function setCertificate($x509){
        if(get_class($x509) === 'phpseclib3\File\X509'){
            $this->x509Certificate = $x509;
            $this->encryptionToken = $this->certificate2Token($x509);
            return $this;
        }
        return false;
    }
    public function getCertificate(){
        if(isset($this->x509Certificate)){
            return $this->x509Certificate;
        } else if(isset($this->encryptionToken)){
            $this->x509Certificate = $this->token2Certificate($this->encryptionToken);
            return $this->x509Certificate;
        } else {
            return null;
        }
    }
    public function getEncryptionToken() {
        return $this->encryptionToken;
    }
    public function setEncryptionToken($token){
        $this->encryptionToken = $token;
        $this->x509Certificate = $this->token2Certificate($token);
    }

    private function token2Certificate($token){
        $x509 = new X509;
        $x509->loadX509($token);
        return $x509;
    }
    private function certificate2Token($x509){
        $token = $x509->saveX509($x509->getCurrentCert());
        $tokenArray = explode("\r\n", $token);
        $tokenArray = array_slice($tokenArray, 1, count($tokenArray)-2);
        $token = join('', $tokenArray);
        return $token;
    }
}