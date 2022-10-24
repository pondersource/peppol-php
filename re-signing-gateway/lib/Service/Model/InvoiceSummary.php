<?php

namespace OCA\PeppolNext\Service\Model;

class InvoiceSummary
{
	public string $orderId;
	public string $note;
	public string $fileName;
	public string $creationTime;
	public string $sender;
	public string $receiver;
	public int $amount;
}
