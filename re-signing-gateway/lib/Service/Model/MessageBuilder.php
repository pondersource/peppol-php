<?php

namespace OCA\PeppolNext\Service\Model;

use Safe\DateTime;

class MessageBuilder
{
	const  PEPPOL_MEDIA = "Peppol";
	const  AS4_MEDIA = "AS4Direct";

	private string $subject ;
	private MessageRecipient $receiver;
	private string $body;
	private int $mediaType;
	private array $invoiceLines ;
	private float $totalAmount;
	private DateTime $dueDate;
	private string $orderReference;

	private array $errors =[];
	public function __construct( array $data)
	{
		$this->body = $data['body'];

		if (empty($data["orderReference"])) {
			$this->errors[] = "set a order reference";
		} else {
			$this->orderReference = $data["orderReference"];
		}
		if (empty($data["dueDate"])) {
			$this->errors[] = "set a due date";
		} else {
			try {
				$this->dueDate = DateTime::createFromFormat('Y-m-d', $data['dueDate']);
			} catch (\Throwable $th) {
				$ex = $th->getMessage();
			}
		}
		if (empty($data['recipient'])) {
			$this->errors[] = "select a recipient";
		} else {
			$this->receiver = new MessageRecipient($data['recipient']['title']
				, $data['recipient']['peppolEndpoint']
				, $data['recipient']['isLocal']
				, $data['recipient']['uid']);
		}

		if (empty($data['subject'])) {
			$this->errors[] = "subject is required";
		} else {
			$this->subject = $data['subject'];
		}

		if (empty($data['mediaType'])) {
			$this->errors[] = "please select one media type";
		} else {
			switch ($data['mediaType']) {
				case self::AS4_MEDIA:
					$this->mediaType = Constants::AS4DIRECT_MEDIA_TYPE;
					break;
				case self::PEPPOL_MEDIA:
					$this->mediaType = Constants::PEPPOL_MEDIA_TYPE;
					break;
				default:
					$this->mediaType = Constants::PEPPOLNEXT_MEDIA_TYPE;
			}
		}

		if (empty($data['invoiceLines']) || count($data['invoiceLines']['items']) == 0) {
			$this->errors[] = "please add at least one order line";
		} else {
			foreach ($data['invoiceLines']['items'] as $item) {
				$this->invoiceLines[] = $item;
			}
			$this->totalAmount = $data['invoiceLines']['total'];
		}
	}

	/**
	 * @return string
	 */
	public function getSubject(): string
	{
		return $this->subject;
	}

	/**
	 * @return MessageRecipient
	 */
	public function getReceiver(): MessageRecipient
	{
		return $this->receiver;
	}

	/**
	 * @return string
	 */
	public function getBody(): string
	{
		return $this->body;
	}

	/**
	 * @return int
	 */
	public function getMediaType(): int
	{
		return $this->mediaType;
	}

	/**
	 * @return array
	 */
	public function getInvoiceLines(): array
	{
		return $this->invoiceLines;
	}

	/**
	 * @return float
	 */
	public function getTotalAmount(): float
	{
		return $this->totalAmount;
	}

	/**
	 * @return array
	 */
	public function getErrors(): array
	{
		return $this->errors;
	}

	/**
	 * @return bool
	 */
	public function hasError(): bool
	{
		return count($this->errors) > 0;
	}

	/**
	 * @return DateTime
	 */
	public function getDueDate(): DateTime
	{
		return $this->dueDate;
	}

	/**
	 * @return mixed|string
	 */
	public function getOrderReference()
	{
		return $this->orderReference;
	}

}
