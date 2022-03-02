<?php
namespace PonderSource\Peppol;

use PonderSource\Peppol\{EBMS,WSSE};
use PonderSource\Peppol\Utils\GUID;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class SOAP implements XmlSerializable {

	const S12 = 'http://www.w3.org/2003/05/soap-envelope';
	const WSU = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd';
	const EB = 'http://docs.oasis-open.org/ebxml-msg/ebms/v3.0/ns/core/200704/';
	const WSSE = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';

	private WSSE $security;
	private EBMS $ebms;
	private string $bodyId;
	private string $messageId;

	function __construct($ebms, $signatureKey, $encryptedKeys, $targetCertificate, $attachments = []) {
		$this->security = new WSSE($signatureKey, $encryptedKeys, $targetCertificate, $attachments);
		$this->ebms = $ebms;
		$this->bodyId = GUID::getNew();
		$this->messageId = GUID::getNew();
	}

	function getSecurity(): WSSE {
		return $this->security;
	}

	function setSecurity($security): SOAP {
		$this->security = $security;
		return $this;
	}

	function getEBMS(): EBMS {
		return $this->ebms;
	}

	function setEBMS($ebms): SOAP {
		$this->ebms = $ebms;
		return $this;
	}

	function getBodyId(): string {
		return $this->bodyId;
	}

	function getMessageId(): string {
		return $this->messageId;
	}

	function getDigest(DOMNode $content, string $cipher='sha256') {
		return base64_encode(openssl_digest($content->C14N($exclusive=true), 'sha256', true));
	}

	function createSignature(){}
	

	function XmlSerialize(Writer $writer) {
		$writer->write([
			'{' . $this::S12 . '}Header' => [
				$this->security,
				[
					'name' => '{' . $this::EB . '}Messaging',
					'attributes' => [
						'{' . $this::WSU . '}Id' => $this->messageId,
					],
					'value' => $this->ebms,
				],
			],
			[
				'name' => '{' . $this::S12 . '}Body',
				'attributes' => [
					'{' . $this::WSU . '}Id' => $this->bodyId
				],
			],
		]);
	}
}