<?php

namespace OCA\PeppolNext\PonderSource\Envelope;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlAttribute,XmlNamespace,SerializedName,XmlRoot,XmlElement};

/**
 * @XmlNamespace(uri=Namespaces::EB, prefix="eb")
 * @XmlNamespace(uri=Namespaces::WSSE, prefix="wsse")
 */
class Header 
{

    /**
     * @SerializedName("Security")
     * @XmlElement(namespace=Namespaces::WSSE)
     * @Type("OCA\PeppolNext\PonderSource\WSSec\Security")
     */
    private $security;

    /**
     * @SerializedName("Messaging")
     * @XmlElement(namespace=Namespaces::EB)
     * @Type("OCA\PeppolNext\PonderSource\EBMS\Messaging")
     */
    private $messaging;

    public function __construct($security = null, $messaging = null){
        $this->messaging = $messaging;
        $this->security = $security;
        return $this;
    }

    public function setSecurity($security){
        $this->security = $security;
        return $this;
    }

    public function getSecurity(){
        return $this->security;
    }

    public function setMessaging($messaging){
        $this->messaging = $messaging;
        return $this;
    }

    public function getMessaging(){
        return $this->messaging;
    }

    public function decodePayload($payload, $private_key) {
        $decrypted_payload = $this->security->decryptData($payload, $private_key);

        $part_info = $this->messaging->getUserMessage()->getPayloadInfo()->getPartInfo();
        $compression_type = $part_info->getProperty('CompressionType');

        if ($compression_type == 'application/gzip') {
            return gzdecode($decrypted_payload);
        }

        return $decrypted_payload;
    }

}