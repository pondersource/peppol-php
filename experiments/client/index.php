<?php

require __DIR__ . '/vendor/autoload.php';

use PonderSource\Peppol\{MIMEMessage, ElectronicBusinessMessage, PayloadInfo, SoapMessage};
use PonderSource\Peppol\Utils\GUID;

$privateKey;
$certificate;

function sendRequest($targetServer, 
                     $targetCertificate, 
					 $privateKey, 
					 $payload, 
					 $recipientId, 
					 $agreementReference, 
					 $service='urn:fdc:peppol.eu:2017:poacc:billing:01:1.0',
					 $action='busdox-docid-qns::urn:oasis:names:specification:ubl:schema:xsd:Invoice-2::Invoice##urn:cen.eu:en16931:2017#compliant#urn:fdc:peppol.eu:2017:poacc:billing:3.0::2.1'){
	$tag;
	$myId = 'pondersourceTestClient' . GUID::getNew();
	$payloadRef = 'cid:pondersourcepeppol-att-' . GUID::getNew() . '@cid';
	$payloadNormalized = $payload->C14N($exclusive=true);
	$payloadCompressed = gzcompress($payloadNormalized);
	$payloadEncrypted;
	$encryptedKeys;
	$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-128-gcm'));
	openssl_seal($payloadCompressed, $payloadEncrypted, $encryptedKeys, $targetCertificate, 'aes-128-gcm', $iv);
	$ebm = 	new ElectronicBusinessMessage(
			new \DateTime(), 
			'messageId-' . GUID::getNew() . '@pondersourcepeppol', 
			$myId,
			'http://docs.oasis-open.org/ebxml-msg/ebms/v3.0/ns/core/200704/initiator',
			$recipientId,
			'http://docs.oasis-open.org/ebxml-msg/ebms/v3.0/ns/core/200704/responder',
			$agreementReference,
			'urn:fdc:peppol.eu:2017:poacc:billing:01:1.0',
			'busdox-docid-qns::urn:oasis:names:specification:ubl:schema:xsd:Invoice-2::Invoice##urn:cen.eu:en16931:2017#compliant#urn:fdc:peppol.eu:2017:poacc:billing:3.0::2.1',
			'pondersourcepeppol-conv-' . GUID::getNew(),
			$myId,
			$recipientId,
			[ new PayloadInfo($payloadRef, ["MimeType" => "application/xml", "CompressionType" => "application/gzip"]) ]
	);
	$header = new SoapMessage($ebm, $privateKey, $encryptedKeys, $targetCertificate);
	$service = new Sabre\XML\Service();
	$service->namespaceMap = [
		'http://www.w3.org/2003/05/soap-envelope' => 'S12',
		'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd' => 'wsse',
		'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd' => 'wsu',
		'http://www.w3.org/2001/04/xmlenc#' => 'xenc',
		'http://www.w3.org/2000/09/xmldsig#' => 'ds',
		'http://www.w3.org/2009/xmlenc11#' => 'xenc11',
		'http://docs.oasis-open.org/wss/oasis-wss-wssecurity-secext-1.1.xsd' => 'wsse11',
		'http://www.w3.org/2001/10/xml-exc-c14n#' => 'ec',
		'http://schemas.xmlsoap.org/soap/envelope/' => 'S11',
		'http://docs.oasis-open.org/ebxml-msg/ebms/v3.0/ns/core/200704/' => 'eb',
		'http://docs.oasis-open.org/ebxml-bp/ebbp-signals-2.0' => 'ebbp',
		'http://www.w3.org/1999/xlink' => 'xlink',
	];
	$service->options = LIBXML_NOBLANKS | LIBXML_COMPACT | LIBXML_NSCLEAN;
	$soap = $service->write('S12:Envelope', $header);
	$soapXml = new \DOMDocument();
	$soapXml->loadXML($soap, LIBXML_NOBLANKS | LIBXML_COMPACT | LIBXML_NSCLEAN);
	$soapNormalized = '<?xml version="1.0" encoding="UTF-8"?>' . $soapXml->C14N($exclusive=true);
	file_put_contents('debug.xml',$soapNormalized);
	$message = (new MIMEMessage('http://localhost:8080/as4'))
		->addAttachment($soapNormalized, 'application/soap+xml;charset=UTF-8', ['Content-Transfer-Encoding: binary'])
		->addAttachment($payloadEncrypted, 'application/octet-stream',['Content-Transfer-Encoding: binary','Content-Description: Attachment', 'Content-ID: <' . $payloadRef . '>']);
	$message->send();
}

$certfile = file_get_contents('test-ap.crt');
$targetCertificate = [openssl_x509_read($certfile)];
$payload = new \DOMDocument();
$payload->load('base-example.xml');
$recipientId = 'recipient-id-test-phase4';
$agreementReference = '1';
$privateKey = openssl_pkey_new();

$out = sendRequest('http://localhost:8080/as4', $targetCertificate, $privateKey, $payload, $recipientId, $agreementReference);
print('<xmp>' . $out . '</xmp>');

?>
