<?php

namespace OCA\PeppolNext\Service;

use GuzzleHttp\Client;
use OCA\PeppolNext\Service\Helper\VCardInterpreter;
use OCA\PeppolNext\Service\Model\Constants;
use OCA\PeppolNext\Service\Model\PeppolContact;
use OCA\PeppolNext\Service\Model\PeppolContactBuilder;
use OCP\Contacts\IManager;
use Psr\Log\LoggerInterface;

class ContactService {
	
	public const FLAG_CUSTOMER = 1;
	public const FLAG_SUPPLIER = 2;

	const SOCIAL_PROFILE_KEY = 'X-SOCIALPROFILE';
	const AS4_RELATIONSHIP = 'AS4-RELATIONSHIP';
	const AS4_DIRECT_ENDPOINT = 'AS4-DIRECT-ENDPOINT';
	const AS4_DIRECT_CERTIFICATE = 'AS4-DIRECT-CERTIFICATE';
	
	const PEPPOL_DIRECTORY_ADDRESS = 'https://directory.peppol.eu/search/1.0/json';

	private IManager $contactManager;

	private LoggerInterface $logger;
	
	public function __construct(IManager $contactManager, LoggerInterface $logger) {
		$this->contactManager = $contactManager;
		$this->logger = $logger;
	}

	public function findContact(string $peppol_id, int $contact_relationship): ?PeppolContact {
		$items = $this->contactManager->search('', ['FN'], ['limit'=>10, 'types'=>true]);
		$this->logger->error('Search found '.count($items).' contacts.');
		
		foreach ($items as $contact) {
			if (isset($contact[self::SOCIAL_PROFILE_KEY])) {
				if (is_array($contact[self::SOCIAL_PROFILE_KEY])) {
					$contact_id = $this->getPeppolConnection($contact[self::SOCIAL_PROFILE_KEY]);
					
					if ($contact_id !== "") {
						$contact_id = substr($contact_id, 8);

						$this->logger->error("Comparing $contact_id with $peppol_id.");
						
						if ($contact_id === $peppol_id) {
							$relationship = $contact[self::AS4_RELATIONSHIP];

							$this->logger->error("Comparing relationships $relationship with $contact_relationship.");

							if (($contact_relationship & $relationship) > 0) {
								$interpreter = new VCardInterpreter($this->contactManager, $contact['UID']);

								// try {
									// $address = $interpreter->getAddress()->asPeppolAddress();
								// } catch (\Throwable $e) {
									$address = [];
								// }

								return new PeppolContact($contact['FN'], $peppol_id, $relationship, true, $contact["UID"], $contact[self::AS4_DIRECT_ENDPOINT], $contact[self::AS4_DIRECT_CERTIFICATE], $address);
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

					if ($peppolId !== "") {
						$peppolId = substr($peppolId, 8);
						$relationship = $contact[self::AS4_RELATIONSHIP];

						if (($contact_relationship & $relationship) > 0) {
							$interpreter = new VCardInterpreter($this->contactManager, $contact['UID']);

							// try {
								// $address = $interpreter->getAddress()->asPeppolAddress();
							// } catch (\Throwable $e) {
								$address = [];
							// }

							$result[] = new PeppolContact($contact['FN'], $peppolId, $relationship, true, $contact["UID"], $contact[self::AS4_DIRECT_ENDPOINT], $contact[self::AS4_DIRECT_CERTIFICATE], $address);
						}
					}
				}
			}
		}
		return $result;
	}

	public function addContact(PeppolContactBuilder $contact) : void{
		$addressBook = $this->contactManager->getUserAddressBooks()[1];
		$result = $addressBook->createOrUpdate($contact->getSerialized());
		//throw new \Exception(json_encode($result));
		//throw new \Exception(json_encode($contact->getSerialized()));
	}

	public function removeContact(string $uid, int $relationship) {
		$result = $this->contactManager->search($uid, ["UID"], ['limit'=>1]);

		if (empty($result)) {
			throw new \Exception('not found');
			return;
		}

		$contact = $result[0];
		
		if (!isset($contact[self::AS4_RELATIONSHIP]) || $contact[self::AS4_RELATIONSHIP] & $relationship === 0) {
			throw new \Exception('not related');
			return;
		}

		$contactId = $contact['UID'];
		$addressBookId = $contact['addressbook-key'];

		$addressBooks = $this->contactManager->getUserAddressBooks();
		$addressBook = $addressBooks[$addressBookId];
		
		//$result = $addressBook->search($uid, ["UID"], ['limit'=>1]);
		//throw new \Exception(json_encode($result, true));

		if ($contact[self::AS4_RELATIONSHIP] == $relationship) {
			// Remove the contact
			//$result = $this->contactManager->delete($conactId, $addressBookId - 1);
			$result = $addressBook->delete($conactId);
			throw new \Exception('removed >' . $contactId . '< >' . $addressBookId . '< ' . ($result ? 'yes' : 'no'));
		}
		else {
			// Update the contact
			$contact[self::AS4_RELATIONSHIP] = $contact[self::AS4_RELATIONSHIP] & ~$relationship;
			$this->contactManager->createOrUpdate($contact, $addressBookId);
			throw new \Exception('updated');
		}
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
