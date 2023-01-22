<?php
namespace OCA\PeppolNext\Service\Model;

use OCA\PeppolNext\Service\ContactService;
use OCA\PeppolNext\Service\Helper\PostalAddress;

class PeppolContactBuilder
{

	private $fullname;
	private $peppolId;
	private $relatipnship;
	private $endpoint = '';
	private $certificate = '';
	private ?PostalAddress $address = null;

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

	public function setCertificate(string $certificate) : PeppolContactBuilder{
		$this->certificate = $certificate;
		return $this;
	}

	public function setAddress(PostalAddress $address): PeppolContactBuilder {
		$this->address = $address;
		return $this;
	}

	public function getSerialized(): array
	{
		return [
			"FN" => $this->fullname,
			"ADR" => [$this->address->asVCardAddress()],
			ContactService::SOCIAL_PROFILE_KEY => Constants::PEPPOL_INDICATOR.$this->peppolId,
			ContactService::AS4_RELATIONSHIP => $this->relatipnship,
			ContactService::AS4_DIRECT_ENDPOINT => $this->endpoint,
			ContactService::AS4_DIRECT_CERTIFICATE => $this->certificate
		];
	}

}
