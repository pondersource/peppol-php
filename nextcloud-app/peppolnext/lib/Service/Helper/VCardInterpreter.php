<?php

namespace OCA\PeppolNext\Service\Helper;

use OCP\Contacts\IManager;

class VCardInterpreter
{
	private array $card ;

	public function __construct(IManager $manager, string $uid){
		$result = $manager->search($uid, ["UID"], ['limit'=>1, 'types'=>true]);
		if (empty($result))
			$this->card = [];
		else
			$this->card = $result[0];
	}

	/**
	 * @param string $type
	 * @return array
	 */
	public function getAddress(string $type = ''): PostalAddress {
		$address = [];
		if (!isset($this->card['ADR']))
			return new PostalAddress();
		if ($type === ''){
			$address = $this->card['ADR'][0];
		}
		else{
			$address = array_filter($this->card['ADR'], function ($item) use($type){
				return strtoupper($item['type']) === strtoupper($type);
			});
			$address = reset($address);
		}
		if ($address === [] || !$address) return new PostalAddress();

		$rawAddress = str_replace("\;","!_!", $address["value"]);
		$parts = explode(";", $rawAddress);

		$postalAddress = new PostalAddress();
		$postalAddress->postOfficeAddress = str_replace("!_!","\;",$parts[0]??"");
		$postalAddress->extendedAddress = str_replace("!_!","\;",$parts[1]??"");
		$postalAddress ->street = str_replace("!_!","\;",$parts[2]??"");
		$postalAddress->locality = str_replace("!_!","\;",$parts[3]??"");
		$postalAddress->region = str_replace("!_!","\;",$parts[4]??"");
		$postalAddress->postalCode = str_replace("!_!","\;",$parts[5]??"");
		$postalAddress->country = str_replace("!_!","\;",$parts[6]??"");

		return $postalAddress;
	}

	/**
	 * @param string $type
	 * @return string
	 */
	public function getEmail(string $type=''):string{
		if (!isset($this->card['EMAIL']))
			return '';
		if ($type === ''){
			return $this->card['EMAIL'][0]["value"];
		}
		else{
			$item = array_filter($this->card['EMAIL'], function ($item) use($type){
				return strtoupper($item['type']) === strtoupper($type);
			});
		}
		if($item === []) return '';
		return reset($item)['value'];
	}

	/**
	 * @param string $type
	 * @return string
	 */
	public function getPhone(string $type=''):string{
		if (!isset($this->card['TEL']))
			return '';
		if ($type === ''){
			return $this->card['TEL'][0]["value"];
		}
		else{
			$item = array_filter($this->card['TEL'], function ($item) use($type){
				return str_contains(strtoupper($item['type']), strtoupper($type));
			});
		}
		if($item === []) return '';
		return reset($item)['value'];
	}
}
