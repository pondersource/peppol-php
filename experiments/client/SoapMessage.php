<?php
namespace PonderSource\Peppol;
require_once('vendor/autoload.php');
require_once('ElectronicBusinessMessage.php');
require_once('GUID.php');
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class SoapMessage implements XmlSerializable {

	const S12 = 'http://www.w3.org/2003/05/soap-envelope';
	const WSU = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd';
	const EB = 'http://docs.oasis-open.org/ebxml-msg/ebms/v3.0/ns/core/200704/';

	private ElectronicBusinessMessage $ebms;
	private string $bodyId;
	private string $messageId;

	function __construct($ebms) {
		$this->ebms = $ebms;
		$this->bodyId = GUID();
		$this->messageId = GUID();
	}

	function getEBMS(): ElectronicBusinessMessage {
		return $this->ebms;
	}

	function setEBMS($ebms): SoapMessage {
		$this->ebms = $ebms;
		return $this;
	}

	function getBodyId(): string {
		return $this->bodyId;
	}

	function getMessageId(): string {
		return $this->messageId;
	}

	function XmlSerialize(Writer $writer) {
		$writer->write([
			'{' . $this::S12 . '}Header' => [
				'name' => '{' . $this::EB . '}Messaging',
				'attributes' => [
					'{' . $this::WSU . '}Id' => $this->messageId,
				],
				'value' => $this->ebms,
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