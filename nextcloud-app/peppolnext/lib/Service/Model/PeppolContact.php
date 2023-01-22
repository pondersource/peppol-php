<?php

namespace OCA\PeppolNext\Service\Model;

use OCA\PeppolNext\Service\Helper\PostalAddress;

class PeppolContact {

	public string $title = '';
	public string $peppolEndpoint = '';
	public int $relationship = 1;
	public bool $isLocal = true;
	public string $uid = '';
	public string $endpoint = '';
	public string $certificate = '';

	public array $address;

	public function __construct(string $title=''
			, string $peppolId=''
			, int $relationship=1
			, bool $isLocal=true
			, string $uid=""
			, string $endpoint=""
			, string $certificate=""
			, array $address=[]) {
		$this->title = $title;
		$this->peppolEndpoint = $peppolId;
		$this->relationship = $relationship;
		$this->isLocal = $isLocal;
		$this->uid = $uid;
		$this->endpoint = $endpoint;
		$this->certificate = $certificate;

		// if ($address == null) {
		// 	$address = new PostalAddress();
		// }

		$this->address = $address;//->asPeppolAddress();
	}

	public function getPeppolId() : string {
		$rawEndpoint = str_replace(Constants::PEPPOL_INDICATOR,"", $this->peppolEndpoint);
		return explode(":", $rawEndpoint)[1];
	}

	public function getPeppolScheme(): string {
		$rawEndpoint = str_replace(Constants::PEPPOL_INDICATOR,"", $this->peppolEndpoint);
		return explode(":", $rawEndpoint)[0];
	}

}
