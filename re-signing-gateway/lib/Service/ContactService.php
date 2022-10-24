<?php

namespace OCA\PeppolNext\Service;

use GuzzleHttp\Client;
use OCA\PeppolNext\Service\Model\Constants;
use OCA\PeppolNext\Service\Model\MessageRecipient;
use OCA\PeppolNext\Service\Model\PeppolContactBuilder;
use OCP\Contacts\IManager;

class ContactService
{
	const SOCIAL_PROFILE_KEY = 'X-SOCIALPROFILE';
	const PEPPOL_DIRECTORY_ADDRESS = 'https://directory.peppol.eu/search/1.0/json';

	private IManager $contactManager;
	public function __construct(IManager $contactManager){
		$this->contactManager = $contactManager;
	}

	public function readLocalPeppolContact(string $pattern) :array{

		$result = array();
		$items = $this->contactManager->search($pattern, ['FN', 'EMAIL'], ['limit'=>10, 'types'=>true]);
		foreach ($items as $contact){
			if (isset($contact[self::SOCIAL_PROFILE_KEY])){

				if (is_array($contact[self::SOCIAL_PROFILE_KEY])){
					$peppolId = $this->getPeppolConnection($contact[self::SOCIAL_PROFILE_KEY]);
					if($peppolId !== "") {
						$result[] = new MessageRecipient($contact['FN'], $peppolId,true, $contact["UID"]);
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

	public function readPeppolDirectory(string $pattern) : array{
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
			$result =array_map(function ($item){
				return new MessageRecipient(
					$item["entities"][0]["name"][0]["name"],
					$item["participantID"]["value"],
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
