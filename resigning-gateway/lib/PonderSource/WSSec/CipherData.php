<?php

namespace OCA\PeppolNext\PonderSource\WSSec;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{XmlRoot,Type,XmlElement,XmlNamespace,SerializedName};

/**
 * @XmlNamespace(uri=Namespaces::XENC, prefix="xenc")
 * @XmlRoot("xenc:CipherData")
 */
class CipherData {
    /**
     * @SerializedName("CipherValue")
     * @XmlElement(cdata=false,namespace=Namespaces::XENC)
     * @Type("string")
     */
    private $cipherValue;

    /**
     * @SerializedName("CipherReference")
     * @Type("OCA\PeppolNext\PonderSource\WSSec\CipherReference")
     * @XmlElement(namespace=Namespaces::XENC)
     */
    private $cipherReference;

    public function __construct($cipherDataOrReference){
        if (is_string($cipherDataOrReference)){
            $this->cipherValue = $cipherDataOrReference;
        } else if (is_object($cipherDataOrReference) && get_class($cipherDataOrReference) === 'OCA\PeppolNext\PonderSource\WSSec\CipherReference'){
            $this->cipherReference = $cipherDataOrReference;
        } else {
            throw new \Exception('CipherData can only contain either CipherValue(string) or CipherReference types');
        }
    }

    public function getCipherValue() {
        return $this->cipherValue;
    }

}