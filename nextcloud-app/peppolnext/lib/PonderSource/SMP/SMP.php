<?php

namespace OCA\PeppolNext\PonderSource\SMP;

use OCA\PeppolNext\PonderSource\SMP\{ServiceGroup, ParticipantIdentifier, ServiceMetadata, ServiceInformation, DocumentIdentifier, Process, ProcessIdentifier, Endpoint, EndpointReference};
use phpseclib3\File\X509;

class SMP 
{

    public static function lookup($participantScheme, $participantId, $isProduction) {
        $smpEndpoint = SMP::getDocumentEndpoint($participantScheme, $participantId, $isProduction);

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

    public static function newParticipant($participantId, $isProduction, $username, $password) {
        $participantIdentifierScheme = 'iso6523-actorid-upis';
        
        $participantEndpoint = SMP::getParticipantEndpoint($participantId, $isProduction);
        
        $serviceGroup = new ServiceGroup(new ParticipantIdentifier($participantIdentifierScheme, $participantId));
        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        $body = $serializer->serialize($serviceGroup, 'xml');

        $client = new \GuzzleHttp\Client();
		$response = $client->request('PUT', $participantEndpoint, [
			'auth' => [ $username, $password ],
			'body' => $body
		]);

        $statusCode = $response->getStatusCode();

        return $statusCode >= 200 && $statusCode < 300;
    }

    public static function removeParticipant($participantId, $isProduction, $username, $password) {
        $participantEndpoint = SMP::getParticipantEndpoint($participantId, $isProduction);

        $client = new \GuzzleHttp\Client();
		$response = $client->request('DELETE', $participantEndpoint, [
			'auth' => [ $username, $password ]
		]);

        $statusCode = $response->getStatusCode();

        return $statusCode >= 200 && $statusCode < 300;
    }

    public static function specifyEndpoint($participantId, $endpointUrl, $certificate, $description, $contactEmail, $isProduction, $username, $password) {
        $participantIdentifierScheme = 'iso6523-actorid-upis';
        $documentTypeScheme = 'busdox-docid-qns';
        $documentType = 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2::Invoice##urn:cen.eu:en16931:2017#compliant#urn:fdc:peppol.eu:2017:poacc:billing:3.0::2.1';
        $processIdentifierScheme = 'cenbii-procid-ubl';
        $processIdentifier = 'urn:fdc:peppol.eu:2017:poacc:billing:01:1.0';

        $smpEndpoint = SMP::getDocumentEndpoint($participantId, $isProduction);

        $serviceMetadata = new ServiceMetadata(
            new ServiceInformation(
                new ParticipantIdentifier($participantIdentifierScheme, $participantId),
                new DocumentIdentifier($documentTypeScheme, $documentType),
                [
                    new Process(
                        new ProcessIdentifier($processIdentifierScheme, $processIdentifier),
                        [
                            new Endpoint(
                                'peppol-transport-as4-v2_0',
                                new EndpointReference($endpointUrl),
                                false,
                                $certificate,
                                $description,
                                $contactEmail
                            )
                        ]
                    )
                ]
            )
        );
        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        $body = $serializer->serialize($serviceMetadata, 'xml');

        $client = new \GuzzleHttp\Client();
		$response = $client->request('PUT', $smpEndpoint, [
			'auth' => [ $username, $password ],
			'body' => $body
		]);

        $statusCode = $response->getStatusCode();

        return $statusCode >= 200 && $statusCode < 300;
    }

    public static function removeEndpoint($participantId, $isProduction, $username, $password) {
        $smpEndpoint = SMP::getDocumentEndpoint($participantId, $isProduction);

        $client = new \GuzzleHttp\Client();
		$response = $client->request('DELETE', $smpEndpoint, [
			'auth' => [ $username, $password ]
		]);

        $statusCode = $response->getStatusCode();

        return $statusCode >= 200 && $statusCode < 300;
    }

    public static function getDocumentEndpoint($participantId, $isProduction) {
        $documentTypeScheme = 'busdox-docid-qns';
        $documentType = 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2::Invoice##urn:cen.eu:en16931:2017#compliant#urn:fdc:peppol.eu:2017:poacc:billing:3.0::2.1';

        $participantEndpoint = SMP::getParticipantEndpoint($participantId, $isProduction);
        $documentEndpoint = $participantEndpoint.'/services/'.urlencode("$documentTypeScheme::$documentType");

        return $documentEndpoint;
    }

    public static function getParticipantEndpoint($participantId, $isProduction) {
        $participantIdentifierScheme = 'iso6523-actorid-upis';

        $smpHost = SMP::getSMPHost($participantId, $isProduction);
        $participantEndpoint = $smpHost.urlencode("$participantIdentifierScheme::$participantId");

        return $participantEndpoint;
    }

    public static function getSMPHost($participantScheme, $participantId, $isProduction) {
        $dnsZone = $isProduction ? 'edelivery.tech.ec.europa.eu' : 'acc.edelivery.tech.ec.europa.eu';

        $dnsPart = ($participantId === '*') ? '*' : 'b-'.md5($participantId);
        $smpHost = "http://$dnsPart.$participantScheme.$dnsZone/";

        return $smpHost;
    }

}