<?php

namespace OCA\PeppolNext\PonderSource\EBMS;

use OCA\PeppolNext\PonderSource\EBMS\Property;
use OCA\PeppolNext\PonderSource\Namespaces;
use JMS\Serializer\Annotation\{Type,XmlNamespace,XmlRoot,XmlList,XmlAttribute,XmlElement,SerializedName};

/**
 * @XmlNamespace(uri=Namespaces::EB, prefix="eb")
 */
class Receipt {
    /**
     * @XmlList(entry="MessagePartNRInformation",namespace=Namespaces::EBBP)
     * @Type("array<OCA\PeppolNext\PonderSource\EBBP\MessagePartNRInformation>")
     * @XmlElement(namespace=Namespaces::EBBP)
     * @SerializedName("NonRepudiationInformation")
     */
    private $nonRepudiationInformation = [];

    public function __construct($nonRepudiationInformation = []){
        $this->nonRepudiationInformation = $nonRepudiationInformation;
    }

    function addMessagePartNRInformation($messagePartNRInformation){
        if(get_class($messagePartNRInformation) !== 'PonderSource\EBBP\MessagePartNRInformation'){
            throw new Exception('Failed to add message part as it is not of class MessagePartNRInformation');
        }
        array_push($this->nonRepudiationInformation, $messagePartNRInformation);
        return $this;
    }

    function removePartNRInformation($messagePartNRInformation){
        array_filter($this->nonRepudiationInformation, function($p) { return $p != $messagePartNRInformation; }, ARRAY_FILTER_USE_KEY);
        return $this;
    }

    function getNonRepudiationInformation() {
        return $this->nonRepudiationInformation;
    }

}
