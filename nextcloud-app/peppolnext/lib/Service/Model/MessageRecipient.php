<?php

namespace OCA\PeppolNext\Service\Model;


class MessageRecipient
{
	public function __construct(string $title, string $peppolId, bool $isLocal, string $uid=""){
		$this->title = $title;
		$this->peppolEndpoint = $peppolId;
		$this->isLocal = $isLocal;
		$this->uid = $uid;
	}

	public string $title;
	public string $peppolEndpoint;
	public bool $isLocal;
	public string $uid;

	public function getPeppolId() : string{
		$rawEndpoint = str_replace(Constants::PEPPOL_INDICATOR,"", $this->peppolEndpoint);
		return explode(":", $rawEndpoint)[1];
	}

	public function getPeppolScheme(): string{
		$rawEndpoint = str_replace(Constants::PEPPOL_INDICATOR,"", $this->peppolEndpoint);
		return explode(":", $rawEndpoint)[0];
	}
}
