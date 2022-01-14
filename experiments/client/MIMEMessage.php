<?php

namespace PonderSource\Peppol;

require_once('./vendor/autoload.php');
require_once('ElectronicBusinessMessage.php');
require_once('GUID.php');
require_once('SoapMessage.php');
require_once('PayloadInfo.php');
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Sabre\Xml\Writer;
use Sabre\Xml\Service;


class MIMEMessage {
	private $boundary;
	private $content;
	private $request;
	private $client;
	private $uri;
	private $messageId;

	function __construct($server){
		$this->uri = $server;
		$this->client = new Client(['base_uri' => $server]);
		$this->boundary = uniqid("----=MIMEBoundary_", true);
		$this->messageId = uniqid("MessageId:", true);
		return $this;
	}

	function addAttachment($payload, $contentType="application/octet-stream", $additionalHeaders=[]){
		$this->content .= "\n$this->boundary\nContent-Type: $contentType";
		if($additionalHeaders){
			foreach($additionalHeaders as $header){
				$this->content .= "\n$header";
			}
		}
		$this->content .= "\n$payload";
		return $this;
	}

	function prepareRequest(){
		$this->request = new Request('POST', $this->uri, ['Message-Id' => $this->messageId, 'MIME-Version' => '1.0', 'Content-Type' => 'multipart/related;	boundary="' . $this->boundary . '";	type="application/soap+xml";	charset=UTF-8'], $this->content);
	}

	function send(){
		$this->content .= "\n$this->boundary";
		$this->prepareRequest();
		try {
			$response = $this->client->send($this->request);
			print($response->getBody());
		} catch(Exception $e) {
			error_log($e);
		}
	}
}

function whatever(){
	$keypair = openssl_pkey_new();
	$publicPem = openssl_pkey_get_details($keypair)['key'];
	$publicKey = openssl_pkey_get_public($publicPem);
	$privateKey = openssl_pkey_get_private($keypair);

	$tag;
	$myId = 'pondersourceTestClient' . GUID();
	$recipient = 'testRecipient' . GUID();
	$payloadRef = 'cid:pondersourcepeppol-att-' . GUID() . '@cid';
	$payloadXML = new \DOMDocument();
	$payloadXML->load('./base-example.xml');
	$payloadNormalized = $payloadXML->C14N($exclusive=true);
	$payloadCompressed = gzcompress($payloadNormalized);
	$payloadEncrypted = openssl_encrypt($payloadCompressed, 'aes-128-gcm', $publicPem, 0, openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-128-gcm')),$tag);
	$header = new SoapMessage(
		new ElectronicBusinessMessage(
			new \DateTime(), 
			'messageId-' . GUID() . '@pondersourcepeppol', 
			$myId,
			'http://docs.oasis-open.org/ebxml-msg/ebms/v3.0/ns/core/200704/initiator',
			$recipient,
			'http://docs.oasis-open.org/ebxml-msg/ebms/v3.0/ns/core/200704/responder',
			'http://docs.oasis-open.org/ebxml-msg/ebms/v3.0/ns/core/200704/initiator',
			'urn:fdc:peppol.eu:2017:poacc:billing:01:1.0',
			'busdox-docid-qns::urn:oasis:names:specification:ubl:schema:xsd:Invoice-2::Invoice##urn:cen.eu:en16931:2017#compliant#urn:fdc:peppol.eu:2017:poacc:billing:3.0::2.1',
			'pondersourcepeppol-conv-' . GUID(),
			$myId,
			$recipient,
			[ new PayloadInfo($payloadRef, ["MimeType" => "application/xml", "CompressionType" => "application/gzip"]) ]
		)
	);
	$service = new Service();
	$service->namespaceMap = [
		'http://www.w3.org/2003/soap-envelope' => 'S12',
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
	$soap = $service->write('S12:Envelope', $header);
	$soapXml = new \DOMDocument();
	$soapXml->loadXML($soap);
	$soapNormalized = $soapXml->C14N($exclusive=true);
	$message = (new MIMEMessage('http://localhost:8080/as4'))
		->addAttachment($soapNormalized, 'application/soap+xml;charset=UTF-8')
		->addAttachment($payloadEncrypted, 'application/octet-stream',['Content-Description: Attachment', 'Content-ID: <' . $payloadRef . '>']);
	$message->send();
}