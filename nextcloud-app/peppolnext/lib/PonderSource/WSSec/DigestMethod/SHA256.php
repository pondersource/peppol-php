<?php

namespace OCA\PeppolNext\PonderSource\WSSec\DigestMethod;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{XmlNamespace,XmlRoot,Type,XmlAttribute,SerializedName};

/**
 * @XmlNamespace(uri=Namespaces::DS, prefix="ds")
 * @XmlRoot("ds:DigestMethod")
 */
class SHA256 implements IDigestMethod {
    /**
     * @XmlAttribute
     * @SerializedName("Algorithm")
     * @Type("string")
     */
    private $uri = "http://www.w3.org/2001/04/xmlenc#sha256";

    public function getUri(){
        return SHA256::$uri;
    }
    public function getDigest($value){
        return base64_encode(hash('sha256',$value,true));
    }
}