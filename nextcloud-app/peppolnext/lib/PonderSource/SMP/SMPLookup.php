<?php

namespace OCA\PeppolNext\PonderSource\SMP;

use phpseclib3\File\X509;

class SMPLookup 
{

    public static function getSMPEndpoint($participantId, $isProduction) {
        $participantIdentifierScheme = 'iso6523-actorid-upis';
        $documentTypeScheme = 'busdox-docid-qns';
        $documentType = 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2::Invoice##urn:cen.eu:en16931:2017#compliant#urn:fdc:peppol.eu:2017:poacc:billing:3.0::2.1';

        $dnsZone = $isProduction ? 'edelivery.tech.ec.europa.eu' : 'acc.edelivery.tech.ec.europa.eu';

        $dnsPart = ($participantId === '*') ? '*' : 'b-'.md5($participantId);
        $smpHost = "http://$dnsPart.$participantIdentifierScheme.$dnsZone/";
        $smpEndpoint = $smpHost.urlencode("$participantIdentifierScheme::$participantId").'/services/'.urlencode("$documentTypeScheme::$documentType");

        return $smpEndpoint;
    }

    public static function SMPLookup($participantId, $isProduction) {
        $smpEndpoint = SMPLookup::getSMPEndpoint($participantId, $isProduction);

        $client = new \GuzzleHttp\Client();
		$response = $client->request('GET', $smpEndpoint)->getBody();

        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
		$obj = $serializer->deserialize($response,'OCA\PeppolNext\PonderSource\SMP\SignedServiceMetadata::class', 'xml');

        $endpoint = $obj->getServiceMetadata()->getServiceInformation()->getProcessList()[0]->getEndpointList()[0];

        $address = $endpoint->getEndpointReference()->getAddress();

        $certificate = new X509;
        $certificate->loadX509($endpoint->getCertificate());
        
        return [$address, $certificate];
    }

}