<?php

namespace OCA\PeppolNext\Service\Model;

class PeppolContact {

	public function __construct(string $title, string $peppolId, int $relationship, bool $isLocal, string $uid="", string $endpoint="", string $certificate=""){
		$this->title = $title;
		$this->peppolEndpoint = $peppolId;
		$this->relationship = $relationship;
		$this->isLocal = $isLocal;
		$this->uid = $uid;
		$this->endpoint = $endpoint;
		$this->certificate = $certificate;
	}

	public string $title;
	public string $peppolEndpoint;
	public int $relationship;
	public bool $isLocal;
	public string $uid;
	public string $endpoint;
	public string $certificate;

	public function getPeppolId() : string {
		$rawEndpoint = str_replace(Constants::PEPPOL_INDICATOR,"", $this->peppolEndpoint);
		return explode(":", $rawEndpoint)[1];
	}

	public function getPeppolScheme(): string {
		$rawEndpoint = str_replace(Constants::PEPPOL_INDICATOR,"", $this->peppolEndpoint);
		return explode(":", $rawEndpoint)[0];
	}

}
