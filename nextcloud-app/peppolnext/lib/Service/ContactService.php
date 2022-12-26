<?php

namespace OCA\PeppolNext\Service;

use GuzzleHttp\Client;
use OCA\PeppolNext\Service\Model\Constants;
use OCA\PeppolNext\Service\Model\PeppolContact;
use OCA\PeppolNext\Service\Model\PeppolContactBuilder;
use OCP\Contacts\IManager;

class ContactService {
	
	public const FLAG_CUSTOMER = 1;
	public const FLAG_SUPPLIER = 2;

	const SOCIAL_PROFILE_KEY = 'X-SOCIALPROFILE';
	const AS4_RELATIONSHIP = 'AS4-RELATIONSHIP';
	const AS4_DIRECT_ENDPOINT = 'AS4-DIRECT-ENDPOINT';
	const AS4_DIRECT_PUBLIC_KEY = 'AS4-DIRECT-PUBLICKEY';
	
	const PEPPOL_DIRECTORY_ADDRESS = 'https://directory.peppol.eu/search/1.0/json';

	private IManager $contactManager;
	
	public function __construct(IManager $contactManager) {
		$this->contactManager = $contactManager;
	}

	public function findContact(string $peppol_id, int $contact_relationship): ?PeppolContact {
		$items = $this->contactManager->search($pattern, [self::SOCIAL_PROFILE_KEY], ['limit'=>10, 'types'=>true]);
		
		foreach ($items as $contact){
			if (isset($contact[self::SOCIAL_PROFILE_KEY])) {
				if (is_array($contact[self::SOCIAL_PROFILE_KEY])) {
					$contact_id = $this->getPeppolConnection($contact[self::SOCIAL_PROFILE_KEY]);
					
					if ($contact_id !== "") {
						$contact_id = substr($contact_id, 8);

						if ($contact_id === $peppol_id) {
							$relationship = $contact[self::AS4_RELATIONSHIP];

							if ($contact_relationship & $relationship > 0) {
								return new PeppolContact($contact['FN'], $peppolId, $relationship, true, $contact["UID"], $contact[self::AS4_DIRECT_ENDPOINT], $contact[self::AS4_DIRECT_PUBLIC_KEY]);
							}
						}
					}
				}
			}
		}

		return null;
	}

	public function readLocalPeppolContact(string $pattern, int $contact_relationship) :array{
		$result = array();
		$items = $this->contactManager->search($pattern, ['FN'], ['limit'=>10, 'types'=>true]);
		foreach ($items as $contact){
			if (isset($contact[self::SOCIAL_PROFILE_KEY])){

				if (is_array($contact[self::SOCIAL_PROFILE_KEY])){
					$peppolId = $this->getPeppolConnection($contact[self::SOCIAL_PROFILE_KEY]);
					if($peppolId !== "") {
						$peppolId = substr($peppolId, 8);
						$relationship = $contact[self::AS4_RELATIONSHIP];

						if ($contact_relationship & $relationship > 0) {
							$result[] = new PeppolContact($contact['FN'], $peppolId, $relationship, true, $contact["UID"], $contact[self::AS4_DIRECT_ENDPOINT], $contact[self::AS4_DIRECT_PUBLIC_KEY]);
						}
					}
				}
			}
		}
		return $result;
	}

	public function addContact(PeppolContactBuilder $contact) : void{
		$addressBook = $this->contactManager->getUserAddressBooks()[1];
		$addressBook->createOrUpdate($contact->getSerialized());
	}

	public function readPeppolDirectory(string $pattern, int $contact_relationship) : array{
		$result = array();
		if (strlen($pattern) < 3)
			return $result;
		$httpClient = new Client(
			[
				'base_url' => self::PEPPOL_DIRECTORY_ADDRESS,
				'timeout' => 2.0
			]
		);
		$response = $httpClient->request("GET", self::PEPPOL_DIRECTORY_ADDRESS,
			[
				"query" => [
					"name"=> $pattern
			]]
		);
		if ($response->getStatusCode() === 200 ){
			$peppolItems = \Safe\json_decode($response->getBody()->getContents(), true)["matches"];
			$result =array_map(function ($item) use ($contact_relationship) {
				return new PeppolContact(
					$item["entities"][0]["name"][0]["name"],
					$item["participantID"]["value"],
					$contact_relationship,
					false
				);
				//"scheme" => $item["participantID"]["scheme"],

			}, $peppolItems);
		}
		return $result;
	}


	private function getPeppolConnection(array $socialContainer) : string{
		$values = array_column($socialContainer, "value");
		$peppolProile = array_filter($values, function ($v){
			if (str_starts_with($v,Constants::PEPPOL_INDICATOR))
				return true;
			return false;
		});
		if (count($peppolProile) > 0)
			return $peppolProile [0];
		return "";

	}
}
