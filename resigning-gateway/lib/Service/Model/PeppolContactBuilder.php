<?php
namespace OCA\PeppolNext\Service\Model;


use OCA\PeppolNext\Service\ContactService;

class PeppolContactBuilder
{
	private $fullname;
	private $peppolId;

	public function setFullname(string $fullname) : PeppolContactBuilder{
		$this->fullname = $fullname;
		return $this;
	}


	public function setPeppolId(string $peppolId) : PeppolContactBuilder{
		$this->peppolId = $peppolId;
		return $this;
	}

	public function getSerialized(): array
	{
		return [
			"FN" => $this->fullname,
			ContactService::SOCIAL_PROFILE_KEY => Constants::PEPPOL_INDICATOR.$this->peppolId,
		];
	}

}
