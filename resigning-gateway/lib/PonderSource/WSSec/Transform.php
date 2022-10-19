<?php

namespace OCA\PeppolNext\PonderSource\WSSec;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{XmlNamespace, XmlRoot, XmlAttribute, SerializedName, Type};

/**
 * @XmlNamespace(uri=Namespaces::DS, prefix="ds")
 * @XmlRoot("ds:Transform")
 */
class Transform {
    /**
     * @XmlAttribute
     * @SerializedName("Algorithm")
     * @Type("string")
     */
    private $uri;

    public function __construct($uri){
        $this->uri = $uri;
        return $this;
    }

    public function getUri(){
        return $this->uri;
    }

    public function setUri($uri){
        $this->uri = $uri;
        return $this;
    }

    public function transform($value){
        switch($this->uri){
            case 'http://www.w3.org/2001/10/xml-exc-c14n#':
                $dom = new \DOMDocument();
                $dom->loadXML($value);
                $xml = $dom->C14N($exclusive=true);
                $xml = str_replace("  ", '', str_replace("\n", '', $xml));
                return $xml;
                break;
            case 'http://docs.oasis-open.org/wss/oasis-wss-SwAProfile-1.1#Attachment-Content-Signature-Transform':
                return $value;
                break;
            default:
                return $value;
        }
    }

}