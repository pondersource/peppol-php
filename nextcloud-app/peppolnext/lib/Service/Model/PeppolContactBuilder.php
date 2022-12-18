<?php
namespace OCA\PeppolNext\Service\Model;


use OCA\PeppolNext\Service\ContactService;

class PeppolContactBuilder
{
	private $fullname;
	private $peppolId;
	private $relatipnship;
	private $endpoint = '';
	private $public_key = '';

	public function setFullname(string $fullname) : PeppolContactBuilder{
		$this->fullname = $fullname;
		return $this;
	}


	public function setPeppolId(string $peppolId) : PeppolContactBuilder{
		$this->peppolId = $peppolId;
		return $this;
	}

	public function setRelationship(int $relatipnship) {
		$this->relatipnship = $relatipnship;
		return $this;
	}

	public function setEndpoint(string $endpoint) : PeppolContactBuilder{
		$this->endpoint = $endpoint;
		return $this;
	}

	public function setPublicKey(string $public_key) : PeppolContactBuilder{
		$this->public_key = $public_key;
		return $this;
	}

	public function getSerialized(): array
	{
		return [
			"FN" => $this->fullname,
			ContactService::SOCIAL_PROFILE_KEY => Constants::PEPPOL_INDICATOR.$this->peppolId,
			ContactService::AS4_RELATIONSHIP => $this->relatipnship,
			ContactService::AS4_DIRECT_ENDPOINT => $this->endpoint,
			ContactService::AS4_DIRECT_PUBLIC_KEY => $this->public_key
		];
	}

}
