<?php

namespace OCA\PeppolNext\PonderSource\WSSec\SignatureMethod;

use OCA\PeppolNext\PonderSource\Namespaces;
use phpseclib3\Crypt\RSA;
use JMS\Serializer\Annotation\{XmlRoot,XmlAttribute,Type,SerializedName,XmlNamespace};

/**
 * @XmlNamespace(uri=Namespaces::DS, prefix="ds")
 * @XmlRoot("ds:SignatureMethod")
 */
class RsaSha256 implements ISignatureMethod {
    /**
     * @XmlAttribute
     * @SerializedName("Algorithm")
     * @Type("string")
     */
    private $uri = "http://www.w3.org/2001/04/xmldsig-more#rsa-sha256";

    public function __construct(){
        return $this;
    }

    public function  getUri() {
        return RsaSha256::$uri;
    }

    public function sign($pkey, $value){
        $pkey = $pkey->withPadding(RSA::SIGNATURE_PKCS1);
        $signature = $pkey->sign($value);
        return \base64_encode($signature);
    }

    public function verify($public_key, $message, $signature) {
        $public_key = $public_key->withPadding(RSA::SIGNATURE_PKCS1);

        $signature = \base64_decode($signature);
        return $public_key->verify($message, $signature);
    }

}