<?php
namespace PonderSource\Peppol;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class PayloadInfo implements XmlSerializable {
	const EBNS='{http://docs.oasis-open.org/ebxml-msg/ebms/v3.0/ns/core/200704/}';
	private string $id;
	private array $partProperties;

	function __construct(string $id, array $partProperties){
		$this->id = $id;
		$this->partProperties = $partProperties;
	}
	function getId(): string {
		return $this->id;
	}
	function setId(string $id): PayloadInfo {
		$this->id = $id;
		return $this;
	}
	function getPartProperties(): array {
		return $this->partProperties;
	}
	function addPartProperties(array $props): PayloadInfo {
		foreach($props as $key => $value) {
			$this->partProperties[$key] = $value;
		}
		return $this;
	}
	function setPartProperty($key, $value): PayloadInfo {
		$this->partProperties[$key] = $value;
		return $this;
	}
	function propertySerialize(): array {
		$res = [];
		foreach($this->partProperties as $key => $value) {
			array_push($res,[
				'name' => $this::EBNS . 'Property', 
				'attribute' => [
					'name' => $key,
				],
				'value' => $value,
			]);
		}
		return $res;
	}
	function xmlSerialize(Writer $writer){
		$writer->write([
			'name' => $this::EBNS . 'PayloadInfo',
			'attributes' => [
				'href' => $this->id,
			],
			'value' => [
				$this::EBNS . 'PartProperties' => [$this->propertySerialize()]
			]
		]);
	}
}