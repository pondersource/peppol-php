<?php

namespace OCA\PeppolNext\PonderSource\WSSec;

use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{XmlRoot, Type, XmlNamespace,XmlAttribute,SerializedName,XmlList,XmlElement};

/**
 * @XmlNamespace(uri=Namespaces::DS, prefix="ds")
 * @XmlRoot("ds:Reference")
 */
class DSigReference {

    /**
     * @XmlAttribute
     * @SerializedName("URI")
     * @Type("string")
     */
    private $uri;

    /**
     * @SerializedName("Transforms")
     * @XmlList(inline=false, entry="Transform", namespace=Namespaces::DS) 
     * @Type("array<OCA\PeppolNext\PonderSource\WSSec\Transform>")
     * @XmlElement(namespace=Namespaces::DS)
     */
    private $transforms;

    /**
     * @SerializedName("DigestMethod")
     * @XmlElement(cdata=false, namespace=Namespaces::DS)
     * @Type("OCA\PeppolNext\PonderSource\WSSec\DigestMethod\SHA256")
     */
    private $digestMethod;

    /**
     * @SerializedName("DigestValue")
     * @XmlElement(cdata=false, namespace=Namespaces::DS)
     * @Type("string")
     */
    private $digestValue;

    public function __construct($uri, $content, $transforms, $digestMethod){
        $this->uri = $uri;
        $this->digestMethod = $digestMethod;
        $this->transforms = $transforms;
        foreach($transforms as $transform){
            $content = $transform->transform($content);
        }
        $this->digestValue = $digestMethod->getDigest($content);
    }

    public function getUri() {
        return $this->uri;
    }

    public function getDigestMethod() {
        return $this->digestMethod;
    }

    public function getTransforms() {
        return $this->transforms;
    }

    public function getDigestValue() {
        return $this->digestValue;
    }

    public function verify($content) {
        foreach($this->transforms as $transform) {
            $content = $transform->transform($content);
        }

        $content = $this->digestMethod->getDigest($content);

        return $content === $this->digestValue;
    }

}