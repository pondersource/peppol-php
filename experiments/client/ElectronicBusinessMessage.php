<?php
namespace PonderSource\Peppol;
require_once('vendor/autoload.php');
require_once('PayloadInfo.php');
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class ElectronicBusinessMessage implements XmlSerializable {
	const EBNS='{http://docs.oasis-open.org/ebxml-msg/ebms/v3.0/ns/core/200704/}';
	private \DateTime $timestamp;
	private string $id;
	private string $partyIdFrom;
	private string $partyRoleFrom;
	private string $partyIdTo;
	private string $partyRoleTo;
	private string $agreementRef;
	private string $service;
	private string $action;
	private string $conversationId;
	private string $originalSender;
	private string $finalRecipient;
	private array $payloadInfo;

	function __construct(\DateTime $timestamp, 
					     string $id, 
						 string $partyIdFrom, 
						 string $partyRoleFrom, 
						 string $partyIdTo, 
						 string $partyRoleTo, 
						 string $agreementRef, 
						 string $service, 
						 string $action, 
						 string $conversationId, 
						 string $originalSender, 
						 string $finalRecipient,
						 array $payloadInfo)
	{
		$this->timestamp = $timestamp;
		$this->id = $id;
		$this->partyIdFrom = $partyIdFrom;
		$this->partyRoleFrom = $partyRoleFrom;
		$this->partyIdTo = $partyIdTo;
		$this->partyRoleTo = $partyRoleTo;
		$this->agreementRef = $agreementRef;
		$this->service = $service;
		$this->action = $action;
		$this->conversationId = $conversationId;
		$this->originalSender = $originalSender;
		$this->finalRecipient = $finalRecipient;
		$this->payloadInfo = $payloadInfo;
	}
	function getTimestamp(): \DateTime {
		return $this->timestamp;
	}
	function setTimestamp(\DateTime $timestamp): ElectronicBusinessMessage {
		$this->timestamp = $timestamp;
		return $this;
	}
	function getId(): string {
		return $this->id;
	}
	function setId(string $id): ElectronicBusinessMessage {
		$this->id = $id;
		return $this;
	}
	function getPartyIdFrom(): string {
		return $this->partyIdFrom;
	}
	function setPartyIdFrom(string $id): ElectronicBusinessMessage {
		$this->partyIdFrom = $id;
		return $this;
	}
	function getPartyRoleFrom(): string {
		return $this->partyRoleFrom;
	}
	function setPartyRoleFrom(string $role): ElectronicBusinessMessage {
		$this->partyRoleFrom = $role;
		return $this;
	}
	function getPartyIdTo(): string {
		return $this->partyIdTo;
	}
	function setPartyIdTo(string $id): ElectronicBusinessMessage {
		$this->partyIdTo = $id;
		return $this;
	}
	function getPartyRoleTo(): string {
		return $this->partyRoleTo;
	}
	function setPartyRoleTo(string $role): ElectronicBusinessMessage {
		$this->partyRoleTo = $role;
		return $this;
	}
	function getAgreementRef(): string {
		return $this->agreementRef;
	}
	function setAgreementRef(string $agreementRef): ElectronicBusinessMessage {
		$this->agreementRef = $agreementRef;
		return $this;
	}
	function getService(): string {
		return $this->service;
	}
	function setService(string $service): ElectronicBusinessMessage {
		$this->service = $service;
		return $this;
	}
	function getAction(): string {
		return $this->action;
	}
	function setAction(string $action): ElectronicBusinessMessage {
		$this->action = $action;
		return $this;
	}
	function getConversationId(): string {
		return $this->conversationId;
	}
	function setConversationId(string $conversationId): ElectronicBusinessMessage {
		$this->conversationId = $conversationId;
		return $this;
	}
	function getOriginalSender(): string {
		return $this->originalSender;
	}
	function setOriginalSender(string $originalSender): ElectronicBusinessMessage {
		$this->originalSender = $originalSender;
		return $this;
	}
	function getFinalRecipient(): string {
		return $this->finalRecipient;
	}
	function setFinalRecipient(string $finalRecipient): ElectronicBusinessMessage {
		$this->finalRecipient = $finalRecipient;
		return $this;
	}
	function getPayloadInfo(): array {
		return $this->payloadInfo;
	}
	function setPayloadInfo(string $payloads): ElectronicBusinessMessage {
		$this->payloadInfo = $payloads;
		return $this;
	}
	function addPayloadInfo(PayloadInfo $part): ElectronicBusinessMessage {
		$this->payloadInfo->append($part);
		return $this;
	}

	function xmlSerialize(Writer $writer){
		$writer->write([
			$this::EBNS . "UserMessage" => [
				$this::EBNS . "MessageInfo" => [
					$this::EBNS . "Timestamp" => $this->timestamp->format(\DateTimeInterface::RFC3339_EXTENDED),
					$this::EBNS  . "MessageId" => $this->id,
				],
				$this::EBNS . "PartyInfo" => [
					$this::EBNS . "From" => [
						[
							'name' => $this::EBNS . "PartyId",  
							'attributes' => [
								'type' => 'urn:fdc:peppol.eu:2017:identifiers:ap',
							],
							'value' => $this->partyIdFrom,
						],
						$this::EBNS . "Role" => $this->partyRoleFrom,
					],
					$this::EBNS . "To" => [
						[
							'name' => $this::EBNS . "PartyId",  
							'attributes' => [
								'type' => 'urn:fdc:peppol.eu:2017:identifiers:ap',
							],
							'value' => $this->partyIdTo,
						],
						$this::EBNS . "Role" => $this->partyRoleTo,
					],
				],
				$this::EBNS . "CollaboriationInfo" => [
					$this::EBNS . "AgreementRef" => $this->agreementRef,
					[
						'name' => $this::EBNS . "Service",
						'attributes' => [
							'type' => 'cenbii-procid-ubl',
						],
						'value' => $this->service,
					],
					$this::EBNS . "Action" => $this->action,
					$this::EBNS . "ConversationId" => $this->conversationId,
				],
				$this::EBNS . "MessageProperties" => [
					[
						'name' => $this::EBNS . "Property",
						'attributes' => [
							'name' => 'originalSender',
							'type' => 'iso6523-actorid-upis',
						],
						'value' => $this->originalSender
					],
					[
						'name' => $this::EBNS . "Property",
						'attributes' => [
							'name' => 'finalRecipient',
							'type' => 'iso6523-actorid-upis',
						],
						'value' => $this->finalRecipient,
					],
				],
				$this::EBNS . "PayloadInfo" => [
					$this->payloadInfo,
				],
			],
		]);
	}
}
