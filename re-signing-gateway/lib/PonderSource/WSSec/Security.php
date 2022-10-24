<?php

namespace OCA\PeppolNext\PonderSource\WSSec;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{XmlElement,Type,XmlNamespace,XmlRoot,SerializedName,XmlAttribute};

/**
 * @XmlNamespace(uri=Namespaces::WSSE, prefix="wsse")
 * @XmlNamespace(uri=Namespaces::WSU, prefix="wsu")
 * @XmlNamespace(uri=Namespaces::XENC, prefix="xenc")
 * @XmlNamespace(uri=Namespaces::DS, prefix="ds")
 */
class Security {
    /**
     * @XmlAttribute
     * @Type("boolean")
     * @SerializedName("S12:MustUnderstand")
     */
    private $S12mustUnderstand = true;

    /**
     * @SerializedName("BinarySecurityToken")
     * @Type("OCA\PeppolNext\PonderSource\WSSec\BinarySecurityToken")
     * @XmlElement(namespace=Namespaces::WSSE)
     */
    private $encryptionSecurityToken;

    /**
     * @SerializedName("EncryptedKey")
     * @Type("OCA\PeppolNext\PonderSource\WSSec\EncryptedKey")
     * @XmlElement(namespace=Namespaces::XENC)
     */
    private $encryptedKey;

    /**
     * @SerializedName("EncryptedData")
     * @Type("OCA\PeppolNext\PonderSource\WSSec\EncryptedData")
     * @XmlElement(namespace=Namespaces::XENC)
     */
    private $encryptedData;

    /**
     * @SerializedName("BinarySecurityToken")
     * @Type("OCA\PeppolNext\PonderSource\WSSec\BinarySecurityToken")
     * @XmlElement(namespace=Namespaces::WSSE)
     */
    private $signatureSecurityToken;

    /**
     * @SerializedName("Signature")
     * @Type("OCA\PeppolNext\PonderSource\WSSec\Signature")
     * @XmlElement(namespace=Namespaces::DS)
     */
    private $signature;

    public function __construct(){
        return $this;
    }

    public function getSignature() {
        return $this->signature;
    }

    public function generateSignature($privateKey, $certificate, $references, $canonicaliztionMethod, $signatureMethod, $envelope){
        $signedInfo = new SignedInfo($signatureMethod, $canonicaliztionMethod);
        foreach($references as $ref){
            $signedInfo->addReference($ref);
        }
        $keyInfoId = uniqid("KI-");
        $securityTokenId = uniqid("STR-");
        $securityTokenReference = uniqid("X509-");
        $keyInfo = new KeyInfo(
            new SecurityTokenReference(
                new WSSecReference('#' . $securityTokenReference, 
                    'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#X509v3'
                ),
                ['Id' => $securityTokenId]
            ),
            $keyInfoId);
        $signature = new Signature($signedInfo, $keyInfo);
        $this->signatureSecurityToken = new BinarySecurityToken($securityTokenReference, $certificate);
        $this->signature = $signature;
        $signature->sign($envelope, $privateKey);
    }

    public function getEncryptionKey($privateKey) {
        $encryptedKey = $this->encryptedKey;
        $cipherValue = $encryptedKey->getCipherData()->getCipherValue();
        return $encryptedKey->getEncryptionMethod()->decrypt($cipherValue, $privateKey);
    }

    public function decryptData($data, $privateKey) {
        $encryptionKey = $this->getEncryptionKey($privateKey);

        return $this->encryptedData->getEncryptionMethod()->decrypt($data, $encryptionKey);
    }

    public function encryptData($encryptionKey, $certificate, $cid, $data){
        $dataId = uniqid('ED-');
        $keyId = uniqid('EK-');
        $tokenId = uniqid('X509-');

        $encryptedKey = new EncryptedKey();
        $encryptedKey->setId($keyId)
                     ->setEncryptionMethod(
                        new EncryptionMethod\RsaOeap(
                            new DigestMethod\SHA256(), 
                            new MGF('http://www.w3.org/2009/xmlenc11#mgf1sha256')))
                     ->setKeyInfo(
                        new KeyInfo(
                            new SecurityTokenReference(
                                new WSSecReference(
                                    '#' . $tokenId, 
                                    'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#X509v3'))))
                     ->setCipherData(
                        new CipherData(
                            $encryptedKey->getEncryptionMethod()->encrypt($encryptionKey, $certificate->getPublicKey())))
                     ->setReferenceList([new DataReference('#' . $dataId)]);

        $encryptedData = new EncryptedData(
            $id=$dataId,
            $mimeType='application/gzip',
            $dataType='http://docs.oasis-open.org/wss/oasis-wss-SwAProfile-1.1#Attachment-Content-Only',
            $encryptionMethod=new EncryptionMethod\AES128GCM(),
            $keyInfo=new KeyInfo(
                new SecurityTokenReference(
                    new WSSecReference(
                        '#' . $keyId,
                        'http://docs.oasis-open.org/wss/oasis-wss-soap-message-security-1.1#EncryptedKey'))),
            $cipherData=new CipherData(
                new CipherReference($cid, [new Transform('http://docs.oasis-open.org/wss/oasis-wss-SwAProfile-1.1#Attachment-Content-Signature-Transform')])));
        $this->encryptionSecurityToken = new BinarySecurityToken($tokenId, $certificate);
        $this->encryptedKey = $encryptedKey;
        $this->encryptedData = $encryptedData;
        return $encryptedData->getEncryptionMethod()->encrypt($data, $encryptionKey);
    }

}