<?php

namespace PonderSource\Peppol;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Sabre\Xml\Writer;
use Sabre\Xml\Service;

class MIME {
	private $boundary;
	private $content;
	private $request;
	private $client;
	private $uri;
	private $messageId;

	function __construct($server){
		$this->uri = $server;
		$this->client = new Client(['base_uri' => $server]);
		$this->boundary = uniqid('--=MIMEBoundary_', true);
		$messageId = uniqid('<', true);
		$messageId = gethostname()?$messageId . '@' . gethostname() . '>':$messageId . '@pondersourcePeppol>';
		$this->messageId = $messageId;
		return $this;
	}

	function addAttachment($attachment, $contentType="application/octet-stream", $additionalHeaders=[]){
		$this->content .= "\r\n--$this->boundary\r\nContent-Type: $contentType";
		if($additionalHeaders){
			foreach($additionalHeaders as $header){
				$this->content .= "\r\n$header";
			}
		}
		$this->content .= "\r\n\r\n$attachment";
		return $this;
	}

	function prepareRequest(){
		$this->request = new Request('POST',
			$this->uri,
			[
				'Message-Id' => $this->messageId,
				'Accept-Encoding' => 'gzip,deflate',
				'Date' => (new \DateTime())->format('D, d M Y H:i:s O (T)'),
				'MIME-Version' => '1.0',
				'Content-Type' => 'multipart/related;	boundary="' . $this->boundary . '";	type="application/soap+xml";	charset=UTF-8'
			],
			$this->content);
	}

	function send(){
		$this->content .= "\r\n--$this->boundary--\r\n";
		$this->prepareRequest();
		try {
			$response = $this->client->send($this->request);
			$xmlstring = $response->getBody();
			return $xmlstring;
		} catch(Exception $e) {
			error_log($e);
		}
	}
}
